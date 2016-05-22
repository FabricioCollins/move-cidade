var $nav,
navH,
$navLat,
yinit,
docScrollTop,
docScrollTopLast,
docScrollDir;

$( document ).ready(function() {

	// Controle as expansão do menu lateral
	$('.nav-toggle a').click(function(event) {
		$('.nav-main').toggleClass('open');
	});

	// Controla o componente de cadastro de email
	$('.cadastro .toggle').click(function(event) {
		$('.cadastro .form-wrapper').animate({
			opacity: "toggle",
			height: "toggle",
			width: "toggle",
		}, 300);
		$(this).toggleClass('ativo').find('i').toggleClass('fa-times').toggleClass('fa-bus');
	});

	// Make search on key press after 0.5 second
	var searchEventContainer=null;
	$(".search-input").keyup(function(){
		if(searchEventContainer!=null) clearTimeout(searchEventContainer);

		searchEventContainer=setTimeout(function() {
			$(".cardboard").idecCardBoard().filterByContent($(".search-input").val());
		}, 500);
	});


	$nav = $(".nav-filter");
	navH = $('.menu-main').innerHeight();
	yinit = 0; //navH;

	$(window).scroll(function() {
		if($(window).scrollTop() > $('.header .title').innerHeight()) {
			$nav.parent().addClass('nav-fixed');
		} else {
			$nav.parent().removeClass('nav-fixed');
		}
	});

});	

function getUrlParameter() {
	var url=document.URL;
	if(url.indexOf("#") != -1)
	return url.substring(url.indexOf("#")+1, url.length-1);
}