<?php
require_once '../BackEnd/vendor/autoload.php';
require 'sendEmail.php';

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'];
$paymentMethodId = $input['paymentMethodId'];

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

    // Create a new subscription
    $subscription = \Stripe\Subscription::create([
        'customer' => $customer->id,
        'items' => [
            [
                'price' => 'prod_QNPIYLXQkZVOWJ', 
            ],
        ],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    // Send welcome email
    sendWelcomeEmail($email);

    // Send back the subscription ID to the client
    echo json_encode(['subscriptionId' => $subscription->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
