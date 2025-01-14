
<?php
include "entete.php";

if(!empty($_GET['id'])){
    $donateur=getDonateur($_GET['id']);

}
 ?>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifDonateur.php" : "../model/ajoutDonateur.php"?>" method="post">
            <div class="case">
            <label for="nom_donateur">Nom et prénom</label>
            <input value="<?= !empty($_GET['id']) ? $donateur['nom_donateur'] : ""?>" type="text"  name="nom_donateur" id="nom_donateur" placeholder="الاسم و اللقب">
            <input value="<?= !empty($_GET['id']) ? $donateur['id'] : ""?>" type="hidden"  name="id" id="id">
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
        <div style="display:block" class="box">
        <form action="" method="get">
            <table class="mtable">
                <tr>
                    
                    <th>Nom de donneur</th>
                    
                </tr>
                <tr>
                    <td>
                    <input  type="text"  name="nom_donateur" id="nom_donateur" placeholder="nom_donateur">
                    </td>
                </tr>
            </table>

            <button type="submit">Chercher</button>
            <br>
            </form>
            <table class="mtable">
                <tr>
                    
                    <th>Modifier</th>
                    <th>Nom de donneur</th>
                </tr>
                <tr>
                    <?php
                    if(!empty($_GET)){
                        $donateurs=getDonateur(null,$_GET);
                    }else{
                        $donateurs=getDonateur();
                    }
                   
                    if(!empty($donateurs) && is_array($donateurs)){
                      foreach($donateurs as $key=>$value)
                      {
                    ?>
                    <tr>
                        <td><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
                        <td><?=$value['nom_donateur']?></td>
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