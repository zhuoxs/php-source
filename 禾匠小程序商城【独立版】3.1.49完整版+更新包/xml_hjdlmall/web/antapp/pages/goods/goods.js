if (typeof wx === 'undefined') var wx = getApp().core;
var WxParse = require('../../wxParse/wxParse.js');
var shoppingCart = require('../../components/shopping_cart/shopping_cart.js');
var specificationsModel = require('../../components/specifications_model/specifications_model.js'); //快速购买多规格
var gSpecificationsModel = require('../../components/goods/specifications_model.js'); //商城多规格选择
var quickNavigation = require('../../components/quick-navigation/quick-navigation.js');
var goodsBanner = require('../../components/goods/goods_banner.js');
var p = 1;
var is_loading_comment = false;
var is_more_comment = true;
var share_count = 0;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        pageType: 'STORE', //模块页面标识
        id: null,
        goods: {},
        show_attr_picker: false,
        form: {
            number: 1,
        },
        tab_detail: "active",
        tab_comment: "",
        comment_list: [],
        comment_count: {
            score_all: 0,
            score_3: 0,
            score_2: 0,
            score_1: 0,
        },
        autoplay: false,
        hide: "hide",
        show: false,
        x: getApp().core.getSystemInfoSync().windowWidth,
        y: getApp().core.getSystemInfoSync().windowHeight - 20,
        page: 1,
        drop: false,
        goodsModel: false,
        goods_num: 0,
        temporaryGood: {
            price: 0.00, // 对应规格的价格
            num: 0,
            use_attr: 1
        },
        goodNumCount: 0,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function(options) {
        getApp().page.onLoad(this, options);
        quickNavigation.init(this);

        var self = this;
        share_count = 0;
        p = 1;
        is_loading_comment = false;
        is_more_comment = true;
        var quick = options.quick;
        if (quick) {
            var item = getApp().core.getStorageSync(getApp().const.ITEM);
            if (item) {
                var total = item.total;
                var carGoods = item.carGoods;
            } else {
                var total = {
                    total_price: 0.00,
                    total_num: 0
                }
                var carGoods = [];
            }
            self.setData({
                quick: quick,
                quick_list: item.quick_list,
                total: total,
                carGoods: carGoods,
                quick_hot_goods_lists: item.quick_hot_goods_lists,
            });
        }
        if (typeof my === 'undefined') {
            var scene = decodeURIComponent(options.scene);
            if (typeof scene !== 'undefined') {
                var scene_obj = getApp().helper.scene_decode(scene);
                if (scene_obj.uid && scene_obj.gid) {
                    options.id = scene_obj.gid;
                }
            }
        } else {
            if (getApp().query !== null) {
                var query = app.query;
                getApp().query = null;
                options.id = query.gid;
            }
        }


        self.setData({
            id: options.id,
        });
        self.getGoods();
        self.getCommentList();
    },
    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function() {
        getApp().page.onReady(this);
    },

    kfMessage: function() {
        let store = getApp().core.getStorageSync(getApp().const.STORE);
        if (!store.show_customer_service) {
            getApp().core.showToast({
                title: "未启用客服功能",
            });
        }

    },
    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function() {
        getApp().page.onShow(this);
        shoppingCart.init(this);
        specificationsModel.init(this, shoppingCart);
        gSpecificationsModel.init(this);
        goodsBanner.init(this);

        var self = this;
        var item = getApp().core.getStorageSync(getApp().const.ITEM);
        if (item) {
            var total = item.total;
            var carGoods = item.carGoods;
            var goods_num = self.data.goods_num;
        } else {
            var total = {
                total_price: 0.00,
                total_num: 0
            }
            var carGoods = [];
            var goods_num = 0;
        }
        self.setData({
            total: total,
            carGoods: carGoods,
            goods_num: goods_num
        });
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

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function() {
        getApp().page.onPullDownRefresh(this);
    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function() {
        getApp().page.onReachBottom(this);
        var self = this;
        if (self.data.tab_detail == 'active' && self.data.drop) {
            self.data.drop = false;
            self.goods_recommend({
                'goods_id': self.data.goods.id,
                'loadmore': true
            });

        } else if (self.data.tab_comment == 'active') {
            self.getCommentList(true);
        }

    },

    /**
     * 用户点击右上角分享
     */
    onShareAppMessage: function() {
        getApp().page.onShareAppMessage(this);
        var self = this;
        var user_info = getApp().getUser();
        var res = {
            path: "/pages/goods/goods?id=" + this.data.id + "&user_id=" + user_info.id,
            success: function(e) {
                share_count++;
                if (share_count == 1)
                    self.shareSendCoupon(self);
            },
            title: self.data.goods.name,
            imageUrl: self.data.goods.pic_list[0].pic_url,
        };
        return res;
    },
    play: function(e) {
        var url = e.target.dataset.url; //获取视频链接
        this.setData({
            url: url,
            hide: '',
            show: true,
        });
        var videoContext = getApp().core.createVideoContext('video');
        videoContext.play();
    },

    close: function(e) {
        if (e.target.id == 'video') {
            return true;
        }
        this.setData({
            hide: "hide",
            show: false
        });
        var videoContext = getApp().core.createVideoContext('video');
        videoContext.pause();
    },
    hide: function(e) {
        if (e.detail.current == 0) {
            this.setData({
                img_hide: ""
            });
        } else {
            this.setData({
                img_hide: "hide"
            });
        }
    },

    showShareModal: function() {
        var self = this;
        self.setData({
            share_modal_active: "active",
            no_scroll: true,
        });
    },

    shareModalClose: function() {
        var self = this;
        self.setData({
            share_modal_active: "",
            no_scroll: false,
        });
    },

    getGoodsQrcode: function() {
        var self = this;
        self.setData({
            goods_qrcode_active: "active",
            share_modal_active: "",
        });
        if (self.data.goods_qrcode)
            return true;
        getApp().request({
            url: getApp().api.default.goods_qrcode,
            data: {
                goods_id: self.data.id,
            },
            success: function(res) {
                if (res.code == 0) {
                    self.setData({
                        goods_qrcode: res.data.pic_url,
                    });
                }
                if (res.code == 1) {
                    self.goodsQrcodeClose();
                    getApp().core.showModal({
                        title: "提示",
                        content: res.msg,
                        showCancel: false,
                        success: function(res) {
                            if (res.confirm) {

                            }
                        }
                    });
                }
            },
        });
    },

    goodsQrcodeClose: function() {
        var self = this;
        self.setData({
            goods_qrcode_active: "",
            no_scroll: false,
        });
    },

    saveGoodsQrcode: function() {
        var self = this;
        if (!getApp().core.saveImageToPhotosAlbum) {
            // 如果希望用户在最新版本的客户端上体验您的小程序，可以这样子提示
            getApp().core.showModal({
                title: '提示',
                content: '当前版本过低，无法使用该功能，请升级到最新版本后重试。',
                showCancel: false,
            });
            return;
        }

        getApp().core.showLoading({
            title: "正在保存图片",
            mask: false,
        });

        getApp().core.downloadFile({
            url: self.data.goods_qrcode,
            success: function(e) {
                getApp().core.showLoading({
                    title: "正在保存图片",
                    mask: false,
                });
                getApp().core.saveImageToPhotosAlbum({
                    filePath: e.tempFilePath,
                    success: function() {
                        getApp().core.showModal({
                            title: '提示',
                            content: '商品海报保存成功',
                            showCancel: false,
                        });
                    },
                    fail: function(e) {
                        getApp().core.showModal({
                            title: '图片保存失败',
                            content: e.errMsg,
                            showCancel: false,
                        });
                    },
                    complete: function(e) {
                        getApp().core.hideLoading();
                    }
                });
            },
            fail: function(e) {
                getApp().core.showModal({
                    title: '图片下载失败',
                    content: e.errMsg + ";" + self.data.goods_qrcode,
                    showCancel: false,
                });
            },
            complete: function(e) {
                getApp().core.hideLoading();
            }
        });

    },

    closeCouponBox: function(e) {
        this.setData({
            get_coupon_list: ""
        });
    },

    to_dial: function(e) {
        var contact_tel = this.data.store.contact_tel;
        getApp().core.makePhoneCall({
            phoneNumber: contact_tel
        })
    },

    goods_recommend: function(args) {
        var self = this;
        self.setData({
            is_loading: true,
        });

        var p = self.data.page || 2;
        getApp().request({
            url: getApp().api.default.goods_recommend,
            data: {
                goods_id: args.goods_id,
                page: p,
            },
            success: function(res) {

                if (res.code == 0) {
                    if (args.reload) {
                        var goods_list = res.data.list;
                    };
                    if (args.loadmore) {
                        var goods_list = self.data.goods_list.concat(res.data.list);
                    };
                    self.data.drop = true;
                    self.setData({
                        goods_list: goods_list
                    })
                    self.setData({
                        page: (p + 1)
                    });
                };

            },
            complete: function() {
                self.setData({
                    is_loading: false,
                });
            }
        });
    },


    getGoods: function() {
        var self = this;
        var quick = self.data.quick;
        if (quick) {
            var carGoods = self.data.carGoods;
            if (carGoods) {
                var length = carGoods.length;
                var goods_num = 0;
                for (var i = 0; i < length; i++) {
                    if (carGoods[i].goods_id == self.data.id) {
                        goods_num += parseInt(carGoods[i].num);
                    }
                }
                self.setData({
                    goods_num: goods_num
                });
            }
        }
        getApp().request({
            url: getApp().api.default.goods,
            data: {
                id: self.data.id
            },
            success: function(res) {
                if (res.code == 0) {
                    var detail = res.data.detail;
                    WxParse.wxParse("detail", "html", detail, self);
                    var goods = res.data;
                    goods.attr_pic = res.data.attr_pic;
                    goods.cover_pic = res.data.pic_list[0].pic_url;

                    var goodsList = goods.pic_list;
                    var pic_list = [];
                    for (var i in goodsList) {
                        pic_list.push(goodsList[i].pic_url);
                    }
                    goods.pic_list = pic_list;

                    self.setData({
                        goods: goods,
                        attr_group_list: res.data.attr_group_list,
                        btn: true
                    });

                    self.goods_recommend({
                        'goods_id': res.data.id,
                        'reload': true,
                    });
                    self.selectDefaultAttr();
                }
                if (res.code == 1) {
                    getApp().core.showModal({
                        title: "提示",
                        content: res.msg,
                        showCancel: false,
                        success: function(res) {
                            if (res.confirm) {
                                getApp().core.switchTab({
                                    url: "/pages/index/index"
                                });
                            }
                        }
                    });
                }
            }
        });
    },

    callPhone: function(e) {
        getApp().core.makePhoneCall({
            phoneNumber: e.target.dataset.info
        })
    },

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
                    goods_id: carGoods[a].goods_id,
                    num: carGoods[a].num,
                    attr: carGoods[a].attr
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
    },

    selectDefaultAttr: function() {
        var self = this;
        if (!self.data.goods || self.data.goods.use_attr !== 0)
            return;
        for (var i in self.data.attr_group_list) {
            for (var j in self.data.attr_group_list[i].attr_list) {
                if (i == 0 && j == 0)
                    self.data.attr_group_list[i].attr_list[j]['checked'] = true;
            }
        }
        self.setData({
            attr_group_list: self.data.attr_group_list,
        });
    },
    getCommentList: function(more) {
        var self = this;
        if (more && self.data.tab_comment != "active")
            return;
        if (is_loading_comment)
            return;
        if (!is_more_comment)
            return;
        is_loading_comment = true;
        getApp().request({
            url: getApp().api.default.comment_list,
            data: {
                goods_id: self.data.id,
                page: p,
            },
            success: function(res) {
                if (res.code != 0)
                    return;
                is_loading_comment = false;
                p++;
                self.setData({
                    comment_count: res.data.comment_count,
                    comment_list: more ? self.data.comment_list.concat(res.data.list) : res.data.list,
                });
                if (res.data.list.length == 0)
                    is_more_comment = false;
            }
        });
    },

    addCart: function() {
        if (this.data.btn) {
            this.submit('ADD_CART');
        }

    },

    buyNow: function() {
        if (this.data.btn) {
            this.submit('BUY_NOW');
        }

    },

    submit: function(type) {
        var self = this;
        if (!self.data.show_attr_picker) {
            self.setData({
                show_attr_picker: true,
            });
            return true;
        }
        if (self.data.miaosha_data && self.data.miaosha_data.rest_num > 0 && self.data.form.number > self.data.miaosha_data.rest_num) {
            getApp().core.showToast({
                title: "商品库存不足，请选择其它规格或数量",
                image: "/images/icon-warning.png",
            });
            return true;
        }

        if (self.data.form.number > self.data.goods.num) {
            getApp().core.showToast({
                title: "商品库存不足，请选择其它规格或数量",
                image: "/images/icon-warning.png",
            });
            return true;
        }
        var attr_group_list = self.data.attr_group_list;
        var checked_attr_list = [];
        for (var i in attr_group_list) {
            var attr = false;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    attr = {
                        attr_id: attr_group_list[i].attr_list[j].attr_id,
                        attr_name: attr_group_list[i].attr_list[j].attr_name,
                    };
                    break;
                }
            }
            if (!attr) {
                getApp().core.showToast({
                    title: "请选择" + attr_group_list[i].attr_group_name,
                    image: "/images/icon-warning.png",
                });
                return true;
            } else {
                checked_attr_list.push({
                    attr_group_id: attr_group_list[i].attr_group_id,
                    attr_group_name: attr_group_list[i].attr_group_name,
                    attr_id: attr.attr_id,
                    attr_name: attr.attr_name,
                });
            }
        }
        if (type == 'ADD_CART') { //加入购物车
            getApp().core.showLoading({
                title: "正在提交",
                mask: true,
            });
            getApp().request({
                url: getApp().api.cart.add_cart,
                method: "POST",
                data: {
                    goods_id: self.data.id,
                    attr: JSON.stringify(checked_attr_list),
                    num: self.data.form.number,
                },
                success: function(res) {
                    getApp().core.hideLoading();
                    getApp().core.showToast({
                        title: res.msg,
                        duration: 1500
                    });
                    self.setData({
                        show_attr_picker: false,
                    });

                }
            });
        }
        if (type == 'BUY_NOW') { //立即购买
            self.setData({
                show_attr_picker: false,
            });
            var goods_list = [];
            goods_list.push({
                goods_id: self.data.id,
                num: self.data.form.number,
                attr: checked_attr_list
            });
            var goods = self.data.goods;
            var mch_id = 0;
            if (goods.mch != null) {
                mch_id = goods.mch.id
            }
            var mch_list = [];
            mch_list.push({
                mch_id: mch_id,
                goods_list: goods_list
            });
            getApp().core.redirectTo({
                url: "/pages/new-order-submit/new-order-submit?mch_list=" + JSON.stringify(mch_list),
            });
        }

    },


    favoriteAdd: function() {
        var self = this;
        getApp().request({
            url: getApp().api.user.favorite_add,
            method: "post",
            data: {
                goods_id: self.data.goods.id,
            },
            success: function(res) {
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.is_favorite = 1;
                    self.setData({
                        goods: goods,
                    });
                }
            }
        });
    },

    favoriteRemove: function() {
        var self = this;
        getApp().request({
            url: getApp().api.user.favorite_remove,
            method: "post",
            data: {
                goods_id: self.data.goods.id,
            },
            success: function(res) {
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.is_favorite = 0;
                    self.setData({
                        goods: goods,
                    });
                }
            }
        });
    },

    tabSwitch: function(e) {
        var self = this;
        var tab = e.currentTarget.dataset.tab;
        if (tab == "detail") {
            self.setData({
                tab_detail: "active",
                tab_comment: "",
            });
        } else {
            self.setData({
                tab_detail: "",
                tab_comment: "active",
            });
        }
    },
    commentPicView: function(e) {
        var self = this;
        var index = e.currentTarget.dataset.index;
        var pic_index = e.currentTarget.dataset.picIndex;
        getApp().core.previewImage({
            current: self.data.comment_list[index].pic_list[pic_index],
            urls: self.data.comment_list[index].pic_list,
        });
    },

});