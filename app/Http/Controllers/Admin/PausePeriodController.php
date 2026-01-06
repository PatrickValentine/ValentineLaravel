<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PausePeriodController extends Controller
{
    protected $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/pause_dates.json');
    }

    // Update pause dates
    public function update(Request $request)
    {
        $request->validate([
            'school_pause_date' => 'required|date',
            'hospital_pause_date' => 'required|date',
            'end_pause_date' => 'required|date|after_or_equal:school_pause_date|after_or_equal:hospital_pause_date',
        ]);

        $data = [
            'school_start' => $request->input('school_pause_date'),
            'hospital_start' => $request->input('hospital_pause_date'),
            'end_date' => $request->input('end_pause_date'),
        ];

        $this->writePauseDates($data);

        return redirect()->back();
    }

    // Read pause dates from JSON file
    protected function readPauseDates()
    {
        if (!file_exists($this->filePath)) {
            // Create file if missing
            $this->writePauseJSON([
                'school_start'   => '',
                'hospital_start' => '',
                'end_date'       => ''
            ]);
        }

        return json_decode(file_get_contents($this->filePath), true);
    }

    // Write pause dates to JSON file
    protected function writePauseDates(array $data)
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
