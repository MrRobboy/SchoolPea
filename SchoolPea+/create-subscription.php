<?php
require_once '../BackEnd/vendor/autoload.php';
require 'sendEmail.php';

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'];

if (!isset($input['payment_method'])) {
    http_response_code(400);
    echo json_encode(['error' => 'payment_method is required']);
    exit;
}

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
            ['price' => 'price_1PWeTS04hLVR8JEwV8T0Ulh6'], // Remplacez 'your_price_id' par l'ID de votre prix
        ],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    sendWelcomeEmail($email);

    echo json_encode(['id' => $subscription->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
