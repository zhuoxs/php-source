var app = getApp();

Page({
    data: {
        navTile: "拼团详情",
        goods: {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "3",
            userNum: 5,
            status: 2
        },
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        user: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg" ]
    },
    onLoad: function(o) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            }), app.get_user_info().then(function(t) {
                var a = o.id;
                app.util.request({
                    url: "entry/wxapp/GetGroup",
                    fromcache: !1,
                    data: {
                        group_id: a,
                        user_id: t.id
                    },
                    success: function(t) {
                        var o = t.data.info;
                        o.group_id = a;
                        for (var i = t.data.list, n = 0; n < o.userNum - o.num; n++) i.push("../../../../style/images/nouser.png");
                        e.setData({
                            goods: o,
                            user: i
                        });
                    }
                });
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.goods, o = {};
        return o.title = t.title, o.path = "yzhyk_sun/pages/index/groupjoin/groupjoin?id=" + t.group_id, 
        o;
    },
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../../index/groupPro/groupPro"
        });
    }
});