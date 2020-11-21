function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

function getTimeStr(e) {
    return e = (e = e.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(e[0], e[1] - 1, e[2], e[3], e[4], e[5]).getTime() / 1e3;
}

Page({
    data: {
        downTime: 0,
        ajax: !1
    },
    onLoad: function(e) {
        var n = e.id.split("-"), a = wx.getStorageSync("linkaddress"), o = this;
        this.setData({
            param: {
                heads_id: n[0],
                goods_id: n[1],
                linkaddress: a
            }
        }), n[2] && wx.setStorageSync("share_user_id", n[2]);
        var t = wx.getStorageSync("userInfo");
        wx.setStorageSync("share_leader_id", n[3]), n[3] && n[3] != a.id && n[2] != t.id && wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var a = e.latitude, t = e.longitude;
                console.log({
                    longitude: t,
                    latitude: a,
                    leader_id: n[3]
                }), app.ajax({
                    url: "Cleader|getLeader",
                    data: {
                        longitude: t,
                        latitude: a,
                        leader_id: n[3]
                    },
                    success: function(a) {
                        console.log(a), wx.showModal({
                            title: "提示",
                            content: a.data.community + "小区的" + a.data.name + "团长距离您" + a.data.distance / 1e3 + "Km",
                            success: function(e) {
                                e.confirm ? (wx.setStorageSync("linkaddress", a.data), o.onLoadData()) : e.cancel && (console.log("用户点击取消"), 
                                app.lunchTo("/sqtg_sun/pages/home/index/index"));
                            }
                        });
                    }
                });
            },
            fail: function(e) {
                console.log("获取地址失败"), newleader_id || oldleader_id ? that.setData({
                    popAllow: !0
                }) : app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        }), this.onLoadData();
    },
    onUnload: function() {
        clearInterval(this.timer);
    },
    onLoadData: function() {
        var o = this, n = this, e = wx.getStorageSync("userInfo"), a = (wx.getStorageSync("linkaddress"), 
        wx.getStorageSync("share_leader_id"));
        e ? (this.setData({
            uInfo: e
        }), this.data.param.user_id = e.id, this.data.param.leader_id = a, app.api.getCpinJoinPage(this.data.param).then(function(e) {
            console.log(e);
            var a = new Date().getTime() / 1e3 - getTimeStr(e.data.headinfo.create_time), t = 3600 * (e.data.goodsinfo.group_time - 0), n = 0;
            0 < t - a - 10 && (n = t - a), o.setData({
                downTime: n
            }), clearInterval(o.timer), 0 != e.data.btn_status && 1 != e.data.btn_status || (o.timer = setInterval(function() {
                o.setData({
                    downTime: n
                }), --n <= 0 && (o.setData(_defineProperty({}, "info.btn_status", 3)), clearInterval(o.timer));
            }, 1e3)), o.setData({
                info: e.data,
                imgRoot: e.other.img_root,
                show: !0
            });
        }).catch(function(e) {
            -1 == e.code ? "该团过期" == e.msg ? wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : app.tips(e.msg) : -2 == e.code && "您的团长没有该商品" == e.msg ? wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            }) : app.tips(e.msg), setTimeout(function() {
                app.lunchTo("/sqtg_sun/pages/home/index/index");
            }, 3e3);
        })) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var a = n.data.param.heads_id + "-" + n.data.param.goods_id, t = encodeURIComponent("/sqtg_sun/pages/plugin/spell/join/join?id=" + a);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onBtnTab: function() {
        if (0 == this.data.info.btn_status) {
            var e = this.data.param.goods_id + "-" + this.data.param.heads_id;
            app.reTo("/sqtg_sun/pages/plugin/spell/info/info?id=" + e);
        } else {
            var a = this.data.param.goods_id + "-0";
            app.reTo("/sqtg_sun/pages/plugin/spell/info/info?id=" + a);
        }
    },
    onInfoTab: function() {
        var e = this.data.param.goods_id + "-0";
        app.reTo("/sqtg_sun/pages/plugin/spell/info/info?id=" + e);
    },
    onShareAppMessage: function() {
        var e = wx.getStorageSync("userInfo"), a = (wx.getStorageSync("linkaddress"), wx.getStorageSync("share_leader_id")), t = this.data.param.heads_id + "-" + this.data.param.goods_id + "-" + e.id + "-" + a;
        return console.log(t), {
            title: e.name + "邀请您参加“" + this.data.info.goodsinfo.name + "”的拼团活动",
            path: "/sqtg_sun/pages/plugin/spell/join/join?id=" + t
        };
    },
    goHome: function() {
        app.lunchTo("/sqtg_sun/pages/home/index/index");
    }
});