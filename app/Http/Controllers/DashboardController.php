<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Overtimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        
        $area = Auth::user()->role;
        $employeesArea = Employees::where('AREA', $area)->get();
        $now = new \DateTime();
        $nextSunday = new \DateTime('next sunday');
        $limitTime = clone $nextSunday;
        $limitTime->modify('-36 hours');

        if ($now > $limitTime) {
            $nextSunday->modify('+1 week');
        }

        $nextSunday = $nextSunday->format('Y-m-d');
        
        return view('dashboard', compact('employeesArea', 'nextSunday'));
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

    public function register(Request $request)
    {
        $area = Auth::user()->role;
        $employeeIds = $request->input('employee_ids');
        $date = $request->input('registration_date');

        $employeesRegister = Employees::whereIn('id', $employeeIds)
                                    ->select('NO_EMPLOYEE', 'NAME', 'AREA', 'PHONE', 'REASON', 'ROUTE', 'DINING', 'SHIFT', 'TIMETABLE', 'NOTES') 
                                    ->get();

        
        $employeeRegistration = new Overtimes();
        $employeeRegistration->FK_BOSS = $area; 
        $employeeRegistration->EMPLOYEE_LIST = $employeesRegister; 
        $employeeRegistration->DATE = $date;

        $employeeRegistration->save();

        return redirect()->route('dashboard.show')->with('success', 'Registro agregado con éxito.');
    }

    public function delete($id)
{
    // Buscar el empleado por ID
    $employee = Employees::findOrFail($id);
    
    // Eliminar el empleado
    $employee->delete();
    
    // Redirigir con un mensaje de éxito
    return redirect()->route('employees.index')->with('success', 'Empleado eliminado correctamente');
}




}
