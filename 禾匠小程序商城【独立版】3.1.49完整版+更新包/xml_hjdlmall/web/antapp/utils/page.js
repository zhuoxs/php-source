if (typeof wx === 'undefined') var wx = getApp().hj;
/**
 * @link http://www.zjhejiang.com/
 * @copyright Copyright (c) 2018 浙江禾匠信息科技有限公司
 * @author Lu Wei
 *
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/5/11
 * Time: 18:32
 */
module.exports = {
    currentPage: null,
    onLoad: function (page, options) {

        var store = wx.getStorageSync('store');
        // 设置平台标识
        page.setData({
            __platform: getApp().getPlatform(),
            __is_comment: store ? store.is_comment : 1, //全局评价开关
            __is_sales: store ? store.is_sales : 1, //全局销量开关
            _navigation_bar_color: wx.getStorageSync('_navigation_bar_color'), //底部导航颜色
        });

        if (typeof my !== 'undefined' && page.route != 'pages/login/login' && options) {
            if (!page.options)
                page['options'] = options;
            wx.setStorageSync('last_page_options', options);
        }
        this.currentPage = page;
        var _this = this;
        if (page.options) {
            var parent_id = 0;
            if (page.options.user_id) {
                parent_id = page.options.user_id;
            } else if (page.options.scene) {
                if (isNaN(page.options.scene)) {
                    var scene = decodeURIComponent(page.options.scene);
                    if (scene) {
                        scene = getApp().utils.scene_decode(scene);
                        if (scene && scene.uid) {
                            parent_id = scene.uid;
                        }
                    }
                } else {
                    parent_id = page.options.scene;
                }
            } else if (getApp().query !== null) {
                var query = getApp().query;
                parent_id = query.uid;
            }
            if (parent_id) {
                wx.setStorageSync('parent_id', parent_id);
            }
        }
        if (typeof page.openWxapp === 'undefined') {
            page.openWxapp = _this.openWxapp;
        }
        if (typeof page.showToast === 'undefined') {
            page.showToast = function (e) {
                _this.showToast(e);
            };
        }
        if (typeof page._formIdFormSubmit === 'undefined') {
            var _this = this;
            page._formIdFormSubmit = function (e) {
                _this.formIdFormSubmit(e);
            };
        }
        getApp().setNavigationBarColor();
        this.setPageNavbar(page);
        page.naveClick = function (e) {
            getApp().navigatorClick(e, page);
        };
        this.setDeviceInfo();
        this.setPageClasses();
        this.setUserInfo();
        if (typeof page.showLoading === 'undefined') {
            page.showLoading = function (e) {
                _this.showLoading(e);
            }
        }
        if (typeof page.hideLoading === 'undefined') {
            page.hideLoading = function (e) {
                _this.hideLoading(e);
            }
        }
        this.setWxappImg();
        this.setAlipayMpConfig();
        if (typeof page.setTimeList === 'undefined') {
            page.setTimeList = function (e) {
                return _this.setTimeList(e);
            }
        }
        this.setBarTitle()
    },
    onReady: function (page) {
        this.currentPage = page;
    },
    onShow: function (page) {
        this.currentPage = page;
        getApp().order_pay.init(page, getApp());
    },
    onHide: function (page) {
        this.currentPage = page;
    },
    onUnload: function (page) {
        this.currentPage = page;
    },

    showToast: function (e) {
        var page = this.currentPage;
        var duration = e.duration || 2500;
        var title = e.title || '';
        var success = e.success || null;
        var fail = e.fail || null;
        var complete = e.complete || null;
        if (page._toast_timer) {
            clearTimeout(page._toast_timer);
        }
        page.setData({
            _toast: {
                title: title,
            },
        });
        page._toast_timer = setTimeout(function () {
            var _toast = page.data._toast;
            _toast.hide = true;
            page.setData({
                _toast: _toast,
            });
            if (typeof complete == 'function') {
                complete();
            }
        }, duration);
    },
    formIdFormSubmit: function (e) {
    },
    setDeviceInfo: function () {
        var page = this.currentPage;
        //iphonex=>iPhone X(GSM+CDMA)<iPhone10,3>
        var device_list = [{
            id: 'device_iphone_5',
            model: 'iPhone 5',
        },
            {
                id: 'device_iphone_x',
                model: 'iPhone X',
            },
        ];
        //设置设备信息
        var device_info = wx.getSystemInfoSync();
        if (device_info.model) {
            if (device_info.model.indexOf('iPhone X') >= 0) {
                device_info.model = 'iPhone X';
            }
            for (var i in device_list) {
                if (device_list[i].model == device_info.model) {
                    page.setData({
                        __device: device_list[i].id,
                    });
                }
            }
        }
    },
    setPageNavbar: function (page) {
        var _this = this;
        var navbar = wx.getStorageSync('_navbar');
        if (navbar) {
            setNavbar(navbar);
        }
        var in_array = false;
        for (var i in this.navbarPages) {
            if (page.route == this.navbarPages[i]) {
                in_array = true;
                break;
            }
        }
        if (!in_array) {
            return;
        }
        getApp().request({
            url: getApp().api.default.navbar,
            success: function (res) {
                if (res.code == 0) {
                    setNavbar(res.data);
                    wx.setStorageSync('_navbar', res.data);
                    _this.setPageClasses();
                }
            }
        });

        function setNavbar(navbar) {
            var in_navs = false;
            var route = page.route || (page.__route__ || null);
            for (var i in navbar.navs) {
                if (navbar.navs[i].url === "/" + route) {
                    navbar.navs[i].active = true;
                    in_navs = true;
                } else {
                    navbar.navs[i].active = false;
                }
            }
            if (!in_navs)
                return;
            page.setData({
                _navbar: navbar
            });
        }

    },
    //加入底部导航的页面
    navbarPages: [
        'pages/index/index',
        'pages/cat/cat',
        'pages/cart/cart',
        'pages/user/user',
        'pages/list/list',
        'pages/search/search',
        'pages/topic-list/topic-list',
        'pages/video/video-list',
        'pages/miaosha/miaosha',
        'pages/shop/shop',
        'pages/pt/index/index',
        'pages/book/index/index',
        'pages/share/index',
        'pages/quick-purchase/index/index',
        'mch/m/myshop/myshop',
        'mch/shop-list/shop-list',
        'pages/integral-mall/index/index',
        'pages/integral-mall/register/index',
        'pages/article-detail/article-detail',
        'pages/article-list/article-list'
    ],
    setPageClasses: function () {
        var page = this.currentPage;
        var device = page.data.__device;
        var classes = device;
        if (page.data._navbar && page.data._navbar.navs && page.data._navbar.navs.length > 0) {
            classes += ' show_navbar';
        }
        if (classes)
            page.setData({
                __page_classes: classes,
            });
    },
    setUserInfo: function () {
        var page = this.currentPage;
        var userInfo = wx.getStorageSync('user_info');
        if (userInfo) {
            page.setData({
                __user_info: userInfo,
            });
        }
    },
    showLoading: function (e) {
        var page = this.currentPage;
        page.setData({
            _loading: true
        });
    },
    hideLoading: function (e) {
        var page = this.currentPage;
        page.setData({
            _loading: false
        });
    },
    setWxappImg: function (e) {
        var page = this.currentPage;
        var wxappImg = wx.getStorageSync('wxapp_img');
        if (wxappImg) {
            page.setData({
                __wxapp_img: wxappImg,
            });
        }else{
            getApp().wxappImgReadyCall = function (res) {
                console.log(res);
                page.setData({
                    __wxapp_img: res.data.wxapp_img,
                });
            }
        }
    },
    setTimeList: function (reset_time) {
        // 补零
        function fillZero(time) {
            if (time <= 0) {
                time = 0;
            }
            return time < 10 ? '0' + time : time;
        }

        var _s = '00';
        var _m = '00';
        var _h = '00';
        var _d = 0;
        if (reset_time >= 86400) {
            _d = parseInt(reset_time / 86400);
            reset_time = reset_time % 86400;
        }
        if (reset_time < 86400) {
            _h = parseInt(reset_time / 3600);
            reset_time = reset_time % 3600;
        }
        if (reset_time < 3600) {
            _m = parseInt(reset_time / 60);
            reset_time = reset_time % 60;
        }

        if (reset_time < 60) {
            _s = reset_time;
        }
        return {
            day: _d,
            hour: fillZero(_h),
            minute: fillZero(_m),
            second: fillZero(_s)
        }
    },
    setBarTitle: function (e) {
        var route = this.currentPage.route;
        var list = wx.getStorageSync('wx_bar_title');
        for (var i in list) {
            if (list[i].url === route) {
                wx.setNavigationBarTitle({
                    title: list[i].title,
                })
            }
        }
    },
    setAlipayMpConfig: function () {
        var page = this.currentPage;
        var data = wx.getStorageSync('alipay_mp_config');
        if (!data) {
            getApp().request({
                url: getApp().api.default.store,
                success: function (res) {
                    if (res.code == 0) {
                        data = res.data.alipay_mp_config;
                        wx.setStorageSync('alipay_mp_config', data);
                        page.setData({
                            __alipay_mp_config: data,
                        });
                    }
                }
            });
        } else {
            page.setData({
                __alipay_mp_config: data,
            });
        }
    },
    openWxapp: function (e) {
        console.log('openWxapp--->', e.currentTarget.dataset);
        if (e.currentTarget.dataset.url) {
            var url = e.currentTarget.dataset.url;
            url = parseQueryString(url);
            url.path = url.path ? decodeURIComponent(url.path) : "";
            wx.navigateToMiniProgram({
                appId: url.appId,
                path: url.path,
                complete: function (e) {
                }
            });
        } else if (e.currentTarget.dataset.appId && e.currentTarget.dataset.path) {
            wx.navigateToMiniProgram({
                appId: e.currentTarget.dataset.appId,
                path: e.currentTarget.dataset.path,
                complete: function (e) {
                }
            });
        } else {
            return;
        }

        function parseQueryString(url) {
            var reg_url = /^[^\?]+\?([\w\W]+)$/,
                reg_para = /([^&=]+)=([\w\W]*?)(&|$|#)/g,
                arr_url = reg_url.exec(url),
                ret = {};
            if (arr_url && arr_url[1]) {
                var str_para = arr_url[1], result;
                while ((result = reg_para.exec(str_para)) != null) {
                    ret[result[1]] = result[2];
                }
            }
            return ret;
        }
    },
};