if (typeof wx === 'undefined') var wx = getApp().core;
var shoppingCart = require('../../../components/shopping_cart/shopping_cart.js');
var specificationsModel = require('../../../components/specifications_model/specifications_model.js');

Page({

    /**
     * 页面的初始数据
     */
    data: {
        quick_list: [],
        goods_list: [],
        carGoods: [], // 购物车数据
        currentGood: {}, //当个商品信息
        checked_attr: [], //已选择的规格
        checkedGood: [], //多规格当前选择的商品
        attr_group_list: [],
        temporaryGood: {
            price: 0.00, // 对应规格的价格
            num: 0,
            use_attr: 1
        },
        check_goods_price: 0.00,
        showModal: false,
        checked: false,
        cat_checked: false,
        color: '',
        total: {
            total_price: 0.00,
            total_num: 0
        }
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        getApp().page.onLoad(this, options);
    },

    onShow: function() {
        getApp().page.onShow(this);
        shoppingCart.init(this);
        specificationsModel.init(this, shoppingCart);
        this.loadData();
    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function() {
        getApp().page.onHide(this);
        shoppingCart.saveItemData(this);
    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function() {
        getApp().page.onUnload(this);
        shoppingCart.saveItemData(this);
    },

    loadData: function(options) {
        var self = this;
        var item = getApp().core.getStorageSync(getApp().const.ITEM);
        var total = {
            total_num: 0,
            total_price: 0.00
        }
        self.setData({
            total: item.total !== undefined ? item.total : total,
            carGoods: item.carGoods !== undefined ? item.carGoods : []
        })
        getApp().core.showLoading({
            title: '加载中',
        })
        getApp().request({
            url: getApp().api.quick.quick,
            success: function(res) {
                getApp().core.hideLoading()
                if (res.code == 0) {
                    var list = res.data.list;
                    var quick_hot_goods_lists = [];
                    var quick_list = [];
                    for (var i in list) {
                        // 判断该分类下是否有商品
                        if (list[i].goods.length > 0) {
                            quick_list.push(list[i])
                            for (var i2 in list[i].goods) {
                                //将商品已选择的数量 回存
                                var carGoods = self.data.carGoods;
                                for (var j in carGoods) {
                                    if (item.carGoods[j].goods_id === parseInt(list[i].goods[i2].id)) {
                                        list[i].goods[i2].num = list[i].goods[i2].num ? list[i].goods[i2].num : 0
                                        list[i].goods[i2].num += item.carGoods[j].num
                                    }
                                }
                                // 取出热销商品
                                if (parseInt(list[i].goods[i2].hot_cakes)) {
                                    quick_hot_goods_lists.push(list[i].goods[i2])
                                }
                            }
                        }
                    }

                    self.setData({
                        quick_hot_goods_lists: quick_hot_goods_lists,
                        quick_list: quick_list,
                    });
                }
            }
        });
    },
    // 商品详情
    get_goods_info: function(e) {
        var self = this;
        var carGoods = self.data.carGoods;
        var total = self.data.total;
        var quick_hot_goods_lists = self.data.quick_hot_goods_lists;
        var quick_list = self.data.quick_list;
        var check_num = self.data.check_num;
        var item = {
            "carGoods": carGoods,
            "total": total,
            "quick_hot_goods_lists": quick_hot_goods_lists,
            "check_num": check_num,
            "quick_list": quick_list
        };
        getApp().core.setStorageSync(getApp().const.ITEM, item)
        var data = e.currentTarget.dataset;
        var goods_id = data.id;
        getApp().core.navigateTo({
            url: '/pages/goods/goods?id=' + goods_id + '&quick=1'
        })
    },

    // 商品定位
    selectMenu: function(event) {
        var data = event.currentTarget.dataset
        var quick_list = this.data.quick_list;
        if (data.tag == 'hot_cakes') {
            var cat_checked = true;
            var quick_list_length = quick_list.length;
            for (var a = 0; a < quick_list_length; a++) {
                quick_list[a]['cat_checked'] = false;
            }
        } else {
            var index = data.index;
            var quick_list_length = quick_list.length;
            for (var a = 0; a < quick_list_length; a++) {
                quick_list[a]['cat_checked'] = false;
                if (quick_list[a]['id'] == quick_list[index]['id']) {
                    quick_list[a]['cat_checked'] = true;
                }
            }
            cat_checked = false;
        }
        this.setData({
            toView: data.tag,
            quick_list: quick_list,
            cat_checked: cat_checked
        })
    },
    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function(options) {
        getApp().page.onShareAppMessage(this);
        var self = this;
        var user_info = getApp().core.getStorageSync(getApp().const.USER_INFO);
        return {
            path: "/pages/quick-purchase/index/index?user_id=" + user_info.id,
            success: function(e) {
                share_count++;
                if (share_count == 1)
                    self.shareSendCoupon(self);
            }
        };
    },
    
    /**
     * 隐藏模态对话框
     */
    close_box: function(e) {
        this.setData({
            showModal: false,
        });
    },
    hideModal: function() {
        this.setData({
            showModal: false
        });
    },


    buynow: function(e) {
        var self = this;
        var carGoods = self.data.carGoods;
        var goodsModel = self.data.goodsModel;
        self.setData({
            goodsModel: false
        });

        var length = carGoods.length;
        var cart_list = [];
        var cart_list_goods = [];
        for (var a = 0; a < length; a++) {
            if (carGoods[a].num != 0) {
                cart_list_goods = {
                    'goods_id': carGoods[a].goods_id,
                    'num': carGoods[a].num,
                    'attr': carGoods[a].attr
                }
                cart_list.push(cart_list_goods)
            }
        }

        var mch_list = [];
        mch_list.push({
            mch_id: 0,
            goods_list: cart_list
        });
        getApp().core.navigateTo({
            url: '/pages/new-order-submit/new-order-submit?mch_list=' + JSON.stringify(mch_list),
        });
        
        shoppingCart.clearShoppingCart();
    },
});