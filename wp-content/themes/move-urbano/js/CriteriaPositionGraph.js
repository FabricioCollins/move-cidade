function CriteriaPositionGraph(elementId) {
	var self=this;

	this.selectedLines = [];
	this.graphContainer = "";	

	this.addLine = function(object) {
		if(this.selectedLines.length < 2) {
			this.selectedLines.push(object);
			this.renderLine(object);
		}
		else {
			//alert("Apenas 2 linhas podem ser adicionadas por vez.");
		}
	};

	this.renderLines = function(lines) {
		for(var i in this.selectedLines) {
			this.addLine(this.selectedLines[i]);
		}
	}

	this.renderLine = function(line) {
		var lineName = line.lineName;
		var lineDescription = line.lineDescription;
		for (var i in line.criterias) {
			var criteria = line.criterias[i];
			var value = criteria.value;
			var code = criteria.code;
			var label = criteria.label;

			var position_percent = value*10;

			var element = this.graphContainer.find(".graph-body .graph-column .graph-bar#" + code);
			if(element) {				
				var averageValue = element.find(".graph-bar-level").data("criteria");
				var cssClass = (position_percent < averageValue)? "bad" : "good";
				var lineTitle = lineName+': '+lineDescription + "(" + label + ": " + (value) + ")";
				var html='<div class="criteria-point '+cssClass+'" style="bottom: 0px; left: '+((element.width()/2)-7)+'%;" data-name="'+lineName+'" data-type="point" data-percent="'+position_percent+'" title="'+lineTitle+'"><div class="line-name">'+lineName+'</div></div>';
				element.append(html);
				element.find("[data-type='point'][data-name='"+lineName+"']").animate({bottom: (position_percent)+"%"}, 1000, function(){
					$(this).find(".line-name").fadeIn("slow");
					$(this).tooltip();
				});
			}
		}
		
	};

	this.clearGraphLines = function() {
		this.graphContainer.find(".criteria-point").remove();
	};

	this.clearLines = function() {
		this.selectedLines = [];
		this.clearGraphLines();
	};

	this.startGraph = function() {
		this.graphContainer.find(".graph-body .graph-bar .graph-bar-level").each(function() {
			var item = $(this);						
			var h=item.data("criteria");
			item.prop('title', (h/10));
			item.tooltip();
			item.animate({height: h+"%"}, 500);
		});
	};

	this.createGraph = function() {
		this.startGraph();
	};

	this.init = function() {
		this.graphContainer = $("#"+elementId);
		if(this.graphContainer)
			this.createGraph();
	};

	this.init();
}