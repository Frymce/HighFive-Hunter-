<?php
require_once __DIR__.'/config/connexionDB.php';
require_once __DIR__.'/models/Hunter.php';

$hunterModel = new Hunter($pdo);
$hunter = null;
$id = null;

// 1. Vérifier si un ID est passé en GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: index.php'); // Rediriger si pas d'ID
    exit();
}

// 2. Gérer la soumission du formulaire de mise à jour (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $describ = $_POST['describ'];
    $price = (float)$_POST['price'];
    $level = $_POST['level'];

    $hunterModel->update($id, $describ, $price, $level);

    // Rediriger vers la page d'accueil après la mise à jour
    header('Location: index.php');
    exit();
}

// 3. Récupérer les données du chasseur pour pré-remplir le formulaire
$hunter = $hunterModel->findById($id);

// Si aucun chasseur n'est trouvé avec cet ID, rediriger
if (!$hunter) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Chasseur</title>
</head>
<body>
    <h1>Modifier le chasseur #<?= htmlspecialchars($hunter['id']) ?></h1>

    <form method="POST">
        <input type="text" name="describ" placeholder="Description" value="<?= htmlspecialchars($hunter['describ']) ?>" required>
        <input type="text" name="price" placeholder="Prix" value="<?= htmlspecialchars($hunter['price']) ?>" required>
        <select name="level">
            <?php $ranks = ['F', 'E', 'D', 'C', 'B', 'A', 'A+']; ?>
            <?php foreach ($ranks as $rank): ?>
                <option value="<?= $rank ?>" <?= ($hunter['level'] == $rank) ? 'selected' : '' ?>>
                    <?= $rank ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="update">Mettre à jour</button>
    </form>

    <a href="index.php">Retour à la liste</a>
</body>
</html>