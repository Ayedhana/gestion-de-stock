
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
    </script>
<div class="home-content">
    <div class="overview-boxes">
        <div class="box" id="box">
            <form action="../model/ajoutEntree.php" method="post">
           
            <div class="case">
            <label for="ar">Numéro ordinal</label>
            <input value="" type="number" name="ar" id="ar" >
            </div>
            <div>
             <label for="numq">Num quitance</label>
             <input value= "" type="number"  name="numq" id="numq" placeholder="Numéro ordinal">
             <input value="" type="hidden"  name="id" id="id">
            </div>
            <div class="case">
            <label for="date_aide">Date aide</label>
            <input value="" type="date" name="date_aide" id="date_aide" >
            </div>
            <div>
             <label for="donateur">Le donateur</label>
             <select name="id_donateur" id="id_donateur">
            <?php
            $donateurs=getDonateur();
            if(!empty($donateurs)&& is_array($donateurs))
            {
                foreach($donateurs as $key => $value){        
            ?>
            <option value="<?= $value['id']?>"><?= $value['nom_donateur'] ?></option>
            <?php

                }
            }
            
            ?>
            </select>
            </div>
            <h3>Ajouter don(s)</h3>
            <div id="produits-container"></div>
    <button type="button" onclick="ajouterProduit()" style="background-color:#7f33ff;color:white">Ajouter un don</button>
    
           <div>
           <button type="submit">Enregistrer l'entree </button>
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
            <th style="border:0px">Donateur</th>
        </tr>
        <tr style="border:0px" >
            
            <td style="border:0px">
                <input type="date" name="date_aide" id="date_aide" value="<?= isset($_GET['date_aide']) ? $_GET['date_aide'] : '' ?>">
            </td>
            <td style="border:0px">
                <select name="id_donateur" id="id_donateur">
                    <option value="">Sélectionnez le donateur</option>
                    <?php
                    $donateurs = getDonateur();
                    foreach($donateurs as $donateur) { 
                        $selected = (isset($_GET['id_donateur']) && $_GET['id_donateur'] == $donateur['id']) ? "selected" : "";
                        echo "<option value='{$donateur['id']}' $selected>{$donateur['nom_donateur']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Chercher</button>
</form>

            <a onclick="window.print()" id="imprimer" style="font-size:30px ;color:#9f33ff;padding-left:750px" ><i class='bx bxs-printer'></i></a>
            <h3 >Liste des entrées</h3>
            <br>
            <?php
include '../model/db_connection.php';

// Préparer la base de la requête
$sql = "SELECT e.id,ar, numq, date_aide, id_donateur, nom_donateur, total_entree
        FROM entrees AS e
        JOIN donateur AS d ON e.id_donateur = d.id
        WHERE 1";

// Initialiser $params comme un tableau vide
$params = [];

// Vérification et ajout des filtres
if (!empty($_GET['date_aide'])) {
    $sql .= " AND e.date_aide = :date_aide";
    $params[':date_aide'] = $_GET['date_aide'];
}
if (!empty($_GET['id_donateur'])) {
    $sql .= " AND e.id_donateur = :id_donateur";
    $params[':id_donateur'] = $_GET['id_donateur'];
}

// Ajouter l'ordre par date
$sql .= " ORDER BY e.date_aide DESC";

// Exécuter la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

// Récupérer les résultats
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($commandes) > 0) {
    echo "<table>";
    echo "<tr>
             <th>Numé ordinal</th>
            <th>Numéro de Quittance</th>
            <th>Date de l'Entrée</th>
            <th>Donneur</th>
            <th>Produits et Quantités</th>
            <th>Quantité Totale</th>
            <th id='sup'>Supprimer</th> <!-- Nouvelle colonne -->
            <th id='imp'>Imprimer</th> <!-- Nouvelle colonne -->
          </tr>";

          foreach ($commandes as $commande) {
            // Récupérer les produits pour chaque entrée
            $stmtProduits = $pdo->prepare("
        SELECT ed.quantite_don, don.nom_don, cd.libelle_categorie, 
               scd.subcategory_name, sscd.sub_subcategory_name, ssscd.sub_sub_subcategory_name
        FROM entree_dons ed
        JOIN don ON ed.id_don = don.id
        JOIN categorie_don cd ON don.categorie_id = cd.id
        LEFT JOIN subcategory scd ON don.sous_categorie_id = scd.id
        LEFT JOIN sub_subcategory sscd ON don.sous_sous_categorie_id = sscd.id
        LEFT JOIN sub_sub_subcategory ssscd ON don.sous_sous_sous_categorie_id = ssscd.id
        WHERE ed.id_entree = ?
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
                <td>{$commande['date_aide']}</td>
                <td>{$commande['nom_donateur']}</td>
                <td>$produitsListe</td>
                <td>{$commande['total_entree']}</td>
                <td id='supp'>
                    <form action='../model/delete_entree.php' method='POST' onsubmit='return confirm(\"Voulez-vous vraiment supprimer cette commande ?\");'>
                        <input type='hidden' name='id_commande' value='{$commande['id']}'>
                        <button type='submit'style='background: #fff; border-color:#fff;width:10px'  ><i class='bx bxs-folder-minus icon-custom'></i></button>
                    </form>
                </td>
                <td id='impp'><a href='recuEntree.php?id={$commande['id']}'><i class='bx bxs-printer'style='font-size:20px ;color:#9f33ff'></i></a></td>
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

