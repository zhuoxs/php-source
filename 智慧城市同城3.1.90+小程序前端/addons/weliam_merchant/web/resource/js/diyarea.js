/**
 * 区域选择四级联动
 */
$(document).ready(function(){
    $(".selectArea .changeArea").change(function () {
        var lv = $(this).attr("level");
        var id = $(this).val();
        $(this).attr("data-value",id);
        if(lv < 4){
            lv++;
            //解决选择区域时 区域突然中断问题
            if(lv == 2){
                $(".selectArea .changeArea[level='3']").html('');
                $(".selectArea .changeArea[level='4']").html('');
            }else if(lv == 3){
                $(".selectArea .changeArea[level='4']").html('');
            }
            //发送请求 获取地址信息
            var url = './index.php?c=site&a=entry&m=weliam_merchant&p=area&ac=areaagent&do=getAreaInfo&';
            $.post(url,{id:id,lv:lv},function (res) {
                if(res.errno == 1){
                    var position = $(".selectArea .changeArea[level='"+lv+"']");
                    //删除原始内容
                    position.html('');
                    //建立新信息
                    var info = res.data;
                    var html = '';
                    if(Object.keys(info).length > 0){
                        $.each(info,function (k,v) {
                            html += "<option value='"+v['id']+"'>"+v['name']+"</option>";
                        });
                        position.append(html);
                        position.change();
                    }
                }else{
                    tip.msgbox.err(res.message);
                }
            },'json');
        }
    });
});




