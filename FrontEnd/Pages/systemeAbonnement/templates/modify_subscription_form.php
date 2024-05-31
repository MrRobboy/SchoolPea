<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon abonnement - SchoolPea+</title>
</head>
<body>
    <h1>Modifier mon abonnement</h1>
    <form action="modify_subscription.php" method="post">
        <!-- Champs pour le nouveau plan d'abonnement, etc. -->
        <select name="new_plan_id">
            <option value="plan_id_1">Plan 1</option>
            <option value="plan_id_2">Plan 2</option>
            <!-- Autres options de plan d'abonnement -->
        </select><br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
