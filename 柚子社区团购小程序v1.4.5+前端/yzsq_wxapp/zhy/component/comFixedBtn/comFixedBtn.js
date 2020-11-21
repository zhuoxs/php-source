function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp(), key = 0;

Component({
    properties: {
        padding: {
            type: Boolean,
            value: !0,
            observer: function(a, t) {}
        },
        dobule: {
            type: Boolean,
            value: !1,
            observer: function(a, t) {}
        }
    },
    data: {
        info: {
            is_open: 0
        }
    },
    attached: function() {
        var a = getCurrentPages();
        "sqtg_sun/pages/home/index/index" == a[a.length - 1].route ? this.setData({
            showHome: !1
        }) : this.setData({
            showHome: !0
        }), this.getData();
    },
    methods: {
        getData: function() {
            var t = this;
            app.ajax({
                url: "Csystem|suspensionIcon",
                success: function(a) {
                    null != a.data ? (1 == a.data.show_index && (t.data.showHome || (a.data.show_index = 0)), 
                    a.data.back_icon && (a.data.back_icon = a.other.img_root + a.data.back_icon), a.data.customer_service_icon && (a.data.customer_service_icon = a.other.img_root + a.data.customer_service_icon), 
                    a.data.tel_icon && (a.data.tel_icon = a.other.img_root + a.data.tel_icon), a.data.wxapp_icon && (a.data.wxapp_icon = a.other.img_root + a.data.wxapp_icon), 
                    t.setData({
                        info: a.data
                    })) : t.setData(_defineProperty({}, "info.is_open", 0));
                }
            });
        },
        _taggleFixedBtnTab: function() {
            var a = this;
            1 != key && (key = 1, setTimeout(function() {
                a.setData({
                    taggleBtn: !a.data.taggleBtn
                }), key = 0;
            }, 600));
        },
        _onPhoneTab: function() {
            wx.makePhoneCall({
                phoneNumber: this.data.info.tel
            });
        },
        _onOtherAppTab: function() {
            var a = this.data.info.wxapp_appid, t = this.data.info.wxapp_path;
            wx.navigateToMiniProgram({
                appId: a,
                path: t
            });
        },
        _onHomeTab: function() {
            app.lunchTo("/sqtg_sun/pages/home/index/index");
        }
    }
});