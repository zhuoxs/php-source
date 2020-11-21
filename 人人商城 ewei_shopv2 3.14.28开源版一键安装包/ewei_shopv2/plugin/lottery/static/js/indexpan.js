/**
 * Created by Root on 2016/12/19.
 */
define(['core', 'tpl'], function (core, tpl) {
    var modal = {};

    modal.init = function (params) {
        $('#pointer').on('touchstart',function(e) {
            if(params.is_login==0){
                var backurl = core.getUrl('lottery/index',{id:params.id})
                FoxUI.confirm("请先登录","提示",function () {
                    location.href = core.getUrl('account/login', {backurl: btoa(backurl)})
                })
                return false;
            }
        });

    };

    return modal;
});