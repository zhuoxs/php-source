var app = getApp();

Page({
    data: {
        imgsrc: "../../../../style/images/scissors.png",
        hairUser: [ {
            hairName: "托尼",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony1.png"
        }, {
            hairName: "马丁",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony2.png"
        }, {
            hairName: "约翰",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony3.png"
        }, {
            hairName: "安琪",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony4.png"
        }, {
            hairName: "丽莎",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony5.png"
        }, {
            hairName: "曼达",
            work: "发型师",
            bookNum: "19",
            hairPhoto: "../../../../style/images/tony6.png"
        } ]
    },
    onLoad: function(o) {
        wx.setStorageSync("good_id", o.good_id), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, o = wx.getStorageSync("build_id"), a = wx.getStorageSync("good_id");
        console.log(a), "" == a && (a = 0), app.util.request({
            url: "entry/wxapp/Hair",
            cachetime: "0",
            data: {
                build_id: o,
                good_id: a
            },
            success: function(o) {
                console.log("你的数据多少哦"), console.log(o.data), t.setData({
                    Hair: o.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    stylist: function(o) {
        console.log(o), wx.navigateTo({
            url: "../stylist/stylist?id=" + o.currentTarget.dataset.id
        });
    }
});