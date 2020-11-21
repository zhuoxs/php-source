Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        column: {
            type: Number,
            value: 4
        },
        fontColor: {
            type: String,
            value: "#000"
        },
        fontSize: {
            type: Number,
            value: 32
        },
        radius: {
            type: String,
            value: "50%"
        },
        list: {
            type: Array,
            value: []
        }
    },
    data: {
        currentIndex: 0
    },
    methods: {
        currentChange: function(n) {
            var t = n.detail.current;
            this.setData({
                currentIndex: t
            });
        },
        intoDetail: function(n) {
            var t = n.currentTarget.dataset.url;
            if (console.log(t), "miniprogram" == t) {
                var e = n.currentTarget.dataset.appid;
                return wx.navigateToMiniProgram({
                    appId: e,
                    success: function(n) {
                        console.log(n);
                    },
                    fail: function(n) {
                        wx.showModal({
                            title: "提示",
                            content: n.errMsg,
                            showCancel: !1
                        });
                    }
                }), !1;
            }
            var a = t.split("/");
            if ([ "kundian_farm", "kundian_game", "kundian_funding", "kundian_active", "kundian_pt", "kundian_store" ].indexOf(a[0]) >= 0) return wx.navigateTo({
                url: "/" + t
            }), !1;
            wx.navigateTo({
                url: "/kundian_farm/pages/" + t,
                fail: function(n) {}
            });
        }
    }
});