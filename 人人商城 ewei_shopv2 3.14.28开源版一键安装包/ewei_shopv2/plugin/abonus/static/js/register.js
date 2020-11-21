define(['core', 'tpl', 'biz/plugin/diyform', 'foxui.picker'], function (core, tpl, diyform) {
    var modal = {params: {applytitle: '', open_protocol: 0}};
    modal.init = function (params) {
        modal.params = $.extend(modal.params, params || {});

        if ($(".diyform-container").length <= 0) {


            $('#citypicker1').cityPicker({
                showArea: false,
                showCity: false
            });
            $('#citypicker2').cityPicker({
                showArea: false
            });
            $('#citypicker3').cityPicker({});

            $(":radio[name='aagenttype']").click(function () {

                $("#div_province,#div_city,#div_area").hide();
                var type = $(this).val();
                if (type == '1') {
                    $("#div_province").show();
                } else if (type == '2') {
                    $("#div_city").show();
                } else if (type == '3') {
                    $("#div_area").show();
                }
            });
        }
        $('.btn-submit').click(function () {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            var html = btn.html();
            var diyformdata = false;
            var data = {};
            if ($(".diyform-container").length > 0) {
                diyformdata = diyform.getData('.page-abonus-register .diyform-container');
                if (!diyformdata) {
                    return
                }
                data = {memberdata: diyformdata}
            } else {
                if ($('#realname').isEmpty()) {
                    FoxUI.toast.show('请填写您的姓名!');
                    return
                }
                if (!$('#mobile').isMobile()) {
                    FoxUI.toast.show('请填写正确手机号!');
                    return
                }
                if ($(":radio[name='aagenttype']:checked").length <= 0) {
                    FoxUI.toast.show('请选择代理类型!');
                    return;
                }
                var type = $(":radio[name='aagenttype']:checked").val();
                if (type == '1') {
                    if ($('#citypicker1').isEmpty()) {
                        FoxUI.toast.show('请选择要代理的省份!');
                        return;
                    }
                    $('#citypicker2').val('');
                    $('#citypicker3').val('');
                } else if (type == '2') {
                    if ($('#citypicker2').isEmpty()) {
                        FoxUI.toast.show('请选择要代理的城市!');
                        return;
                    }
                    $('#citypicker1').val('');
                    $('#citypicker3').val('');
                } else if (type == '3') {
                    if ($('#citypicker3').isEmpty()) {
                        FoxUI.toast.show('请选择要代理的地区!');
                        return;
                    }
                    $('#citypicker1').val('');
                    $('#citypicker2').val('');
                }

                data = {
                    'realname': $('#realname').val(),
                    'mobile': $('#mobile').val(),
                    'weixin': $('#weixin').val(),
                    'aagenttype': type,
                    'province': $('#citypicker1').val(),
                    'city': $('#citypicker2').val(),
                    'area': $('#citypicker3').val()
                }
            }

            if (modal.params.open_protocol == 1) {
                if (!$('#agree').prop('checked')) {
                    FoxUI.toast.show('请阅读并了解【'+ modal.params.applytitle +'】!');
                    return
                }
            }

            btn.attr('stop', 1).html('正在处理...');
            core.json('abonus/register', data, function (pjson) {

                if (pjson.status == 0) {
                    btn.removeAttr('stop').html(html);
                    FoxUI.toast.show(pjson.result.message);
                    return
                }
                var result = pjson.result;
                FoxUI.message.show({
                    icon: 'icon icon-info text-warning',
                    content: "您的申请已经提交，我们会尽快联系您!",
                    buttons: [{
                        text: '先去商城逛逛', extraClass: 'btn-danger', onclick: function () {
                            location.href = core.getUrl('')
                        }
                    }]
                });

            }, true, true);
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