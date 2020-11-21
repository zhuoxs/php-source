var common = require("../../common/common.js"), app = getApp();

function sign(a) {
    var t = a.data.username, n = a.data.bank, e = a.data.amount, o = "";
    "" == t || null == t ? o = "请输入账户" : "" != n && null != n || 2 != a.data.curr ? "" == e || null == e || isNaN(e) || 0 == parseFloat(e) ? o = "请输入提现金额" : parseFloat(e) > parseFloat(a.data.xc.userinfo.store_amount) && 1 == a.data.admin ? o = "余额不足" : parseFloat(e) > parseFloat(a.data.xc.userinfo.fen_amount) && 2 == a.data.admin && (o = "余额不足") : o = "请输入开户行", 
    "" != o ? wx.showModal({
        title: "内容不符合要求",
        content: o,
        showCancel: !1
    }) : a.setData({
        submit: !0
    });
}

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        submit: !1,
        canload: !0
    },
    tab: function(a) {
        var t = a.currentTarget.dataset.index;
        this.data.curr != t && this.setData({
            curr: t
        });
    },
    input: function(a) {
        var t = this, n = a.currentTarget.dataset.name, e = a.detail.value;
        switch (n) {
          case "username":
            t.setData({
                username: e
            });
            break;

          case "bank":
            t.setData({
                bank: e
            });
            break;

          case "amount":
            t.setData({
                amount: e
            });
        }
    },
    submit: function() {
        var a = this;
        if (sign(a), a.data.submit && a.data.canload) {
            a.setData({
                canload: !1
            });
            var t = {
                type: a.data.curr,
                username: a.data.username,
                name: a.data.xc.apply.coname,
                amount: a.data.amount,
                admin: a.data.admin
            };
            2 == a.data.curr && (t.bank = a.data.bank), app.util.request({
                url: "entry/wxapp/withdraw",
                method: "POST",
                data: t,
                success: function(a) {
                    "" != a.data.data && (wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 2e3));
                }
            });
        }
    },
    onLoad: function(a) {
        var n = this;
        n.setData({
            admin: a.admin
        }), 1 == n.data.admin ? common.config(n, "admin2") : 2 == n.data.admin && common.config(n, "admin3");
        var t = {
            op: "store"
        };
        "" != n.data.admin && null != n.data.admin && 2 == n.data.admin && (t.admin = 2), 
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data && n.setData({
                    xc: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});