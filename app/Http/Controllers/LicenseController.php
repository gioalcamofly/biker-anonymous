<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

}
