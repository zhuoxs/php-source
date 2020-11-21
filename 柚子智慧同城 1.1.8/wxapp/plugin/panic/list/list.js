/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t
}
var a = getApp();
a.Base({
    data: {
        temList: {
            mask: !1,
            classify: [],
            banner: {
                list: [],
                root: ""
            },
            choose: 0,
            flag: 1
        }
    },
    onClassifyTap: function(a) {
        var i, s = a.currentTarget.dataset.idx;
        this.setData((i = {}, t(i, "temList.choose", s), t(i, "temList.mask", !1), t(i, "list", {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }), i)), this.loadListData()
    },
    onNavTap: function(a) {
        var i, s = a.currentTarget.dataset.idx;
        this.setData((i = {}, t(i, "temList.flag", s), t(i, "list", {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }), i)), this.loadListData()
    },
    onTaggleTap: function() {
        this.setData(t({}, "temList.mask", !this.data.temList.mask))
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            a.onLoadData(t)
        }, "/plugin/panic/list/list")
    },
    onLoadData: function(i) {
        var s = this;
        Promise.all([a.api.apiGoodsGetCategoryList(), a.api.apiStoreGetBanner({
            type: 3
        })]).then(function(a) {
            var i, o = {
                name: "全部",
                id: 0
            };
            a[0].data.unshift(o), s.setData((i = {
                imgRoot: a[0].other.img_root
            }, t(i, "temList.classify", a[0].data), t(i, "temList.banner", {
                list: a[1].data,
                root: a[1].other.img_root
            }), t(i, "show", !0), i)), s.loadListData()
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    onChange: function(t) {
        wx.showToast({
            title: "切换到标签 " + (t.detail.index + 1),
            icon: "none"
        })
    },
    loadListData: function() {
        var i, s = this;
        if (!this.data.list.over && !this.data.ajax) {
            this.setData((i = {}, t(i, "list.load", !0), t(i, "ajax", !0), i));
            var o = {
                cid: this.data.temList.classify[this.data.temList.choose].id,
                type: this.data.temList.flag,
                page: this.data.list.page,
                length: this.data.list.length,
                hot: 0
            };
            a.api.apiPanicPanicList(o).then(function(t) {
                s.data.show || s.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), s.dealList(t.data, s.data.list.page)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadListData()
    },
    onCouponTap: function(t) {
        var i = t.currentTarget.dataset.idx,
            s = this.data.list.data[i].id;
        a.navTo("/plugin/panic/info/info?id=" + s)
    },
    onShareAppMessage: function(t) {}
});