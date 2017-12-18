var MP = new function() {

	this.video = $("video").get(0);

	this.video.addEventListener("timeupdate" ,this.timeupdate);
	this.video.addEventListener("loadeddata" ,this.loadeddata);
	this.video.addEventListener("ended" ,this.ended);
	this.video.addEventListener("error" , this.error);
	this.video.addEventListener("seeking" , this.seeking);
	this.video.addEventListener("seeking" , this.seeked);

	this.dataObj = [];

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
	});

	this.initialize = function(content) {
		
		$("video").find('source')[0].src = content.url;
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

}

