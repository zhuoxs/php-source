if (typeof wx === 'undefined') var wx = getApp().core;
module.exports = {
    currentPage: null,
    /**
     * 注意！注意！！注意！！！
     * 由于组件的通用，部分变量名称需统一，在各自引用的xxx.js文件需定义，并给对应变量赋相应的值
     * 以下变量必须定义并赋值
     * 
     * pageType     标识从哪个模块引用的
     * goods         商品信息
     * goods.attr_pic    规格相应图片
     * goods.cover_pic   没有规格图片展示商品默认图片
     * goods.price      商品价格
     * goods.num        商品库存
     * attr_group_list  商品规格、包含规格组、规格
     * 持续补充...
     */
    init: function(self) {
        var _this = this;
        _this.currentPage = self;

        if (typeof self.previewImage === 'undefined') {
            self.previewImage = function(e) {
                _this.previewImage(e);
            }
        }
        if (typeof self.showAttrPicker === 'undefined') {
            self.showAttrPicker = function(e) {
                _this.showAttrPicker(e);
            }
        }
        if (typeof self.hideAttrPicker === 'undefined') {
            self.hideAttrPicker = function(e) {
                _this.hideAttrPicker(e);
            }
        }
        if (typeof self.storeAttrClick === 'undefined') {
            self.storeAttrClick = function(e) {
                _this.storeAttrClick(e);
            }
        }
        if (typeof self.numberAdd === 'undefined') {
            self.numberAdd = function(e) {
                _this.numberAdd(e);
            }
        }
        if (typeof self.numberSub === 'undefined') {
            self.numberSub = function(e) {
                _this.numberSub(e);
            }
        }
        if (typeof self.numberBlur === 'undefined') {
            self.numberBlur = function(e) {
                _this.numberBlur(e);
            }
        }
    },

    previewImage: function(e) {
        // TODO 商城的路径不是这个
        var urls = e.currentTarget.dataset.url;
        getApp().core.previewImage({
            urls: [urls]
        });
    },

    /**
     * 隐藏规格选择框
     */
    hideAttrPicker: function() {
        var self = this.currentPage;
        self.setData({
            show_attr_picker: false,
        });
    },
    /**
     * 显示规格选择框
     */
    showAttrPicker: function() {
        var self = this.currentPage;
        self.setData({
            show_attr_picker: true,
        });
    },

    groupCheck: function() {
        var self = this;
        var attr_group_num = self.data.attr_group_num;
        var attr_list = self.data.attr_group_num.attr_list;
        for (var i in attr_list) {
            attr_list[i].checked = false;
        }
        attr_group_num.attr_list = attr_list;

        var goods = self.data.goods;
        self.setData({
            group_checked: 0,
            attr_group_num: attr_group_num,
        });

        var attr_group_list = self.data.attr_group_list;
        var check_attr_list = [];
        var check_all = true;
        for (var i in attr_group_list) {
            var group_checked = false;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    check_attr_list.push(attr_group_list[i].attr_list[j].attr_id);
                    group_checked = true;
                    break;
                }
            }
            if (!group_checked) {
                check_all = false;
                break;
            }
        }
        if (!check_all)
            return;
        getApp().core.showLoading({
            title: "正在加载",
            mask: true,
        });

        getApp().request({
            url: getApp().api.group.goods_attr_info,
            data: {
                goods_id: self.data.goods.id,
                group_id: self.data.group_checked,
                attr_list: JSON.stringify(check_attr_list),
            },
            success: function(res) {
                getApp().core.hideLoading();
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.price = res.data.price;
                    goods.num = res.data.num;
                    goods.attr_pic = res.data.pic;
                    goods.original_price = res.data.single;

                    self.setData({
                        goods: goods,
                    });
                }
            }
        });
    },

    attrNumClick: function(e) {
        var self = this.currentPage;
        var attr_id = e.target.dataset.id;

        var attr_group_num = self.data.attr_group_num;
        var attr_list = attr_group_num.attr_list;

        for (var i in attr_list) {
            if (attr_list[i].id == attr_id) {
                attr_list[i].checked = true;
            } else {
                attr_list[i].checked = false;
            }
        }
        attr_group_num.attr_list = attr_list;

        self.setData({
            attr_group_num: attr_group_num,
            group_checked: attr_id,
        });

        var attr_group_list = self.data.attr_group_list;
        var check_attr_list = [];
        var check_all = true;
        for (var i in attr_group_list) {
            var group_checked = false;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    check_attr_list.push(attr_group_list[i].attr_list[j].attr_id);
                    group_checked = true;
                    break;
                }
            }
            if (!group_checked) {
                check_all = false;
                break;
            }
        }
        if (!check_all)
            return;
        getApp().core.showLoading({
            title: "正在加载",
            mask: true,
        });

        getApp().request({
            url: getApp().api.group.goods_attr_info,
            data: {
                goods_id: self.data.goods.id,
                group_id: self.data.group_checked,
                attr_list: JSON.stringify(check_attr_list),
            },
            success: function(res) {
                getApp().core.hideLoading();
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.price = res.data.price;
                    goods.num = res.data.num;
                    goods.attr_pic = res.data.pic;
                    goods.original_price = res.data.single;
                    self.setData({
                        goods: goods,
                    });
                }
            }
        });

    },

    /**
     * 选择规格
     */
    storeAttrClick: function(e) {
        var self = this.currentPage;
        var _this = this;
        var attr_group_id = e.target.dataset.groupId;
        var attr_id = parseInt(e.target.dataset.id);
        var attr_group_list = self.data.attr_group_list;
        var attrs = self.data.goods.attr;
        if (typeof attrs == 'string') {
            attrs = JSON.parse(attrs);
        }

        for (var i in attr_group_list) {
            if (attr_group_list[i].attr_group_id != attr_group_id) {
                continue;
            }

            for (var j in attr_group_list[i].attr_list) {
                var aGList = attr_group_list[i].attr_list[j];
                if (parseInt(aGList.attr_id) === attr_id && aGList.checked) {
                    aGList.checked = false;
                } else {
                    aGList.checked = parseInt(aGList.attr_id) === attr_id;
                }

                if (aGList.attr_id === attr_id && aGList.attr_num_0) {
                    aGList.checked = false;
                    return;
                }
            }
        }
        // 无库存规格样式 start
        var attrNum_0 = [];
        for (var i in attrs) {
            if (attrs[i].num === 0) {
                var arr = [];
                for (var i2 in attrs[i].attr_list) {
                    arr.push(attrs[i].attr_list[i2].attr_id);
                }
                attrNum_0.push(arr)
            }
        }

        var checkedAttr = [];
        for (var i in attr_group_list) {
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    checkedAttr.push(attr_group_list[i].attr_list[j].attr_id)
                }
            }
        }

        var newAttrNum_0 = [];
        for (var i in checkedAttr) {
            for (var j in attrNum_0) {
                if (getApp().helper.inArray(checkedAttr[i], attrNum_0[j])) {
                    for (var k in attrNum_0[j]) {
                        if (attrNum_0[j][k] !== checkedAttr[i]) {
                            newAttrNum_0.push(attrNum_0[j][k])
                        }
                    }
                }
            }
        }

        //库存为0的规格添加标识
        for (var i in attr_group_list) {
            for (var j in attr_group_list[i].attr_list) {
                var cAttr = attr_group_list[i].attr_list[j];
                cAttr.attr_num_0 = getApp().helper.inArray(cAttr.attr_id, newAttrNum_0);
            }
        }

        self.setData({
            attr_group_list: attr_group_list,
        });

        var check_attr_list = [];
        var check_all = true;
        for (var i in attr_group_list) {
            var group_checked = false;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    //积分商城
                    if (self.data.pageType === 'INTEGRAL') {
                        var attrs = {
                            'attr_id': attr_group_list[i].attr_list[j].attr_id,
                            'attr_name': attr_group_list[i].attr_list[j].attr_name
                        }
                        check_attr_list.push(attrs);

                    } else {
                        check_attr_list.push(attr_group_list[i].attr_list[j].attr_id);
                        group_checked = true;
                        break;

                    }
                }
            }
            // TODO ..
            if (self.data.pageType !== 'INTEGRAL' && !group_checked) {
                check_all = false;
                break;
            }
        }

        // TODO ..
        if (self.data.pageType !== 'INTEGRAL' && !check_all) {
            return;
        }

        getApp().core.showLoading({
            title: "正在加载",
            mask: true,
        });

        //不同模块页面请求接口不同
        var pageType = self.data.pageType;
        if (pageType === 'STORE') {
            var httpUrl = getApp().api.default.goods_attr_info;

        } else if (pageType === 'PINTUAN') {
            var httpUrl = getApp().api.group.goods_attr_info;

        } else if (pageType === 'INTEGRAL') {
            getApp().core.hideLoading();
            _this.integralMallAttrClick(check_attr_list);
            return;

        } else if (pageType === 'BOOK') {
            getApp().core.hideLoading();
            _this.bookAttrGoodsClick(check_attr_list);
            return;
        } else if (pageType === 'MIAOSHA') {
            var httpUrl = getApp().api.default.goods_attr_info;
        } else {
            getApp().core.showModal({
                title: '提示',
                content: 'pageType变量未定义或变量值不是预期的',
            });
            getApp().core.hideLoading();
            return;

        }

        getApp().request({
            url: httpUrl,
            data: {
                goods_id: pageType === 'MIAOSHA' ? self.data.id : self.data.goods.id,
                group_id: self.data.group_checked, // TODO 商城没有该字段
                attr_list: JSON.stringify(check_attr_list),
                type: pageType === 'MIAOSHA' ? 'ms' : ''
            },
            success: function(res) {
                getApp().core.hideLoading();
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.price = res.data.price;
                    goods.num = res.data.num;
                    goods.attr_pic = res.data.pic;
                    goods.original_price = res.data.single; // TODO 商城没有该字段

                    if (pageType === 'MIAOSHA') {
                        var miaosha = res.data.miaosha;
                        goods.price = miaosha.miaosha_price;
                        self.setData({
                            miaosha_data: miaosha,
                        });
                    }

                    self.setData({
                        goods: goods,
                    });

                    
                }
            }
        });
    },

    attrClick: function(e) {
        var self = this;
        var attr_group_id = e.target.dataset.groupId;
        var attr_id = e.target.dataset.id;
        var attr_group_list = self.data.attr_group_list;
        for (var i in attr_group_list) {
            if (attr_group_list[i].attr_group_id != attr_group_id)
                continue;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].attr_id == attr_id) {
                    attr_group_list[i].attr_list[j].checked = true;
                } else {
                    attr_group_list[i].attr_list[j].checked = false;
                }
            }
        }
        self.setData({
            attr_group_list: attr_group_list,
        });

        var check_attr_list = [];
        var check_all = true;
        for (var i in attr_group_list) {
            var group_checked = false;
            for (var j in attr_group_list[i].attr_list) {
                if (attr_group_list[i].attr_list[j].checked) {
                    check_attr_list.push(attr_group_list[i].attr_list[j].attr_id);
                    group_checked = true;
                    break;
                }
            }
            if (!group_checked) {
                check_all = false;
                break;
            }
        }
        if (!check_all)
            return;
        getApp().core.showLoading({
            title: "正在加载",
            mask: true,
        });
        getApp().request({
            url: getApp().api.default.goods_attr_info,
            data: {
                goods_id: self.data.id,
                attr_list: JSON.stringify(check_attr_list),
                type: 'ms'
            },
            success: function(res) {
                getApp().core.hideLoading();
                if (res.code == 0) {
                    var goods = self.data.goods;
                    goods.price = res.data.price;
                    goods.num = res.data.num;
                    goods.attr_pic = res.data.pic;
                    self.setData({
                        goods: goods,
                        miaosha_data: res.data.miaosha,
                    });
                }
            }
        });

    },

    /**
     * TODO 预约规格选择，需要优化合并
     */
    bookAttrGoodsClick: function(check_attr_list) {
        var self = this.currentPage;
        var goods = self.data.goods;
        goods.attr.forEach(function(item, index, array) {
            var attr_list = [];
            item['attr_list'].forEach(function(itema, indexa, arraya) {
                attr_list.push(itema['attr_id']);
            });

            if (check_attr_list.sort().toString() == attr_list.sort().toString()) {
                goods['attr_pic'] = item['pic'];
                goods['num'] = item['num'];
                goods['price'] = item['price'];
                self.setData({
                    goods: goods
                })
            }
        });
    },

    /**
     * TODO 积分商城规格选择,需要合并优化
     */
    integralMallAttrClick: function(checkAttrList) {
        var self = this.currentPage;
        var goods = self.data.goods;
        var inattr = goods.attr;
        var inattr_id = [];
        var price = 0;
        var integral = 0;
        for (var x in inattr) {
            if (JSON.stringify(inattr[x].attr_list) == JSON.stringify(checkAttrList)) {
                if (parseFloat(inattr[x].price) > 0) {
                    price = inattr[x].price;
                } else {
                    price = goods.price;
                }
                if (parseInt(inattr[x].integral) > 0) {
                    integral = inattr[x].integral
                } else {
                    integral = goods.integral
                }
                goods.num = inattr[x].num;
                self.setData({
                    attr_integral: integral,
                    attr_num: inattr[x].num,
                    attr_price: price,
                    status: 'attr',
                    goods: goods
                });
            }
        }
    },

    /**
     * 商品数量减少
     */
    numberSub: function() {
        var self = this.currentPage;
        var num = self.data.form.number;
        if (num <= 1)
            return true;
        num--;
        self.setData({
            form: {
                number: num,
            }
        });
    },

    /**
     * 商品数量添加
     */
    numberAdd: function() {
        var self = this.currentPage;
        var num = self.data.form.number;
        num++;
        // TODO 商城商品详情没有以下判断
        if (num > self.data.goods.one_buy_limit && self.data.goods.one_buy_limit != 0) {
            getApp().core.showModal({
                title: '提示',
                content: '数量超过最大限购数',
                showCancel: false,
                success: function(res) {}
            })
            return;
        }

        self.setData({
            form: {
                number: num,
            }
        });
    },

    /**
     * 手动输入商品数量
     */
    numberBlur: function(e) {
        var self = this.currentPage;
        var num = e.detail.value;
        num = parseInt(num);
        if (isNaN(num)) {
            num = 1;
        }
        if (num <= 0) {
            num = 1;
        }
        // TODO 商城商品详情没有以下判断   
        if (num > self.data.goods.one_buy_limit && self.data.goods.one_buy_limit != 0) {
            getApp().core.showModal({
                title: '提示',
                content: '数量超过最大限购数',
                showCancel: false,
                success: function(res) {}
            });
            num = self.data.goods.one_buy_limit;
        }

        self.setData({
            form: {
                number: num,
            }
        });
    },
}