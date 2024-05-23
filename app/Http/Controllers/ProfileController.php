<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        return view('profile.index');
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 400, 'message' => 'User failed to update'];
            if ($user->email != $request['email']) {
                if (User::where('email', $request['email'])->exists()) {
                    return $data = ['status' => false, 'code' => 400, 'message' => 'Email already exists'];
                }
            }
            $validator = Validator::make($request->all(), [
                'name'       => 'required',
                'email'      => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 403, 'message' => $validator->errors()]);
            }

            $user->name          = $request['name'];
            $user->email         = $request['email'];
            $user->save();

            if ($user) {
                DB::commit();
                $data = ['status' => true, 'code' => 200, 'message' => 'User updated successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 500, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'User failed to be found'];
            $user = User::where('id', $id)->first();
            if ($user) {
                $data = ['status' => true, 'message' => 'User was successfully found', 'data' => $user];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function changePassword(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 400, 'message' => 'Password failed to change'];
            $user = User::find($request->id);
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['status' => false, 'code' => 400, 'message' => 'Password already used']);
            }
            $update = User::where('id', $request->id)->update([
                'password'      => Hash::make($request['password']),
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 200, 'message' => 'Password changed successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 500, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
