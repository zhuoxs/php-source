var tiger=0;
function tiger_nva(type){
    
	if(tiger!=type){
		if(type==1){
			document.getElementById('cd1').style.display='block';
			document.getElementById('cd2').style.display='none';
			document.getElementById('cd3').style.display='none';
			$("#a1").addClass("arrow-icon1");
			$("#a2").removeClass("arrow-icon1");
			$("#a3").removeClass("arrow-icon1");
			$("#s1").addClass("red");
			$("#s2").removeClass("red");
			$("#s3").removeClass("red");
			$("#tiger_bj").css("display","block");
			tiger=1;
		}else if(type==2){
			document.getElementById('cd1').style.display='none';
			document.getElementById('cd2').style.display='block';
			document.getElementById('cd3').style.display='none';	
			$("#a2").addClass("arrow-icon1");
			$("#a1").removeClass("arrow-icon1");
			$("#a3").removeClass("arrow-icon1");
			$("#s1").removeClass("red");
			$("#s2").addClass("red");
			$("#s3").removeClass("red");
			$("#tiger_bj").css("display","block");
			tiger=2;
		}else if(type==3){
			document.getElementById('cd1').style.display='none';
			document.getElementById('cd2').style.display='none';
			document.getElementById('cd3').style.display='block';	
			$("#a3").addClass("arrow-icon1");
			$("#a1").removeClass("arrow-icon1");
			$("#a2").removeClass("arrow-icon1");
			$("#s1").removeClass("red");
			$("#s2").removeClass("red");
			$("#s3").addClass("red");
			$("#tiger_bj").css("display","block");
			tiger=3;
		} 	  
	}else{
	  document.getElementById('cd'+tiger).style.display='none';   
	 $("#a"+tiger).removeClass("arrow-icon1");
	 $("#s"+tiger).removeClass("red");
	 $("#tiger_bj").css("display","none");
	  tiger=0;
	}
	
}


function colok(){
	 document.getElementById('cd1').style.display='none';   
	 document.getElementById('cd2').style.display='none';  
	 document.getElementById('cd3').style.display='none';  
	 $("#a1,#a2,#a3").removeClass("arrow-icon1");
	 $("#s1,#s2,#s3").removeClass("red");
	 $("#tiger_bj").css("display","none");
}



	//搜索导航浮动//这个JS放在jquery下面

	
	var tiger_nav_search_show=function(){
		$(window).on('scroll',function(){
			if($(window).scrollTop()>$("#head_seach").offset().top){
				$("#pf_seach").show();
			}

			else{
				$("#pf_seach").hide();
			}
		})
	}

    if($("#head_seach").size()>0){
        tiger_nav_search_show();
	}


