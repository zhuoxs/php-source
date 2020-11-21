$(document).ready(function(){

			$("#timerange").picker({
				toolbarTemplate:'<div class="toolbar"><div class="toolbar-inner"><a href="javascript:;" class="picker-cancel close-picker-cancel">取消</a><a href="javascript:;" class="picker-button close-picker-ok">确定</a></div></div>',
				cssClass:'timerange',
				cols: [
				    {
				      textAlign: 'center',
				      values: ['08', '09', '10', '11', '12', '13', '14', '15','16','17','18','19','20']
				    },
				    {
				      textAlign: 'center',
				      values: [':']
				    },
				    {
				      textAlign: 'center',
				      values: ['00', '10','20','30','40','50']
				    },
				    {
				    	textAlign:'center',
				    	values:['至']
				    },
				    {
				      textAlign: 'center',
				      values: ['08', '09', '10', '11', '12', '13', '14', '15','16','17','18','19','20']
				    },
				    {
				      textAlign: 'center',
				      values: [':']
				    },
				    {
				      textAlign: 'center',
				      values: ['00', '10','20','30','40','50']
				    }
	  			],
			});
			$('body').on('click','.timerange .close-picker-ok',function(){
				var timerange=$('#timerange').val().split(' ');
				if(parseInt(timerange[0])>parseInt(timerange[4])){
					$.toast('时间选择错误', "forbidden");
					return false;
				}
				if(parseInt(timerange[0])==parseInt(timerange[4])){
					if(parseInt(timerange[2])<=parseInt(timerange[6])){
						$.toast('时间选择错误',"forbidden");
						return false;
					}
				}
				$('#accept_stime').val(timerange[0]+timerange[1]+timerange[2]);
				$('#accept_etime').val(timerange[4]+timerange[5]+timerange[6]);
				$('#timerange').picker('close');
			});
			$('body').on('click','.timerange .close-picker-cancel',function(){
				var s=$('#accept_stime').val().split(':');
				var e=$('#accept_etime').val().split(':');
				$('#timerange').val(s[0]+' : '+s[1]+' 至 '+e[0]+' : '+e[1]);
				$("#timerange").picker("setValue", $('#timerange').val().split(' '));
				$('#timerange').picker('close');
			});
			$('#picker-name1,#picker-name2').click(function(){
				window.setTimeout(function(){
					$('#timerange').picker('open');
				},500);
			});
			$('.address input[type="checkbox"]').click(function(){
				if(parseInt(this.value)==1){
					$('.address input[type="checkbox"]').prop('checked',this.checked);
				}
				else{
					if(this.checked){
						if(isall()){
							$('#s12').prop('checked',true);
						}
					}
					else{
						$('#s12').prop('checked',false);
					}
				}
			});
			$('#1submit').click(function(){
				var area=[];
				$('.address input[type="checkbox"]').each(function(){
					if(this.checked){
						area.push(this.value);
					}
				});
				var accept=$('#accept').prop('checked')?1:0;
				var accept_time=$('#accept_time').prop('checked')?1:0;
				var timerange=$('#timerange').val().split(' ');
				if(area.length==0){
					//$.toast('请选择地区','forbidden');
					//return false;
				}
				base.request('api.weixin.message',{accept:accept,accept_time:accept_time,accept_stime:(timerange[0]+':'+timerange[2]),accept_etime:(timerange[4]+':'+timerange[6]),area:area.join(',')},function(data){
					if(data.error){
						$.toast(data.error,'forbidden');
						return false;
					}
					$.toast('设置成功');
				});
			});

		function isall(){
			var all=true;
			$('.address input[type="checkbox"]').each(function(){
				//console.log(isall);
				if(parseInt(this.value)!=1&&!this.checked){
					all=false;
					return false;
				}
			});
			return all;
		}
		

});