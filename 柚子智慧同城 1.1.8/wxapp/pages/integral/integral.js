var a = getApp();

require("../../zhy/component/comFooter/dealfoot.js");

a.Base({
    data: {
        navChoose: 0,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.onLoadData();
        }, "/pages/integral/integral");
    },
    onLoadData: function() {
        var t = this;
        a.api.apiIntegralCategory().then(function(a) {
            var o = {
                icon: "",
                id: 0,
                name: "全部"
            };
            a.data || (a.data = []), a.data.unshift(o), t.setData({
                nav: a.data,
                show: !0
            }), t.loadList();
        }).catch(function(t) {
            a.tips(t.msg);
        });
    },
    loadList: function() {
        var t = this, o = t.data.olist, n = t.data.length, e = t.data.page, i = 0;
        this.data.nav.length > 0 && (i = this.data.nav[this.data.navChoose].id);
        var s = {
            cat_id: i,
            page: e,
            length: n
        };
        a.api.apiIntegralGoodslist(s).then(function(a) {
            var i = !(a.data.length < n);
            if (a.data.length < n && t.setData({
                nomore: !0,
                show: !0
            }), 1 == e) o = a.data; else for (var s in a.data) o.push(a.data[s]);
            e += 1, t.setData({
                olist: o,
                show: !0,
                hasMore: i,
                page: e,
                img_root: a.other.img_root
            });
        }).catch(function(t) {
            a.tips(t.msg);
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.hasMore ? a.onLoadData() : this.setData({
            nomore: !0
        });
    },
    onNavTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.setData({
            navChoose: t,
            page: 1
        }), this.loadList();
    },
    onIntegraldetailTap: function(t) {
        var o = t.currentTarget.dataset.odx;
        a.navTo("/base/integraldetail/integraldetail?id=" + o);
    }
});