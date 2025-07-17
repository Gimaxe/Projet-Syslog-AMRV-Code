<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="/public/css/login.css">
</head>
<body>

  <div class="header">
    <div class="user-info">
        <span class="user-name"><?= htmlspecialchars($userData['prenom']) ?> <strong><?= htmlspecialchars($userData['nom']) ?></strong></span>
    <div class="avatar" style="background-image: url('/<?= htmlspecialchars($avatar) ?>');"></div>
</div>

  </div>

  <div class="container">
    <div class="dashboard-box">
      <h2>Bienvenue sur le dashboard</h2>
      <p>Voici vos options :</p>
      <div class="button-grid">
        <a href="/instance?name=wordpress"><button>WordPress</button></a>
      </div>
    </div>
  </div>

</body>
</html>
