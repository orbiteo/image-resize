<?php

if($_FILES) {
    //Vérifier pas d'erreur, voir:https://www.php.net/manual/fr/features.file-upload.errors.php
    if($_FILES['imageBase']['error'] === 0) { // Si pas d'erreur au chargement de l'image
        $targetdir = '../images_send/';
        $basename = basename($_FILES['imageBase']['name']);
        $targetfile = $targetdir.$basename;
    
        if (move_uploaded_file($_FILES['imageBase']['tmp_name'], $targetfile)) { // enregistrement sur serveur ok
            // Fichier
            $filename = $targetfile;
            list($width, $height) = getimagesize($filename); // largeur et hauteur de l'image

            // L'internaute souhaite diminuer le poids de son image
            if($_POST && $_POST['typeModif'] == "1" && !empty($_POST['choixReduction'])) { // Vérifier qu'il a selectionné un pourcentage de réduction
                switch($_POST['choixReduction']) {
                    case 0: 
                        $compression = 90;
                    break;
                    case 1:
                        $compression = 80;
                    break;
                    case 2:
                        $compression = 70;
                    break;
                    case 3:
                        $compression = 60;
                    break;
                    case 4:
                        $compression = 50;
                    break;
                    case 5:
                        $compression = 40;
                    break;
                    case 6:
                        $compression = 30;
                    break;
                    case 7:
                        $compression = 20;
                    break;
                    default:
                        $compression = 50;
                    
                }
                // pas de modif de dimensions
                $newwidth = $width;
                $newheight = $$height;
            } 
            // L'internaute souhaite modifier les dimensions
            elseif($_POST && $_POST['typeModif'] == "2") {
                if(!empty($_POST['hauteur']) && !empty($_POST['largeur'])) { //Si 2 valeurs remplies donc pas de conservation des proportions
                    $newwidth = intval($_POST['largeur']);
                    $newheight = intval($_POST['hauteur']);
                }
                elseif(!empty($_POST['hauteurInput'])) { // Si uniquement hauteur renseignée
                    $newheight = intval($_POST['hauteurInput']);
                    // coeff de modif
                    $coef = $height/$newheight;
                    $newwidth = ceil($width/$coef); 
                }
                elseif(!empty($_POST['largeurInput'])) { // Si uniquement largeur renseignée
                    $newwidth = intval($_POST['largeurInput']);
                    // coeff de modif
                    $coef = $width/$newwidth;
                    $newheight = ceil($height/$coef); 
                }
                $compression = 100; // pas de compression supplémentaire
            }
            // Chargement
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            $source = imagecreatefromjpeg($filename);
    
            // Redimensionnement
            //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            // voir pour remplacer par imagecopyresampled
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
            // Affichage
            imagejpeg($thumb, '../images_returned/'.$_FILES['imageBase']['name'], $compression);

            //Image 
    
            // Télécharger l'image
            header('Content-disposition: attachment; filename="'.$_FILES['imageBase']['name'].'"');
            header('Content-Type: application/force-download');
            header('Content-Transfer-Encoding: fichier');
            header('Content-Length: '.filesize($thumb));
            header('Pragma: no-cache');
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            readfile('../images_returned/'.$_FILES['imageBase']['name']);

            // Supprimer l'image sur le serveur
            if(unlink($filename) && unlink('../images_returned/'.$_FILES['imageBase']['name'])) { // si fichiers bien supprimer sur serveur
                echo 'ok';
                //renvoyer vers page d'accueil
            } else {
                // envoyer une alerte
                echo 'nok';
            }
            // Libération de la mémoire
            imagedestroy($thumb);
            exit();
    
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