Page({
    data: {
        showModalStatus: !1,
        curIndex: 0,
        classicData: [ "打听事", "求帮助" ]
    },
    onLoad: function(t) {
        this.calculWidth();
    },
    tabClick: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curIndex: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    toCircleDetails: function(t) {
        wx.navigateTo({
            url: "../circle/details/details"
        });
    },
    writeComments: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a), console.log(t);
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("630rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    calculWidth: function(t) {
        console.log(this.data.classicData.length);
        3 < this.data.classicData.length && this.setData({
            limit: "min-width"
        });
    }
});