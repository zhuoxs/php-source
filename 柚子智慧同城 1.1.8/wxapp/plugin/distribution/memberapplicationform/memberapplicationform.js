/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp(),
    a = require("../../../zhy/template/wxParse/wxParse.js");
t.Base({
    data: {
        isChecked: !0
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData(a)
        }, "/base/memberapplicationform/memberapplicationform")
    },
    onLoadData: function(i) {
        this.setData({
            show: !0
        });
        var e = this,
            s = {
                user_id: i.id
            };
        Promise.all([t.api.apiDistributionGetDistributionset(), t.api.apiDistributionIsDistributionpromoter(s)]).then(function(t) {
            var i = t[0].data.application;
            a.wxParse("detail", "html", i, e, 20), e.setData({
                info: t[1].data,
                mes: t[0].data,
                img_root: t[0].other.img_root
            })
        }).
        catch (function(a) {
            e.setData({
                ajax: !1
            }), a.code, t.tips(a.msg)
        })
    },
    application: function(a) {
        var i = this,
            e = i.data.phone || a.detail.value.phone.replace(/\s+/g, "");
        if (/^1(3|4|5|7|8|9)\d{9}$/.test(e)) {
            var s = a.detail.value.name;
            if (s || t.tips("请输入您的姓名！"), 0 != this.data.isChecked) {
                var o = {
                    user_id: i.data.user.id,
                    type: 2,
                    name: s,
                    phone: e,
                    form_id: a.detail.formId
                };
                i.data.ajax || (i.setData({
                    ajax: !0
                }), t.api.apiDistributionSetDistributionpromoter(o).then(function(t) {
                    i.setData({
                        info: t.data
                    })
                }).
                catch (function(a) {
                    i.setData({
                        ajax: !1
                    }), a.code, t.tips(a.msg)
                }))
            } else t.tips("请先阅读并同意提现须知")
        } else t.tips("请输入正确的手机号码！")
    },
    checkWarm: function() {
        this.setData({
            popWin: !0
        })
    },
    agree: function() {
        this.setData({
            isChecked: !0,
            popWin: !1
        })
    },
    checkChange: function() {
        console.log(this.data.isChecked), this.setData({
            isChecked: !this.data.isChecked
        })
    }
});