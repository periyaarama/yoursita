<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BridalHenna;
use App\Models\BridalMakeup;
use App\Models\BunHairstyle; 
use App\Models\ChineseMakeup;
use App\Models\HalfUpHairstyle;
use App\Models\HandHenna;
use App\Models\LegHenna;// Adjust model if yours is named differently

class AdminPortfolioController extends Controller
{


//Bridal henna Portfolio
public function updateBridalHenna(Request $request, $id)
{
    $image = BridalHenna::findOrFail($id);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('bridalhenna', 'public');
        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Bridal Henna image updated.');
}



public function a_braidHairstyle()
{
    $images = \App\Models\BraidHairstyle::all();
    return view('admin.portfolio.a_braidhairstyle', compact('images'));
}

// Client view
public function showBraidPortfolio()
{
    $images = \App\Models\BraidHairstyle::all();
    return view('portfolio.braidhairstyle', compact('images'));
}

public function updateBraidHairstyle(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = \App\Models\BraidHairstyle::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('images/portfolio/braidhairstyle', $filename, 'public');

        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Braid Hairstyle image updated.');
}

public function destroyBraidHairstyle($id)
{
    $image = \App\Models\BraidHairstyle::findOrFail($id);
    $image->delete();

    return back()->with('success', 'Braid Hairstyle image deleted.');
}
public function uploadBraidHairstyle(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/braidhairstyle', $filename, 'public');

    $image = new \App\Models\BraidHairstyle();
    $image->url = 'storage/' . $path;
    $image->save();

    return back()->with('success', 'Braid hairstyle image uploaded successfully.');
}


public function a_bridalHenna()
{
    $images = BridalHenna::all(); // or your correct model
    return view('admin.portfolio.a_bridalhenna', compact('images'));
}

//Bridal Makeup
public function a_bridalMakeup()
{
    $images = BridalMakeup::all();
    return view('admin.portfolio.a_bridalmakeup', compact('images'));
}

public function updateBridalMakeup(Request $request, $id)
{
    $image = BridalMakeup::findOrFail($id);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('bridalmakeup', 'public');
        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Bridal Makeup image updated.');
}

public function destroyBridalMakeup($id)
{
    $image = BridalMakeup::findOrFail($id);
    $image->delete();

    return back()->with('success', 'Bridal Makeup image deleted.');
}
public function uploadBridalMakeup(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/bridalmakeup', $filename, 'public');

    $model = new BridalMakeup();
    $model->url = 'storage/' . $path;
    $model->save();

    return back()->with('success', 'Bridal Makeup image uploaded.');
}

public function uploadBridalHenna(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/bridalhenna', $filename, 'public');

    $newImage = new BridalHenna();
    $newImage->url = 'storage/' . $path;
    $newImage->save();

    return back()->with('success', 'Bridal Henna image uploaded.');
}


//Bun Hairstyle
public function a_bunHairstyle()
{
    $images = BunHairstyle::all();
    return view('admin.portfolio.a_bunhairstyle', compact('images'));

}

public function updateBunHairstyle(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = BunHairstyle::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('images/portfolio/bunhairstyle', $filename, 'public');

        $image->url = 'storage/' . $path; // update with relative public URL
        $image->save();
    }

    return back()->with('success', 'Bun Hairstyle image updated successfully.');
}

public function destroyBunHairstyle($id)
{
    BunHairstyle::destroy($id);
    return response()->json(['message' => 'Image deleted successfully.']);
}

public function uploadBunHairstyle(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/bunhairstyle', $filename, 'public');

    $newImage = new BunHairstyle();
    $newImage->url = 'storage/' . $path;
    $newImage->save();

    return back()->with('success', 'Bun Hairstyle image uploaded successfully.');
}


//Chinese Makeup
public function a_chineseMakeup()
{
    $images = ChineseMakeup::all();
    return view('admin.portfolio.a_chinesemakeup', compact('images'));
}

public function updateChineseMakeup(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = ChineseMakeup::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('images/portfolio/chinesemakeup', $filename, 'public');
        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Chinese Makeup image updated.');
}

public function destroyChineseMakeup($id)
{
    $image = ChineseMakeup::findOrFail($id);
    $image->delete();

    return back()->with('success', 'Chinese Makeup image deleted.');
}
public function uploadChineseMakeup(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/chinesemakeup', $filename, 'public');

    $model = new ChineseMakeup();
    $model->url = 'storage/' . $path;
    $model->save();

    return back()->with('success', 'Image uploaded successfully.');
}


//Half Up Hairstyle
public function a_halfUpHairstyle()
{
    $images = HalfUpHairstyle::all();
    return view('admin.portfolio.a_halfuphairstyle', compact('images'));
}

public function updateHalfUpHairstyle(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = HalfUpHairstyle::findOrFail($id);
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('images/portfolio/halfuphairstyle', $filename, 'public');
        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Half-Up Hairstyle image updated.');
}

public function destroyHalfUpHairstyle($id)
{
    $image = HalfUpHairstyle::findOrFail($id);
    $image->delete();

    return back()->with('success', 'Half-Up Hairstyle image deleted.');
}

public function uploadHalfUpHairstyle(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/halfuphairstyle', $filename, 'public');

    $model = new HalfUpHairstyle();
    $model->url = 'storage/' . $path;
    $model->save();

    return back()->with('success', 'Image uploaded successfully.');
}

//Hand henna
public function a_handHenna()
{
    $images = HandHenna::all();
    return view('admin.portfolio.a_handhenna', compact('images'));
}

public function updateHandHenna(Request $request, $id)
{
    $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png']);
    $image = HandHenna::findOrFail($id);

    // Optionally delete old file: File::delete(public_path($image->url));
    $path = $request->file('image')->store('images/portfolio/handhenna', 'public');
    $image->url = 'storage/' . $path;
    $image->save();

    return back()->with('success', 'Hand Henna image updated.');
}

public function destroyHandHenna($id)
{
    $image = HandHenna::findOrFail($id);
    $image->delete();
    return back()->with('success', 'Hand Henna image deleted.');
}

public function uploadHandHenna(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/handhenna', $filename, 'public');

    $newImage = new HandHenna();
    $newImage->url = 'storage/' . $path;
    $newImage->save();

    return back()->with('success', 'New image uploaded successfully.');
}

//Indian Makeup
public function a_indianMakeup()
{
    $images = \App\Models\IndianMakeup::all();
    return view('admin.portfolio.a_indianmakeup', compact('images'));
}

public function updateIndianMakeup(Request $request, $id)
{
    $image = \App\Models\IndianMakeup::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('images/portfolio/indianmakeup', 'public');
        $image->url = 'storage/' . $path;
        $image->save();
    }

    return back()->with('success', 'Image updated successfully!');
}

public function destroyIndianMakeup($id)
{
    $image = \App\Models\IndianMakeup::findOrFail($id);
    $image->delete();

    return back()->with('success', 'Image deleted successfully!');
}
public function uploadIndianMakeup(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/indianmakeup', $filename, 'public');

    $model = new \App\Models\IndianMakeup();
    $model->url = 'storage/' . $path;
    $model->save();

    return back()->with('success', 'Image uploaded successfully.');
}

//Leg Henna
public function a_legHenna()
{
    $images = LegHenna::all();
    return view('admin.portfolio.a_leghenna', compact('images'));
}

public function updateLegHenna(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $image = LegHenna::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = 'leghenna_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/portfolio/leghenna'), $filename);
        $image->url = 'images/portfolio/leghenna/' . $filename;
        $image->save();
    }

    return back()->with('success', 'Leg Henna image updated.');
}

public function destroyLegHenna($id)
{
    $image = LegHenna::findOrFail($id);
    $image->delete();
    return back()->with('success', 'Leg Henna image deleted.');
}

public function uploadLegHenna(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('images/portfolio/leghenna', $filename, 'public');

    $newImage = new LegHenna();
    $newImage->url = 'storage/' . $path;
    $newImage->save();

    return back()->with('success', 'New image uploaded successfully.');
}

}
