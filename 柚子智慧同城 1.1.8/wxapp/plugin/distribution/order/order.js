/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "普通订单",
            status: 1
        }, {
            title: "抢购订单",
            status: 2
        }, {
            title: "拼团订单",
            status: 3
        }, {
            title: "会员卡订单",
            status: 4
        }, {
            title: "预约",
            status: 5
        }],
        nav1: [{
            title: "全部",
            status: 1
        }, {
            title: "待付款",
            status: 2
        }, {
            title: "已付款",
            status: 3
        }, {
            title: "完成",
            status: 4
        }],
        showGoods: !1,
        curHdIndex: 1,
        curIndex: 0,
        page: 1,
        length: 4,
        olist: []
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                show: !0,
                user: t
            }), a.onLoadData(t)
        }, "/plugin/distribution/commission/commission")
    },
    onLoadData: function() {
        var a = this,
            s = a.data.olist,
            o = a.data.length,
            e = a.data.page,
            i = {
                user_id: a.data.user.id,
                page: e,
                length: o,
                status: a.data.curHdIndex,
                type: a.data.curIndex + 1
            };
        t.api.apiDistributionGetDistributionorderList(i).then(function(t) {
            var i = !(t.data.length < o);
            if (t.data.length < o && a.setData({
                nomore: !0,
                show: !0
            }), 1 == e) s = t.data;
            else for (var n in t.data) s.push(t.data[n]);
            e += 1, a.setData({
                olist: s,
                show: !0,
                hasMore: i,
                page: e,
                img_root: t.other.img_root
            })
        }).
        catch (function(a) {
            a.code, t.tips(a.msg)
        })
    },
    swichNav: function(t) {
        var a = this,
            s = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: s,
            page: 1
        }), a.onLoadData()
    },
    topSwichNav: function(t) {
        var a = this,
            s = t.currentTarget.dataset.status - 1;
        a.setData({
            curIndex: s,
            curHdIndex: 1,
            page: 1
        }), a.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    },
    onArrowTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            idx: a,
            showGoods: a != this.data.idx || !this.data.showGoods
        })
    }
});