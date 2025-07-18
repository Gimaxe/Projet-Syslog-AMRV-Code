<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="/public/css/dashboard_v5.css">
  <link rel="icon" type="image/x-icon" href="/public/images/logo_logcatch_v2.png"> </head>
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

  </div>

  <div class="container">
    <div class="dashboard-box">
      <h2>Bienvenue sur Logcatch</h2>
      <p>Voici vos services :</p>
      <div class="button-grid">
        <a href="/instance?name=wordpress"><button>WordPress</button></a>
      </div>
    </div>
  </div>

<script src="/public/js/main.js"></script>
</body>
</html>
