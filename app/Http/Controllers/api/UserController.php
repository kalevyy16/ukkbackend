<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'sometimes|string',
            'profile_photo' => 'nullable|string',
            'address' => 'nullable|string',
            'job' => 'nullable|string',
            'birth_date' => 'sometimes|date',
            'phone' => 'sometimes|string',
            'password' => 'sometimes|string|min:6',
        ]);
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update($request->only(['name','profile_photo','address','job','birth_date','phone']));
        return response()->json($user);
    }

    public function onboarding(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string',
            'saving_mode' => 'required|in:sendiri,berdua',
        ]);
        $user->update([
            'name' => $request->name,
            'saving_mode' => $request->saving_mode,
            'onboarding_completed' => true,
        ]);
        return response()->json($user);
    }
}