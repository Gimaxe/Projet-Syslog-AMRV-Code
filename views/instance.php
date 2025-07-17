<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Instance - Logs</title>
  <link rel="stylesheet" href="/public/css/login.css" />
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
    </div>
  </div>

  <main class="main-container">
    <div class="logs-box">
      <?php foreach($logs as $log): ?>
        <p><?= htmlspecialchars($log) ?></p>
      <?php endforeach; ?>
    </div>
  </main>

  <div class="return-container">
    <button class="btn-return" onclick="window.location.href='/dashboard'">← Retour au dashboard</button>
  </div>
</body>
</html>
