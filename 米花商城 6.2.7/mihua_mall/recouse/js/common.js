/* $Id : common.js 4865 2007-01-31 14:04:10Z paulgao $ */
 function tip(msg,autoClose){
     var div = $("#poptip");
     var content =$("#poptip_content");
     if(div.length<=0){
         div = $("<div id='poptip'></div>").appendTo(document.body);
         content =$("<div id='poptip_content'>" + msg + "</div>").appendTo(document.body);
     }
     else{
         content.html(msg);
         content.show(); div.show();
     }
     if(autoClose) {
        setTimeout(function(){
            content.fadeOut(500);
            div.fadeOut(500);

        },1000);
     }
}
function tip_close(){
    $("#poptip").fadeOut(2000);
     $("#poptip_content").fadeOut(2000);
}
/* *
 * 添加商品到购物车 
 */

function addToCart(goodsId, cp, parentId)
{
  var goods        = new Object();
  var spec_arr     = new Array();
  var fittings_arr = new Array();
  var number       = 1;
  var formBuy      = document.forms['ECS_FORMBUY'];
  var quick		   = 0;

  // 检查是否有商品规格 
  if (formBuy)
  {
    spec_arr = getSelectedAttributes(formBuy);

    if (formBuy.elements['number'])
    {
      number = formBuy.elements['number'].value;
    }

	quick = 1;
  }

  goods.quick    = quick;
  goods.spec     = spec_arr;
  goods.goods_id = goodsId;
  goods.number   = number;
  goods.parent   = (typeof(parentId) == "undefined") ? 0 : parseInt(parentId);

  Ajax.call('buy.php?act=add_to_cart', 'cp='+ cp +'&goods=' + $.toJSON(goods), addToCartResponse, 'POST', 'JSON');
}

/**
 * 获得选定的商品属性
 */
function getSelectedAttributes(formBuy)
{
  var spec_arr = new Array();
  var j = 0;

  for (i = 0; i < formBuy.elements.length; i ++ )
  {
    var prefix = formBuy.elements[i].name.substr(0, 5);

    if (prefix == 'spec_' && (
      ((formBuy.elements[i].type == 'radio' || formBuy.elements[i].type == 'checkbox') && formBuy.elements[i].checked) ||
      formBuy.elements[i].tagName == 'SELECT'))
    {
      spec_arr[j] = formBuy.elements[i].value;
      j++ ;
    }
  }

  return spec_arr;
}

/* *
 * 处理添加商品到购物车的反馈信息
 */
function addToCartResponse(result)
{
  if (result.error > 0)
  {
    // 如果需要缺货登记，跳转
    if (result.error == 2)
    {
      if (confirm(result.message))
      {
        //location.href = 'user.php?act=add_booking&id=' + result.goods_id + '&spec=' + result.product_spec;
		location.href = 'kefu.php';
      }
    }
    // 没选规格，弹出属性选择框
    //else if (result.error == 6)
    //{
    //  openSpeDiv(result.message, result.goods_id, result.parent);
    //}
    else
    {
      alert(result.message);
    }
  }
  else
  {
    var cart_url = 'cart.php';

    if (result.ctype == '1')
    {
	  $("#buy_lay").show();
	  $("#buy_lay_frm").show();
	  $("#buy_lay_frm").css({"top":($(window).height()/2-70)+'px'});
    }else{
		location.href = cart_url;
	}
   
  }
}

/* *
 * 添加商品到收藏夹
 */
function collect(goodsId)
{
  Ajax.call('user.php?act=collect', 'id=' + goodsId, collectResponse, 'GET', 'JSON');
}

/* *
 * 处理收藏商品的反馈信息
 */
function collectResponse(result)
{
  alert(result.message);
}

/* *
 *  返回属性列表
 */
function getAttr(cat_id)
{
  var tbodies = document.getElementsByTagName('tbody');
  for (i = 0; i < tbodies.length; i ++ )
  {
    if (tbodies[i].id.substr(0, 10) == 'goods_type')tbodies[i].style.display = 'none';
  }

  var type_body = 'goods_type_' + cat_id;
  try
  {
    document.getElementById(type_body).style.display = '';
  }
  catch (e)
  {
  }
}

function showBigImage(url,obj){
    var maxWidth = 360;
    var offset = obj.offset();
    var start = {
        width:obj.attr('width')||parseInt(obj.css('width')),
        height:obj.attr('height')||parseInt(obj.css('height'))
    }
    $('<div></div>')
    .attr('id', 'div_img_cover')
    .css({ 'position': 'absolute', 'top': '0', 'left': '0', 'z-index': 9999, 
        'width': "100%", 
        'height': getWaitHeight(),
        'text-align': 'center',
        'font': 'bold 24px arial',
        'background-repeat': 'no-repeat',
        'background-position': 'center',
        'background-attachment': 'fixed',
        'opacity':0.8,
        'background':'#000'
        })
    .appendTo('body');
     
    var img = new Image();
    $(img).css(start);
    if(img.attachEvent){
        img.attachEvent('onload',imgLoaded)
    }else{
        img.addEventListener('load',imgLoaded,false);
    }
    img.src = url;
    function imgLoaded(){
        var imgWidth = img.width,imgHeight = img.height;
        var newWidth = imgWidth > maxWidth ? maxWidth : imgWidth;
        var newHeight = imgHeight/imgWidth*newWidth
        var end = {
            width:parseInt(newWidth),
            height:parseInt(newHeight)
        }
        var container = $('<div></div>').appendTo('body');
        container.css('position','absolute');
        container.css(offset);
        container.attr('id','container');
        container.append(img);
        var css = setElementCenter('#container',1,end);
        $(img).animate(end,200);
        container.animate(css,200);
        $('#div_img_cover').click(function(){
            var that = $(this);
            $(img).animate(start,200);
            container.animate(offset,200,function(){
                that.remove();
                $(this).remove();
            });
        });
                $('#container').click(function(){
           $("#div_img_cover").remove();
            $("#container").remove();
           
        });

    }
     
    function setElementCenter(selector,pos,finalSize){
        var position = $(selector).css('position')=='fixed';
        var winSize = myGetWinSize();
        var elementSize = finalSize || getElementSize(selector);
        var finalTop =(winSize.height-elementSize.height)/2 + parseInt((!position ? winSize.scrollTop : 0)),
            finalLeft=(winSize.width-elementSize.width)/2+winSize.scrollLeft;
        var finalCss = {
            left:finalLeft,
            top:position ? finalTop : (finalTop<winSize.scrollTop ? winSize.scrollTop : finalTop)
        }
        if(!pos){
            $(selector).css({'position':position ?'fixed' : 'absolute','z-index':10000});
            $(selector).css(finalCss);
        }
        $(selector).css({'z-index':10000});
        return finalCss;
    }
    function myGetWinSize(){
        var size = {
            width:document.documentElement.clientWidth || document.body.clientWidth,
            height:document.documentElement.clientHeight || document.body.clientHeight,
            scrollTop:$(window).scrollTop(),
            scrollLeft:$(window).scrollLeft()
        }
        return size;
    }
    function getElementSize(selector){
        return {
            width:$(selector).width(),
            height:$(selector).height()
        }
    }
    function getWaitHeight(){
        var scrollHeight,
            offsetHeight;
        // handle IE 6
        if ('undefined' == typeof(document.body.style.maxHeight)) {
        //if ($.browser.msie && $.browser.version < 7) {
            scrollHeight = Math.max(
                 document.documentElement.scrollHeight,
                 document.body.scrollHeight
            );
            offsetHeight = Math.max(
                     document.documentElement.offsetHeight,
                     document.body.offsetHeight
            );
         
            if (scrollHeight < offsetHeight) {
                     return $(window).height() + 'px';
            } else {
                     return scrollHeight + 'px';
            }
        // handle "good" browsers
        } else {
            return $(document).height() + 'px';
        }
    }
}