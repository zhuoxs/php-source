/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "全部",
            status: 0
        }, {
            title: "待使用",
            status: 1
        }, {
            title: "已使用",
            status: 2
        }, {
            title: "已过期",
            status: 3
        }],
        page: 1,
        length: 10,
        olist: [],
        curHdIndex: 0
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user_id: a.id
            }), t.onLoadData()
        }, "/base/mycoupons/mycoupons")
    },
    onLoadData: function(a) {
        var o = this,
            e = o.data.olist,
            n = o.data.page,
            s = o.data.length,
            i = {
                user_id: o.data.user_id,
                page: n,
                length: s,
                type: o.data.curHdIndex
            };
        t.api.apIcouponMyCoupon(i).then(function(t) {
            var a = (new Date).getTime(),
                i = !(t.data.length < s);
            if (t.data.length < s && o.setData({
                nomore: !0,
                show: !0
            }), 1 == n) e = t.data;
            else for (var d in t.data) e.push(t.data[d]);
            n += 1, o.setData({
                olist: e,
                show: !0,
                hasMore: i,
                page: n,
                nowtime: a,
                img_root: t.other.img_root
            })
        }).
        catch (function(a) {
            a.code, t.tips(a.msg)
        })
    },
    onSwichTap: function(t) {
        var a = this,
            o = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: o,
            page: 1
        }), this.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : t.setData({
            nomore: !0
        })
    },
    onCouponDetailTap: function(a) {
        t.navTo("/base/mycoupondetail/mycoupondetail?id=" + a.currentTarget.dataset.id)
    }
});