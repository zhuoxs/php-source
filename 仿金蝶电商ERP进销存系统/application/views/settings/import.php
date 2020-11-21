<?php $this->load->view('header');?>

<script type="text/javascript">
var DOMAIN = document.domain;
var WDURL = "";
var SCHEME= "<?php echo sys_skin()?>";
try{
	document.domain = '<?php echo base_url()?>';
}catch(e){
}
//ctrl+F5 增加版本号来清空iframe的缓存的
$(document).keydown(function(event) {
	/* Act on the event */
	if(event.keyCode === 116 && event.ctrlKey){
		var defaultPage = Public.getDefaultPage();
		var href = defaultPage.location.href.split('?')[0] + '?';
		var params = Public.urlParam();
		params['version'] = Date.parse((new Date()));
		for(i in params){
			if(i && typeof i != 'function'){
				href += i + '=' + params[i] + '&';
			}
		}
		defaultPage.location.href = href;
		event.preventDefault();
	}
});
</script>

<script src="<?php echo base_url()?>statics/js/common/libs/swfupload/swfupload.js?v=2015616"></script>
<style>
.wrapper {padding: 15px 0 0 18px;min-width: 0;}
</style>
</head>

<body>
<div class="wrapper">
	<div class="mod-inner"  style="width:480px; ">
      <h3>批量导入客户、供应商、商品信息及初始余额</h3>
      <ul class="mod-steps" id="import-steps">
          <li><span class="current">1.下载模版</span>&gt;</li>
          <li><span>2.导入Excel</span>&gt;</li>
          <li><span>3.导入完毕</span></li>
      </ul>
      <div id="import-wrap" class="cf">
          <div id="import-step1" class="step-item">
              <div class="ctn">
                  <h3 class="tit">温馨提示：</h3>
                  <p>导入模板的格式不能修改，录入方法请参考演示模板。</p>
              </div>
              <p><a href="../index.php/basedata/import/downloadtemplate1" class="link">下载导入客户模版</a></p>
              <p><a href="../index.php/basedata/import/downloadtemplate2" class="link">下载导入供应商模版</a></p>
              <p><a href="../index.php/basedata/import/downloadtemplate3" class="link">下载导入商品模版</a></p>
              <div class="step-btns">
                  <a href="#" class="ui-btn ui-btn-sp" rel="step2">下一步</a>
              </div>
          </div>

          <div id="import-step2" class="step-item" style="display:none;">
              <div class="ctn file-import-ctn"> 
                  <form action="uploadExcel" enctype="multipart/form-data" id="fileUploadForm">
                    <input type="file" accept=".xls" name="docFile" id="docFile" style="display: none;" onchange="document.getElementById('filePath').value=this.value"/>
                  </form>
                  <span class="tit">请选择要导入文件：</span>
                  <input type="text" name="filePath" id="filePath" class="ui-input" readonly autocomplete="false" style="width:200px;" />
                  <!-- <span id="import-btn-wrap"><span id="import-btn"></span></span> -->
                  <input type="button" value="" style="background:url('<?php echo base_url()?>statics/js/common/libs/swfupload/import-btn.png') no-repeat;border: none;vertical-align:middle;display:inline-block;*display:inline;zoom:1;width:60px;height:32px;" onclick="document.getElementById('docFile').click()"/><br>
              </div>
              <div class="step-btns">
                  <a href="#" class="ui-btn mrb" rel="step1">上一步</a><a href="#" class="ui-btn ui-btn-sp"
 id="btn-import">导入</a>
              </div>					
          </div>

          <div id="import-step3" class="step-item" style="display:none;">
              <div class="ctn file-import-ctn" id="import-result"></div>

              <div class="step-btns">
                  <a href="#" class="ui-btn mrb" id="a_step3">上一步</a><a href="#" class="ui-btn ui-btn-sp" id
="btn-complete">完成</a>
              </div>
          </div>
      </div>
	</div>
</div>



<script type="text/javascript">
function getTabWindow() { var curTabWin = null; var curTab = parent.$('#page-tab').tabs('getSelected'); if (curTab && curTab.find('iframe').length > 0) { curTabWin = curTab.find('iframe')[0].contentWindow; } return curTabWin; }
(function($){	
	$('#import-wrap .step-btns a[rel]').bind('click',function(e){
		var step = $(this).attr('rel').substr(4,1)-1;
		if(step < 2){
			$('#import-wrap .step-item').eq(step).show().siblings().hide();
			$('#import-steps >li >span').removeClass('current');
			$('#import-steps >li >span').eq(step).addClass('current');
		} else {
			
		}
		e.preventDefault();
	});
	$('#a_step3').bind('click',function(e){			
		$('#import-wrap .step-item').eq(1).show().siblings().hide();
		$('#import-steps >li >span').eq(2).removeClass('current');
		$('#import-steps >li >span').eq(1).addClass('current');
		e.preventDefault();
	});
   $('#btn-complete').on('click',function(e){
   		
   		var callback = frameElement.api.data.callback;
   		if($.isFunction(callback)){
   			callback();
   		}
   		frameElement.api.close();
 		//var tab = parent.$('#page-tab').ligerGetTabManager();
 		//tab.getTabItem();
	    //parent.$("#search",pwin.document).html('222');
   		//$("#search",window.parent.document).click();
   });
	$('#btn-import').on('click',function(e){
		$('#import-result').empty();
		var obj = document.getElementById("docFile");
		if(obj.value=="")
		{
			parent.Public.tips({content : '请选择要上传的文件！', type : 2});
		    return; 
		}
		var formData = new FormData();
		var name = $("filePath").val();
		formData.append("file",$("#docFile")[0].files[0]);
		formData.append("name",name);
		$.ajax({ 
			url : '../index.php/basedata/import/uploadExcel', 
			type : 'POST', 
			data : formData, 
			// 告诉jQuery不要去处理发送的数据
			processData : false, 
			// 告诉jQuery不要去设置Content-Type请求头
			contentType : false,
			dataType:'json',
			beforeSend:function(){
				console.log("正在进行，请稍候");
			},
			success : function(data) { 
				$('#import-wrap .step-item').eq(2).show().siblings().hide();
				$('#import-steps >li >span').eq(1).removeClass('current');
				$('#import-steps >li >span').eq(2).addClass('current');
				var html='<font color="red">'+data.msg+'</font>';
				$('#import-result').append(html);
				if(data.status===200){
					
				}else{
					
				}
			}, 
			error : function(data) { 
				$('#import-result').append('上传文件过程中失败，请重试！');
			} 
		});
	});
	  
})(jQuery);

</script>
</body>
</html>
