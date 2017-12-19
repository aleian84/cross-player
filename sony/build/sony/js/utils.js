var utils = new function(){
	
	this.encodeUrl = function(url){
		return encodeURIComponent(url);
	}

	this.decodeUrl = function(url){
		return decodeURIComponent(url);
	}
	
}