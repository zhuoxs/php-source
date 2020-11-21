/**
 * Created by Root on 2016/12/19.
 */
define(['core', 'tpl'], function (core, tpl) {
    var modal = {};

    modal.init = function (params) {
        $('#gua-img').on('touchstart',function(e) {
            if(params.is_login==0){
                var backurl = core.getUrl('lottery/index',{id:params.id})
                FoxUI.confirm("请先登录","提示",function () {
                    location.href = core.getUrl('account/login', {backurl: btoa(backurl)})
                })
                return false;
            }
            if(params.changes<=0){
                $('#model-failtitle').html(params.toast);
                taskget = new FoxUIModal({
                    content: $('#failmodel').html(),
                    extraClass: 'picker-modal',
                    maskClick: function () {
                        taskget.close();
                    }
                });
                taskget.container.find('.task-btn-close').click(function () {
                    taskget.close();
                });
                taskget.show();
                return false;
            }
        });

    };

    return modal;
});