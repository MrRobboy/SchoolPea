<?php
require_once '../BackEnd/vendor/autoload.php';
require 'sendEmail.php';

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');


$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'];
$paymentMethodId = $input['payment_method'];

header('Content-Type: application/json');

try {
    $customer = \Stripe\Customer::create([
        'email' => $email,
        'payment_method' => $paymentMethodId,
        'invoice_settings' => [
            'default_payment_method' => $paymentMethodId,
        ],
    ]);

    $subscription = \Stripe\Subscription::create([
        'customer' => $customer->id,
        'items' => [
            [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'SchoolPea Subscription',
                    ],
                    'unit_amount' => 999,
                    'recurring' => [
                        'interval' => 'month',
                    ],
                ],
            ],
        ],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'SchoolPea Subscription',
                ],
                'unit_amount' => 999,
                'recurring' => [
                    'interval' => 'month',
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'success_url' => 'http://localhost/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/cancel.php',
        'customer' => $customer->id,
    ]);

    sendWelcomeEmail($email);

    echo json_encode(['id' => $session->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
