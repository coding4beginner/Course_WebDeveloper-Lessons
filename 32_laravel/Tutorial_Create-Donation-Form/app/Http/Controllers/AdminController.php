<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with all donations.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $donations = Donation::orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Admin/Dashboard', [
            'donations' => $donations,
        ]);
    }
}
