function check_adminRemark(){
	if($("#admin_remark").val()==""){
		alert("备注不能为空");
		return false;
	}

}
function senddata(url){
		$.ajax({				
  			type:'post',
  			url:url,
            dataType: 'json',	
            success:function(data){
            if(data.result=='0'){
              new TipBox({type:'success',str:data.str,hasBtn:true});
            }else{               
              new TipBox({type:'error',str:data.str,hasBtn:true});  
            }
            
          }
        });
}