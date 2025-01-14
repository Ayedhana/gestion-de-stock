
<?php
include "entete.php";

 ?>
 <script>
        function chargerSousCategories(select, index) {
            const categorie_id = select.value;
            const produitContainer = document.getElementById('produits-container').querySelectorAll('.produit')[index];
            const sousCategorieContainer = produitContainer.querySelector('.sous-categorie-container');
            const sousSousCategorieContainer = produitContainer.querySelector('.sous-sous-categorie-container');
            const produitListeContainer = produitContainer.querySelector('.produit-container');
            
            sousCategorieContainer.innerHTML = "";
            sousSousCategorieContainer.innerHTML = "";
            produitListeContainer.innerHTML = "";

            if (categorie_id) {
                fetch(`../model/get_categories.php?categorie_id=${categorie_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let sousCategorieSelect = document.createElement('select');
                            sousCategorieSelect.name = `produits[${index}][sous_categorie]`;
                            sousCategorieSelect.onchange = () => chargerSousSousCategories(sousCategorieSelect, index);

                            sousCategorieSelect.innerHTML = `<option value="">--Sélectionner une sous-catégorie--</option>`;
                            data.forEach(sousCategorie => {
                                sousCategorieSelect.innerHTML += `<option value="${sousCategorie.id}">${sousCategorie.subcategory_name}</option>`;
                            });
                            sousCategorieContainer.appendChild(sousCategorieSelect);
                        } else {
                            chargerProduits(categorie_id, 'categorie', index);
                        }
                    })
                    .catch(error => console.error("Erreur lors de la récupération des sous-catégories :", error));
            }
        }

        function chargerSousSousCategories(select, index) {
            const sous_categorie_id = select.value;
            const produitContainer = document.getElementById('produits-container').querySelectorAll('.produit')[index];
            const sousSousCategorieContainer = produitContainer.querySelector('.sous-sous-categorie-container');
            const produitListeContainer = produitContainer.querySelector('.produit-container');

            sousSousCategorieContainer.innerHTML = "";
            produitListeContainer.innerHTML = "";

            if (sous_categorie_id) {
                fetch(`../model/get_categories.php?sous_categorie_id=${sous_categorie_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let sousSousCategorieSelect = document.createElement('select');
                            sousSousCategorieSelect.name = `produits[${index}][sous_sous_categorie]`;
                            sousSousCategorieSelect.onchange = () => chargerProduits(sousSousCategorieSelect.value, 'sous_sous_categorie', index);

                            sousSousCategorieSelect.innerHTML = `<option value="">--Sélectionner une sous-sous-catégorie--</option>`;
                            data.forEach(sousSousCategorie => {
                                sousSousCategorieSelect.innerHTML += `<option value="${sousSousCategorie.id}">${sousSousCategorie.sub_subcategory_name}</option>`;
                            });
                            sousSousCategorieContainer.appendChild(sousSousCategorieSelect);
                        } else {
                            chargerProduits(sous_categorie_id, 'sous_categorie', index);
                        }
                    })
                    .catch(error => console.error("Erreur lors de la récupération des sous-sous-catégories :", error));
            }
        }

        function chargerProduits(id, niveau, index) {
            const produitContainer = document.getElementById('produits-container').querySelectorAll('.produit')[index].querySelector('.produit-container');
            produitContainer.innerHTML = "";

            fetch(`../model/get_produits.php?${niveau}_id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let produitSelect = document.createElement('select');
                        produitSelect.name = `produits[${index}][produit]`;

                        produitSelect.innerHTML = `<option value="">--Sélectionner un produit--</option>`;
                        data.forEach(produit => {
                            produitSelect.innerHTML += `<option value="${produit.id}">${produit.nom_don}--${produit.quantite_don}</option>`;
                        });
                        produitContainer.appendChild(produitSelect);

                        let quantityInput = document.createElement('input');
                        quantityInput.type = 'number';
                        quantityInput.name = `produits[${index}][quantite]`;
                        quantityInput.placeholder = "Quantité";
                        quantityInput.min = 1;
                        produitContainer.appendChild(quantityInput);
                    }
                })
                .catch(error => console.error("Erreur lors de la récupération des produits :", error));
        }

        function ajouterProduit() {
            const produitsContainer = document.getElementById('produits-container');
            const index = produitsContainer.querySelectorAll('.produit').length;
            const produitDiv = document.createElement('div');
            produitDiv.className = 'produit';

            produitDiv.innerHTML = `
                <select name="produits[${index}][categorie]" onchange="chargerSousCategories(this, ${index})">
                    <option value="">--Sélectionner une catégorie--</option>
                    <?php
                    include '../model/db_connection.php';
                    $categories = $pdo->query("SELECT id, libelle_categorie FROM categorie_don")->fetchAll();
                    foreach ($categories as $categorie) {
                        echo "<option value='{$categorie['id']}'>{$categorie['libelle_categorie']}</option>";
                    }
                    ?>
                </select>
                <div class="sous-categorie-container"></div>
                <div class="sous-sous-categorie-container"></div>
                <div class="produit-container"></div>
            `;
            produitsContainer.appendChild(produitDiv);
        }
        function getbeneficiaire() {
        var delegation_id = $("#id_delegation").val();
        if (!delegation_id) return;

        $.ajax({
            url: "fetch_beneficiaire.php",
            type: "POST",
            data: { delegation_id: delegation_id },
            success: function(response) {
                $("#id_beneficiaire").html(response);
                
            }
        });
    }

    </script>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box" id="box">
            <form action="../model/ajoutSortie.php"  method="post">
            <div>
             <label for="ar">numéro ordinal</label>
             <input value="" type="number"  name="ar" id="ar" placeholder="numéro ordinal">
            </div>
            <div>
             <label for="numq">num quitance</label>
             <input value= "" type="number"  name="numq" id="numq" placeholder="numéro de quitance">
             <input value="<?= !empty($_GET['id']) ? $sortie['id'] : ""?>" type="hidden"  name="id" id="id">
            </div>
            <div>
             <label for="programme">Programme</label>
             <input value="" type="text"  name="programme" id="programme" placeholder="programme">
            </div>
            <div class="case">
            <label for="date_aide">Date d'aide</label>
            <input value="" type="date" name="date_aide" id="date_aide" >
            </div>
            <div>
             <label for="donateur">Le donateur</label>
             <input value="" type="text"  name="donateur" id="donateue" placeholder="">
            </div>
            <h5>Choisir le bénéficiaire</h5>
            <div>
             <label for="id_delegation"> La délégation</label>
            <select name="id_delegation" id="id_delegation" onchange="getbeneficiaire()">
			<option value="">Selectionnez la délégation</option>
            <?php
            $delegations=getDelegation();
            if(!empty($delegations)&& is_array($delegations))
            {
                foreach($delegations as $key => $value){        
            ?>
            <option value="<?=$value['id']?>"><?= $value['nom_delegation'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
            </div>
            
            <div>
            <label for="id_beneficiaire">Le nom de bénéficiaire</label>
            <select name="id_beneficiaire" id="id_beneficiaire">
			<option value="">Selectionnez le bénéficiaire</option>
            
            </select>
            </div>
            <h3>Ajouter don(s)</h3>
            <div id="produits-container"></div>
    <button type="button" onclick="ajouterProduit()" style="background-color:#7f33ff;color:white">Ajouter un don</button>
           <div>
           <button type="submit">Enregistrer la sortie </button>
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
        <div style="display:block"class="box">
        <form action="" method="get" id="filtre">
    <table class="mtable" style="border:0px" >
        <tr style="border:0px">
           
            <th style="border:0px">Date aide</th>
            <th style="border:0px"> Nom de don</th>
            <th style="border:0px"> Nom Beneficiaire</th>
            <th style="border:0px">CIN Beneficiaire</th>
            <th style="border:0px"> Delegation</th>
        </tr>
        <tr style="border:0px" >
            
            <td style="border:0px">
                <input type="date" name="date_aide" id="date_aide" value="<?= isset($_GET['date_aide']) ? $_GET['date_aide'] : '' ?>">
            </td>
            <td style="border:0px">
                <input type="text" name="nom_don" id="nom_don" value="<?= isset($_GET['nom_don']) ? $_GET['nom_don'] : '' ?>" placeholder="Nom de don">
            </td>
            <td style="border:0px">
                <input type="text" name="nom_beneficiaire" id="nom_beneficiaire" value="<?= isset($_GET['nom_beneficiaire']) ? $_GET['nom_beneficiaire'] : '' ?>"placeholder="Nom beneficiaire">
            </td>
            <td style="border:0px">
                <input type="text" name="cin_beneficiaire" id="cin_beneficiaire" value="<?= isset($_GET['cin_beneficiaire']) ? $_GET['cin_beneficiaire'] : '' ?>" placeholder="CIN">
            </td>
            <td style="border:0px">
                <select name="id_delegation" id="id_delegation">
                    <option value="">Sélectionnez la délégation </option>
                    <?php
                    $donateurs = getDelegation();
                    foreach($donateurs as $donateur) { 
                        $selected = (isset($_GET['id_delegation']) && $_GET['id_delegation'] == $donateur['id']) ? "selected" : "";
                        echo "<option value='{$donateur['id']}' $selected>{$donateur['nom_delegation']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Chercher</button>
</form>

            <a onclick="window.print()" id="imprimer" style="font-size:30px ;color:#9f33ff;margin-left:700px" ><i class='bx bxs-printer'></i></a>
            <h3 >Liste des sorties</h3>
            <br>
            <?php
include '../model/db_connection.php';

// Préparer la base de la requête
$sql = "
    SELECT 
        s.id,
        s.ar, 
        s.numq, 
        s.date_aide, 
        s.id_beneficiaire, 
        b.nom_beneficiaire, 
        b.cin, 
        s.programme, 
        s.donateur,
        s.id_delegation, 
        d.nom_delegation, 
        s.total_sortie
    FROM 
        sorties AS s
    JOIN 
        beneficiaire AS b 
        ON s.id_beneficiaire = b.id
    JOIN 
        delegation AS d 
        ON s.id_delegation = d.id
    WHERE 1
";

// Initialiser $params comme un tableau vide
$params = [];

// Vérification et ajout des filtres
if (!empty($_GET['date_aide'])) {
    $sql .= " AND s.date_aide = :date_aide";
    $params[':date_aide'] = $_GET['date_aide'];
}

if (!empty($_GET['id_beneficiaire'])) {
    $sql .= " AND s.id_beneficiaire = :id_beneficiaire";
    $params[':id_beneficiaire'] = $_GET['id_beneficiaire'];
}
if (!empty($_GET['cin'])) {
    $sql .= " AND b.cin = :cin";
    $params[':cin'] = $_GET['cin'];
}
if (!empty($_GET['nom_beneficiaire'])) {
    $sql .= " AND b.nom_beneficiaire = :nom_beneficiaire";
    $params[':nom_beneficiaire'] = $_GET['nom_beneficiaire'];
}
if (!empty($_GET['id_delegation'])) {
    $sql .= " AND s.id_delegation = :id_delegation";
    $params[':id_delegation'] = $_GET['id_delegation'];
}

// Ajouter l'ordre par date
$sql .= " ORDER BY s.date_aide DESC";

// Exécuter la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

// Récupérer les résultats
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($commandes) > 0) {
    echo "<table>";
    echo "<tr>
            <th>Numéro Ordinal</th>
            <th>Num de Quitt</th>
             <th>Program</th>
            <th>Date de Sortie</th> 
            <th>Donneur</th> 
            <th>Nom de Benefi</th>
             <th>CIN de Benefi</th>
              <th>Delegation</th>
            <th>Produits </th>
            <th>Quantt Totale</th>
            <th id='sup'>Supp</th> <!-- Nouvelle colonne -->
            <th id='imp'>Imp</th> <!-- Nouvelle colonne -->
          </tr>";

    foreach ($commandes as $commande) {
        // Récupérer les produits pour chaque entrée
        $stmtProduits = $pdo->prepare("
    SELECT sd.quantite_don, don.nom_don, cd.libelle_categorie, 
           scd.subcategory_name, sscd.sub_subcategory_name, ssscd.sub_sub_subcategory_name
    FROM sortie_dons sd
    JOIN don ON sd.id_don = don.id
    JOIN categorie_don cd ON don.categorie_id = cd.id
    LEFT JOIN subcategory scd ON don.sous_categorie_id = scd.id
    LEFT JOIN sub_subcategory sscd ON don.sous_sous_categorie_id = sscd.id
    LEFT JOIN sub_sub_subcategory ssscd ON don.sous_sous_sous_categorie_id = ssscd.id
    WHERE sd.id_sortie = ?
");
        $stmtProduits->execute([$commande['id']]);
        $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

        // Générer la liste des produits avec quantités
        $produitsListe = "";
        foreach ($produits as $produit) {
            // Construire l'affichage conditionnellement
            $detailsProduit = $produit['libelle_categorie']; // La catégorie est obligatoire
        
            if (!empty($produit['subcategory_name'])) {
                $detailsProduit .= " - " . $produit['subcategory_name'];
            }
            if (!empty($produit['sub_subcategory_name'])) {
                $detailsProduit .= " - " . $produit['sub_subcategory_name'];
            }
            if (!empty($produit['sub_sub_subcategory_name'])) {
                $detailsProduit .= " - " . $produit['sub_sub_subcategory_name'];
            }
        
            // Ajouter le nom du don et la quantité
            $produitsListe .= "{$detailsProduit} : {$produit['nom_don']} : {$produit['quantite_don']}<br>";
        }

        // Affichage de la ligne de commande dans le tableau
        echo "<tr>
                <td>{$commande['ar']}</td>
                <td>{$commande['numq']}</td>
                <td>{$commande['programme']}</td>
                <td>{$commande['date_aide']}</td>
                <td>{$commande['donateur']}</td>
                <td>{$commande['nom_beneficiaire']}</td>
                <td>{$commande['cin']}</td>
                <td>{$commande['nom_delegation']}</td>
                <td>$produitsListe</td>
                <td>{$commande['total_sortie']}</td>
                <td id='supp'>
                    <form action='../model/delete_sortie.php' method='POST' onsubmit='return confirm(\"Voulez-vous vraiment supprimer cette sortie ?\");'>
                        <input type='hidden' name='id_commande' value='{$commande['id']}'>
                        <button type='submit'style='background: #fff; border-color:#fff; width:10px'><i class='bx bxs-folder-minus icon-custom'></i></button>
                    </form>
                </td>
                <td id='impp'><a href='recuSortie.php?id={$commande['id']}'><i class='bx bxs-printer'style='font-size:20px ;color:#9f33ff'></i></a></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Aucune commande disponible.</p>";
}
?>
        </div>
    </div>
</div>