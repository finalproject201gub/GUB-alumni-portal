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

        $user = User::findOrFail($id);

        $user->fill($request->except('_token'));

        if ($request->hasFile('profile_pic')) {
            if ($user->avatar && $user->avatar != 'avatar.png' && file_exists(public_path('img/profile/' . $user->avatar))) {
                unlink(public_path('img/profile/' . $user->avatar));
            }

            $fileName = time() . '.' . $request->profile_pic->extension();
            $request->profile_pic->move(public_path('img/profile'), $fileName);
            $user->avatar = $fileName;
        }
        $user->save();
        return redirect()
            ->back()
            ->with('success', 'Profile Updated Successfully');
    }
}
