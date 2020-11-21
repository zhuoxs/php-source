/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t
}
var a = getApp();
a.Base({
    data: {
        navChoose: 0,
        sending: !1,
        reload: !1
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData()
        }, "/base/integralorder/integralorder")
    },
    onLoadData: function() {
        var t = this;
        t.setData({
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        });
        var i = {
            user_id: this.data.user.id,
            type: t.data.navChoose,
            page: this.data.list.page,
            length: this.data.list.length
        };
        a.api.apiIntegralOrderList(i).then(function(a) {
            t.setData({
                show: !0
            });
            for (var e in a.data) a.data[e].goodsinfo.cover = a.other.img_root + a.data[e].goodsinfo.cover;
            t.dealList(a.data, i.page)
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            navChoose: a,
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList()
    },
    loadList: function() {
        var i = this;
        if (!this.data.list.over) {
            this.setData(t({}, "list.load", !0));
            var e = {
                user_id: this.data.user.id,
                type: i.data.navChoose,
                page: i.data.list.page,
                length: i.data.list.length
            };
            a.api.apiIntegralOrderList(e).then(function(t) {
                for (var a in t.data) t.data[a].goodsinfo.cover = t.other.img_root + t.data[a].goodsinfo.cover;
                i.dealList(t.data, e.page)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadList()
    },
    onCancelTab: function(t) {
        var i = this,
            e = t.currentTarget.dataset.idx,
            n = {
                goods_id: i.data.list.data[e].goodsinfo.id,
                user_id: i.data.uInfo.id,
                oid: i.data.list.data[e].id
            };
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗！",
            success: function(t) {
                t.confirm ? a.api.apiIntegralCancelOrder(n).then(function(t) {
                    i.data.list.data.splice(e, 1), i.setData({
                        list: i.data.list
                    }), a.tips(t.msg)
                }).
                catch (function(t) {
                    a.tips(t.msg)
                }) : t.cancel
            }
        })
    },
    onCheckReceiveTab: function(t) {
        var i = this,
            e = t.currentTarget.dataset.idx,
            n = {
                goods_id: i.data.list.data[e].goodsinfo.id,
                user_id: i.data.user.id,
                oid: i.data.list.data[e].id
            };
        wx.showModal({
            title: "提示",
            content: "确定已经收到快递！",
            success: function(t) {
                t.confirm ? a.api.apiIntegralCheckGet(n).then(function(t) {
                    a.tips("收货成功！"), setTimeout(function() {
                        a.reTo("/cysc_sun/pages/public/pages/integralorder/integralorder")
                    }, 1e3)
                }).
                catch (function(t) {
                    a.tips(t.msg)
                }) : t.cancel
            }
        })
    },
    onDelectTab: function(t) {
        var i = this,
            e = t.currentTarget.dataset.idx,
            n = {
                goods_id: i.data.list.data[e].goodsinfo.id,
                user_id: i.data.user.id,
                oid: i.data.list.data[e].id
            };
        wx.showModal({
            title: "提示",
            content: "确定删除该订单记录！",
            success: function(t) {
                t.confirm ? a.api.apiIntegralDelOrd(n).then(function(t) {
                    a.tips("删除成功！"), setTimeout(function() {
                        a.reTo("/cysc_sun/pages/public/pages/integralorder/integralorder")
                    }, 1e3)
                }).
                catch (function(t) {
                    a.tips(t.msg)
                }) : t.cancel
            }
        })
    }
});