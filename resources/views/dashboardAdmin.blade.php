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
                <div class="w-2/12 p-2 border border-gray-300 bg-blue-500 rounded-lg flex-col items-center text-center">
                    <h1 class="font-bold text-white">Fecha:</h1> 
                    <p class="text-white">{{ $availableDate }}</p>
                </div>
                <div class="w-4/12 p-2 ml-5">
                    <h2 class="text-2xl font-bold custom-font text-gray-700">Concentrado overtime</h2>
                </div>
                <div class="w-2/12 p-2 flex-col">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32">
                </div>
            </div>
        </div>
        <!-- PRIMER TURNO-->
        <div class="w-11/12 mt-5" id="first">
            <div class="flex justify-center items-center">
                <div class="w-full p-2 border border-gray-300 bg-blue-500 rounded-lg flex items-center justify-center">
                    <h1 class="font-bold text-white">Turno:</h1>
                    <p class="text-white ml-2">Primero</p>
                </div>
            </div>
            @if(count($firstShift) > 0)
                @php $counter = 0; @endphp <!-- Inicializar el contador -->
                @foreach($firstShift as $employee)
                <div class="flex flex-wrap justify-center items-stretch mt-5 border border-blue-500 {{ $counter % 2 == 0 ? 'bg-blue-200' : 'bg-blue-400' }}">
                    <!-- Primer bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">No. Empleado</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NO_EMPLOYEE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Nombre</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NAME'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Teléfono</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['PHONE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Área</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['AREA'] }}</p>
                        </div>
                    </div>
                    <!-- Segundo bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Horario</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['TIMETABLE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Motivo</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['REASON'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Ruta (transporte)</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['ROUTE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Comedor</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['DINING'] }}</p>
                        </div>
                    </div>
                </div>
                @php $counter++; @endphp <!-- Incrementar el contador -->
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="py-2 text-center">No hay registros disponibles.</td>
                </tr>
            @endif


        </div>

        <!-- SEGUNDO TURNO-->
        <div class="w-11/12 mt-10" id="second">
            <div class="flex justify-center items-center">
                <div class="w-full p-2 border border-gray-300 bg-green-500 rounded-lg flex items-center justify-center">
                    <h1 class="font-bold text-white">Turno:</h1>
                    <p class="text-white ml-2">Segundo</p>
                </div>
            </div>
            @if(count($secondShift) > 0)
                @php $counter = 0; @endphp <!-- Inicializar el contador -->
                @foreach($secondShift as $employee)
                <div class="flex flex-wrap justify-center items-stretch mt-5 border border-green-500 {{ $counter % 2 == 0 ? 'bg-green-200' : 'bg-green-400' }}">
                    <!-- Primer bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">No. Empleado</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NO_EMPLOYEE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Nombre</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NAME'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Teléfono</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['PHONE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Área</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['AREA'] }}</p>
                        </div>
                    </div>
                    <!-- Segundo bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Horario</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['TIMETABLE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Motivo</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['REASON'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Ruta (transporte)</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['ROUTE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Comedor</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['DINING'] }}</p>
                        </div>
                    </div>
                </div>
                @php $counter++; @endphp <!-- Incrementar el contador -->
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="py-2 text-center">No hay registros disponibles.</td>
                </tr>
            @endif


        </div>

        <!-- TERCER TURNO-->
        <div class="w-11/12 mt-5" id="third">
            <div class="flex justify-center items-center">
                <div class="w-full p-2 border border-gray-300 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <h1 class="font-bold text-white">Turno:</h1>
                    <p class="text-white ml-2">Tercero</p>
                </div>
            </div>
            @if(count($thirdShift) > 0)
                @php $counter = 0; @endphp <!-- Inicializar el contador -->
                @foreach($thirdShift as $employee)
                <div class="flex flex-wrap justify-center items-stretch mt-5 border border-yellow-500 {{ $counter % 2 == 0 ? 'bg-yellow-200' : 'bg-yellow-400' }}">
                    <!-- Primer bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">No. Empleado</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NO_EMPLOYEE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Nombre</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['NAME'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Teléfono</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['PHONE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Área</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['AREA'] }}</p>
                        </div>
                    </div>
                    <!-- Segundo bloque -->
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Horario</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['TIMETABLE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Motivo</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['REASON'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Ruta (transporte)</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['ROUTE'] }}</p>
                        </div>
                    </div>
                    <div class="w-3/12 p-2 border border-gray-300 rounded-lg flex flex-col items-center text-center flex-grow">
                        <h1 class="font-bold text-gray-700">Comedor</h1>
                        <div class="w-full bg-white rounded-lg">
                            <p class="text-gray-700">{{ $employee['DINING'] }}</p>
                        </div>
                    </div>
                </div>
                @php $counter++; @endphp <!-- Incrementar el contador -->
                @endforeach
            @else
                <tr>
                    <td colspan="9" class="py-2 text-center">No hay registros disponibles.</td>
                </tr>
            @endif
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
