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
    'Poids de votre image: ' + size + " Mo" + '</b>');      
}); 