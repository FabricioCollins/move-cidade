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
            this.filterByCategory();
            this.filterByContent();
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