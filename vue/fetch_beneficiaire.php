<?php
if (!empty($_POST['delegation_id'])) {
    $delegation_id = $_POST['delegation_id'];

    $conn = new mysqli("localhost", "root", "", "association");

    $query = "SELECT id, nom_beneficiaire FROM beneficiaire WHERE id_delegation = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delegation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Sélectionnez un beneficiaire</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['nom_beneficiaire'] . '</option>';
    }

   
    
}
?>
