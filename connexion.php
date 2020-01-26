<!DOCTYPE html>
<html id='background'>
<head>
	<title>Accueil</title>
	<meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="image/favicon.png" />
    <link rel="shortcut icon" type="image/x-icon" href="image/favicon.png" />
    <link rel="stylesheet" href="assets/main.css" />
    <script type="text/javascript" src="assets/jquery-3.4.0.min.js"></script>
    <script>     
    $(function () {
        $(".pop-up-info").delay(1200).fadeOut(500);       
    });
    </script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="assets/three.r92.min.js"></script>
    <script src="assets/vanta.waves.min.js"></script>
    <script>
    VANTA.WAVES({
      el: "#background",
      color: 0x0,
      shininess: 33.00,
      waveHeight: 14.50,
      waveSpeed: 0.80,
      zoom: 0.81
    });
    </script>
</head>
    
<body>

<div class='main-login center'>
    <img class='logo-login' src="image/comparklogo.png">
    
    <div class="login-box">
        <form>
            <input class="connexion-input" type="text" name="nom" placeholder="Entrez votre identifiant" required>
            <input class="connexion-input" type="password" name="password" placeholder="Entrez votre mot de passe" required>
            <input class="connexion-input" type="submit" name='connect' value='Connexion'>
        </form>
    </div>
    
<?php

if ( isset ($_GET['connect'])) {
    Connexion();
}
    
function Connexion () {
   
            $Login = $_GET['nom'];
            $Password = $_GET['password'];

            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            $Requete = "Select * from utilisateur where nom_util = '".$Login."';";

            //--- Exécution de la requête (fin du script possible sur erreur ...)
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
    
            $ligne = mysqli_fetch_array($Resultat);

            if ($Login == ($ligne['nom_util'])) {
                if ($Password == ($ligne['mdp_util'])) {

                      header('Location: index.php');
                      exit();
                }
            } else {
                echo "<div class='pop-up-info center'><p>Mauvais mot de passe ou identifiant</p></div>";
            }


            //--- Déconnection de la base de données0
            mysqli_close ( $DataBase ) ;
                
             }

   ?>
    
</div>
    
</body>
    
</html>

