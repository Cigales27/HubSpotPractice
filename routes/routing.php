<?php

/**
 * ---------------------------------------------------------------------------
 * Routing on folders
 * ---------------------------------------------------------------------------
 */

use App\Helpers\VarHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        foreach (scandir(base_path('routes/api')) as $file) {
            if (!Str::contains($file, '.php')) continue;

            $cleanFileName = Str::replace('.php', '', $file);
            $camelCaseToSpaces = VarHelper::camelCaseToSpaces($cleanFileName);
            $finalName = Str::slug($camelCaseToSpaces, '-', 'es');
            Route::prefix($finalName)->group(base_path("routes/api/{$file}"));
        }
    });
