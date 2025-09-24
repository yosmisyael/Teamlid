<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $employees = Employee::query()->latest()->paginate(5);
        $inactiveEmployees = Employee::query()->onlyTrashed()->count();

        return view('employees.index', compact('employees', 'inactiveEmployees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string|max:50',
        ]);
        Employee::query()->create($request->all());
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $employee = Employee::query()->find($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $employee = Employee::query()->find($id);

        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nama_lengkap'
            => 'required|string|max:255',
            'email'
            => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat'
            => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'status'
            => 'required|string|max:50',
        ]);

        $employee = Employee::query()->findOrFail($id);

        $employee->update($request->only([
            'nama_lengkap',
            'email',
            'nomor_telepon',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'status',
        ]));

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $employee = Employee::query()->find($id);

        $employee->delete();

        return redirect()->route('employees.index');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $employee = Employee::query()->withTrashed()->find($id);

        if ($employee) {
            $employee->forceDelete();
            return redirect()->route('employees.index')
                ->with('success', 'Employee record has been permanently deleted.');
        }

        return redirect()->route('employees.index')
            ->with('error', 'Employee not found.');
    }
}
