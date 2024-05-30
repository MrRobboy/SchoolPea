<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Logs</title>
    <link rel="stylesheet" type="text/css" href="../Styles/logs.css" />
</head>

<body>
    <div class="container">
        <h1>Visualisation des Logs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Logs </th>
                    <th>ID Utilisateur</th>
                    <th>Action</th>
                    <th>Date </th>
                </tr>
            </thead>
            <tbody>
                <?php include 'get_logs.php'; ?>
            </tbody>
        </table>
    </div>
</body>