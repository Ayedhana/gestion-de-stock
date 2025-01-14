<?php
include "connexion.php";

function getDon($id=null,$searchDATA=array()){
    if(!empty($id))
    {
        $sql= "SELECT nom_don,libelle_categorie,quantite_don,prix_unitaire,categorie_id,d.id
        FROM don AS d,categorie_don AS c WHERE d.categorie_id=c.id AND d.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }
    elseif (!empty($searchDATA)) {
       //var_dump($searchDATA);
       $search="";
       extract($searchDATA);
       if(!empty($nom_don))$search.="AND d.nom_don LIKE '%$nom_don%'";
       if(!empty($category))$search.="AND d.categorie_id LIKE $category";
       if(!empty($sub_category))$search.="AND d.sous_categorie_id LIKE $sub_category";
       

       $sql= "SELECT nom_don,libelle_categorie,quantite_don,prix_unitaire,categorie_id,d.id 
       FROM don AS d,categorie_don AS c WHERE d.categorie_id=c.id $search" ;
       $req=$GLOBALS['connexion']->prepare($sql);
       $req->execute();
       return $req->fetchAll();

       
    }else
    {
        $sql= "SELECT nom_don,libelle_categorie,quantite_don,prix_unitaire,categorie_id,d.id 
        FROM don AS d,categorie_don AS c WHERE d.categorie_id=c.id";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}

function getDelegation($id=null){
    if(!empty($id))
    {
        $sql= "SELECT * FROM delegation WHERE  id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT * FROM delegation  ";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}
function getCategorie($id=null){
    if(!empty($id))
    {
        $sql= "SELECT * FROM categorie_don WHERE  id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT * FROM categorie_don  ";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}
function getSousCategorie($id=null){
    if(!empty($id))
    {
        $sql= "SELECT subcategory_name, category_id, libelle_categorie,c.id, sc.id 
        FROM categorie_don AS c, subcategory AS sc WHERE 
          c.id =sc.category_id AND sc.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT subcategory_name, category_id ,libelle_categorie,c.id, sc.id FROM categorie_don AS c, subcategory AS sc WHERE 
         c.id =sc.category_id";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}
function getSousSousCategorie($id=null){
    if(!empty($id))
    {
        $sql= "SELECT  sub_subcategory_name, sub_category_id ,subcategory_name,
        category_id,libelle_categorie, c.id,sc.id, ssc.id
         FROM sub_subcategory AS ssc, subcategory AS sc ,categorie_don AS c WHERE 
         ssc.sub_category_id=sc.id AND sc.category_id=c.id AND ssc.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT  sub_subcategory_name, sub_category_id ,subcategory_name,
        category_id,libelle_categorie,c.id,sc.id, ssc.id
         FROM sub_subcategory AS ssc, subcategory AS sc ,categorie_don AS c WHERE 
         ssc.sub_category_id=sc.id AND sc.category_id=c.id ";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}
function getSousSousSousCategorie($id=null){
    if(!empty($id))
    {
        $sql= "SELECT  sub_sub_subcategory_name, sub_subcategory_id ,sub_subcategory_name,
        sub_category_id,subcategory_name,category_id, libelle_categorie ,sssc.id,sc.id, ssc.id, c.id FROM 
        sub_sub_subcategory AS sssc, sub_subcategory AS ssc, subcategory AS sc,categorie_don AS c WHERE 
         sssc.sub_subcategory_id=ssc.id AND ssc.sub_category_id=sc.id AND sc.category_id=c.id AND sssc.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT  sub_sub_subcategory_name, sub_subcategory_id ,sub_subcategory_name,
        sub_category_id,subcategory_name,category_id, libelle_categorie ,sssc.id,sc.id, ssc.id,c.id FROM
         sub_sub_subcategory AS sssc, sub_subcategory AS ssc, subcategory AS sc,categorie_don AS c WHERE 
         sssc.sub_subcategory_id=ssc.id AND ssc.sub_category_id=sc.id AND sc.category_id=c.id ";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}



function getDonateur($id=null,$searchDATA=array()){
    if(!empty($id))
    {
        $sql= "SELECT id,nom_donateur FROM donateur WHERE id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();
    }
    

    elseif (!empty($searchDATA)) {
        //var_dump($searchDATA);
        $search="";
        extract($searchDATA);
        if(!empty($nom_donateur))$search.="nom_donateur LIKE '%$nom_donateur%'";
        
        $sql= "SELECT id,nom_donateur FROM donateur $search";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }else
    {
        $sql= "SELECT id,nom_donateur FROM donateur";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}


function getBeneficaire($id=null,$searchDATA=array()){
    if(!empty($id))
    {
        $sql= "SELECT b.id,num_ord, nom_beneficiaire,cin, id_delegation,adresse,programme, nom_delegation
         FROM beneficiaire AS b, delegation AS d WHERE b.id_delegation=d.id  AND b.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();
    }
        elseif (!empty($searchDATA)) {
            //var_dump($searchDATA);
            $search="";
            extract($searchDATA);
            if(!empty($nom_beneficiaire))$search.="AND b.nom_beneficiaire LIKE '%$nom_beneficiaire%'";
            if(!empty($cin))$search.="AND b.cin LIKE '%$cin%'";
            if(!empty($id_delegation))$search.="AND b.id_delegation LIKE $id_delegation";
            if(!empty($programme))$search.="AND programme LIKE '%$programme%'";
            
     
            $sql= "SELECT b.id,num_ord, nom_beneficiaire,cin, id_delegation,adresse,programme, nom_delegation
         FROM beneficiaire AS b, delegation AS d WHERE b.id_delegation=d.id $search" ;
            $req=$GLOBALS['connexion']->prepare($sql);
            $req->execute();
            return $req->fetchAll();
     

    }else
    {
        $sql= "SELECT b.id,num_ord, nom_beneficiaire,cin, id_delegation,adresse,programme, nom_delegation
         FROM beneficiaire AS b, delegation AS d WHERE b.id_delegation=d.id";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}
function getTrie($id=null){
    if(!empty($id))
    {
        $sql= "SELECT * FROM trie WHERE id=?";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    }else
    {
        $sql= "SELECT * FROM trie";
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    }
   
}

function getStock(){
    
        $sql= "SELECT nom_don, quantite_don,prix_unitaire FROM don ORDER BY date_modification desc";
         
        $req=$GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

   
}



function getAllEntree(){
    
    $sql = "SELECT COUNT(id) AS nombre_id FROM entrees";
     
    $req=$GLOBALS['connexion']->prepare($sql);
    $req->execute();
    $result= $req->fetch();
    return $result['nombre_id'];


}
function getAllSortie(){
    
    $sql = "SELECT COUNT(id) AS nombre_id FROM sorties";
     
    $req=$GLOBALS['connexion']->prepare($sql);
    $req->execute();
    $result= $req->fetch();
    return $result['nombre_id'];
}
function getAllBeneficiaire(){
    
    $sql = "SELECT COUNT(id) AS nombre_id FROM beneficiaire";
     
    $req=$GLOBALS['connexion']->prepare($sql);
    $req->execute();
    $result= $req->fetch();
    return $result['nombre_id'];
}
function getAllDon(){
    
    $sql = "SELECT COUNT(id) AS nombre_id FROM don";
     
    $req=$GLOBALS['connexion']->prepare($sql);
    $req->execute();
    $result= $req->fetch();
    return $result['nombre_id'];
}

