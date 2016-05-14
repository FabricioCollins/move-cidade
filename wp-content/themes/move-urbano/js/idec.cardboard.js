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
        // settings
        var config = {
            
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
                if( (param==null || param=="") || (content.indexOf(param.toLowerCase()) > -1) )
                    $(this).show("explode");
                else 
                    $(this).hide("explode");
            });
        };

        this.resetFilter = function() {
            this.filterByCategory();
            this.filterByContent();
        };

        this.render = function(obj) {
            this.html(obj);
        }; 

        // Main code
        this.main = function() {

        }; 

        // Contructor
        this.init = function(){
            this.main();
        };        

        this.init();

        return this;
    };
})($);