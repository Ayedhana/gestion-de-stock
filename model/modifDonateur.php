<?php
include "connexion.php";
if(
 !empty($_POST['nom_donateur']) &&
 
 !empty($_POST['id'])
 )
 {
    $sql="UPDATE donateur SET nom_donateur=?  WHERE id=?" ;
    $req=$connexion->prepare($sql);
    $req->execute(array(
        $_POST['nom_donateur'],
        $_POST['id']

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
header("Location:../vue/donateur.php");