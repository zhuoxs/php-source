/*www.lanrenzhijia.com   time:2019-06-01 22:11:55*/
var t = getApp();
t.Base({
    data: {
        num: 1
    },
    onLoad: function(t) {
        var e = this;
        this.checkLogin(function(a) {
            e.setData({
                order_no: t.order_no,
                user: a
            }), e.onLoadData()
        }, "/base/reserveorderverification/reserveorderverification?id=" + t.order_no)
    },
    onLoadData: function() {
        var e = this;
        this.setData({
            show: !0
        });
        var a = {
            order_no: this.data.order_no,
            user_id: this.data.user.id,
            order_lid: 2
        };
        t.api.apiOrderGetOrderDetailByOrderNo(a).then(function(a) {
            var n = a.data.goods,
                i = new Date(n.end_time.replace(/-/g, "/")).getTime(),
                o = (new Date).getTime();
            if (i < o && t.alert("去首页逛逛", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "商品已过期"), new Date(n.expire_time.replace(/-/g, "/")).getTime() < o && t.alert("去首页逛逛", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "核销过期！"), a.data.num - a.data.write_off_num <= 0) e.setData({
                numRemain: 0
            }), t.tips("该商品已全部核销完毕！");
            else {
                var r = a.data.num - a.data.write_off_num;
                e.setData({
                    numRemain: r
                })
            }
            var d = 0;
            a.data.detail.forEach(function(t, e) {
                d += t.total_price - 0
            }), e.setData({
                order: a.data,
                img_root: a.other.img_root,
                countPrice: d.toFixed(2),
                show: !0
            })
        }).
        catch (function(e) {
            -1 == e.code ? t.alert("返回上一页", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0, "您没有审核权限") : t.tips(e.msg)
        })
    },
    addNum: function() {
        var e = this.data.num,
            a = this.data.order;
        if (e + 1 > a.num) return e = a.num, this.setData({
            num: e
        }), void t.tips("已达核销上限！");
        e++, this.setData({
            num: e
        })
    },
    reduceNum: function() {
        var e = this.data.num;
        if (1 == e) return t.tips("核销数量不能小于一"), void this.setData({
            num: 1
        });
        e -= 1, this.setData({
            num: e
        })
    },
    onVerificationTap: function() {
        var e = {
            type: 1,
            order_no: this.data.order.order_no,
            num: this.data.num,
            user_id: this.data.user.id
        };
        t.api.apiStoreConfirmAllOrder(e).then(function(e) {
            wx.showModal({
                title: "核销成功",
                content: "可返回上一页继续核销",
                cancelText: "返回首页",
                confirmText: "回上一页",
                success: function(e) {
                    e.cancel ? t.lunchTo("/pages/home/home") : wx.navigateBack({
                        delta: 1
                    })
                }
            })
        }).
        catch (function(e) {
            e.code, t.tips(e.msg)
        })
    },
    onTelTap: function() {
        var e = this.data.order.store.tel;
        t.phone(e)
    }
});