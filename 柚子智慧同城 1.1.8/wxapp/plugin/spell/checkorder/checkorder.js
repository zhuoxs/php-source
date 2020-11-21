/*www.lanrenzhijia.com   time:2019-06-01 22:11:50*/
var t = getApp();
Page({
    data: {
        downTime: 0,
        payType: [{
            name: "微信支付",
            pic: "../../../../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../../../../zhy/resource/images/local.png"
        }],
        curPay: 1,
        alert: !1,
        ajax: !1
    },
    onLoad: function(t) {
        this.setData({
            id: t.id,
            store_id: t.store_id
        }), this.onLoadData()
    },
    onLoadData: function() {
        var e = this,
            i = this,
            a = wx.getStorageSync("userInfo");
        if (a) {
            this.setData({
                uInfo: a
            });
            var n = {
                order_num: this.data.id,
                store_id: this.data.store_id
            };
            t.api.getCpinOrdernumFind(n).then(function(t) {
                e.data.store_id == t.data.info.store_id ? e.setData({
                    info: t.data,
                    imgRoot: t.other.img_root,
                    show: !0
                }) : wx.showModal({
                    title: "提示",
                    content: "不是本店商品！",
                    showCancel: !1,
                    success: function(t) {
                        wx.navigateBack({
                            delta: 1
                        })
                    }
                })
            }).
            catch (function(e) {
                e.code, t.tips(e.msg)
            })
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var a = encodeURIComponent("/cysc_sun/pages/plugin/spell/checkorder/checkorder?id=" + i.data.id);
                    clearInterval(this.timer), t.reTo("/cysc_sun/pages/home/login/login?id=" + a)
                } else e.cancel && (clearInterval(this.timer), t.lunchTo("/cysc_sun/pages/home/index/index"))
            }
        })
    },
    onBtnTab: function() {
        var e = this;
        wx.getStorageSync("userInfo");
        wx.showModal({
            title: "提示",
            content: "确定核销该订单？",
            success: function(i) {
                i.confirm && t.api.getCpinUseOrd({
                    oid: e.data.info.info.id,
                    user_id: e.data.info.info.user_id,
                    store_id: e.data.store_id
                }).then(function(e) {
                    t.tips("核销成功"), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        })
                    }, 1e3)
                }).
                catch (function(e) {
                    e.code, t.tips(e.msg)
                })
            }
        })
    }
});