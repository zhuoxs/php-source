$(function(){
    /*顶部导航的展开和收起*/
    $(".head .menu").click(function(){
        if($(".js-header").hasClass("nav-active")==false){
            $(".js-header nav").css("top","40px");
          	$(".js-header nav").css("display","block");
            $(".js-header").addClass("nav-active");
        }else{
            $(".js-header nav").css("top","-100%");
          	$(".js-header nav").css("display","none");
            $(".js-header").removeClass("nav-active");
        }
    });
    $(".nav-masklayer").click(function(){
        $(".js-header nav").css("top","-100%");
      	$(".js-header nav").css("display","none");
        $(".js-header").removeClass("nav-active");
    });

    /*点击分类更多和收起*/
    $(".select").on("click",function(){
        var $text = $(this).text();
        if($text == "更多"){
            var self = $(".item label").text();
            if(self == "分类：子分类：标签：排序："){
                $(".vault-top").animate({height:"210px"});
            }else{
                $(".vault-top").animate({height:"165px"});
            }
            $(this).text("收起");
        }else{
            $(".vault-top").animate({height:"120px"});
            $(this).text("更多");
        }

    });
});

window.onload=function () {
    document.addEventListener('touchstart',function (event) {
        if(event.touches.length>1){
            event.preventDefault();
        }
    })
    var lastTouchEnd=0;
    document.addEventListener('touchend',function (event) {
        var now=(new Date()).getTime();
        if(now-lastTouchEnd<=300){
            event.preventDefault();
        }
        lastTouchEnd=now;
    },false)
}


//资讯扣费
function novelpermit(itemprice,id){
    requestData={itemprice:itemprice,id:id,type:3};
    //询问框
    layer.open({
        content: '你需要花费'+itemprice+'金币浏览该文章吗？'
        ,btn: ['阅读','取消']
        ,yes: function(index){
            $.post('/api/permit.html',requestData,function (e) {
                if(e.resultCode==0){
                    layer.open({content: e.message,skin: 'msg',time: 2,end:function(){
                            window.location.reload();
                        }
                    });
                }else if(e.resultCode==4005){
                    layer.open({
                        content: e.error,skin: 'msg',time: 2,end:function(){
                            window.location.href="/index/login";
                        }
                    });
                } else {
                    layer.open({content: e.error,skin: 'msg',time: 2});
                }
            },'json');
        }
    });
}

//图片扣费
function imagespermit(itemprice,id){
    requestData={itemprice:itemprice,id:id,type:2};
    layer.open({
        content: '你需要花费'+itemprice+'金币阅读该图册吗？'
        ,btn: ['阅读','取消']
        ,yes: function(index){
            $.post('/api/permit.html',requestData,function (e) {
                if(e.resultCode==0){
                    layer.open({content: e.message,skin: 'msg',time: 2,end:function(){
                        window.location.reload();
                    }});
                }else if(e.resultCode==4005){
                    layer.open({content: e.error,skin: 'msg',time: 2,end:function(){
                            window.location.href="/index/login";
                    }});
                } else {
                    layer.open({content: e.error,skin: 'msg',time: 2});
                }
            },'json');
        }
    });
}

//删除收藏 id为project_id,type为删除类型,removeObjId为执行完毕要移除的对象元素
function delcolect(id,type,colle_id,removeObjId){
    var DelColleData={type:type,id:id,colle_id:colle_id};
    var msg='您确定<b style="color:red;">删除</b>此内容吗？';
    switch (type){
        case 'video':
            msg='您确定<b style="color:red;">取消收藏</b>此相册吗？';
            break;
        case 'user_atlas':
            msg='您确定<b style="color:red;">删除此收藏相册</b>吗？';
            break;
        case 'novel':
            msg='您确定<b style="color:red;">取消收藏</b>此资讯吗？';
            break;
        case 'image':
            msg='您确定<b style="color:red;">取消收藏</b>此图片吗？';
            break;
    }

    layer.open({
        content:msg
        ,btn: ['确定','取消']
        ,yes: function(index){
        $.get('/api/delcollection.html',DelColleData,function(e){
            if(e.resultCode==4005){
                layer.open({content: e.error,skin: 'msg',time: 2});
            }else if(e.resultCode==5002){
                layer.open({content: e.error,skin: 'msg',time: 2});
            }else if(e.resultCode==0){
                layer.open({content: e.message,skin: 'msg',time: 2,end:function(){
                    if(removeObjId==undefined){
                        window.location.reload();
                    }else{
                        $('#'+removeObjId).hide(500,function () {
                            $('#'+removeObjId).remove();
                        })
                    }
                }});
            }
        },'json');
        }
    });
}

/*我的收藏、编辑图册*/
function atlas_edit(atlasid,imgname){
    layer.open({
        title: '创建图册',
        btn: ['确定', '取消'],
        content: '<input type="text" class="layui-layer-input" id="imgname" value="'+imgname+'"/>',
        yes: function(index){
            var imgnames = $('#imgname').val();
        var imgsname={name:imgnames,type:'1',id:atlasid};
        $.get('/api/control_imgs.html',imgsname,function(e){
            if(e.resultCode==4005){
                layer.open({content: e.error,skin: 'msg',time: 1});
            }else if(e.resultCode==5002){
                layer.open({content: e.error,skin: 'msg',time: 1});
            }else if(e.resultCode==0){
                layer.open({content: e.message,skin: 'msg',time: 1,end:function(){
                    window.location.reload();
                }});
            }
        },'json');
         }
    });
}

//打赏
function reward(itemid,itemprice,projectid,type){
    var requestData={itemid:itemid,projectid:projectid,type:type,itemprice:itemprice};
    layer.open({
        content:'你需要花费'+itemprice+'金币打赏礼物吗？',
        btn:['打赏','取消'],
        yes:function () {
            $.post('/api/reward.html',requestData,function (e) {
                if(e.resultCode==0){
                    $("#count").html(e.data.counts);
                    $("#countprice").html(e.data.countprice);
                    layer.open({skin:'msg',content:e.message,time:2});
                }else if(e.resultCode==4005){
                    layer.open({
                        'content':e.error,
                        skin:'msg',
                        time:2,
                        end:function(){
                            location.href="/index/login";
                        }
                    });
                } else {
                    layer.open({skin:'msg',content:e.error,time:2});
                }
            },'json');
        }

    });
}

/*收藏*/
function select_atlas(id) {
    $.get('/api/is_login.html',function(e){//检测登录
        if(e.resultCode==0){
            layer.open({
                type: 1,
                title:'收藏相册',
                skin: 'layui-layer-rim', //加上边框
                area: ['420px', '250px'], //宽高
                content: $('.select-box')
            });
            $(".layui-layer-content").css("height","100%");
            $('#collect_id').val(id);
            $(this).addClass("isSelected");
        }else {
            layer.msg('请登录后再试');
        }
    },'json');
};

/* 验证邮箱地址的合法性 */
function isEmail(str){
    var reg=/^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/;
    return reg.test(str);
}
/* 验证邮箱地址的合法性 */
function isPhone(str){
    var reg = /((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8}$/;
    return reg.test(str);
}


/* PC判断 */
function isPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
