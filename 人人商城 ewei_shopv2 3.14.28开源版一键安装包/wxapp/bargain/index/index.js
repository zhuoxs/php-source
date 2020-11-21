var t = getApp(), a = t.requirejs("core");

t.requirejs("jquery"), t.requirejs("foxui");

Page({
    data: {
        list: {},
        emptyHint: !1,
        label: "/static/images/label.png"
    },
    onLoad: function() {
        var i = this;
        a.get("bargain/get_list", {}, function(t) {
            i.setData({
                list: t.list
            });
        }), t.getCache("isIpx") ? i.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : i.setData({
            isIpx: !1,
            iphonexnavbar: ""
        });
    },
    bindFocus: function() {
        this.setData({
            fromsearch: !0
        });
    },
    bindback: function() {
        this.setData({
            fromsearch: !1
        }), this.onLoad();
    },
    bindSearch: function(t) {
        var i = this, e = t.detail.value;
        a.get("bargain/get_list", {
            keywords: e
        }, function(t) {
            t.list.length <= 0 ? i.setData({
                emptyHint: !0
            }) : i.setData({
                emptyHint: !1
            }), i.setData({
                list: t.list
            });
        });
    }
});