<?php
include "connexion.php";
if(
    !empty($_POST['libelle_sous_sous_categorie'])&&
    !empty($_POST['sous_categorie'])&&
    !empty($_POST['categorie'])&&
    !empty($_POST['id'])
 )
 {
    $sql="UPDATE sub_subcategory SET sub_subcategory_name=?, sub_category_id=? WHERE id=?" ;
    $req=$connexion->prepare($sql);
    $req->execute(array(
        $_POST['libelle_sous_sous_categorie'],
        $_POST['sous_categorie'],
        $_POST['id']

));
    if($req->rowCount()!=0)
    {
        $_SESSION['message']['text']="Les données sont modifiées";
        $_SESSION['message']['type']="success";
     }
     
     
    else{
        $_SESSION['message']['text']="Les données ne sont pas modifiées";
        $_SESSION['message']['type']="warning";
       }
 }
 else{
    $_SESSION['message']['text']="Un ou des champs obligatoite(s) non renseigné(s)";
    $_SESSION['message']['type']="danger";
 }
header("Location:../vue/sous_sous_categorie.php");