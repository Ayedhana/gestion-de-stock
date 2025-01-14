<?php
include_once '../model/fonctions.php';
?>
<!DOCTYPE html>
<htm lang="Ar" dir="auto">
    <head>
    <meta charset="UTF-8">
    <title id="titre">
    <?php
    echo ucfirst(str_replace(".php","",basename($_SERVER['PHP_SELF'])))  ;
    ?>
    </title>
    <link rel="stylesheet" href="../public/css/style.css">
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
       @media print { #filtre, #imprimer,#box,#modif,#modiff,#titre,#sup,#supp,#imp,#impp{ display: none; } }
    </style>
    <style>
        .icon-custom {
            color: #28a745; /* Vert */
            font-size: 24px; /* Taille de l'icône */
        }
        .icon-custom:hover {
            color: #dc3545; /* Change en rouge au survol */
        }
    </style>
  </head>
    <body>
    <div class="sidebar hidden-print">
      <div class="logo-details">
      <img style="width:80px ;height:80px; margin-left:70px ;margin-top:20px; margin: buttom 20px;"
       src="../public/img/logo.jpg" />
       
      </div>
      <ul class="nav-links" >
        <li style="height:40px">
          <a href="dashboard.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="dashboard.php" ?"active":"" ?>">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Stock </span>
          </a>
        </li>
        <li style="height:40px">
          <a href="don.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="don.php" ?"active":"" ?>">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Les dons</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="entree.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="entree.php" ?"active":"" ?>">
            <i class="bx bx-box"></i>
            <span class="links_name">Les entrées</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="sortie.php">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">Les sorties</span>
          </a>
        </li>
        
        <li style="height:40px">
          <a href="beneficaire.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="beneficaire.php" ?"active":"" ?>">
            <i class="bx bx-box"></i>
            <span class="links_name">Les bénéficiaires</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="donateur.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="donateur.php" ?"active":"" ?>">
            <i class="bx bx-box"></i>
            <span class="links_name">Les donateurs</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="categorie.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="categorie.php" ?"active":"" ?>">
            <i class="bx bx-category"></i>
            <span class="links_name">Les Catégories</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="sous_categorie.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="sous_categorie.php" ?"active":"" ?>">
            <i class="bx bx-category"></i>
            <span class="links_name">Les Sous catégories</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="sous_sous_categorie.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="sous_sous_categorie.php" ?"active":"" ?>">
            <i class="bx bx-category"></i>
            <span class="links_name">Les Sous sous catégories</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="sous_sous_sous_categorie.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="sous_sous_sous_categorie.php" ?"active":"" ?>">
            <i class="bx bx-category"></i>
            <span class="links_name">Les Sous sous sous catégories</span>
          </a>
        </li>
        <li style="height:40px">
          <a href="trie.php" class="<?php echo(basename($_SERVER['PHP_SELF']))=="trie.php" ?"active":"" ?>">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Les enregistres de trie</span>
          </a>
        </li>
       
        
          
        <!-- <li>
          <a href="#">
            <i class="bx bx-message" ></i>
            <span class="links_name">Messages</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-heart" ></i>
            <span class="links_name">Favrorites</span>
          </a>
        </li> -->
        
        </li>
        
      </ul>
    </div>
    <section class="home-section">
      <nav class="hidden-print">
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard" > <?php
    echo ucfirst(str_replace(".php","",basename($_SERVER['PHP_SELF'])))  ;
    ?></span>
        </div>
        
        <div class="search-box">
        <br>
         <h1 style="color:#0a2558">Union Tunisienne de solidatité sociale</h1>
        </div>
        
      </nav>

