<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function show(Request $request) {
        return response()->json($request->user()->incomes);
    }
    public function update(Request $request) {
        $request->validate([
            'my_income' => 'required|integer',
            'partner_income' => 'required|integer',
        ]);
        $income = $request->user()->incomes;
        $income->update($request->only('my_income', 'partner_income'));
        return response()->json($income);
    }
}