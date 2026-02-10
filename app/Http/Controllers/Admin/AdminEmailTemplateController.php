<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class AdminEmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::latest()->get();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($request->has('is_active') && $request->is_active) {
            // Deactivate other templates of the same type if this one is active
            EmailTemplate::where('type', $validated['type'])->update(['is_active' => false]);
        }

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($request->has('is_active') && $request->is_active) {
            // Deactivate other templates of the same type if this one is active
            EmailTemplate::where('type', $validated['type'])
                ->where('id', '!=', $emailTemplate->id)
                ->update(['is_active' => false]);
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = false;
        }

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect()->route('admin.email-templates.index')->with('success', 'Template deleted successfully.');
    }
}
