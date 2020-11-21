var app = getApp(), Toast = require("../../libs/zanui/toast/toast"), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {
        first: !0,
        cancelWithMask: !0,
        showConfirm: !1,
        isAgree: !0,
        play: !1,
        manual: !1,
        video: [],
        album: [],
        thumb: [],
        tagList: [],
        book_field: "",
        recycle: {
            open: !1,
            style: []
        },
        delivery: [ "快递", "自提" ],
        deliveryIndex: null,
        unitIndex: 0,
        onlinePay: !0,
        isSetTop: !1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img");
        e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), t.id && a.setData({
            item_id: t.id
        }), app.viewCount(), a.checkBlacklist(), a.checkPostCount();
    },
    closeAuth: function() {
        this.setData({
            showAuth: !1
        });
    },
    showScanItems: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            cid: a,
            showAction: !0,
            actions: [ {
                name: "扫码上传",
                subname: "扫图书背面条形码"
            }, {
                name: "手动上传",
                subname: "手动填写图书内容"
            } ]
        });
    },
    closeActionSheet: function() {
        this.setData({
            showAction: !1
        });
    },
    clickAction: function(t) {
        for (var s = this, a = s.data.cid, e = s.data.category, i = 0; i < e.length; i++) if (e[i].id == a) {
            s.setData({
                cateIndex: i
            });
            break;
        }
        0 == t.detail.index ? wx.scanCode({
            scanType: [ "barCode" ],
            success: function(t) {
                if ("EAN_13" == t.scanType) {
                    var a = t.result;
                    s.setData({
                        bookCode: a
                    }), wx.request({
                        url: "https://douban.uieee.com/v2/book/isbn/" + a,
                        header: {
                            "content-type": "application/text"
                        },
                        success: function(t) {
                            if (s.setData({
                                showAction: !1
                            }), t.data) {
                                var a = t.data;
                                if (a.code && 6e3 == a.code) return void s.showIconToast("图书未找到，请扫描正版图书");
                                var e = a.title ? a.title : "", i = a.summary ? a.summary : "", o = [];
                                if (a.author && 0 < a.author.length) for (var n = 0; n < a.author.length; n++) o.push(a.author[n]); else o.push(a.origin_title);
                                s.setData({
                                    detail: {
                                        title: e,
                                        summary: i
                                    },
                                    book_field: {
                                        author: encodeURIComponent(o),
                                        publisher: encodeURIComponent(a.publisher),
                                        pubdate: a.pubdate,
                                        pages: a.pages,
                                        rating: a.rating && a.rating.average ? a.rating.average : 0,
                                        book_url: encodeURIComponent(a.alt),
                                        comment_url: encodeURIComponent(a.alt + "collections"),
                                        subtitle: encodeURIComponent(a.subtitle),
                                        price: a.price
                                    },
                                    first: !1
                                });
                            } else s.setData({
                                first: !1
                            }), Toptips("扫码获取内容失败，请手动填写内容");
                        }
                    });
                } else s.setData({
                    showAction: !1
                }), Toptips("请扫描图书后面的条形码，暂不支持其他类型条码");
            }
        }) : s.setData({
            showAction: !1,
            first: !1,
            manual: !0
        });
    },
    showPostPage: function() {
        this.setData({
            first: !1
        });
    },
    checkBlacklist: function() {
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "blacklist",
                m: "superman_hand2"
            },
            success: function(t) {},
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "../home/index"
                        });
                    }
                });
            }
        });
    },
    checkPostCount: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "post_count",
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno || (a.setData({
                    credit_title: app.globalData.credit_title
                }), a.checkPlugin(), a.getBasicInfo());
            },
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "../home/index"
                        });
                    }
                });
            }
        });
    },
    checkPlugin: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                act: "plugin",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) e.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    e.setData({
                        wechatPlugin: 1 == a.superman_hand2_plugin_wechat,
                        onlinePay: 1 == a.superman_hand2_plugin_wechat,
                        canSetTop: 1 == a.superman_hand2_plugin_ad
                    });
                }
            },
            fail: function(t) {
                e.showIconToast(t.data.errmsg);
            }
        });
    },
    getBasicInfo: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : 1 == t.data.data.auth_phone && "" == wx.getStorageSync("userInfo").memberInfo.mobile ? wx.showModal({
                    title: "系统提示",
                    content: "发布物品前需先绑定手机号",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "../bind_phone/index"
                        });
                    }
                }) : a.getMoreInfo();
            }
        });
    },
    getMoreInfo: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "get",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) l.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    if (!l.data.item_id) {
                        var e = a.add_fields || [];
                        if (e) for (var i = 0; i < e.length; i++) if ("radio" == e[i].type || "checkbox" == e[i].type) {
                            for (var o = e[i].extra.option, n = [], s = 0; s < o.length; s++) n[s] = new Object(), 
                            n[s].value = o[s], n[s].checked = !1;
                            e[i].extra.option = n;
                        } else "single_select" == e[i].type && (e[i].extra.value = "");
                        l.setData({
                            form_field: e
                        });
                    }
                    var r = [];
                    if (0 == a.default_unit ? (r = [ {
                        type: 0,
                        title: "元"
                    }, {
                        type: -1,
                        title: l.data.credit_title
                    } ], l.data.wechatPlugin && l.setData({
                        open_wechat: !0
                    })) : r = [ {
                        type: -1,
                        title: l.data.credit_title
                    }, {
                        type: 0,
                        title: "元"
                    } ], a.unit_list) for (var d = 0; d < a.unit_list.length; d++) {
                        var c = {
                            type: a.unit_list[d].type,
                            title: a.unit_list[d].title
                        };
                        r.push(c);
                    }
                    l.setData({
                        video_switch: a.video_switch,
                        category: a.category,
                        district: a.district,
                        rule: a.rule,
                        notice: a.notice,
                        auditType: a.audit_type,
                        books_on: !!a.book_status,
                        notice_switch: 1 == a.post_notice,
                        showTrade: 0 == a.show_trade,
                        first: 0 != a.book_status || 0 != a.post_notice,
                        set_top: 1 == a.set_top,
                        unitList: r
                    }), l.data.item_id ? l.getEditData(l.data.item_id) : l.setData({
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                l.setData({
                    completed: !0
                }), l.showIconToast(t.data.errmsg);
            }
        });
    },
    goNext: function(t) {
        var a = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), this.setData({
            first: !1
        });
    },
    showPopup: function() {
        this.setData({
            showBottomPopup: !0
        });
    },
    toggleBottomPopup: function() {
        this.setData({
            showBottomPopup: !this.data.showBottomPopup
        });
    },
    getEditData: function(t) {
        var f = this;
        app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "edit",
                id: t,
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) f.showIconToast(t.data.errmsg); else {
                    for (var a = t.data.data, e = f.data.category, i = 0; i < e.length; i++) if (e[i].id == a.cid) {
                        f.setData({
                            cateIndex: i
                        });
                        break;
                    }
                    var o = a.video || [];
                    f.setData({
                        first: !1,
                        detail: a,
                        album: a.album,
                        thumb: a.thumb,
                        video: o,
                        deliveryIndex: 0 != a.trade_type ? parseInt(a.trade_type) - 1 : null,
                        tagList: a.tags ? a.tags : [],
                        price: 0 == a.buy_type ? a.price : a.credit,
                        address: a.address,
                        open_wechat: 0 == a.unit,
                        onlinePay: 1 == a.wechatpay,
                        lat: a.lat,
                        lng: a.lng,
                        finish: !0,
                        completed: !0
                    });
                    var n = a.add_fields || [];
                    if (n) {
                        for (var s = 0; s < n.length; s++) if ("radio" == n[s].type || "checkbox" == n[s].type) {
                            for (var r = n[s].value, d = n[s].extra.option, c = [], l = 0; l < d.length; l++) {
                                c[l] = new Object(), c[l].value = d[l], c[l].checked = !1;
                                for (var u = 0; u < r.length; u++) if (c[l].value == r[u]) {
                                    c[l].checked = !0;
                                    break;
                                }
                            }
                            n[s].extra.option = c;
                        }
                        f.setData({
                            form_field: n
                        });
                    }
                    for (var p = f.data.unitList, h = 0; h < p.length; h++) if (p[h].type == a.unit) {
                        f.setData({
                            unitIndex: h
                        });
                        break;
                    }
                }
            }
        });
    },
    showCategory: function(t) {
        this.setData({
            cateIndex: t.detail.value
        });
    },
    changeUnit: function(t) {
        var a = t.detail.value, e = this.data.wechatPlugin;
        this.setData({
            unitIndex: a,
            open_wechat: !!e && 0 == this.data.unitList[a].type,
            onlinePay: 0 == this.data.unitList[a].type
        });
    },
    setOnlinePay: function(t) {
        this.setData({
            onlinePay: t.detail.value
        });
    },
    showDelivery: function(t) {
        this.setData({
            deliveryIndex: t.detail.value
        });
    },
    setItemTop: function(t) {
        this.setData({
            isSetTop: t.detail.value
        });
    },
    bindAgreeChange: function(t) {
        this.setData({
            isAgree: !!t.detail.value.length
        });
    },
    chooseVideo: function() {
        var a = this;
        wx.chooseVideo({
            success: function(t) {
                a.uploadVideo(t.tempFilePath);
            },
            fail: function(t) {
                Toptips(t.errMsg);
            }
        });
    },
    uploadVideo: function(t) {
        var i = this, a = app.util.url("entry/wxapp/item", {
            act: "upload",
            m: "superman_hand2"
        });
        wx.showLoading({
            title: "上传中"
        }), wx.uploadFile({
            url: a,
            filePath: t,
            name: "videoData",
            fail: function(t) {
                Toptips(t.errMsg);
            },
            complete: function() {
                wx.hideLoading();
            },
            success: function(t) {
                var a = JSON.parse(t.data);
                if (0 == a.errno) {
                    var e = i.data.video;
                    e.push(a.data), i.setData({
                        video: e
                    });
                } else Toptips(a.errmsg);
            }
        });
    },
    deleteVideo: function(t) {
        var e = this, i = t.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确定要删除该视频吗？",
            success: function(t) {
                if (t.confirm && e.data.video) {
                    var a = e.data.video;
                    a.splice(i, 1), e.setData({
                        video: a
                    });
                }
            }
        });
    },
    chooseImage: function(t) {
        var i = this;
        wx.chooseImage({
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var a = t.tempFilePaths.length, e = app.util.url("entry/wxapp/item", {
                    act: "upload",
                    m: "superman_hand2"
                });
                i.uploadImg(t.tempFilePaths, 0, a, e);
            }
        });
    },
    uploadImg: function(o, n, s, r) {
        var d = this;
        wx.showLoading({
            title: "上传中"
        }), wx.uploadFile({
            url: r,
            filePath: o[n],
            name: "imgData",
            complete: function() {
                wx.hideLoading();
            },
            success: function(t) {
                n++;
                var a = JSON.parse(t.data);
                if (0 == a.errno) {
                    var e = d.data.album, i = d.data.thumb;
                    e.push(a.data.orignal), i.push(a.data.thumb), d.setData({
                        album: e,
                        thumb: i
                    });
                } else Toptips(a.errmsg);
                n != s && d.uploadImg(o, n, s, r);
            },
            fail: function(t) {
                var a = JSON.parse(t.data);
                Toptips(a.errmsg);
            }
        });
    },
    deleteImg: function(t) {
        var i = this, o = t.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确定要删除该图片吗？",
            success: function(t) {
                if (t.confirm && i.data.album) {
                    var a = i.data.album, e = i.data.thumb;
                    e && 0 < e.length && e.splice(o, 1), a.splice(o, 1), i.setData({
                        album: a,
                        thumb: e
                    });
                }
            }
        });
    },
    setCurTag: function(t) {
        this.setData({
            curTag: t.detail.value
        });
    },
    addTags: function(t) {
        var a = this.data.tagList, e = t.detail.value.tags;
        if (e) if (this.setData({
            curTag: e
        }), 8 < e.length) Toptips("标签长度应小于8个字符"); else if (10 <= a.length) Toptips("标签最多添加10个"); else {
            for (var i = 0; i < a.length; i++) if (a[i] == e) return void Toptips("标签不能重复添加");
            a.push(e), this.setData({
                tagList: a,
                curTag: ""
            });
        } else Toptips("请填写标签内容");
    },
    setInput: function(t) {
        var a = this.data.form_field, e = t.currentTarget.dataset.index, i = t.detail.value;
        a[e].value = i, this.setData({
            form_field: a
        });
    },
    radioChange: function(t) {
        for (var a = this.data.form_field, e = a[t.currentTarget.dataset.index].extra.option, i = 0; i < e.length; i++) e[i].value == t.detail.value ? e[i].checked = !0 : e[i].checked = !1;
        this.setData({
            form_field: a
        });
    },
    checkboxChange: function(t) {
        for (var a = this.data.form_field, e = a[t.currentTarget.dataset.index].extra.option, i = t.detail.value, o = 0; o < e.length; o++) {
            e[o].checked = !1;
            for (var n = 0; n < i.length; n++) if (e[o].value == i[n]) {
                e[o].checked = !0;
                break;
            }
        }
        this.setData({
            form_field: a
        });
    },
    bindPickChange: function(t) {
        var a = this.data.form_field, e = t.currentTarget.dataset.index, i = t.detail.value;
        a[e].value = i, this.setData({
            form_field: a
        });
    },
    formSubmit: function(t) {
        var o = this;
        if (o.data.btnDisabled) return !1;
        o.setData({
            btnDisabled: !0
        });
        var a = t.detail.value, e = t.detail.formId, i = o.data.cateIndex, n = o.data.category, s = o.data.album, r = o.data.thumb;
        s && (s = app.util.base64Encode(JSON.stringify(s))), r && (r = app.util.base64Encode(JSON.stringify(r)));
        var d = o.data.video;
        d && (d = app.util.base64Encode(JSON.stringify(d)));
        var c = o.data.city;
        null == c && "全国" == (c = wx.getStorageSync("local_city")) && (c = "");
        var l = o.data.unitIndex, u = o.data.unitList[l].type, p = o.data.unitList[l].title, h = "";
        "" != o.data.book_field && (h = app.util.base64Encode(JSON.stringify(o.data.book_field)));
        var f = "";
        if (o.data.item_id && (f = o.data.item_id), !a.title) return Toptips("请填写标题"), void o.setData({
            btnDisabled: !1
        });
        if (null == i) return Toptips("请选择分类"), void o.setData({
            btnDisabled: !1
        });
        if (0 == u && (!a.price || 0 == a.price) && o.data.onlinePay) return Toptips("价格为0或空时不能设置在线支付"), 
        void o.setData({
            btnDisabled: !1
        });
        if (!o.data.isAgree) return Toptips("请阅读公约"), void o.setData({
            btnDisabled: !1
        });
        var m = o.data.form_field, g = [];
        if (m && 0 < m.length) {
            for (var v = 0; v < m.length; v++) {
                var b = m[v].title;
                if (1 == m[v].required && "" == a[b]) return Toptips(b + "不能为空"), void o.setData({
                    btnDisabled: !1
                });
                var y = encodeURIComponent(a[b]);
                g.push(y);
            }
            g = app.util.base64Encode(JSON.stringify(g));
        }
        var _ = [];
        if (0 < o.data.tagList.length) {
            for (var w = o.data.tagList, x = 0; x < w.length; x++) _.push(encodeURIComponent(w[x]));
            _ = app.util.base64Encode(JSON.stringify(_));
        }
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: e,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            method: "POST",
            data: {
                act: "post",
                id: f,
                isbn: o.data.bookCode ? o.data.bookCode : "",
                title: a.title,
                description: null != a.description ? a.description : "",
                summary: null != a.summary ? a.summary : "",
                book_field: h,
                album: s,
                thumb: r,
                city: c,
                video: d,
                cid: n[i].id,
                address: app.globalData.location,
                buy_type: 0 <= u ? 0 : 1,
                price: u < 0 ? 0 : a.price,
                unit_type: u,
                unit_title: p,
                credit: u < 0 ? a.price : 0,
                formid: e,
                wechatpay: o.data.onlinePay ? 1 : 0,
                lat: app.globalData.lat,
                lng: app.globalData.lng,
                add_field: g,
                stock: a.stock ? a.stock : 1,
                tags: 0 < _.length ? _ : "",
                trade_type: null != o.data.deliveryIndex ? parseInt(o.data.deliveryIndex) + 1 : 0,
                fetch_address: a.fetch_address ? a.fetch_address : app.globalData.location,
                m: "superman_hand2"
            },
            fail: function(t) {
                o.setData({
                    btnDisabled: !1
                }), Toptips(t.data.errmsg);
            },
            success: function(t) {
                if (o.setData({
                    btnDisabled: !1
                }), t.data.errno) Toptips(t.data.errmsg); else {
                    var a = "发布成功", e = 0, i = "../detail/index?id=" + t.data.data.itemid + "&share=1";
                    t.data.data.upload && (e += parseFloat(t.data.data.upload.credit)), t.data.data.category && (e += parseFloat(t.data.data.category.credit)), 
                    1 == o.data.auditType ? (a += "，请等待管理员审核", i = "../home/index") : !f && 0 < e && (a = a + ", " + o.data.credit_title + "+" + e), 
                    o.data.isSetTop && (i = "../set_top/index?post=1&id=" + t.data.data.itemid, a += "，即将跳转至置顶付费页..."), 
                    o.showIconToast(a, "success"), setTimeout(function() {
                        wx.redirectTo({
                            url: i
                        });
                    }, 1500);
                }
            }
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});