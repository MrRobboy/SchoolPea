<?php
require 'vendor/autoload.php';
require 'sendEmail.php';

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'];
$paymentMethodId = $input['payment_method'];

header('Content-Type: application/json');

try {
    // Create a new customer
    $customer = \Stripe\Customer::create([
        'email' => $email,
        'payment_method' => $paymentMethodId,
        'invoice_settings' => [
            'default_payment_method' => $paymentMethodId,
        ],
    ]);

    // Create a subscription for the customer
    $subscription = \Stripe\Subscription::create([
        'customer' => $customer->id,
        'items' => [
            [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'SchoolPea Subscription',
                    ],
                    'unit_amount' => 999, // 9.99 EUR in cents
                    'recurring' => [
                        'interval' => 'month',
                    ],
                ],
            ],
        ],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    // Create a checkout session
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

    // Send a welcome email to the customer
    sendWelcomeEmail($email);

    // Return the session ID as a JSON response
    echo json_encode(['id' => $session->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
