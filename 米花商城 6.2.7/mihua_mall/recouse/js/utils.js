/* $Id : utils.js 5052 2007-02-03 10:30:13Z weberliu $ */

var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.htmlEncode = function(text)
{
  return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

Utils.trim = function( text )
{
  if (typeof(text) == "string")
  {
    return text.replace(/^\s*|\s*$/g, "");
  }
  else
  {
    return text;
  }
}

Utils.isEmpty = function( val )
{
  switch (typeof(val))
  {
    case 'string':
      return Utils.trim(val).length == 0 ? true : false;
      break;
    case 'number':
      return val == 0;
      break;
    case 'object':
      return val == null;
      break;
    case 'array':
      return val.length == 0;
      break;
    default:
      return true;
  }
}

Utils.isNumber = function(val)
{
  var reg = /^[\d|\.|,]+$/;
  return reg.test(val);
}

Utils.isInt = function(val)
{
  if (val == "")
  {
    return false;
  }
  var reg = /\D+/;
  return !reg.test(val);
}

Utils.isEmail = function( email )
{
  var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;

  return reg1.test( email );
}

Utils.isTel = function ( tel )
{
  var reg = /^[\d|\-|\s|\_]+$/; //只允许使用数字-空格等

  return reg.test( tel );
}

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}

Utils.srcElement = function(e)
{
  if (typeof e == "undefined") e = window.event;
  var src = document.all ? e.srcElement : e.target;

  return src;
}

Utils.isTime = function(val)
{
  var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/;

  return reg.test(val);
}

Utils.x = function(e)
{ //当前鼠标X坐标
    return Browser.isIE?event.x + document.documentElement.scrollLeft - 2:e.pageX;
}

Utils.y = function(e)
{ //当前鼠标Y坐标
    return Browser.isIE?event.y + document.documentElement.scrollTop - 2:e.pageY;
}

Utils.request = function(url, item)
{
	var sValue=url.match(new RegExp("[\?\&]"+item+"=([^\&]*)(\&?)","i"));
	return sValue?sValue[1]:sValue;
}

Utils.$ = function(name)
{
    return document.getElementById(name);
}

function rowindex(tr)
{
  if (Browser.isIE)
  {
    return tr.rowIndex;
  }
  else
  {
    table = tr.parentNode.parentNode;
    for (i = 0; i < table.rows.length; i ++ )
    {
      if (table.rows[i] == tr)
      {
        return i;
      }
    }
  }
}

document.getCookie = function(sName)
{
  // cookies are separated by semicolons
  var aCookie = document.cookie.split("; ");
  for (var i=0; i < aCookie.length; i++)
  {
    // a name/value pair (a crumb) is separated by an equal sign
    var aCrumb = aCookie[i].split("=");
    if (sName == aCrumb[0])
      return decodeURIComponent(aCrumb[1]);
  }

  // a cookie with the requested name does not exist
  return null;
}

document.setCookie = function(sName, sValue, sExpires)
{
  var sCookie = sName + "=" + encodeURIComponent(sValue);
  if (sExpires != null)
  {
    sCookie += "; expires=" + sExpires;
  }

  document.cookie = sCookie;
}

document.removeCookie = function(sName,sValue)
{
  document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
}

function getPosition(o)
{
    var t = o.offsetTop;
    var l = o.offsetLeft;
    while(o = o.offsetParent)
    {
        t += o.offsetTop;
        l += o.offsetLeft;
    }
    var pos = {top:t,left:l};
    return pos;
}

function cleanWhitespace(element)
{
  var element = element;
  for (var i = 0; i < element.childNodes.length; i++) {
   var node = element.childNodes[i];
   if (node.nodeType == 3 && !/\S/.test(node.nodeValue))
     element.removeChild(node);
   }
}

  function retime(total_time){
                var days = parseInt(total_time/86400)           
                var remain = parseInt(total_time%86400);
                var hours = parseInt(remain/3600)
                var remain = parseInt(remain%3600);    
                var mins = parseInt(remain/60);
                var secs = parseInt(remain%60);
                var ret = "";
                if(days>0){
                    days = days+"";
                    if(days.length<=1) { days="0"+days;}
                    ret+="<span class='day'>"+days+" </span>天 ";
                }
                if(hours>0){
                    hours = hours+"";
                    if(hours.length<=1) { hours="0"+hours;}
                    ret+="<span class='hour'>"+hours+" </span> "+":";
                }
                if(mins>0){
                        mins = mins+"";
                    if(mins.length<=1) { mins="0"+mins;}
                    ret+="<span class='min'>"+mins+" </span> "+":";
                }
              
                       secs = secs+"";
                     if(secs.length<=1) { secs="0"+secs;}
                      ret+="<span class='sec'>"+secs+" </span> ";
                      return ret;
  }



 function show_id(num){
    if(num==1){
      $('#intro1').show();
      $('#intro2').hide();
      $('.product_intro').eq(0).addClass('active2');
      $('.product_intro').eq(1).removeClass('active2');
    }else{
      $('#intro2').show();
      $('#intro1').hide();
      $('.product_intro').eq(1).addClass('active2');
      $('.product_intro').eq(0).removeClass('active2');      
    }
  }

	
    function option_confirm(){
         var ret = option_selected();
        if(ret.no!=''){
           tip("请选择" + ret.no + "!",true);
            return false;
        }
       

     
    }




function get_search_box(){
	try{
		document.getElementById('get_search_box').click();
	}catch(err){
		document.getElementById('keywordfoot').focus();
 	}
}

function optionlabel(){
$(".hint").css({"display":"block"});
 $(".box").css({"display":"block"});
 }


 function option_selected(){
   
     var ret= {
         no: "",
         all: []
     };
    if(!hasoption){
        return ret;
    }
            $(".optionid").each(function(){
                ret.all.push($(this).val());
                if($(this).val()==''){
                    ret.no = $(this).attr("title");
                    return false;
                }
     })
     return ret;
}
function change_pic(u){             
var imgObj = document.getElementById("option_pic");
if(imgObj.getAttribute("src",2)!=u){
imgObj.src=u;
}
}


  $(function(){   
      $('.shuoming').click(function(){
        $(".groupdetail").toggle();  
 });
   $('.cardbtn').click(function(){
        $("#actionSheet_wrap").toggle();  
 });
  $('.iconbtn').click(function(){
        $("#actionSheet_wrap").toggle();  
 });
    $('#qr_code2').click(function(){
        var url = '{$qr_code}';
         showBigImage(url,$('#qr_code2'));
      
    });



 });
      function send1(){
  $(".infobox2").toggle();
     $("input[name=dispatch]").attr("checked",false);
      }


    function showStores(obj){
        if($(obj).attr('show')=='1'){
            $(obj).next('div').slideUp(100);
            $(obj).removeAttr('show').find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        }
        else{
            $(obj).next('div').slideDown(100);
            $(obj).attr('show','1').find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    }

 function checkdispro(){ //检查物流     
                var c=$('input:radio[name="dispatch"]:checked').val();                   
                     if(c==undefined){           
                        tip("请选择物流方式");
                        tip_close();
                    return 1;   
                    }
                    
              }
 function checkaddress(){//虚拟商品需填联系人、联系电话
                if($(".address_item").length==0){
                        tip("请填写联系地址!");
                        tip_close();
                          return 1;   
                    }   
            }

 function checkuservirtual(){
                  if($(".address_item").length==0){
                    if($("#carrier_input_realname").val()=='' ){                   
                        tip("请填写联系人!");
                        tip_close();
                          return 1;   
                    }   
					 if( $("#carrier_input_mobile").val()=='' ){                   
                        tip("请填写联系电话!");
                        tip_close();
                          return 1;   
                    }   
					
                  }
             }
function checkname(){
    if($(".address_item").length==0){
        if($("#carrier_input_realname").val()=='' ){
            tip("请填写联系人!");
            tip_close();
            return 1;
        }


    }
}
function checkphone(){
    if($(".address_item").length==0){
        if( $("#carrier_input_mobile").val()=='' ){
            tip("请填写联系电话!");
            tip_close();
            return 1;
        }

    }
}
function express_btn(expressname,expressnumber,url){
    $('.express_body').html('请稍候，正在查询');
    $.ajax({
        url:url,
        data:{'expressname':expressname,'expressnumber':expressnumber},
        dataType:'json',
        success:function(data){
            $('.express_body').css('display','block');
            if(data.status == 1){
                if(data.data){
                    $('.express_body').html(data.data);
                    $('.closeDis').css('display','inline');
                    $('.openDis').css('display','none');
                }else{
                    $('.express_body').html( '【<a  href="http://www.kuaidi100.com/chaxun?nu='+expressnumber+'">还没有物流信息?去官网看看 </a>】');
                }


            }else{
                $('.express_body').html(data.data);
                $('.express_body').html( '【<a  href="http://www.kuaidi100.com/chaxun?nu='+expressnumber+'">没还没有物流信息?去官网看看 </a>】');
            }
        }
    });
}
function closeDis() {
    $('.express_body').css('display','none');
    $('.closeDis').css('display','none');
    $('.openDis').css('display','inline');
  
}