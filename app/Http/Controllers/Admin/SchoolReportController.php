<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class SchoolReportController extends Controller
{
    public function index(Request $request)
    {
        // Loads the same Blade you’re already on OR a separate /reports page.
        // If you prefer keeping it on the current page, just add the modal there (see Blade below).
        return view('admin.schools.reports'); 
    }

    private function baseQuery(Request $request)
    {
        $q = School::query()
            ->leftJoin('school_box_size_matrices as sb', function ($join) {
                $join->on(DB::raw('schools.envelope_quantity'), '>', DB::raw('sb.greater_than'))
                    ->on(DB::raw('schools.envelope_quantity'), '<=', DB::raw('sb.qty_of_env'));
            })
            ->leftJoin('volunteers as v', function ($join) {
                $join->on(DB::raw('schools.volunteer_id'), '=', DB::raw('v.id'));
            });

        // Filters (extend as needed)
        if ($state = $request->get('state')) {
            $q->where('schools.state', $state);
        }
        if ($name = $request->get('name')) {
            $q->where('schools.organization_name', 'like', "%{$name}%");
        }
        if ($minEnv = $request->get('min_envelopes')) {
            $q->where('schools.envelope_quantity', '>=', (int)$minEnv);
        }
        if ($maxEnv = $request->get('max_envelopes')) {
            $q->where('schools.envelope_quantity', '<=', (int)$maxEnv);
        }
        if ($standing = $request->get('standing_order')) {
            $q->where('schools.standing_order', $standing === 'yes');
        }
        if ($update_status = $request->get('update_status')) {
            $q->where('schools.update_status', $update_status === 'update');
        }

        return $q->orderBy('reference');
    }

    // DataTables JSON (server-side)
    public function data(Request $request)
    {
        try {
            $rows = $this->baseQuery($request)
                ->with('volunteer')
                ->select([
                    'schools.id','schools.organization_name','schools.contact_person_name','schools.how_to_address',
                    'schools.email','schools.phone','schools.street','schools.city','schools.county','schools.state','schools.zip',
                    'schools.envelope_quantity','schools.instructions_cards','schools.prefilled_link','schools.standing_order','schools.update_status','schools.updated_at',
                    'schools.public_notes','schools.internal_notes','schools.contact_title',
                    'sb.box_style','sb.length','sb.width','sb.height','sb.empty_weight','sb.full_weight',
                    'v.name as volunteer_name','v.phone as volunteer_phone',                    
                    DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'), 
                    DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'), 
                ])
                ->get();

            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            logger()->error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }        
    }

    // Exports share filters via query string (?state=CA&min_envelopes=100...)
    public function export(Request $request, string $type)
    {
        $rows = $this->baseQuery($request)
            ->with('volunteer')
            ->select([
                'schools.id','schools.organization_name','schools.contact_person_name','schools.how_to_address',
                'schools.email','schools.phone','schools.street','schools.city','schools.county','schools.state','schools.zip',
                'schools.envelope_quantity','schools.instructions_cards','schools.prefilled_link','schools.standing_order','schools.update_status','schools.updated_at',
                'schools.public_notes','schools.internal_notes','schools.contact_title',
                'sb.box_style','sb.length','sb.width','sb.height','sb.empty_weight','sb.full_weight',
                'v.name as volunteer_name','v.phone as volunteer_phone',                    
                DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'), 
                DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'), 
            ])
            ->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.schools.report-pdf', ['rows' => $rows, 'filters' => $request->all()])
                    ->setPaper('a4', 'landscape'); // or 'letter';
            return $pdf->download('schools-report(' . now()->format('Y-m-d') . ').pdf');
        }

        // CSV / XLSX
        $export = new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function __construct(private $rows) {}
            public function array(): array {
                return $this->rows->map(function ($r) {
                    return [
                        $r->reference,
                        $r->organization_name,
                        $r->contact_person_name,
                        $r->email,
                        $r->how_to_address,
                        $r->phone,
                        $r->street, $r->city, $r->county, $r->state, $r->zip,
                        $r->envelope_quantity,
                        $r->instructions_cards,
                        $r->box_style,
                        "{$r->length}x{$r->width}x{$r->height}",
                        $r->empty_weight,
                        $r->full_weight,
                        $r->volunteer_name,
                        $r->prefilled_link,
                        $r->public_notes,
                        $r->internal_notes,
                        $r->standing_order ? 'Yes' : 'No',
                        $r->update_status ? 'Update' : 'New',
                        $r->updated_at->format('Ymd')
                        // $r->prefilled_link,                        
                        // $r->update_status ? 'Updated' : '—',
                    ];
                })->toArray();
            }
            public function headings(): array {
                return [
                    'ID','Organization','Contact','Email','Dear Whom','Phone',
                    'Street','City','County','State','ZIP',
                    'Envelopes','Cards','Box Style','Dimensions','Empty Weight','Full Weight',
                    'Volunteer','Prefilled Link','Notes from School','Internal Notes','Standing Order','New/Update','Last Updated'
                ];
            }
        };

        $filename = 'schools-report(' . now()->format('Y-m-d') . ').' . ($type === 'xlsx' ? 'xlsx' : 'csv');
        $writer = $type === 'xlsx' ? ExcelWriter::XLSX : ExcelWriter::CSV;

        return Excel::download($export, $filename, $writer);
    }

    // OPTIONAL: export to Google Sheets
    public function exportToSheets(Request $request)
    {
        // You’ll need a service account JSON and a shared Sheet.
        // 1) Create a Google Cloud project, enable Sheets API
        // 2) Create service account & JSON key, store path in config/env
        // 3) Share target sheet with service account email
        // This is a minimal example; handle auth/config as you prefer.

        $rows = $this->baseQuery($request)->select([
            'schools.id','schools.organization_name','schools.contact_person_name','schools.how_to_address',
            'schools.email','schools.phone','schools.street','schools.city','schools.county','schools.state','schools.zip',
            'schools.envelope_quantity','schools.instructions_cards','schools.prefilled_link','schools.standing_order','schools.update_status','schools.updated_at',
            'schools.public_notes','schools.internal_notes','schools.contact_title',
            'sb.box_style','sb.length','sb.width','sb.height','sb.empty_weight','sb.full_weight',
            DB::raw('CONCAT("S", schools.state, LPAD(schools.id, 5, "0")) as reference'), 
            DB::raw('CONCAT(schools.envelope_quantity, "/", schools.instructions_cards, "/", sb.box_style) as invoiceNumber'), 
        ])->get();;

        $client = new \Google\Client();
        $client->setApplicationName('School Reports');
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('app/google/service-account.json')); // adjust path
        $service = new \Google\Service\Sheets($client);

        $spreadsheetId = config('services.google.sheets_id'); // put in config/services.php & .env
        $range = 'Sheet1!A1'; // top-left cell

        $values = [];
        $values[] = [
            'ID','Organization','Contact','Email','Dear Whom','Phone',
            'Street','City','County','State','ZIP',
            'Envelopes','Cards','Box Style','Dimensions','Empty Weight','Full Weight',
            'Volunteer','Prefilled Link','Notes from School','Internal Notes','Standing Order','New/Update','Last Updated'
        ];
        foreach ($rows as $r) {
            $values[] = [
                $r->reference,
                $r->organization_name,
                $r->contact_person_name,
                $r->email,
                $r->how_to_address,
                $r->phone,
                $r->street, $r->city, $r->state, $r->zip,
                $r->envelope_quantity,
                $r->instructions_cards,
                $r->box_style,
                "{$r->length}x{$r->width}x{$r->height}",
                $r->empty_weight,
                $r->full_weight,
                $r->volunteer_name,
                $r->prefilled_link,
                $r->public_notes,
                $r->internal_notes,
                $r->standing_order ? 'Yes' : 'No',
                $r->update_status ? 'Update' : 'New',
                $r->updated_at->format('Ymd')
                // $r->prefilled_link,                
                // $r->update_status ? 'Updated' : '—',
            ];
        }

        $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];

        // Clear & write
        $service->spreadsheets_values->clear($spreadsheetId, 'Sheet1', new \Google\Service\Sheets\ClearValuesRequest());
        $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);

        return back()->with('status', 'Exported to Google Sheets!');
    }
}
