<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MortgageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = \App\Models\MortgageSetting::first();
        if (!$setting) {
            $setting = \App\Models\MortgageSetting::create([
                'down_payment_percentage' => 20,
                'interest_rate' => 3.5,
                'loan_term_years' => 20
            ]);
        }
        return view('admin.mortgage-settings.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'down_payment_percentage' => 'required|numeric|min:0|max:100',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'loan_term_years' => 'required|integer|min:1|max:50',
        ]);

        $setting = \App\Models\MortgageSetting::findOrFail($id);
        $setting->update($request->all());

        return redirect()->back()->with('success', 'Mortgage settings updated successfully.');
    }
}
