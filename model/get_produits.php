<?php
include 'db_connection.php';

header('Content-Type: application/json');

if (isset($_GET['categorie_id'])) {
    $stmt = $pdo->prepare("SELECT id, nom_don,quantite_don FROM don WHERE categorie_id = ?");
    $stmt->execute([$_GET['categorie_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif (isset($_GET['sous_categorie_id'])) {
    $stmt = $pdo->prepare("SELECT id, nom_don,quantite_don FROM don WHERE sous_categorie_id = ?");
    $stmt->execute([$_GET['sous_categorie_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif (isset($_GET['sous_sous_categorie_id'])) {
    $stmt = $pdo->prepare("SELECT id, nom_don,quantite_don FROM don WHERE sous_sous_categorie_id = ?");
    $stmt->execute([$_GET['sous_sous_categorie_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}
?>
