<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Store user document and auto-approve if unique.
     */
    public function storeDocument(Request $request): RedirectResponse
    {
        $request->validate([
            'document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // 5MB max
            'type' => 'required|string',
        ]);

        $file = $request->file('document');

        // Calculate hash to ensure uniqueness across the system
        $hash = hash_file('sha256', $file->getRealPath());

        // Check if hash exists anywhere in the system
        if (\App\Models\UserDocument::where('file_hash', $hash)->exists()) {
            return back()->with('error', 'This document is already in our system. Duplicate submissions are rejected.');
        }

        $path = $file->store('user_documents', 'public');

        $request->user()->documents()->create([
            'type' => $request->input('type'),
            'file_path' => $path,
            'file_hash' => $hash,
            'status' => 'approved',
        ]);

        // Auto-approve user status upon successful unique document upload
        $user = $request->user();
        if ($user->status !== 'document_approved') {
            $user->status = 'document_approved';
            $user->save();
        }

        // Notify Admin
        Mail::to('info@propertyfinda.co.uk')->send(new AdminNotification('document_uploaded', [
            'user' => $user,
            'doc_type' => $request->input('type')
        ]));

        return back()->with('status', 'document-uploaded');
    }
}
