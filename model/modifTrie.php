<?php
include "connexion.php";
if(
 !empty($_POST['ar']) &&
 !empty($_POST['date_aide'])&& 
 !empty($_POST['num_enregister'])&&
 !empty($_POST['donateur'])&&
 !empty($_POST['nom_don']) &&
 !empty($_POST['quantite_don']) &&
 !empty($_POST['programme']) &&
 !empty($_POST['numq']) &&
 !empty($_POST['id'])
 )
 {
$sql="UPDATE trie SET ar=?, date_aide=?, num_enregister=?, donateur=?, nom_don=?, quantite_don=?, programme=?, numq=? WHERE id=?" ;
$req=$connexion->prepare($sql);
$req->execute(array(
    $_POST['ar'],
    $_POST['date_aide'],
    $_POST['num_enregister'],
    $_POST['donateur'],
    $_POST['nom_don'],
    $_POST['quantite_don'],
    $_POST['programme'],
    $_POST['numq'],
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
header("Location:../vue/trie.php");