<?php
class PaymentService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    }

    public function createPaymentIntent(Appointment $appointment): array
    {
        $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => $appointment->service->price * 100,
            'currency' => 'brl',
            'metadata' => [
                'appointment_id' => $appointment->id
            ]
        ]);

        return [
            'clientSecret' => $paymentIntent->client_secret,
            'publicKey' => config('services.stripe.key')
        ];
    }
}
