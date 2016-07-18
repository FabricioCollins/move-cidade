/*
* 
* Dependency: Jquery 1.12.2 or >
*  
* Developer: Fabricio Silva de Souza
* E-mail: fabricio.collins@gmail.com
* Phone: +55 31 9 9107-4760
*/

(function($){
    $.fn.idecCardBoard = function(selector, settings){

        var self = this;

        // settings
        var config = {
            'menuSelector': '.nav-categories'
        };
        if ( settings ){$.extend(config, settings);}

        // variables
        var obj = $(selector);

        // Make search based in data-category attribute value
        this.filterByCategory = function(param) {
            this.find("div[data-category]").each(function(){                
                if( ($(this).data('category').indexOf(param) > -1) || (param==null || param=="") )
                    $(this).show("explode");
                else 
                    $(this).hide("explode");
            });
        };

        // Make search based in element dynamic content
        this.filterByContent = function(param) {
            this.find(".col").each(function(){ 
                var content=$(this).find("a").html().toLowerCase() + " " + $(this).find("p").html().toLowerCase();
                if( (param==null || param=="") || (self.removeAccent(content).indexOf(self.removeAccent(param).toLowerCase()) > -1) )
                    $(this).show("explode");
                else 
                    $(this).hide("explode");
            });
        };

        // Remove filter and reset component to initial state
        this.resetFilter = function() {
            self.filterByCategory();
            self.filterByContent();
        };

        // This function is used by remove accents in a word or text
        this.removeAccent = function(str) {
            var output="";
            var str_accent= "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";  
            var str_without_accent = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";                
            for (var i = 0; i < str.length; i++) {
                if (str_accent.indexOf(str.charAt(i)) != -1) {
                    output+=str_without_accent.substr(str_accent.search(str.substr(i,1)),1);
                } else {
                    output+=str.substr(i,1);
                }
            }
            return output;  
        };

        // Distribui cores aleatórias aos cards
        this.setCardsRandomColours = function() {
            this.find('.col').each(function(index, el) {
                $(this).addClass('cor-' + Math.floor((Math.random() * 3) + 1));
            });
        };

        // Atribui a categoria dos menus aos conteúdos
        this.joinMenuCardCategories = function() {
            $(config.menuSelector).find("li[data-target]").each(function(index, el){                
                $(this).click(function() {
                    $("li[data-target]").not($(this)).removeClass("selected");
                    if($(this).hasClass("selected")) {
                        self.resetFilter();
                        $(this).removeClass("selected");
                    }
                    else {
                        self.filterByCategory($(this).data("target"));
                        $(this).addClass("selected");
                    }
                    $(".responsivo-show.menu-toggle a").click();
                });
            });
        };

        this.render = function(obj) {
            this.html(obj);
        }; 

        // Contructor
        this.init = function(){
            
        };        

        self.init();

        return this;
    };
})($);