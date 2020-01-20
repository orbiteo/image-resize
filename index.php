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
        <img id="blah" src="#" alt="your image" width="300"/>

        <!-- afficher en live le poids de l'image chargée -->

        <!-- choix 1 réduire le poids de l'image sans toucher les dimensions -->
        <label for="">Vous souhaitez :</label><br>
        <input type="radio" name="typeModif" value="1"> Réduire le poids de mon image<br>

        <!-- choix 2 modifier les dimensions de l'image -->
        <input type="radio" name="typeModif" value="2"> Modifier les dimensions de mon image<br>

            <!-- en gardant les proportion donc en choisissant une largeur OU une hauteur fixe -->
            <input type="radio" name="proportions" value="1"> En conservant les proportions<br>

            <!-- sans respect des proportions donc avec largeur ET hauteur fixes -->
            <input type="radio" name="proportions" value="2"> En choisissant une hauteur et une largeur fixes

        <input type="submit" value="TÉLÉCHARGER">
    </form>
</body>
</html>
<script
	src="https://code.jquery.com/jquery-3.4.1.min.js"
	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	crossorigin="anonymous"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
                console.log(e.target);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function() {
        readURL(this);
    });
</script>
