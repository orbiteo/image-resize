<?php

//var_dump($_FILES);
if($_FILES) {
    //Vérifier pas d'erreur, voir:https://www.php.net/manual/fr/features.file-upload.errors.php
    if($_FILES['imageBase']['error'] === 0) { // Si pas d'erreur au chargement de l'image
        $targetdir = '../images_send/';
        $basename = basename($_FILES['imageBase']['name']);
        $targetfile = $targetdir.$basename;
    
        if (move_uploaded_file($_FILES['imageBase']['tmp_name'], $targetfile)) { // enregistrement sur serveur ok
            // Fichier et nouvelle taille
            $filename = $targetfile;
            $percent = 0.5;
    
            // Calcul des nouvelles dimensions
            list($width, $height) = getimagesize($filename);
            $newwidth = $width * $percent;
            $newheight = $height * $percent;
    
            // Chargement
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            $source = imagecreatefromjpeg($filename);
    
            // Redimensionnement
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
            // Affichage
            imagejpeg($thumb, '../images_returned/'.$_FILES['imageBase']['name']);

            //Image 
    
            // Télécharger l\'image
            header('Content-disposition: attachment; filename="'.$_FILES['imageBase']['name'].'"');
            header('Content-Type: application/force-download');
            header('Content-Transfer-Encoding: fichier');
            header('Content-Length: '.filesize($thumb));
            header('Pragma: no-cache');
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            readfile('../images_returned/'.$_FILES['imageBase']['name']);
            exit();

            // Supprimer l'image sur le serveur
            if(unlink($targetfile) && unlink('../images_returned/'.$_FILES['imageBase']['name'])) { // si fichiers bien supprimer sur serveur
                echo 'ok';
                //renvoyer vers page d'accueil
            } else {
                // envoyer une alerte
            }

            // Libération de la mémoire
            imagedestroy($thumb);
    
        } else { // enregistrement sur serveur nok
        echo 'Votre image n\'a pas pu être téléchargée veuillez essayer à nouveau';
        }
    } elseif($_FILES['imageBase']['error'] === 1 || $_FILES['imageBase']['error'] === 2) {
        echo 'Image trop lourde, maximum 1Go';
    } else {
        echo 'Un problème est survenu dans le téléchargement de votre image, veuillez essayer à nouveau';
    }
    
} else {
    echo 'Merci de télécharger une image';
}


?>