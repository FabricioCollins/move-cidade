function LinePositionGraph(elementId) {
	var self=this;

	this.selectedLines = [];
	this.graphContainer = "";
	this.generalAverage = 50;
	
	this.addLine = function(object) {
		if(this.selectedLines.length < 2) {
			this.selectedLines.push(object);
			this.renderComparitionLine(object);
		}
		else {
			//alert("Apenas 2 linhas podem ser adicionadas por vez.");
		}
	};

	this.removeLine = function(name) {
		var items = this.selectedLines;
		for (var i = 0; i < items.length; i++) {
	    	if (items[i].name && items[i].name === name) { 
	       		items.splice(i, 1);
	       		self.graphContainer.find("[data-name='"+name+"']").remove();
	        	break;
	        }
	    }
	};

	this.addAverageLine = function(value) {			
		var graphPosition = value;
		console.log(value);
		this.generalAverage	= graphPosition;
		var line='<div class="average-criteria-line" style="bottom: 0%; display: none;" data-percent="'+graphPosition+'" title="'+graphPosition+'%"><div class="description">Média Geral ('+graphPosition/10+')</div></div>';
		this.graphContainer.append(line);

		setTimeout(function() {
			self.graphContainer.find(".average-criteria-line").each(function() {	
				$(this).tooltip();
				var b=$(this).data("percent");	
				$(this).show().animate({bottom: (b-1)+"%"}, 1000, function() {
					self.graphContainer.find(".description").fadeIn("slow");
				});
			});
		}, 1000);
	};

	this.clearGraphComparisonLines = function() {
		this.graphContainer.find(".stick.comparison-line").remove();
	};

	this.clearLines = function() {
		this.selectedLines = [];
		this.clearGraphComparisonLines();
	};

	this.renderComparitionLine = function(object) {		
		var position = object.position;
		var position_percent = (object.position*10);
		var name = object.name;
		var description = object.description;
		var cssClass = (position_percent < this.generalAverage)? "bad" : "good";
		if(this.selectedLines.length > 1) {
			if(this.selectedLines[0].position == object.position) {
				cssClass = cssClass + ' upper';
			}
		}

		var lineTitle = name+': '+description + "(" + position + ")";
		var html_stick='<div class="stick comparison-line '+cssClass+'" style="height: 0%; right: '+(position_percent-1)+'%;" data-percent="'+position_percent+'" data-name="'+name+'" title="'+lineTitle+'"><div class="line-name">'+name+'</div><div class="line-rank">'+position+'</div></div>';

		this.graphContainer.append(html_stick);

		setTimeout(function() {
			self.graphContainer.find("[data-name='"+name+"']").each(function() {
				var item = $(this);
				item.tooltip();
				var h=item.data("percent");
				item.animate({height: h+"%"}, 500, function(){
					item.find(".line-name").show("explode");
					item.find(".line-rank").show("explode");
				});
			});
		}, 1000);		
	};

	this.renderComparitionLines = function() {
		for(var i in this.selectedLines) {
			this.renderComparitionLine(this.selectedLines[i]);
		}
	};

	this.createGraph = function() {
		var sticks=100;
		for(var i = sticks; i > 0; i--) {
			var mtop=(sticks-i)+1;
			self.graphContainer.append('<div class="stick" style="height: 0px; top: '+mtop+'%;" title="'+i+'%" data-percent="'+(i-1)+'"></div>');
		}

		self.graphContainer.append('<div class="descripion-line vert">Notas</div>');
		self.graphContainer.append('<div class="descripion-line horz">Linhas</div>');

		setTimeout(function() {
			self.graphContainer.find(".stick").each(function() {
				var value=$(this).data("percent");
				$(this).animate({height: value+"%"});
				//$(this).tooltip();
			});
		}, 500);
	};

	this.init = function() {
		this.graphContainer = $("#"+elementId);
		if(this.graphContainer)
			this.createGraph();
	};

	this.init();
}