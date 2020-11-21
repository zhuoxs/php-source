var app = getApp();

Page({
    data: {
        navTile: "小朋友故事会",
        story: [],
        storyList: [],
        viptype: 0,
        currentIndex: 0,
        classify: [ {
            id: "0",
            title: "全部"
        } ],
        curPage: 1,
        pagesize: 6,
        searchCont: "",
        catgoryId: 0,
        imgroot: wx.getStorageSync("imgroot")
    },
    onLoad: function(t) {
        var r = this;
        wx.setNavigationBarTitle({
            title: r.data.navTile
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.util.request({
            url: "entry/wxapp/getStoryCategory",
            cachetime: "0",
            success: function(t) {
                console.log(t.data);
                var a = r.data.classify;
                for (var e in t.data) a.push(t.data[e]);
                r.setData({
                    classify: a
                });
            }
        }), app.get_imgroot().then(function(t) {
            r.setData({
                imgroot: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.get_user_vip().then(function(t) {
            a.setData({
                vipType: t
            });
        }), app.util.request({
            url: "entry/wxapp/getStoryStStory",
            cachetime: "0",
            data: {
                page: 1,
                pagesize: 10
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    story: t.data
                });
            }
        }), a.get_story_list();
    },
    get_story_list: function() {
        var r = this, o = r.data.curPage, n = r.data.storyList, t = r.data.searchCont, a = r.data.catgoryId;
        app.util.request({
            url: "entry/wxapp/getCategoryVipStory",
            cachetime: "0",
            data: {
                catgory_id: a,
                page: o,
                pagesize: r.data.pagesize,
                keyword: t
            },
            success: function(t) {
                var a = t.data.length == r.data.pagesize;
                if (1 == o) n = t.data; else for (var e in t.data) n.push(t.data[e]);
                o += 1, r.setData({
                    storyList: n,
                    curPage: o,
                    hasMore: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_story_list() : wx.showToast({
            title: "没有更多故事啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    classify: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.id;
        this.setData({
            currentIndex: a,
            catgoryId: e,
            curPage: 1,
            searchCont: "",
            hasMore: !0
        }), this.get_story_list();
    },
    toVipStory: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.album, r = t.currentTarget.dataset.flink, o = r || this.data.imgroot + t.currentTarget.dataset.src, n = t.currentTarget.dataset.index, s = t.currentTarget.dataset.albumid;
        app.get_user_vip().then(function(t) {
            0 == t ? wx.showModal({
                content: "你还不是会员喔~",
                confirmText: "开通会员",
                confirmColor: "#ff5e5e",
                success: function(t) {
                    t.confirm && wx.navigateTo({
                        url: "/yzqzk_sun/pages/member/joinmember/joinmember"
                    });
                }
            }) : 0 == e ? (console.log(o), wx.navigateTo({
                url: "../storydet/storydet?id=" + a + "&src=" + o + "&index" + n
            })) : wx.navigateTo({
                url: "../story/story?id=" + s
            });
        });
    },
    toStory: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.album, r = t.currentTarget.dataset.flink, o = r || this.data.imgroot + t.currentTarget.dataset.src, n = t.currentTarget.dataset.index, s = t.currentTarget.dataset.albumid;
        0 == e ? wx.navigateTo({
            url: "../storydet/storydet?id=" + a + "&src=" + o + "&index" + n
        }) : wx.navigateTo({
            url: "../story/story?id=" + s
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/joinmember/joinmember"
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
            catgoryId: "",
            searchCont: t,
            curPage: 1,
            hasMore: !0,
            pagesize: 12
        }), this.get_story_list()) : wx.showToast({
            title: "搜索关键词不得微空",
            icon: "none",
            duration: 2500
        });
    }
});