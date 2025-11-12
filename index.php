<?php
require_once __DIR__.'../config/connexionDB.php';
require_once __DIR__.'../controllers/HunterController.php';
require_once __DIR__.'../models/Hunter.php';


$Controller = new HunterController($pdo);
$hunters = $Controller->handleRequest();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD CHASSEURS</title>
    <style>
        span{
            cursor: pointer;
            font-weight: bold;
        }
        table{
            border: 1px solid black;
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        tr {
            background-color: #726060ff;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Gestion de chasseurs</h1>

    <div class="">
        <p>Triez suivant la date de creation : <span name="sort" value="created_at">⬆ Croissant </span>, <span name="sort" value="-created_at"> ⬇ Decroissant</span></p>
        <p>Triez suivant la date de modification <span name="sort" value="updated_at">⬆ Croissant</span>, <span name="sort" value="-updated_at"> ⬇ Decroissant</span></p>
    </div>
    <form method="POST">
        <input type="text" name="describ" placeholder="Nom" required>
        <input type="text" name="price" placeholder="Prix" required>
        <select name=" level">
            <option value="F">F</option>
            <option value="E">E</option>
            <option value="D">D</option>
            <option value="C">C</option>
            <option value="B">B</option>
            <option value="A">A</option>
            <option value="A+">A+</option>
            <option value="S" disabled>S</option>
        </select>
        <button type="submit" name="create">Ajouter</button>
    </form>
    
    <h2>Listes des chasseurs</h2>
  <form method="GET">
      <select name="search">
        <option value="">Tous</option>
        <option value="F">F</option>
        <option value="E">E</option>
        <option value="D">D</option>
        <option value="C">C</option>
        <option value="B">B</option>
        <option value="A">A</option>
        <option value="A+">A+</option>
        <option value="S" disabled>S</option>
    </select>
    <button type="submit">Filtrer</button>
  </form>
    
    <table>
        <tr>
            <td>ID</td>
            <td>Pseudo</td>
            <td>Prix</td>
            <td>Rang</td>
            <td>Actions</td>
            <td>Date de creation</td>
            <td>Date de modificaation</td>
        </tr>
        <?php if (!empty($hunters)): ?>
            <?php foreach ($hunters as $hunter): ?>
                <tr>
                    <td><?= htmlspecialchars($hunter['id']) ?></td>
                    <td><?= htmlspecialchars($hunter['describ']) ?></td>
                    <td><?= htmlspecialchars($hunter['price']) ?></td>
                    <td><?= htmlspecialchars($hunter['level']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $hunter['id'] ?>">Modifier</a>
                        <a href="index.php?delete=<?= $hunter['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chasseur ?');">Supprimer</a>
                    </td>
                    <td><?= $hunter['created_at'] ?></td>
                    <td><?= $hunter['updated_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>