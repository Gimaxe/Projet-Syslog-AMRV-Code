<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="/public/css/login_v20.css">
    <link rel="icon" type="image/x-icon" href="/public/images/logo_logcatch_favicon.png"> </head>

</head>
<body>
    <div class="header"></div>
    <div class="container">
        <div class="login-box"> <img src="/public/images/logo_logcatch_v2.png" alt="Logo Logcatch" class="login-logo">

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" required />
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required />
                </div>

                <input type="submit" value="Se connecter" />
            </form>
        <?php if (!empty($messageConnexion)): ?>
            <p class="<?= str_contains($messageConnexion, 'Erreur') ? 'message-error' : 'message-success' ?>">
            <?= $messageConnexion ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($messageFormulaire)): ?>
                <p class="<?= str_contains($messageFormulaire, 'incorrect') || str_contains($messageFormulaire, 'remplir') ? 'message-error' : 'message-success' ?>">
                <?= strip_tags($messageFormulaire) ?>
                </p>
        <?php endif; ?>
        </div> 
    </div>
</body>
</html>