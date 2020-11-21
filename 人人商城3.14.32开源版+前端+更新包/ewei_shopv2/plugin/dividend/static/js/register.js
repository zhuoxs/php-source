define(['jquery','jquery.gcjs', 'core', 'tpl', 'biz/plugin/diyform'], function ($,gc, core, tpl, diyform) {
    var modal = {params: {applytitle: '', open_protocol: 0}};
    modal.init = function (mid, params) {
        modal.params = $.extend(modal.params, params || {});
        $('.btn-submit').click(function () {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            var html = btn.html();
            var diyformdata = false;
            var data = {};

            if ($(".diyform-container").length > 0) {
                diyformdata = diyform.getData('.page-commission-register .diyform-container');
                if (!diyformdata) {
                    return
                }
                data = {'memberdata':diyformdata};
            } else {
                if ($('#realname').isEmpty()) {
                    FoxUI.toast.show('请填写您的姓名!');
                    return
                }
                if (!$('#mobile').isMobile()) {
                    FoxUI.toast.show('请填写正确手机号!');
                    return
                }
                data = {'realname': $('#realname').val(), 'mobile': $('#mobile').val(), 'weixin': $('#weixin').val()}
            }
            if (modal.params.open_protocol == 1) {
                if (!$('#agree').prop('checked')) {
                    FoxUI.toast.show('请阅读并了解【' + modal.params.applytitle + '】!');
                    return
                }
            }
            btn.attr('stop', 1).html('正在处理...');
            core.json('dividend/register', data, function (pjson) {
                console.log(pjson);
                if (pjson.status == 0) {
                    btn.removeAttr('stop').html(html);
                    FoxUI.toast.show(pjson.result.message);
                    return
                }
                var result = pjson.result;
                if (result.check == '1') {
                    FoxUI.message.show({
                        icon: 'icon icon-roundcheck success',
                        content: "恭喜您审核通过!",
                        buttons: [{
                            text: '进入商城', extraClass: 'btn-success', onclick: function () {
                                location.href = core.getUrl('')
                            }
                        }]
                    })
                } else {
                    location.href = core.getUrl('dividend/registr');
                }
            }, true, true)
        });
        $("#btn-apply").unbind('click').click(function () {
            var html = $(".pop-apply-hidden").html();
            container = new FoxUIModal({
                content: html, extraClass: "popup-modal", maskClick: function () {
                    container.close()
                }
            });
            container.show();
            $('.verify-pop').find('.close').unbind('click').click(function () {
                container.close()
            });
            $('.verify-pop').find('.btn').unbind('click').click(function () {
                container.close()
            })
        })
    };
    return modal
});