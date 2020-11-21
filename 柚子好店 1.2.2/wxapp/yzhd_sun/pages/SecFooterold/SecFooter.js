var app = getApp();

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
        this._getUrl();
    },
    ready: function() {},
    methods: {
        _getUrl: function() {
            var a = this;
            app.util.request({
                url: "entry/wxapp/url",
                cachetime: "0",
                success: function(e) {
                    console.log(e), a.setData({
                        url: e.data
                    }), wx.setStorage({
                        key: "url",
                        data: e.data
                    }), a._getNav();
                }
            });
        },
        _getNav: function() {
            var r = this;
            app.util.request({
                url: "entry/wxapp/GetMenu",
                cachetime: "30",
                success: function(e) {
                    if (console.log(e), e.data.status) r._dealData(!1); else {
                        var a = e.data.data, t = [];
                        for (var s in a) t.push(a[s]);
                        var o = [ {}, {}, {}, {} ];
                        for (var n in t) o[n].txt = t[n].name, o[n].img = r.data.url + t[n].logo, o[n].imgh = r.data.url + t[n].ck_logo;
                        wx.setStorageSync("footernav", e.data.data), r._dealData(o);
                    }
                }
            });
        },
        _dealData: function(e) {
            console.log("resss"), console.log(e);
            var a = [ {}, {}, {}, {} ];
            switch (a[0].choose = 0, a[1].choose = 0, a[2].choose = 0, a[3].choose = 0, this.data.chooseNav) {
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
            e ? a = e : (a[0].imgh = "../../resource/images/index/jingxuan.png", a[0].img = "../../resource/images/index/jingxuan-1.png", 
            a[1].imgh = "../../resource/images/index/haodian.png", a[1].img = "../../resource/images/index/haodian-1.png", 
            a[2].imgh = "../../resource/images/index/wode.png", a[2].img = "../../resource/images/index/wode-1.png", 
            a[3].imgh = "../../resource/images/index/fensika_s.png", a[3].img = "../../resource/images/index/fensika-1.png", 
            a[0].txt = "精选", a[1].txt = "好店", a[2].txt = "我的", a[3].txt = "粉丝卡"), wx.setStorageSync("footernav", a), 
            console.log("JSON"), console.log(a), this.setData({
                nav: a
            }), console.log(this.data.nav);
        },
        _onNavTab: function(e) {
            switch (e.currentTarget.dataset.index) {
              case 0:
                wx.reLaunch({
                    url: "../index/index"
                });
                break;

              case 1:
                wx.reLaunch({
                    url: "../bestShops/bestShops"
                });
                break;

              case 2:
                wx.reLaunch({
                    url: "../mine/mine"
                });
                break;

              case 3:
                wx.reLaunch({
                    url: "../fansCard/fansCard"
                });
            }
        }
    }
});