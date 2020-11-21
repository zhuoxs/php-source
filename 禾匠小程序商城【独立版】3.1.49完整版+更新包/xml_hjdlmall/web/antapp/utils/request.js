if (typeof wx === 'undefined') var wx = getApp().hj;
/**
 * @link http://www.zjhejiang.com/
 * @copyright Copyright (c) 2018 浙江禾匠信息科技有限公司
 * @author Lu Wei
 *
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/5/11
 * Time: 18:38
 */

module.exports = function (object) {
    if (!object.data)
        object.data = {};
    var access_token = wx.getStorageSync("access_token");
    if (access_token) {
        object.data.access_token = access_token;
    }
    object.data._uniacid = this.siteInfo.uniacid;
    object.data._acid = this.siteInfo.acid;
    object.data._version = this._version;
    if (typeof wx !== 'undefined') {
        object.data._platform = 'wx';
    }
    if (typeof my !== 'undefined') {
        object.data._platform = 'my';
    }

    wx.request({
        url: object.url,
        header: object.header || {
            'content-type': 'application/x-www-form-urlencoded'
        },
        data: object.data || {},
        method: object.method || "GET",
        dataType: object.dataType || "json",
        success: function (res) {
            if (res.data.code == -1) {
                var pages = getCurrentPages();
                var current_page = pages[(pages.length - 1)];
                if (!current_page) {
                    getApp().login();
                } else if (current_page.route != 'pages/login/login') {
                    getApp().login();
                } else {
                    console.log('Login Page Do Not Login');
                }
            } else if (res.data.code == -2) {
                wx.redirectTo({
                    url: '/pages/store-disabled/store-disabled',
                })
            } else {
                if (object.success)
                    object.success(res.data);
            }
        },
        fail: function (res) {
            console.warn('--- request fail >>>');
            console.warn('--- ' + object.url + ' ---');
            console.warn(res);
            console.warn('<<< request fail ---');
            var app = getApp();
            if (app.is_on_launch) {
                app.is_on_launch = false;
                wx.showModal({
                    title: "网络请求出错",
                    content: res.errMsg || '',
                    showCancel: false,
                    success: function (res) {
                        if (res.confirm) {
                            if (object.fail)
                                object.fail(res);
                        }
                    }
                });
            } else {
                wx.showToast({
                    title: res.errMsg,
                    image: "/images/icon-warning.png",
                });
                if (object.fail)
                    object.fail(res);
            }
        },
        complete: function (res) {
            if (res.statusCode != 200) {
                if (res.data.code && res.data.code == 500) {
                    var sort_msg = res.data.data.message;
                    wx.showModal({
                        title: '系统错误',
                        content: sort_msg + ";\r\n请将错误内容复制发送给我们，以便进行问题追踪。",
                        cancelText: '关闭',
                        confirmText: '复制',
                        success: function (e) {
                            if (e.confirm) {
                                wx.setClipboardData({
                                    data: JSON.stringify({
                                        data: res.data.data,
                                        object: object,
                                    }),
                                });
                            }
                        },
                    });

                    // wx.showModal({
                    //     title: '系统错误',
                    //     content: res.data.data.type + "\r\n事件ID:" + res.data.data.event_id,
                    //     cancelText: '关闭',
                    //     confirmText: '复制',
                    //     success: function (e) {
                    //         if (e.confirm) {
                    //             wx.setClipboardData({
                    //                 data: res.data.data.type + "\r\n事件ID:" + res.data.data.event_id + "\r\n " + object.url,
                    //             });
                    //         }
                    //     },
                    // });
                }
            }
            if (object.complete)
                object.complete(res);
        }
    });
};