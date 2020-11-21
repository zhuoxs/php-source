window.onload=function(){
ImageBase64($(".wrapper").find("img"));
}
	function getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, img.width, img.height);
        var ext = img.src.substring(img.src.lastIndexOf(".")+1).toLowerCase();
        var dataURL = canvas.toDataURL("image/"+ext);
        return dataURL;
	}	
	function ImageBase64(obj){
			var thisURL =obj.attr("src");
			var image = new Image();
				image.src = thisURL;
				image.onload = function(){
		    var base64 = getBase64Image(image);
		    obj.attr("src",base64);
		}
}