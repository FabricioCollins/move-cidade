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
	

	// Dashboard and ranking functions

	$(".filter-select").change(function() {			
		var url="./?"
			+"city_name=" + $("#city_name").val()
			+"&modal_id=" + $("#modal_id").val();

		$(location).attr('href', url);
	});

	$(".add-line-field").select2({
		placeholder: "Digite o número ou nome da linha",
  		allowClear: true
	});

	$(".btn-add-line").click(function() {
		var data = $(".add-line-field").val().split(";");
		var field = "<tr class='comparar'>";
		var className="";
		var removeButton="<a href='#' class='btn-remove-line'><i class='fa fa-times-circle' aria-hidden='true'></i></a>";
			for(var i in data) {
				if(i>1)
					className="nota";

				field += ("<td class='"+className+"'>"+removeButton+" "+data[i]+"</td>");

				removeButton="";
			}

			field += "</tr>";

		$('table > tbody:last tr:eq(1)').after(field);
	});

	$(".btn-remove-line").click(function() {
		console.log(this);
		//$().remove();
	});
	
	$(".ds-filter-select").change(function() {
		loadDashboard($("#city_name").val(), $("#modal_id").val());
	});
	loadDashboard($("#city_name").val(), $("#modal_id").val());
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

function loadDashboard(city, modal) {
	$.ajax({
	  url: "./api/get_dashboard_info.php",
	  data:{ 'city_name': city, 'modal_id': modal, 'limit_count': '3'},
	  beforeSend: function( xhr ) {
	    xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
	    $(".dashboard").hide();
	  }
	}).done(function( data ) {
	    $("#table-ranking").html(data);
	    $(".dashboard").show();
  	});
}