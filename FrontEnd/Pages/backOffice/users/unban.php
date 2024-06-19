<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

$id = $_GET['id'];

$user = getById('users', $id);

if (!$user) {
    echo 'Utilisateur non trouvé';
    exit();
}

if ($user['status'] !== 'banned') {
    echo 'L\'utilisateur n\'est pas banni';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (update('users', $id, ['status' => 'active'])) {
        // Envoi de l'email de déban
        $to = $user['email'];
        $subject = 'Votre compte a été rétabli';
        $message = 'Bonjour ' . $user['username'] . ",\n\nVotre compte a été rétabli. Vous pouvez maintenant vous reconnecter.\n\nCordialement,\nL'équipe de support.";
        $headers = 'From: support@votre-site.com' . "\r\n" .
                   'Reply-To: support@votre-site.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors du débannissement de l\'utilisateur';
    }
}
?>

<div class="container">
    <h1>Débannir Utilisateur</h1>
    <p>Êtes-vous sûr de vouloir débannir l'utilisateur <strong><?= $user['username'] ?></strong>?</p>
    <form method="post">
        <button type="submit">Oui</button>
        <a href="index.php">Non</a>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
