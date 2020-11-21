function a(a, t) {
    var e = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), d = a.split("?")[1].match(e);
    return null != d ? unescape(d[2]) : null;
}

function t(a, t) {
    d = setInterval(function() {
        var t = a.data.xc;
        s.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            method: "POST",
            data: {
                op: "online_refresh",
                pid: a.data.id,
                id: t.detail[t.detail.length - 1].id
            },
            success: function(e) {
                var d = e.data;
                "" != d.data && (a.setData({
                    scrollId: ""
                }), t.detail = t.detail.concat(d.data), a.setData({
                    xc: t,
                    scrollId: "scrollB"
                }));
            }
        });
    }, t);
}

function e(a, t) {
    i = setInterval(function() {
        var t = a.data.xc;
        s.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            method: "POST",
            data: {
                op: "online_refresh2",
                id: a.data.id
            },
            success: function(e) {
                var d = e.data;
                if ("" != d.data) {
                    for (var i = 0; i < d.data.length; i++) {
                        for (var r = -1, s = 0; s < t.list.length; s++) t.list[s].id == d.data[i].id && (r = 1, 
                        t.list[s].member = d.data[i].member);
                        -1 == r && t.list.push(d.data[i]);
                    }
                    a.setData({
                        xc: t
                    });
                }
            }
        });
    }, t);
}

var d, i, r = require("../common/common.js"), s = getApp();

Page({
    data: {
        curIndex: 0,
        inputValue: "",
        pagesize: 20,
        r_page: 1,
        r_isbottom: !1,
        canload: !0
    },
    bindTap: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        if (t.data.xc.list[e].id != t.data.id) {
            var d = t.data.xc;
            d.list[e].member = 0, t.setData({
                r_page: 1,
                r_isbottom: !1,
                scrollId: ""
            }), s.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_detail",
                    id: t.data.xc.list[e].id,
                    pagesize: t.data.pagesize,
                    r_page: t.data.r_page
                },
                success: function(a) {
                    var i = a.data;
                    "" != i.data && "" != i.data.detail && null != i.data.detail ? (d.detail = i.data.detail, 
                    t.setData({
                        xc: d,
                        id: t.data.xc.list[e].id,
                        r_page: t.data.r_page + 1,
                        scrollId: "scrollB"
                    })) : t.setData({
                        xc: d,
                        r_isbottom: !0,
                        id: t.data.xc.list[e].id
                    });
                }
            });
        }
    },
    ipnut: function(a) {
        this.setData({
            inputValue: a.detail.value
        });
    },
    submitTo: function(a) {
        var t = this;
        if ("" != t.data.inputValue && null != t.data.inputValue) {
            t.setData({
                scrollId: ""
            });
            var e = t.data.xc, d = {
                type: 1,
                content: t.data.inputValue,
                avatar: e.user.avatar,
                on: 1,
                pid: t.data.id
            };
            s.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_on",
                    type: 1,
                    content: t.data.inputValue,
                    pid: t.data.id
                },
                success: function(a) {
                    var i = a.data;
                    "" != i.data && (d.createtime = i.data.createtime, d.id = i.data.id, e.detail.push(d), 
                    t.setData({
                        xc: e,
                        inputValue: "",
                        scrollId: "scrollB"
                    }));
                }
            });
        }
    },
    upload: function() {
        var t = this, e = "entry/wxapp/onlineupload";
        -1 == e.indexOf("http://") && -1 == e.indexOf("https://") && (e = s.util.url(e));
        var d = wx.getStorageSync("userInfo").sessionid;
        !a(e, "state") && d && (e = e + "&state=we7sid-" + d), e = e + "&state=we7sid-" + d;
        var i = getCurrentPages();
        i.length && (i = i[getCurrentPages().length - 1]) && i.__route__ && (e = e + "&m=" + i.__route__.split("/")[0]), 
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var d = a.tempFilePaths;
                wx.uploadFile({
                    url: e,
                    filePath: d[0],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(a) {
                        var e = t.data.xc;
                        a.data = JSON.parse(a.data);
                        var d = {
                            type: 2,
                            content: a.data.url,
                            avatar: e.user.avatar,
                            on: 1,
                            pid: t.data.id
                        };
                        self.setData({
                            scrollId: ""
                        }), s.util.request({
                            url: "entry/wxapp/user",
                            method: "POST",
                            data: {
                                op: "online_on",
                                type: 2,
                                content: a.data.url,
                                pid: t.data.id,
                                upload: a.data.upload
                            },
                            success: function(a) {
                                var i = a.data;
                                "" != i.data && (d.createtime = i.data.createtime, d.id = i.data.id, e.detail.push(d), 
                                t.setData({
                                    xc: e,
                                    scrollId: "scrollB"
                                }));
                            }
                        });
                    }
                });
            }
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.previewImage({
            current: t,
            urls: [ t ]
        });
    },
    load_r: function() {
        var a = this;
        if (!a.data.r_isbottom && a.data.canload) {
            a.setData({
                canload: !1
            });
            var t = a.data.xc, e = t.detail[0].id;
            s.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_detail",
                    id: a.data.id,
                    pagesize: a.data.pagesize,
                    r_page: a.data.r_page,
                    prev_id: e
                },
                success: function(d) {
                    var i = d.data;
                    "" != i.data && "" != i.data.detail && null != i.data.detail ? (t.detail = i.data.detail.concat(t.detail), 
                    a.setData({
                        xc: t,
                        r_page: a.data.r_page + 1,
                        scrollId: "id" + e
                    })) : a.setData({
                        r_isbottom: !0
                    });
                },
                complete: function() {
                    a.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var n = this;
        r.config(n), r.theme(n), n.setData({
            id: a.id
        }), s.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online_detail",
                id: n.data.id,
                pagesize: n.data.pagesize,
                r_page: n.data.r_page
            },
            success: function(a) {
                var r = a.data;
                "" != r.data && (n.setData({
                    xc: r.data
                }), "" != r.data.detail && null != r.data.detail ? n.setData({
                    r_page: n.data.r_page + 1,
                    scrollId: "scrollB"
                }) : n.setData({
                    r_isbottom: !0
                }), 0 != parseInt(r.data.refresh) && (clearInterval(d), t(n, parseInt(r.data.refresh)), 
                clearInterval(i), e(n, parseInt(r.data.refresh))));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        a.setData({
            r_page: 1,
            r_isbottom: !1,
            scrollId: ""
        }), clearInterval(d), s.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online_detail",
                id: a.data.id,
                pagesize: a.data.pagesize,
                r_page: a.data.r_page
            },
            success: function(e) {
                var d = e.data;
                if ("" != d.data) {
                    if (wx.stopPullDownRefresh(), "" != d.data.detail && null != d.data.detail) {
                        var i = a.data.xc;
                        i.detail = d.data.detail, a.setData({
                            xc: i,
                            r_page: a.data.r_page + 1,
                            scrollId: "scrollB"
                        });
                    } else a.setData({
                        r_isbottom: !0
                    });
                    0 != parseInt(d.data.refresh) && t(a, parseInt(d.data.refresh));
                } else a.setData({
                    r_isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {}
});