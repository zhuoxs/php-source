 //*************************************js数据的验证
var valid_easy=function(iclass){ 
	//参数：dom对象id  <input type="text" class="form-input" valid="length|4|20" valid-msg="密码必须4到20位">
	//说明：通过domid取得dom内的所有.form-input的标签。通过遍历获取vilid,valid-msg等属性
	//遍历所input进行验证,默认验证非空：valid="没有的验证" > 验证非空，valid="" > 不验证
	
	var inputs = $("."+iclass);
	var temp =false;
	if(inputs.length<=0){//没有找到class
		return true;
	}
	
	$.each(inputs,function(i,v){
		temp=false;//避免上一个循环为true
		var valid0 =["default"];//要执行的验证
		var valid=""; 
		if(typeof($(v).attr("valid"))=="undefined"){//没有定义valid
			temp=true;
			return true;
		}
		valid0 =($(v).attr("valid")+"").split("|");//分割出验证方法与参数

		valid=valid0[0];
		var inp=$(v).val().trim(); 
		
		var tag=['ssifewji','INPUT','SELECT','TEXTAREA'];	
		if(tag.indexOf($(v).get(0).tagName)<1){ //验证标签类型是否是input
			return true;//jquery的continue
		}
		if(!valid){
			return true;
		}
		switch(valid){ 
			case "length": //验证长度：如 valid="length|2|10" 验证长度2到10
				if(inp.length>=valid0[1]&&inp.length<=valid0[2]){
					temp=true;
				}
				break;
			case "interval"://数值大小区间 
				if(inp*1>=valid0[1]&&inp*1<=valid0[2]){
					temp=true;
				}
				break;
			case "email":
				temp=isEmail(inp);
				break;
			case "idcard":
				temp=isCardNo(inp);
				break;
			case "mobile":
				break;
			case "birth":
				break;
				
			case "mobtel"://电话
				temp=MobOrTel(inp);
				break;
			case "date"://日期
				temp=CheckDate(inp);
				break;
			case "datetime"://时间
				temp=CheckIsValidDate(inp);
				break;
			case "int"://数字
				temp=isInt(inp);
				break;
			case "username"://标准登陆账号
				temp=UserName(inp);
				break;
			case "cnname"://中文名字
				temp=CNName(inp);
				break;
			case "chinese"://中文
				temp=Chinese(inp);
				break;
			default:
				if( inp==null||inp==""){
					temp=false;
				}else{
					temp=true;
				}
				break;
		} 
		//console.log($(v).attr("name"));
		if(temp==false){ 
			var msg=$(v).attr("valid-msg"); 
			//console.log(msg);
			if(typeof(msg)!="undefined"&&msg.length>0){
				try{
					modalMsg(msg);
				}catch(e){
					alert(msg);
				} 
			}else{
				try{
					modalMsg("请检查参数");
				}catch(e){
					alert("请检查参数");
				}
			}
			return false;//jquery的break
		}

	});
	return temp;
} 
function UserName(str){
	var nameCheck=/^[A-Za-z0-9]*$/;
	if(nameCheck.test(str)&&(str.length>3&&str.length<21)){
		return true;
	}
	return false;
}
//验证IP地址是否有效
function isIp(str){
	//获取验证ip
	var strIp=str;
	//正则表达式
	var ipCheck = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/;  
	if (ipCheck.test(strIp)){
		//判断IP是否在有效范围内
		strIp.match(ipCheck);
		if(RegExp.$1<=255&&RegExp.$1>=0
			&&RegExp.$2<=255&&RegExp.$2>=0
			&&RegExp.$3<=255&&RegExp.$3>=0
			&&RegExp.$4<=255&&RegExp.$4>=0){  
			return true; 
		}else{
			return false;
		}  
	}else{
		 return false; 
	}
}

//检验是否正确日期格式 精确到时分秒的验证
function CheckIsValidDate(str){
	var strD=str;
	var DateCheck= /^(\d+)\-(\d+)\-(\d+)\ (\d+)\:(\d+)\:(\d+)$/;
	//正则表达式 匹配出生日期(简单匹配)     
	if (DateCheck.test(strD)){
		strD.match(DateCheck);
		//设置时间范围年1976-3000 时0-23 分0-59 秒0-59
		if(RegExp.$1<=3000&&RegExp.$1>=1970
			&&RegExp.$4<=23&&RegExp.$4>=0
			&&RegExp.$5<=59&&RegExp.$5>=0
			&&RegExp.$6<=59&&RegExp.$6>=0){
				var iyear=(RegExp.$1)%4;
				//如果月份为小则 日1-30 如果月份为大1-31 如果为润2月 1-29 平2月 1-28
				if((RegExp.$2==4||RegExp.$2==5||RegExp.$2==9||RegExp.$2==11)&&(RegExp.$3>=1&&RegExp.$3<=30)){
					return true;
				}else if((RegExp.$2==1||RegExp.$2==3||RegExp.$2==5||RegExp.$2==7||RegExp.$2==8||RegExp.$2==10||RegExp.$2==12)&&(RegExp.$3>=1&&RegExp.$3<=31)){
					return true;
				}else if(RegExp.$2==2&&iyear==0&&RegExp.$3>=1&&RegExp.$3<=29){
					return true;
				}else if(RegExp.$2==2&&iyear!=0&&RegExp.$3>=1&&RegExp.$3<=28){
					return true;
				}
				else{
					return false;
				}
			}else{
				return false;
			}
	}else{
		return false;
	}
}
function CheckDate(str){
	var strD=str;
	var DateCheck= /^(\d+)\-(\d+)\-(\d+)$/;
	//正则表达式 匹配出生日期(简单匹配)     
	if (DateCheck.test(strD)){
		strD.match(DateCheck);
		//设置时间范围年1976-3000 时0-23 分0-59 秒0-59
		if(RegExp.$1<=3000&&RegExp.$1>=1970){
				var iyear=(RegExp.$1)%4;
				//如果月份为小则 日1-30 如果月份为大1-31 如果为润2月 1-29 平2月 1-28
				if((RegExp.$2==4||RegExp.$2==5||RegExp.$2==9||RegExp.$2==11)&&(RegExp.$3>=1&&RegExp.$3<=30)){
					return true;
				}else if((RegExp.$2==1||RegExp.$2==3||RegExp.$2==5||RegExp.$2==7||RegExp.$2==8||RegExp.$2==10||RegExp.$2==12)&&(RegExp.$3>=1&&RegExp.$3<=31)){
					return true;
				}else if(RegExp.$2==2&&iyear==0&&RegExp.$3>=1&&RegExp.$3<=29){
					return true;
				}else if(RegExp.$2==2&&iyear!=0&&RegExp.$3>=1&&RegExp.$3<=28){
					return true;
				}
				else{
					return false;
				}
			}else{
				return false;
			}
	}else{
		return false;
	}
}
//验证MAC地址
function isMac(str){
	//获取验证Mac
	var strMac=str;
	//正则表达式
	var MacCheck = /^[a-fA-F\d]{2}\:[a-fA-F\d]{2}\:[a-fA-F\d]{2}\:[a-fA-F\d]{2}\:[a-fA-F\d]{2}\:[a-fA-F\d]{2}$/;  
	if (MacCheck.test(strMac)){
		return true;
	}else{
		return false;
	}
}

//验证是否为小数
function isFloat(str){
	//获取验证float
	var strfloat=str;
	//正则表达式
	var FloatCheck=/^(\d+)(\.?)\d{0,3}$/;
	if (FloatCheck.test(strfloat)){
		var FloatCheck1=/^(\d+)\.$/;
		if(FloatCheck1.test(strfloat))
		{
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

//验证是否为整数
function isInt(str){
	//获取验证int
	var strint=str;
	//正则表达式
	var IntCheck=/^(\d+)$/;
	if (IntCheck.test(strint)){
		return true;
	}else{
		return false;
	}
}

//判断键盘元素是否是数字键 
function isNumkey(e){
	var keynum;
	var keychar;
	var numcheck;
	if(window.event){ // IE
		keynum = e.keyCode;
	}
	else if(e.which){ // Netscape/Firefox/Opera
		keynum = e.which;
	}
	keychar = String.fromCharCode(keynum);
	if(keynum>95 && keynum<106)
		return true;
	numcheck = /\d/;
	return numcheck.test(keychar);
}
//验证是手机号或者座机
function MobOrTel(str){ 
    var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
    var isMob=/^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8}|1349[0-9]{7})$/;
    if(isMob.test(str)||isPhone.test(str)){
        return true;
    }
    else{
        return false;
    } 
}
//验证手机号
function isMobile(str){
	//获取验证手机号
	var strmobile=str;
	//正则表达式
	var MobileCheck=/^1\d{10}$/;
	if (MobileCheck.test(strmobile)){
		return true;
	}else{
		return false;
	}
}

//验证规则：区号+号码，区号以0开头，3位或4位
//号码由7位或8位数字组成
//区号与号码之间可以无连接符，也可以“-”连接
function isTelephone(str){
	//获取验证电话号码
	var strTelephone=str;
	//正则表达式
	var TelephoneCheck=/^0\d{2,3}\-?\d{7,8}$/;
	if (TelephoneCheck.test(strTelephone)){
		return true;
	}else{
		return false;
	}
}

function isEmail(str){
	//获取验证邮箱
	var strEmail=str;
	//正则表达式
	var EmailCheck=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
	if (EmailCheck.test(strEmail)){
		return true;
	}else{
		return false;
	}
}

//身份证精确验证
function isCardNo(idcard){
	//var Errors=new Array("验证通过!","身份证号码位数不对!","身份证号码出生日期超出范围或含有非法字符!","身份证号码校验错误!","身份证地区非法!"); 
	var area={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}
	var idcard,Y,JYM; 
	var S,M; 
	var idcard_array = new Array(); 
	idcard_array = idcard.split(""); 
	//地区检验  
	if(area[parseInt(idcard.substr(0,2))]==null) {
		return false;
	}
	//身份号码位数及格式检验  
	switch(idcard.length){
		case 15:
		if((parseInt(idcard.substr(6,2))+1900)%4==0||((parseInt(idcard.substr(6,2))+1900)%100==0&&(parseInt(idcard.substr(6,2))+1900)%4 ==0)){ 
		ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;//测试出生日期的合法性  
		} else { 
		ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;//测试出生日期的合法性  
		} 
		if(ereg.test(idcard)){
			return true;
		}else{
			return false;
		}
		break;
		case 18: 
			//18位身份号码检测  
			//出生日期的合法性检查  
			//闰年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))  
			//平年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))  
			if ( parseInt(idcard.substr(6,4)) % 4 == 0 || (parseInt(idcard.substr(6,4)) % 100 == 0 && parseInt(idcard.substr(6,4))%4 == 0 )){ 
			ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;//闰年出生日期的合法性正则表达式  
			} else { 
			ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;//平年出生日期的合法性正则表达式  
			} 
			if(ereg.test(idcard)){//测试出生日期的合法性  
				//计算校验位  
				S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 
				+ (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 
				+ (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 
				+ (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 
				+ (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 
				+ (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 
				+ (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 
				+ parseInt(idcard_array[7]) * 1 
				+ parseInt(idcard_array[8]) * 6 
				+ parseInt(idcard_array[9]) * 3 ; 
				Y = S % 11; 
				M = "F"; 
				JYM = "10X98765432"; 
				M = JYM.substr(Y,1);//判断校验位  
				if(M == idcard_array[17]) return true; //检测ID的校验位  
				else return false; 
			} 
			else return false; 
			break; 
		default: 
			return false; 
			break; 
	} 
}


//验证是否问中文姓名
function Chinese(str){
	var pattern=/^[\u4e00-\u9fa5]+$/;
	if(pattern.test(name)){
		return true;
	}
	return false;
}
function CNName(name){
	var pattern=/^[\u4e00-\u9fa5]+$/;
	name=name.replace(/^\s*|\s*$/g, "");//替换空格
	if(pattern.test(name)&&(name.length>1&&name.length<16)){
		return true;
	}
	return false;
}
 
function modalMsg(text){ 
var height;
// 获取窗口高度
if (window.innerHeight)
height = window.innerHeight;
else if ((document.body) && (document.body.clientHeight))
height = document.body.clientHeight; 
	var top=document.body.scrollTop+(window.screen.height/2.6) ;
	/*var top=height/2-90;
	if(top<180){
		top=180;
	}else if(top>700){
		top=400;
	}*/
	if(typeof($("#popupop-bg").attr("id"))=="undefined"){
		var html='<div id="popupop-bg" class="popupop-bg" style=" z-index: 10000000;position: absolute;top: 0px;left: 0px;width: 100%;height:'+height+'px;background-color: #000;opacity: 0.3;"></div>';		
		$(document.body).append(html);  
	}else{
		$("#popupop-bg").css("display","block"); 
	}
	if(typeof($("#popupop").attr("id"))=="undefined"){
		var html='<div id="popupop" style="z-index:12000000;width: 30%;min-height:200px;display: block;border:1px solid #ccc;border-radius: 3px;background-color:#FFF; position: absolute;top:'+top+'px;left: 50%;-webkit-transform: translate(-50%, -60%);-moz-transform: translate(-50%, -60%);-ms-transform: translate(-50%, -60%);-o-transform: translate(-50%, -60%);transform: translate(-50%, -50%);"><div style="border-bottom: 1px solid #FFFFFF;text-align: left; padding: 8px 16px;background-color:#F0F0F0;" >提示';
		html+='</div><div style="text-align: center; padding: 15px;" id="popupop-body">'+text+'</div><div style="width:100%;height:45px;line-height:45px;text-align:center;background-color:#F0F0F0;position:absolute;bottom:0px;"><button class="mybtn" style="margin:0 auto;cursor:pointer;width:60px;text-align:center;color:#FFF;background-color:#34A7FE;" onclick="modalMsgClose()" >关 闭</button><div></div>';
		$(document.body).append(html);  
	}else{

		$("#popupop-body").html(text);
		$("#popupop").css("display","block"); 
		$("#popupop").css("top",top+"px"); 

	} 
}
function modalMsgClose(){
	$("#popupop").css("display","none");
	$(".popupop-bg").css("display","none");
}
var tempfunc=function(){};
function modalDlgClose(){
	$("#sssmodal").css("display","none");
	$(".popupop-bg").css("display","none");
}  
function modalDlg(text,callBack,title=""){ 
var height;
// 获取窗口高度
if (window.innerHeight)
height = window.innerHeight;
else if ((document.body) && (document.body.clientHeight))
height = document.body.clientHeight; 
 
	var top=document.body.scrollTop+(window.screen.height/2.6) ;
	 
	if(typeof(title)!="string"||title.length<1){
		title="提示";
	}
	//var top=height/2-90;
	/*if(top<180){
		top=180;
	}else if(top>700){
		top=400;
	}*/
	var func=callBack; 
    if(typeof(callBack)!="function"){
    	func+="()";
    }else{
    	tempfunc=callBack;
    	func="tempfunc()";
    };
	if(typeof($("#sssmodal-bg").attr("id"))=="undefined"){
		var html='<div id="modal-bg" class="popupop-bg" style=" z-index: 1000000;position: absolute;top: 0px;left: 0px;width: 100%;height:'+height+'px;background-color: #000;opacity: 0.3;" ></div>';		
		$(document.body).append(html);  
	}else{
		$("#sssmodal-bg").css("display","block"); 
	}
	if(typeof($("#sssmodal").attr("id"))=="undefined"){
		var html='<div id="sssmodal" style="z-index:1200000; min-width:500px;display: block;border:1px solid #ccc;border-radius: 3px;background-color:#FFF; position: absolute;top: '+top+'px;left: 50%;-webkit-transform: translate(-50%, -60%);-moz-transform: translate(-50%, -60%);-ms-transform: translate(-50%, -60%);-o-transform: translate(-50%, -60%);transform: translate(-50%, -50%);"><div style="border-bottom: 1px solid #FFFFFF;text-align: left; padding: 8px 16px;background-color:#F0F0F0;" id="modaldlgtitle">'+title;
		html+='</div><div style="text-align: center;padding: 15px;padding-bottom:30px; " id="popupop-body2">'+text+'</div><div style="width:100%;height:50px;line-height:45px;text-align:center;background-color:#F0F0F0;position:absolute;text-align:center;"> ';
		html+='<button  onclick="'+func+'" style="margin:10px 40px 10px 143px;height:30px;padding:4px 8px;border-raduis:5px;line-height:1.4;display:line-block;cursor:pointer;border:1px solid transparent;width:60px;text-align:center;color:#FFF;background-color:#34A7FE;"  >确 认</button>';
		html+='<button class="mybtn" style="margin:10px 143px 10px 40px;height:30px;padding:4px 8px;border-raduis:5px;line-height:1.4;display:line-block;cursor:pointer;border:1px solid #999;width:60px;text-align:center;background-color:#FFF;color:black;" onclick="modalDlgClose()" >关 闭</button><div></div>';
		$(document.body).append(html);  
	}else{
		$("#modaldlgtitle").text(title);
		$("#popupop-body2").html(text);
		$("#sssmodal").css("top",top+"px");
		$("#sssmodal").css("display","block"); 
	} 
}
 

