var e = new getApp();

Component({
    data: {
        statusBarHeight: e.globalData.statusBarHeight,
        titleBarHeight: e.globalData.titleBarHeight
    },
    properties: {
        isIphoneX: {
            type: Boolean,
            value: !1
        },
        fontColor: {
            type: String,
            value: "#ffffff"
        },
        bgColor: {
            type: String,
            value: "#46abf7"
        },
        title: {
            type: String,
            value: "农场乐园"
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
        }
    },
    attached: function() {
        wx.setNavigationBarColor({
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