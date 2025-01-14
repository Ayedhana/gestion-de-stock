<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$database = "association";

$conn = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if (isset($_POST['cin'])) {
    $cin = $_POST['cin'];

    // Préparation et exécution de la requête SQL
    $stmt = $conn->prepare("SELECT nom_beneficiaire, delegation, adresse FROM beneficiaire WHERE cin = ?");
    $stmt->bind_param("s", $cin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si le client est trouvé, envoyer les coordonnées au format JSON
    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "nom_beneficiaire" => $client['nom_beneficiaire'],
            "delegation" => $client['delegation'],
            "adresse_beneficiaire" => $client['adresse'],
            
        ]);
    } else {
        // Si aucun client n'est trouvé, retourner un échec
        echo json_encode(["success" => false]);
    }

    
}


?>