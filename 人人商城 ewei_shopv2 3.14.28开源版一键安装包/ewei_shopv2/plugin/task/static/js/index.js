define(['core', 'tpl'], function (core, tpl) {
    var model = {};
    model.init = function () {
        $('.pickit').click(function () {
            FoxUI.loader.show('mini');
            var id = $(this).data('id');
            if (id != undefined){
                $.ajax({
                    url:core.getUrl('task.picktask'),
                    data:{id:id},
                    type:'post',
                    success:function (data) {
                        data = JSON.parse(data);
                        if (data.status == 1){
                            FoxUI.loader.hide();
                            FoxUI.alert('请在我的任务中查看','接取成功',function () {
                                location.href = core.getUrl('task.mine');
                            });
                        }else{
                            FoxUI.loader.hide();
                            FoxUI.alert(data.result.message,'失败提示');
                        }
                    }
                });
            }
        })
    }
    return model;
})
