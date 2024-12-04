<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function processPayment(Appointment $appointment)
    {
        $paymentInfo = $this->paymentService->createPaymentIntent($appointment);

        return view('appointments.payment', [
            'appointment' => $appointment,
            'paymentInfo' => $paymentInfo
        ]);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $sig_header,
                config('services.stripe.webhook_secret')
            );

            if ($event->type === 'payment_intent.succeeded') {
                $appointmentId = $event->data->object->metadata->appointment_id;
                $appointment = Appointment::find($appointmentId);

                $appointment->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed'
                ]);

                event(new AppointmentConfirmed($appointment));
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
