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
    
            // Contadores globales
            $diningCountGlobal = 0;
            $routeCountsGlobal = [
                'Oriente' => 0,
                'Oriente 2' => 0,
                'Centro' => 0,
                'Tequisquiapan' => 0,
                'Vista hermosa' => 0,
                'Paso de mata' => 0,
            ];
    
            // Función para obtener los empleados por turno y horario
            function getOvertimeEmployees($date, $shift, $timetable = null) {
                $employees = Overtimes::where('DATE', $date)
                    ->get()
                    ->flatMap(function ($overtime) use ($shift, $timetable) {
                        return collect(json_decode($overtime->EMPLOYEE_LIST, true))
                            ->where('SHIFT', $shift)
                            ->when($timetable, function ($collection) use ($timetable) {
                                return $collection->where('TIMETABLE', $timetable);
                            });
                    })
                    ->sortBy(['AREA']);
    
                return $employees;
            }
    
            // Función para procesar los datos
            function processShiftData($employees, &$diningCountGlobal, &$routeCountsGlobal) {
                $diningCount = $employees->where('DINING', 'Si')->count();
                $diningCountGlobal += $diningCount;
    
                $routeCounts = [
                    'Oriente' => $employees->where('ROUTE', 'Oriente')->count(),
                    'Oriente 2' => $employees->where('ROUTE', 'Oriente 2')->count(),
                    'Centro' => $employees->where('ROUTE', 'Centro')->count(),
                    'Tequisquiapan' => $employees->where('ROUTE', 'Tequisquiapan')->count(),
                    'Vista hermosa' => $employees->where('ROUTE', 'Vista hermosa')->count(),
                    'Paso de mata' => $employees->where('ROUTE', 'Paso de mata')->count(),
                ];
    
                foreach ($routeCounts as $route => $count) {
                    $routeCountsGlobal[$route] += $count;
                }
    
                return [$diningCount, $routeCounts];
            }
    
            // Procesar cada turno
            $firstShift1 = getOvertimeEmployees($date, 'Primero', '7:00 - 15:00 hrs');
            list($firstShift1DiningCount, $firstShift1RouteCounts) = processShiftData($firstShift1, $diningCountGlobal, $routeCountsGlobal);
    
            $firstShift2 = getOvertimeEmployees($date, 'Primero', '7:00 - 19:00 hrs');
            list($firstShift2DiningCount, $firstShift2RouteCounts) = processShiftData($firstShift2, $diningCountGlobal, $routeCountsGlobal);
    
            $secondShift1 = getOvertimeEmployees($date, 'Segundo', '15:00 - 23:00 hrs');
            list($secondShift1DiningCount, $secondShift1RouteCounts) = processShiftData($secondShift1, $diningCountGlobal, $routeCountsGlobal);
    
            $secondShift2 = getOvertimeEmployees($date, 'Segundo', '19:00 - 7:00 hrs');
            list($secondShift2DiningCount, $secondShift2RouteCounts) = processShiftData($secondShift2, $diningCountGlobal, $routeCountsGlobal);
    
            $thirdShift = getOvertimeEmployees($date, 'Tercero');
            list($thirdShiftDiningCount, $thirdShiftRouteCounts) = processShiftData($thirdShift, $diningCountGlobal, $routeCountsGlobal);
    
            // Obtener todas las fechas disponibles para el selector de fechas
            $dates = Overtimes::orderBy('DATE')
                ->distinct()
                ->pluck('DATE');
    
            return view('dashboardAdmin', compact(
                'firstShift1', 'firstShift2', 'secondShift1', 'secondShift2', 'thirdShift', 
                'dates', 'date', 'diningCountGlobal', 'routeCountsGlobal', 
                'firstShift1DiningCount', 'firstShift1RouteCounts', 
                'firstShift2DiningCount', 'firstShift2RouteCounts', 
                'secondShift1DiningCount', 'secondShift1RouteCounts', 
                'secondShift2DiningCount', 'secondShift2RouteCounts', 
                'thirdShiftDiningCount', 'thirdShiftRouteCounts'
            ));
        } else {
            date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria correcta
            
            $employeesArea = Employees::where('AREA', $area)->get();
            if (is_null($employeesArea) || empty($employeesArea)) {
                $employeeCount = 1;
            } else {
                // Si es una colección y no un array, utilizamos métodos de colección
                $employeeCount = is_object($employeesArea) && method_exists($employeesArea, 'count') 
                    ? $employeesArea->count() 
                    : count($employeesArea);
            }
            

            $now = new \DateTime();
            $formattedNow = $now->format('Y-m-d H:i:s');
            $nextSunday = new \DateTime('next sunday');
            $limitTime = new \DateTime('friday 15:00'); // Establecer la hora límite a cada viernes 3pm
            $limitTimeFormatted = $limitTime->format('Y-m-d H:i:s');
            
            if ($now > $limitTime) {
                // Si es después de la hora límite, establecer el siguiente domingo al próximo
                $nextSunday->modify('+1 week');
            }

            $overtimes = Overtimes::where('FK_BOSS', $area)->get();
            $hasOvertimesFlag = $overtimes->isEmpty() ? 0 : 1;
            
            $nextSunday = $nextSunday->format('Y-m-d');
            //return $employeesArea;
            return view('dashboard', compact('employeesArea', 'nextSunday', 'limitTimeFormatted', 'hasOvertimesFlag', 'employeeCount'));            
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
    public function destroy($id)
    {
        $employee = Employees::findOrFail($id);
        $employee->delete();

        return redirect()->back()->with('success', 'Empleado eliminado correctamente.');
    }
    public function register(Request $request)
    {
        $area = Auth::user()->role;
        $employeeIds = $request->input('employee_ids');
        $date = $request->input('registration_date');

        // Definir el límite de tiempo (Jueves a las 7:08 PM)
        $limitTime = new \DateTime('friday 15:00', new \DateTimeZone('America/Mexico_City'));
        $now = new \DateTime('now', new \DateTimeZone('America/Mexico_City'));

        // Validar que el registro se haga antes del límite
        if ($now > $limitTime) {
            // Si el registro es después del límite, retornar con un error
            return redirect()->back()->withErrors(['error' => 'La fecha limite de registro fue a las 3:00pm, intenta con otra fecha disponible.']);
        }

        foreach ($employeeIds as $employeeId) {
            $shift = $request->input("SHIFT_$employeeId");
            $timetable = $request->input("TIMETABLE_$employeeId");

            // Validar que los valores de SHIFT y TIMETABLE no sean nulos
            if ($shift && $timetable) {
                Employees::where('id', $employeeId)
                    ->update([
                        'SHIFT' => $shift,
                        'TIMETABLE' => $timetable,
                    ]);
            } else {
                return redirect()->back()->with('error', 'Todos los empleados seleccionados deben tener un valor en "Turno" y "Horario" válido.');
            }
        }

        // Obtener los empleados seleccionados
        $employeesRegister = Employees::whereIn('id', $employeeIds)
                                    ->select('NO_EMPLOYEE', 'NAME', 'AREA', 'PHONE', 'REASON', 'ROUTE', 'DINING', 'SHIFT', 'TIMETABLE', 'NOTES')
                                    ->get();

        // Buscar si ya existe un registro con el mismo área y fecha
        $existingRecord = Overtimes::where('FK_BOSS', $area)->where('DATE', $date)->first();

        if ($existingRecord) {
            // Si existe, decodificar EMPLOYEE_LIST existente
            $existingEmployees = json_decode($existingRecord->EMPLOYEE_LIST, true);
            $newEmployees = $employeesRegister->toArray();

            // Verificar duplicados
            foreach ($newEmployees as $newEmployee) {
                foreach ($existingEmployees as $existingEmployee) {
                    if ($newEmployee['NO_EMPLOYEE'] == $existingEmployee['NO_EMPLOYEE']) {
                        // Empleado duplicado encontrado, cancelar registro y redirigir con error
                        return redirect()->back()->withErrors(['error' => 'Solo puede haber un empleado por día.']);
                    }
                }
            }

            // Si no hay duplicados, combinar las listas y actualizar el registro existente
            $combinedEmployees = array_merge($existingEmployees, $newEmployees);
            $existingRecord->EMPLOYEE_LIST = json_encode($combinedEmployees);
            $existingRecord->save();
        } else {
            // Si no existe un registro, crear uno nuevo
            Overtimes::create([
                'FK_BOSS' => $area,
                'DATE' => $date,
                'EMPLOYEE_LIST' => json_encode($employeesRegister->toArray()),
            ]);
        }

        return redirect()->back()->with('success', 'Empleados registrados y actualizados correctamente.');
    }

    

    public function overtimes(Request $request)
    {
        $area = Auth::user()->role;
        // Obtener la fecha más próxima a la actual
        $nearestDate = Overtimes::where('DATE', '>=', Carbon::now()->format('Y-m-d'))
            ->where('FK_BOSS', $area)
            ->orderBy('DATE')
            ->pluck('DATE')
            ->first();

    
        // Opción para permitir la selección de una fecha específica
        $date = $request->input('date', $nearestDate);
    
        // Contadores globales
        $diningCountGlobal = 0;
        $routeCountsGlobal = [
            'Oriente' => 0,
            'Oriente 2' => 0,
            'Centro' => 0,
            'Tequisquiapan' => 0,
            'Vista hermosa' => 0,
            'Paso de mata' => 0,
        ];
    
        // Función para obtener los empleados por turno y horario
        function getOvertimeEmployees($date, $shift = null, $timetable = null) {
            $area = Auth::user()->role;
            $employees = Overtimes::where('DATE', $date)->where('FK_BOSS', $area)
                ->get()
                ->flatMap(function ($overtime) use ($shift, $timetable) {
                    $collection = collect(json_decode($overtime->EMPLOYEE_LIST, true));
        
                    if ($shift) {
                        $collection = $collection->where('SHIFT', $shift);
                    }
        
                    if ($timetable) {
                        $collection = $collection->where('TIMETABLE', $timetable);
                    }
        
                    return $collection;
                })
                ->sortBy('AREA');
        
            return $employees;
        }
        
    
        // Función para procesar los datos
        function processShiftData($employees, &$diningCountGlobal, &$routeCountsGlobal) {
            $diningCount = $employees->where('DINING', 'Si')->count();
            $diningCountGlobal += $diningCount;
    
            $routeCounts = [
                'Oriente 2' => $employees->where('ROUTE', 'Oriente 2')->count(),
                'Centro' => $employees->where('ROUTE', 'Centro')->count(),
                'Tequisquiapan' => $employees->where('ROUTE', 'Tequisquiapan')->count(),
                'Vista hermosa' => $employees->where('ROUTE', 'Vista hermosa')->count(),
                'Paso de mata' => $employees->where('ROUTE', 'Paso de mata')->count(),
                'Oriente' => $employees->where('ROUTE', 'Oriente')->count(),
                
            ];
            foreach ($routeCounts as $route => $count) {
                $routeCountsGlobal[$route] += $count;
            }

            return [$diningCount, $routeCounts];
        }

        // Procesar cada turno
        $firstShift1 = getOvertimeEmployees($date, 'Primero', '7:00 - 15:00 hrs');
        list($firstShift1DiningCount, $firstShift1RouteCounts) = processShiftData($firstShift1, $diningCountGlobal, $routeCountsGlobal);
    
        $firstShift2 = getOvertimeEmployees($date, 'Primero', '7:00 - 19:00 hrs');
        list($firstShift2DiningCount, $firstShift2RouteCounts) = processShiftData($firstShift2, $diningCountGlobal, $routeCountsGlobal);
    
        $secondShift1 = getOvertimeEmployees($date, 'Segundo', '15:00 - 23:00 hrs');
        list($secondShift1DiningCount, $secondShift1RouteCounts) = processShiftData($secondShift1, $diningCountGlobal, $routeCountsGlobal);
    
        $secondShift2 = getOvertimeEmployees($date, 'Segundo', '19:00 - 7:00 hrs');
        list($secondShift2DiningCount, $secondShift2RouteCounts) = processShiftData($secondShift2, $diningCountGlobal, $routeCountsGlobal);
    
        $thirdShift = getOvertimeEmployees($date, 'Tercero');
        list($thirdShiftDiningCount, $thirdShiftRouteCounts) = processShiftData($thirdShift, $diningCountGlobal, $routeCountsGlobal);
    
        $employees = getOvertimeEmployees($date, null);
        // Obtener todas las fechas disponibles para el selector de fechas
        $dates = Overtimes::orderBy('DATE')
            ->distinct()
            ->pluck('DATE');
    

        //return $employees;
        return view('overtimesEmployees', compact(
            'firstShift1', 'firstShift2', 'secondShift1', 'secondShift2', 'thirdShift', 
            'dates', 'date', 'diningCountGlobal', 'routeCountsGlobal', 
            'firstShift1DiningCount', 'firstShift1RouteCounts', 
            'firstShift2DiningCount', 'firstShift2RouteCounts', 
            'secondShift1DiningCount', 'secondShift1RouteCounts', 
            'secondShift2DiningCount', 'secondShift2RouteCounts', 
            'thirdShiftDiningCount', 'thirdShiftRouteCounts', 'employees'
        ));
    
    }

}
