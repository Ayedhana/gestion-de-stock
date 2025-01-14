
<?php
include "entete.php";

if(!empty($_GET['id'])){
$don=getCategorie($_GET['id']);

}
 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifCategorie.php" : "../model/ajoutCategorie.php"?>" method="post">
            <div class="case">
            <label for="libelle_categorie">Libelle categorie</label>
            <input value="<?= !empty($_GET['id']) ? $don['libelle_categorie'] : ""?>" type="text"  name="libelle_categorie" id="libelle_categorie" placeholder="Libelle categorie">
            <input value="<?= !empty($_GET['id']) ? $don['id'] : ""?>" type="hidden"  name="id" id="id">
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
                    
                    <th>Libelle categorie</th>
                    
                </tr>
                <tr>
                    <?php
                    $dons=getCategorie();
                    if(!empty($dons) && is_array($dons)){
                      foreach($dons as $key=>$value)
                      {
                    ?>
                    <tr>
                        <td><?=$value['libelle_categorie']?></td>
                        <td><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
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