
<?php
include "entete.php";

if(!empty($_GET['id'])){
    $beneficiaire=getBeneficaire($_GET['id']);

}
 ?>
<div class="home-content">
    <div class="overview-boxes" >
        <div class="box" id="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifBeneficaire.php" : "../model/ajoutBeneficaire.php"?>" method="post" id="form">
            <div class="case">
            <label for="num_ord">Numéro ordinal</label>
            <input value="<?= !empty($_GET['id']) ? $beneficiaire['num_ord'] : ""?>" type="number" name="num_ord" id="num_ord" >
            </div>
            <div class="case">
            <label for="nomPrenom">Nom et Prénom</label>
            <input value="<?= !empty($_GET['id']) ? $beneficiaire['nom_beneficiaire'] : ""?>" type="text"  name="nom_beneficiaire" id="nom_beneficiaire" placeholder="Nom et prénom">
            <input value="<?= !empty($_GET['id']) ? $beneficiaire['id'] : ""?>" type="hidden"  name="id" id="id">
        </div>
            
            <div class="case">
            <label for="cin">CIN</label>
            <input value="<?= !empty($_GET['id']) ? $beneficiaire['cin'] : ""?>" type="number" name="cin" id="cin" >
            </div>
           
            <td>
            <label for="Délégation">Délégation</label>
            <select name="id_delegation" id="id_delegation">
			<option value="">la délégation</option>
            <?php
            $categories=getDelegation();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option value="<?=$value['id']?>"><?= $value['nom_delegation'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
                   
            </td>
             <div>
             <label for="adresse">Adresse</label>
             <input value="<?= !empty($_GET['id']) ? $beneficiaire['adresse'] : ""?>" type="text"  name="adresse" id="adresse" placeholder="Adresse">
            </div>
            <div>
             <label for="programme">Programme</label>
             <input value="<?= !empty($_GET['id']) ? $beneficiaire['programme'] : ""?>" type="text"  name="programme" id="programme" placeholder="programme">
            </div>
            <br>
            
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
        <form action="" method="get" id="filtre">
            <table class="mtable">
                <tr>
                    
                    
                    <th>Nom de beneficiaire</th>
                    <th>CIN</th>
                    <th>Programma</th>
                    <th>Délegation</th>
                </tr>
                <tr>
                    <td>
                    <input  type="text"  name="nom_beneficiaire" id="nom_beneficiaie" placeholder="nom_beneficiaire">
                    </td>
                    <td>
                    <input  type="text"  name="cin" id="cin" placeholder="cin">
                    </td>
                    <td>
                    <input  type="text"  name="programme" id="programme" placeholder="programme">
                    </td>
                    <td>
            <select name="id_delegation" id="id_delegation">
			<option value="">la délégation</option>
            <?php
            $categories=getDelegation();
            if(!empty($categories)&& is_array($categories))
            {
                foreach($categories as $key => $value){        
            ?>
            <option <?= !empty($_GET['id'])&& $beneficaire['id_delegation']==$value['id'] ? "selected" : ""?> value="<?=$value['id']?>"><?= $value['nom_delegation'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
                   
            </td>
                         
                    </td>
                </tr>
            </table>

            <button type="submit" style="width:120px;height:30px ">Chercher</button>
            <br>
            </form>
            <a onclick="window.print()" id="imprimer" style="font-size:25px ;color:#9f33ff;padding-left:650px" ><i class='bx bxs-printer'></i></a>
            <h3 >Liste de bénéficiaire</h3>
            
            <table class="mtable" style="width:650px; margin-right:30px">
                <tr>
                    <th id="modif">Modifier</th>
                    <th>Numéro ordinal</th>
                    <th>Nom et prénom</th>
                    <th>Numéro CIN</th>
                    <th>Délégation</th>
                    <th>Adresse</th>
                    <th>Programme</th>
                </tr>
                <tr>
                    <?php

                    if(!empty($_GET)){
                        $beneficaires= getBeneficaire(null,$_GET);
                    }else{
                        $beneficaires= getBeneficaire();
                    }
                    if(!empty($beneficaires) && is_array($beneficaires)){
                      foreach($beneficaires as $key=>$value)
                      {
                    ?>
                    <tr>
                    <td id="modiff"><a href="?id=<?= $value['id']?>"><i class="bx bx-edit-alt"></i></a></td>
                    <td><?=$value['num_ord']?></td>
                    <td><?=$value['nom_beneficiaire']?></td>
                    <td><?=$value['cin']?></td>
                    <td><?=$value['nom_delegation']?></td>
                    <td><?=$value['adresse']?></td>
                    <td><?=$value['programme']?></td>
                    
                        
                        
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