<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Instance - Logs</title>
    <link rel="stylesheet" href="/public/css/instance_v12.css" />
    <link rel="icon" type="image/x-icon" href="/public/images/logo_logcatch_v2.png">
</head>

<body>
    <div class="header">
        <?php
        $avatar = $userData['image_profil'] ?? '';
        if (empty($avatar) || !file_exists(__DIR__ . '/../' . ltrim($avatar, '/'))) {
            $avatar = 'public/images/avatars/avatar_defaut.png';
        }
        ?>
        <div class="user-info">
            <span class="user-name"><?= htmlspecialchars($userData['prenom']) ?> <strong><?= htmlspecialchars($userData['nom']) ?></strong></span>
            <div class="avatar" style="background-image: url('/<?= ltrim($avatar, '/') ?>');"></div>
            <div class="dropdown-menu" id="userDropdown">
                <a href="/logout" class="logout-button">Se déconnecter</a>
            </div>
        </div>
    </div>

    <div class="return-button-wrapper">
        <button class="btn-return" onclick="window.location.href='/dashboard'">← Retour au dashboard</button>
    </div>
    
    <div class="main-instance-content">

        <div class="filter-controls">
            <form action="/instance" method="GET">
                <label for="tag-filter">Filtrer par Tag :</label>
                <select name="tag" id="tag-filter">
                    <option value="all" <?= ($currentFilterTag === 'all' || $currentFilterTag === null) ? 'selected' : '' ?>>Tous les logs</option>
                    <?php if (isset($distinctSysLogTags) && is_array($distinctSysLogTags)): ?>
                        <?php foreach ($distinctSysLogTags as $tag): ?>
                            <option value="<?= htmlspecialchars($tag) ?>" <?= ($currentFilterTag === $tag) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tag) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="submit" class="btn-filter">Appliquer le filtre</button>
            </form>
        </div>
        <div class="instance-box">
            <?php
            if (isset($logs) && is_array($logs) && count($logs) > 0) {
                foreach ($logs as $log) {
                    $receivedAt = htmlspecialchars($log['ReceivedAt'] ?? 'N/A');
                    $message = htmlspecialchars($log['Message'] ?? 'N/A');
                    $priority = htmlspecialchars($log['Priority'] ?? 'N/A'); 

                    echo '<p>';
                    echo $receivedAt . ' / ' . $message . ' / ' . $priority;
                    echo '</p>';
                }
            } else {
                echo '<p>Aucun log trouvé pour ce filtre ou une erreur est survenue lors du chargement.</p>';
            }
            ?>
        </div>
    </div>

    <script src="/public/js/main.js"></script>
</body>
</html>