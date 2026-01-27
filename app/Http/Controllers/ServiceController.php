<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('admin.services.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string'
        ]);

        $data = $request->only(['title', 'description', 'author']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('our-service', compact('service'));
    }

    public function edit(Service $service)
    {
        $users = \App\Models\User::all();
        return view('admin.services.edit', compact('service', 'users'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string'
        ]);

        $data = $request->only(['title', 'description', 'author']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $imagePath = $request->file('image')->store('services', 'public');
            $data['image'] = $imagePath;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    public function list()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('our-service', compact('services'));
    }
}