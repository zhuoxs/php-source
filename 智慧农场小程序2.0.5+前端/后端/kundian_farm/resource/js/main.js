function postData(url, data) {
    var load=layer.load();
    $.post(url, data, function (data) {
        console.log(data);
        layer.close(load);
        layer.closeAll();
        data = JSON.parse(data);
        if (data.code == 0) {
            if(data.redirect){
                setTimeout(function () {
                    window.location.href = data.redirect;
                }, 1000)
            }
        }
        layer.msg(data.msg);
    });
}


function updateData(url,data,title) {
    layer.confirm(title,function (index) {
        var load=layer.load(1);
        $.ajax({
            type:"post",
            data:data,
            url:url,
            dataType:'json',
            success:function(res){
                layer.close(load);
                layer.close(index);
                layer.msg(res.msg,{time:1000},function () {
                    if(res.code==0){
                        window.location.reload();
                    }
                });
            }
        })
    })
}


function goBack() {
    window.history.go(-1);
}

//  禁用回车时间
// $(window).keydown( function(e) {
//     var key = window.event?e.keyCode:e.which;
//     if(key.toString() == "13"){
//         return false;
//     }
// });
