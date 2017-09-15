taille_ecran = $( window ).height();
taille_footer = $('#footer').height();
taille_footer = $('.bandeau').height();
taille_grd_ecran = taille_ecran;
taille = taille_ecran - taille_footer;
taille2 = taille_ecran - taille_footer;
	$('#page').css('min-height', taille2);
	$('#fct_1').css('min-height', taille_ecran);
	$('#fct_2').css('min-height', taille_ecran);
	$('#fct_3').css('min-height', taille_ecran);

if ($('#bandeau_index')){
	taille_header = $('#bandeau_index').height();
	taille_div = taille_ecran -  taille_footer;
}
$('#ecran_1').css('height', taille_ecran);
$('#ecran_2').css('height', taille_ecran);

$('#ecran_grd_1').css('min-height', taille);
$('#ecran_grd_2').css('min-height', taille);