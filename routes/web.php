<?php

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', function () {
    $files = collect(Storage::allFiles())->filter(function ($filePath) {
        return Str::endsWith($filePath, '.zip');
    })->mapToGroups(function ($filePath) {
        list($system, $fileName) = explode('/', $filePath);

        return [$system => $fileName];
    });

    return view('dashboard', [
        'files' => $files
    ]);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/', function (Request $request) {
        $file = $request->file;

        if (Storage::exists($file)) {
            Download::create([
                'file' => $file,
                'stats' => implode('->', $request->ips())
            ]);

            return response()->download(Storage::path($file));
        }
        else {
            return redirect()->route('dashboard');
        }
    })->name('download');
});

Route::get('/stats', function (Request $request) {
    abort_unless(Hash::check($request->get('bacon'), env('STATS_PW') ), 404);

    $files = collect(Storage::allFiles())->filter(function ($filePath) {
        return Str::endsWith($filePath, '.zip');
    })->mapToGroups(function ($filePath) {
        list($system, $fileName) = explode('/', $filePath);

        return [$system => $fileName];
    });

    return view('stats', [
        'files' => $files
    ]);
});

require __DIR__ . '/auth.php';
