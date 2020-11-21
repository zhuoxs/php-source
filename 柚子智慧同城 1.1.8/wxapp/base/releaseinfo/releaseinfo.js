/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
Page({
    data: {
        showchoice: !0,
        showModalStatus: !1,
        userImg: "../../zhy/resource/images/cs2.jpg",
        userName: "柚子鱼庄",
        userLab: ["宠物情缘", "宠物求购"],
        nodes: ["本人想领养一只猫咪，品种不限，有的请联系我；猫 贩勿扰。电话：13000000000"],
        userAddr: "厦门市集美区杏林湾营运……",
        fbTime: "2018-04-09 18:00",
        browse: "2018",
        like: "2018",
        telephone: "18350231299",
        pnTxt: "拨打电话",
        discuss: [{
            diserImg: "../../zhy/resource/images/cs2.jpg",
            diserName: "那棵树看起来真的生气了1",
            diserTime: "2018-04-09 18:00",
            deserCont: "这里是评论内容详情这里是评论内容详情这里是评论 内容详情这里是评论内容详情这里是评论内容详情这 里是评论内容详情。"
        }, {
            diserImg: "../../zhy/resource/images/cs.jpg",
            diserName: "那棵树看起来真的生气了1",
            diserTime: "2018-04-09 18:00",
            deserCont: "这里是评论内容详情这里是评论内容详情这里是评论 内容详情这里是评论内容详情这里是评论内容详情这 里是评论内容详情。"
        }]
    },
    onLoad: function(t) {
        this.setData({
            show: !0
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    showPopup: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e)
    },
    close: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e)
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        this.animation = e, e.opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("630rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            })
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        })
    },
    callme: function(t) {
        var e = this.data;
        t.currentTarget.dataset.index;
        wx.makePhoneCall({
            phoneNumber: e.telephone,
            success: function() {
                console.log("拨打电话成功！")
            },
            fail: function() {
                console.log("拨打电话失败！")
            }
        })
    },
    showchoice: function() {
        var t = this.data.showchoice,
            e = parseInt(this.data.like);
        1 == t ? this.setData({
            showchoice: !1,
            like: e + 1
        }) : this.setData({
            showchoice: !0,
            like: e - 1
        })
    },
    iwRelease: function() {
        wx.navigateTo({
            url: "../../fabu/fabu"
        })
    }
});