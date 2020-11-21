if (typeof wx === 'undefined') var wx = getApp().core;
var WxParse = require('./../../wxParse/wxParse.js');
var quickNavigation = require('./../../components/quick-navigation/quick-navigation.js');
Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        getApp().page.onLoad(this, options);
        quickNavigation.init(this);
        var self = this;
        getApp().request({
            url: getApp().api.default.topic,
            data: {
                id: options.id,
            },
            success: function (res) {
                if (res.code == 0) {
                    self.setData(res.data);
                    WxParse.wxParse("content", "html", res.data.content, self);
                } else {
                    getApp().core.showModal({
                        title: "提示",
                        content: res.msg,
                        showCancel: false,
                        success: function (e) {
                            if (e.confirm) {
                                getApp().core.redirectTo({
                                    url: "/pages/index/index"
                                });
                            }
                        }
                    });
                }
            }
        });

    },

    wxParseTagATap: function (e) {
        if (e.currentTarget.dataset.goods) {
            var src = e.currentTarget.dataset.src || false;
            if (!src) return;
            getApp().core.navigateTo({
                url: src,
            });
        }
    },

    quickNavigation: function(){
        this.setData({
            quick_icon:!this.data.quick_icon
        })  
        let animationPlus = getApp().core.createAnimation({
            duration: 300,
            timingFunction: 'ease-out',
        });

        var x = -55;
        if (this.data.quick_icon) {
            animationPlus.opacity(0).step();
        } else {
            animationPlus.translateY(x).opacity(1).step();
        }
        this.setData({
           animationPlus: animationPlus.export(),
        });
    },

    favoriteClick: function (e) {
        var self = this;
        var action = e.currentTarget.dataset.action;

        getApp().request({
            url: getApp().api.user.topic_favorite,
            data: {
                topic_id: self.data.id,
                action: action,
            },
            success: function (res) {
                getApp().core.showToast({
                    title: res.msg,
                });
                if (res.code == 0) {
                    self.setData({
                        is_favorite: action,
                    });
                }
            }
        });
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        getApp().page.onShow(this);
    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function () {
        getApp().page.onShareAppMessage(this);

        var user_info = getApp().getUser();
        var id = this.data.id;
        var res = {
            title: this.data.title,
            path: "/pages/topic/topic?id=" + id + "&user_id=" + user_info.id,
        };
        return res;
    }
});