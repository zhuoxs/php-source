/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp(),
    i = require("../../../zhy/template/wxParse/wxParse.js");
t.Base({
    data: {
        flag: 0,
        popWin: !1,
        isChecked: !0,
        otype: [{
            img: "/plugin/resource/images/distribution/webchat.png",
            name: "微信"
        }],
        typeindex: 0,
        balance: 0
    },
    onLoad: function(t) {
        var i = this;
        this.checkLogin(function(t) {
            i.onLoadData(t), i.setData({
                show: !0,
                user: t
            })
        }, "/plugin/distribution/distributioncenter/distributioncenter")
    },
    onLoadData: function(a) {
        var e = this,
            n = this.data.balance;
        Promise.all([t.api.apiDistributionGetDistributionpromoterDetail({
            user_id: a.id
        }), t.api.apiDistributionGetDistributionset({})]).then(function(t) {
            n = (t[0].data.canwithdraw - 0 - (t[0].data.freezemoney - 0)).toFixed(2);
            var a = t[1].data.withdraw_notice;
            i.wxParse("detail", "html", a, e, 20), e.setData({
                setmoney: t[0].data,
                info: t[1].data,
                balance: n,
                withdrawFee: t[1].data.withdraw_fee - 0
            })
        }).
        catch (function(i) {
            t.tips(i.msg)
        })
    },
    formSubmit: function(i) {
        var a = this,
            e = i.detail.value.money;
        if (e <= 0) t.tips("提现金额不能为零");
        else if (0 != this.data.isChecked) {
            var n = {
                user_id: this.data.user.id,
                money: e,
                with_type: 1
            };
            t.api.apiDistributionSetWithDraw(n).then(function(i) {
                t.tips(i.data), a.setData({
                    omoney: ""
                })
            }).
            catch (function(i) {
                i.code, t.tips(i.msg)
            })
        } else t.tips("请先阅读并同意提现须知")
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