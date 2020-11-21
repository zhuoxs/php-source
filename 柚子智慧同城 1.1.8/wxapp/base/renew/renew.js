/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = getApp();
t.Base({
    data: {
        showPage: 1,
        reChoose: 0,
        param: {
            cid: ""
        }
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData(a)
        }, "/base/apply/apply")
    },
    onLoadData: function(e) {
        var i = this;
        this.data.param.user_id = e.id, Promise.all([t.api.apiStoreGetMyStore({
            user_id: e.id
        }), t.api.apiStoreGetStoreRecharges()]).then(function(t) {
            var e;
            i.setData({
                imgRoot: t[0].other.img_root
            });
            for (var r in t[1].data) t[1].data[r].price = t[1].data[r].price - 0, t[1].data[r].price <= 0 && (t[1].data[r].price = 0), t[1].data[r].show_select = t[1].data[r].days + "天";
            i.setData((e = {
                shop: t[0].data,
                recharge: t[1].data
            }, a(e, "param.cid", t[1].data.length > 0 ? t[1].data[0].id : ""), a(e, "show", !0), e))
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    getRecharge: function(t) {
        var e = t.detail.value;
        this.setData(a({
            reChoose: e
        }, "param.cid", this.data.recharge[e].id))
    },
    onApplyTap: function() {
        var a = this,
            e = this;
        if (!this.data.ajax) {
            this.data.ajax = !0;
            var i = this.data.param;
            i.store_id = this.data.shop.id, i.user_id = this.data.user.id, t.api.apiStoreRenewalfeeStore(i).then(function(i) {
                i.data.paydata ? (a.setData({
                    payStamp: i.data.paydata
                }), a.wxpayAjax(i.data.paydata)) : (t.alert("续费成功！", function() {
                    e.reloadPrevious()
                }, 0), e.data.ajax = !1)
            }).
            catch (function(e) {
                "[ name ]字段唯一" == e.msg ? t.tips("该店铺名称已经存在，请重新输入店铺名称！") : t.tips(e.msg), a.data.ajax = !1
            })
        }
    },
    wxpayAjax: function() {
        var a = this.data.payStamp,
            e = this;
        wx.requestPayment({
            timeStamp: a.timeStamp,
            nonceStr: a.nonceStr,
            package: a.package,
            signType: a.signType,
            paySign: a.paySign,
            success: function(a) {
                setTimeout(function() {
                    t.alert("续费成功！", function() {
                        e.reloadPrevious()
                    }, 0), e.data.ajax = !1
                }, 1e3)
            },
            fail: function(a) {
                e.data.ajax = !1
            }
        })
    }
});