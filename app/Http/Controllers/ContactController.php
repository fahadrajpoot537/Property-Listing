<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact.index', compact('submissions'));
    }

    public function show(ContactSubmission $submission)
    {
        return view('admin.contact.show', compact('submission'));
    }

    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        ContactSubmission::create($request->all());

        return redirect()->back()->with('success', 'Thank you for contacting us! Your message has been received.');
    }

    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Contact submission deleted successfully.');
    }
}