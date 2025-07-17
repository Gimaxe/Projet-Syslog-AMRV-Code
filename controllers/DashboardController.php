<?php
require_once __DIR__ . '/../models/User.php';

class DashboardController
{
    public function show()
    {
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $userData = $userModel->getById($_SESSION['user_id']);

        if (!$userData) {
            // Si l'utilisateur n'existe pas en base
            session_destroy();
            header('Location: /login');
            exit;
        }

        // Prépare l'avatar
        $avatar = $userData['image_profil'] ?? '';
        if (empty($avatar) || !file_exists(__DIR__ . '/../' . $avatar)) {
            $avatar = 'public/images/avatars/avatar_defaut.png';
        }

        // Charge la vue avec les données utilisateur + avatar
        require __DIR__ . '/../views/dashboard.php';
    }
}
