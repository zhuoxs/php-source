$(function(){
    var refresh;

    $.ajax({
        type: "get",
        url: window.moduleurl +  "RefreshScreen",
        data:'',
        dataType: "json",
        success: function(data){
            if(data.list){
                var list = '';
                $(data.list).each(function(index, el) {
                    list += '<li data-type="'+ this.type +'" class="clearfix"><span class="wrap-con-cl fl">';
                    if(this.current == 0){
                        list += '<strong>无人排号</strong>';
                    }else{
                        list +='<strong>下一位：</strong>' + this.current;
                    }
                    list+='</span><span class="wrap-con-cr fr">'+ this.type_name +'</span></li>';
                });

                $('#con1').html('').append(list);
                resizeWin();
            }else{
                alert(data.msg);
            }
        }
    });

    $(window).resize(function(){
        resizeWin();
    });

    function resizeWin(){
        var bodyH = $("body").height();//body高度
        var conh =$('.wrap-con-c ul').height();//中间排号内容高度
        var conmaxH =bodyH-310;//中间内容最大高度


        if(conh > conmaxH){
            var s = Math.floor(conmaxH/106);
            $(".wrap-con").height(s*106+1);
            $('.wrap-con-c').height(s*106-1);
            scrollTop(s);
        }else{
            $(".wrap-con").height(conh+2);
            $('.wrap').css("padding-top",(bodyH-conh-310)/2+15);
        }

        function scrollTop(sum){
            var lisum = $('#con1 li').size();
            var MyMar;

            if(lisum > sum){
                var speed=30,
                    con = document.getElementById('con'),
                    con1= document.getElementById('con1'),
                    con2= document.getElementById('con2');

                con2.innerHTML=con1.innerHTML;

                console.log('test');

                function Marquee(){
                    if(con1.offsetHeight-con.scrollTop<=0)
                        con.scrollTop-=con1.offsetHeight
                    else{
                        con.scrollTop++;
                    }
                }
                MyMar=setInterval(Marquee,speed)
            }else{
                clearInterval(MyMar);
            }

        }
    }

    //刷新页面
    function Fonrefresh(){
        $.ajax({
            type: "get",
            url: window.moduleurl +  "RefreshScreen",
            data:'',
            dataType: "json",
            success: function(data){
                if(data.list){
                    $(data.list).each(function() {
                        var datatype = this.type,
                            dataname = '';

                        if (this.current == 0) {
                            dataname = '<strong>无人排号</strong>';
                        } else {
                            dataname = '<strong>下一位：</strong>' + this.current;
                        }

                        $('#con1 li').each(function() {
                            var thistype = $(this).data('type');
                            if(datatype == thistype){
                                $(this).find('.wrap-con-cl').html('').append(dataname);
                            }

                        });
                        $('#con2 li').each(function() {
                            var thistype = $(this).data('type');
                            if(datatype == thistype){
                                $(this).find('.wrap-con-cl').html('').append(dataname);
                            }

                        });

                    });
                }
            }
        });
    }
    refresh = setInterval(Fonrefresh,3000);
});