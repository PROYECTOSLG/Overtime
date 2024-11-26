
        
        // Aquí definimos la constante isEditable basándonos en el rol del usuario
        const isEditable = (userRole === 'administrador') || (userRole === 'POWER PACK') || (userRole === 'GEN 3') || 
                            (userRole === 'NEXTEER') || (userRole === 'MFG CAMARA') || 
                            (userRole === 'CUSTOMER QA MOTOR') || (userRole === 'PROCESS QA MOTOR') || 
                            (userRole === 'SQA MOTOR') || (userRole === 'METROLOGIA') || 
                            (userRole === 'ALMACEN') || (userRole === 'MANTENIMIENTO') || 
                            (userRole === 'IT') || (userRole === 'EESH');
        
        function showEmployeeDetails(employee) {
            const loggedInUserName = '{{ Auth::user()->name }}';
            
            document.getElementById('modal-content').innerHTML = `
                <h2 class="text-xl font-bold mb-4">Employee Details: ${employee.NO_EMPLOYEE}</h2>
                <form id="employee-details-form" action="{{ route('employees.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="employee_id" value="${employee.id}">
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="NO_EMPLOYEE" class="block text-gray-700">No. Employee</label>
                            <input type="text" name="NO_EMPLOYEE" id="NO_EMPLOYEE" value="${employee.NO_EMPLOYEE || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="AREA" class="block text-gray-700">Area</label>
                            <input type="text" name="AREA" id="AREA" value="${employee.AREA || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="NAME" class="block text-gray-700">Name</label>
                            <input type="text" name="NAME" id="NAME" value="${employee.NAME || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="PHONE" class="block text-gray-700">Phone</label>
                            <input type="text" name="PHONE" id="PHONE" value="${employee.PHONE || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="REASON" class="block text-gray-700">Reason</label>
                            <input type="text" name="REASON" id="REASON" value="${employee.REASON || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="ROUTE" class="block text-gray-700">Route</label>
                            <select name="ROUTE" id="ROUTE" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                                <option value="">-- Selecciona una ruta --</option>
                                <option value="Centro" ${employee.ROUTE === 'Centro' ? 'selected' : ''}>Centro</option>
                                <option value="Oriente" ${employee.ROUTE === 'Oriente' ? 'selected' : ''}>Oriente</option>
                                <option value="Oriente 2" ${employee.ROUTE === 'Oriente 2' ? 'selected' : ''}>Oriente 2</option>
                                <option value="Tequisquiapan" ${employee.ROUTE === 'Tequisquiapan' ? 'selected' : ''}>Tequisquiapan</option>
                                <option value="Vista hermosa" ${employee.ROUTE === 'Vista hermosa' ? 'selected' : ''}>Vista hermosa</option>
                                <option value="Paso de mata" ${employee.ROUTE === 'Paso de mata' ? 'selected' : ''}>Paso de mata</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="DINING" class="block text-gray-700">Dining</label>
                            <select name="DINING" id="DINING" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                                <option value="">-- Selecciona un valor --</option>
                                <option value="Si" ${employee.DINING === 'Si' ? 'selected' : ''}>Si</option>
                                <option value="No" ${employee.DINING === 'No' ? 'selected' : ''}>No</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="SHIFT" class="block text-gray-700">Shift</label>
                            <select name="SHIFT" id="SHIFT" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                                <option value="">-- Selecciona un valor --</option>
                                <option value="Si" ${employee.SHIFT === 'Primero' ? 'selected' : ''}>Primero</option>
                                <option value="No" ${employee.SHIFT === 'Segundo' ? 'selected' : ''}>Segundo</option>
                                <option value="No" ${employee.SHIFT === 'Tercero' ? 'selected' : ''}>Tercero</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/2 px-2 mb-4">
                            <label for="TIMETABLE" class="block text-gray-700">Timetable</label>
                            <select name="TIMETABLE" id="TIMETABLE" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                                <option value="">-- Selecciona un valor --</option>
                                <option value="Si" ${employee.TIMETABLE === '7:00 - 15:00 hrs' ? 'selected' : ''}>7:00 - 15:00 hrs</option>
                                <option value="No" ${employee.TIMETABLE === '7:00 - 19:00 hrs' ? 'selected' : ''}>7:00 - 19:00 hrs</option>
                                <option value="No" ${employee.TIMETABLE === '15:00 - 23:00 hrs' ? 'selected' : ''}>15:00 - 23:00 hrs</option>
                                <option value="No" ${employee.TIMETABLE === '19:00 - 7:00 hrs' ? 'selected' : ''}>19:00 - 7:00 hrs</option>
                                <option value="No" ${employee.TIMETABLE === '23:00 - 7:00 hrs' ? 'selected' : ''}>23:00 - 7:00 hrs</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        ${isEditable ? `<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Modify</button>` : ''}
                        <button type="button" onclick="closeModal()" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel</button>
                    </div>
                    <div class="w-full sm:w-1/2 px-2 mb-4">
                        <label for="NO_EMPLOYEE" class="block text-gray-700">No. Employee</label>
                        <input type="text" name="NO_EMPLOYEE" id="NO_EMPLOYEE" value="${employee.NO_EMPLOYEE || ''}" class="w-full p-2 border border-gray-300 rounded-lg" ${!isEditable ? 'disabled' : ''}>
                    </div>
                </form>
            `;

            document.getElementById('modal').classList.remove('hidden');

        }

        
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }