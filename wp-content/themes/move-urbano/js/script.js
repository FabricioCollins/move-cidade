var $nav;
var linePositionGraph;

$( document ).ready(function() {
	
	// Gráfico de linhas de comparação
	linePositionGraph = new LinePositionGraph("internal-rank-graph-01");

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
			+"city_name=" 		+ $("#city_name").val()
			+"&modal_id=" 		+ $("#modal_id").val();

		$(location).attr('href', url);
	});

	$(".btn-add-line").click(function() {
		var val = $("#add-line-hidden").val();
		$( "#add-line-field" ).val("");
		var cookieValue = Cookies.get("comparable-ranking");
		var blocks = cookieValue.split(";");
		if(blocks.length <= 2) {
			var resultant = val + ";" + cookieValue;
			Cookies.set("comparable-ranking", resultant);
			updateComparableRankingLine();
		}
		else {
			alert("Apenas 2 linhas podem ser adicionadas por vez.");
		}
	});
	
	$(".ds-filter-select").change(function() {
		loadDashboard($("#city_name").val(), $("#modal_id").val());
	});
		
	updateComparableRankingLine();			
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

function loadDashboard(city) {
	$.ajax({
	  url: "./api/get_dashboard_info.php",
	  data:{ 'city_name': city },	  
	  beforeSend: function( xhr ) {
	    xhr.overrideMimeType( "text/plain; charset=UTF-8" );	   
	    $(".dashboard-loading").show();
	  }
	}).done(function( data ) {
		$(".table-cell.ranking,.table-cell.ranking.best,.table-cell.ranking.worst").remove();
	    $(".dashboard-filter-form").after(data);	
	    $(".dashboard").css("display", "table");
	    $(".dashboard-loading").hide();

	    // Animate bars
	    $(".ranking.bars ul li").each(function() {
	    	var bar = $(this).find(".bar");
	    	var rank = bar.data("rank");
	    	bar.animate({ width: rank }, 1500);
	    	bar.tooltip();
	    });
  	});
}

function removeComparableRankingLine(val) {
	var cookieValue = Cookies.get("comparable-ranking");
	var blocks = cookieValue.split(";");
	var resultant = "";

	for(var i in blocks) {
		if(blocks[i] != val && blocks[i] != "")
			resultant += blocks[i]+";";
	}	
	Cookies.set("comparable-ranking", resultant);
	updateComparableRankingLine();
}

function clearComparableRankingLine() {
	Cookies.set("comparable-ranking", "");
	updateComparableRankingLine();
}

function updateComparableRankingLine() {
	var cookieValue = Cookies.get("comparable-ranking");
	if(cookieValue ==  null)
		return;
	var blocks = cookieValue.split(";");
	$("tr.comparable-line").remove();
	
	blocks.reverse();

	linePositionGraph.clearComparisonLines();

	for(var i in blocks) {
		if(blocks[i]=="" || !blocks[i].includes("|"))
			continue;
		
		var data = blocks[i].split("|");		
		var field = "<tr class='comparar comparable-line' data-line='"+blocks[i]+"'>";
		var className="";
		var removeButton="<span class='btn-remove-line'><i class='fa fa-times-circle' aria-hidden='true'></i></span>";
		for(var i in data) {
			if(i>1)
				className="nota";
			field += ("<td class='"+className+"'>"+removeButton+" "+data[i]+"</td>");
			removeButton="";
		}
		field += "</tr>";
		$('.ranking-table > tbody:last tr:eq(1)').after(field);

		var graphPosition = data[8] * 10;
		linePositionGraph.addLine({name:data[0], description: data[1], position: graphPosition});
	}

	// Bind button remove event
	$("span.btn-remove-line").each(function(key, value) {
	  $(value).click(function(){    
	    var val = $(this).parent().parent().data("line");
	    removeComparableRankingLine(val);
	    $(value).parent().parent().remove();
	  });	    
	});
}