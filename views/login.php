<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="/public/css/login.css"> <!-- corrigé si ton serveur est bien configuré -->
</head>
<body>
    <div class="header"></div>
    <div class="container">
        <div class="login-box">

            <form method="POST" action="">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required />

                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required />

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
