define(['core', 'tpl', 'biz/plugin/universalform'],
function(core, tpl, universalform) {
    var modal = {
        params: {
            applytitle: '',
            open_protocol: 0
        }
    };
    modal.init = function(fid,params) {
        modal.params = $.extend(modal.params, params || {});
        modal.fid = fid;
        $('.btn-submit').click(function() {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            var html = btn.html();
            var universalformdata = false;
            universalformdata = universalform.getData('.universalform-container');
            if (!universalformdata) {
                return
            }
            var data = {
            	universalformdata: universalformdata,
            	id : modal.fid
            }
            btn.attr('stop', 1).html('正在处理...');
            core.json('universalform/post', data,
            function(pjson) {
                if (pjson.status == 0) {
                    btn.removeAttr('stop').html(html);
                    FoxUI.toast.show(pjson.result.message);
                    return
                }
                FoxUI.toast.show(pjson.result.message);
                setTimeout("history.go(-1);",1000);
                
            },
            true, true)
        });
       
    };
    return modal
});