<x-app-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold mb-6">Pagamento do Agendamento</h2>

            <div class="mb-8">
                <div class="text-gray-600">
                    <p>Serviço: {{ $appointment->service->name }}</p>
                    <p>Valor: R$ {{ number_format($appointment->service->price, 2, ',', '.') }}</p>
                    <p>Data: {{ $appointment->start_time->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <form id="payment-form">
                <div id="payment-element" class="mb-6"></div>
                <button id="submit-button"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Pagar
                </button>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $paymentInfo["publicKey"] }}');
        const elements = stripe.elements({
            clientSecret: '{{ $paymentInfo["clientSecret"] }}'
        });
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const {error} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route("appointments.index") }}'
                }
            });

            if (error) {
                console.error(error);
            }
        });
    </script>
</x-app-layout>
