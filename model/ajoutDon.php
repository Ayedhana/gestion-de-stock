<?php
include "connexion.php";

$nom_don = !empty($_POST['nom_don']) ? $_POST['nom_don'] : null;
$category = !empty($_POST['category']) ? $_POST['category'] : null;
$sub_category = !empty($_POST['sub_category']) ? $_POST['sub_category'] : null;
$sub_sub_category = !empty($_POST['sub_sub_category']) ? $_POST['sub_sub_category'] : null;
$sub_sub_sub_category = !empty($_POST['sub_sub_sub_category']) ? $_POST['sub_sub_sub_category'] : null;
$quantite_don = !empty($_POST['quantite_don']) ? $_POST['quantite_don'] : null;
$prix_unitaire = !empty($_POST['prix_unitaire']) ? $_POST['prix_unitaire'] : null;


if(
 !empty($_POST['nom_don']) &&
 !empty($_POST['category'])
 
 )
 {
    $sql="INSERT INTO don(nom_don,categorie_id,sous_categorie_id,
    sous_sous_categorie_id,sous_sous_sous_categorie_id,quantite_don,prix_unitaire) values(?,?,?,?,?,?,?)" ;
    $req=$connexion->prepare($sql);
    $req->execute(array($nom_don,$category,$sub_category,$sub_sub_category,$sub_sub_sub_category,$quantite_don,$prix_unitaire
        
    ));
        if($req->rowCount()!=0)
        {
            $_SESSION['message']['text']="Les donnée sont ajoutées avec succès";
            $_SESSION['message']['type']="success";
         }
         
         
        else{
            $_SESSION['message']['text']="Un erreur s'est produit";
            $_SESSION['message']['type']="danger";
           }
     }
     else{
        $_SESSION['message']['text']="Un champ obligatoire ou plus non rensegné(s)";
        $_SESSION['message']['type']="danger";
     }

header("Location:../vue/don.php");