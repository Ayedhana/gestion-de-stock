
<?php
include "entete.php";
if(!empty($_GET['id'])){
    $sous_sous_categorie=getSousSousCategorie($_GET['id']);
    
    }

 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifSousSousCategorie.php" : "../model/ajoutSousSousCategorie.php"?>" method="post">
            <div class="case">
            <label for="libelle_sous_sous_categorie">Libelle sous sous categorie</label>
            <input value= "<?= !empty($_GET['id']) ? $sous_sous_categorie['sub_subcategory_name'] : ""?>" type="text"  name="libelle_sous_sous_categorie" id="libelle_sous_sous_categorie" placeholder="Libelle_sous_sous_categorie">
            <input value="<?= !empty($_GET['id']) ? $sous_sous_categorie['id'] : ""?>" type="hidden"  name="id" id="id">
        </div>
        <div>
             <label for="categorie">Categorie (Obligatoire)</label>
            <select name="categorie" id="categorie">
			<option value="">Selectionnez la categorie</option>
            <?php
            $categories=getCategorie();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option value="<?=$value['id']?>"><?= $value['libelle_categorie'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
            </div>
            <div>
             <label for="sous_categorie">Sous categorie (Obligatoire)</label>
            <select name="sous_categorie" id="sous_categorie">
            <option value="">Selectionnez une sous categorie</option>
            </select>
            </div>
            <script>
            $(document).ready(function() {
	$('#categorie').on('change', function() {
			var categorie_id = this.value;
			console.log(categorie_id);
			$.ajax({
				url: "fetch_sous_categories.php",
				type: "POST",
				data: {
					categorie_id: categorie_id
				},
				cache: false,
				success: function(dataResult){
					$("#sous_categorie").html(dataResult);
				}
			});
            $('#sous_categorie').on('change', function() {
			var sous_categorie_id = this.value;
			console.log(sous_categorie_id);
			$.ajax({
				url: "fetch_sous_sous_categories.php",
				type: "POST",
				data: {
					sous_categorie_id: sous_categorie_id
				},
				cache: false,
				success: function(dataResult){
					$("#sous_sous_categorie").html(dataResult);
				}
			});
		
		
	});
		
        })})
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
                   <th>Modifier</th>
                   <th>Libelle sous sous categorie</th>
                   <th>Libelle sous categorie</th>
                   <th>Libelle categorie</th>
                    
                    
                    
                </tr>
                <tr>
                    <?php
                    $sous_categories=getSousSousCategorie();
                    if(!empty($sous_categories) && is_array($sous_categories)){
                      foreach($sous_categories as $key=>$value)
                      {
                    ?>
                    <tr>
                    <td><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
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