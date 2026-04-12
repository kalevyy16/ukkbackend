<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        return $request->user()->expenses()->latest()->get();
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|integer',
            'category' => 'required|in:Kebutuhan,Keinginan,Tabungan',
        ]);
        $expense = $request->user()->expenses()->create($request->all());
        return response()->json($expense, 201);
    }
    public function destroy(Expense $expense) {
        if ($expense->user_id !== auth()->id()) abort(403);
        $expense->delete();
        return response()->json(['message' => 'Deleted']);
    }
}