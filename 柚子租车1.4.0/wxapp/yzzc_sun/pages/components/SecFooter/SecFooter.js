var _extends = Object.assign || function(e) {
    for (var a = 1; a < arguments.length; a++) {
        var n = arguments[a];
        for (var o in n) Object.prototype.hasOwnProperty.call(n, o) && (e[o] = n[o]);
    }
    return e;
}, _api = require("../../../common/js/api.js"), _reload = require("../../../common/js/reload.js"), app = getApp();

Component({
    properties: {
        chooseNav: {
            type: Number,
            value: 0,
            observer: function(e, a) {}
        }
    },
    data: {},
    attached: function() {
        this.getFooter();
    },
    ready: function() {},
    methods: _extends({}, _reload.reload, {
        getFooter: function() {
            var o = this;
            this.checkUrl().then(function(e) {
                var a = wx.getStorageSync("color");
                if (o.setData({
                    color: a
                }), wx.getStorageSync("footernav") && 3 != o.data.chooseNav) {
                    var n = wx.getStorageSync("footernav");
                    switch (n[0].choose = 0, n[1].choose = 0, n[2].choose = 0, n[3].choose = 0, o.data.chooseNav) {
                      case 0:
                        n[0].choose = 1;
                        break;

                      case 1:
                        n[1].choose = 1;
                        break;

                      case 2:
                        n[2].choose = 1;
                        break;

                      case 3:
                        n[3].choose = 1;
                    }
                    o.setData({
                        nav: n
                    });
                } else (0, _api.NavsetData)().then(function(e) {
                    o._dealData(e);
                }, function(e) {
                    console.log("err" + e);
                });
            }).catch(function(e) {
                -1 === e.code ? o.tips(e.msg) : o.tips("false");
            });
        },
        _dealData: function(e) {
            wx.getStorageSync("footernav");
            var a = [ {}, {}, {}, {} ];
            switch (a[0].choose = 0, a[1].choose = 0, a[2].choose = 0, a[3].choose = 0, a[0].show = 1, 
            a[1].show = wx.getStorageSync("color").open_fj - 0, a[2].show = 1, a[3].show = 1, 
            this.data.chooseNav) {
              case 0:
                a[0].choose = 1;
                break;

              case 1:
                a[1].choose = 1;
                break;

              case 2:
                a[2].choose = 1;
                break;

              case 3:
                a[3].choose = 1;
            }
            e ? (null === e.nav_img_one || "" === e.nav_img_one ? a[0].imgh = "../../../resource/images/tabbar/shouye-h.png" : a[0].imgh = this.data.imgLink + e.nav_img_a, 
            null === e.nav_img_one || "" === e.nav_img_one ? a[0].img = "../../../resource/images/tabbar/shouye.png" : a[0].img = this.data.imgLink + e.nav_img_one, 
            null === e.nav_img_two || "" === e.nav_img_two ? a[1].imgh = "../../../resource/images/tabbar/fujin-h.png" : a[1].imgh = this.data.imgLink + e.nav_img_b, 
            null === e.nav_img_two || "" === e.nav_img_two ? a[1].img = "../../../resource/images/tabbar/fujin.png" : a[1].img = this.data.imgLink + e.nav_img_two, 
            null === e.nav_img_three || "" === e.nav_img_three ? a[2].imgh = "../../../resource/images/tabbar/dingdan-h.png" : a[2].imgh = this.data.imgLink + e.nav_img_c, 
            null === e.nav_img_three || "" === e.nav_img_three ? a[2].img = "../../../resource/images/tabbar/dingdan.png" : a[2].img = this.data.imgLink + e.nav_img_three, 
            null === e.nav_img_four || "" === e.nav_img_four ? a[3].imgh = "../../../resource/images/tabbar/wode-h.png" : a[3].imgh = this.data.imgLink + e.nav_img_d, 
            null === e.nav_img_four || "" === e.nav_img_four ? a[3].img = "../../../resource/images/tabbar/wode.png" : a[3].img = this.data.imgLink + e.nav_img_four, 
            null === e.nav_name_one || "" === e.nav_name_one ? a[0].txt = "首页" : a[0].txt = e.nav_name_one, 
            null === e.nav_name_two || "" === e.nav_name_two ? a[1].txt = "附近" : a[1].txt = e.nav_name_two, 
            null === e.nav_name_three || "" === e.nav_name_three ? a[2].txt = "订单" : a[2].txt = e.nav_name_three, 
            null === e.nav_name_four || "" === e.nav_name_four ? a[3].txt = "我的" : a[3].txt = e.nav_name_four) : (a[0].imgh = "../../../resource/images/tabbar/shouye-h.png", 
            a[0].img = "../../../resource/images/tabbar/shouye.png", a[1].imgh = "../../../resource/images/tabbar/fujin-h.png", 
            a[1].img = "../../../resource/images/tabbar/fujin.png", a[2].imgh = "../../../resource/images/tabbar/dingdan-h.png", 
            a[2].img = "../../../resource/images/tabbar/dingdan.png", a[3].imgh = "../../../resource/images/tabbar/wode-h.png", 
            a[3].img = "../../../resource/images/tabbar/wode.png", a[0].txt = "首页", a[1].txt = "附近", 
            a[2].txt = "订单", a[3].txt = "我的"), wx.setStorageSync("footernav", a), this.setData({
                nav: a
            });
        },
        _onNavTab: function(e) {
            switch (e.currentTarget.dataset.index) {
              case 0:
                wx.reLaunch({
                    url: "../home/home"
                });
                break;

              case 1:
                wx.reLaunch({
                    url: "../near/near"
                });
                break;

              case 2:
                wx.reLaunch({
                    url: "../order/order"
                });
                break;

              case 3:
                wx.reLaunch({
                    url: "../mine/mine"
                });
            }
        }
    })
});