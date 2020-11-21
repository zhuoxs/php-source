var e = require("../../../../wxParse/wxParse.js"), a = new getApp();

Page({
    data: {
        config: [],
        isSelect: !1,
        current: 1,
        goodsData: [],
        sourceLi: [],
        source: [],
        about: [],
        source_code: ""
    },
    onLoad: function(e) {
        var a = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            config: a
        }), e.source_code && t.setData({
            source_code: e.source_code
        });
    },
    getText: function(e) {
        this.setData({
            source_code: e.detail.value
        });
    },
    saoma: function() {
        var e = this;
        wx.scanCode({
            success: function(t) {
                var a = t.path.split("=");
                e.setData({
                    source_code: a[1]
                });
            }
        });
    },
    selectSource: function() {
        wx.showLoading({
            title: "正在查询..."
        });
        var t = this, s = t.data.source_code;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSourceCode",
                control: "shop",
                source_code: s
            },
            success: function(a) {
                if (wx.hideLoading(), -1 != a.data.code) {
                    var s = a.data, c = s.goodsData, o = s.source, r = s.sourceLi, u = s.about;
                    t.setData({
                        goodsData: c,
                        source: o,
                        sourceLi: r,
                        about: u,
                        isSelect: !0
                    }), "" != u.farm_desc && e.wxParse("article", "html", u.farm_desc, t, 5);
                } else wx.showToast({
                    title: a.data.msg,
                    icon: "none"
                });
            }
        });
    },
    changeTar: function(e) {
        this.setData({
            current: e.currentTarget.dataset.current
        });
    },
    previewImg: function(e) {
        wx.previewImage({
            urls: [ e.currentTarget.dataset.src ],
            current: e.currentTarget.dataset.src
        });
    }
});