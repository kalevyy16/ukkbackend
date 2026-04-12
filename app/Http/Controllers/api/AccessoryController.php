<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function index() { return Accessory::all(); }

    public function buy(Request $request, Accessory $accessory) {
        $user = $request->user();
        $pet = $user->pet;
        if ($pet->coin < $accessory->price) return response()->json(['message' => 'Koin tidak cukup'], 400);
        if ($user->accessories()->where('accessory_id', $accessory->id)->exists()) return response()->json(['message' => 'Sudah dimiliki'], 400);
        $pet->coin -= $accessory->price;
        $pet->save();
        $user->accessories()->attach($accessory->id, ['acquired_at' => now()]);
        return response()->json(['message' => 'Berhasil membeli', 'coin' => $pet->coin]);
    }

    public function equip(Request $request, Accessory $accessory) {
        $user = $request->user();
        if (!$user->accessories()->where('accessory_id', $accessory->id)->exists()) return response()->json(['message' => 'Tidak dimiliki'], 400);
        $user->accessories()->updateExistingPivot($user->accessories->pluck('id'), ['is_equipped' => false]);
        $user->accessories()->updateExistingPivot($accessory->id, ['is_equipped' => true]);
        return response()->json(['message' => 'Aksesoris dipakai']);
    }

    public function unequip(Request $request) {
        $user = $request->user();
        $user->accessories()->updateExistingPivot($user->accessories->pluck('id'), ['is_equipped' => false]);
        return response()->json(['message' => 'Aksesoris dilepas']);
    }
}