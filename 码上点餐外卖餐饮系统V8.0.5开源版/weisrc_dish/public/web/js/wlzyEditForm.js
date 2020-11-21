/*
 *  Document   : yqdtPage.js
 *  Author     : yxw
 *  Description: 鐝骇鐩稿唽鍜屽疂瀹濅綔鍝佺鐞嗛〉闈�
 */

var ctx = $("#ctx").val();
var wlzyType = $("#wlzyType").val();
var orgcode = $("#orgcode").val();
var currentPage = $("#currentPage").val();
var appid = $("#appid").val();

$(window).load(function() {
	var imgDiv = $(".img");
	for (var i = 0; i < imgDiv.length; i++) {
		if(imgDiv.eq(i).find("img").height() < imgDiv.eq(i).find("img").width()){
			imgDiv.eq(i).find("img").css("height","100%");
			imgDiv.eq(i).find("img").css("left","50%");
			imgDiv.eq(i).find("img").css("margin-left",-imgDiv.eq(i).find("img").width()/2);
		}else{
			imgDiv.eq(i).find("img").css("width","100%");
			imgDiv.eq(i).find("img").css("top","50%");
			imgDiv.eq(i).find("img").css("margin-top",-imgDiv.eq(i).find("img").height()/2);
		}
	}
	
	var imgDivs = $(".imgs");
	for (var i = 0; i < imgDivs.length; i++) {
		//澶栭潰杈规鐨勭殑楂樺姣斾緥
		var H_W = imgDivs.eq(i).height() / imgDivs.eq(i).width();
		//鍥剧墖鐨勯珮瀹芥瘮渚�
		var h_w = imgDivs.eq(i).find("img").height() / imgDivs.eq(i).find("img").width();
		if(H_W > 1 && H_W > h_w){
			maxHeight(imgDivs.eq(i));
		}else if(H_W > 1 && H_W < h_w){
			maxWidth(imgDivs.eq(i));
		}else if(H_W < 1 && H_W > h_w){
			maxHeight(imgDivs.eq(i));
		}else if(H_W < 1 && H_W < h_w){
			maxWidth(imgDivs.eq(i));
		}else if(H_W = 1 && h_w > 1){
			maxWidth(imgDivs.eq(i));
		}else if(H_W = 1 && h_w < 1){
			maxHeight(imgDivs.eq(i));
		}else{
			maxWidth(imgDivs.eq(i));
		}
	}
	
	var content = $(".content");
	for (var i = 0; i < content.length; i++) {
		/*if(content.eq(i).find("a").html().length > 23){
			content.eq(i).find("a").html(content.eq(i).find("a").html().substr(0,23) + "...");
		}else{
			content.eq(i).find("a").html(content.eq(i).find("a").html().substr(0,23));
		}*/
	}
	
	var publishdate = $("span[name='publishdate']");
	for (var i = 0; i < publishdate.length; i++) {
//		var yyyy = publishdate.eq(i).html().substring(0,4);
//		var MM = publishdate.eq(i).html().substring(5,7);
//		var dd = publishdate.eq(i).html().substring(8,10);
//		publishdate.eq(i).html(yyyy + "." + MM + "." + dd);
		publishdate.eq(i).html(publishdate.eq(i).html().substring(5));
	}
	
	function maxWidth(obj){
		obj.find("img").css("width","100%");
		obj.find("img").css("top","50%");
		obj.find("img").css("margin-top",-obj.find("img").height()/2);
	}
	
	function maxHeight(obj){
		obj.find("img").css("height","100%");
		obj.find("img").css("left","50%");
		obj.find("img").css("margin-left",-obj.find("img").width()/2);
	};
	
	initWebUploader();
});

$(document).ready(
	function() {
		$("#school-chosen").change(function() {
			$("#bj-chosen").val("");
			$("#rq-chosen").val("");
			query_wlzy(1);
		});
		$("#bj-chosen").change(function() {
			query_wlzy(1);
		});
		$("#rq-chosen").change(function() {
			query_wlzy(1);
		});
		$("#state-chosen").change(function() {
			query_wlzy(1);
		});
		$("#search-btn").click(function() {
			query_wlzy(1);
		});
		$("#addPageBtn").click(function() {
			location.href = ctx + "/klxx/wlzy/toForm/" + wlzyType+ "?id=0&appid="+appid;
		});
		$("#school-chosen-add").change(function() {
			findBjandXsByCampusid();
		});
		$("#bj-chosen-add").change(function() {// 鏌ヨ
//			getXsjbByBjid();
		});
		$("#publishBtn").click(function() {// 鏌ヨ
			saveInfo();
		});
});

function getXsjbByBjid(){
	var wlzytype = $("#wlzyType").val();
	if(wlzytype == 6){// 瀹濆疂浣滃搧
		sendtype == 2;
	}
	var bjid = $("#bj-chosen-add").val();
	var url=ctx+"/xtgl/xsjb/ajax_queryJsonXsjbByBjid/"+bjid+"/0";
	var submitData = {
			bjid : bjid,
			stuids : 0
	};
	$.get(url,submitData,function(data){
		var datas = eval(data);
		var stuSelect = $("select[name=xcForm_stus]");
		$("select[name=xcForm_stus] option").remove();
		for (var i = 0; i < stuSelect.length; i++) {
			for(var j=0;j<datas.length;j++){
			    stuSelect.eq(i).append("<option value=" + datas[j].id+" >" + datas[j].xm + "</option>");
			};
		stuSelect.eq(i).multiselect('refresh');
		}
	});
}

function findBjandXsByCampusid(){
	var url = ctx + "/klxx/wlzy/ajax_change_bj";
	var submitData = {
		campusid : $("#school-chosen-add").val()
	};
	$.post(url, submitData,
			function(data) {
				var datas = eval(data);
				$("#bj-chosen-add option").remove();// user涓鸿缁戝畾鐨剆elect锛屽厛娓呴櫎鏁版嵁
				for ( var i = 0; i < datas.length; i++) {
					$("#bj-chosen-add").append(
							"<option value=" + datas[i].id
									+ ">" + datas[i].bj
									+ "</option>");
				}
				;
				$("#bj-chosen-add").multiselect('refresh');
//				$("#bj-chosen-add").trigger("chosen:updated");

//				getXsjbByBjid();
				return false;
			});
}

function findBjByCampusid(){
	var url = ctx + "/klxx/wlzy/ajax_change_bj";
	var submitData = {
		campusid : $("#school-chosen").val()
	};
	$.post(url, submitData,
			function(data) {
				var datas = eval(data);
				$("#bj-chosen option").remove();// user涓鸿缁戝畾鐨剆elect锛屽厛娓呴櫎鏁版嵁
				var bjids = new Array();
				for ( var i = 0; i < datas.length; i++) {
					bjids.push(datas[i].id);
					$("#bj-chosen").append(
							"<option value=" + datas[i].id
									+ ">" + datas[i].bj
									+ "</option>");
				}
				$("#bj-chosen").prepend("<option value=" + bjids.toString()+ ">鍏ㄩ儴</option>");
				$("#bj-chosen option").eq(0).attr("selected", true);
				$("#bj-chosen").trigger("chosen:updated");
				query_wlzy(1);
				return false;
			});
}

function delConfirm(num) {
	if (confirm("纭鍒犻櫎?")) {
		var url = ctx + "/klxx/wlzy/ajax_del_wlzy";
		var submitData = {
			id : num,
			wlzytype:5
		};
		$.post(url, submitData, function(data) {
			alert("鍒犻櫎鎴愬姛!");
			if($(".viewBox").length==1&&currentPage!=1){
				query_wlzy(currentPage-1);
			}else{
				query_wlzy(currentPage);
			}
			return false;
			imagesTotal();
		});
	}
}

function toEdit(num) {
	var url = ctx + "/klxx/wlzy/toEditForm/" + wlzyType + "?id=" + num;
	location.href = url;
}

function query_wlzy(pageNum) {
	var rq = "";
	if($("#rq-chosen").val()!=null){
		rq = $("#rq-chosen").val();
	}
	var bjid = "";
	if($("#bj-chosen").val()!=null){
		bjid = $("#bj-chosen").val();
	}
	location.href = ctx + "/klxx/wlzy/" + wlzyType +"?"
	+ "search_campusid="+$("#school-chosen").val().trim()
	+ "&search_bjid="+bjid.trim()
	+ "&search_rq="+rq.trim()
	+ "&search_content="+$("#title").val()
	+ "&search_pagenum="+pageNum+"&appid=30";
}

function queryLastWlzyByPageNum(page){
	if(page > 1){
		query_wlzy(page-1);
	}
}

function queryNextWlzyByPageNum(page,total){
	if(page < total){
		query_wlzy(page+1);
	}
}

function removePhoto(obj){
	$(obj).parent().parent().remove();
	imagesTotal();
}


/**
 * 璁＄畻鍥剧墖鏁伴噺
 */
function imagesTotal(){
	if($(".gallery-image").length==9 || $(".gallery-video").length==1){
		$("#filePicker").addClass("hide");
	}else{
		$("#filePicker").removeClass("hide");
	}
	if($(".gallery-image").length > 0){
		$("#tips").html('杩樺彲浠ヤ笂浼�'+(9-$(".gallery-image").length)+'寮犵収鐗囧摕~');
	}else{
		$("#tips").html('鍙互涓婁紶1涓棰戞垨9寮犵収鐗囧摕~');
	}
}

/**
 * 鏌ョ湅鐝骇鍦堣鎯�
 * @param id
 */
function viewBjqDetails(id){
	if (confirm("纭鍒犻櫎?")) {
		var url = ctx + "/klxx/wlzy/ajax_del_wlzy";
		var submitData = {
			id : num,
			wlzytype:5
		};
		$.post(url, submitData, function(data) {
			alert("鍒犻櫎鎴愬姛!");
			query_wlzy(currentPage);
			return false;
		});
	}
}

function saveInfo(){
//	var sendObject = $("select[name=xcForm_stus]").val();
	
	var havePhoto = 0;
    var jsonArr = "{'json':[";
	var photoNum = 0;
	var commaNum = 0;
	var photoList = $(".uploader-list").find(".thumbnail");
	var photos = "";
	var fileids = "";
	var text = $("#profile-tweet").val();
	if(text.length>55){
		alert("鍐呭瀛楁暟澶锛岃灏戜簬55涓瓧绗︼紒");
		return;
	}
	if(photoList.length==0){
		PromptBox.alert("璇疯嚦灏戜笂浼犱竴寮犵収鐗囷紒");
		return;
	}
	if($('#bj-chosen-add').val()===null||$('#bj-chosen-add').val()===''){
		PromptBox.alert('鐝骇蹇呭～锛�');
		return;
	}
	for (var j = 0; j < photoList.length; j++) {
		if(photoList.eq(j).find("img").attr("src") != "" && photoList.eq(j).find("img").attr("src") != ctx +"/static/js/images/loading1.gif"){
			havePhoto = 1;
		}
		if(photoList.eq(j).find("img").attr("src") != ctx +"/static/js/images/loading1.gif"){
			photos += photoList.eq(j).find("img").attr("src") + ",";
			fileids += photoList.eq(j).find("img").attr("id") + ",";
		}
	}
	photoNum += photoList.length;
	commaNum += photos.match(/(,)/g).length;
	if(photos.length > 0){
		photos = photos.substring(0,photos.length - 1);
	}
	if(fileids.length > 0){
		fileids = fileids.substring(0,photos.length - 1);
	}
	var selectXsids = -1;
//	if(wlzyType==5){
//		if(sendObject!=null&&document.getElementById("xcForm_stus").options.length!=sendObject.length){
//			selectXsids = sendObject.toString();
//		}
//	}
	var jsonObj = "{\"photos\":\""+photos+"\",\"content\":\""+text+"\",\"xsids\":\""+selectXsids+"\",\"wlzytype\":"+$("#wlzyType").val()+",\"fileids\":\""+fileids+"\"}";
	if($(".gallery-video").length > 0){
		jsonObj = "{\"picpath\":\""+photos+"\",\"content\":\""+text+"\",\"xsids\":\""+selectXsids+"\",\"wlzytype\":"+$("#wlzyType").val()+",\"fileids\":\""+fileids+"\",\"photos\":\""+$("input[name=videoPath]").val()+"\"}";
	}
	jsonArr += jsonObj + "]}";
	var prompt = "纭畾淇濆瓨?";
	if (confirm(prompt)) {
		GHBB.prompt("鏁版嵁淇濆瓨涓瓇");
		var url=ctx+"/klxx/wlzy/addBatchWlzy?appid="+$("#appid").val();
		var submitData = {
				json:jsonArr,
				campusid:$("#school-chosen-add").val(),
				bjid:$("#bj-chosen-add").val().toString()
		};
		$.post(url,submitData,function(data){
			if(data == "success"){
				var url = ctx + "/klxx/wlzy/" + $("#wlzyType").val() + "?appid="+appid;
				GHBB.hide();
				location.href = url;
			}
	    });
	}	
}

function toView(num) {
	var url = ctx + "/klxx/wlzy/toViewForm/" + wlzyType + "?id=" + num+"&appid=30";
	location.href = url;
}

function playVideo(obj){
	$(obj).addClass("hide");
	$(obj).parent().find("video").get(0).play();
	$(obj).parent().find("video").get(0).addEventListener("ended",function(){
		$(obj).removeClass("hide");
    },false);
}

function initWebUploader(){
	// 鍒濆鍖朩eb Uploader
	var uploader = WebUploader.create({
	    // 閫夊畬鏂囦欢鍚庯紝鏄惁鑷姩涓婁紶銆�
	    auto: true,
	    // swf鏂囦欢璺緞
	    swf: ctx + '/static/js/webuploader/Uploader.swf',
	    // 鏂囦欢鎺ユ敹鏈嶅姟绔€�
	    server: ctx+"/klxx/wlzy/swfupload",
	    // 閫夋嫨鏂囦欢鐨勬寜閽€傚彲閫夈€�
	    // 鍐呴儴鏍规嵁褰撳墠杩愯鏄垱寤猴紝鍙兘鏄痠nput鍏冪礌锛屼篃鍙兘鏄痜lash.
	    pick: '#filePicker',
	    // 鍙厑璁搁€夋嫨鍥剧墖鏂囦欢銆�
	    accept: {
	        title: 'Images,Mp4',
	        extensions: 'gif,jpg,jpeg,bmp,png,mp4',
	        mimeTypes: 'image/*,video/mp4'
	    }
	});
	
	// 褰撴湁鏂囦欢娣诲姞杩涙潵鐨勬椂鍊�
	uploader.on( 'fileQueued', function( file ) {
		if($(".gallery-image").length >= 9){
			alert("鏈€澶氬彧鑳戒笂浼�9寮犲浘鐗�");
			return;
		}else if($(".gallery-video").length >= 1){
			alert("鏈€澶氬彧鑳戒笂浼�1涓棰�");
			return;
		}else if(file.type == "video/mp4" && $(".gallery-image").length > 0){
			alert("涓嶈兘鍚屾椂涓婁紶瑙嗛鍜屽浘鐗�");
			return;
		}
		var boxCss = 'gallery-image';
		var boxCssOption = 'gallery-image-options';
		var videoPath ="";
		if(file.ext == 'mp4'){
			boxCss = 'gallery-video';
			boxCssOption = 'gallery-video-options';
		}
	    var $li = $(
	            '<div id="' + file.id + '" class="thumbnail '+boxCss+'">' +
	                '<div class="img">' +
	                	'<input name="videoPath" type="hidden">' +
	                	'<img id="0" alt="image">' +
	                '</div>' +
	                '<div class="'+boxCssOption+'">' +  
	                '	<a onclick="removePhoto(this)" class="btn btn-sm btn-alt btn-primary" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></a>' +  
	                '</div>' +
	            '</div>'
	            ),
	        $img = $li.find('img');
        	$video = $li.find('video');
	    // $list涓哄鍣╦Query瀹炰緥
	    $("#fileList").prepend( $li );
	    // 鍒涘缓缂╃暐鍥�
	    // 濡傛灉涓洪潪鍥剧墖鏂囦欢锛屽彲浠ヤ笉鐢ㄨ皟鐢ㄦ鏂规硶銆�
	    // thumbnailWidth x thumbnailHeight 涓� 100 x 100
	    $img.attr( 'src', ctx +'/static/js/images/loading1.gif' );
	    imagesTotal();
	});
	
	// 鏂囦欢涓婁紶鎴愬姛锛岀粰item娣诲姞鎴愬姛class, 鐢ㄦ牱寮忔爣璁颁笂浼犳垚鍔熴€�
	uploader.on( 'uploadSuccess', function( file,response ) {
		uploader.removeFile(file);
	    $( '#'+file.id ).find("img").attr("src",response.picUrl);
	    $( '#'+file.id ).find("input[name=videoPath]").val(response.url);
	    setTimeout(function(){renderPhoto(file.id);}, 200);
	});
	
	// 鏂囦欢涓婁紶澶辫触锛屾樉绀轰笂浼犲嚭閿欍€�
	uploader.on( 'uploadError', function( file ) {
	    var $li = $( '#'+file.id ),
	        $error = $li.find('div.error');

	    // 閬垮厤閲嶅鍒涘缓
	    if ( !$error.length ) {
	        $error = $('<div class="error"></div>').appendTo( $li );
	    }

	    $error.text('涓婁紶澶辫触');
	});
	
	// 瀹屾垚涓婁紶瀹屼簡锛屾垚鍔熸垨鑰呭け璐ワ紝鍏堝垹闄よ繘搴︽潯銆�
	uploader.on( 'uploadComplete', function( file ) {
	    $( '#'+file.id ).find('.progress').remove();
	});
}

function renderPhoto(fileid){
	var img = $("#"+fileid).find("img");
	if(img.height() < img.width()){
		img.css("height","100%");
		img.css("left","50%");
		img.css("margin-left",-img.width()/2);
	}else if(img.height() == img.width()){
		img.css("width","100%");
		img.css("height","100%");
		img.css("top","0");
		img.css("left","0");
	}else{
		img.css("width","100%");
		img.css("top","50%");
		img.css("margin-top",-img.height()/2);
	}
}