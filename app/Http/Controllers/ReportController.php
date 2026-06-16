<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function index()
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        return view('reports.index');
    }

    public function store(Request $request)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => $this->currentUserId(),
            'message' => $request->message,
        ]);

        return redirect('/reports')->with('success', 'Laporan terkirim!');
    }

}
