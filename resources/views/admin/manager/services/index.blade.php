<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Serviços</h2>
                        <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Novo Serviço
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Nome</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Duração</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Preço</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Status</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($services as $service)
                                    <tr>
                                        <td class="px-6 py-4">{{ $service->name }}</td>
                                        <td class="px-6 py-4">{{ $service->duration }}min</td>
                                        <td class="px-6 py-4">R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $service->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $service->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="editService({{ $service->id }})" class="text-blue-600 hover:text-blue-900">
                                                Editar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Novo Serviço -->
    <div id="serviceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Novo Serviço</h3>
                <form action="{{ route('manager.services.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Duração (minutos)</label>
                        <input type="number" name="duration" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Preço</label>
                        <input type="number" name="price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mt-5 flex justify-end">
                        <button type="button" onclick="closeModal()" class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('serviceModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('serviceModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
