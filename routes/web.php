<?php

use Illuminate\Http\Request;
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
            return response()->download(Storage::path($file));
        }
        else {
            return redirect()->route('dashboard');
        }
    })->name('download');
});

require __DIR__ . '/auth.php';
