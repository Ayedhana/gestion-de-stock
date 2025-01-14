<?php
include 'db_connection.php';
include_once 'fonctions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['produits'])&& isset($_POST['ar'])&& isset($_POST['numq'])
&& isset($_POST['date_aide'])&&isset($_POST['donateur'])&& isset($_POST['id_beneficiaire'])&& isset($_POST['id_delegation'])&& isset($_POST['programme'])) {
   $produits = $_POST['produits'];
   $ar=$_POST['ar'];
   $numq=$_POST['numq'];
   $date_aide=$_POST['date_aide'];
   $id_donateur=$_POST['donateur'];
   $programme=$_POST['programme'];
   $id_delegation=$_POST['id_delegation'];
   $id_beneficiaire=$_POST['id_beneficiaire'];
   
   $totalQuantite = 0;


   // Calcul de la quantité totale pour la commande
   foreach ($produits as $produit) {
       if (!empty($produit['produit']) && !empty($produit['quantite'])) {
           $totalQuantite += (int)$produit['quantite'];
       }
   }

   // Insertion de la commande dans la table commandes
   $stmt = $pdo->prepare("INSERT INTO sorties (ar,numq,date_aide,donateur,id_delegation,id_beneficiaire,programme,total_sortie) VALUES (?,?,?,?,?,?,?,?)");
   $stmt->execute([$ar,$numq,$date_aide,$id_donateur,$id_delegation,$id_beneficiaire,$programme,$totalQuantite]);
   $commandeId = $pdo->lastInsertId();

   // Insertion des produits commandés dans la table commande_produits
   foreach ($produits as $produit) {
       if (!empty($produit['produit']) && !empty($produit['quantite'])) {
           $produit_id = (int)$produit['produit'];
           $quantite = (int)$produit['quantite'];

           // Mettre à jour le stock du produit
           $stmt = $pdo->prepare("UPDATE don SET quantite_don = quantite_don - ? WHERE id = ?");
           $stmt->execute([$quantite, $produit_id]);



           // Enregistrer le produit dans la commande
           $stmt = $pdo->prepare("INSERT INTO sortie_dons (id_sortie,id_don, quantite_don) VALUES (?, ?, ?)");
           $stmt->execute([$commandeId, $produit_id, $quantite]);
       }
   }

   $_SESSION['message']['text']="Sortie effectuer avec succès";
   $_SESSION['message']['type']="success";
} else {
   echo "Aucun produit sélectionné pour la commande.";
}


header("Location:../vue/sortie.php");