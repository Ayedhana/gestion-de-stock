<?php
if (!empty($_POST['sous_sous_categorie_id'])) {
    $sous_categorie_id = $_POST['sous_sous_categorie_id'];

    $conn = new mysqli("localhost", "root", "", "association");

    $query = "SELECT id, sub_sub_subcategory_name FROM sub_sub_subcategory WHERE sub_subcategory_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sous_categorie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Sélectionnez une sous-sous-catégorie</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['sub_sub_subcategory_name'] . '</option>';
    }

   
   
}

?>
