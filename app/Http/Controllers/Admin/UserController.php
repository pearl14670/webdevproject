<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['carts' => function($query) {
            $query->where('status', 'active');
        }])->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['carts' => function($query) {
            $query->with('items.product')->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Log the current user and target user
        \Log::info('Update attempt:', [
            'admin_id' => auth()->id(),
            'target_user' => $user->id,
            'is_admin_before' => $user->is_admin,
            'request_data' => $request->all()
        ]);

        // Only check for last admin if trying to remove own admin privileges
        if ($user->id === auth()->id()) {
            if (!$request->has('is_admin')) {
                $otherAdmins = User::where('id', '!=', $user->id)
                    ->where('is_admin', true)
                    ->count();

                if ($otherAdmins === 0) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cannot remove admin privileges from the last admin account.');
                }
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'is_admin' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            
            // Set admin status based on checkbox presence
            $user->is_admin = $request->has('is_admin');
            
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            // Log the changes before saving
            \Log::info('About to save user:', [
                'is_admin_after' => $user->is_admin,
                'changes' => $user->getDirty()
            ]);

            $user->save();

            DB::commit();

            // Log the final state
            \Log::info('User updated:', [
                'user_id' => $user->id,
                'is_admin_final' => $user->fresh()->is_admin
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update user:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function clearCart(User $user)
    {
        $activeCart = $user->carts()->where('status', 'active')->first();
        
        if ($activeCart) {
            $activeCart->items()->delete();
            $activeCart->updateTotal();
        }

        return back()->with('success', 'User\'s cart cleared successfully');
    }

    public function blockUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot block your own account');
        }

        $user->update(['is_blocked' => true]);
        
        // Mark all active carts as abandoned
        $user->carts()->where('status', 'active')->update(['status' => 'abandoned']);

        return back()->with('success', 'User blocked successfully');
    }

    public function unblockUser(User $user)
    {
        $user->update(['is_blocked' => false]);
        return back()->with('success', 'User unblocked successfully');
    }
} 