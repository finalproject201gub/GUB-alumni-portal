<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $userData = User::where('id', auth()->user()->id)->first();

        return view('public.profile.index', compact('userData'));
    }
}
