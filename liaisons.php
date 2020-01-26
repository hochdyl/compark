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
        $(function () {
            $(".pop-up-info").delay(600).fadeOut(500);   
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
            if ($_GET['action'] == 'supprimer') {
                SupprimerPopUp();
            }
            if ($_GET['action'] == 'delete') {
                Supprimer();
            }
            if ($_GET['action'] == 'update') {
                Modifier();
            }
        }
        if ( isset ($_GET['popup'])) {
            PopUp();
        }
    ?>
    
    <div class="wrapper">
        
        <!-- Bannière header -->
        <header class="header">
            <span class='vertical-align'></span>
            <a href='index.php'><img id='logo-head' class='center' src="image/comparklogo.png"></a>
        </header>
        
        
        
        <!-- Pop up supprimer confirmation -->
        <?php
        function SupprimerPopUp() {
               
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

                echo "<div class='pop-up-overlay-update'></div>";
                    echo "<div class='pop-up-update center'>";
                        echo "<label><input class='round pop-up-close' type=button value='X'/></label>";
                        echo "<label><form action='liaisons.php'><p class='pop-up-content center'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                            echo "<label><p class='center box-label spc-bot'>SUPPRESSION LIAISONS :</p></label>";
                            echo "<div class='contain-overflow-pop-up'>";
                            if ( isset ( $_GET['id_linked_ordi'] )) {
                                echo "<input type='hidden' name='id_compo' value='".$_GET['id_compo']."'>";
                                foreach($_GET['id_linked_ordi'] as $IDRecherche) {
                                $Requete = "SELECT * from ordinateur where id_ordi=".$IDRecherche.";";
                                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                                $ligne = mysqli_fetch_array($Resultat);
                                    
                                    echo "<div class='ligne'>";
                                        echo "<input type=hidden name=id_linked_ordi[] value=".$ligne['id_ordi'].">";
                                        echo "<p class='item-name'>".$ligne['nom_ordi']."</p>";
                                    echo "</div>";
                                }
                            }
                            if ( isset ( $_GET['id_linked_compo'] )) {
                                echo "<input type='hidden' name='id_ordi' value='".$_GET['id_ordi']."'>";
                                foreach($_GET['id_linked_compo'] as $IDRecherche) {
                                $Requete = "SELECT * from composant where id_compo=".$IDRecherche.";";
                                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                                $ligne = mysqli_fetch_array($Resultat);
                                    
                                    echo "<div class='ligne'>";
                                        echo "<input type=hidden name=id_linked_compo[] value=".$ligne['id_compo'].">";
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
        
        <!-- REQUETE SUPPRIMER LIAISONS -->
        <?php
        function Supprimer() {
        if ( isset ($_GET['id_ordi'])) {
            $var = 'ordi';
            $id = $_GET['id_ordi'];
        }
        if ( isset ($_GET['id_compo'])) {
            $var = 'compo';
            $id = $_GET['id_compo'];
        }
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;
            
            if ( isset ($_GET['id_ordi'])) {
                
                $id = $_GET['id_ordi'];
                
                foreach($_GET['id_linked_compo'] as $IDRecherche) {
                    
                    //--- Préparation de la requête
                    $Requete = "Delete From installation Where refordi='". $id ."' AND refcompo='".$IDRecherche."' Limit 1;" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

                    }
            }

            if ( isset ($_GET['id_compo'])) {
                
                $id = $_GET['id_compo'];
                
                foreach($_GET['id_linked_ordi'] as $IDRecherche) {
                    
                    //--- Préparation de la requête
                    $Requete = "Delete From installation Where refcompo='". $id ."' AND refordi='".$IDRecherche."' Limit 1;" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

                    }
            }
            
            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
            
            header('Location: liaisons.php?popup=supprimer&id_'.$var.'='.$id);
            exit();
        }
        ?>
        
        
        
        
        <!-- REQUETE UPDATE LIAISONS -->
        <?php
        function Modifier() {
        if ( isset ($_GET['id_ordi'])) {
            $var = 'ordi';
            $id = $_GET['id_ordi'];
        }
        if ( isset ($_GET['id_compo'])) {
            $var = 'compo';
            $id = $_GET['id_compo'];
        }
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;
            
            if ( isset ($_GET['id_ordi'])) {
                
                //--- Préparation de la requête
                $Requete = "Update installation set OKHS = 'HS' Where refordi=". $id .";" ;

                //--- Exécution de la requête (fin du script possible sur erreur ...)
                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                
                if ( isset ($_GET['id_compo_okhs'])) {
                    foreach($_GET['id_compo_okhs'] as $IDRecherche) {
                        //--- Préparation de la requête
                        $Requete = "Update installation set OKHS = 'OK' Where refordi=". $id ." and refcompo=".$IDRecherche.";" ;

                        //--- Exécution de la requête (fin du script possible sur erreur ...)
                        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    }
                }
            }

            if ( isset ($_GET['id_compo'])) {
                
                //--- Préparation de la requête
                $Requete = "Update installation set OKHS = 'HS' Where refcompo=". $id .";" ;

                //--- Exécution de la requête (fin du script possible sur erreur ...)
                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                
                if ( isset ($_GET['id_ordi_okhs'])) {
                    foreach($_GET['id_ordi_okhs'] as $IDRecherche) {
                        //--- Préparation de la requête
                        $Requete = "Update installation set OKHS = 'OK' Where refcompo=". $id ." and refordi=".$IDRecherche.";" ;

                        //--- Exécution de la requête (fin du script possible sur erreur ...)
                        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    }
                }
            }
            
            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;
            
            header('Location: liaisons.php?popup=modifier&id_'.$var.'='.$id);
            exit();
        }
        ?>
        
        
        
        
        <!-- Content box -->
        <?php
        // Affichage d'une donnée ordinateur ou composant selon l'id recu
        
        if ( isset ($_GET['id_ordi'])) {
            BDOrdi();
            BDOrdiAjouter();
        }
        if ( isset ($_GET['id_compo'])) {
            BDCompo();
            BDCompoAjouter();
        }
        
        function BDOrdi () {
            $id = $_GET['id_ordi'];
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "SELECT * FROM installation i JOIN composant c ON c.id_compo=i.refcompo JOIN ordinateur o ON o.id_ordi=i.refordi WHERE refordi=". $id ." ORDER BY nom_ordi ;" ;

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            $Count = 0;
            
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                    {
                        $Count = $Count + 1;
                    }

            $Nom = "SELECT * FROM ordinateur WHERE id_ordi=".$id.";" ;
            
            $AffichageNom = mysqli_query ( $DataBase, $Nom )  or  die(mysqli_error($DataBase) ) ;
            
            $ligne = mysqli_fetch_array($AffichageNom);
            
            echo "
            <div class='main'>

                <div class='summary-box'><i class='fas fa-link'></i><label class='count'>".$Count."</label></div>
                <input id='search-bar-ele' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>".$ligne['nom_ordi']."</p></label>

                <a class='delete-input-link composant'><i class='delete-input composant fas fa-trash'></i></a>
                <i class='sync-input fas fa-sync'></i>
                ";

                // LISTE DES ELEMENTS COMPOSANTS LIES
                echo "
                <div class='contain-overflow'>
                    <form id='liaison-compo'>
                
                <input class='reload' type='hidden' name='id_ordi' value='".$id."'>";


            if ( $Count == 0 ) {
                echo "
                <div class='error'>
                    <label><p class='item-name center'>IL N'Y A PAS DE LIAISON</p></label>
                </div> ";
            }

            else {

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    echo "
                    <div class='ligne ele'>
                        <p class='item-name'>".$ligne['nom_compo']."</p>
                        <input class='delete-checkbox delete_linked' type='checkbox' name='id_linked_compo[]' value='".$ligne['refcompo']."'>
                        <div class='switch_box'>";
                            if ( $ligne['OKHS'] == 'OK') {
                                echo "<input type='checkbox' class='switch_1 okhs_linked' name='id_compo_okhs[]' value='".$ligne['refcompo']."' checked>";
                            }
                            else {
                                echo "<input type='checkbox' class='switch_1 okhs_linked' name='id_compo_okhs[]' value='".$ligne['refcompo']."'>";
                            }
                    echo "
                        </div>
                    </div>";
                }

            }

            $ligne = mysqli_fetch_array($Resultat);
                
            echo "
                </form>
                </div>
                
                <div class='form-box'>
                    <p class='box-label'></p>
                </div>
            </div>

            ";
            
            //--- Libérer l'espace mémoire du résultat de la requête
            mysqli_free_result ( $Resultat ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;  
        }
        
        
        
        function BDCompo () {
            $id = $_GET['id_compo'];
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "SELECT * FROM installation i JOIN ordinateur o ON o.id_ordi=i.refordi JOIN composant c ON c.id_compo=i.refcompo WHERE refcompo=". $id ." ORDER BY nom_compo ;" ;

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            $Count = 0;
            
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                    {
                        $Count = $Count + 1;
                    }

            $Nom = "SELECT * FROM composant WHERE id_compo=".$id.";" ;
            
            $AffichageNom = mysqli_query ( $DataBase, $Nom )  or  die(mysqli_error($DataBase) ) ;
            
            $ligne = mysqli_fetch_array($AffichageNom);
            
            echo "
            <div class='main'>

                <div class='summary-box'><i class='fas fa-link'></i><label class='count'>".$Count."</label></div>
                <input id='search-bar-ele' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>".$ligne['nom_compo']."</p></label>

                <a class='delete-input-link ordinateur'><i class='delete-input ordinateur fas fa-trash'></i></a>
                <i class='sync-input fas fa-sync'></i>
                ";

                // LISTE DES ELEMENTS ORDINATEURS LIES
                echo "
                <div class='contain-overflow'>
                    <form id='liaison-ordi'>
                
                <input class='reload' type='hidden' name='id_compo' value='".$id."'>";


            if ( $Count == 0 ) {
                echo "
                <div class='error'>
                    <label><p class='item-name center'>IL N'Y A PAS DE LIAISON</p></label>
                </div> ";
            }

            else {

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    echo "
                    <div class='ligne ele'>
                        <p class='item-name'>".$ligne['nom_ordi']."</p>
                        <input class='delete-checkbox delete_linked' type='checkbox' name='id_linked_ordi[]' value='".$ligne['refordi']."'>
                        <div class='switch_box'>";
                            if ( $ligne['OKHS'] == 'OK') {
                                echo "<input type='checkbox' class='switch_1 okhs_linked' name='id_ordi_okhs[]' value='".$ligne['refordi']."' checked>";
                            }
                            else {
                                echo "<input type='checkbox' class='switch_1 okhs_linked' name='id_ordi_okhs[]' value='".$ligne['refordi']."'>";
                            }
                    echo "
                        </div>
                    </div>";
                }

            }

            $ligne = mysqli_fetch_array($Resultat);
                
            echo "
                </form>
                </div>
                
                <div class='form-box'>
                    <p class='box-label'></p>
                </div>
            </div>

            ";
            
            //--- Libérer l'espace mémoire du résultat de la requête
            mysqli_free_result ( $Resultat ) ;

            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;  
        }
        ?>
                    


        
        
        
        <!-- Content box -->
        <?php
        function BDOrdiAjouter () {
            
            $id = $_GET['id_ordi'];
            
            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "Select * From composant where id_compo not in (SELECT refcompo from installation where refordi = '".$id."')";

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            $Count = 0;
            
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                    {
                        $Count = $Count + 1;
                    }

            echo "
            <div class='main'>
                <div class='summary-box'><i class='fas fa-tools'></i><label class='count'>".$Count."</label></div>
                <input id='search-bar-liaison' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>AJOUTER DES COMPOSANTS</p></label>
                ";

                // LISTE DES ELEMENTS COMPOSANTS LIES
                echo "
                <div class='contain-overflow'>
                    <form id='insert-linked'>
                    
                <input type='hidden' name='id_ordi' value='".$id."'>
                ";



            if ( $Count == 0 ) {
                echo "
                <div class='error'>
                    <label><p class='item-name center'>IL N'Y A PAS DE LIAISON POSSIBLE</p></label>
                </div> ";
            }

            else {

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    echo "
                    <div class='ligne liaison'>
                        <p class='item-name'>".$ligne['nom_compo']."</p>
                        <input class='insert-checkbox' type='checkbox' name='id_add_compo[]' value='".$ligne['id_compo']."'>
                    </div> ";
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
        ?>
        
        <!-- Content box -->
        <?php
        function BDCompoAjouter () {

            $id = $_GET['id_compo'];

            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;

            //--- Préparation de la requête
            $Requete = "Select * From ordinateur where id_ordi not in (SELECT refordi from installation where refcompo = '".$id."')";

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            $Count = 0;
            
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                    {
                        $Count = $Count + 1;
                    }

            echo "
            <div class='main'>
                <div class='summary-box'><i class='fas fa-tools'></i><label class='count'>".$Count."</label></div>
                <input id='search-bar-liaison' class='search-bar' type='text' placeholder='Rechercher'>

                <label><p class='center box-label'>AJOUTER DES ORDINATEURS</p></label>
                ";

                // LISTE DES ELEMENTS COMPOSANTS LIES
                echo "
                <div class='contain-overflow'>
                    <form id='insert-linked'>
                    
                <input type='hidden' name='id_compo' value='".$id."'>
                ";



            if ( $Count == 0 ) {
                echo "
                <div class='error'>
                    <label><p class='item-name center'>IL N'Y A PAS DE LIAISON POSSIBLE</p></label>
                </div> ";
            }

            else {

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            //--- Enumération des lignes du résultat de la requête
            while (  $ligne = mysqli_fetch_array($Resultat)  )
                {
                    echo "
                    <div class='ligne liaison'>
                        <p class='item-name'>".$ligne['nom_ordi']."</p>
                        <input class='insert-checkbox' type='checkbox' name='id_add_ordi[]' value='".$ligne['id_ordi']."'>
                    </div> ";
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
        ?>
                
        <!-- Input ajouter -->
        <div class="form-box">
            <input class='insert-linked-submit' type='submit' alt='AJOUTER'>
        </div>
        
    
        <!-- REQUETE AJOUTER -->
        <?php
        function Ajouter () {
            if ( isset ($_GET['id_ordi'])) {
                $var = 'ordi';
                $id = $_GET['id_ordi'];
            }
            if ( isset ($_GET['id_compo'])) {
                $var = 'compo';
                $id = $_GET['id_compo'];
            }

            //--- Connection au SGBDR 
            $DataBase = mysqli_connect ( "localhost" , "root" , "" ) ;

            //--- Ouverture de la base de données
            mysqli_select_db ( $DataBase, "compark" ) ;
                
            if ( isset ($_GET['id_ordi'])) {
                foreach ( $_GET['id_add_compo'] as $IDRecherche ) {
                    
                    $Requete = "INSERT INTO installation ( refordi , refcompo , OKHS ) 
                                VALUES ( ".$_GET['id_ordi']." , ".$IDRecherche." , 'OK' );" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    
                }
            }
            
            if ( isset ($_GET['id_compo'])) {
                foreach ( $_GET['id_add_ordi'] as $IDRecherche ) {
                    
                    $Requete = "INSERT INTO installation ( refcompo , refordi , OKHS ) 
                                VALUES ( ".$_GET['id_compo']." , ".$IDRecherche." , 'OK' );" ;

                    //--- Exécution de la requête (fin du script possible sur erreur ...)
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    
                }
            }
            
            //--- Déconnection de la base de données
            mysqli_close ( $DataBase ) ;

            
            header('Location: liaisons.php?popup=ajouter&id_'.$var.'='.$id);
            exit();
        }
        ?>
        
        
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
            var ele = $('.reload').attr('name');  
            var id = $('.reload').val();
            window.location.replace("liaisons.php?"+ele+"="+id);
        });
        
        // ENVOYER FORMULAIRE AJOUTER LIAISON
        $('.insert-linked-submit').click(function(){
            var input = $("<input>") // AJOUTER UN INPUT HIDDEN AVEC ID ORIGINAL LIAISON
                .attr("type", "hidden")
                .attr("name", "action").val("insert");
                $('#insert-linked').append(input);
            $('#insert-linked').submit()
        });
        
        // ENVOYER FORMULAIRE SYNC OKHS
        $('.sync-input').click(function(){
            
            $('.delete_linked').removeAttr('name');
            var input = $("<input>") // AJOUTER UN INPUT HIDDEN AVEC ID ORIGINAL LIAISON
                .attr("type", "hidden")
                .attr("name", "action").val("update");
                $('#liaison-compo,#liaison-ordi').append(input);
            $('#liaison-compo,#liaison-ordi').submit()
        });

        
        // ANIMATION INPUT ORDINATEUR
        $('.delete-input-link.ordinateur').click(function(ev){
            var atLeastOneIsChecked = $('input[name="id_linked_ordi[]"]:checked').length > 0;

            if ( atLeastOneIsChecked == true ) { // SI AU MOINS UNE CHECKBOX EST COCHEE
                var input = $("<input>") // AJOUTER UN INPUT HIDDEN ACTION SUPPRIMER
                    .attr("type", "hidden")
                    .attr("name", "action").val("supprimer");
                    $('#liaison-ordi').append(input); 
                $('.okhs_linked').removeAttr('name');
                $("#liaison-ordi").submit()
            }
                                          
            else {
            $('.delete-input.ordinateur').addClass('shake'); // SINON SHAKE
            ev.preventDefault();
            }
        });
        
        
        
        // ANIMATION INPUT COMPOSANT
        $('.delete-input-link.composant').click(function(ev){
            var atLeastOneIsChecked = $('input[name="id_linked_compo[]"]:checked').length > 0;

            if ( atLeastOneIsChecked == true ) { // SI AU MOINS UNE CHECKBOX EST COCHEE
                var input = $("<input>") // AJOUTER UN INPUT HIDDEN ACTION SUPPRIMER
                .attr("type", "hidden")
                .attr("name", "action").val("supprimer");
                $('#liaison-compo').append(input);
                $('.okhs_linked').removeAttr('name');
                $("#liaison-compo").submit()
            }
            
            else {
            $('.delete-input.composant').toggleClass('shake');
            ev.preventDefault();
            }
        });
        
        
        
        $('.okhs_linked').click(function(){
            $('.sync-input').css('color','#F0A000').css('transition','0.3s'); // CHANGE LA COULEUR EN ORANGE
        });
        
        
        // BARRE DE RECHERCHE
        
        $("#search-bar-ele").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".ligne.ele").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        $("#search-bar-liaison").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".ligne.liaison").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
    
</body>
    
</html>

