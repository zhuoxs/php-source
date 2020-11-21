function dragEvent(obj) {
	var posterIndex = obj.attr('index');
	var posterrs = new Resize(obj, {
		Max : true,
		mxContainer : "#tiger_poster"
	});
	posterrs.Set($(".dRightDown", obj), "right-down");
	posterrs.Set($(".dLeftDown", obj), "left-down");
	posterrs.Set($(".dRightUp", obj), "right-up");
	posterrs.Set($(".dLeftUp", obj), "left-up");
	posterrs.Set($(".dRight", obj), "right");
	posterrs.Set($(".dLeft", obj), "left");
	posterrs.Set($(".rUp", obj), "up");
	posterrs.Set($(".rDown", obj), "down");
	posterrs.Scale = true;
	var type = obj.attr('type');
	if (type == 'name' || type == 'img' || type == 'code') {
		posterrs.Scale = false;
	}
	new Drag(obj, {
		Limit : true,
		mxContainer : "#tiger_poster"
	});
	$('.drag .remove').unbind('click').click(function() {
		$(this).parent().remove();
	})

	$.contextMenu({
		selector : '.drag[index=' + posterIndex + ']',
		callback : function(key, options) {
			var zindex = parseInt($(this).attr('zindex'));

			if (key == 'prev') {
				var prevdiv = $(this).prev('.drag');
				if (prevdiv.length > 0) {
					$(this).insertBefore(prevdiv);
				}
			} else if (key == 'next') {
				var nextdiv = $(this).next('.drag');
				if (nextdiv.length > 0) {
					nextdiv.insertBefore($(this));
				}
			} else if (key == 'last') {
				var len = $('.drag').length;
				if (zindex >= len - 1) {
					return;
				}
				var last = $('#tiger_poster .drag:last');
				if (last.length > 0) {
					$(this).insertAfter(last);
				}
			} else if (key == 'first') {
				var zindex = $(this).index();
				if (zindex <= 1) {
					return;
				}
				var first = $('#tiger_poster .drag:first');
				if (first.length > 0) {
					$(this).insertBefore(first);
				}
			} else if (key == 'delete') {
				$(this).remove();
			}
			var n = 1;
			$('.drag').each(function() {
				$(this).css("z-index", n);
				n++;
			})
		},
		items : {
			"next" : {
				name : "移动到上一层"
			},
			"prev" : {
				name : "移动到下一层"
			},
			"last" : {
				name : "移动到最顶层"
			},
			"first" : {
				name : "移动到最低层"
			},
			"delete" : {
				name : "删除元素"
			}
		}
	});

	obj.unbind('click').click(function() {
		tiger_bind($(this));
	})
}

function deleteTimers() {
	clearInterval(imgcounter);
	clearInterval(ncounter);
	clearInterval(bscounter);
}
function getUrl(val) {
	if (val.indexOf('http://') == -1) {
		val = attachurl + val;
	}
	return val;
}

function PreviewImg(imgFile){
    var image = new Image();
	image.src = imgFile;
	return image;
}

$('#posterbg').find('button:first').click(function(){
    var oldbg = $(':input[name=bg]').val();
    bscounter = setInterval(function(){
         var bg = $(':input[name=bg]').val();
         if(oldbg!=bg){
        	 var img = PreviewImg(attachurl+bg);
        	 $('#bgtd').css('width',img.width/2+'px').css('height',img.height/2+'px');
        	 $('#tiger_poster').css('width',img.width/2+'px').css('height',img.height/2+'px');
        	 
               if(bg.indexOf('http://')==-1){
                    bg = attachurl + bg;
               }
              $('#tiger_poster .bg').remove();
              var bgh = $("<img src='" + bg + "' class='bg' style='width:"+img.width/2+"px;height:"+img.height/2+"px'/>");
               var first = $('#tiger_poster .drag:first');
                if(first.length>0){
                   bgh.insertBefore(first);  
                } else{
                   $('#tiger_poster').append(bgh);      
                }
               
              oldbg = bg;
         }
    },10);
})