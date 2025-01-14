<?php
include "connexion.php";
if( 
 !empty($_POST['libelle_categorie'])
 
 )
 {
$sql="INSERT INTO categorie_don(libelle_categorie ) values(?)" ;
$req=$connexion->prepare($sql);
$req->execute(array(
    $_POST['libelle_categorie'],
));
    if($req->rowCount()!=0)
    {
        $_SESSION['message']['text']="المعطيات سجلت بنجاح";
        $_SESSION['message']['type']="success";
     }
     
     
    else{
        $_SESSION['message']['text']="خطأ في تسجيل المعطيات";
        $_SESSION['message']['type']="danger";
       }
 }
 else{
    $_SESSION['message']['text']="المعطيات منقوصة";
    $_SESSION['message']['type']="danger";
 }
header("Location:../vue/categorie.php");