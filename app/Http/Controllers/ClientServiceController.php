<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ClientServiceController extends Controller
{
    public function showBridal()
{
    $service = Service::where('name', 'Bridal Package')->firstOrFail();
    $service->images = json_decode($service->image); // ← add this line

    return view('services.bridal', compact('service'));
}


    public function showMakeup()
{
    $service = Service::where('name', 'Makeup Service')->firstOrFail();
    return view('services.makeup', compact('service'));
}


    public function showHairdo()
{
    $service = Service::where('name', 'Hairdo Service')->firstOrFail();
    return view('services.hairdo', compact('service'));
}


   public function showSaree()
{
    $service = Service::where('name', 'Saree Drapping Service')->firstOrFail();
    return view('services.saree', compact('service'));
}



    public function showMakeover()
{
    $services = Service::where('name', 'Personal Makeover')->get()->keyBy('type');
    return view('services.makeover', compact('services'));
}


    public function showHenna()
{
    $services = Service::where('name', 'Henna Service')->get();
    return view('services.henna', compact('services'));
}
 
    public function showGroupHenna()
{
    $services = Service::where('name', 'Henna Service')
        ->where('type', 'Group Henna')
        ->get()
        ->map(function ($item) {
            return [
                'name' => $item->name,
                'price' => $item->price,
                'img' => asset('images/' . $item->image), // add this
            ];
        });

    return view('services.henna.group', compact('services'));
}


 public function showIndividualHenna()
{
    $handDesigns = Service::where('name', 'Henna Service')
    ->where('type', 'Individual Henna')
    ->whereIn('sub_service', ['Wrist', 'Mid Arm', 'Elbow'])
    ->get()
    ->map(function ($item) {
        return [
            'key' => strtolower(str_replace(' ', '', $item->sub_service)),
            'name' => $item->sub_service,
            'price' => $item->price,
            'img' => asset('images/' . $item->image), // fixed here
        ];
    });


    $legDesigns = Service::where('name', 'Henna Service')
        ->where('type', 'Individual Henna')

        ->whereIn('sub_service', ['Toe', 'Top Foot', 'Ankle'])
        ->get()
        ->map(function ($item) {
            return [
                'key' => strtolower(str_replace(' ', '', $item->sub_service)),
                'name' => $item->sub_service,
                'price' => $item->price,
                'img' => asset('images/' . $item->image), 
            ];
        });

    return view('services.henna.individual', compact('handDesigns', 'legDesigns'));
}








}
