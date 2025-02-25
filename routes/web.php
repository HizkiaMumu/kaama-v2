<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

Route::get('/', [PagesController::class, 'homePage']);

Route::get('/cam', [PagesController::class, 'camPage']);

Route::post('/upload-images', function (Request $request) {
    $images = $request->input('images');
    $savedImages = [];

    foreach ($images as $index => $image) {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'photo_' . time() . '_' . $index . '.png';
        Storage::disk('public')->put($imageName, base64_decode($image));
        $savedImages[] = asset('storage/' . $imageName);
    }

    session(['captured_images' => $savedImages]);

    return response()->json(['success' => true]);
});

Route::post('/upload-video', function (Request $request) {
    if ($request->hasFile('video')) {
        $video = $request->file('video');
        $videoName = 'video_' . time() . '.webm';
        $video->storeAs('public', $videoName);

        session(['captured_video' => asset('storage/' . $videoName)]);

        return response()->json(['success' => true, 'video_url' => asset('storage/' . $videoName)]);
    }

    return response()->json(['success' => false, 'message' => 'No video uploaded'], 400);
});


Route::get('/preview', function () {
    $capturedImages = session('captured_images', []);
    return view('preview', compact('capturedImages'));
});