var keycodes = new function() {

	document.onkeydown = function(e){
		MP.onKeyDown(e.which);
	}

	this.ENTER = 13;
	this.UP = 38;
	this.DOWN = 40;
	this.LEFT = 37;
	this.RIGHT = 39;
	
}