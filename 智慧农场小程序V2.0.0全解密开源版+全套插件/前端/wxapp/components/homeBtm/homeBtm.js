Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        homeBtm: {
            type: Object,
            value: []
        }
    },
    data: {},
    methods: {
        intoBtmDetail: function(n) {
            var t = n.currentTarget.dataset.jumpurl, a = t.split("/");
            if (0 == [ "kundian_farm", "kundian_game", "kundian_funding", "kundian_active", "kundian_pt" ].indexOf(a[0])) return wx.navigateTo({
                url: "/" + t
            }), !1;
            wx.navigateTo({
                url: "/kundian_farm/pages/" + t,
                fail: function(n) {}
            });
        }
    }
});