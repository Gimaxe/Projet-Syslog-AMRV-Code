<?php

require __DIR__ . '/../config.php';

class User
{
    private $pdo;

    public function __construct()
    {
        global $config;
        
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
        } catch (\PDOException $e) {
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
