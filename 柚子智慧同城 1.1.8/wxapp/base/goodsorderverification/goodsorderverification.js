/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        num: 1
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(e) {
            a.setData({
                order_no: t.order_no,
                user: e
            }), a.onLoadData()
        }, "/base/goodsorderinfo/goodsorderinfo?id=" + t.order_no)
    },
    onLoadData: function() {
        var a = this;
        this.setData({
            show: !0
        });
        var e = {
            order_no: this.data.order_no,
            user_id: this.data.user.id
        };
        t.api.apiOrderGetOrderDetailByOrderNo(e).then(function(e) {
            var o = e.data.goods,
                n = new Date(o.end_time.replace(/-/g, "/")).getTime(),
                i = (new Date).getTime();
            if (n < i && t.alert("去首页逛逛", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "商品已过期"), new Date(o.expire_time.replace(/-/g, "/")).getTime() < i && t.alert("去首页逛逛", function() {
                t.lunchTo("/pages/home/home")
            }, 0, "核销过期！"), e.data.num - e.data.write_off_num <= 0) a.setData({
                numRemain: 0
            }), t.tips("该商品已全部核销完毕！");
            else {
                var r = e.data.num - e.data.write_off_num;
                a.setData({
                    numRemain: r
                })
            }
            var d = 0;
            e.data.detail.forEach(function(t, a) {
                d += t.total_price - 0
            }), a.setData({
                order: e.data,
                img_root: e.other.img_root,
                countPrice: d.toFixed(2),
                show: !0
            })
        }).
        catch (function(a) {
            -1 == a.code ? t.alert("返回上一页", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 0, "您没有审核权限") : t.tips(a.msg)
        })
    },
    addNum: function() {
        var a = this.data.num,
            e = this.data.order;
        if (a + 1 > e.num) return a = e.num, this.setData({
            num: a
        }), void t.tips("已达核销上限！");
        a++, this.setData({
            num: a
        })
    },
    reduceNum: function() {
        var a = this.data.num;
        if (1 == a) return t.tips("核销数量不能小于一"), void this.setData({
            num: 1
        });
        a -= 1, this.setData({
            num: a
        })
    },
    onVerificationTap: function() {
        var a = {
            type: 1,
            order_no: this.data.order.order_no,
            num: this.data.num,
            user_id: this.data.user.id
        };
        t.api.apiStoreConfirmAllOrder(a).then(function(a) {
            wx.showModal({
                title: "核销成功",
                content: "可返回上一页继续核销",
                cancelText: "返回首页",
                confirmText: "回上一页",
                success: function(a) {
                    a.cancel ? t.lunchTo("/pages/home/home") : wx.navigateBack({
                        delta: 1
                    })
                }
            })
        }).
        catch (function(a) {
            a.code, t.tips(a.msg)
        })
    },
    onTelTap: function() {
        var a = this.data.order.store.tel;
        t.phone(a)
    }
});