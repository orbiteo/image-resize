<!DOCTYPE html>
<html>
<head>
    <title>Modification images</title>
</head>
<body>
    <form method="post" action="controleur/image-treatment.php" enctype="multipart/form-data">
        <label for="">Téléchargez votre image à modifier</label>
        <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /> <!-- Max 10 Mo -->
        <input id="imgInp" type="file" name="imageBase"><br>
        <img id="blah" src="#" alt="your image" width="300"/><br>
        <p id="output"></p> 

        <!-- afficher en live le poids de l'image chargée -->

        <!-- choix 1 réduire le poids de l'image sans toucher les dimensions -->
        <label for="typeModif">Vous souhaitez :</label><br>
        <input id="reduceWeight" type="radio" name="typeModif" value="1"> Réduire le poids de l'image<br>
            <div class="choixTaille">
                <!-- choix du % de réduction -->
                <label for="choixReduction">Selectionnez le pourcentage de réduction</label>
                <select name="choixReduction">
                    <option value="0">10%</option>
                    <option value="1">20%</option>
                    <option value="2">30%</option>
                    <option value="3">40%</option>
                    <option value="4">50%</option>
                    <option value="5">60%</option>
                    <option value="6">70%</option>
                    <option value="7">80%</option>
                </select>
            </div>

        <!-- choix 2 modifier les dimensions de l'image -->
        <input id="modifyDimensions" type="radio" name="typeModif" value="2"> Modifier les dimensions de l'image<br>   
            <div class="choixProportions">
                <!-- en gardant les proportion donc en choisissant une largeur OU une hauteur fixe -->
                <input id="conserverProportions" type="radio" name="proportions" value="1"> En conservant les proportions<br>

                <div class="choixHauteurOuLargeur">
                    <!-- Choix hauteur ou largeur fixe -->
                    <input id="hauteur" type="radio" name="taille" value="1"> Hauteur fixe<br>
                    <input id="largeur" type="radio" name="taille" value="2"> Largeur fixe<br>
                        
                        <div class="hauteurInput">
                            <input class="hauteurInput" type="text" name="hauteurInput" placeholder="500"> px
                        </div>
                        <div class="largeurInput">
                            <input class="largeurInput" type="text" name="largeurInput" placeholder="300"> px
                        </div>      
                </div>

                <!-- sans respect des proportions donc avec largeur ET hauteur fixes -->
                <input id="sansProportions" type="radio" name="proportions" value="2"> En choisissant une hauteur et une largeur fixes<br>

                <div class="choixHauteurEtLargeur">
                    <!-- Choix hauteur et largeur fixes -->
                    <input type="text" name="largeur" placeholder="300"> px<br>
                    <input type="text" name="hauteur" placeholder="500"> px<br>
                </div>
            </div>
        <input type="submit" value="TÉLÉCHARGER">
    </form>
</body>
</html>
<script
	src="https://code.jquery.com/jquery-3.4.1.min.js"
	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	crossorigin="anonymous"></script>
<script>

    $('.choixTaille').hide();
    $('.choixProportions').hide();
    $('.choixHauteurOuLargeur').hide();
    $('.choixHauteurEtLargeur').hide();
    $('.choixHauteurOuLargeurInputs').hide();
    $('.hauteurInput').hide();
    $('.largeurInput').hide();

    // Afficher les questions supplémentaires suivant le bouton coché et vice versa
    //Vider les valeurs remplies lors de changement de choix
    function showOrHide(idClicked, classToShow, classToHide) {
        $(idClicked).on( 'click', function() {
            $(classToHide).hide();
            $(classToShow).show();
        });
    }
    showOrHide('#reduceWeight', '.choixTaille', '.choixProportions');
    showOrHide('#modifyDimensions', '.choixProportions', '.choixTaille');
    showOrHide('#conserverProportions', '.choixHauteurOuLargeur', '.choixHauteurEtLargeur');
    showOrHide('#sansProportions', '.choixHauteurEtLargeur', '.choixHauteurOuLargeur');
    showOrHide('#hauteur', '.hauteurInput', '.largeurInput');
    showOrHide('#largeur', '.largeurInput', '.hauteurInput');

    $('#hauteur').on('click', function() {
        $('input[name="hauteur"]').val('');
        $('input[name="largeur"]').val('');
    });
    $('#largeur').on('click', function() {
        $('input[name="hauteur"]').val('');
        $('input[name="largeur"]').val('');
    });
    $('#sansProportions').on('click', function() {
        $('input[name="hauteurInput"]').val('');
        $('input[name="largeurInput"]').val('');
    });
 
    function readURL(input) { // Affiche l'image au chargement
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    let srcImage = '';
    $("#imgInp").change(function() {
        readURL(this);
    });

    $('#imgInp').on('change', function() { // Affiche le poids de l'image au chargement
        const size =  
        (this.files[0].size / 1024 / 1024).toFixed(2); 
        $("#output").html('<b>' + 
        'Taille de votre image: ' + size + " Mo" + '</b>');      
    }); 
    
</script>
