/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "全部",
            status: 0
        }, {
            title: "待打款",
            status: 1
        }, {
            title: "已打款",
            status: 2
        }, {
            title: "被拒绝",
            status: 3
        }, {
            title: "提现失败",
            status: 4
        }],
        curHdIndex: 0,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, "/plugin/distribution/commission/commission")
    },
    onLoadData: function() {
        var a = this,
            s = a.data.olist,
            i = a.data.length,
            e = a.data.page,
            n = {
                user_id: a.data.user.id,
                page: e,
                length: i,
                type: a.data.curHdIndex
            };
        t.api.apiDistributionGetWithdrawList(n).then(function(t) {
            var n = !(t.data.length < i);
            if (t.data.length < i && a.setData({
                nomore: !0,
                show: !0
            }), 1 == e) s = t.data;
            else for (var o in t.data) s.push(t.data[o]);
            e += 1, a.setData({
                olist: s,
                show: !0,
                hasMore: n,
                page: e
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
        }), this.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    }
});