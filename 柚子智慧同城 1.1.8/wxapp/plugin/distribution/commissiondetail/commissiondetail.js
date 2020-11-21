/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var a = getApp();
a.Base({
    data: {
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user: a
            }), t.onLoadData()
        }, "/plugin/distribution/commission/commission")
    },
    onLoadData: function() {
        var t = this,
            o = this,
            i = o.data.olist,
            s = o.data.length,
            e = o.data.page,
            n = {
                user_id: o.data.user.id,
                page: e,
                length: s
            };
        a.api.apiDistributionGetMercapdetails(n).then(function(a) {
            var n = !(a.data.length < s);
            if (a.data.length < s && t.setData({
                show: !0,
                nomore: !0
            }), 1 == e) i = a.data;
            else for (var d in a.data) i.push(a.data[d]);
            e += 1, o.setData({
                olist: i,
                show: !0,
                hasMore: n,
                page: e
            })
        }).
        catch (function(t) {
            t.code, a.tips(t.msg)
        })
    },
    onReachBottom: function() {
        var a = this;
        a.data.hasMore ? a.onLoadData() : this.setData({
            nomore: !0
        })
    }
});