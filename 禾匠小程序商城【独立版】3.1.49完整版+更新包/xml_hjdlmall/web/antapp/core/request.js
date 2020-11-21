/**
 * @link http://www.zjhejiang.com/
 * @copyright Copyright (c) 2018 浙江禾匠信息科技有限公司
 * @author LuWei
 */
/***
 * http请求
 * @param args
 */

module.exports = function(object) {
    if (!object.data) {
        object.data = {};
    }
    let core = this.core;
    let access_token = this.core.getStorageSync(this.const.ACCESS_TOKEN);
    if (access_token) {
        object.data.access_token = access_token;
    }
    object.data._version = this._version;
    object.data._platform = this.platform

    if (!this.is_login && this.page.currentPage){
        this.is_login = true;
        this.login({});
    }
    var app = this;
    core.request({
        url: object.url,
        header: object.header || {
            'content-type': 'application/x-www-form-urlencoded'
        },
        data: object.data || {},
        method: object.method || "GET",
        dataType: object.dataType || "json",
        success: function (res) {
            if (res.data.code == -1) {
                app.page.setUserInfoShow();
                app.is_login = false;
            } else if (res.data.code == -2) {
                core.redirectTo({
                    url: '/pages/store-disabled/store-disabled',
                })
            } else {
                if (object.success)
                    object.success(res.data);
            }
        },
        fail: function(res) {
            console.warn('--- request fail >>>');
            console.warn('--- ' + object.url + ' ---');
            console.warn(res);
            console.warn('<<< request fail ---');
            var app = getApp();
            if (app.is_on_launch) {
                app.is_on_launch = false;
                core.showModal({
                    title: "网络请求出错",
                    content: res.errMsg || '',
                    showCancel: false,
                    success: function(res) {
                        if (res.confirm) {
                            if (object.fail)
                                object.fail(res);
                        }
                    }
                });
            } else {
                core.showToast({
                    title: res.errMsg,
                    image: "/images/icon-warning.png",
                });
                if (object.fail)
                    object.fail(res);
            }
        },
        complete: function(res) {
            if (res.statusCode != 200) {
                if (res.data.code && res.data.code == 500) {
                    var sort_msg = res.data.data.message;
                    core.showModal({
                        title: '系统错误',
                        content: sort_msg + ";\r\n请将错误内容复制发送给我们，以便进行问题追踪。",
                        cancelText: '关闭',
                        confirmText: '复制',
                        success: function(e) {
                            if (e.confirm) {
                                core.setClipboardData({
                                    data: JSON.stringify({
                                        data: res.data.data,
                                        object: object,
                                    }),
                                });
                            }
                        },
                    });
                }
            }
            if (object.complete)
                object.complete(res);
        }
    });
};