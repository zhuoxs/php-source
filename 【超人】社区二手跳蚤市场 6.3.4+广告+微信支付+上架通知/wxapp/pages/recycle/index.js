function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page({
    data: {
        categorys: {
            list: [],
            children: [],
            selectedId: "",
            scroll: !0
        }
    },
    onLoad: function() {
        var e = this;
        e.setData({
            recycle: {
                style: wx.getStorageSync("recycle_style")
            }
        }), app.util.footer(e), e.getCategorys();
    },
    getCategorys: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/recycle",
            data: {
                m: "superman_hand2",
                act: "category"
            },
            fail: function(e) {
                console.log(e), wx.showModal({
                    title: "系统提示",
                    content: e.data.errmsg + "(" + e.data.errno + ")"
                });
            },
            success: function(e) {
                if (console.log(e), e.data.data.categorys) {
                    var a = {
                        list: e.data.data.categorys,
                        children: e.data.data.categorys[0].children,
                        selectedId: e.data.data.categorys[0].id,
                        scroll: t.data.categorys.scroll
                    };
                    t.setData({
                        categorys: a
                    });
                }
            }
        });
    },
    handleTabChangeCategory: function(e) {
        var a = this, t = e.detail;
        if (a.data.categorys.list) for (var r = 0; r < a.data.categorys.list.length; r++) {
            var c = a.data.categorys.list[r];
            if (c.id == t) {
                var o;
                a.setData((_defineProperty(o = {}, "categorys.selectedId", t), _defineProperty(o, "categorys.children", c.children ? c.children : []), 
                o));
                break;
            }
        }
    }
});