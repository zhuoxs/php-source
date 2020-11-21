var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        currentType: 0,
        currentIndex: 0,
        typeList: [],
        lists: [],
        videos: [],
        farmSetData: []
    },
    onLoad: function(t) {
        var e = this, r = {
            control: "article",
            op: "getArticleData",
            uniacid: a,
            page: 1
        };
        e.getArticle(r);
        var i = wx.getStorageSync("kundian_farm_setData");
        e.setData({
            farmSetData: i
        }), wx.setNavigationBarColor({
            frontColor: i.front_color,
            backgroundColor: i.background_color
        });
    },
    changeType: function(t) {
        var e = t.currentTarget.dataset.id;
        this.data.currentType !== e && this.setData({
            currentType: e
        });
        var r = {
            control: "article",
            op: "getArticleData",
            uniacid: a,
            page: 1,
            type_id: e
        };
        this.getArticle(r);
    },
    getArticle: function(a) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var e = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: a,
            success: function(t) {
                if (1 == a.page) {
                    var r = e.data.typeList, i = t.data, n = i.typeData, c = i.articleData, s = i.type_id;
                    n && (r = n), e.setData({
                        lists: c,
                        currentType: s,
                        typeList: r
                    });
                } else {
                    var o = t.data.articleData, d = e.data.lists;
                    o.map(function(t) {
                        d.push(t);
                    }), e.setData({
                        lists: d
                    });
                }
                wx.hideLoading();
            }
        });
    },
    changeIndex: function(t) {
        var a = t.detail.current;
        this.setData({
            currentIndex: a
        });
    }
});