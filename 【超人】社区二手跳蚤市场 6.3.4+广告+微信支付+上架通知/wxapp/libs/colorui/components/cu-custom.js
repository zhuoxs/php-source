var app = getApp();

Component({
    options: {
        addGlobalClass: !0,
        multipleSlots: !0
    },
    properties: {
        bgColor: {
            type: String,
            default: ""
        },
        isCustom: {
            type: [ Boolean, String ],
            default: !1
        },
        isBack: {
            type: [ Boolean, String ],
            default: !1
        },
        bgImage: {
            type: String,
            default: ""
        }
    },
    data: {
        StatusBar: app.globalData.StatusBar,
        CustomBar: app.globalData.CustomBar,
        Custom: app.globalData.Custom
    },
    methods: {
        BackPage: function() {
            wx.navigateBack({
                delta: 1
            });
        },
        toHome: function() {
            wx.reLaunch({
                url: "/pages/index/index"
            });
        }
    }
});