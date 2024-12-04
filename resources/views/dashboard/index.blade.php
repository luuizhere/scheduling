inde<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Agendamentos do Mês</h3>
                    <p class="text-3xl font-bold">{{ $metrics['appointments'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Receita do Mês</h3>
                    <p class="text-3xl font-bold">R$ {{ number_format($metrics['revenue'], 2, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Serviços Ativos</h3>
                    <p class="text-3xl font-bold">{{ $metrics['services'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Funcionários</h3>
                    <p class="text-3xl font-bold">{{ $metrics['employees'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
