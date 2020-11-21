Page({
    data: {
        navTile: "设置",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/yzbld_sun/pages/user/distribute/distribute",
                text: "配送",
                iconPath: "/style/images/ps1.png",
                selectedIconPath: "/style/images/ps2.png",
                selectedColor: "#ef8200",
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/user/dorder/dorder",
                text: "订单",
                iconPath: "/style/images/ps3.png",
                selectedIconPath: "/style/images/ps4.png",
                selectedColor: "#ef8200",
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/user/dset/dset",
                text: "设置",
                iconPath: "/style/images/ps5.png",
                selectedIconPath: "/style/images/ps6.png",
                selectedColor: "#ef8200",
                active: !0
            } ],
            position: "bottom"
        },
        sets: [ {
            sets: "shop",
            status: !0
        } ]
    },
    onLoad: function(e) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    switchChange: function(e) {
        var t = e.detail.value, s = e.currentTarget.dataset.index, a = this.data.sets;
        a[s].status = !t, this.setData({
            sets: a
        });
    }
});