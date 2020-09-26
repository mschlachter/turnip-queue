<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**'password' => Hash::make($data['password'])
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        redirect(route('profile.show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        $user->update($validated);
        return back()->withStatus('Your name has been saved.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);
        return redirect(url()->previous() . '#password-section')
        ->with(['password-status' => 'Your password has been changed.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = auth()->user();
        $user->delete();
        return redirect(route('login'))->withStatus('Your account has been deleted.');
    }
}
