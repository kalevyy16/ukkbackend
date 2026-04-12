<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\SavingHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SavingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['amount' => 'required|integer|min:1', 'goal_id' => 'nullable|exists:goals,id']);
        $user = $request->user();
        $amount = $request->amount;
        $pet = $user->pet;

        $expGained = max(5, ceil($amount / 100000));
        $newExp = $pet->current_exp + $expGained;
        $newLevel = $pet->level;
        $tiers = ['Bronze','Silver','Gold','Platinum','Crown','Ace','Ace Master','Ace Dominator','Conqueror'];
        while ($newExp >= 50 && $newLevel < count($tiers) - 1) {
            $newExp -= 50;
            $newLevel++;
        }
        $pet->current_exp = $newExp;
        $pet->level = $newLevel;
        $pet->total_exp += $expGained;
        $pet->coin += max(1, ceil($amount / 100000));

        $today = Carbon::now();
        $last = $pet->last_save_date ? Carbon::parse($pet->last_save_date) : null;
        if (!$last || !$last->isSameDay($today)) {
            $pet->streak += 1;
        }
        $pet->last_save_date = $today;
        $pet->save();

        $goal = null;
        $purpose = $request->purpose ?? 'Tabungan umum';
        if ($request->goal_id) {
            $goal = Goal::find($request->goal_id);
            if ($goal && $goal->user_id == $user->id) {
                $goal->collected_amount += $amount;
                if ($goal->collected_amount >= $goal->target_amount) $goal->completed = true;
                $goal->save();
                $purpose = $goal->name;
            }
        }

        $history = $user->savingHistories()->create([
            'amount' => $amount,
            'goal_id' => $request->goal_id,
            'purpose' => $purpose,
            'saved_at' => $today,
        ]);

        return response()->json(['pet' => $pet, 'goal' => $goal, 'history' => $history]);
    }

    public function history(Request $request) {
        return $request->user()->savingHistories()->with('goal')->latest()->get();
    }

    public function destroy(SavingHistory $history) {
        if ($history->user_id !== auth()->id()) abort(403);
        $history->delete();
        return response()->json(['message' => 'Deleted']);
    }
}