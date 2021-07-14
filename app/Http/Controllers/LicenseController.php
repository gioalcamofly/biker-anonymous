<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class LicenseController extends Controller
{
    
    /**
     * Update a licenses file for later processing
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request) {

        $path = $request->file('file')->store(Carbon::now()->format('d-m-Y'));

        return response('File Uploaded', 200);

    }

    public function getLicensePdf(Request $request) {

        $license = License::where('license_number', $request->input('license_number'))->first();

        view()->share('license', $license);
        $pdf = PDF::loadView('license', $license);

        return $pdf->download('license.pdf');

    }

}
