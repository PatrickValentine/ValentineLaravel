<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendEmail;
use Carbon\Carbon;

class HospitalController extends Controller
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
        $isHospitalPaused = $today->between(
            Carbon::parse($pauseData['hospital_start']),
            Carbon::parse($pauseData['end_date'])
        );

        return view('hospitals.register', compact('isHospitalPaused'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name'     => 'required|string|max:255',
            'organization_type'     => 'required|string|max:255',
            'contact_person_name'   => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:hospitals,email',
            'how_to_address'        => 'required|string|max:255',
            'valentine_card_count'  => 'required|integer|min:0',
            'extra_staff_cards'     => 'nullable|integer|min:0',
            'street'                => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'county'                => ['nullable', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'                 => 'required|string|max:255',
            'zip'                   => 'required|string|max:20',
            'phone'                 => 'required|string|max:20',
            'standing_order'        => 'boolean',
            'public_notes'              => 'nullable|string',
            // 'internal_notes'            => 'nullable|string',
        ], [
            'email.unique' => 'The email has already been taken. You can use a different address or email us at Patrick@ValentinesByKids.org to ask us to either delete the old record or to send you a link to update your information.',
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

        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isHospitalPaused = $today->between(
            Carbon::parse($pauseData['hospital_start']),
            Carbon::parse($pauseData['end_date'])
        );

        if($isHospitalPaused){
            $hospital->full_greeting = ($hospital->how_to_address ? $hospital->how_to_address : "Friend") . ", thank you for registering to participate in Valentines By Kids! Because your request came in after January 5, we will only be able to satisfy your request if we receive enough Valentines from the children. Our database now reflects:";
            $success = "Success! You have registered. 
                        We hope we will have enough cards to satisfy your request this coming Valentine’s Day. 
                        Your information appears below. 
                        Feel free to correct anything, but remember to click “Submit” again at the end.";
        }
        else{
            $hospital->full_greeting = ($hospital->how_to_address ? $hospital->how_to_address : "Friend") . ", thank you for registering to participate in Valentines By Kids! Our database now reflects:";
            $success = 'Success! You have registered and you will receive your delivery before Valentine’s Day. 
                        Your information appears below. 
                        Feel free to correct anything, but remember to click “Submit” again at the end.';
        }

        $subject = 'Valentine notification';
        $message = $hospital;

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($hospital->email)->send(new SendEmail($data));

        return redirect()->route('hospital.edit', $hospital->token)
        // return redirect()
        //     ->back()
            ->with('success', $success);
    }

    public function edit($token)
    {
        $hospital = Hospital::where('token', $token)->firstOrFail();
        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isHospitalPaused = $today->between(
            Carbon::parse($pauseData['hospital_start']),
            Carbon::parse($pauseData['end_date'])
        );
        return view('hospitals.edit', compact('hospital', 'isHospitalPaused'));
    }

    public function update(Request $request, $token)
    {
        $hospital = Hospital::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'organization_name'     => 'required|string|max:255',
            'organization_type'     => 'required|string|max:255',
            'contact_person_name'   => 'required|string|max:255',
            'email'                 => 'required|email|max:255',
            'valentine_card_count'  => 'required|integer|min:0',
            'extra_staff_cards'     => 'nullable|integer|min:0',
            'street'                => 'required|string|max:255',
            'city'                  => 'required|string|max:255',
            'county'                => ['nullable', 'max:35', 'regex:/^[A-Za-z0-9 .-]+$/'],
            'state'                 => 'required|string|max:20',
            'zip'                   => 'required|string|max:20',
            'phone'                 => 'required|string|max:255',
            'standing_order'        => 'boolean',
            'public_notes'          => 'nullable|string',
            // 'internal_notes'          => 'nullable|string',
        ]);

        // Ensure standing_order is boolean
        $validated['standing_order'] = $request->has('standing_order');

        // Mark the school as updated
        $validated['update_status'] = true;

        if($hospital->email != $request->email){
            $request->validate([
                'email' => 'required|email|max:255|unique:hospitals,email'], [
                'email.unique' => 'The email has already been taken. You can use a different address or email us at Patrick@ValentinesByKids.org to ask us to either delete the old record or to send you a link to update your information.',
            ]);
        }

        // Merge the full form data (request->all) with validated data
        $allData = array_merge($request->all(), $validated);

        $hospital->update($allData);
        
        // $hospital->prefilled_link = url('/hospital/' . $hospital->id . '/edit');
        $hospital->save();

        $pauseData = $this->pauseData;
        $today = Carbon::today();
        $isHospitalPaused = $today->between(
            Carbon::parse($pauseData['hospital_start']),
            Carbon::parse($pauseData['end_date'])
        );

        if($isHospitalPaused){
            $hospital->full_greeting = ($hospital->how_to_address ? $hospital->how_to_address : "Friend") . ", thank you for updating your information.";
            $success = "Success! You have updated your information. 
                        Feel free to correct anything below, but remember to click “Submit” again at the end.";
        }
        else{
            $hospital->full_greeting = ($hospital->how_to_address ? $hospital->how_to_address : "Friend") . ", thank you for updating your information.";
            $success = 'Success! You have updated your information. 
                        Feel free to correct anything, but remember to click “Submit” again at the end.';
        }

        $subject = 'Valentine notification';
        // $message = 'Dear ' . ($hospital->how_to_address ? $hospital->how_to_address : 'Friend') . ', our database has been successfully';
        $message = $hospital;

        $data = array(
            'from_name' => env('MAIL_FROM_NAME'),
            'from_email' => env('MAIL_FROM_ADDRESS'),
            'subject' => $subject,
            'message' => $message,
        );

        Mail::to($hospital->email)->send(new SendEmail($data));
        
        return redirect()
            ->back()
            ->with('success', $success);
    }
}