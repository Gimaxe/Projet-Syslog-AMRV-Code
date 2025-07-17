<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Affiche les infos de debug (optionnel)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//var_dump($uri);
//var_dump($_SERVER['REQUEST_METHOD']);

// Appelle du contrôleur
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/DashboardController.php';


switch ($uri) {
    case '/':
    case '/login': // Gère à la fois GET et POST
        $controller = new UserController();
        $controller->login();
        break;
    
    case '/dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        require_once __DIR__ . '/controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->show();
        break;
    // ... au début, n'oublie pas d'inclure le contrôleur au besoin

    case '/instance':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        require_once __DIR__ . '/controllers/InstanceController.php';
        $controller = new InstanceController();
        $controller->show();
        break;

    case '/logout':
        session_destroy();
        //  Ne redirige plus, affiche juste un message de confirmation
        echo "<p style='text-align:center; font-weight:bold; color:green;'>Déconnexion réussie.</p>";
        echo "<p style='text-align:center;'><a href='/login'>Revenir à la page de connexion</a></p>";
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}

