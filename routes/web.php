<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\PaymentController;

Route::get('/', [PagesController::class, 'homePage']);

Route::get('/cam', [PagesController::class, 'camPage']);

Route::post('/upload-images', function (Request $request) {
    $images = $request->input('images');
    $videos = $request->input('videos');
    $savedImages = [];
    $savedVideos = [];

    // Save images (unchanged)
    foreach ($images as $index => $image) {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'photo_' . time() . '_' . $index . '.png';
        Storage::disk('public')->put($imageName, base64_decode($image));
        $savedImages[] = asset('storage/' . $imageName);
    }

    // Save videos (base64 encoded)
    foreach ($videos as $index => $video) {
        $video = str_replace(' ', '+', $video);  // Make sure spaces are replaced with '+'
        $videoName = 'video_' . time() . '_' . $index . '.webm'; // Save as .webm, or .mp4 if you prefer
        Storage::disk('public')->put($videoName, base64_decode($video));
        $savedVideos[] = asset('storage/' . $videoName);
    }

    // Store images and videos in the session
    session(['captured_images' => $savedImages, 'captured_videos' => $savedVideos]);

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
    $capturedVideos = session('captured_videos', []);
    return view('preview', compact('capturedImages', 'capturedVideos'));
});

Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken']);
