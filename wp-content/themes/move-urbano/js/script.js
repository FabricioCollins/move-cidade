var $nav;

$( document ).ready(function() {
	// Controle as expansão do menu lateral
	$('.nav-toggle a').click(function(event) {
		$('.nav-main').toggleClass('open');
	});

	// Show/Hide responsive category
	$('.menu-toggle a').click(function(event) {
		$(this).parent().toggleClass('ativo').siblings('.menu').toggleClass('open');
	});

	// Controla o componente de cadastro de email	
	// cadastro
	$('.cadastro .toggle').click(function(event) {
		toggleCadastro($(this), 300);
	});
	if($(window).width() < 1024) 
		toggleCadastro($('.cadastro .toggle'), 500);

	// Make search on key press after 0.5 second
	var searchEventContainer=null;
	$(".search-input").keyup(function(){
		if(searchEventContainer!=null) clearTimeout(searchEventContainer);

		searchEventContainer=setTimeout(function() {
			$(".cardboard").idecCardBoard().filterByContent($(".search-input").val());
		}, 500);
	});

	// Salesforce Integration
	$("#idec-mailing-form").submit(function(event){
		event.preventDefault();
		var form=$(this);		
		jQuery.support.cors = true;
		$.ajax({
			url: form.attr("action"),
		  	method: form.attr("method"),
		  	data: form.serialize(),
		  	crossDomain: false,
		  	dataType: 'text/html',
		  	headers: {'X-Requested-With': 'XMLHttpRequest'},
			beforeSend: function( xhr ) {
				xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
  				xhr.setRequestHeader("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
				$(".mailing").find(".send").attr("disabled", true).val("Enviando...");
			},
		  	error: function (request, status, error) {
        		console.log(request.responseText);
		    	$(".mailing").find(".erro").show("Slide");
		   	}
		}).done(function(data) {			
	  		$(".form-wrapper").html("<p class='info'>Obrigado por se cadastrar no Move Cidade</p>");	  		
		});
		$(".mailing").find(".send").attr("disabled", false).val("Enviar"); 
		return false;
	});
});	

$(window).scroll(function() {

	$nav = $(".nav-filter");

	// fixar o menu no topo
	if($(window).scrollTop() > $('.header .title').innerHeight() && $(window).width() > 480) {
		$nav.parent().addClass('nav-fixed');
		$('.nav-main').addClass('ajustar');
	} else {
		$nav.parent().removeClass('nav-fixed');
		$('.nav-main').removeClass('ajustar');
	}

	// fechar cadastro
	if(!$('.cadastro .toggle').hasClass('ativo')) toggleCadastro($('.cadastro .toggle'), 300);
}); 

function getUrlParameter() {
	var url=document.URL;
	if(url.indexOf("#") != -1)
	return url.substring(url.indexOf("#")+1, url.length);
}

function toggleCadastro($this, duration) {
	$('.cadastro .form-wrapper').animate({
		opacity: "toggle",
		height: "toggle",
		width: "toggle",
	}, duration);
	$this.toggleClass('ativo').find('i').toggleClass('fa-times');
}