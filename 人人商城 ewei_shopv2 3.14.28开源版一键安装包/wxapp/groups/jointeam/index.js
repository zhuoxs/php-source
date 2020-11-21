var t = getApp(), a = t.requirejs("core");

t.requirejs("jquery"), t.requirejs("foxui");

Page({
    data: {
        goods_id: 0,
        option_id: 0,
        ladder_id: 0
    },
    onLoad: function(t) {
        var d = this, e = t.id, o = t.ladder_id;
        this.setData({
            goods_id: t.id,
            option_id: t.option_id,
            ladder_id: t.ladder_id
        }), a.get("groups.goods.fight_groups", {
            id: e,
            ladder_id: o
        }, function(t) {
            1 != t.error ? (d.setData({
                data: t.data,
                other: t.other
            }), setInterval(function() {
                var t = d.data.other;
                for (var a in t) {
                    var e = t[a].residualtime, o = 0, i = 0;
                    e > 60 && (i = parseInt(e / 60), e = parseInt(e % 60), i > 60 && (o = parseInt(i / 60), 
                    i = parseInt(i / 60))), e < 0 && (o = 0, i = 0, e = 0, d.data.other[a].status = "hide", 
                    d.data.other = []), d.data.other[a].hours = o, d.data.other[a].minite = i, d.data.other[a].second = e, 
                    d.data.other[a].residualtime = d.data.other[a].residualtime - 1;
                }
                d.setData({
                    other: t
                });
            }, 1e3)) : a.alert(t.message);
        });
    },
    join: function() {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    do_: function(t) {
        var d = this, e = t.target.dataset.teamid;
        a.get("groups/order/create_order", {
            id: d.data.goods_id,
            group_option_id: d.data.option_id,
            ladder_id: d.data.ladder_id,
            type: "groups",
            heads: 0,
            teamid: e
        }, function(t) {
            1 != t.error ? wx.navigateTo({
                url: "../confirm/index?id=" + d.data.goods_id + "&heads=0&type=groups&option_id=" + d.data.option_id + "&teamid=" + e + "&ladder_id=" + d.data.ladder_id
            }) : a.alert(t.message);
        });
    }
});