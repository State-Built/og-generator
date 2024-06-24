<?php
use Illuminate\Support\Facades\Route;
use State\OgWally\Http\Controllers\SettingsController;

Route::name('ogwally.')->prefix('ogwally')->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('update');
    Route::get('/preview', [SettingsController::class, 'preview'])->name('preview');
});
