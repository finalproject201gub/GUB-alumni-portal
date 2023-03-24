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

    public function update(Request $request, $id)
    {

        $request->validate([
            'batch_number' => 'nullable',
            'passing_year' => 'nullable',
            'department_id' => 'nullable',
            'student_id_number' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);


        $user = User::find($id)->update($request->all());

        return redirect()
            ->back()
            ->with('success', 'Profile Updated Successfully');
    }
}
