<?php
include '../model/db_connection.php'; // Inclure la connexion à la base de données

// Vérifiez si l'ID de l'entrée est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_entree = $_GET['id'];

    // Récupérez les informations de l'entrée
    $stmt = $pdo->prepare("SELECT e.ar, e.numq, e.date_aide, d.nom_donateur, e.total_entree
                           FROM entrees AS e
                           JOIN donateur AS d ON e.id_donateur = d.id
                           WHERE e.id = ?");
    $stmt->execute([$id_entree]);
    $entree = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérez les produits associés à l'entrée
    $stmtProduits = $pdo->prepare("SELECT ed.quantite_don, don.nom_don, cd.libelle_categorie, 
           scd.subcategory_name, sscd.sub_subcategory_name, ssscd.sub_sub_subcategory_name
    FROM entree_dons ed
    JOIN don ON ed.id_don = don.id
    JOIN categorie_don cd ON don.categorie_id = cd.id
    LEFT JOIN subcategory scd ON don.sous_categorie_id = scd.id
    LEFT JOIN sub_subcategory sscd ON don.sous_sous_categorie_id = sscd.id
    LEFT JOIN sub_sub_subcategory ssscd ON don.sous_sous_sous_categorie_id = ssscd.id
    WHERE ed.id_entree = ?");
    $stmtProduits->execute([$id_entree]);
    $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

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
        $produitsListe .= "{$detailsProduit} : {$produit['nom_don']} ({$produit['quantite_don']})<br>";
    }

} else {
    echo "<p>ID d'entrée invalide.</p>";
    exit;
}
?>

<?php
include "entete.php";


 ?>
 <div class="home-content">
<div class="overview-boxes">
<div  style="display:block; margin-left:90px">
    
     <div style="display:flex ;margin-left:300px">
     <a onclick="window.print()" id="imprimer" style="font-size:30px ;color:#9f33ff;" ><i class='bx bxs-printer'></i></a>
        <h3>الاتحاد التونسي للتضامن الاجتماعي</h3>
    </div>
    <br>
    
        <table>
            <tr>
            <th>Numéro Ordinal </th>
            <th>Numéro de quitance</th>
            <th>Date</th>
            <th>Donneur </th>
            <th>Produits</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($entree['ar']) ?></td>
                <td><?= htmlspecialchars($entree['numq']) ?></td>
                <td><?= htmlspecialchars($entree['date_aide']) ?></td>
                <td><?= htmlspecialchars($entree['nom_donateur']) ?></td>
                <td style="white-space: normal;"> 
                <?php echo $produitsListe; ?></td>

            </tr>
            
        </table>
       

        
</div>  
</div>
    
</div>

