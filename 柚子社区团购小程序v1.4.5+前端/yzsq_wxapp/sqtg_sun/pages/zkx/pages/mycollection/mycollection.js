var app = getApp();

Page({
    data: {
        padding: !1,
        page: 1,
        limit: 10,
        tab1: "商品",
        tab2: "商家",
        tab3: "话题",
        activeIndex: 0
    },
    swichNav: function(t) {
        this.setData({
            activeIndex: t.currentTarget.dataset.index
        }), this.getList(), wx.pageScrollTo({
            scrollTop: 0,
            duration: 400
        });
    },
    onLoad: function(t) {
        this.getList(), this.pageCount();
    },
    getList: function() {
        var o = this, s = o.data.page, t = o.data.limit, n = o.data.activeIndex - 0 + 1, a = wx.getStorageSync("userInfo");
        o.setData({
            user_id: a.id
        }), app.ajax({
            url: "Ccollection|getCollections",
            data: {
                user_id: o.data.user_id,
                type: n,
                page: s,
                limit: t
            },
            success: function(t) {
                if (1 == n) {
                    console.log(t);
                    var a = o.data.storelist;
                    if (1 == s) a = t.data; else for (var e in t.data) a.push(t.data[e]);
                    o.setData({
                        storelist: a,
                        img_root: t.other.img_root,
                        count: t.other.count
                    });
                }
                if (3 == n) {
                    console.log(t);
                    var i = o.data.topiclist;
                    if (1 == s) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                    o.setData({
                        topiclist: i,
                        img_root: t.other.img_root,
                        count: t.other.count
                    });
                }
            }
        });
    },
    addPage: function() {
        var t = this, a = t.data.page;
        t.setData({
            page: ++a
        }), t.getList();
    },
    cancelcollection: function(t) {
        var a = this, e = t.currentTarget.id, i = a.data.topiclist, o = a.data.storelist, s = t.currentTarget.dataset.index, n = a.data.activeIndex - 0 + 1;
        app.ajax({
            url: "Ccollection|cancelCollection",
            data: {
                id: e
            },
            success: function(t) {
                0 == t.code ? (1 == n && (o.splice(s, 1), a.setData({
                    storelist: o
                })), 3 == n && (i.splice(s, 1), a.setData({
                    topiclist: i
                }))) : wx.showModal({
                    title: "提示",
                    content: t.msg
                });
            }
        });
    },
    pageCount: function() {
        var t = this, a = t.data.limit;
        t.data.count < t.data.page * a && t.setData({
            nomore: !0
        });
    },
    onReachBottom: function() {
        this.data.nomore || (this.addPage(), this.pageCount());
    },
    getPadding: function(t) {
        this.setData({
            padding: t.detail
        });
    }
});