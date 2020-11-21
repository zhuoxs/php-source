var timer, app = getApp();

Component({
    properties: {
        modalHidden: {
            type: Boolean,
            value: !1,
            observer: function(e, o, t) {}
        },
        orderType: {
            type: Number,
            value: 0
        },
        Goodsid: {
            type: Number,
            value: 0
        }
    },
    data: {
        neworder: [],
        bgcolor: "#000000",
        fontcolor: "#fffb00"
    },
    methods: {
        getorder: function() {
            var t = this, e = t.data.orderType, o = t.data.Goodsid;
            app.util.request({
                url: "entry/wxapp/GetNewOrder",
                data: {
                    ordertype: e,
                    gid: o
                },
                showLoading: !1,
                success: function(e) {
                    console.log("获取订单数据"), console.log(e);
                    var o = e.data;
                    2 == o ? t.setData({
                        neworder: []
                    }) : (t.setData({
                        neworder: o.orderlist,
                        bgcolor: o.bgcolor,
                        fontcolor: o.fontcolor
                    }), t.gotofly(t, 0));
                }
            });
        },
        gotofly: function(e, o) {
            var t = e.data.neworder.length;
            o < t && 0 <= o || (o = 0), console.log(o), this.slideupshow(e, 2e3, o, 80, 1), 
            app.globalData.timer_slideupshoworder = setTimeout(function() {
                this.slideupshow(e, 0, o, -80, 0);
            }.bind(this), 5e3);
        },
        slideupshow: function(e, o, t, r, a) {
            var i = e.data.neworder, n = wx.createAnimation({
                duration: o,
                timingFunction: "ease"
            });
            n.translateY(r).opacity(a).step(), i[t].neworderfly = n.export(), e.setData({
                neworder: i
            }), 0 == a && (t++, console.log(t), e.gotofly(e, t));
        }
    },
    lifetimes: {
        ready: function() {
            this.getorder();
        }
    },
    ready: function() {
        this.getorder();
    },
    pageLifetimes: {
        hide: function() {
            clearTimeout(app.globalData.timer_slideupshoworder);
        }
    }
});