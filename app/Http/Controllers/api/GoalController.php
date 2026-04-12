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
            'name' => 'required|string',
            'target_amount' => 'required|integer',
            'deadline' => 'nullable|date',
            'is_shared' => 'boolean',
        ]);
        $goal = $request->user()->goals()->create($request->all());
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