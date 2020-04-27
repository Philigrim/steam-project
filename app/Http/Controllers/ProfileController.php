<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Subject;
use App\Lecturer;
use App\User;
use App\LecturerHasSubject;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {

        if(\Auth::user()->isRole()=="paskaitu_lektorius"){
        $lecturer_id=Lecturer::all()->where('user_id','=',\Auth::user()->id)->first()->id;
        $lecturer_subjects_ids = LecturerHasSubject::all()->where('lecturer_id', $lecturer_id)->pluck('subject_id');
        $addable_subjects = Subject::all()->whereNotIn('id', $lecturer_subjects_ids);
        $lector_subjects = Subject::all()->whereIn('id', $lecturer_subjects_ids);
        return view('profile', ['addable_subjects'=>$addable_subjects, 'lector_subjects'=>$lector_subjects]);
        }
        else{
            return view('profile');
        }

    }

    public function index()
    {
    }
    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    public function addSubject(Request $request)
    {
        $subject_id = $request->get('input-subject');
        $lecturer_id=Lecturer::all()->where('user_id','=',\Auth::user()->id)->first()->id;

        $data = array(
            'subject_id' => $subject_id,
            'lecturer_id' => $lecturer_id);
    
        LecturerHasSubject::insert($data);

        return back()->withSubjectStatus(__('Mokomasis dalykas pridėtas!'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
