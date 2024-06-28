<?php
require '../BackEnd/vendor/autoload.php';
require 'sendEmail.php';

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$paymentMethodId = $data['paymentMethodId'];

$customer = \Stripe\Customer::create([
    'email' => $email,
    'payment_method' => $paymentMethodId,
    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
]);

$subscription = \Stripe\Subscription::create([
    'customer' => $customer->id,
    'items' => [['price' => 'prod_QNPIYLXQkZVOWJ']],
    'expand' => ['latest_invoice.payment_intent'],
]);

echo json_encode($subscription);
