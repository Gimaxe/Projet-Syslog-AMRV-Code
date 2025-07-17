<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom']) ?> !</h1>
    <p>Vous êtes connecté en tant que <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
    <a href="/logout">Se déconnecter</a>
</body>
</html>
