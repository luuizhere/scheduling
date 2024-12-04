<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Empresas</h2>
                        <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Nova Empresa
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Logo</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Nome</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Status</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($companies as $company)
                                    <tr>
                                        <td class="px-6 py-4">
                                            @if($company->logo)
                                                <img src="{{ Storage::url($company->logo) }}" class="h-10 w-10 rounded-full">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $company->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $company->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $company->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button onclick="editCompany({{ $company->id }})" class="text-blue-600 hover:text-blue-900">
                                                Editar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nova Empresa -->
    <div id="companyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Nova Empresa</h3>
                <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                        <input type="file" name="logo" class="mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Cor Primária</label>
                        <input type="color" name="primary_color" class="mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Cor Secundária</label>
                        <input type="color" name="secondary_color" class="mt-1 block w-full">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="payment_required" class="rounded border-gray-300 text-blue-600">
                            <span class="ml-2 text-sm text-gray-600">Requer Pagamento</span>
                        </label>
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
            document.getElementById('companyModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('companyModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
