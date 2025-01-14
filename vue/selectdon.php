<?php
$conn = new mysqli("localhost", "root", "", "association");

$categorie_id = !empty($_POST['category']) ? $_POST['category'] : null;
$sous_categorie_id = !empty($_POST['sub_category']) ? $_POST['sub_category'] : null;
$sous_sous_categorie_id = !empty($_POST['sub_sub_category']) ? $_POST['sub_sub_category'] : null;
$sous_sous_sous_categorie_id = !empty($_POST['sub_sub_sub_category']) ? $_POST['sub_sub_sub_category'] : null;

$query = "SELECT id, nom_don FROM don WHERE categorie_id = ?";
$params = [$categorie_id];

// Ajout des conditions supplémentaires si disponibles
if (!empty($sous_categorie_id)) {
    $query .= " AND sous_categorie_id = ?";
    $params[] = $sous_categorie_id;
}
if (!empty($sous_sous_categorie_id)) {
    $query .= " AND sous_sous_categorie_id = ?";
    $params[] = $sous_sous_categorie_id;
}
if (!empty($sous_sous_sous_categorie_id)) {
    $query .= " AND sous_sous_sous_categorie_id = ?";
    $params[] = $sous_sous_sous_categorie_id;
}

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat("i", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

echo '<option value="">Sélectionnez un don</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id'] . '">' . $row['nom_don'] . '</option>';
}

$stmt->close();
$conn->close();
?>
