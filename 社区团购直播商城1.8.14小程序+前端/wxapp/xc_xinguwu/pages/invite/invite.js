var app = getApp();

Page({
    data: {
        style: 1,
        modal_cut_success: !1
    },
    onLoad: function(a) {
        var n = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), console.log(a), app.look.istrue(a.style) ? n.setData({
            style: a.style
        }) : n.setData({
            style: 1
        }), n.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "my_bargain_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data), 1 == t.data.bargain_self.status && n.countTime(t.data.bargain, t.data.bargain_self), 
                n.setData({
                    bargain: t.data.bargain,
                    bargain_self: t.data.bargain_self,
                    bargain_self_log: t.data.bargain_self_log
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this), app.look.accredit(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "my_bargain_detail",
                id: n.data.options.id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                console.log(t.data), 1 == t.data.bargain_self.status && n.countTime(t.data.bargain, t.data.bargain_self), 
                n.setData({
                    bargain: t.data.bargain,
                    bargain_self: t.data.bargain_self,
                    bargain_self_log: t.data.bargain_self_log
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var t = "你的朋友需要你的助攻", n = "";
        if (3 == this.data.bargain_self.status) return !1;
        var o = "", e = this.data.bargain;
        console.log(e), app.look.istrue(e.share.title) && (t = e.share.title), app.look.istrue(e.share.img) && (o = e.share.img);
        var i = this.data.bargain_self.id;
        return "button" == a.from ? (n = "../invite/invite?id=" + i + "&style=2", n = encodeURIComponent(n), 
        console.log(n), {
            title: t,
            path: "/xc_xinguwu/pages/base/base?share=" + n + "&userid=" + app.globalData.userInfo.id,
            imageUrl: o,
            success: function(a) {
                console.log(a), wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(a) {}
        }) : void 0;
    },
    modal_hide: function() {
        this.setData({
            modal_cut_success: !1
        });
    },
    bargain_help: function() {
        var n = this;
        wx.showLoading({
            title: "请求中"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "bargain_help",
                id: n.data.bargain_self.id
            },
            success: function(a) {
                wx.hideLoading();
                var t = a.data;
                n.setData({
                    bargain_self: t.data.bargain_self,
                    bargain_self_log: n.data.bargain_self_log.concat(t.data.bargain_self_log),
                    cut_price: t.data.bargain_self_log.cut_price,
                    modal_cut_success: !0
                });
            }
        });
    },
    joinSelf: function() {
        wx.redirectTo({
            url: "../bargain/bargain?pagestyle=1"
        });
    },
    toBuy: function() {
        if (3 != this.data.bargain_self.status) {
            var a = [];
            a.push({
                id: this.data.bargain.good_id,
                img: this.data.bargain.img,
                floor_price: this.data.bargain.floor_price,
                name: this.data.bargain.good_name,
                num: 1,
                price: this.data.bargain_self.new_price,
                attr_name: this.data.bargain.attr_name,
                weight: this.data.bargain.weight
            });
            var t = [];
            t = {
                content: a,
                totalPrice: this.data.bargain_self.new_price,
                totalNum: 1,
                cid: 4,
                bargain_self_id: this.data.bargain_self.id
            }, console.log(t), t = JSON.stringify(t), t = encodeURIComponent(t), wx.navigateTo({
                url: "../submit/submit?order=" + t
            });
        }
    },
    countTime: function(a, t) {
        var n = new app.util.date(), o = 60 * a.time_range, e = n.dateToLong(new Date(app.look.change_date(t.createtime)));
        e = parseInt((e - n.dateToLong(new Date())) / 1e3), e += o, console.log(e), this.countDown(e);
    },
    countDown: function(c) {
        var d = this;
        clearInterval(this.data.interval);
        var u = setInterval(function() {
            var a = c, t = Math.floor(a / 3600 / 24), n = t.toString();
            1 == n.length && (n = "0" + n);
            var o = Math.floor((a - 3600 * t * 24) / 3600), e = o.toString();
            1 == e.length && (e = "0" + e);
            var i = Math.floor(a / 3600).toString();
            1 == i.length && (i = "0" + i);
            var s = Math.floor((a - 3600 * t * 24 - 3600 * o) / 60), r = s.toString();
            1 == r.length && (r = "0" + r);
            var l = (a - 3600 * t * 24 - 3600 * o - 60 * s).toString();
            if (1 == l.length && (l = "0" + l), d.setData({
                countHour: i,
                countDownDay: n,
                countDownHour: e,
                countDownMinute: r,
                countDownSecond: l
            }), --c < 0) {
                clearInterval(u), wx.showToast({
                    title: "活动已结束",
                    icon: "none"
                });
                var g = d.data.bargain_self;
                g.status = 3, d.setData({
                    bargain_self: g,
                    countHour: "00",
                    countDownDay: "00",
                    countDownHour: "00",
                    countDownMinute: "00",
                    countDownSecond: "00"
                });
            }
        }.bind(d), 1e3);
        d.setData({
            interval: u
        });
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    }
});