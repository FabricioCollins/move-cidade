$(document).ready(function(){

	// conteudo03
	var galeriaItem = $('.conteudo03 .galeria li');
	// var galeriaLength = galeriaItem.length;
	var galeriaItemOn = 0;
	var galeriaItemCount = galeriaItem.length - 1;

	$('.conteudo03 .galeria li').not(':first-child').hide();
	$('.conteudo03 .galeria-nav-prev').click(function(event) {
		galeriaItem.eq(galeriaItemOn).hide();
		if(galeriaItemOn > 0) {
			galeriaItemOn -= 1;
		} else {
			galeriaItemOn = galeriaItemCount;
		}
		galeriaItem.eq(galeriaItemOn).show();
	});
	$('.conteudo03 .galeria-nav-next').click(function(event) {
		galeriaItem.eq(galeriaItemOn).hide();
		if(galeriaItemOn < galeriaItemCount) {
			galeriaItemOn += 1;
		} else {
			galeriaItemOn = 0;
		}
		galeriaItem.eq(galeriaItemOn).show();
	});


	// conteudo07
	$('.aba').not('#aba-reclamando').addClass('hide');
	$('.abas-menu a[href="#aba-reclamando"]').parent().addClass('ativo');
	$('.abas-menu a').click(function(event) {
		event.preventDefault();
		$(this).parent().addClass('ativo').siblings().removeClass('ativo');
		var id = $(this).attr('href');
		$(id).removeClass('hide').siblings().addClass('hide');
	});

	//conteudo 15
	$('.conteudo15 .imagens .toggle, .conteudo15 .imagens .vazio').click(function(event) {
		$(this).parent().find('.texto').toggleClass('hide');
	});

	// conteudo19
	$('#cod_estados').change(function(){
		if( $(this).val() ) {
			$('#cod_cidades').hide();
			$('.carregando').show();
			var options = '<option value="">Selecione</option>';	
			options += '<option value="belo_horizonte">Belo Horizonte</option>';	
			$('#cod_cidades').html(options).show();
			$('.carregando').hide();
			$('.cidades').addClass('ativo');
		} else {
			$('.resultado').hide();
			$('#cod_cidades').html('<option value="">– Escolha um estado –</option>');
			$('.cidades').removeClass('ativo');
		}
	});
	$('#cod_cidades').change(function(){
		if( $(this).val() ) {
			$('.resultado').show();
		} else {
			$('.resultado').hide();
		}
	});

});
