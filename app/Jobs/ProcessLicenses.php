<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\License;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessLicenses {

    public function __invoke() {

        $files = Storage::files(Carbon::now()->format('d-m-Y'));
        foreach($files as $file) {
            $f = fopen('./storage/app/' . $file, 'r');
            while (!feof($f)) {
                $this->processLicense(fgetcsv($f, 0, ';'));
            }
            fclose($f);
        }

    }

    private function processLicense($csvLicense) {
        if (!empty($csvLicense)) {
            License::create([
                'name' => $csvLicense[1],
                'email' => $csvLicense[2],
                'address' => $csvLicense[3],
                'license_number' => $csvLicense[4],
            ]);
        }
    }
}