var t = getApp(), e = t.requirejs("core"), a = t.requirejs("foxui");

Page({
    data: {
        list: [],
        indicatorDots: !1,
        autoplay: !1,
        current: 0,
        modal: !1
    },
    onLoad: function(e) {
        var a = this, i = {
            cate: e.cate
        };
        t.getCache("isIpx") ? a.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : a.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), a.setData({
            options: e
        }), e.id && (i.id = e.id, i.page = e.page, a.setData({
            id: e.id
        })), a.getlist(i);
    },
    swiperchange: function(t) {
        this.setData({
            current: t.detail.current
        });
    },
    getlist: function(t) {
        var a = this;
        e.get("membercard.detail", t, function(e) {
            if (0 == e.error) {
                if (t.id) for (var i in e.list) t.id == e.list[i].id && a.setData({
                    current: i
                });
                a.setData({
                    list: e.list
                });
            }
        });
    },
    submit: function(t) {
        var i = t.currentTarget.dataset, r = this;
        console.error(i), -1 != i.startbuy && ("0" != i.stock ? e.post("membercard.order.create_order", {
            id: i.id
        }, function(t) {
            0 == t.error ? wx.navigateTo({
                url: "/pages/member/membercard/pay/index?order_id=" + t.order.order_id
            }) : a.toast(r, t.message);
        }) : a.toast(r, "库存不足"));
    },
    coupon: function(t) {
        var i = this, r = t.currentTarget.dataset, o = i.data.current, s = i.data.list, n = i.data.options, d = {
            cate: n.cate
        }, c = {
            id: r.id,
            couponid: r.couponid
        };
        r.issend || (n.id && (d.id = n.id), e.post("membercard.get_month_coupon", c, function(t) {
            if (0 == t.error) {
                a.toast(i, "领取成功");
                for (var e in s[o].month_coupon) r.couponid == s[o].month_coupon[e].id && (s[o].month_coupon[e].isget_month_coupon = !0, 
                i.setData({
                    list: s
                }));
            } else a.toast(i, t.message);
        }));
    },
    credit: function(t) {
        var i = this, r = t.currentTarget.dataset, o = i.data.list, s = i.data.current, n = (i.data.options.cate, 
        {
            id: r.id
        });
        r.iscredit || e.post("membercard.get_month_point", n, function(t) {
            0 == t.error ? (a.toast(i, "领取成功"), o[s].isget_month_point = 1, i.setData({
                list: o
            })) : a.toast(i, t.message);
        });
    }
});