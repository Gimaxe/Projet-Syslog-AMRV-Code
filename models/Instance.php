<?php
// models/Instance.php

require_once __DIR__ . '/../config.php'; 

class Instance
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php'; 
        
        if (!isset($config['syslog_db'])) {
            error_log("Erreur de configuration : la clé 'syslog_db' est manquante dans config.php.");
            throw new \Exception("Erreur de configuration de la base de données des logs.");
        }
        $syslogDbConfig = $config['syslog_db']; 
        
        $dsn = "mysql:host={$syslogDbConfig['host']};dbname={$syslogDbConfig['db']};charset={$syslogDbConfig['charset']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $syslogDbConfig['user'], $syslogDbConfig['pass'], $options);
        } catch (\PDOException $e) {
            error_log("Erreur connexion BDD Syslog (Instance Model) : " . $e->getMessage());
            throw new \Exception("Échec de connexion à MariaDB : " . $e->getMessage());
        }
    }

    public function getLatestLogs($limit = 50, $syslogTagFilter = null)
    {
        $sql = "SELECT ReceivedAt, FromHost, SysLogTag, Message, Priority FROM SystemEvents";
        $whereClauses = [];
        $params = [];

        if ($syslogTagFilter !== null && $syslogTagFilter !== 'all') {
            // Utiliser LIKE pour correspondre au tag nettoyé ou au tag complet si l'utilisateur l'a choisi spécifiquement
            // Nous allons filtrer sur le tag brut dans la base de données, mais en utilisant LIKE pour trouver les correspondances
            $whereClauses[] = "SysLogTag LIKE :syslogTagFilter";
            // Si le filtre est "dockerd", on cherche "%dockerd%", si c'est "dockerd[123]", on cherche "%dockerd[123]%"
            $params[':syslogTagFilter'] = '%' . $syslogTagFilter . '%'; 
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= " ORDER BY ReceivedAt DESC LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); 
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }

        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Récupère et nettoie tous les SysLogTag distincts de la table SystemEvents.
     * Fusionne les tags ayant la même racine (ex: "dockerd[123]" et "dockerd[456]" deviennent "dockerd").
     *
     * @return array An array of cleaned, distinct SysLogTags.
     */
    public function getDistinctSysLogTags()
    {
        $stmt = $this->pdo->prepare("SELECT DISTINCT SysLogTag FROM SystemEvents WHERE SysLogTag IS NOT NULL AND SysLogTag != ''");
        $stmt->execute();
        $rawTags = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $cleanedTags = [];
        foreach ($rawTags as $tag) {
            // Nettoyer le tag : retirer ce qui est après '[' ou ':'
            $cleanedTag = $tag;
            if (strpos($cleanedTag, '[') !== false) {
                $cleanedTag = substr($cleanedTag, 0, strpos($cleanedTag, '['));
            }
            if (strpos($cleanedTag, ':') !== false) {
                $cleanedTag = substr($cleanedTag, 0, strpos($cleanedTag, ':'));
            }
            // Retirer les espaces en fin si besoin
            $cleanedTag = trim($cleanedTag);
            
            // Ajouter le tag nettoyé s'il n'est pas vide et n'existe pas déjà
            if (!empty($cleanedTag) && !in_array($cleanedTag, $cleanedTags)) {
                $cleanedTags[] = $cleanedTag;
            }
        }
        
        sort($cleanedTags); // Trie les tags nettoyés par ordre alphabétique
        return $cleanedTags;
    }
}