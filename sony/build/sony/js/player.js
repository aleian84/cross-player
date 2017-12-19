var MP = new function() {

	this.video = $("video").get(0);

	this.video.addEventListener("timeupdate" ,this.timeupdate);
	this.video.addEventListener("loadeddata" ,this.loadeddata);
	this.video.addEventListener("ended" ,this.ended);
	this.video.addEventListener("error" , this.error);
	this.video.addEventListener("seeking" , this.seeking);
	this.video.addEventListener("seeking" , this.seeked);

	this.dataObj = [];
	this.btnFocused = 0;
	this.focus = 0;

	$.getJSON( "json/content.json", function(data) {
		
		if (data && data.sony) {

			for (var i=0; i<data.sony.length;i++) {
				MP.dataObj.push(data.sony[i]);
				var b = $('<button id="button_'+i+'" class="button" />')
					.text(data.sony[i].label)
					.css('background-image', 'url(' + data.sony[i].img + ')')
					.click(function () { MP.initialize(MP.dataObj[this.id.substring(this.id.length-1, this.id.length)])});
				$(".buttons-container").append(b);
			}
		}
		if (MP.dataObj && MP.dataObj[0]) {
			$("#button_0").addClass("focus");
		}
	});

	this.initialize = function(content) {	
		var videoUrl = content.url;
		if (content.customData != "") {
			videoUrl = "./webinitiator/webinitiator.php?contentUrl=" + utils.encodeUrl(content.url) + "&CD=" + content.customData;
		}

		$("video").find('source')[0].src = videoUrl;
		$("video").find('source')[0].type = content.type;

		this.video.load();

		this.play();
	
	}

	this.play = function(){
		this.video.play();
	}

	this.pause = function(){
		this.video.pause();
	}

	this.onKeyDown = function(code){
		
		if (code == keycodes.ENTER) {
			this.initialize(this.dataObj[this.btnFocused]);
		}

		if (code == keycodes.UP) {
			if (this.focus == 0){
				this.focus == 1;
			} else {
				this.focus == 0;
			}

		}

		if (code == keycodes.DOWN) {
			if (this.focus == 0){
				this.focus == 1;
			} else {
				this.focus == 0;
			}
		}

		if (code == keycodes.LEFT) {
			$("#button_"+this.btnFocused).removeClass("focus");
			this.btnFocused--;
			if (this.btnFocused < 0){
				this.btnFocused = this.dataObj.length-1;
			}
			$("#button_"+this.btnFocused).addClass("focus");
		}

		if (code == keycodes.RIGHT) {
			$("#button_"+this.btnFocused).removeClass("focus");
			this.btnFocused++;
			if (this.btnFocused > this.dataObj.length-1){
				this.btnFocused = 0;
			}
			$("#button_"+this.btnFocused).addClass("focus");
		}
	}

}

