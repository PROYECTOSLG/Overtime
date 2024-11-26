<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $area = Auth::user()->role;
        $employeesArea = Employees::where('AREA', $area)->get();
        
        //return response()->json($employeesArea);
        return view('dashboard', compact('employeesArea'));
    }


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'NO_EMPLOYEE' => 'required|string',
            'AREA' => 'required|string',
            'NAME' => 'required|string',
            'PHONE' => 'required|string',
            'REASON' => 'required|string',
            'ROUTE' => 'required|string',
            'DINING' => 'required|string',
            'SHIFT' => 'required|string',
            'TIMETABLE' => 'required|string',
            'NOTES' => 'nullable|string',
        ]);

        if ($request->has('employee_id')) {
            // Buscar el empleado por ID y actualizar
            $employee = Employees::findOrFail($request->employee_id);
            $employee->fill($validatedData);
            $employee->save();
            
            return redirect()->route('dashboard.show')->with('success', 'Datos actualizados con éxito.');
        } else {
            // Crear un nuevo registro
            Employees::create($validatedData);
            
            return redirect()->route('dashboard.show')->with('success', 'Empleado agregado con éxito.');
        }
    }

}
