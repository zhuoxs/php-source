var app = getApp();

Page({
    data: {
        navTile: "亲子活动",
        operation: [],
        list: [],
        curPage: 1,
        pagesize: 5,
        searchCont: ""
    },
    onLoad: function(i) {
        var o = this;
        o.setData({
            typeid: i.tid
        }), app.get_imgroot().then(function(t) {
            o.setData({
                imgroot: t
            });
        });
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.util.request({
            url: "entry/wxapp/getActivityCategory",
            cachetime: "10",
            success: function(t) {
                console.log(t.data);
                var a = "";
                for (var e in t.data) if (i.tid == t.data[e].id) {
                    a = t.data[e].title;
                    break;
                }
                wx.setNavigationBarTitle({
                    title: a
                }), o.setData({
                    operation: t.data,
                    title: a
                });
            }
        }), o.get_active_list();
    },
    get_active_list: function() {
        var i = this, t = i.data.typeid, o = i.data.curPage, n = i.data.list;
        app.util.request({
            url: "entry/wxapp/getActivity",
            cachetime: "0",
            data: {
                tid: t,
                page: o,
                pagesize: i.data.pagesize,
                title: i.data.searchCont
            },
            success: function(t) {
                console.log(t.data);
                var a = t.data.length == i.data.pagesize;
                if (1 == o) n = t.data, o += 1; else for (var e in t.data) n.push(t.data[e]);
                i.setData({
                    list: n,
                    curPage: o,
                    hasMore: a
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? (t.get_active_list(), t.setData({
            curPage: t.data.curPage++
        })) : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    chooseActive: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.title;
        this.setData({
            typeid: a,
            curPage: 1,
            searchCont: "",
            hasMore: !0,
            title: e
        }), wx.setNavigationBarTitle({
            title: e
        }), this.get_active_list();
    },
    toParentingDet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../parentingdet/parentingdet?id=" + a
        });
    },
    formSubmit: function(t) {
        var a = t.detail.value.searchText;
        this.seachFun(a);
    },
    toSearch: function(t) {
        var a = t.detail.value;
        console.log(a), this.seachFun(a);
    },
    seachFun: function(t) {
        "" != t ? (this.setData({
            searchCont: t,
            curPage: 1,
            hasMore: !0,
            typeid: 0
        }), this.get_active_list()) : wx.showToast({
            title: "搜索关键词不得微空",
            icon: "none",
            duration: 2500
        });
    }
});