
<?php
include "entete.php";

if(!empty($_GET['id'])){
$sous_categorie=getSousCategorie($_GET['id']);

}
 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifSousCategorie.php" : "../model/ajoutSousCategorie.php"?>" method="post">
            <div class="case">
            <label for="libelle_sous_categorie">Libelle sous categorie</label>
            <input value="<?= !empty($_GET['id']) ? $sous_categorie['subcategory_name'] : ""?>" type="text"  name="libelle_sous_categorie" id="libelle_sous_categorie" placeholder="Libelle_sous_categorie">
            <input value="<?= !empty($_GET['id']) ? $sous_categorie['id'] : ""?>" type="hidden"  name="id" id="id">
        </div>
        <div>
             <label for="category">Categorie (Obligatoire)</label>
            <select name="category", id="category">
			<option value="">Selectionnez la categorie</option>
            <?php
            $categories=getCategorie();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option <?= !empty($_GET['id'])&&  $sous_categorie['category_id']==$value['id'] ? "selected" : ""?> value="<?=$value['id']?>"><?= $value['libelle_categorie'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
            </div>
            
            
                <button type="submit">Enregistrer</button>
                <?php
                if(!empty($_SESSION['message']['type'])){
                ?>
                <div class="alert <?= $_SESSION['message']['type']?>">
                    <?= $_SESSION['message']['text']?>
                </div>
                <?php
                }
                ?>
            
            
            </form>    
        </div>
        <div class="box">
            <table class="mtable">
                <tr>
                    
                    <th>Modifier</th>
                    <th>Libelle sous categorie</th>
                    <th>Libelle categorie</th>
                    
                    
                    
                </tr>
                <tr>
                    <?php
                    $sous_categories=getSousCategorie();
                    if(!empty($sous_categories) && is_array($sous_categories)){
                      foreach($sous_categories as $key=>$value)
                      {
                    ?>
                    <tr>
                    <td><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
                    <td><?=$value['subcategory_name']?></td>
                    <td><?=$value['libelle_categorie']?></td>   
                    
                        
                       
                    </tr>
                    <?php
                      }
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>

 </div>


 <?php
include "pied.php";
 ?>