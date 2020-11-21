var t = getApp(), i = t.requirejs("/core"), a = t.requirejs("foxui");

t.requirejs("jquery");

Page({
    data: {
        activity_setting: {},
        shareid: "",
        id: "",
        share_id: "",
        time: [ "00", "00", "00", "00" ],
        listlength: !1,
        pindex: 6
    },
    onLoad: function(i) {
        t.url(i);
        var a = this;
        i.share_id && a.setData({
            share_id: i.share_id
        }), i.id && a.setData({
            id: i.id
        }), a.getList();
    },
    getCoupon: function(e) {
        var r = this;
        if (!r.data.isGet) {
            var s = {
                id: r.data.id,
                share_id: r.data.share_id,
                form_id: e.detail.formId
            };
            r.data.isLogin ? (r.setData({
                isGet: !0
            }), i.get("friendcoupon/receive", s, function(t) {
                0 == t.error ? (a.toast(r, "领取成功"), r.getList(), r.setData({
                    isGet: !1
                })) : r.setData({
                    invalidMessage: t.message.replace("<br>", "\n"),
                    isGet: !1
                });
            })) : t.checkAuth();
        }
    },
    carve: function(e) {
        var r = this, s = {
            id: r.data.id,
            share_id: r.data.share_id,
            form_id: e.detail.formId
        };
        r.data.isLogin ? i.get("friendcoupon/divide", s, function(t) {
            t.error, a.toast(r, t.message), r.getList();
        }) : t.checkAuth();
    },
    mycoupon: function() {
        this.setData({
            id: this.data.data.currentActivityInfo.activity_id,
            share_id: this.data.data.currentActivityInfo.headerid
        }), this.getList();
    },
    onShareAppMessage: function(t) {
        var a = this, e = a.data.data.activitySetting.title, r = "/friendcoupon/index?share_id=" + a.data.shareid + "&id=" + a.data.id;
        return i.onShareAppMessage(r, e);
    },
    more: function() {
        var t = this, e = t.data.activityList;
        i.get("friendcoupon/more", {
            id: t.data.id,
            share_id: t.data.shareid,
            pindex: t.data.pindex
        }, function(i) {
            0 === i.result.list.length ? a.toast(t, "没有更多了") : t.setData({
                activityList: e.concat(i.result.list),
                pindex: t.data.pindex + 10
            });
        });
    },
    getList: function() {
        var t = this;
        i.get("friendcoupon", {
            id: t.data.id,
            share_id: t.data.share_id
        }, function(e) {
            if (0 == e.error) {
                if (e.currentActivityInfo && (e.currentActivityInfo.enough = Number(e.currentActivityInfo.enough)), 
                "string" == typeof e.activitySetting.desc && t.setData({
                    isArray: !0
                }), t.setData({
                    activityData: e.activityData,
                    activityList: e.activityData.length > 5 ? e.activityData.slice(0, 5) : e.activityData,
                    data: e,
                    isLogin: e.isLogin,
                    mylink: e.mylink,
                    invalidMessage: e.invalidMessage,
                    shareid: e.currentActivityInfo ? e.currentActivityInfo.headerid : ""
                }), +e.overTime + 3 > Math.round(+new Date() / 1e3)) var r = setInterval(function() {
                    t.setData({
                        time: i.countDown(+e.overTime + 3)
                    }), t.data.time || (clearInterval(r), t.getList());
                }, 1e3);
            } else a.toast(t, e.message);
        });
    }
});