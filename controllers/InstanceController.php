<?php
require_once __DIR__ . '/../models/User.php';

class InstanceController
{
    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $userData = $userModel->getById($_SESSION['user_id']);

        if (!$userData) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        // Ici tu peux récupérer les logs réels de l'instance WordPress, pour l'exemple on fait statique
        $logs = [
            "2025-07-17 10:00:00 - Instance WordPress démarrée.",
            "2025-07-17 10:05:23 - Mise à jour du plugin SEO effectuée.",
            "2025-07-17 10:10:45 - Nouvel utilisateur créé : user123.",
            "2025-07-17 10:15:00 - Erreur 404 sur la page /about.",
            // etc.
        ];

        require __DIR__ . '/../views/instance.php';
    }
}
