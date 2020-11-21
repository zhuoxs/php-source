/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "全部",
            status: 0
        }, {
            title: "审核中",
            status: 1
        }, {
            title: "已通过",
            status: 2
        }, {
            title: "已拒绝",
            status: 3
        }],
        curHdIndex: 0,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user_id: a.id,
                page: 1
            }), t.onLoadData(a)
        }, "/base/myrelease/myrelease")
    },
    onLoadData: function() {
        var a = this,
            e = a.data.olist,
            n = a.data.length,
            o = a.data.page,
            i = {
                user_id: a.data.user_id,
                page: o,
                length: n,
                type: a.data.curHdIndex
            };
        t.api.apiInfoGetMyInfo(i).then(function(t) {
            var i = !(t.data.length < n);
            if (t.data.length < n && a.setData({
                nomore: !0,
                show: !0
            }), 1 == o) e = t.data;
            else for (var s in t.data) e.push(t.data[s]);
            o += 1, a.setData({
                olist: e,
                show: !0,
                hasMore: i,
                page: o,
                img_root: t.other.img_root
            })
        }).
        catch (function(a) {
            a.code, t.tips(a.msg)
        })
    },
    swichNav: function(t) {
        var a = this,
            e = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: e,
            page: 1
        }), this.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    },
    onPreviewTap: function(t) {
        for (var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.oindex, n = this.data.olist[e].pics, o = this.data.img_root, i = 0; i < n.length; i++) n[i] = o + n[i];
        wx.previewImage({
            current: n[a],
            urls: n
        })
    },
    onLikeTap: function(a) {
        var e = this,
            n = a.currentTarget.dataset.id;
        t.api.apiInfoSetLike({
            user_id: this.data.user_id,
            id: n
        }).then(function(t) {
            e.setData({
                page: 1
            }), e.onLoadData()
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    onDeleteTap: function(a) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确定删除该帖子？",
            success: function(n) {
                if (n.confirm) {
                    var o = {
                        user_id: e.data.user_id,
                        info_id: a.currentTarget.dataset.id
                    };
                    t.api.apiInfoDelInfo(o).then(function(a) {
                        t.tips("删除成功！"), e.setData({
                            page: 1
                        }), e.onLoadData()
                    }).
                    catch (function(a) {
                        t.tips(a.msg)
                    })
                }
            }
        })
    },
    toInfoTap: function(a) {
        t.navTo("/base/circledetail/circledetail?id=" + a.currentTarget.dataset.id)
    },
    cancelOrder: function(a) {
        var e = this,
            n = a.currentTarget.dataset.index,
            o = e.data.olist;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(a) {
                a.confirm && t.ajax({
                    url: "Corder|cancelOrder",
                    data: {
                        order_id: o[n].id
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功"
                        }), o.splice(n, 1), e.setData({
                            olist: o
                        })
                    }
                })
            }
        })
    },
    payNow: function(a) {
        var e = this,
            n = a.currentTarget.dataset.index;
        t.ajax({
            url: "Corder|payOrder",
            data: {
                order_id: e.data.olist[n].id
            },
            success: function(a) {
                a.other.paydata && wx.requestPayment({
                    timeStamp: a.other.paydata.timeStamp,
                    nonceStr: a.other.paydata.nonceStr,
                    package: a.other.paydata.package,
                    signType: a.other.paydata.signType,
                    paySign: a.other.paydata.paySign,
                    success: function(a) {
                        t.reTo("/sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess")
                    }
                })
            },
            complete: function() {
                e.setData({
                    isRequest: 0
                })
            }
        })
    },
    onOrderinfoTap: function(a) {
        t.navTo("/base/goodsorderinfo/goodsorderinfo?id=" + a.currentTarget.dataset.id)
    }
});