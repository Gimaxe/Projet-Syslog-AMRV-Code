<?php
// controllers/InstanceController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Instance.php'; 

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

        if (empty($userData)) { 
            session_destroy();
            header('Location: /login');
            exit;
        }

        $logs = [];
        $distinctSysLogTags = []; // Nouvelle variable pour stocker les tags distincts
        $currentFilterTag = $_GET['tag'] ?? null; // Récupère le filtre depuis l'URL, ou null si non présent

        try {
            $instanceModel = new Instance(); 
            
            // Récupère les tags distincts pour le filtre
            $distinctSysLogTags = $instanceModel->getDistinctSysLogTags();

            // Récupère les logs avec le filtre approprié
            $logs = $instanceModel->getLatestLogs(50, $currentFilterTag); 
            
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des logs dans InstanceController : " . $e->getMessage());
            $logs = ["error" => "Impossible de charger les logs : Une erreur est survenue."];
            // Optionnel : Afficher l'erreur pour le débogage si besoin (comme avant)
            // echo "<pre style='background-color: #ff0000; color: #fff;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</pre>";
        }

        // Passe $userData, $logs, $distinctSysLogTags et $currentFilterTag à la vue
        require __DIR__ . '/../views/instance.php';
    }
}