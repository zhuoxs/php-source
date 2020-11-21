/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
 The FileProgress class is not part of SWFUpload.
 */

/* **********************
 Event Handlers
 These are my custom event handlers to make my
 web application behave the way I went when SWFUpload
 completes different tasks.  These aren't part of the SWFUpload
 package.  They are part of my application.  Without these none
 of the actions SWFUpload makes will show up in my application.
 ********************** */
var totalNum = 0, totalSize = 0, first = 0,workid=0;

function byteFormat(byte) {
	return byte / 1024 < 1024 ? (byte / 1024).toFixed(1) + " KB" : (byte / 1024 / 1024).toFixed(2) + " MB"
}

function fileQueued(file) {
	try {
		totalNum += 1;
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		//progress.setStatus();
		progress.toggleCancel(true, this);
		progress.setFileSize(byteFormat(file.size));
		totalSize += file.size;
		$("#totalsize").text(byteFormat(totalSize));
		$("#totalnum").text(totalNum);
		$('#upload-btn').css({
			'opacity' : 0,
			'height' : 0
		});
		$('#upload-btn object').css({
			'height' : 0
		});
		$('#que-foot').show();
	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("你选择了太多的文件,\n" + (message === 0 ? "达到了上传的上限" : "你最多可以选择 " + message + " 个文件。"));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				progress.setStatus("上传的文件太大了");
				this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				progress.setStatus("不能上传大小为0的文件");
				this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
				progress.setStatus("无效的文件类型");
				this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			default:
				if (file !== null) {
					progress.setStatus("未知错误，但我们知道的！");
				}
				this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			$('#upload-tips').hide();
			$('#upload-start').show();
		}

		/* I want auto start the upload and I can do that here */
		//this.startUpload();
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		 return true to indicate that the upload should start.
		 It's important to update the UI here because in Linux no uploadProgress events are called. The best
		 we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("上传中……");
		$('#upload').text("上传中……").attr('disabled', 'disabled');
		progress.toggleCancel(true, this);
	} catch (ex) {
	}

	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("上传中...");
	} catch (ex) {
		this.debug(ex);
	}
}

//上传一个文件后获取服务器返回数据
function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("上传完成.");
		progress.toggleCancel(false);

		//回调服务器信息
		var ret = $.parseJSON(serverData);
		/*if (ret != '') {
			console.log(ret);
			if (first == 0) {
				first = ret.data;
				workid=ret.code;
			}
		}*/
		//显示缩略图
		showThumb(ret.savepath.substring(1, ret.savepath.length - 1 ) + '/' + ret.savename);
	} catch (ex) {
		this.debug(ex);
	}
}

//生成缩略图
var i = 0;
function showThumb(src) {
	i = i + 1;
	if( i == 1 ){
		var arr = src.split('.');
		var suffix = arr[1].toUpperCase();
		if( suffix != 'jpg' && suffix != 'gif' && suffix != 'png' && suffix != 'jpeg' && suffix != 'JPG' && suffix != 'GIF' && suffix != 'PNG' && suffix != 'JPEG'){
			var newImg = '<img src="/Public/Img/file_icon/'+ suffix +'.png" class="sel" />';
		} else {
			var newImg = '<img src="'+ src +'" class="sel" />';
		}
		$('#returnValue').val(src);
	}else{
		var newImg = '<img src="'+ src +'" />';
	}
    $("#thumbnails").append(newImg);
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
			case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
				progress.setStatus("Upload Error: " + message);
				this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
				progress.setStatus("Upload Failed.");
				this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.IO_ERROR:
				progress.setStatus("Server (IO) Error");
				this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
				progress.setStatus("Security Error");
				this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				progress.setStatus("Upload limit exceeded.");
				this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
				progress.setStatus("Failed Validation.  Upload skipped.");
				this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
				// 执行取消已经上传文件操作 jxcent@2013-03-29 16:06:37
				progress.setStatus("正在删除...");
				totalSize -= file.size;
				$("#totalsize").text(byteFormat(totalSize));
				$("#totalnum").text(totalNum -= 1);
				progress.setCancelled();
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				progress.setStatus("Stopped");
				break;
			default:
				progress.setStatus("Unhandled Error: " + errorCode);
				this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {

	if (this.getStats().files_queued === 0) {
		
		//window.location=P+'/settings/work/complete?fid='+first+'&id='+workid;
		
		//上传完成之后置换
		$('#upload').attr('disabled', false);
		$('#upload').text('上传文件');
		// document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// 上传完成后调用
function queueComplete(numFilesUploaded) {
	// var status = document.getElementById("divStatus");
	// status.innerHTML = numFilesUploaded + " file" + (numFilesUploaded === 1 ? "" : "s") + " uploaded.";
}
