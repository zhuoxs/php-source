var e = new getApp();

Component({
    properties: {
        isIphoneX: {
            type: Boolean,
            value: !1
        },
        fontColor: {
            type: String,
            value: "#000000"
        },
        bgColor: {
            type: String,
            value: "#ffffff"
        },
        title: {
            type: String,
            value: "农场"
        },
        clearfix: {
            type: Boolean,
            value: !1
        },
        showIcon: {
            type: Boolean,
            value: !1
        },
        hidden: {
            type: Boolean,
            value: !1
        },
        showHome: {
            type: Boolean,
            value: !1
        },
        justOnePage: {
            type: Boolean,
            value: !1
        },
        istopShow: {
            type: Boolean,
            value: !1
        },
        opacity: {
            type: Number,
            value: 1
        }
    },
    data: {
        statusBarHeight: e.globalData.statusBarHeight,
        titleBarHeight: e.globalData.titleBarHeight
    },
    attached: function() {
        this.data.fontColor && wx.setNavigationBarColor({
            frontColor: this.data.fontColor,
            backgroundColor: this.data.bgColor
        });
    },
    methods: {
        back: function() {
            wx.navigateBack({
                delta: 1
            });
        },
        index: function() {
            wx.reLaunch({
                url: "/kundian_farm/pages/HomePage/index/index"
            });
        }
    }
});