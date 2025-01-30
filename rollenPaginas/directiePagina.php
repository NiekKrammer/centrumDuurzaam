<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet" type="text/css">
    <link href="../css/directiePagina.css" rel="stylesheet" type="text/css">
    <title>Directie</title>
</head>
<body>
    
	<?php 
    
    include '../includes/nav.php';

    $helpers = new Helpers();

    $helpers->checkAccess(["directie"], "../login.php");

    ?>

    <div id="directieContainer">
        <div class="directieLinkDivs"><h2>Ritten</h2><p>Overzicht van de ritten planning</p><a class="directieLinkButton" href="./chauffeurPagina.php">Ga naar ritten</a></div>
        <div class="directieLinkDivs"><h2>Voorraad beheer</h2><p>Voorraad beheer overzicht</p><a class="directieLinkButton" href="./magazijnMedewerkerPagina.php">Ga naar voorraad beheer</a></div>
        <div class="directieLinkDivs"><h2>Klanten</h2><p>Beheer hier alle klanten/gebruikers</p><a class="directieLinkButton" href="./klantenPagina.php">Ga naar klanten</a></div>
        <div class="directieLinkDivs"><h2>Medewerkers</h2><p>Overzicht van alle medewerkers</p><a class="directieLinkButton" href="./personeelPagina.php">Ga naar medewerkers</a></div>
    </div>

    <footer>
        <p>© 2025 Centrum Duurzaam. Alle rechten voorbehouden.</p>
    </footer>
</body>
</html>