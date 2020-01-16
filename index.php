<!DOCTYPE html>
<html>
<head>
    <title>Modification images</title>
</head>
<body>
    <form method="post" action="controleur/image-treatment.php" enctype="multipart/form-data">
        <label for="">Téléchargez votre image à modifier</label>
        <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!-- Max 1 Mo -->
        <input type="file" name="imageBase">
        <input type="submit" value="MODIFIER">
    </form>
</body>
</html>
