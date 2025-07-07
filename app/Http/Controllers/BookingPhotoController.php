<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingPhoto;
use Illuminate\Support\Facades\Storage;

class BookingPhotoController extends Controller
{
   
public function upload(Request $request)
{
    $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'photos.*' => 'required|image|max:2048',
    ]);

    // Check if photos exist and are valid
    if (!$request->hasFile('photos') || !is_array($request->file('photos'))) {
        return back()->with('error', 'Please upload at least one photo.');
    }

    foreach ($request->file('photos') as $photo) {
    if (!$photo || !$photo->isValid()) continue;

    // Store file and get original name
    $storedPath = $photo->store('reference_photos', 'public');
    $originalName = $photo->getClientOriginalName();

    BookingPhoto::create([
        'booking_id' => $request->booking_id,
        'photo_path' => $storedPath,
        'file_name' => $originalName, // ✅ store original name in DB
    ]);
}


    return back()->with('success', 'Photos uploaded successfully.');
}


public function destroy($id)
{
    $photo = BookingPhoto::findOrFail($id);

    // Delete the file from storage
    if (Storage::disk('public')->exists($photo->photo_path)) {
        Storage::disk('public')->delete($photo->photo_path);
    }

    // Delete from database
    $photo->delete();

    return back()->with('success', 'Photo removed successfully.');
}


}

