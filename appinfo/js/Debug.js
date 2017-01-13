function Debug(){
	var logCount = 0;
	var logDiv = null;
	
	this.assignLogDiv = function(div){
		logDiv = div;
	}
	
	this.log = function(text, error = false) {
		if(logDiv == null)
			return;
			
		if (text) {
			var id = " -> " + logCount;
			style = "warning";
			
			if (error == true) {
				id += " Error";
				style = "error";
			}
	
			logDiv.prepend("<p class='"+ style +"'>" + id + ": " + text + " </p>");
			logCount++;
		}
	}

	this.clearLog = function() {
		if(logDiv == null)
			return;
		
		logCount = 0;
		logDiv.empty();
	}
}