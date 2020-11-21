/**
 * 公共js方法
 * @Author: dreamer
 * @Date:   2017/11/15
 */

/**
 * 图片的layer tips层
 * @param e     需要弹出层的对象，一般直接用(this)
 * @param param
 */
function imgTips(e,param){
    var imgSrc=$(e).attr('src');
    var width=800;
    var className='tipsimg';
    var bgColor='#fff';

    if(param!=undefined){
        if(param.width!=undefined)  width=param.width;
        if(param.className!=undefined)  className=param.className;
        if(param.bgColor!=undefined)  bgColor=param.bgColor;
    }

    var index=layer.tips("<img style='max-width:"+width+"px;' class='"+className+"' src='"+imgSrc+"'}>",e,{tips: [1, bgColor],area: [(width+30)+'px', 'auto'],});


    $(e).on('mouseout',function(){
        layer.closeAll();
    });
}