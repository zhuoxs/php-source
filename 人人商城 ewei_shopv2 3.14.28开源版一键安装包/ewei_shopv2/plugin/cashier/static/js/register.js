define(['core', 'tpl', 'biz/plugin/diyform'], function (core, tpl, diyform) {
    var modal = {params: {applycontent: 0}};
    modal.init = function (params) {
        modal.params.applycontent = params.applycontent;
        $('.fui-uploader').uploader({
            uploadUrl: core.getUrl('cashier/uploader'),
            removeUrl: core.getUrl('cashier/uploader/remove')
        });

        $('.btn-submit').click(function () {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            var html = btn.html();
            var diyformdata = false;
            if ($('#title').isEmpty()) {
                FoxUI.toast.show('请填写收银台名称!');
                return
            }
            if ($('#name').isEmpty()) {
                FoxUI.toast.show('请填写联系人!');
                return
            }
            if (!$('#mobile').isMobile()) {
                FoxUI.toast.show('请填写正确的手机号!');
                return
            }
            if ($('#username').isEmpty()) {
                FoxUI.toast.show('请填写登录用户名!');
                return
            }

            var data = $("#cashierForm").serialize();

            if ($(".diyform-container").length > 0) {
                diyformdata = diyform.getData('.page-cashier-register .diyform-container');
                if (!diyformdata) {
                    return
                }
                data.mdata =  diyformdata;
            }

            if (modal.params.applycontent == 1) {
                if (!$('#agree').prop('checked')) {
                    FoxUI.toast.show('请阅读并了解【申请协议】!');
                    return
                }
            }

            btn.attr('stop', 1).html('正在处理...');
            core.json('cashier/register', data, function (pjson) {
                if (pjson.status == 0) {
                    btn.removeAttr('stop').html(html);
                    FoxUI.toast.show(pjson.result.message);
                    return
                }

                FoxUI.message.show({
                    icon: 'icon icon-info text-warning',
                    content: "您的申请已经提交，请等待我们联系您!",
                    buttons: [{
                        text: '先去商城逛逛', extraClass: 'btn-danger', onclick: function () {
                            location.href = core.getUrl('')
                        }
                    }]
                });

            }, true, true)
        });
        
        $("#btn-apply").unbind('click').click(function () {
            var html = $(".pop-apply-hidden").html();
            container = new FoxUIModal({
                content: html, extraClass: "popup-modal", maskClick: function () {
                    container.close();
                }
            });
            container.show();
            $('.verify-pop').find('.close').unbind('click').click(function () {
                container.close()
            });
            $('.verify-pop').find('.btn').unbind('click').click(function () {
                container.close();
            })
        });
    };
    return modal
});