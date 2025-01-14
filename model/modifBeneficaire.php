<?php
include "connexion.php";
if(
!empty($_POST['num_ord']) &&
 !empty($_POST['nom_beneficiaire']) &&
 !empty($_POST['cin'])&& 
 !empty($_POST['adresse'])&&
 !empty($_POST['programme'])&&
 !empty($_POST['id_delegation'])&&
 !empty($_POST['id'])
 )
 {
$sql="UPDATE beneficiaire SET num_ord=?,nom_beneficiaire=?, cin=?, id_delegation=?, adresse=?,programme=?  WHERE id=?" ;
$req=$connexion->prepare($sql);
$req->execute(array(
    $_POST['num_ord'],
    $_POST['nom_beneficiaire'],
    $_POST['cin'],
    $_POST['id_delegation'],
    $_POST['adresse'],
    $_POST['programme'],
    $_POST['id'],
    
    

));
    if($req->rowCount()!=0)
    {
        $_SESSION['message']['text']="المعطيات حينت بنجاح";
        $_SESSION['message']['type']="success";
     }
     
     
    else{
        $_SESSION['message']['text']="لم يقع التحيين";
        $_SESSION['message']['type']="warning";
       }
 }
 else{
    $_SESSION['message']['text']="المعطيات منقوصة";
    $_SESSION['message']['type']="danger";
 }
header("Location:../vue/beneficaire.php");