<?php
include "connexion.php";
if(
!empty($_POST['num_ord']) &&
 !empty($_POST['nom_beneficiaire']) &&
 !empty($_POST['cin'])&& 
 !empty($_POST['id_delegation'])&&
 !empty($_POST['adresse'])&&
 !empty($_POST['programme'])
 )
 {
$sql="INSERT INTO beneficiaire(num_ord,nom_beneficiaire, cin, id_delegation, adresse,programme ) values(?,?, ?, ?, ?,?)" ;
$req=$connexion->prepare($sql);
$req->execute(array(
    $_POST['num_ord'],
    $_POST['nom_beneficiaire'],
    $_POST['cin'],
    $_POST['id_delegation'],
    $_POST['adresse'],
    $_POST['programme']
   
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
header("Location:../vue/beneficaire.php");