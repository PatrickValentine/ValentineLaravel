<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\SchoolBoxSizeMatrix;
use App\Models\School;
use App\Models\SchoolOutgoingFedexFieldMapping;
use App\Models\SchoolReturnFedexFieldMapping;
use App\Models\SchoolSendgridFieldMapping;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SchoolController extends Controller
{
    // Schools methods
    public function schoolList()
    {
        $schools = School::select('schools.*', 
                DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'), 
                'sb.id as matrix_id', 
                'sb.box_style', 
                'sb.length', 
                'sb.width', 
                'sb.height', 
                'sb.empty_weight', 
                'sb.full_weight')
            ->leftJoin('school_box_size_matrices as sb', function ($join) {
                $join->on('schools.envelope_quantity', '>', 'sb.greater_than')
                     ->on('schools.envelope_quantity', '<=', 'sb.qty_of_env');
            })
            ->orderBy('reference')
            ->get();

        return view('admin.schools.index', compact('schools'));
    }

    public function createSchool()
    {
        $volunteers = Volunteer::all();
        return view('admin.schools.create', compact('volunteers'));
    }

    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'organization_name'     => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name'   => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'                 => 'required|email|max:255|unique:schools,email',
            'envelope_quantity'     => 'required|integer|min:0',
            'street'                => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                  => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'                 => ['required', 'size:2', 'alpha'],
            'zip'                   => 'required|string|max:20',
            'phone'                 => ['required', 'digits:10'],
            'standing_order'        => 'boolean',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $school = School::updateOrCreate(
            ['organization_name' => $validated['organization_name'], 'email' => $validated['email']],
            $allData
        );

        do {
            $token = Str::random(8);
        } while (School::where('token', $token)->exists());

        $school->token = $token;
        $school->prefilled_link = url('/school/' . $token . '/edit');
        $school->save();
        
        return redirect()->route('admin.schools')->with('success', 'School created successfully.');
    }

    public function editSchool(School $school)
    {
        $volunteers = Volunteer::all();
        return view('admin.schools.edit', compact('school', 'volunteers'));
    }

    public function updateSchool(Request $request, School $school)
    {
        $validated = $request->validate([
            'organization_name'    => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name'  => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'                => 'required|email|max:255',
            'envelope_quantity'    => 'required|integer|min:0',
            'street'               => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                 => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'                => ['required', 'size:2', 'alpha'],
            'zip'                  => 'required|string|max:20',
            'phone'                => ['required', 'digits:10'],
            'standing_order'       => 'boolean',
            'updated_at'           => 'nullable|date',
        ]);

        // Always use validated data instead of $request->all()
        if (!isset($validated['updated_at']) || empty($validated['updated_at'])) {
            unset($validated['updated_at']);
        }
        else{
            $validated['updated_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $validated['updated_at']);
        }

        if($school->email != $request->email){
            $request->validate(['email' => 'required|email|max:255|unique:schools,email']);
        }

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        // Update school
        $school->fill($allData);

        // Add prefilled link
        // $school->prefilled_link = url('/school/' . $school->id . '/edit');
        $school->save();

        return redirect()->route('admin.schools')->with('success', 'School updated successfully.');
    }

    public function deleteSchool(School $school)
    {
        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'School deleted successfully.');
    }

    public function importSchools(Request $request)
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
            $schoolData = [
                'organization_name'   => $row[0] ?? null,
                'street'              => $row[1] ?? null,
                'city'                => $row[2] ?? null,
                'state'               => strtoupper($row[3] ?? ''),
                'zip'                 => $row[4] ?? null,
                'phone'               => $row[5] ?? null,
                'contact_person_name' => $row[6] ?? null,
                'how_to_address'      => $row[7] ?? null,
                'email'               => $row[8] ?? null,
                'envelope_quantity'   => !empty($row[9]) ? intval($row[9]) : 0,
                'instructions_cards'  => !empty($row[10]) ? intval($row[10]) : 0,
                'public_notes'        => $row[11] ?? null,
                'contact_title'       => $row[12] ?? null,
            ];

            if (!empty($schoolData['email'])) {
                $school = School::updateOrCreate(
                    ['organization_name' => $schoolData['organization_name'], 'email' => $schoolData['email']],
                    $schoolData
                );

                do {
                    $token = Str::random(8);
                } while (School::where('token', $token)->exists());

                $school->token = $token;
                $school->prefilled_link = url('/school/' . $token . '/edit');
                $school->save();
                $imported++;
            }
        }

        fclose($file);

        return redirect()->route('admin.schools')
            ->with('success', "Imported {$imported} schools successfully.");
    }

    // public function importSchools(Request $request)
    // {
    //     try {
    //         $spreadsheetId = env('GOOGLE_SHEETS_SCHOOL_ID', '1u0DFmacIwOlkbuhD1Um809-Mzif2JQpepnJ5WDn66W4');
            
    //         // Try to access the sheet as a public CSV export
    //         $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid=1903950335";
            
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
    //             return redirect()->route('admin.schools')->with('error', 'No data found in the Google Sheet. Need at least 3 rows (first row + header row + data row).');
    //         }

    //         // Skip first row and use second row as header
    //         array_shift($rows); // Remove first row
    //         $header = array_map('trim', array_shift($rows)); // Use second row as header
            
    //         // Now $rows contains only data rows (starting from third row)
    //         $imported = 0;

    //         foreach ($rows as $row) {
    //             // Pad the row to match header length
    //             $paddedRow = array_pad($row, count($header), '');
    //             $data = array_combine($header, $paddedRow);

    //             $schoolData = [
    //                 'participation' => $data["Will you participate to create wonderful Valentine's Day cards?"] ?? '',
    //                 'organization_name' => $data["Name of School or Organization"] ?? '',
    //                 'contact_person_name' => $data["Contact Person's Name"] ?? '',
    //                 'email' => $data["Email Address"] ?? '',
    //                 'how_to_address' => $data['How to address you (like "Ms. Jones")'] ?? '',
    //                 'envelope_quantity' => intval($data["Quantity of empty Valentine's envelopes we should send to you.  (Please estimate realistically - We promise hospitals quantities based upon the number of envelopes you request and, if you return fewer, we can't fulfill the promise - Thank you!)"] ?? 0),
    //                 'instructions_cards' => intval($data["Each teacher will receive an instructions card.  How many instructions cards shall we include?"] ?? 0),
    //                 'street' => $data["Street Address for delivery of envelopes to you: (without city/state -- just the street address)"] ?? '',
    //                 'city' => $data['City'] ?? '',
    //                 'state' => strtoupper($data['State/District']) ?? '',
    //                 'zip' => $data['Zip Code'] ?? '',
    //                 'phone' => $data["Phone (Fedex requires in case they have an issue - enter digits only, no spaces, dashes, or parentheses):"] ?? '',
    //                 'standing_order' => ($data["Do you want to make this a standing order (we just send you the same amount in future years), so you don't have to remember (makes it easier for you and for us)?"] == "Yes" ? 1 : 0),
    //                 'public_notes' => $data["Any other questions or thoughts to share?"] ?? null,
    //                 // 'internal_notes' => $data["How did you find out about Valentines By Kids?"] ?? null,
    //                 'prefilled_link' => $data["Prefilled Link"] ?? null,
    //                 'update_status' => 0,
    //             ];

    //             if (!empty($schoolData['email'])) {
    //                 $school = \App\Models\School::updateOrCreate(
    //                     [
    //                         'organization_name' => $schoolData['organization_name'],
    //                         'email' => $schoolData['email']
    //                     ],
    //                     $schoolData
    //                 );
                
    //                 $school->prefilled_link = url('/school/' . $school->id . '/edit');
    //                 $school->save();
                
    //                 $imported++;
    //             }
    //         }

    //         return redirect()->route('admin.schools')->with('success', "Successfully connected to Google Sheets. Found " . count($rows) . " data rows (using second row as header).");

    //     } catch (\Exception $e) {
    //         return redirect()->route('admin.schools')->with('error', 'Error importing data: ' . $e->getMessage());
    //     }
    // }

    public function exportSendgridCsv(Request $request)
    {
        $query = School::select(
                'schools.*',
                DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'),
                DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'),
                'sb.id as matrix_id',
                'sb.box_style',
                'sb.length',
                'sb.width',
                'sb.height',
                'sb.empty_weight',
                'sb.full_weight'
            )
            ->leftJoin('school_box_size_matrices as sb', function ($join) {
                $join->on(DB::raw('schools.envelope_quantity'), '>', DB::raw('sb.greater_than'))
                    ->on(DB::raw('schools.envelope_quantity'), '<=', DB::raw('sb.qty_of_env'));
            })
            // ->where('schools.update_status', 1)
            ->orderBy('reference');

        if ($request->scope === 'since' && $request->has('since')) {
            $sinceDate = Carbon::parse($request->since)->startOfDay();
            $query->where('schools.updated_at', '>=', $sinceDate);
        }
        
        $schools = $query->get();

        $mappings = SchoolSendgridFieldMapping::all();
        
        $fileName = 'School Sendgrid Upload Format.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('sendgrid_field')->toArray();

        $callback = function() use ($schools, $mappings, $columns) {
            $file = fopen('php://output', 'w');
        
            // Add UTF-8 BOM so Excel reads characters correctly
            fputs($file, "\xEF\xBB\xBF"); 
        
            // Write header
            fputcsv($file, $columns, ',', '"');
        
            foreach ($schools as $school) {
                $row = [];
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        if ($map->our_field == "standing_order") {
                            $row[] = $school->{$map->our_field} ? "Yes" : "No";
                        } elseif ($map->our_field == "updated_at") {
                            $row[] = $school->{$map->our_field} ? $school->{$map->our_field}->format('Ymd') : "";
                        } else {
                            $value = $school->{$map->our_field} ?? '';
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
                fputcsv($file, $row, ',', '"');
            }
        
            fclose($file);
        };        

        return response()->stream($callback, 200, $headers);
    }

    public function exportFedexCsv(Request $request, string $type)
    {
        $query = School::select('schools.*', 
                DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'), 
                'sb.id as matrix_id', 
                'sb.box_style', 
                'sb.length', 
                'sb.width', 
                'sb.height', 
                'sb.empty_weight', 
                'sb.full_weight')
            ->leftJoin('school_box_size_matrices as sb', function ($join) {
                $join->on(DB::raw('schools.envelope_quantity'), '>', DB::raw('sb.greater_than'))
                    ->on(DB::raw('schools.envelope_quantity'), '<=', DB::raw('sb.qty_of_env'));
            })
            // ->where('schools.update_status', 1)
            ->orderBy('reference');

            if ($request->scope === 'since' && $request->has('since')) {
                $sinceDate = Carbon::parse($request->since)->startOfDay();
                $query->where('schools.updated_at', '>=', $sinceDate);
            }

        $schools = $query->get();

        if ($type === 'outgoing') {
            $mappings = SchoolOutgoingFedexFieldMapping::all();
        }

        if ($type === 'return') {
            $mappings = SchoolReturnFedexFieldMapping::all();            
        }

        $fileName = 'Fedex Formatted School Import '. now()->format('m-d-Y') .'.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('fedex_field')->toArray();

        $callback = function() use ($schools, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($schools as $school) {
                $row = [];
        
                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        if ($map->our_field == "updated_at") {
                            $row[] = $school->{$map->our_field} ? $school->{$map->our_field}->format('Ymd') : "";
                        } else{
                            // Pull value from the schools table dynamically
                            $value = $school->{$map->our_field} ?? '';
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