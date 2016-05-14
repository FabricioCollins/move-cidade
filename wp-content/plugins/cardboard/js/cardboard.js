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
            width: "100%"
        };
        if ( settings ){$.extend(config, settings);}

        // variables
        var obj = $(selector);

        // Methods
        this.shuffle = function() {
            var el=this.find(".col");
            console.log(el);
            var i = el.length, j, tempi, tempj;
            if ( i == 0 ) return el;
            while ( --i ) {
                j       = Math.floor( Math.random() * ( i + 1 ) );
                tempi   = el[i];
                tempj   = el[j];
                el[i]   = tempj;
                el[j]   = tempi;
            }

            this.render(el);
        };

        // Make search based in data-category attribute value
        this.filterByCategory = function(param) {
            this.find("div[data-category]").each(function(){
                if( ($(this).data('category')==param) || (param==null || param=="") )
                    $(this).show("explode");
                else 
                    $(this).hide("explode");
            });
        };

        this.resetFilter = function() {

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