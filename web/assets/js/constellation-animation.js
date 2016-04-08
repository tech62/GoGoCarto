function toggleFournisseurDetailsComplet()
{	
	window.console.log('toggle');
	if ( $('#bandeau_detail .moreDetails').is(':visible') )
	{
		hideFournisseurDetailsComplet();
	}
	else
	{
		var bandeau_detail_new_height = $( window ).height()
		-$('header').height()
		-$('#bandeau_plus_resultats').outerHeight(true);

		$('#bandeau_detail').css('height', bandeau_detail_new_height);
		ajuster_taille_carte(bandeau_detail_new_height);	

		$("#btn_menu").hide();
		$('#bandeau_detail .moreDetails').show();
	}	
}

function hideFournisseurDetailsComplet()
{
	setTimeout(function(){$("#btn_menu").show();},1000);
	$('#bandeau_detail .moreDetails').hide();

	var bandeau_detail_new_height = $('#detail_fournisseur').height();

	$('#bandeau_detail').css('height', bandeau_detail_new_height);
	ajuster_taille_carte(bandeau_detail_new_height);	
}


function ajuster_taille_composants()
{	
	$("#bandeau_option").css('height',$( window ).height()-$('header').height());
	ajuster_taille_carte();
}

function ajuster_taille_carte(bandeau_detail_height = $('#bandeau_detail').height())
{	
	/*window.console.log('taille carte: detail -> ' + bandeau_detail_height);*/
	$("#map").css('height',$( window ).height()
		-$('header').height()
		-$('#bandeau_plus_resultats').outerHeight(true)
		-bandeau_detail_height);
}

function animate_up_bandeau_detail()
{
	var bandeau_detail_new_height = $('#detail_fournisseur').height();

	$('#bandeau_detail').css('height', bandeau_detail_new_height);
	ajuster_taille_carte(bandeau_detail_new_height);	
}

function animate_down_bandeau_detail()
{
	hideFournisseurDetailsComplet();
	$('#bandeau_detail').css('height','0');
	ajuster_taille_carte(0);	
}

function animate_up_bandeau_options()
{
	$('#overlay').css('z-index','15');
	$('#overlay').css('opacity','1');
	$("#bandeau_option").css('left','0');
}

function animate_down_bandeau_options()
{
	$('#overlay').css('z-index','-1');
	$('#overlay').css('opacity','0');
	$("#bandeau_option").css('left','-200px');
}
