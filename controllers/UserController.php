<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function login()
    {

        $messageConnexion = '';
        $messageFormulaire = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $mdp = $_POST['mdp'] ?? '';

            try {
                $userModel = new User();
                $messageConnexion = "Connexion à la base réussie.";

                if (!empty($email) && !empty($mdp)) {
                    $userData = $userModel->getByEmail($email);

                    if ($userData && password_verify($mdp, $userData['mot_de_passe'])) {
                        // Connexion réussie
                        $messageFormulaire = '<span style="color:green;">Connexion réussie !</span>';
                    } else {
                        // Identifiants invalides
                        $messageFormulaire = '<span style="color:red;">Email ou mot de passe incorrect.</span>';
                    }
                } else {
                    $messageFormulaire = '<span style="color:red;">Veuillez remplir tous les champs.</span>';
                }

            } catch (Exception $e) {
                $messageConnexion = "<span style='color:red;'>Erreur de connexion à la base : " . htmlspecialchars($e->getMessage()) . "</span>";
            }
        }

        require __DIR__ . '/../views/login.php';
    }
} 
