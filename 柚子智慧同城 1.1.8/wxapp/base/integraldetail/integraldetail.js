/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function a(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a
}
var t = require("../../zhy/template/wxParse/wxParse.js"),
    i = getApp();
i.Base({
    data: {
        alert: !1,
        canBuy: 1,
        reload: !1
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(i) {
            t.setData({
                user: i,
                id: a.id,
                param: {
                    num: 1,
                    goods_id: a.id
                }
            }), t.onLoadData()
        }, "/pages/integraldetail/integraldetail?id=" + a.id)
    },
    onShow: function() {},
    onLoadData: function() {
        var a = this;
        i.api.apiIntegralGoodsDetails({
            id: a.data.id,
            user_id: this.data.user.id
        }).then(function(i) {
            for (var e in i.data.pics) i.data.pics[e] = i.other.img_root + i.data.pics[e];
            i.data.cover = i.other.img_root + i.data.cover, t.wxParse("content", "html", i.data.details, a, 0), a.setData({
                info: i.data,
                show: !0
            })
        }).
        catch (function(a) {
            i.tips(a.msg)
        })
    },
    onOrderTab: function() {
        var a = this;
        i.api.apiUserMyInfo({
            user_id: this.data.user.id
        }).then(function(t) {
            a.setData({
                userinfo: t.data
            });
            var e = t.data.userinfo.now_integral - 0,
                n = a.data.info.intergral - 0,
                o = (a.data.info.limit_buy, a.data.info.my_buy_num, a.data.info.num - 0),
                r = Math.floor(e / n).toFixed(0),
                s = a.data.info.limit_buy - a.data.info.my_buy_num;
            o <= 0 ? i.tips("库存不足！") : r > 0 ? (a.data.info.limit_buy > 0 ? o <= r && o <= s ? a.setData({
                canBuy: o
            }) : r <= o && r <= s ? a.setData({
                canBuy: r
            }) : s <= o && s <= r && a.setData({
                canBuy: s
            }) : o <= r ? a.setData({
                canBuy: o
            }) : a.setData({
                canBuy: r
            }), a.toggleMask()) : i.tips("您剩余" + e + "积分，不足购买本商品！")
        }).
        catch (function(a) {
            i.tips(a.msg)
        })
    },
    checkOrder: function() {
        var a = JSON.stringify(this.data.param);
        i.navTo("/base/integralorder2/integralorder?id=" + a), this.toggleMask()
    },
    toggleMask: function() {
        this.setData({
            alert: !this.data.alert
        })
    },
    getNum: function(t) {
        this.setData(a({}, "param.num", t.detail))
    }
});