var app = getApp();

Page({
    data: {
        page: 1,
        limit: 10,
        olist: [],
        status: !0
    },
    onLoad: function(a) {
        this.setData({
            leader_id: a.leader_id
        });
        var t = wx.getStorageSync("userInfo");
        t ? this.setData({
            user_id: t.id
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/zkx/pages/headcenter/headcenter");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function(a) {
        this.loadDate();
    },
    loadDate: function() {
        var s = this, i = s.data.olist, d = s.data.limit, o = s.data.page;
        app.ajax({
            url: "Cleader|getMyUsers",
            data: {
                leader_id: s.data.leader_id,
                page: o,
                limit: d
            },
            success: function(a) {
                console.log(a);
                var t = !(a.data.length < d);
                if (1 == o) i = a.data; else for (var e in a.data) i.push(a.data[e]);
                o += 1, s.setData({
                    olist: i,
                    show: !0,
                    hasMore: t,
                    page: o,
                    imgroot: a.other.img_root
                });
            }
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadDate() : wx.showToast({
            title: "没有更多核销人员啦~",
            icon: "none"
        });
    },
    deleteMember: function(a) {
        var t = this, e = a.currentTarget.dataset.leaderuserid;
        t.setData({
            status: !0
        }), app.ajax({
            url: "Cleader|deleteUser",
            data: {
                leaderuser_id: e
            },
            success: function(a) {
                app.tips(a.data), t.setData({
                    page: 1
                }), t.loadDate();
            }
        });
    },
    addMember: function(a) {
        var t = this, e = a.currentTarget.dataset.memid;
        t.setData({
            status: !0
        }), app.ajax({
            url: "Cleader|addUser",
            data: {
                leader_id: t.data.leader_id,
                user_id: e
            },
            success: function(a) {
                app.tips(a.data), t.setData({
                    page: 1
                }), t.loadDate();
            }
        });
    },
    searchBtn: function(a) {
        var t = this, e = (t.data.olist, a.detail.value);
        "" != (e = e.trim()) && (app.ajax({
            url: "Cleader|getUsers",
            data: {
                key: e
            },
            success: function(a) {
                if (0 == a.data.length) return app.tips("查无此人"), t.setData({
                    olist: []
                }), !1;
                t.setData({
                    olist: a.data
                });
            }
        }), t.setData({
            value: e,
            status: !1
        }));
    },
    formSubmit: function(a) {
        var t = this, e = (t.data.olist, a.detail.value.vmvalue);
        "" != (e = e.trim()) && (app.ajax({
            url: "Cleader|getUsers",
            data: {
                key: e
            },
            success: function(a) {
                if (0 == a.data.length) return app.tips("查无此人"), t.setData({
                    olist: []
                }), !1;
                t.setData({
                    olist: a.data
                });
            }
        }), t.setData({
            value: e,
            status: !1
        }));
    }
});