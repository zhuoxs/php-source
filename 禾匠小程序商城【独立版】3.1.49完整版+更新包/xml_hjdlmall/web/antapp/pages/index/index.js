if (typeof wx === 'undefined') var wx = getApp().core;
var quickNavigation = require('./../../components/quick-navigation/quick-navigation.js');
var interval = 0;
var page_first_init = true;
var timer = 1;
var fullScreen = false;
Page({
    data: {
        x: getApp().core.getSystemInfoSync().windowWidth,
        y: getApp().core.getSystemInfoSync().windowHeight,
        left: 0,
        show_notice: false,
        animationData: {},
        play: -1,
        time: 0,
        buy: false,
        opendate: false,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        getApp().page.onLoad(this, options);
        this.loadData(options);
        quickNavigation.init(this);
    },

    /**
     * 购买记录
     */
    suspension: function () {
        var self = this;

        interval = setInterval(function () {
            getApp().request({
                url: getApp().api.default.buy_data,
                data: {
                    'time': self.data.time
                },
                method: 'POST',
                success: function (res) {
                    if (res.code == 0) {
                        var inArray = false;
                        var msgHistory = self.data.msgHistory;
                        if (msgHistory == res.md5) {
                            inArray = true;
                        }
                        var cha_time = '';
                        var s = res.cha_time;
                        var m = Math.floor(s / 60 - Math.floor(s / 3600) * 60);
                        if (m == 0) {
                            cha_time = s % 60 + '秒';
                        } else {
                            cha_time = m + '分' + s % 60 + '秒';
                        }

                        if (!inArray && res.cha_time <= 300) {
                            self.setData({
                                buy:{
                                    time: cha_time,
                                    type: res.data.type,
                                    url: res.data.url,
                                    user: (res.data.user.length >= 5) ? res.data.user.slice(0, 4) + "..." : res.data.user,
                                    avatar_url: res.data.avatar_url,
                                    address: (res.data.address.length >= 8) ? res.data.address.slice(0, 7) + "..." : res.data.address,
                                    content: res.data.content,
                                },
                                msgHistory: res.md5
                            });
                        } else {
                            self.setData({
                                buy:false
                            });
                        }

                    }
                }
            });
        }, 10000);
    },

    /**
     * 加载页面数据
     */
    loadData: function (options) {
        var self = this;
        var pages_index_index = getApp().core.getStorageSync(getApp().const.PAGE_INDEX_INDEX);
        if (pages_index_index) {
            pages_index_index.act_modal_list = [];
            self.setData(pages_index_index);
        }
        getApp().request({
            url: getApp().api.default.index,
            success: function (res) {
                if (res.code == 0) {
                    if (!page_first_init) {
                        res.data.act_modal_list = [];
                    } else {
                        page_first_init = false;
                    }

                    self.setData(res.data);
                    getApp().core.setStorageSync(getApp().const.PAGE_INDEX_INDEX, res.data);
                    self.miaoshaTimer();
                }
            },
            complete: function () {
                getApp().core.stopPullDownRefresh();
            }
        });

    },
    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        var self = this;
        getApp().page.onShow(this);
        getApp().getConfig(function (config) {
            let store = config.store;
            if (store && store.name) {
                getApp().core.setNavigationBarTitle({
                    title: store.name,
                });
            }
            if (store && store.purchase_frame === 1) {
                self.suspension(self.data.time);
            } else {
                self.setData({
                    buy_user: '',
                })
            }
        });
        self.notice();
    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function () {
        getApp().getStoreData();
        clearInterval(timer);
        this.loadData();
    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function (options) {
        var self = this;
        var user_info = getApp().getUser();
        return {
            path: "/pages/index/index?user_id=" + user_info.id,
            title: self.data.store.name
        };
    },

    showshop: function (e) {

        var self = this;
        var goods_id = e.currentTarget.dataset.id;
        var data = e.currentTarget.dataset;
        getApp().request({
            url: getApp().api.default.goods,
            data: {
                id: goods_id
            },
            success: function (res) {
                if (res.code == 0) {
                    self.setData({
                        data: data,
                        attr_group_list: res.data.attr_group_list,
                        goods: res.data,
                        showModal: true
                    });
                }
            }
        });
    },




    receive: function (e) {
        var self = this;
        var id = e.currentTarget.dataset.index;
        getApp().core.showLoading({
            title: '领取中',
            mask: true,
        });
        if (!self.hideGetCoupon) {
           self.hideGetCoupon = function (e) {
               var url = e.currentTarget.dataset.url || false;
               self.setData({
                   get_coupon_list: null,
               });
               wx.navigateTo({
                   url: url || '/pages/list/list',
               });
           };
        }
        getApp().request({
            url: getApp().api.coupon.receive,
            data: {
                id: id
            },
            success: function (res) {
                getApp().core.hideLoading();
                if (res.code == 0) {
                    self.setData({
                        get_coupon_list: res.data.list,
                        coupon_list: res.data.coupon_list
                    });
                } else {
                    getApp().core.showToast({
                        title: res.msg,
                        duration: 2000
                    })
                    self.setData({
                        coupon_list: res.data.coupon_list
                    });
                }
            },
            // complete: function () {
            //   getApp().core.hideLoading();
            // }
        });
    },

    closeCouponBox: function (e) {
        this.setData({
            get_coupon_list: ""
        });
    },

    notice: function () {
        var self = this;
        var notice = self.data.notice;
        if (notice === undefined) {
            return;
        }
        var length = notice.length * 14;
        return;
    },
    miaoshaTimer: function () {
        var self = this;
        if(!self.data.miaosha){
            return ;
        }
        if (self.data.miaosha.rest_time == 0){
            return ;
        }
        if (self.data.miaosha.ms_next) {
        } else {
            timer = setInterval(function () {
                if (self.data.miaosha.rest_time > 0) {
                    self.data.miaosha.rest_time = self.data.miaosha.rest_time - 1;
                } else {
                    clearInterval(timer);
                    return;
                }
                self.data.miaosha.times = self.setTimeList(self.data.miaosha.rest_time);
                self.setData({
                    miaosha: self.data.miaosha,
                });
            }, 1000);
        }
    },

    onHide: function () {
        getApp().page.onHide(this);
        this.setData({
            play: -1
        });
        clearInterval(interval);
    },
    onUnload: function () {
        getApp().page.onUnload(this);
        this.setData({
            play: -1
        });
        clearInterval(timer);
        clearInterval(interval);
    },
    showNotice: function () {
        this.setData({
            show_notice: true
        });
    },
    closeNotice: function () {
        this.setData({
            show_notice: false
        });
    },
    
    to_dial: function () {
        var contact_tel = this.data.store.contact_tel;
        getApp().core.makePhoneCall({
            phoneNumber: contact_tel
        })
    },

    closeActModal: function () {
        var self = this;
        var act_modal_list = self.data.act_modal_list;
        var show_next = true;
        var next_i;
        for (var i in act_modal_list) {
            var index = parseInt(i);
            if (act_modal_list[index].show) {
                act_modal_list[index].show = false;
                next_i = index + 1;
                if (typeof act_modal_list[next_i] != 'undefined' && show_next) {
                    show_next = false;
                    setTimeout(function () {
                        self.data.act_modal_list[next_i].show = true;
                        self.setData({
                            act_modal_list: self.data.act_modal_list
                        });
                    }, 500);
                }
            }
        }
        self.setData({
            act_modal_list: act_modal_list,
        });
    },
    naveClick: function (e) {
        var self = this;
        getApp().navigatorClick(e, self);
    },
    play: function (e) {
        this.setData({
            play: e.currentTarget.dataset.index
        });
    },
    onPageScroll: function (e) {
        var self = this;
        if (fullScreen) {
            return;
        }
        if (self.data.play != -1) {
            var max = getApp().core.getSystemInfoSync().windowHeight;
            if (typeof my === 'undefined') {
                getApp().core.createSelectorQuery().select('.video').fields({
                    rect: true
                }, function (res) {
                    if (res.top <= -200 || res.top >= max - 57) {
                        self.setData({
                            play: -1
                        });
                    }
                }).exec();
            } else {
                getApp().core.createSelectorQuery().select('.video').boundingClientRect().scrollOffset().exec((res) => {
                    if (res[0].top <= -200 || res[0].top >= max - 57) {
                        self.setData({
                            play: -1
                        });
                    }
                });
            }
        }
    },
    fullscreenchange: function (e) {
        if (e.detail.fullScreen) {
            fullScreen = true;
        } else {
            fullScreen = false;
        }
    }
});