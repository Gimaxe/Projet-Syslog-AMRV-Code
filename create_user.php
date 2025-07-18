<?php
require_once __DIR__ . '/models/User.php';

$nom     = 'MAMOUNA';
$prenom  = 'Anthony';
$email   = 'anthonymamouna@gmail.com';
$mdp     = 'Password123'; // mot de passe en clair
$avatar  = ''; // chemin relatif ou URL

echo "Début du script\n";

$hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
echo "Mot de passe hashé.\n";

try {
    $userModel = new User();
    $pdo = $userModel->getPDO();
    echo "Connexion à la base réussie.\n";

    $existing = $userModel->getByEmail($email);
    if ($existing) {
        echo "L'utilisateur avec l'email $email existe déjà.\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mdp, image_profil) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $hashedPassword, $avatar]);
        echo "Nouvel utilisateur inséré avec succès.\n";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

echo "Fin du script\n";
