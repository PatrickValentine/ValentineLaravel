<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HospitalBoxSizeMatrix;
use App\Models\Hospital;
use App\Models\HospitalOutgoingFedexFieldMapping;
use App\Models\HospitalSendgridFieldMapping;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HospitalController extends Controller
{
    // Hospitals methods
    public function hospitalList()
    {
        $hospitals = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_weight', 
                'hb.full_weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            ->orderBy('reference')
            ->get();

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function createHospital()
    {
        return view('admin.hospitals.create');
    }

    public function storeHospital(Request $request)
    {
        $validated = $request->validate([
            'organization_name'     => 'required|string|max:255',
            'organization_type'     => 'required|string|max:255',
            'contact_person_name'   => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:hospitals,email',
            'valentine_card_count'  => 'required|integer|min:0',
            'street'                => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'state'                 => 'required|string|max:20',
            'zip'                   => 'required|string|max:20',
            'phone'                 => 'required|string|max:255',
            'standing_order'        => 'boolean',
            // 'prefilled_link' => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $hospital = Hospital::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $allData
        );

        do {
            $token = Str::random(8);
        } while (Hospital::where('token', $token)->exists());

        $hospital->token = $token;
        $hospital->prefilled_link = url('/hospital/' . $token . '/edit');
        $hospital->save();

        return redirect()->route('admin.hospitals')->with('success', 'Hospital created successfully.');
    }

    public function editHospital(Hospital $hospital)
    {
        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function updateHospital(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'valentine_card_count' => 'required|integer|min:0',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:255',
            'standing_order' => 'boolean',
            'updated_at' => 'nullable|date',
        ]);

        // Always use validated data instead of $request->all()
        if (!isset($validated['updated_at']) || empty($validated['updated_at'])) {
            unset($validated['updated_at']);
        }
        else{
            $validated['updated_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['updated_at']);
        }

        if($hospital->email != $request->email){
            $request->validate(['email' => 'required|email|max:255|unique:hospitals,email']);
        }

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        // Update Hospital
        $hospital->fill($allData);

        // Add prefilled link
        // $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');        
        $hospital->save();

        return redirect()->route('admin.hospitals')->with('success', 'Hospital updated successfully.');
    }

    public function deleteHospital(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->route('admin.hospitals')->with('success', 'Hospital deleted successfully.');
    }

    public function importHospitals(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');

        // Skip header row
        $header = fgetcsv($file);

        $imported = 0;

        while (($row = fgetcsv($file)) !== false) {
            // Adjust indices to match your CSV format
            $hospitalData = [
                'organization_name'     => $row[0] ?? null,
                'valentine_card_count'  => !empty($row[1]) ? intval($row[1]) : 0,
                'extra_staff_cards'     => !empty($row[2]) ? intval($row[2]) : 0,
                'street'                => $row[3] ?? null,
                'city'                  => $row[4] ?? null,
                'state'                 => strtoupper($row[5] ?? ''),
                'zip'                   => $row[6] ?? null,
                'phone'                 => $row[7] ?? null,
                'contact_person_name'   => $row[8] ?? null,
                'how_to_address'        => $row[9] ?? null,
                'email'                 => $row[10] ?? null,                
                'public_notes'          => $row[11] ?? null,
                'organization_type'     => $row[12] ?? null,
                'contact_title'         => $row[13] ?? null,
            ];

            if (!empty($hospitalData['email'])) {
                $hospital = Hospital::updateOrCreate(
                    ['organization_name' => $hospitalData['organization_name'], 'email' => $hospitalData['email']],
                    $hospitalData
                );

                do {
                    $token = Str::random(8);
                } while (Hospital::where('token', $token)->exists());

                $hospital->token = $token;
                $hospital->prefilled_link = url('/hospital/' . $token . '/edit');
                $hospital->save();
                $imported++;
            }
        }

        fclose($file);

        return redirect()->route('admin.schools')
            ->with('success', "Imported {$imported} schools successfully.");
    }

    // public function importHospitals(Request $request)
    // {
    //     try {
    //         $spreadsheetId = env('GOOGLE_SHEETS_HOSPITAL_ID', '1NJuNcffKR2KeJLkFSsCyICdUhKXCwNV8');
            
    //         // Try to access the sheet as a public CSV export
    //         $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid=616306137";
            
    //         $response = Http::get($csvUrl);
            
    //         if (!$response->successful()) {
    //             throw new \Exception('Failed to access Google Sheet. Make sure it is shared publicly or with the service account.');
    //         }
            
    //         $csvData = $response->body();
    //         $rows = array_map('str_getcsv', explode("\n", $csvData));
            
    //         // Remove empty rows
    //         $rows = array_filter($rows, function($row) {
    //             return !empty(array_filter($row));
    //         });

    //         if (empty($rows) || count($rows) < 3) {
    //             return redirect()->route('admin.hospitals')->with('error', 'No data found in the Google Sheet. Need at least 3 rows (first row + header row + data row).');
    //         }

    //         // Skip first row and use second row as header
    //         // array_shift($rows); // Remove first row
    //         $header = array_map('trim', array_shift($rows)); // Use second row as header

    //         for ($i = 0; $i < 2; $i++) {
    //             array_shift($rows);
    //         }
            
    //         // Now $rows contains only data rows (starting from third row)
    //         $imported = 0;

    //         foreach ($rows as $row) {
    //             // Pad the row to match header length
    //             $paddedRow = array_pad($row, count($header), '');
    //             $data = array_combine($header, $paddedRow);
    //             $hospitalData = [
    //                 'valentine_opt_in' => $data["May I send you some Valentine's Day cards?"] ?? '',
    //                 'organization_name' => $data["Name of Organization"] ?? '',
    //                 'organization_type' => $data["Type of Organization"] ?? '',
    //                 'contact_person_name' => $data["Contact Person's Name"] ?? '',
    //                 'email' => $data["Email Address"] ?? '',
    //                 'how_to_address' => $data['How to address you (like "Ms. Anderson")'] ?? '',
    //                 'valentine_card_count' => intval($data["Number of Valentine's Day Cards Desired for your patients/clients?"] ?? 0),
    //                 'extra_staff_cards' => intval($data["If we have enough cards, how many extra cards would you like for your wonderful staff?"] ?? 0),
    //                 'street' => $data["Street address for delivery to you (no city, state, zip here)"] ?? '',
    //                 'city' => $data["City"] ?? '',
    //                 'state' => strtoupper($data["State/District:"]) ?? '',
    //                 'zip' => $data["Zip Code:"] ?? '',
    //                 'phone' => $data["Phone (Fedex requires in case they have an issue - enter 10 digits only - no dashes, no hyphens, spaces, or parentheses):"] ?? '',
    //                 'standing_order' => ($data["Do you want to make this a standing order (we send you the same amount each year) so you don't need to worry about remembering? (Easier for us and for you!)"] == "Yes" ? 1 : 0),
    //                 'public_notes' => $data["Any other questions or comments?"] ?? null,
    //                 // 'internal_notes' => $data["How did you hear about Valentine's By Kids?"] ?? null,
    //                 'prefilled_link' => $data["Prefilled Link"] ?? null,
    //                 'update_status' => 0,
    //             ];

    //             if (!empty($hospitalData['email'])) {
    //                 $hospital = \App\Models\Hospital::updateOrCreate(
    //                     [
    //                         'organization_name' => $hospitalData['organization_name'],
    //                         'email' => $hospitalData['email']
    //                     ],
    //                     $hospitalData
    //                 );

    //                 $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');
    //                 $hospital->save();
                
    //                 $imported++;
    //             }
    //         }

    //         return redirect()->route('admin.hospitals')->with('success', "Imported $imported hospitals from Google Sheets.");

    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.hospitals')->with('error', 'Error importing data: ' . $e->getMessage());
    //     }
    // }

    public function exportSendgridCsv(Request $request)
    {
        $query = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_weight', 
                'hb.full_weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            // ->where('hospitals.update_status', 1)
            ->orderBy('reference');

        if ($request->scope === 'since' && $request->has('since')) {
            $sinceDate = Carbon::parse($request->since)->startOfDay();
            $query->where('hospitals.updated_at', '>=', $sinceDate);
        }

        $hospitals = $query->get();

        $fileName = 'Hospital Sendgrid Upload Format.csv';

        $mappings = HospitalSendgridFieldMapping::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('sendgrid_field')->toArray();

        $callback = function() use ($hospitals, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($hospitals as $hospital) {
                $row = [];
        
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        if ($map->our_field == "standing_order") {
                            $row[] = $hospital->{$map->our_field} ? "Yes" : "No";
                        } elseif ($map->our_field == "updated_at") {
                            $row[] = $hospital->{$map->our_field} ? $hospital->{$map->our_field}->format('Ymd') : "";
                        } else {
                            $value = $hospital->{$map->our_field} ?? '';
                            // Force Excel to treat as text
                            if (preg_match('/^0\d+$/', $value)) {
                                $row[] = "\t" . $value;  // Excel sees it as text
                            } else {
                                $row[] = $value;
                            }
                        }
                    } elseif (!empty($map->common_value)) {
                        $row[] = $map->common_value;
                    } else {
                        $row[] = '';
                    }
                }
        
                fputcsv($file, $row);
            }
        
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportFedexCsv(Request $request)
    {
        $fileName = 'Fedex Formatted hospitals Import '. now()->format('m-d-Y') .'.csv';
        $query = Hospital::select('hospitals.*', 
                DB::raw('(hospitals.valentine_card_count + hospitals.extra_staff_cards) as totalHospRequested'), 
                DB::raw('CONCAT("H", hospitals.state, LPAD(hospitals.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(hospitals.valentine_card_count, "/", hospitals.extra_staff_cards, "/", (hospitals.valentine_card_count + hospitals.extra_staff_cards), "/", hb.box_style) as invoiceNumber'), 
                'hb.id as matrix_id', 
                'hb.box_style', 
                'hb.length', 
                'hb.width', 
                'hb.height', 
                'hb.empty_weight', 
                'hb.full_weight')
            ->leftJoin('hospital_box_size_matrices as hb', function ($join) {
                $join->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '>', DB::raw('hb.greater_than'))
                    ->on(DB::raw('hospitals.valentine_card_count + hospitals.extra_staff_cards'), '<=', DB::raw('hb.qty_of_env'));
            })
            // ->where('hospitals.update_status', 1)
            ->orderBy('reference');

        if ($request->scope === 'since' && $request->has('since')) {
            $sinceDate = Carbon::parse($request->since)->startOfDay();
            $query->where('hospitals.updated_at', '>=', $sinceDate);
        }

        $hospitals = $query->get();

        $mappings = HospitalOutgoingFedexFieldMapping::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('fedex_field')->toArray();

        $callback = function() use ($hospitals, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($hospitals as $hospital) {
                $row = [];
        
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        if ($map->our_field == "updated_at") {
                            $row[] = $hospital->{$map->our_field} ? $hospital->{$map->our_field}->format('Ymd') : "";
                        } else {
                            // Pull value from the hospitals table dynamically
                            $value = $hospital->{$map->our_field} ?? '';
                            // Force Excel to treat as text
                            if (preg_match('/^0\d+$/', $value)) {
                                $row[] = "\t" . $value;  // Excel sees it as text
                            } else {
                                $row[] = $value;
                            }
                        }
                    } elseif (!empty($map->common_value)) {
                        $row[] = $map->common_value;
                    } else {
                        $row[] = '';
                    }
                }
        
                fputcsv($file, $row);
            }
        
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}