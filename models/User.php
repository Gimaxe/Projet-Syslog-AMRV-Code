<?php

require __DIR__ . '/../config.php';

class User
{
    private $pdo;

     public function __construct()
    {
        // Charge les configurations depuis le fichier config.php
        $config = require __DIR__ . '/../config.php'; 
        $siteDbConfig = $config['site_db']; // Accède à la section 'site_db'
        
        $dsn = "mysql:host={$siteDbConfig['host']};dbname={$siteDbConfig['db']};charset={$siteDbConfig['charset']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $siteDbConfig['user'], $siteDbConfig['pass'], $options);
        } catch (\PDOException $e) {
            error_log("Erreur connexion BDD site : " . $e->getMessage());
            throw new \Exception("Erreur connexion BDD : " . $e->getMessage());
        }
    }

    public function getByEmail($email)
    {
    	$stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    	$stmt->execute([$email]);
    	return $stmt->fetch();
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
