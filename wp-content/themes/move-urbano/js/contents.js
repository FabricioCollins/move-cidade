$(document).ready(function(){

	// conteudo03, conteudo 06
	$('.galeria-wrapper').each(function(index, el) {
		$galeriaWrapper = $(this);
		var galeriaItem = $galeriaWrapper.find('.galeria li');
		// var galeriaLength = galeriaItem.length;
		var galeriaItemOn = 0;
		var galeriaItemCount = galeriaItem.length - 1;

		$galeriaWrapper.find('.galeria-nav-prev').hide().click(function(event) {
			if(galeriaItemOn > 0) {
				galeriaItem.eq(galeriaItemOn).hide();
				galeriaItemOn -= 1;
				galeriaItem.eq(galeriaItemOn).show();
				$(this).parent().find('.galeria-nav-next').show();
			}
			if(galeriaItemOn <= 0) {
				$(this).hide();
				$(this).parent().find('.galeria-nav-next').show();
			}
		});
		$galeriaWrapper.find('.galeria-nav-next').click(function(event) {
			if(galeriaItemOn < galeriaItemCount) {
				galeriaItem.eq(galeriaItemOn).hide();
				galeriaItemOn += 1;
				galeriaItem.eq(galeriaItemOn).show();
				$(this).parent().find('.galeria-nav-prev').show();
			}
			if(galeriaItemOn >= galeriaItemCount) {
				$(this).hide();
				$(this).parent().find('.galeria-nav-prev').show();
			}
		});
	});

	$('.conteudo04 img, .conteudo06 img').click(function(event) {
		$(this).toggleClass('expand');
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

	//conteudo09
	$('.conteudo09 .imagem-legenda-interativa .imagem-sobreposta a').click(function(event) {
		event.preventDefault();
		var id = $(this).attr('href');
		$(id).addClass('visible').siblings().removeClass('visible');
		desaturate($(this));
	});
	$('.conteudo09 .imagem-legenda-interativa .next').click(function(event) {
		event.preventDefault();
		var $visible = $(this).parent().parent().find('.imagem-destaque.visible');
		if($visible.next().length > 0) {
			$visible.removeClass('visible').next().addClass('visible');
		} else {
			$visible.removeClass('visible').parent().parent().find('.imagem-destaque:first-child').addClass('visible');
		}
		desaturate($(this));
	});

	$('.conteudo09 .imagem-legenda-interativa .prev').click(function(event) {
		event.preventDefault();
		var $visible = $(this).parent().parent().find('.imagem-destaque.visible');
		if($visible.prev().length > 0) {
			$visible.removeClass('visible').prev().addClass('visible');
		} else {
			$visible.removeClass('visible').parent().parent().find('.imagem-destaque:last-child').addClass('visible');
		}
		desaturate($(this));
	});

	//conteudo 15
	$('.conteudo15 .imagens .toggle, .conteudo15 .imagens .vazio').click(function(event) {
		$(this).parent().find('.texto').toggleClass('c15hide');
	});

	// conteudo19
	/*$('#cod_estados').change(function(){
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
			$('#cod_cidades').html('<option value="">–- Escolha um estado –-</option>');
			$('.cidades').removeClass('ativo');
		}
	});
	$('#cod_cidades').change(function(){
		if( $(this).val() ) {
			$('.resultado').show();
		} else {
			$('.resultado').hide();
		}
	});*/

});

function desaturate($this) {
	$visible = $this.parent().parent().find('.imagem-destaque.visible');
	$imagembase = $this.closest('.imagem-legenda-interativa').find('.imagem-base');
	if($visible.hasClass('vazio')) {
		$imagembase.removeClass('desaturate');
	} else {
		$imagembase.addClass('desaturate');
	}
}