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

    public function logout()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        // Ceci est crucial pour pouvoir manipuler la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Détruire toutes les variables de session
        $_SESSION = array();

        // Si vous utilisez aussi les cookies de session, détruisez-les
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: /login");
        exit();
    }
}
