<?php
require_once '../BackEnd/vendor/autoload.php';
require 'sendEmail.php';

include 'db.php';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

\Stripe\Stripe::setApiKey('sk_test_51PMPWY04hLVR8JEws7Pq0AxyUa289HwfgjeZDtzjyRxltMxIx03LIPLpU6kBJH9G5oxsRaizMvQAinjeGOIFvXPM000NV4FfZY');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'];
$paymentMethodId = $input['paymentMethodId'];

header('Content-Type: application/json');

try {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        $stmt = $dbh->prepare("SELECT id_USER FROM USER WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $stmt = $dbh->prepare("INSERT INTO USER (email, pass, role) VALUES (?, ?, ?)");
            $passwordHash = password_hash('defaultPassword', PASSWORD_BCRYPT); // Or generate a random password
            $stmt->execute([$email, $passwordHash, 'prof']);

            $userId = $dbh->lastInsertId();

            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'prof';
        } else {
            $userId = $user['id_USER'];
        }
    }

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
                'price' => 'price_1PWeTS04hLVR8JEwV8T0Ulh6',
            ],
        ],
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    sendWelcomeEmail($email);

    echo json_encode(['subscriptionId' => $subscription->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>