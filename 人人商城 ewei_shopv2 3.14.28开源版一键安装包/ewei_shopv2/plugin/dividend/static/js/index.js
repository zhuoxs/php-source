define(['core', 'tpl'], function (core, tpl) {
    var modal = {};
    modal.init = function () {
        $('.setteam').click(function() {
            FoxUI.loader.display('loading','创建中...');
            core.json('dividend/createTeam', {}, function (ret) {
                var result = ret.result;
                if(ret.status == 0){
                    FoxUI.loader.hide();
                    FoxUI.toast.show(result.message);
                    location.reload();
                }else if(ret.status == 1){
                    FoxUI.toast.show(result.message);
                    FoxUI.loader.hide();
                    location.reload();
                    return
                }
            })
        });
    };

    return modal
});