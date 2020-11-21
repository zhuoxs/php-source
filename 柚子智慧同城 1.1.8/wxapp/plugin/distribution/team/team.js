/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "一级",
            status: 0
        }, {
            title: "二级",
            status: 1
        }, {
            title: "三级",
            status: 2
        }],
        curHdIndex: 0,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData(a)
        }, "/plugin/distribution/team/team")
    },
    onLoadData: function() {
        var a = this,
            e = a.data.olist,
            i = a.data.length,
            n = a.data.page,
            o = {
                user_id: a.data.user.id,
                page: n,
                length: i,
                level: a.data.curHdIndex + 1
            };
        Promise.all([t.api.apiDistributionGetTeamLevel(o), t.api.apiDistributionGetDistributionset()]).then(function(t) {
            var o = !(t[0].data.length < i);
            if (t[0].data.length < i && a.setData({
                nomore: !0,
                show: !0
            }), 1 == n) e = t[0].data;
            else for (var s in t[0].data) e.push(t[0].data[s]);
            n += 1, a.setData({
                olist: e,
                setInfo: t[1].data,
                show: !0,
                hasMore: o,
                page: n,
                img_root: t[0].other.img_root,
                "nav[0].title": t[1].data.first_name || "一级",
                "nav[1].title": t[1].data.second_name || "二级",
                "nav[2].title": t[1].data.third_name || "三级"
            })
        }).
        catch (function(a) {
            a[0].code, t.tips(a[0].msg)
        })
    },
    swichNav: function(t) {
        var a = this,
            e = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: e,
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