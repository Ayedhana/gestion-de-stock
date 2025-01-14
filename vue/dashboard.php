
<?php
include "entete.php";

 ?>


      <div class="home-content">
        <div class="overview-boxes">
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Entrées</div>
              <div class="number"><?php $nbe=getAllEntree();echo $nbe ;?></div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Aujourd'hui</span>
              </div>
            </div>
            <p style=" font-size: 50px">
            <i style="color:#33ff3c"class='bx bx-log-in-circle' ></i>
            </p>  
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Sorties</div>
              <div class="number"><?php $nbe=getAllSortie();echo $nbe ;?></div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Aujourd'hui</span>
              </div>
            </div>
            <p style=" font-size: 50px">
            <i style="color:#ffb833"class='bx bx-log-out-circle'></i>
            </p> 
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Les bénnéficaires</div>
              <div class="number"><?php $nbe=getAllBeneficiaire();echo $nbe ;?></div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Aujourd'hui</span>
              </div>
            </div>
            <p style=" font-size: 50px">
            <i class='bx bxs-user-pin 3x' style="color:aqua"></i>
            </p>  
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Les dons</div>
              <div class="number"><?php $nbe=getAllDon();echo $nbe ;?></div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text">Aujourd'hui</span>
              </div>
            </div> 
            <p style=" font-size: 50px">
          <i style="color:#9f33ff" class='bx bxs-basket'></i> 
          </p>
          </div>
        </div>
        <a onclick="window.print()" id="imprimer" style="font-size:30px ;color:#9f33ff;padding-left:1000px" ><i class='bx bxs-printer'></i></a>
    <div class="home-content" style="padding-top:0px">
    <div class="overview-boxes">
      <div style="display:block">
        <h2>Les Dons:</h2>
      <div>
      <table class="mtable">
       
                <tr>
                    <th>Nom don</th>
                    <th>Qantité </th>
                    <th>Prix unitaire</th>
                </tr>
                <tr>
                    <?php
                    $stock=getStock();
                    if(!empty($stock) && is_array($stock)){
                      foreach($stock as $key=>$value)
                      {
                    ?>
                    <tr>
                        <td><?=$value['nom_don']?></td>
                        <td><?=$value['quantite_don']?></td>
                        <td><?=$value['prix_unitaire']?>-<span>DT</span></td>
                    </tr>
                    <?php
                      }
                    }
                    ?>
                </tr>
            </table>
      </div>
      </div>
      <div style="display:block; margin:5px">
        <h2>Les Entrées:</h2>
      <div>
        <?php
      include '../model/db_connection.php';

// Préparer la base de la requête
$sql = "SELECT e.id, date_aide, total_entree
        FROM entrees AS e";

// Ajouter l'ordre par date
$sql .= " ORDER BY e.date_aide DESC";

// Exécuter la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérer les résultats
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($commandes) > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID Entrée</th>
            <th>Date de l'Entrée</th>
            <th>Produits et Quantités</th>
            <th>Quantité Totale</th>
          </tr>";

    foreach ($commandes as $commande) {
        // Récupérer les produits pour chaque entrée
        $stmtProduits = $pdo->prepare("SELECT ed.quantite_don, d.nom_don FROM entree_dons ed 
                                       JOIN don d ON ed.id_don = d.id
                                       WHERE ed.id_entree = ?");
        $stmtProduits->execute([$commande['id']]);
        $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

        // Générer la liste des produits avec quantités
        $produitsListe = "";
        foreach ($produits as $produit) {
            $produitsListe .= "{$produit['nom_don']} : {$produit['quantite_don']}<br>";
        }

        // Affichage de la ligne de commande dans le tableau
        echo "<tr>
                <td>{$commande['id']}</td>
                <td>{$commande['date_aide']}</td>
                <td>$produitsListe</td>
                <td>{$commande['total_entree']} -Produit(s)</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Aucune commande disponible.</p>";
}
?>
      </div>
</div>
<div style="display:block">
<h2>Les sorties:</h2>
       <div >
       <?php
include '../model/db_connection.php';

// Préparer la base de la requête
$sql = "
    SELECT 
        s.id, 
        s.date_aide, 
        s.total_sortie
    FROM 
        sorties AS s
";


// Ajouter l'ordre par date
$sql .= " ORDER BY s.date_aide DESC";

// Exécuter la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérer les résultats
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($commandes) > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID Sortie</th>
            <th>Date de Sortie</th> 
            <th>Produits et Quantités</th>
            <th>Quantité Totale</th>
          </tr>";

    foreach ($commandes as $commande) {
        // Récupérer les produits pour chaque entrée
        $stmtProduits = $pdo->prepare("SELECT sd.quantite_don, d.nom_don FROM sortie_dons sd 
                                       JOIN don d ON sd.id_don = d.id
                                       WHERE sd.id_sortie = ?");
        $stmtProduits->execute([$commande['id']]);
        $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

        // Générer la liste des produits avec quantités
        $produitsListe = "";
        foreach ($produits as $produit) {
            $produitsListe .= "{$produit['nom_don']} : {$produit['quantite_don']}<br>";
        }

        // Affichage de la ligne de commande dans le tableau
        echo "<tr>
                <td>{$commande['id']}</td>
                <td>{$commande['date_aide']}</td>
                <td>$produitsListe</td>
                <td>{$commande['total_sortie']} -Produit(s)</td>
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
    </div>