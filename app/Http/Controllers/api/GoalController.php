<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Request $request) {
        return $request->user()->goals()->latest()->get();
    }

    public function store(Request $request) {
        $request->validate([
            'name'          => 'required|string',
            'target_amount' => 'required|integer|min:1',
            'deadline'      => 'nullable|date',
            'is_shared'     => 'nullable|boolean',
        ]);

        $goal = $request->user()->goals()->create([
            'name'             => $request->name,
            'target_amount'    => $request->target_amount,
            'collected_amount' => 0,
            'deadline'         => $request->deadline ?: null,
            'is_shared'        => $request->boolean('is_shared', false),
            'completed'        => false,
        ]);

        return response()->json($goal, 201);
    }

    public function update(Request $request, Goal $goal) {
        if ($goal->user_id !== auth()->id()) abort(403);
        $goal->update($request->only('collected_amount', 'completed'));
        return response()->json($goal);
    }

    public function destroy(Goal $goal) {
        if ($goal->user_id !== auth()->id()) abort(403);
        $goal->delete();
        return response()->json(['message' => 'Deleted']);
    }
}