define(['core', './order-base.js'], function (core, obase) {
    var modal = {paction: false, orderid: 0};
    modal.initDetail = function () {
        obase.init();
        if (window.remarksaler == 1) {
            $(".icon-pin").show()
        } else if (window.remarksaler == 2) {
            $(".icon-pin").hide()
        }
        $(".check-param").unbind('click').click(function () {
            var action = $(this).data('action');
            if (action) {
                modal.paction = action;
                modal.showParams()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            var action = modal.paction;
            if (action == 'remarksaler') {
                var text = $("#remarksaler").data('olddata');
                $("#remarksaler").val(text)
            } else if (action == 'changeaddress') {
                location.reload()
            }
            modal.hideParams()
        })
    };
    modal.showParams = function () {
        if (!modal.paction) {
            return
        }
        $(".params-block .fui-navbar .cancel-params").css('display', 'table-cell');
        $(".params-block .fui-navbar .submit-params").css('display', 'table-cell');
        var params_item = $(".params-block").find(".param-" + modal.paction);
        if (params_item.length < 1) {
            return
        }
        params_item.show();
        $(".params-block").addClass('in');
        $(".btn-back").hide()
    };
    modal.hideParams = function () {
        $(".params-block .fui-navbar .nav-item").hide();
        $(".params-block").find(".param-item").hide();
        $(".params-block").removeClass('in');
        $(".btn-back").show();
        modal.paction = false;
        modal.orderid = 0
    };
    modal.getVal = function (elm, int, isClass) {
        var mark = isClass ? "." : "#";
        var value = $.trim($(mark + elm).val());
        if (int) {
            if (value == '') {
                return 0
            }
            value = parseInt(value)
        }
        return value
    };
    modal.selectVal = function (elm, isVal) {
        if (isVal) {
            return $("#" + elm).find('option:selected').val()
        }
        return $("#" + elm).find('option:selected').text()
    };
    modal.checkVal = function (elm, isClass) {
        var mark = isClass ? "." : "#";
        var checked = $(mark + elm).is(":checked") ? 1 : 0;
        return checked
    };
    modal.checkVals = function (elm, isStr) {
        var arr = [];
        $(elm).each(function () {
            var id = $(this).val();
            var checked = $(this).is(":checked");
            if (checked && id) {
                arr.push(id)
            }
        });
        if (isStr) {
            return arr.join(",")
        }
        return arr
    };
    return modal
});