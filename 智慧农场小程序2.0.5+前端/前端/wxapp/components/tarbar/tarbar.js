Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        list: {
            type: Array,
            value: []
        },
        path: {
            type: String,
            value: "kundian_farm/pages/HomePage/index/index"
        },
        SystemInfo: {
            type: Object,
            value: {}
        }
    },
    data: {
        os_x: !1
    },
    attached: function() {
        var t = !1;
        this.data.SystemInfo.model.indexOf("iPhone X") > -1 && (t = !0), this.setData({
            os_x: t
        });
    },
    methods: {
        navTo: function(t) {
            var e = t.currentTarget.dataset, a = e.path;
            e.current || wx.reLaunch({
                url: "/" + a + "?is_tarbar=true"
            });
        }
    }
});