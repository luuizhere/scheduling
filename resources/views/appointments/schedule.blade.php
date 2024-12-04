<x-app-layout>
    <div class="bg-white min-h-screen" style="background-color: {{ $company->secondary_color }}">
        <div class="max-w-7xl mx-auto py-12 px-4">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold" style="color: {{ $company->primary_color }}">
                        {{ $company->name }}
                    </h2>
                    <p class="text-gray-600">{{ $service->name }} - {{ $service->duration }}min</p>
                    <p class="font-semibold">R$ {{ number_format($service->price, 2, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Calendário -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" id="date" min="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                   onchange="loadTimeSlots()">
                        </div>

                        <div id="time-slots" class="grid grid-cols-4 gap-2">
                            <!-- Slots preenchidos via JavaScript -->
                        </div>
                    </div>

                    <!-- Profissionais -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Escolha o Profissional</h3>
                        <div class="space-y-4">
                            @foreach($employees as $employee)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="employee_id" value="{{ $employee->id }}"
                                           class="text-blue-600" onchange="loadTimeSlots()">
                                    <span class="ml-3">{{ $employee->user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form id="appointment-form" action="{{ route('appointments.store') }}" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="start_time" id="start_time">

                    <button type="submit"
                            class="w-full py-3 px-4 text-white rounded-lg font-medium disabled:opacity-50"
                            style="background-color: {{ $company->primary_color }}"
                            id="submit-btn" disabled>
                        Confirmar Agendamento
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const timeSlots = document.getElementById('time-slots');
        const startTimeInput = document.getElementById('start_time');
        const submitBtn = document.getElementById('submit-btn');

        async function loadTimeSlots() {
            const date = document.getElementById('date').value;
            const employeeId = document.querySelector('input[name="employee_id"]:checked')?.value;

            if (!date || !employeeId) return;

            const response = await fetch(`/api/available-slots?date=${date}&employee_id=${employeeId}&service_id=${{{ $service->id }}}`);
            const slots = await response.json();

            timeSlots.innerHTML = slots.map(slot => `
                <button onclick="selectTime('${slot}')"
                        class="p-2 text-sm border rounded hover:bg-gray-50 time-slot">
                    ${new Date(slot).toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'})}
                </button>
            `).join('');
        }

        function selectTime(time) {
            document.querySelectorAll('.time-slot').forEach(btn =>
                btn.classList.remove('bg-blue-600', 'text-white'));
            event.target.classList.add('bg-blue-600', 'text-white');

            startTimeInput.value = time;
            submitBtn.disabled = false;
        }
    </script>
</x-app-layout>
