<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create() {
        return view('admin.services.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Service added!');
    }

    public function edit(Service $service) {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
{
    $data = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
    ]);

    $service->update($data);

    $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
]);


    return redirect()->route('admin.services.index')->with('success', 'Service updated!');
}


}

