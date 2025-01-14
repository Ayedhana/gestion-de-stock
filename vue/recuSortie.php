<?php
include '../model/db_connection.php'; // Inclure la connexion à la base de données

// Vérifiez si l'ID de l'entrée est passé en paramètre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_entree = $_GET['id'];

    // Récupérez les informations de l'entrée
    $stmt = $pdo->prepare("
    SELECT 
        s.id,
        s.ar, 
        s.numq, 
        s.date_aide, 
        s.id_beneficiaire, 
        b.nom_beneficiaire, 
        b.adresse,
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
    
     WHERE s.id = ?");

                        
    $stmt->execute([$id_entree]);
    $entree = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérez les produits associés à l'entrée
    $stmtProduits = $pdo->prepare("SELECT sd.quantite_don, don.nom_don, cd.libelle_categorie, 
           scd.subcategory_name, sscd.sub_subcategory_name, ssscd.sub_sub_subcategory_name
    FROM sortie_dons sd
    JOIN don ON sd.id_don = don.id
    JOIN categorie_don cd ON don.categorie_id = cd.id
    LEFT JOIN subcategory scd ON don.sous_categorie_id = scd.id
    LEFT JOIN sub_subcategory sscd ON don.sous_sous_categorie_id = sscd.id
    LEFT JOIN sub_sub_subcategory ssscd ON don.sous_sous_sous_categorie_id = ssscd.id
    WHERE sd.id_sortie = ?");
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
<div style="display:block" >
    
     <div style="display:flex ;margin-left:400px">
     <a onclick="window.print()" id="imprimer" style="font-size:30px ;color:#9f33ff;" ><i class='bx bxs-printer'></i></a>
        <h3>الاتحاد التونسي للتضامن الاجتماعي</h3>
    </div>
    <br>
    
        <table style="margin-left:0px">
            <tr>
            <th>Numéro Ordinal </th>
            <th>Numéro de quitance</th>
            <th>Date</th>
            <th>Donneur </th>
            <th>Programme</th>
            <th>Bénéficiaire </th>
            <th>CIN de bénéficiaire</th>
            <th>Adresse </th>
            <th>Produits</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($entree['ar']) ?></td>
                <td><?= htmlspecialchars($entree['numq']) ?></td>
                <td><?= htmlspecialchars($entree['date_aide']) ?></td>
                <td><?= htmlspecialchars($entree['donateur']) ?></td>
                <td><?= htmlspecialchars($entree['programme']) ?></td>
                <td><?= htmlspecialchars($entree['nom_beneficiaire']) ?></td>
                <td><?= htmlspecialchars($entree['cin']) ?></td>
                <td><?= htmlspecialchars($entree['adresse']) ?></td>
                <td style="white-space: normal;"> 
    <?php echo $produitsListe; ?>
</td>
                
            </tr>
            
        </table>
       

        
</div>  
</div>
    
</div>

 
