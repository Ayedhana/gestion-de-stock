<?php
include 'db_connection.php';
include_once 'fonctions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['produits'])&& isset($_POST['ar'])
&& isset($_POST['date_aide'])&&isset($_POST['num_enregister'])&& isset($_POST['id_donateur'])&& isset($_POST['programme']) ){
   $produits = $_POST['produits'];
   $ar=$_POST['ar'];
   $date_aide=$_POST['date_aide'];
   $num_enregister=$_POST['num_enregister'];
   $id_donateur=$_POST['id_donateur'];
   $programme=$_POST['programme'];
   
   

   // Insertion de la commande dans la table commandes
   $stmt = $pdo->prepare("INSERT INTO trie (ar,date_aide,num_enregister,id_donateur,programme) VALUES (?,?,?,?,?)");
   $stmt->execute([$ar,$date_aide,$num_enregister,$id_donateur,$programme]);
   $commandeId = $pdo->lastInsertId();

   // Insertion des produits commandés dans la table commande_produits
   foreach ($produits as $produit) {
       if (!empty($produit['produit']) && !empty($produit['quantite'])) {
        $produit_id = (int)$produit['produit'];
        $quantite = (int)$produit['quantite'];
           
           // Enregistrer le produit dans la commande
           $stmt = $pdo->prepare("INSERT INTO trie_dons (id_trie,id_don, quantite_don) VALUES (?, ?, ?)");
           $stmt->execute([$commandeId, $produit_id, $quantite]);
       }
   }

   $_SESSION['message']['text']="enregistre de trie effectuer avec succès";
   $_SESSION['message']['type']="success";
} else {
   echo "Aucun produit sélectionné pour la commande.";
}



header("Location:../vue/trie.php");
