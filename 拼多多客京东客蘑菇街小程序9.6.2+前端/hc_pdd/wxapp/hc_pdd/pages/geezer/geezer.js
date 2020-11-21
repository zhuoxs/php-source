var app = getApp();

Page({
    data: {
        wen: [ {
            id: "1",
            txt: "服务器办公资料",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "2",
            txt: "办公用品标记",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "3",
            txt: "定义工作流",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "4",
            txt: " 存储",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "5",
            txt: "集成整合办公 ",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "6",
            txt: "培训与教程",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "7",
            txt: "客户成就",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "8",
            txt: "服务类目",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "9",
            txt: "资源管理",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "10",
            txt: "关于我们说明",
            img: "../../resource/images/sacxsa_03.png"
        }, {
            id: "11",
            txt: "办公环境",
            img: "../../resource/images/sacxsa_03.png"
        } ]
    },
    onLoad: function(a) {
        var t = a.img;
        this.setData({
            img: t
        }), this.Headcolor(), this.Shenhelist();
    },
    onReady: function() {},
    Shenhelist: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shenhelist",
            method: "POST",
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    adlist: t
                });
            }
        });
    },
    Headcolor: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                var e = a.data.data.config.title;
                wx.setNavigationBarColor({
                    frontColor: "#ffffff",
                    backgroundColor: app.globalData.Headcolor
                }), wx.setNavigationBarTitle({
                    title: e
                }), o.setData({
                    backgroundColor: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onShow: function() {},
    xiangqig: function(a) {
        console.log(111);
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../education/education?id=" + t
        });
    },
    dianji: function() {
        console.log(111);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});