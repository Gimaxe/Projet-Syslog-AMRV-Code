<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $mdp = $_POST['mdp'] ?? '';

            try {
                $userModel = new User();
                $userData = $userModel->getByEmail($email);

                if ($userData && password_verify($mdp, $userData['mdp'])) {
                    $_SESSION['user_id'] = $userData['id'];
                    header('Location: /dashboard');
                    exit;
                } else {
                    $messageFormulaire = '<span style="color:red;">Email ou mot de passe incorrect.</span>';
                }
            } catch (Exception $e) {
                $messageConnexion = "<span style='color:red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</span>";
            }
        }

        require __DIR__ . '/../views/login.php';
    }
}
