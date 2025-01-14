
<?php
include "entete.php";
if(!empty($_GET['id'])){
    $sous_sous_sous_categorie=getSousSousSousCategorie($_GET['id']);
}
 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifSousSousSousCategorie.php" : "../model/ajoutSousSousSousCategorie.php"?>" method="post">
            <div class="case">
            <label for="libelle_sous_sous_sous_categorie">Libelle sous sous sous categorie</label>
            <input value= "<?= !empty($_GET['id']) ?$sous_sous_sous_categorie['sub_sub_subcategory_name'] : ""?>" type="text"  name="libelle_sous_sous_sous_categorie" id="libelle_sous_sous_sous_categorie" placeholder="Libelle_sous_sous_sous_categorie">
            <input value="<?= !empty($_GET['id']) ? $sous_sous_sous_categorie['id'] : ""?>" type="hidden"  name="id" id="id">
        </div>
        <div>
             <label for="category">Categorie (Obligatoire)</label>
            <select name="category" id="category">
			<option value="">Selectionnez la categorie</option>
            <?php
            $categories=getCategorie();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option <?= !empty($_GET['id'])?> value="<?=$value['id']?>"><?= $value['libelle_categorie'] ?></option>
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
});


    </script>
            
            
            
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
                <th id="modif">Modifier</th>
                <th>Libelle sous sous sous categorie</th>
                   <th>Libelle sous sous categorie</th>
                    <th>Libelle sous categorie</th>
                    <th>Libelle categorie</th>
                    
                    
                    
                </tr>
                <tr>
                    <?php
                    $sous_categories=getSousSousSousCategorie();
                    if(!empty($sous_categories) && is_array($sous_categories)){
                      foreach($sous_categories as $key=>$value)
                      {
                    ?>
                    <tr>
                    <td id="modiff"><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
                    <td><?=$value['sub_sub_subcategory_name']?></td>
                    <td><?=$value['sub_subcategory_name']?></td>
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