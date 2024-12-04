<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Receita Mensal</h3>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Serviços Mais Populares</h3>
                <div class="h-64">
                    <canvas id="servicesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueCtx = document.getElementById('revenueChart');
        const servicesCtx = document.getElementById('servicesChart');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenue->pluck('month')),
                datasets: [{
                    label: 'Receita Mensal',
                    data: @json($monthlyRevenue->pluck('total')),
                    borderColor: '{{ $whitelabel["colors"]["primary"] }}',
                }]
            }
        });

        new Chart(servicesCtx, {
            type: 'bar',
            data: {
                labels: @json($popularServices->pluck('name')),
                datasets: [{
                    label: 'Agendamentos',
                    data: @json($popularServices->pluck('appointments_count')),
                    backgroundColor: '{{ $whitelabel["colors"]["primary"] }}',
                }]
            }
        });
    </script>
    @endpush
</x-app-layout>
