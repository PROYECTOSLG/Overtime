<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\Overtimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $area = Auth::user()->role;
        
        if ($area === 'RH') {
            // Obtener la fecha más próxima a la actual
            $nearestDate = Overtimes::where('DATE', '>=', Carbon::now()->format('Y-m-d'))
                        ->orderBy('DATE')
                        ->pluck('DATE')
                        ->first();
    
            // Opción para permitir la selección de una fecha específica
            $date = $request->input('date', $nearestDate);
    
            // Consultas para cada turno
            $firstShift = Overtimes::where('DATE', $date)
                ->get()
                ->flatMap(function ($overtime) {
                    return collect(json_decode($overtime->EMPLOYEE_LIST, true))
                        ->where('SHIFT', 'Primero');
                })
                ->sortBy(['TIMETABLE', 'AREA']);
    
            $secondShift = Overtimes::where('DATE', $date)
                ->get()
                ->flatMap(function ($overtime) {
                    return collect(json_decode($overtime->EMPLOYEE_LIST, true))
                        ->where('SHIFT', 'Segundo');
                })
                ->sortBy(['TIMETABLE', 'AREA']);
    
            $thirdShift = Overtimes::where('DATE', $date)
                ->get()
                ->flatMap(function ($overtime) {
                    return collect(json_decode($overtime->EMPLOYEE_LIST, true))
                        ->where('SHIFT', 'Tercero');
                })
                ->sortBy(['TIMETABLE', 'AREA']);
            
            // Obtener todas las fechas disponibles para el selector de fechas
            $dates = Overtimes::orderBy('DATE')
            ->distinct()
            ->pluck('DATE');
        
    
            return view('dashboardAdmin', compact('firstShift', 'secondShift', 'thirdShift', 'dates', 'date'));


        } else {
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

    // Obtener los empleados seleccionados
    $employeesRegister = Employees::whereIn('id', $employeeIds)
                                  ->select('NO_EMPLOYEE', 'NAME', 'AREA', 'PHONE', 'REASON', 'ROUTE', 'DINING', 'SHIFT', 'TIMETABLE', 'NOTES')
                                  ->get();

    // Buscar si ya existe un registro con el mismo área y fecha
    $existingRecord = Overtimes::where('FK_BOSS', $area)->where('DATE', $date)->first();

    if ($existingRecord) {
        // Si existe, decodificar EMPLOYEE_LIST existente y agregar los nuevos empleados
        $existingEmployees = json_decode($existingRecord->EMPLOYEE_LIST, true);
        $newEmployees = $employeesRegister->toArray();
        $combinedEmployees = array_merge($existingEmployees, $newEmployees);

        // Actualizar el registro existente
        $existingRecord->EMPLOYEE_LIST = json_encode($combinedEmployees);
        $existingRecord->save();
    } else {
        // Si no existe, crear un nuevo registro
        $employeeRegistration = new Overtimes();
        $employeeRegistration->FK_BOSS = $area;
        $employeeRegistration->EMPLOYEE_LIST = json_encode($employeesRegister->toArray());
        $employeeRegistration->DATE = $date;
        $employeeRegistration->save();
    }

    return redirect()->route('dashboard.show')->with('success', 'Registro agregado con éxito.');
}


}
