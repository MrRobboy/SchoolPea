<?php
include '../includes/auth.php';
include '../includes/functions.php';
?>
<script>
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?") !== true) {
        window.location.href = document.referrer;
    }
</script>

<?php

if (delete('users', $id)) {
    header('Location: index.php');
    exit();
} else {
    echo 'Erreur lors de la suppression de l\'utilisateur';
}
?>