<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Inertia\Inertia;

class DonationController extends Controller
{
    /**
     * Display the donation form.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Donate');
    }

    /**
     * Store a new donation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bank_info' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
        ]);

        // Create the donation
        Donation::create($validated);

        // Redirect back with a success message
        return redirect()->route('donate.form')->with('success', 'Thank you for your donation!');
    }
}
