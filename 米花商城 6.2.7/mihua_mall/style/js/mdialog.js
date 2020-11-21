/*  
 * @弹出提示层 ( 加载动画(load), 提示动画(tip), 成功(success), 错误(error), )  
 * @method  tipBox  
 * @description 默认配置参数   
 * @time    2014-12-19   
 * @param {Number} width -宽度  
 * @param {Number} height -高度         
 * @param {String} str -默认文字  
 * @param {Object} windowDom -载入窗口 默认当前窗口  
 * @param {Number} setTime -定时消失(毫秒) 默认为0 不消失  
 * @param {Boolean} hasMask -是否显示遮罩  
 * @param {Boolean} hasMaskWhite -显示白色遮罩   
 * @param {Boolean} clickDomCancel -点击空白取消  
 * @param {Function} callBack -回调函数 (只在开启定时消失时才生效)  
 * @param {Function} hasBtn -显示按钮  
 * @param {String} type -动画类型 (加载,成功,失败,提示)  
 * @example   
 * new TipBox();   
 * new TipBox({type:'load',setTime:1000,callBack:function(){ alert(..) }});   
*/  
function TipBox(cfg){  
    this.config = {   
        width          : 250,      
        height         : 170,                 
        str            : '正在处理',       
        windowDom      : window,   
        setTime        : 0,     
        hasMask        : true,    
        hasMaskWhite   : false,   
        clickDomCancel : false,    
        callBack       : null, 
        hasBtn         : false, 
        type           : 'success'  
    }  
    $.extend(this.config,cfg);    
      
    //存在就retrun  
    if(TipBox.prototype.boundingBox) return;  
      
    //初始化  
    this.render(this.config.type);    
    return this;   
};  
  
//外层box  
TipBox.prototype.boundingBox = null;  
  
//渲染  
TipBox.prototype.render = function(tipType,container){    
    this.renderUI(tipType);   
      
    //绑定事件  
    this.bindUI();   
      
    //初始化UI  
    this.syncUI();   
    $(container || this.config.windowDom.document.body).append(TipBox.prototype.boundingBox);     
};  
  
//渲染UI  
TipBox.prototype.renderUI = function(tipType){   
    TipBox.prototype.boundingBox = $("<div id='animationTipBox'></div>");         
    tipType == 'load'    && this.loadRenderUI();  
    tipType == 'success' && this.successRenderUI();   
    tipType == 'error'   && this.errorRenderUI();  
    tipType == 'tip'     && this.tipRenderUI();  
    TipBox.prototype.boundingBox.appendTo(this.config.windowDom.document.body);  
                  
    //是否显示遮罩  
    if(this.config.hasMask){  
        this.config.hasMaskWhite ? this._mask = $("<div class='mask_white'></div>") : this._mask = $("<div class='mask'></div>");  
        this._mask.appendTo(this.config.windowDom.document.body);  
    }     
    // 是否显示按钮
    if(this.config.hasBtn){
        this.config.height = 206;
        $('#animationTipBox').css("margin-top","103px");
        switch(this.config.type){
            case 'success':$(".success").after("<button class='okoButton'>ok</button>");
                break;
            case 'error':$(".lose").after("<button  class='okoButton redOkoButton'>ok</button>");
                break;
            case 'tip':$(".tip").after("<button class='okoButton'>ok</button>");
                break;
            default: break;
        }
      
        
  $('button.okoButton').on('click',function(){location.reload();_this.close();});
    }
    //定时消失  
    _this = this;  
    !this.config.setTime && typeof this.config.callBack === "function" && (this.config.setTime = 1);      
    this.config.setTime && setTimeout( function(){ _this.close(); }, _this.config.setTime );  
};  
  
TipBox.prototype.bindUI = function(){  
    _this = this;             
      
    //点击空白立即取消  
    this.config.clickDomCancel && this._mask && this._mask.click(function(){_this.close();});                        
};  
TipBox.prototype.syncUI = function(){             
    TipBox.prototype.boundingBox.css({  
        width       : this.config.width+'px',  
        height      : this.config.height+'px',  
        marginLeft  : "-"+(this.config.width/2)+'px',  
        marginTop   : "-"+(this.config.height/2)+'px'  
    });   
};  
  
//提示效果UI  
TipBox.prototype.tipRenderUI = function(){  
    var tip = "<div class='tip'>";  
        tip +="     <div class='icon'>i</div>";  
        tip +="     <div class='dec_txt'>"+this.config.str+"</div>";  
        tip += "</div>";  
    TipBox.prototype.boundingBox.append(tip);  
};  
  
//成功效果UI  
TipBox.prototype.successRenderUI = function(){  
    var suc = "<div class='success'>";  
        suc +=" <div class='icon'>";  
        suc +=      "<div class='line_short'></div>";  
        suc +=      "<div class='line_long'></div>  ";        
        suc +=  "</div>";  
        suc +=" <div class='dec_txt'>"+this.config.str+"</div>";  
        suc += "</div>";  
    TipBox.prototype.boundingBox.append(suc);  
};  
  
//错误效果UI  
TipBox.prototype.errorRenderUI = function(){  
    var err  = "<div class='lose'>";  
        err +=  "   <div class='icon'>";  
        err +=  "       <div class='icon_box'>";  
        err +=  "           <div class='line_left'></div>";  
        err +=  "           <div class='line_right'></div>";  
        err +=  "       </div>";  
        err +=  "   </div>";  
        err +=  "<div class='dec_txt'>"+this.config.str+"</div>";  
        err +=  "</div>";  
    TipBox.prototype.boundingBox.append(err);  
};  
  
//加载动画load UI  
TipBox.prototype.loadRenderUI = function(){  
    var load = "<div class='load'>";  
        load += "<div class='icon_box'>";  
    for(var i = 1; i < 4; i++ ){  
        load += "<div class='cirBox"+i+"'>";  
        load +=     "<div class='cir1'></div>";  
        load +=     "<div class='cir2'></div>";  
        load +=     "<div class='cir3'></div>";  
        load +=     "<div class='cir4'></div>";  
        load += "</div>";  
    }  
    load += "</div>";  
    load += "</div>";  
    load += "<div class='dec_txt'>"+this.config.str+"</div>";  
    TipBox.prototype.boundingBox.append(load);  
};  
  
//关闭  
TipBox.prototype.close = function(){      
    TipBox.prototype.destroy();  
    this.destroy();  
    this.config.setTime && typeof this.config.callBack === "function" && this.config.callBack();                  
};  
  
//销毁  
TipBox.prototype.destroy = function(){  
    this._mask && this._mask.remove();  
    TipBox.prototype.boundingBox && TipBox.prototype.boundingBox.remove();   
    TipBox.prototype.boundingBox = null;  
};  