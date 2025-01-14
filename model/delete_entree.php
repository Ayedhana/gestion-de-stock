<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_commande'])) {
    $id_commande = $_POST['id_commande'];

    // Supprimer l'entrée de la table principale et ses relations (si nécessaire)
    try {
        $pdo->beginTransaction();

        // Supprimer les produits associés dans `entree_dons` si nécessaire
        $stmt = $pdo->prepare("DELETE FROM entree_dons WHERE id_entree = ?");
        $stmt->execute([$id_commande]);

        // Supprimer la commande dans la table `entrees`
        $stmt = $pdo->prepare("DELETE FROM entrees WHERE id = ?");
        $stmt->execute([$id_commande]);

        $pdo->commit();

        // Rediriger après suppression
        header("Location:../vue/entree.php?success=1");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    echo "Requête invalide.";
}
?>
