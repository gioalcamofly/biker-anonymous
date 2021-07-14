<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\GetLicenseRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class LicenseController extends Controller
{
    
    /**
     * Update a licenses file for later processing
     * 
     * @param App\Http\Requests\UploadFileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(UploadFileRequest $request) {

        $path = $request->file('file')->store(Carbon::now()->format('d-m-Y'));

        return response()->json('File Uploaded', 200);

    }

    /**
     * Returns a license pdf file from the required license (using license number)
     * 
     * @param App\Http\Requests\GetLicenseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getLicensePdf(GetLicenseRequest $request) {

        $license = License::where('license_number', $request->input('license_number'))->first();

        view()->share('license', $license);
        $pdf = PDF::loadView('license', $license);

        return $pdf->download('license.pdf');

    }

    /**
     * Sends email with information about daily activity
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request) {

        $user = Auth::guard('api')->user();
        $processedLicenses = License::whereDate('created_at', Carbon::today())->count();

        Mail::send('daily_activity_email', ['processed_licenses' => $processedLicenses], function ($message) use($user) { 
            $message->to($user->email)->subject('this works!'); 
        });

        return response()->json('Mail sent', 200);

    }

}
