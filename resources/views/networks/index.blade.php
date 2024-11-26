<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPs de la Red {{ $network }}</title>
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
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold flex items-center justify-center mb-4">NETWORK {{ $network }}</h1>
        
        <div class="flex justify-center mb-4 space-x-2">
            <input type="radio" id="filter-all" name="filter" value="ALL" class="hidden peer" onclick="filterIps('ALL')" checked>
            <label for="filter-all" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">                           
                <div class="block text-center">ALL</div>
            </label>

            <input type="radio" id="filter-free" name="filter" value="FREE" class="hidden peer" onclick="filterIps('FREE')">
            <label for="filter-free" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">                           
                <div class="block text-center">FREE</div>
            </label>

            <input type="radio" id="filter-inuse" name="filter" value="IN-USE" class="hidden peer" onclick="filterIps('IN-USE')">
            <label for="filter-inuse" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">
                <div class="block text-center">IN USE</div>
            </label>

            <input type="radio" id="filter-requested" name="filter" value="REQUESTED" class="hidden peer" onclick="filterIps('REQUESTED')">
            <label for="filter-requested" class="inline-flex items-center justify-between w-28 p-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white">
                <div class="block text-center">REQUESTED</div>
            </label>
        </div>

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    @if ($network === '212')
                        <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">No. Employee</th>
                        <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Name</th>
                    @endif
                    <th class="py-2 bg-blue-500 border border-white text-white">IP</th>
                    <th class="py-2 bg-blue-500 border border-white text-white">Status</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Inno</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Project</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Area</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Process</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Type</th>
                    <th class="py-2 bg-blue-500 border border-white text-white hidden sm:table-cell">Person In Charge</th>
                </tr>
            </thead>
            <tbody id="ip-table-body">
                @if(count($ips) > 0)
                    @php
                        $requestedIps = $ips->filter(function($ip) {
                            return $ip->STATUS === 'REQUESTED';
                        });
                        $otherIps = $ips->filter(function($ip) {
                            return $ip->STATUS !== 'REQUESTED';
                        });
                        $allIps = $requestedIps->merge($otherIps);
                    @endphp
                    @foreach($allIps as $index => $ip)
                        <tr class="ip-row {{ str_replace(' ', '-', $ip->STATUS) }} cursor-pointer hover:bg-blue-200 {{ $ip->STATUS === 'REQUESTED' ? 'highlighted' : '' }} {{ $index % 2 == 0 ? 'bg-white' : 'bg-blue-100' }}" onclick='showIpDetails(@json($ip))'>
                            @if ($network === '212')
                                <td class="py-2 text-center hidden sm:table-cell">{{ $ip->NO_EMPLOYEE }}</td>
                                <td class="py-2 text-center hidden sm:table-cell">{{ $ip->NAME }}</td>
                            @endif
                            <td class="py-2 text-center">{{ $ip->IP }}</td>
                            <td class="py-2 text-center">{{ $ip->STATUS }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->INNO }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->PROJECT }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->AREA }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->PROCESS }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->TYPE }}</td>
                            <td class="py-2 text-center hidden sm:table-cell">{{ $ip->PERSON_IN_CHARGE }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ $network === '212' ? '10' : '8' }}" class="py-2 text-center">No hay registros disponibles.</td>
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
        function filterIps(status) {
            const rows = document.querySelectorAll('.ip-row');
            rows.forEach(row => {
                if (status === 'ALL' || row.classList.contains(status.replace(' ', '-'))) {
                    row.style.display = '';
                    if (row.classList.contains('REQUESTED')) {
                        row.classList.add('highlighted');
                    }
                } else {
                    row.style.display = 'none';
                    row.classList.remove('highlighted');
                }
            });

            const labels = document.querySelectorAll('.peer');
            labels.forEach(label => {
                if (label.value === status) {
                    label.nextElementSibling.classList.add('selected');
                } else {
                    label.nextElementSibling.classList.remove('selected');
                }
            });
        }

        // Set initial filter to ALL
        document.getElementById('filter-all').checked = true;
        filterIps('ALL');
    </script>

    <!-- Espacio del modal en index -->
    <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg">
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

    <!-- Generacion y accionar del modal para update de datos IP -->
    <script>
        const loggedInUserName = '{{ Auth::user()->name }}';
        const userRole = '{{ Auth::user()->role }}'; // Asumiendo que el rol del usuario está disponible como 'role'
        console.log(userRole);

        function showIpDetails(ip) {
            const network = "{{ $network }}";
            const thirdOctet = ip.IP.split('.')[2];
            const isEditable = (userRole === 'administrador') || (userRole === 'estandar' && ip.STATUS === 'FREE');
            const statusOptions = userRole === 'estandar'
                ? `<option value="FREE" ${ip.STATUS == 'FREE' ? 'selected' : ''}>FREE</option>
                <option value="REQUESTED" ${ip.STATUS == 'REQUESTED' ? 'selected' : ''}>REQUESTED</option>
                ${ip.STATUS == 'IN USE' ? `<option value="IN USE" selected>IN USE</option>` : ''}`
                : `<option value="FREE" ${ip.STATUS == 'FREE' ? 'selected' : ''}>FREE</option>
                <option value="IN USE" ${ip.STATUS == 'IN USE' ? 'selected' : ''}>IN USE</option>
                <option value="REQUESTED" ${ip.STATUS == 'REQUESTED' ? 'selected' : ''}>REQUESTED</option>`;

            document.getElementById('modal-content').innerHTML = `
                <h2 class="text-xl font-bold mb-4">IP Details: ${ip.IP}</h2>
                <form id="ip-details-form" action="{{ route('network.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="IP_ID" value="${ip.id}">
                    <input type="hidden" name="network" value="${network}">
                    <div class="flex flex-wrap -mx-2">
                        ${thirdOctet === '212' ? `
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="NO_EMPLOYEE" class="block text-gray-700">No. Employee</label>
                            <input type="text" name="NO_EMPLOYEE" id="NO_EMPLOYEE" value="${ip.NO_EMPLOYEE || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="NAME" class="block text-gray-700">Name</label>
                            <input type="text" name="NAME" id="NAME" value="${ip.NAME || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>` : ''}
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="STATUS" class="block text-gray-700">Status</label>
                            <select name="STATUS" id="STATUS" class="w-full p-2 border border-gray-300 rounded-lg" onchange="handleStatusChange()" ${!isEditable ? 'disabled' : ''}>
                                ${statusOptions}
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="INNO" class="block text-gray-700">Inno</label>
                            <input type="text" name="INNO" id="INNO" value="${ip.INNO || ''}" class="w-full p-2 border border-gray-300 rounded-lg uppercase" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="PROJECT" class="block text-gray-700">Project</label>
                            <input type="text" name="PROJECT" id="PROJECT" value="${ip.PROJECT || ''}" class="w-full p-2 border border-gray-300 rounded-lg uppercase" ${!isEditable ? 'disabled' : ''}>
                        </div>
                     <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="AREA" class="block text-gray-700">Area</label>
                            <input type="text" name="AREA" id="AREA" value="${ip.AREA || ''}" class="w-full p-2 border border-gray-300 rounded-lg uppercase" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="PROCESS" class="block text-gray-700">Process</label>
                            <input type="text" name="PROCESS" id="PROCESS" value="${ip.PROCESS || ''}" class="w-full p-2 border border-gray-300 rounded-lg uppercase" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="TYPE" class="block text-gray-700">Type</label>
                            <input type="text" name="TYPE" id="TYPE" value="${ip.TYPE || ''}" class="w-full p-2 border border-gray-300 rounded-lg uppercase" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="PERSON_IN_CHARGE" class="block text-gray-700">Person In Charge</label>
                            <input type="text" name="PERSON_IN_CHARGE" id="PERSON_IN_CHARGE" value="${loggedInUserName || ''}" class="w-full p-2 border border-gray-300 rounded-lg" readonly>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        ${isEditable ? `<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Modify</button>` : ''}
                        <button type="button" onclick="closeModal()" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel</button>
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
