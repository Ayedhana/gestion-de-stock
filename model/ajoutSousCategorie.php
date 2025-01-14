<?php
include "connexion.php";
if( 
 !empty($_POST['libelle_sous_categorie'])&&
 !empty($_POST['category'])
 
 )
 {
$sql="INSERT INTO subcategory (subcategory_name, category_id ) values(?,?)" ;
$req=$connexion->prepare($sql);
$req->execute(array(
    $_POST['libelle_sous_categorie'],
    $_POST['category']
));
    if($req->rowCount()!=0)
    {
        $_SESSION['message']['text']="Les données sont enregistrées";
        $_SESSION['message']['type']="success";
     }
     
     
    else{
        $_SESSION['message']['text']="Les données ne sont pas enregistrées";
        $_SESSION['message']['type']="danger";
       }
 }
 else{
    $_SESSION['message']['text']="Un champs obligatoire non renseigné";
    $_SESSION['message']['type']="danger";
 }
header("Location:../vue/sous_categorie.php");