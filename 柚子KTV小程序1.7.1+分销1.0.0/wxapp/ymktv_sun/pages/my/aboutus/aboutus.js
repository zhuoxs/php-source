var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        imgsrc: "https://p1.meituan.net/movie/dc1f94811793e9c653170cba7b05bf3e484939.jpg",
        title: "恒大集团",
        titletxt: "恒大集团是以民生地产为基础，金融、健康为两翼，文化旅游为龙头的世界500强企业集团，已形成“房地产+服务业”产业格局。总资产1.5万亿，年销售规模超5000亿，年纳税超420亿，员工12万多人，解决就业220多万人。多年来，恒大持续践行社会责任，已累计为民生、扶贫、教育和体育等公益事业捐款100多次超105亿。",
        usphone: "12345678910",
        add: "福建厦门集美地球村18号"
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    dianhua: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.family.phone,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        n.url(), app.util.request({
            url: "entry/wxapp/family",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    family: t.data
                });
            }
        });
    },
    url: function(t) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});