<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    public function index(): View
{
    $expenses = Expense::latest('expense_date')->paginate(10);

    $totalExpenses = Expense::sum('amount');

    return view('expenses.index', compact(
        'expenses',
        'totalExpenses'
    ));
}

    public function create(): View
    {
        return view('expenses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['required', 'string', 'max:255'],
            'expense_date' => ['required', 'date'],
            'payment_method' => [
                'nullable',
                'in:Cash,Card,Mobile Money,Bank Transfer',
            ],
        ]);

        $validated['expense_number'] =
            'EXP-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5));

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    public function edit(Expense $expense): View
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['required', 'string', 'max:255'],
            'expense_date' => ['required', 'date'],
            'payment_method' => [
                'nullable',
                'in:Cash,Card,Mobile Money,Bank Transfer',
            ],
        ]);

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }
    public function destroy(Expense $expense): RedirectResponse
{
    $expense->delete();

    return redirect()
        ->route('expenses.index')
        ->with('success', 'Expense deleted successfully.');
}

}