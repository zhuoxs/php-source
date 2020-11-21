define(['core', 'tpl'], function (core, tpl) {
    var modal = {};
    modal.init = function (params) {
        modal.params = params;
        modal.initClick();
        modal.initSign()
    };
    modal.initClick = function () {
        $("#signrule").unbind('click').click(function () {
            var html = $(".pop-rule-hidden").html();
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
    modal.initSign = function () {
        $("#btn-sign").unbind('click').click(function () {
            var _this = $(this);
            var doing = _this.data('doing');
            if (modal.params.signed) {
                //FoxUI.alert('您今天' + modal.params.textsigned + '过了~');
                return
            }
            if (doing) {
                FoxUI.alert('正在执行, 请稍等.');
                return
            }
            _this.data('doing', 1);
            modal.sign(_this, null)
        });
        if (modal.params.signold) {
            $(document).on('click', "#calendar .day", function () {
                var _this = $(this);
                var doing = _this.data('doing');
                var signed = _this.data('signed');
                var date = _this.data('date');
                var day = _this.data('day');
                var month = _this.data('month');
                var year = _this.data('year');

                if(modal.params.signold<1){
                    return;
                }

                if(!date || !day){
                    return
                }
                if (day >= modal.params.today || signed) {
                    return
                }
                if (year < modal.params.year || signed) {
                    return
                }
                if(month<modal.params.month){
                    return
                }

                if (doing) {
                    FoxUI.alert('正在执行, 请稍等.');
                    return
                }
                var text = "确定要" + modal.params.textsignold + "吗？";
                if (modal.params.signoldprice>0) {
                    text = modal.params.textsignold + "需扣除" + modal.params.signoldprice + modal.params.signoldtype + "，确定" + modal.params.textsignold + "吗？"
                }
                FoxUI.confirm(text, function () {
                    _this.data('doing', 1);
                    modal.sign(_this, date)
                })
            })
        }
        $(document).on('click', "#advaward .candraw", function () {
            var _this = $(this);
            var day = _this.data('day');
            var type = _this.data('type');
            var doing = _this.data('doing');
            if (doing) {
                FoxUI.alert('正在执行, 请稍等.');
                return
            }
            if (!type || !day) {
                modal.getAdvAward();
                return
            }
            _this.data('doing', 1);
            core.json('sign/doreward', {type: type, day: day}, function (ret) {
                var result = ret.result;
                FoxUI.confirm(result.message);
                _this.data('doing', 0);
                if (ret.status && result.addcredit) {
                    $("#credit").text(result.credit)
                }
                modal.getAdvAward()
            }, false, true)
        });
        $("#date").unbind('change').change(function () {
            modal.getCalendar()
        })
    };
    modal.sign = function (_this, date) {
        core.json('sign/dosign', {date: date}, function (ret) {
            var result = ret.result;
            setTimeout(function () {

                if (ret.status) {
                    if(result.lottery.is_changes==1){
                        var changes = result.lottery.lottery;
                        $('#changescontent').attr('onclick', 'window.location.href="'+ core.getUrl("lottery/lottery_info",[],true) +'&id=' + changes.lottery_id + '"');
                        taskget = new FoxUIModal({
                            content: $('#changesmodel').html(),
                            extraClass: 'picker-modal',
                            maskClick: function () {
                                taskget.close();
                            }
                        });
                        taskget.container.find('.changes-btn-close').click(function () {
                            taskget.close();
                            event.stopPropagation();
                        });
                        taskget.show();
                    }else{
                        FoxUI.alert(result.message);
                        $("#credit").text(result.credit)
                    }
                    _this.data('doing', 0);
                    if (!date) {
                        _this.text("今日" + modal.params.textsigned);
                        modal.params.signed = 1
                    }
                    if (result.addcredit) {
                        $("#credit").text(result.credit)
                    }
                    $("#signorder").text(result.signorder);
                    $("#signsum").text(result.signsum);
                    modal.setCalendar();
                    modal.getAdvAward()
                } else {
                    FoxUI.alert(result.message);
                    _this.data('doing', 0)
                }
            }, 500)
        }, false, true)
    };
    modal.getCalendar = function () {
        var url = core.getUrl('sign/getCalendar');
        var date = $("#date").find('option:selected').val();
        $.get(url, {date: date}, function (html) {
            if (html) {
                $("#calendar").html(html)
            }
        })
    };
    modal.getAdvAward = function () {
        var url = core.getUrl('sign/getAdvAward');
        $.get(url, null, function (html) {
            if (html) {
                $("#advaward").html(html)
            }
        })
    };
    modal.setCalendar = function () {
        var leng = $("#date").find('option').length;
        $('#date').get(0).selectedIndex = leng - 1;
        $("#date").trigger('change')
    };
    return modal
});