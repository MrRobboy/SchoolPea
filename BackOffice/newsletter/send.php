<?php
include '../includes/auth.php';
include '../includes/functions.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Envoi de la newsletter à tous les utilisateurs
    $users = getAll('users');
    foreach ($users as $user) {
        mail($user['email'], $subject, $message);
    }

    // Enregistrement de la newsletter dans l'historique
    if (create('newsletters', ['subject' => $subject, 'message' => $message, 'sent_at' => date('Y-m-d H:i:s')])) {
        header('Location: index.php');
        exit();
    } else {
        echo 'Erreur lors de l\'envoi de la newsletter';
    }
}
?>

<div class="container">
    <h1>Envoyer une Newsletter</h1>
    <form method="post">
        <label>Sujet:</label>
        <input type="text" name="subject" required>
        <label>Message:</label>
        <textarea name="message" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
