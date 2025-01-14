<?php
if (!empty($_POST['categorie_id'])) {
    $categorie_id = $_POST['categorie_id'];

    $conn = new mysqli("localhost", "root", "", "association");

    $query = "SELECT id, subcategory_name FROM subcategory WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categorie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Sélectionnez une sous-catégorie</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['subcategory_name'] . '</option>';
    }

   
    
}
?>
