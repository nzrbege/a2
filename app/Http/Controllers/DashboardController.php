<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function ringkasan()
    {
        return view('dashboard.ringkasan');
    }

    public function kendaliSubKegiatan()
    {
        return view('dashboard.kendali-sub-kegiatan');
    }
}
