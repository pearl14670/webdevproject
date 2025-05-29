<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'current_password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();

        // Count remaining admins
        $remainingAdmins = \App\Models\User::where('is_admin', true)
            ->where('id', '!=', $user->id)
            ->count();

        if ($remainingAdmins === 0) {
            return back()
                ->withErrors(['current_password' => 'Cannot delete the last admin account.'])
                ->withInput();
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
} 