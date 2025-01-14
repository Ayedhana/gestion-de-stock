<?php
include 'db_connection.php';

header('Content-Type: application/json');

if (isset($_GET['categorie_id'])) {
    $stmt = $pdo->prepare("SELECT id, subcategory_name FROM subcategory WHERE category_id = ?");
    $stmt->execute([$_GET['categorie_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif (isset($_GET['sous_categorie_id'])) {
    $stmt = $pdo->prepare("SELECT id, sub_subcategory_name FROM sub_subcategory WHERE sub_category_id = ?");
    $stmt->execute([$_GET['sous_categorie_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}
?>
