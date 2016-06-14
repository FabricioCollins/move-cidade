/*
* 
* Dependency: Jquery 1.12.2 or >
*  
* Developer: Fabricio Silva de Souza
* E-mail: fabricio.collins@gmail.com
* Phone: +55 31 9 9107-4760
*/

(function($){
    $.fn.dock = function(selector, settings){

        var self = this;

        // settings
        var config = {
            'itemWidth': 240,
            'itemHeight': 110
        };
        if ( settings ){$.extend(config, settings);}

        // variables
        var object = $(this);
        var items = object.children().first();

        // Bind Events
        this.bindEvents = function(param) {      
            object.mousemove(function( event ) {                
                var boxPosX = object.offset().left;
                var boxWidth = object.innerWidth();
                var menuWidth = items.innerWidth() - boxWidth;                
                items.css('left', (-(event.pageX - boxPosX) * menuWidth / boxWidth) + 'px');
            });

            $('.'+items.attr('class')+" li").mouseover(function( event ) {                
                $(this).css({
                    width: config.itemWidth+40+'px',
                    height: config.itemHeight+50+'px',
                    marginTop: '0'
                }).next().css({
                    width: config.itemWidth+20+'px',
                    height: config.itemHeight+35+'px',
                    marginTop: '15px'
                }).prev().prev().css({
                    width: config.itemWidth+20+'px',
                    height: config.itemHeight+35+'px',
                    marginTop: '15px'
                });
            }).mouseout(function(event) {
                $(this).css({
                    width: config.itemWidth+'px',
                    height: config.itemHeight+'px',
                    marginTop: '30px'
                }).next().css({
                    width: config.itemWidth+'px',
                    height: config.itemHeight+'px',
                    marginTop: '30px'
                }).prev().prev().css({
                    width: config.itemWidth+'px',
                    height: config.itemHeight+'px',
                    marginTop: '30px'
                });

                //items.animate({left, '0px'}, 300);

            });
        };

        // Contructor
        this.init = function(){
            this.bindEvents();
        };        

        self.init();

        return this;
    };
})($);