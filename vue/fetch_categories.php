<?php
$conn = new mysqli("localhost", "root", "", "association");

$query = "SELECT id, libelle_categorie FROM categorie_don";
$result = $conn->query($query);

echo '<option value="">Sélectionnez une catégorie</option>';
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id'] . '">' . $row['libelle_categorie'] . '</option>';
}

?>
