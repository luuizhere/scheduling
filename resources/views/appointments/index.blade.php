<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Meus Agendamentos</h2>

                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">{{ $appointment->service->name }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->employee->user->name }} -
                                            {{ $appointment->start_time->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs
                                        @if($appointment->status === 'confirmed')
                                            bg-green-100 text-green-800
                                        @elseif($appointment->status === 'cancelled')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
