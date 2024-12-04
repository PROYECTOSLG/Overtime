<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/Overtime/public/images/lg.ico" />

    <style>
        .highlighted {
            background-color: #0C969C;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>
    <!-- ESPACIO DE TOP BAR-->
    <div class="flex justify-between items-center bg-white p-4 shadow-md">
        <div></div>
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none">
                <img src="{{ asset('images/logout.png') }}" alt="Logout" class="w-6 mr-2">
                Log out
            </button>
        </form>
    </div>

    <form method="GET" action="{{ route('dashboard.show') }}">
    
        <div class="text-center mt-4 ">
        <label for="date">Selecciona una fecha:</label>
            <select name="date" id="date" class="w-2/12 p-2 border border-gray-300 rounded-lg">
                @foreach($dates as $availableDate)
                    <option value="{{ $availableDate }}" {{ $availableDate === $date ? 'selected' : '' }}>{{ $availableDate }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700">Buscar</button>
        </div>
    </form>

    <div class="w-full flex flex-col items-center justify-center">
        <div class="w-11/12 flex justify-end">
            <button id="generate-pdf" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-700 mt-4 flex items-center">
                Generar PDF
                <img src="{{ asset('images/PDF.png') }}" alt="Print to PDF" class="w-6 ml-2">
            </button>
        </div>
    </div>

    

    <div class="w-full flex flex-col items-center justify-center " id="schedule">
        <div class="w-11/12 mt-10">
            <div class="flex justify-between items-center">
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Fecha:</h1> 
                    <p class="text-gray-700">{{ $availableDate }}</p>
                </div>
                <div class="w-4/12 p-2 ml-10">
                    <h2 class="text-4xl font-bold custom-font text-gray-700">Concentrado overtime</h2>
                </div>
                <div class="w-2/12 p-2 flex-col">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32">
                </div>
            </div>
        </div>

        <div class="w-11/12 mt-10">
            <div class="flex justify-between items-center">
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Comedor:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta centro:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta oriente:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta oriente 2:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta Tequisquiapan:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta Vista hermosa:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
                <div class="w-2/12 p-2 border border-gray-300 bg-gray-50 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-gray-700">Ruta Paso de mata:</h1> 
                    <p class="text-gray-700">N</p>
                </div>
            </div>
        </div>


        <!-- PRIMER TURNO-->
        <div class="w-11/12 mt-5" id="first">
            @if(count($firstShift1) > 0)
                <div class="flex-col justify-center items-center">
                    <div class="w-full p-2 border border-gray-300 bg-blue-500 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-white">Turno:</h1>
                        <p class="text-white ml-2">Primero</p>
                    </div>
                    <div class="w-full p-2 border border-gray-300 bg-blue-50 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-gray-700">Horario:</h1>
                        <p class="text-gray-700 ml-2">7:00 - 15:00 hrs</p>
                    </div>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white">No. empleado</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white">Nombre de empleado</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Ruta</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Notas</th>
                        </tr>
                    </thead>
                    <tbody id="ip-table-body">
                        @foreach($firstShift1 as $index => $employee)
                        <tr class="bg-blue-200 border-b border-white">
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NO_EMPLOYEE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NAME'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['PHONE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['REASON'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['ROUTE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['DINING'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['NOTES'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if(count($firstShift2) > 0)
                <div class="flex-col justify-center items-center">
                    <div class="w-full p-2 border border-gray-300 bg-blue-500 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-white">Turno:</h1>
                        <p class="text-white ml-2">Primero</p>
                    </div>
                    <div class="w-full p-2 border border-gray-300 bg-blue-50 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-gray-700">Horario:</h1>
                        <p class="text-gray-700 ml-2">7:00 - 19:00 hrs</p>
                    </div>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white">No. empleado</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white">Nombre de empleado</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Ruta</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                            <th class="py-2 rounded-lg bg-blue-500 border border-white text-white hidden sm:table-cell">Notas</th>
                        </tr>
                    </thead>
                    <tbody id="ip-table-body">
                        @foreach($firstShift2 as $index => $employee)
                        <tr class="bg-blue-200 border-b border-white">
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NO_EMPLOYEE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NAME'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['PHONE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['REASON'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['ROUTE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['DINING'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['NOTES'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- SEGUNDO TURNO-->
        <div class="w-11/12 mt-10" id="second">
            @if(count($secondShift1) > 0)
                <div class="flex-col justify-center items-center">
                    <div class="w-full p-2 border border-gray-300 bg-green-500 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-white">Turno:</h1>
                        <p class="text-white ml-2">Segundo</p>
                    </div>
                    <div class="w-full p-2 border border-gray-300 bg-green-50 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-gray-700">Horario:</h1>
                        <p class="text-gray-700  ml-2">15:00 - 23:00 hrs</p>
                    </div>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white">No. empleado</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white">Nombre de empleado</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Ruta</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Notas</th>
                        </tr>
                    </thead>
                    <tbody id="ip-table-body">
                        @foreach($secondShift1 as $index => $employee)
                        <tr class="bg-green-200 border-b border-white">
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NO_EMPLOYEE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NAME'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['PHONE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['REASON'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['ROUTE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['DINING'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['NOTES'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif


            @if(count($secondShift2) > 0)
                <div class="flex-col justify-center items-center">
                    <div class="w-full p-2 border border-gray-300 bg-green-500 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-white">Turno:</h1>
                        <p class="text-white ml-2">Segundo</p>
                    </div>
                    <div class="w-full p-2 border border-gray-300 bg-green-50 rounded-lg flex items-center justify-center">
                        <h1 class="font-bold text-gray-700">Horario:</h1>
                        <p class="text-gray-700  ml-2">19:00 - 7:00 hrs</p>
                    </div>
                </div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white">No. empleado</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white">Nombre de empleado</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Ruta</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                            <th class="py-2 rounded-lg bg-green-500 border border-white text-white hidden sm:table-cell">Notas</th>
                        </tr>
                    </thead>
                    <tbody id="ip-table-body">
                        @foreach($secondShift2 as $index => $employee)
                        <tr class="bg-green-200 border-b border-white">
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NO_EMPLOYEE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NAME'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['PHONE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['REASON'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['ROUTE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['DINING'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['NOTES'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>

        <!-- TERCER TURNO-->
        <div class="w-11/12 mt-10 mb-10" id="third">
            <div class="flex-col justify-center items-center">
                <div class="w-full p-2 border border-gray-300 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <h1 class="font-bold text-white">Turno:</h1>
                    <p class="text-white ml-2">Tercero</p>
                </div>
                <div class="w-full p-2 border border-gray-300 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <h1 class="font-bold text-gray-700">Horario:</h1>
                    <p class="text-gray-700  ml-2">23:00 - 7:00 hrs</p>
                </div>
            </div>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white">No. empleado</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white">Nombre de empleado</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white hidden sm:table-cell">Ruta</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                        <th class="py-2 rounded-lg bg-yellow-500 border border-white text-white hidden sm:table-cell">Notas</th>
                    </tr>
                </thead>
                <tbody id="ip-table-body">
                    @if(count($thirdShift) > 0)
                        @foreach($thirdShift as $index => $employee)
                        <tr class="bg-yellow-200 border-b border-white">
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NO_EMPLOYEE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg">{{ $employee['NAME'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['PHONE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['REASON'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['ROUTE'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['DINING'] }}</td>
                            <td class="py-2 text-center border-r rounded-lg hidden sm:table-cell">{{ $employee['NOTES'] }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="py-2 text-center rounded-lg border border-gray-200">No hay registros para este horario.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    document.getElementById('generate-pdf').addEventListener('click', function() {
        var element = document.getElementById('schedule');
        var opt = {
            margin: 1,
            filename: 'schedule.pdf',
            image: { type: 'jpeg', quality: 1.0 },
            html2canvas: { 
                scale: 2, // Ajusta la escala para una mejor calidad
                width: 1750 // Ancho en píxeles
            },
            jsPDF: { unit: 'px', format: [1240, 1754], orientation: 'landscape' }
        };
        html2pdf().from(element).set(opt).save();
    });
</script>


</body>
</html>
