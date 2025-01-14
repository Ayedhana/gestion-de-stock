
<?php

include "entete.php";

if(!empty($_GET['id'])){
   $don=getDon($_GET['id']);
}
 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box" id="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifDon.php" : "../model/ajoutDon.php"?>" method="post">
            <div class="case">
            <label for="nom_don">Nom de don (Obligatoire)</label>
            <input value="<?= !empty($_GET['id']) ?$don['nom_don'] : ""?>" type="text"  name="nom_don" id="nom_don" placeholder="Nom de don">
            <input value="<?= !empty($_GET['id']) ?$don['id'] : ""?>" type="hidden"  name="id" id="id">
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
            <option <?= !empty($_GET['id'])&& $don['categorie_id']==$value['id'] ? "selected" : ""?> value="<?=$value['id']?>"><?= $value['libelle_categorie'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
            </div>
			<div>
             <label for="sub_category">Sous categorie (Optionnel)</label>
            <select name="sub_category" id="sub_category">
            <option value="">Selectionnez une categorie</option>
            </select>
            </div>
			<div>
             <label for="sub_sub_category">Sous Sous categorie (Optionnel)</label>
            <select name="sub_sub_category" id="sub_sub_category">
            <option value="" selected="selected">Selectionnez une sous categorie</option>
            </select>
            </div>
            <div>
             <label for="sub_sub_sub_category">Sous Sous Sous categorie (Optionnel)</label>
            <select name="sub_sub_sub_category" id="sub_sub_sub_category">
            <option value="" selected="selected">Selectionnez une sous categorie</option>
            </select>
            </div>
			<script>
$(document).ready(function() {
	$('#category').on('change', function() {
			var categorie_id = this.value;
			
			$.ajax({
				url: "fetch_sous_categories.php",
				type: "POST",
				data: {
					categorie_id: categorie_id
				},
				cache: false,
				success: function(dataResult){
					$("#sub_category").html(dataResult);
				}
			});
		
		
	});

	$('#sub_category').on('change', function() {
			var sous_categorie_id = this.value;
			
			$.ajax({
				url: "fetch_sous_sous_categories.php",
				type: "POST",
				data: {
					sous_categorie_id: sous_categorie_id
				},
				cache: false,
				success: function(dataResult){
					$("#sub_sub_category").html(dataResult);
				}
			});
		
		
	});

    $('#sub_sub_category').on('change', function() {
			var sous_sous_categorie_id = this.value;
			console.log(sous_sous_categorie_id);
			$.ajax({
				url: "fetch_sous_sous_sous_categories.php",
				type: "POST",
				data: {
					sous_sous_categorie_id: sous_sous_categorie_id
				},
				cache: false,
				success: function(dataResult){
					$("#sub_sub_sub_category").html(dataResult);
				}
			});
		
		
	});
});
</script>
            
         <div>
         <label for="quantite_don">Quantité don</label>
        <input value="<?= !empty($_GET['id']) ?$don['quantite_don'] : ""?>" type="number"  name="quantite_don" id="quantite_don" placeholder="Quantité">
        </div>
        <div>
         <label for="prix_unitaire">Prix unitaire</label>
        <input value="<?= !empty($_GET['id']) ?$don['prix_unitaire'] : ""?>" type="number"  name="prix_unitaire" id="prix_unitaire" placeholder="prix_unitaire">
        </div>
        
        <br>
        <div>
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

        </div>    
                
            
            
            </form>    
        </div>
        <div style="display:block" class="box" >
            <form action="" method="get" id="filtre">
            <table class="mtable">
                <tr>
                    
                    
                    <th>Nom de don</th>
                    <th>Catégorie</th>
                    
                </tr>
                <tr>
                    <td>
                    <input  type="text"  name="nom_don" id="nom_don" placeholder="Nom de don">
                    </td>
                    <td>

                    
            <select name="category", id="category">
			<option value="">Selectionnez la categorie</option>
            <?php
            $categories=getCategorie();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option <?= !empty($_GET['id'])&& $don['categorie_id']==$value['id'] ? "selected" : ""?> value="<?=$value['id']?>"><?= $value['libelle_categorie'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
                         
                    </td>
                   
                         
                    </td>
                </tr>
            </table>

            <button type="submit">Chercher</button>
            <br>
            </form>
            <a onclick="window.print()" id="imprimer" style="font-size:25px ;color:#9f33ff;padding-left:600px" ><i class='bx bxs-printer'></i></a>
            <h3 >Liste des dons</h3>
            <br>
            <table class="mtable" style="width:650px">
                <tr>
                    
                   <th id="modif">Modifier</th>
                    <th>Nom de don</th>
                    <th>Catégorie</th>
                    <th>Qantité</th>
                    <th>Prix unitaire</th>
                    
                </tr>
                <tr>
                    <?php
                    if(!empty($_GET)){
                        $dons=getDon(null,$_GET);
                    }else{
                        $dons=getDon();
                    }
                   
                    if(!empty($dons) && is_array($dons)){
                      foreach($dons as $key=>$value)
                      {
                    ?>
                    <tr>
                    <td id="modiff"><a href="?id=<?=$value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
                    <td><?=$value['nom_don']?></td>
                    <td><?=$value['libelle_categorie']?></td>
                    <td><?=$value['quantite_don']?></td>
                    <td><?=$value['prix_unitaire']?>- DT</td>
                    
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
 