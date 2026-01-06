<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendEmail;
use Carbon\Carbon;

class SchoolController extends Controller
{
    protected $pauseData;

    public function __construct()
    {
        $filePath = storage_path('app/pause_dates.json');
        
        if (!file_exists($filePath)) {
            // Create file if missing
            $this->pauseData = [
                'school_start'   => '',
                'hospital_start' => '',
                'end_date'       => ''
            ];
        } else {
            $this->pauseData = json_decode(file_get_contents($filePath), true);
        }
    }

    public function create()
    {
        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isSchoolPaused = $today->between(
            Carbon::parse($pauseData['school_start']),
            Carbon::parse($pauseData['end_date'])
        );

        return view('schools.register', compact('isSchoolPaused'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'   => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name' => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'               => 'required|email|max:255|unique:schools,email',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'county'              => ['nullable', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'               => ['required', 'size:2', 'alpha'],
            'zip'                 => 'required|string|max:20',
            'phone'               => ['required', 'digits:10'],
            'standing_order'      => 'boolean',
            'public_notes'            => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ], [
            'email.unique' => 'The email has already been taken. You can use a different address or email us at Patrick@ValentinesByKids.org to ask us to either delete the old record or to send you a link to update your information.',
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

        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isSchoolPaused = $today->between(
            Carbon::parse($pauseData['school_start']),
            Carbon::parse($pauseData['end_date'])
        );

        if($isSchoolPaused){
            $school->full_greeting = ($school->how_to_address ? $school->how_to_address : "Friend") . ", thank you for registering to participate in Valentines By Kids! Even though we won’t be able to send you envelopes for this coming Valentine’s Day, please don’t forget that you can still join the fun! Click <a href='https://valentinesbykids.org/single-cards/' target='_blank' style='font-family:Arial;color:rgb(58, 115, 119);white-space:nowrap'>HERE</a> for details.<br/>Our database now reflects (for future years):";
            $success = "Success! You have completed the registration process for future years, but please participate this coming Valentines by clicking <a href='https://valentinesbykids.org/single-cards/' target='_blank' style='font-family:Arial;color:rgb(58, 115, 119);white-space:nowrap'>HERE</a>.";
        }
        else{
            $school->full_greeting = ($school->how_to_address ? $school->how_to_address : "Friend") . ", thank you for registering to participate in Valentines By Kids! Our database now reflects:";
            $success = 'Success! You have completed the registration process. 
                        We will contact you when we are about to send you the envelopes. 
                        Feel free to correct anything below, but remember to click “Submit” again at the end.';
        }

        $subject = 'Valentine notification';
        $message = $school;

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($school->email)->send(new SendEmail($data));

        return redirect()->route('school.edit', $school->token)
        // return redirect()
        //     ->back()
            ->with('success', $success);
    }

    public function edit($token)
    {
        $school = School::where('token', $token)->firstOrFail();
        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isSchoolPaused = $today->between(
            Carbon::parse($pauseData['school_start']),
            Carbon::parse($pauseData['end_date'])
        );
        return view('schools.edit', compact('school', 'isSchoolPaused'));
    }

    public function update(Request $request, $token)
    {
        $school = School::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'organization_name'   => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'contact_person_name' => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'email'               => 'required|email|max:255',
            'how_to_address'      => 'required|string|max:255',
            'envelope_quantity'   => 'required|integer|min:0',
            'instructions_cards'  => 'nullable|integer|min:0',
            'street'              => ['required', 'max:30', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'city'                => ['required', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'county'              => ['nullable', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'               => ['required', 'size:2', 'alpha'],
            'zip'                 => 'required|string|max:20',
            'phone'               => ['required', 'digits:10'],
            'standing_order'      => 'boolean',
            'public_notes'            => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        if($school->email != $request->email){
            $request->validate([
                'email' => 'required|email|max:255|unique:schools,email'
            ], [
                'email.unique' => 'The email has already been taken. You can use a different address or email us at Patrick@ValentinesByKids.org to ask us to either delete the old record or to send you a link to update your information.',
            ]);
        }
        
        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $school->update($allData);

        // $school->prefilled_link = url('/school/' . $school->id . '/edit');

        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isSchoolPaused = $today->between(
            Carbon::parse($pauseData['school_start']),
            Carbon::parse($pauseData['end_date'])
        );

        if($isSchoolPaused){
            $school->full_greeting = ($school->how_to_address ? $school->how_to_address : "Friend") . ", thank you for updating your information.";
            $success = "Success! You have updated your information. 
                        Feel free to correct anything, but remember to click “Submit” again at the end.";
        }
        else{
            $school->full_greeting = ($school->how_to_address ? $school->how_to_address : "Friend") . ", thank you for updating your information.";
            $success = 'Success! You have updated your information. 
                        Feel free to correct anything, but remember to click “Submit” again at the end.';
        }
        
        $subject = 'Valentine notification';
        $message = $school;

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($school->email)->send(new SendEmail($data));
        
        return redirect()
            ->back()
            ->with('success', $success);
    }

}