<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
<body class="bg-gray-100">
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

    <!-- ESPACIO DEL CUERPO DE LA PAGINA-->
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold flex items-center justify-center mb-4"></h1>

        <div class="flex justify-center mb-4 space-x-2">
            <button type="button" onclick="showEmployeeDetails({})" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700"><img src="{{ asset('images/addUser.png') }}" alt="Add user"></button>
            <input type="radio" id="filter-all" name="filter" value="ALL" class="hidden peer" onclick="filterShifts('ALL')" checked>
            <label for="filter-all" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">                           
                <div class="block text-center">ALL</div>
            </label>

            <input type="radio" id="filter-Primero" name="filter" value="Primero" class="hidden peer" onclick="filterShifts('Primero')">
            <label for="filter-Primero" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">                           
                <div class="block text-center">Primero</div>
            </label>

            <input type="radio" id="filter-Segundo" name="filter" value="Segundo" class="hidden peer" onclick="filterShifts('Segundo')">
            <label for="filter-Segundo" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">
                <div class="block text-center">Segundo</div>
            </label>

            <input type="radio" id="filter-Tercero" name="filter" value="Tercero" class="hidden peer" onclick="filterShifts('Tercero')">
            <label for="filter-Tercero" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">
                <div class="block text-center">Tercero</div>
            </label>
            
        </div>

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">No. Empleado</th>
                    <th class="py-2 bg-blue-500 border border-white text-white">Area</th>
                    <th class="py-2 bg-blue-500 border border-white text-white">Nombre de empleado</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Telefono</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Motivo</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Ruta (transporte)</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Comedor</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Turno</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Horario</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Notas</th>
                </tr>
            </thead>
            <tbody id="ip-table-body">
                @if(count($employeesArea) > 0)
                    @foreach($employeesArea as $index => $employees)
                        <tr class="ip-row {{ str_replace(' ', '-', $employees->SHIFT) }} cursor-pointer hover:bg-blue-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-blue-100' }}" onclick='showEmployeeDetails(@json($employees))'>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->NO_EMPLOYEE }}</td>
                            <td class="py-2 text-center">{{ $employees->AREA }}</td>
                            <td class="py-2 text-center">{{ $employees->NAME }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->PHONE }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->REASON }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->ROUTE }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->DINING }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->SHIFT }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->TIMETABLE }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $employees->NOTES }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="py-2 text-center">No hay registros disponibles.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Estilo para los botones de filtro -->
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

        .selected {
            background-color: #3b82f6;
            color: white;
        }
    </style>

    <!-- SCRIPT para los botones de filtro -->
    <script>
        function filterShifts(shift) {
            const rows = document.querySelectorAll('.ip-row');
            rows.forEach(row => {
                if (shift === 'ALL' || row.classList.contains(shift)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            const labels = document.querySelectorAll('.peer');
            labels.forEach(label => {
                if (label.value === shift) {
                    label.nextElementSibling.classList.add('selected');
                } else {
                    label.nextElementSibling.classList.remove('selected');
                }
            });
        }

        // Set initial filter to ALL
        document.getElementById('filter-all').checked = true;
        filterShifts('ALL');
    </script>

    <!-- Espacio del modal en index -->
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg w-10/12">
            <div id="modal-content"></div>
        </div>
    </div>
    
    <!-- Modifica los campos en blanco cuando STATUS es FREE -->
    <script>
        function handleStatusChange() {
            const statusSelect = document.getElementById('STATUS');
            if (statusSelect.value === 'FREE') {
                const fieldsToClear = ['INNO', 'PROJECT', 'AREA', 'PROCESS', 'TYPE'];
                fieldsToClear.forEach(fieldId => {
                    document.getElementById(fieldId).value = '';
                });
            }
        }
    </script>
    
    <!-- Generacion y accionar del modal para update de datos -->
    <script>
        // Obtener el rol del usuario desde Laravel y pasar a JavaScript
        const userRole = @json(Auth::user()->role);
        
        // Aquí definimos la constante isEditable basándonos en el rol del usuario
        const isEditable = (userRole === 'administrador') || (userRole === 'POWER PACK') || (userRole === 'GEN 3') || 
                            (userRole === 'NEXTEER') || (userRole === 'MFG CAMARA') || 
                            (userRole === 'CUSTOMER QA MOTOR') || (userRole === 'PROCESS QA MOTOR') || 
                            (userRole === 'SQA MOTOR') || (userRole === 'METROLOGIA') || 
                            (userRole === 'ALMACEN') || (userRole === 'MANTENIMIENTO') || 
                            (userRole === 'IT') || (userRole === 'EESH');
        
        function showEmployeeDetails(employee = {}) {
            const userRole = '{{ Auth::user()->role }}'                            
            const loggedInUserName = '{{ Auth::user()->name }}'; 
            const isEditable = employee.hasOwnProperty('NO_EMPLOYEE'); // Manteniendo tu lógica original para determinar si es editable

            document.getElementById('modal-content').innerHTML = `
                <h2 class="text-xl font-bold mb-4">${isEditable ? `Employee Details: ${employee.NO_EMPLOYEE}` : 'Agregar Nuevo Usuario'}</h2>
                @if ($errors->any()) <div class="bg-red-500 text-white p-4 rounded-lg mb-4"> <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </div> @endif
                <form id="employee-details-form" action="{{ route('employees.update') }}" method="POST">
                    @csrf
                    ${isEditable ? `<input type="hidden" name="employee_id" value="${employee.id}">` : ''}
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="NO_EMPLOYEE" class="block text-gray-700">No. Empleado</label>
                            <input type="text" name="NO_EMPLOYEE" id="NO_EMPLOYEE" value="${employee.NO_EMPLOYEE || ''}" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="AREA" class="block text-gray-700">Area</label>
                            <input type="text" name="AREA_display" id="AREA_display" value="${userRole || ''}" class="w-full p-2 border border-gray-300 rounded-lg" disabled>
                            <input type="hidden" name="AREA" id="AREA" value="${userRole || ''}">
                        </div>

                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="NAME" class="block text-gray-700">Nombre de empleado</label>
                            <input type="text" name="NAME" id="NAME" value="${employee.NAME || ''}" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="PHONE" class="block text-gray-700">Telefono</label>
                            <input type="text" name="PHONE" id="PHONE" value="${employee.PHONE || ''}" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="REASON" class="block text-gray-700">Motivo</label>
                            <input type="text" name="REASON" id="REASON" value="${employee.REASON || ''}" class="w-full p-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4">
                            <label for="ROUTE" class="block text-gray-700">Ruta (transporte)</label>
                            <select name="ROUTE" id="ROUTE" class="w-full p-2 border border-gray-300 rounded-lg">  
                                <option value="">-- Selecciona una ruta --</option> 
                                <option value="Centro" ${employee.ROUTE === 'Centro' ? 'selected' : ''}>Centro</option> 
                                <option value="Oriente" ${employee.ROUTE === 'Oriente' ? 'selected' : ''}>Oriente</option> 
                                <option value="Oriente 2" ${employee.ROUTE === 'Oriente 2' ? 'selected' : ''}>Oriente 2</option> 
                                <option value="Tequisquiapan" ${employee.ROUTE === 'Tequisquiapan' ? 'selected' : ''}>Tequisquiapan</option> 
                                <option value="Vista hermosa" ${employee.ROUTE === 'Vista hermosa' ? 'selected' : ''}>Vista hermosa</option> 
                                <option value="Paso de mata" ${employee.ROUTE === 'Paso de mata' ? 'selected' : ''}>Paso de mata</option> 
                            </select> 
                        </div> 
                        <div class="w-full sm:w-1/3 px-2 mb-4"> 
                            <label for="DINING" class="block text-gray-700">Comedor</label> 
                            <select name="DINING" id="DINING" class="w-full p-2 border border-gray-300 rounded-lg"> 
                                <option value="">-- Selecciona un valor --</option> <option value="Si" ${employee.DINING === 'Si' ? 'selected' : ''}>Si</option> 
                                <option value="No" ${employee.DINING === 'No' ? 'selected' : ''}>No</option> 
                            </select> 
                        </div> 
                        <div class="w-full sm:w-1/3 px-2 mb-4"> 
                            <label for="SHIFT" class="block text-gray-700">Turno</label> 
                            <select name="SHIFT" id="SHIFT" class="w-full p-2 border border-gray-300 rounded-lg"> 
                                <option value="">-- Selecciona un valor --</option> 
                                <option value="Primero" ${employee.SHIFT === 'Primero' ? 'selected' : ''}>Primero</option> 
                                <option value="Segundo" ${employee.SHIFT === 'Segundo' ? 'selected' : ''}>Segundo</option> 
                                <option value="Tercero" ${employee.SHIFT === 'Tercero' ? 'selected' : ''}>Tercero</option> 
                            </select> 
                        </div> 
                        <div class="w-full sm:w-1/3 px-2 mb-4"> 
                            <label for="TIMETABLE" class="block text-gray-700">Horario</label> 
                            <select name="TIMETABLE" id="TIMETABLE" class="w-full p-2 border border-gray-300 rounded-lg"> 
                                <option value="">-- Selecciona un valor --</option> 
                                <option value="7:00 - 15:00 hrs" ${employee.TIMETABLE === '7:00 - 15:00 hrs' ? 'selected' : ''}>7:00 - 15:00 hrs</option> 
                                <option value="7:00 - 19:00 hrs" ${employee.TIMETABLE === '7:00 - 19:00 hrs' ? 'selected' : ''}>7:00 - 19:00 hrs</option> 
                                <option value="15:00 - 23:00 hrs" ${employee.TIMETABLE === '15:00 - 23:00 hrs' ? 'selected' : ''}>15:00 - 23:00 hrs</option> 
                                <option value="19:00 - 7:00 hrs" ${employee.TIMETABLE === '19:00 - 7:00 hrs' ? 'selected' : ''}>19:00 - 7:00 hrs</option> 
                                <option value="23:00 - 7:00 hrs" ${employee.TIMETABLE === '23:00 - 7:00 hrs' ? 'selected' : ''}>23:00 - 7:00 hrs</option> 
                            </select> 
                        </div> 
                        <div class="w-full sm:w-1/3 px-2 mb-4"> 
                            <label for="NOTES" class="block text-gray-700">Notas</label> 
                            <input type="text" name="NOTES" id="NOTES" value="${employee.NOTES || ''}" class="w-full p-2 border border-gray-300 rounded-lg"> 
                        </div> 
                    </div>
                    <div class="flex justify-center"> 
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">${isEditable ? 'Modificar' : 'Agregar'}</button>
                        <button type="button" onclick="closeModal()" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancelar</button> 
                    </div>
                </form>
            `;
            document.getElementById('modal').classList.remove('hidden');
        }



        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>


</body>
</html>
