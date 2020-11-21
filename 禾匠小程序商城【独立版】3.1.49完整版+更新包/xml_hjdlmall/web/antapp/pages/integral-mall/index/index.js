if (typeof wx === 'undefined') var wx = getApp().core;
// pages/integral-mall/index/index.js
var integral_catId = 0;
var integral_index = -1;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) { getApp().page.onLoad(this, options);
        getApp().page.onLoad(this, options);
        getApp().core.showLoading({
            title: '加载中',
        })
    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function (options) { getApp().page.onReady(this);
        getApp().page.onReady(this);
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function (options) { getApp().page.onShow(this);
        getApp().page.onShow(this);
        var self = this;
        getApp().request({ 
            url: getApp().api.integral.index,
            data: {
                page:1
            },
            success: function (res) {
                if(res.code == 0){
                    var index_goods = [];
                    var goods_list = res.data.goods_list;
                    var goods_lists = [];
                    if (goods_list){
                        for (var i in goods_list) {
                            if (goods_list[i].goods.length > 0) {
                                goods_lists.push(goods_list[i])
                            }
                        }
                    }
                    if (goods_lists.length > 0) {
                        for (var x in goods_lists){
                            var goods = goods_lists[x].goods;
                            for (var z in goods) {
                                if (goods[z].is_index == 1) {
                                    index_goods.push(goods[z])
                                }
                            }
                        }
                    }
                    if (res.data.today) {
                        self.setData({
                            register_day: 1,
                        });
                    }
                    self.setData({
                        banner_list: res.data.banner_list,
                        coupon_list: res.data.coupon_list,
                        goods_list: goods_lists,
                        index_goods: index_goods,
                        integral: res.data.user.integral,
                    });

                    if(integral_index != -1){
                        var data = [];
                        data['index'] = integral_index;
                        data['catId'] = integral_catId;
                        self.catGoods({'currentTarget':{'dataset':data}});
                    }
                }
            },
            complete:function(e){
                getApp().core.hideLoading();
            }
        });
    },

    exchangeCoupon:function(e){
        var self = this;
        var coupon_list = self.data.coupon_list;
        var index = e.currentTarget.dataset.index;
        var coupon = coupon_list[index];
        var integral = self.data.integral;
        if (parseInt(coupon.integral) > parseInt(integral)){
            self.setData({
                showModel:true,
                content: '当前积分不足',
                status:1,
            });
        }else{
            if (parseFloat(coupon.price) > 0) {
                var content = '需要' + coupon.integral + '积分' + '+￥' + parseFloat(coupon.price)
            } else {
                var content = '需要' + coupon.integral + '积分'
            }
            if (parseInt(coupon.total_num) <= 0){
                self.setData({
                    showModel: true,
                    content: '已领完,来晚一步',
                    status: 1,
                });
                return 
            }
            if (parseInt(coupon.num) >= parseInt(coupon.user_num)){
                coupon.type = 1;
                self.setData({
                    showModel: true,
                    content:'兑换次数已达上限',
                    status: 1,
                    coupon_list: coupon_list
                });
                return 
            }
            getApp().core.showModal({
                title: '确认兑换',
                content: content,
                success: function (e) {
                    if (e.confirm) {
                        if (parseFloat(coupon.price) > 0){
                            getApp().core.showLoading({
                                title: '提交中',
                            });
                            getApp().request({
                                url: getApp().integral.exchange_coupon,
                                data: {
                                    id: coupon.id,
                                    type: 2
                                },
                                success: function (res) {
                                    if (res.code == 0) {
                                        getApp().core.requestPayment({
                                            _res: res,
                                            timeStamp: res.data.timeStamp,
                                            nonceStr: res.data.nonceStr,
                                            package: res.data.package,
                                            signType: res.data.signType,
                                            paySign: res.data.paySign,
                                            complete: function (e) {
                                                if (e.errMsg == "requestPayment:fail" || e.errMsg == "requestPayment:fail cancel") {
                                                    getApp().core.showModal({
                                                        title: "提示",
                                                        content: "订单尚未支付",
                                                        showCancel: false,
                                                        confirmText: "确认",
                                                    });
                                                    return;
                                                }
                                                if (e.errMsg == "requestPayment:ok") {
                                                    coupon.num = parseInt(coupon.num)
                                                    coupon.num += 1;
                                                    coupon.total_num = parseInt(coupon.total_num)
                                                    coupon.total_num -= 1;
                                                    integral = parseInt(integral)
                                                    integral -= parseInt(coupon.integral)
                                                    self.setData({
                                                        showModel: true,
                                                        status: 4,
                                                        content: res.msg,
                                                        coupon_list: coupon_list,
                                                        integral: integral
                                                    });
                                                }
                                            },
                                        });
                                    }
                                },
                                complete: function () {
                                    getApp().core.hideLoading();
                                }
                            });
                        }else{
                            getApp().core.showLoading({
                                title: '提交中',
                            });
                            getApp().request({
                                url: getApp().api.integral.exchange_coupon,
                                data: {
                                    id: coupon.id,
                                    type:1
                                },
                                success: function (res) {
                                    if(res.code == 0){
                                        coupon.num = parseInt(coupon.num)
                                        coupon.num += 1;
                                        coupon.total_num = parseInt(coupon.total_num)
                                        coupon.total_num -= 1;
                                        integral = parseInt(integral)
                                        integral -= parseInt(coupon.integral)
                                        self.setData({
                                            showModel: true,
                                            status: 4,
                                            content:res.msg,
                                            coupon_list: coupon_list,
                                            integral: integral
                                        });
                                    }
                                },
                                complete: function () {
                                    getApp().core.hideLoading();
                                }
                            });
                        }
                    }
                }
            })
        }
    },
    hideModal: function () {
        this.setData({
            showModel: false
        });
    },
    couponInfo: function (e) {
        var data = e.currentTarget.dataset;
        getApp().core.navigateTo({
            url: '/pages/integral-mall/coupon-info/index?coupon_id=' + data.id
        })
    },

    goodsAll:function(){
        var self = this;
        var goods_list = self.data.goods_list;
        var goodsAll = [];
        for (var i in goods_list){
            var goods = goods_list[i].goods;
            goods_list[i].cat_checked = false;
            for (var x in goods) {
                goodsAll.push(goods[x])
            }
        }
        self.setData({
            index_goods: goodsAll,
            cat_checked: true,
            goods_list: goods_list
        });
    },
    catGoods:function(e){
        var data = e.currentTarget.dataset;
        var self = this;
        var goods_list = self.data.goods_list;
        var cat_goods = goods_list.find(function (v) {
            return v.id == data.catId
        })
        integral_catId = data.catId;
        integral_index = data.index;
        var index = data.index;
        for (var i in goods_list) {
            if (goods_list[i]['id'] == goods_list[index]['id']) {
                goods_list[i]['cat_checked'] = true;
            } else {
                goods_list[i]['cat_checked'] = false;
            }
        }
        self.setData({
            index_goods: cat_goods.goods,
            goods_list: goods_list,
            cat_checked: false
        });
    },

    goodsInfo:function(e){
        var goods_id = e.currentTarget.dataset.goodsId;
        var self = this;
        getApp().core.navigateTo({
            url: '/pages/integral-mall/goods-info/index?goods_id=' + goods_id + '&integral='+self.data.integral
        })
    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function (options) { getApp().page.onHide(this);
        getApp().page.onHide(this);
    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function (options) { getApp().page.onUnload(this);
        getApp().page.onUnload(this);
    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function (options) { getApp().page.onPullDownRefresh(this);
        getApp().page.onPullDownRefresh(this);
    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function (options) { getApp().page.onReachBottom(this);
        getApp().page.onReachBottom(this);
    },

    shuoming: function () {
        getApp().core.navigateTo({
            url: '/pages/integral-mall/shuoming/index',
        })
    },
    detail: function () {
        getApp().core.navigateTo({
            url: '/pages/integral-mall/detail/index',
        })
    },
    exchange: function () {
        getApp().core.navigateTo({
            url: '/pages/integral-mall/exchange/index',
        })
    },
    register: function () {
        getApp().core.navigateTo({
            url: '/pages/integral-mall/register/index',
        })
    },
})