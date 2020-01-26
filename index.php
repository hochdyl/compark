<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
	<meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="image/favicon.png" />
    <link rel="shortcut icon" type="image/x-icon" href="image/favicon.png" />
    <link rel="stylesheet" href="assets/main.css" />
    <script type="text/javascript" src="assets/jquery-3.4.0.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script type="text/javascript">
    $(document).ready(function(){
        
        // ANIMATION VALIDER
        $(function () {
            $(".pop-up-info").delay(800).fadeOut(500);       
        });
        
    });
    </script>
</head>
    
    
    
    
<body>
    <?php
        if ( isset ($_GET['action'])) {
            if ($_GET['action'] == 'insert') {
                Ajouter();
            }
            if ($_GET['action'] == 'modifier') {
                ModifierPopUp();
            }
            if ($_GET['action'] == 'update') {
                Modifier();
            }
            if ($_GET['action'] == 'supprimer') {
                SupprimerPopUp();
            }
            if ($_GET['action'] == 'delete') {
                Supprimer();
            }
        }
        if ( isset ($_GET['popup'])) {
            PopUp();
        }
    ?>
        
    
    
    
        <!-- REQUETE AJOUTER -->
        <?php
            function Ajouter () {
            if ( isset ($_GET['nom_ordi'])) {
                $nom = $_GET['nom_ordi'];
                $table = 'ordinateur';
                $var = 'ordi';
                if ( isset ($_GET['commentaire_ordi'])) {
                    $commentaire = $_GET['commentaire_ordi'];
                }
                else {
                    $commentaire = NULL;
                }
            }
                
            if ( isset ($_GET['nom_compo'])) {
                $nom = $_GET['nom_compo'];
                $table = 'composant';
                $var = 'compo';
                if ( isset ($_GET['commentaire_compo'])) {
                    $commentaire = $_GET['commentaire_compo'];
                }
                else {
                    $commentaire = NULL;
                }
            }

            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            $Requete = "INSERT INTO ".$table." ( nom_".$var." , commentaire_".$var." ) 
                        VALUES ( '".$nom."','".$commentaire."');" ;

            //--- Exécution de la requête (fin du script possible sur erreur ...)
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
                
            header('Location: index.php?popup=ajouter');
            exit();
            }
        ?>

    
    
    
    
    
        <!-- Pop up modifier -->
        <?php
            function ModifierPopUp() {

            if ( isset ($_GET['id_ordi'])) {
                $var = 'ordi';
                $id = $_GET['id_ordi'];
                $table = 'ordinateur';
            }
            if ( isset ($_GET['id_compo'])) {
                $var = 'compo';
                $id = $_GET['id_compo'];
                $table = 'composant';
            }
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;
                
            $Requete = "select * from ".$table." where id_".$var."=".$id.";";
                
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            $ligne = mysqli_fetch_array($Resultat);
            
                echo "<div class='pop-up-overlay-update'></div>";
                    echo "<div class='pop-up-update center'>";
                        echo "<label><input class='round pop-up-close' type=button value='X'/></label>";
                        echo "<label><form action='index.php'><p class='pop-up-content center'>";
                        echo "<input type='hidden' name='action' value='update'>";
                        echo "<input type='hidden' name='id_".$var."' value='".$id."'>";
                            echo "<label><p class='center box-label spc-bot'>METTRE A JOUR :</p></label>";
                            if ( isset ($_GET['id_ordi'])) {
                                echo "<input class='update-text' name='nom_ordi' value='".$ligne['nom_ordi']."' type='text' placeholder='Nouveau nom'>";
                                if ( $ligne['commentaire_ordi'] != "" or ( $ligne['commentaire_ordi'] != NULL ) ) {
                                    echo "<input class='update-text' name='commentaire_ordi' value='".$ligne['commentaire_ordi']."' type='text' placeholder='Nouveau commentaire (facultatif)'>";
                                }
                                else {
                                    echo "<input class='update-text' name='commentaire_ordi' type='text' placeholder='Nouveau commentaire (facultatif)'>";
                                }
                            }
                            if ( isset ($_GET['id_compo'])) {
                                echo "<input class='update-text' name='nom_compo' value='".$ligne['nom_compo']."' type='text' placeholder='Nouveau nom'>";
                                if ( $ligne['commentaire_compo'] != "" or ( $ligne['commentaire_compo'] != NULL ) ) {
                                    echo "<input class='update-text' name='commentaire_compo' value='".$ligne['commentaire_compo']."' type='text' placeholder='Nouveau commentaire (facultatif)'>";
                                }
                                else {
                                    echo "<input class='update-text' name='commentaire_compo' type='text' placeholder='Nouveau commentaire (facultatif)'>";
                                }
                            }
                            echo "<input class='update-submit spc-top' type='submit' alt='VALIDER'>";
                        echo "</p></form></label>";
                echo "</div>";
            }
        ?>
        
        <!-- REQUETE MODIFIER -->
        <?php
            function Modifier () {
            if ( isset ($_GET['nom_ordi'])) {
                $nom = $_GET['nom_ordi'];
                $table = 'ordinateur';
                $var = 'ordi';
                $id = $_GET['id_ordi'];
                if ( isset ($_GET['commentaire_ordi'])) {
                    $commentaire = $_GET['commentaire_ordi'];
                }
                else {
                    $commentaire = NULL;
                }
            }
                
            if ( isset ($_GET['nom_compo'])) {
                $nom = $_GET['nom_compo'];
                $table = 'composant';
                $var = 'compo';
                $id = $_GET['id_compo'];
                if ( isset ($_GET['commentaire_compo'])) {
                    $commentaire = $_GET['commentaire_compo'];
                }
                else {
                    $commentaire = NULL;
                }
            }

            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            $Requete = "update ".$table." set nom_".$var."='".$nom."',commentaire_".$var."='".$commentaire."' where id_".$var."=".$id.";";

            //--- Exécution de la requête (fin du script possible sur erreur ...)
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
                
            header('Location: index.php?popup=modifier');
            exit();
            }
    
        ?>
    
    
    
    
    
    
    
        <!-- Pop up supprimer confirmation -->
        <?php
        function SupprimerPopUp() {
               
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

                echo "<div class='pop-up-overlay-update'></div>";
                    echo "<div class='pop-up-update pop-up-center center'>";
                        echo "<label><input class='round pop-up-close' type=button value='X'/></label>";
                        echo "<label><form action='index.php'><p class='pop-up-content center'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                            echo "<label><p class='center box-label spc-bot'>SUPPRESSION :</p></label>";
                            echo "<div class='contain-overflow-pop-up'>";
                        
                            if ( isset ( $_GET['id_ordi'] )) {
                                foreach($_GET['id_ordi'] as $IdRecherche) {
                                $Requete = "SELECT * from ordinateur where id_ordi=".$IdRecherche.";";
                                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                                $ligne = mysqli_fetch_array($Resultat);
                                    
                                    echo "<div class='ligne'>";
                                        echo "<input type=hidden name=id_ordi[] value=".$ligne['id_ordi'].">";
                                        echo "<p class='item-name'>".$ligne['nom_ordi']."</p>";
                                    echo "</div>";
                                }
                            }
                            if ( isset ( $_GET['id_compo'] )) {
                                foreach($_GET['id_compo'] as $IdRecherche) {
                                $Requete = "SELECT * from composant where id_compo=".$IdRecherche.";";
                                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                                $ligne = mysqli_fetch_array($Resultat);
                                    
                                    echo "<div class='ligne'>";
                                        echo "<input type=hidden name=id_compo[] value=".$ligne['id_compo'].">";
                                        echo "<p class='item-name'>".$ligne['nom_compo']."</p>";
                                    echo "</div>";
                                }
                            }
                            
                            echo "</div><input class='delete-submit spc-top' type='submit' alt='CONFIRMER'>";
                        echo "</p></form></label>";
                echo "</div>";
            
                
            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
            }
        ?>
    
        <!-- REQUETE SUPPRIMER -->
        <?php
        function Supprimer() {
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;
            
            if ( isset ($_GET['id_ordi'])) {
                foreach($_GET['id_ordi'] as $IDRecherche)
                    {
                    //--- Préparation de la requête
                    $Requete = "Delete From ordinateur Where id_ordi='". $IDRecherche ."' Limit 1;" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

                    }
            }

            if ( isset ($_GET['id_compo'])) {
                foreach($_GET['id_compo'] as $IDRecherche)
                    {
                    //--- Préparation de la requête
                    $Requete = "Delete From composant Where id_compo='". $IDRecherche ."' Limit 1;" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

                    }
            }
            
            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
            
            header('Location: index.php?popup=supprimer');
            exit();
        }
    

        ?>
    
    
    
    <div class="wrapper">
        
        <!-- Bannière header -->
        <header class="header">
            <span class='vertical-align'></span>
            <a href='index.php'><img id='logo-head' class='center' src="image/comparklogo.png"></a>
        </header>
    
        

        
        
        <!-- Content box -->
        <?php
        // Affichage d'une donnée ordinateur
        
        function BDOrdi () {
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "SELECT * FROM ordinateur ORDER BY nom_ordi ;" ;
            $Count = "SELECT Count('*') AS resultat FROM ordinateur ;" ;

            $Resultat = mysqli_query ( $DataBase, $Count )  or  die(mysqli_error($DataBase) ) ;

            $ligne = mysqli_fetch_array($Resultat);


            echo "
                <div class='main'>
                <div class='summary-box'><i class='fas fa-desktop'></i><label class='count'>".$ligne['resultat']."</label></div>
                <input id='search-bar-ordi' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>ORDINATEURS</p></label>
                <a class='delete-input-link ordinateur'><i class='delete-input ordinateur fas fa-trash'></i></a>
                ";

                // LISTE DES ELEMENTS ORDINATEURS
                echo "
                <div class='contain-overflow'>
                    <form id='delete-ordi'>";


            if ( $ligne['resultat'] == '0') {
                echo "
                    <div class='error'>
                        <label><p class='item-name center'>IL N'Y A PAS D'ORDINATEURS</p></label>
                    </div>";
            }

            else {

            //--- Exécution de la requête (fin du script possible sur erreur ...)
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    if ( $ligne['commentaire_ordi'] != "" or ( $ligne['commentaire_ordi'] != NULL )) {
                        echo "<a href='liaisons.php?id_ordi=".$ligne['id_ordi']."'><div class='ligne ordinateur' title='Commentaire : ".$ligne['commentaire_ordi']."'>";
                    }
                    else {
                        echo "<a href='liaisons.php?id_ordi=".$ligne['id_ordi']."'><div class='ligne ordinateur' title='Pas de commentaire'>";
                    }
                    echo "
                        <p class='item-name'>".$ligne['nom_ordi']."</p>
                        <input class='delete-checkbox' type='checkbox' name='id_ordi[]' value='".$ligne['id_ordi']."'>
                        <a href='index.php?action=modifier&id_ordi=".$ligne['id_ordi']."'><i class='update-input fas fa-edit'></i></a>
                    </div></a>";
                }

            }

            //--- Libérer l'espace mémoire du résultat de la requête
            mysqli_free_result ( $Resultat ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;  

            echo "
                </form>
            </div>
            ";
        }
        BDOrdi();
        ?>
        
            <!-- Formulaire ajouter -->
            <div class="form-box">
                <form>
                    <input type='hidden' name='action' value='insert'>
                    <input class="insert-input" type="text" placeholder="Nom" name="nom_ordi" required>
                    <input class="insert-submit" type="submit" value="+"> <!-- Envoyer -->
                    <input class="insert-input" type="text" placeholder="Commentaire (facultatif)" name="commentaire_ordi">
                </form>
            </div>
        </div>
        
        
        <!-- Content box -->
        <?php
        // Affichage d'une donnée ordinateur
        
        function BDCompo () {
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "SELECT * FROM composant ORDER BY nom_compo ;" ;
            $Count = "SELECT Count('*') AS resultat FROM composant ;" ;

            $Resultat = mysqli_query ( $DataBase, $Count )  or  die(mysqli_error($DataBase) ) ;

            $ligne = mysqli_fetch_array($Resultat);


            echo "
            <div class='main'>
                <div class='summary-box'><i class='fas fa-tools'></i><label class='count'>".$ligne['resultat']."</label></div>
                <input id='search-bar-compo' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>COMPOSANTS</p></label>
                <a class='delete-input-link composant'><i class='delete-input composant fas fa-trash'></i></a>
                ";

                // LISTE DES ELEMENTS ORDINATEURS
                echo "
                <div class='contain-overflow'>
                    <form id='delete-compo'>";


            if ( $ligne['resultat'] == '0') {
                echo "
                    <div class='error'>
                        <label><p class='item-name center'>IL N'Y A PAS DE COMPOSANTS</p></label>
                    </div>";
            }

            else {

            //--- Exécution de la requête (fin du script possible sur erreur ...)
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    if ( $ligne['commentaire_compo'] != "" or ( $ligne['commentaire_compo'] != NULL )) {
                        echo "<a href='liaisons.php?id_compo=".$ligne['id_compo']."'><div class='ligne composant' title='Commentaire : ".$ligne['commentaire_compo']."'>";
                    }
                    else {
                        echo "<a href='liaisons.php?id_compo=".$ligne['id_compo']."'><div class='ligne composant' title='Pas de commentaire'>";
                    }
                    echo "
                        <p class='item-name'>".$ligne['nom_compo']."</p>
                        <input class='delete-checkbox' type='checkbox' name='id_compo[]' value='".$ligne['id_compo']."'>
                        <a href='index.php?action=modifier&id_compo=".$ligne['id_compo']."'><i class='update-input fas fa-edit'></i></a>
                    </div></a>";
                }

            }

            //--- Libérer l'espace mémoire du résultat de la requête
            mysqli_free_result ( $Resultat ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;  

            echo "
                </form>
            </div>
            ";
        }
        BDCompo();
        ?>
    
            <!-- Formulaire ajouter -->
            <div class="form-box">
                <form>
                    <input type='hidden' name='action' value='insert'>
                    <input class="insert-input" type="text" placeholder="Nom" name="nom_compo" required>
                    <input class="insert-submit" type="submit" value="+"> <!-- Envoyer -->
                    <input class="insert-input" type="text" placeholder="Commentaire (facultatif)" name="commentaire_compo">
                </form>
            </div>
        </div>
    
        <!-- Pop up informations -->
        <?php
        function PopUp() {
            if ( $_GET['popup'] == 'ajouter') {
                echo "<div class='pop-up-info center'><p>Ajout réussi</p></div>";
            }
            if ( $_GET['popup'] == 'supprimer') {
                echo "<div class='pop-up-info center'><p>Suppression réussi</p></div>";
            }
            if ( $_GET['popup'] == 'modifier') {
                echo "<div class='pop-up-info center'><p>Mise à jour réussi</p></div>";
            }
        }
        ?>
    
    <script>
        
        // Fermer le formulaire si annulation + animation si aucunes checkbox checked
        
        $('.pop-up-overlay-update, .pop-up-close').click(function(){
            window.location.replace("index.php");
        });

        // ANIMATION INPUT ORDINATEUR
        $('.delete-input-link.ordinateur').click(function(ev){
            var atLeastOneIsChecked = $('input[name="id_ordi[]"]:checked').length > 0;

            if ( atLeastOneIsChecked == true ) { // SI AU MOINS UNE CHECKBOX EST COCHEE
                var input = $("<input>") // AJOUTER UN INPUT HIDDEN ACTION SUPPRIMER
                .attr("type", "hidden")
                .attr("name", "action").val("supprimer");
                $('#delete-ordi').append(input);
                $("#delete-ordi").submit();
            }
            else {
            $('.delete-input.ordinateur').toggleClass('shake'); // SINON SHAKE
            ev.preventDefault();
            }
        });
        
        
        
        // ANIMATION INPUT COMPOSANT
        $('.delete-input-link.composant').click(function(ev){
            var atLeastOneIsChecked = $('input[name="id_compo[]"]:checked').length > 0;

            if ( atLeastOneIsChecked == true ) { // SI AU MOINS UNE CHECKBOX EST COCHEE
                var input = $("<input>") // AJOUTER UN INPUT HIDDEN ACTION SUPPRIMER
                .attr("type", "hidden")
                .attr("name", "action").val("supprimer");
                $('#delete-compo').append(input);
                $("#delete-compo").submit();
            }
            
            else {
            $('.delete-input.composant').toggleClass('shake'); 
            ev.preventDefault();
            }
        });
        
        
        // BARRE DE RECHERCHE
        
        $("#search-bar-ordi").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".ligne.ordinateur").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        $("#search-bar-compo").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".ligne.composant").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>

</body>
    
</html>

