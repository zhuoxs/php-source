var tt, dd, common = require("../common/common.js"), app = getApp();

function getUrlParam(a, t) {
    var e = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), d = a.split("?")[1].match(e);
    return null != d ? unescape(d[2]) : null;
}

function refresh(d, a) {
    tt = setInterval(function() {
        var e = d.data.xc;
        app.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            method: "POST",
            data: {
                op: "online_refresh",
                pid: d.data.id,
                id: e.detail[e.detail.length - 1].id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (d.setData({
                    scrollId: ""
                }), e.detail = e.detail.concat(t.data), d.setData({
                    xc: e,
                    scrollId: "scrollB"
                }));
            }
        });
    }, a);
}

function refresh2(s, a) {
    dd = setInterval(function() {
        var i = s.data.xc;
        app.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            method: "POST",
            data: {
                op: "online_refresh2",
                id: s.data.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    for (var e = 0; e < t.data.length; e++) {
                        for (var d = -1, r = 0; r < i.list.length; r++) i.list[r].id == t.data[e].id && (d = 1, 
                        i.list[r].member = t.data[e].member);
                        -1 == d && i.list.push(t.data[e]);
                    }
                    s.setData({
                        xc: i
                    });
                }
            }
        });
    }, a);
}

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
        var e = this, d = a.currentTarget.dataset.index;
        if (e.data.xc.list[d].id != e.data.id) {
            var r = e.data.xc;
            r.list[d].member = 0, e.setData({
                r_page: 1,
                r_isbottom: !1,
                scrollId: ""
            }), app.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_detail",
                    id: e.data.xc.list[d].id,
                    pagesize: e.data.pagesize,
                    r_page: e.data.r_page
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && "" != t.data.detail && null != t.data.detail ? (r.detail = t.data.detail, 
                    e.setData({
                        xc: r,
                        id: e.data.xc.list[d].id,
                        r_page: e.data.r_page + 1,
                        scrollId: "scrollB"
                    })) : e.setData({
                        xc: r,
                        r_isbottom: !0,
                        id: e.data.xc.list[d].id
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
        var e = this;
        if ("" != e.data.inputValue && null != e.data.inputValue) {
            e.setData({
                scrollId: ""
            });
            var d = e.data.xc, r = {
                type: 1,
                content: e.data.inputValue,
                avatar: d.user.avatar,
                on: 1,
                pid: e.data.id
            };
            app.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_on",
                    type: 1,
                    content: e.data.inputValue,
                    pid: e.data.id
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && (r.createtime = t.data.createtime, r.id = t.data.id, d.detail.push(r), 
                    e.setData({
                        xc: d,
                        inputValue: "",
                        scrollId: "scrollB"
                    }));
                }
            });
        }
    },
    upload: function() {
        var r = this, e = "entry/wxapp/onlineupload";
        -1 == e.indexOf("http://") && -1 == e.indexOf("https://") && (e = app.util.url(e));
        var a = wx.getStorageSync("userInfo").sessionid;
        !getUrlParam(e, "state") && a && (e = e + "&state=we7sid-" + a), e = e + "&state=we7sid-" + a;
        var t = getCurrentPages();
        t.length && (t = t[getCurrentPages().length - 1]) && t.__route__ && (e = e + "&m=" + t.__route__.split("/")[0]), 
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths;
                wx.uploadFile({
                    url: e,
                    filePath: t[0],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(a) {
                        var e = r.data.xc;
                        a.data = JSON.parse(a.data);
                        var d = {
                            type: 2,
                            content: a.data.url,
                            avatar: e.user.avatar,
                            on: 1,
                            pid: r.data.id
                        };
                        self.setData({
                            scrollId: ""
                        }), app.util.request({
                            url: "entry/wxapp/user",
                            method: "POST",
                            data: {
                                op: "online_on",
                                type: 2,
                                content: a.data.url,
                                pid: r.data.id,
                                upload: a.data.upload
                            },
                            success: function(a) {
                                var t = a.data;
                                "" != t.data && (d.createtime = t.data.createtime, d.id = t.data.id, e.detail.push(d), 
                                r.setData({
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
        var e = this;
        if (!e.data.r_isbottom && e.data.canload) {
            e.setData({
                canload: !1
            });
            var d = e.data.xc, r = d.detail[0].id;
            app.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online_detail",
                    id: e.data.id,
                    pagesize: e.data.pagesize,
                    r_page: e.data.r_page,
                    prev_id: r
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && "" != t.data.detail && null != t.data.detail ? (d.detail = t.data.detail.concat(d.detail), 
                    e.setData({
                        xc: d,
                        r_page: e.data.r_page + 1,
                        scrollId: "id" + r
                    })) : e.setData({
                        r_isbottom: !0
                    });
                },
                complete: function() {
                    e.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online_detail",
                id: e.data.id,
                pagesize: e.data.pagesize,
                r_page: e.data.r_page
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.detail && null != t.data.detail ? e.setData({
                    r_page: e.data.r_page + 1,
                    scrollId: "scrollB"
                }) : e.setData({
                    r_isbottom: !0
                }), 0 != parseInt(t.data.refresh) && (clearInterval(tt), refresh(e, parseInt(t.data.refresh)), 
                clearInterval(dd), refresh2(e, parseInt(t.data.refresh))));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var d = this;
        d.setData({
            r_page: 1,
            r_isbottom: !1,
            scrollId: ""
        }), clearInterval(tt), app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online_detail",
                id: d.data.id,
                pagesize: d.data.pagesize,
                r_page: d.data.r_page
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    if (wx.stopPullDownRefresh(), "" != t.data.detail && null != t.data.detail) {
                        var e = d.data.xc;
                        e.detail = t.data.detail, d.setData({
                            xc: e,
                            r_page: d.data.r_page + 1,
                            scrollId: "scrollB"
                        });
                    } else d.setData({
                        r_isbottom: !0
                    });
                    0 != parseInt(t.data.refresh) && refresh(d, parseInt(t.data.refresh));
                } else d.setData({
                    r_isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {}
});