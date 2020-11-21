function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

function changeFeature(e) {
    for (var a = e.value, t = [], r = 0, i = a.length; r < i; r++) t.push({
        attr: a[r],
        price: "",
        stock: ""
    });
    return e.value = t, console.log(e), e;
}

function trancategoryIndex(e, a) {
    if (0 == e) return 0;
    for (var t = 0, r = a.length; t < r; t++) if (e == a[t].id) return t + 1;
    return 0;
}

function tranAttrs(e) {
    var a = [];
    for (var t in e) a.push({
        attr: t,
        price: e[t].price,
        stock: e[t].stock,
        img: e[t].img
    });
    return a;
}

function tranarriveIndex(e, a) {
    if (0 == e) return 0;
    for (var t = 0, r = a.length; t < r; t++) if (e == a[t].id) return t + 1;
    return 0;
}

function getUrlParam(e, a) {
    var t = new RegExp("(^|&)" + a + "=([^&]*)(&|$)"), r = e.split("?")[1].match(t);
    return null != r ? unescape(r[2]) : null;
}

Page({
    data: {
        category: [ {
            id: 0,
            name: "请选择分类"
        } ],
        categoryIndex: 0,
        img: "../../images/add_image.png",
        ecid: -1,
        presell: -1,
        arrive: [ {
            id: 0,
            name: "不选择"
        } ],
        arriveIndex: 0,
        feature: {
            name: "",
            value: []
        },
        param: [],
        shareImg: {},
        bimg: {},
        imgs: [],
        content: ""
    },
    cleardata: function(e) {
        e.setData({
            categoryIndex: 0,
            img: "../../images/add_image.png",
            ecid: -1,
            presell: -1,
            arrive: [ {
                id: 0,
                name: "不选择"
            } ],
            arriveIndex: 0,
            feature: {
                name: "",
                value: []
            },
            name: "",
            param: [],
            shareImg: {},
            bimg: {},
            imgs: [],
            oprice: "",
            prices: "",
            unit: "",
            number: "",
            weight: "",
            content: "",
            status: 1
        }), e.selectComponent("#editor").clear();
    },
    changeecid: function(e) {
        console.log("12455555"), this.setData({
            ecid: -this.data.ecid
        });
    },
    changeCategory: function(e) {
        var a = e.detail.value;
        if (this.setData({
            categoryIndex: e.detail.value
        }), 0 == a) ; else {
            var t = this;
            app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !1,
                data: {
                    op: "categoryToFeature",
                    id: t.data.category[a].id
                },
                success: function(e) {
                    var a = e.data;
                    a.data.list && t.setData({
                        feature: changeFeature(a.data.list)
                    });
                }
            });
        }
    },
    changeArrive: function(e) {
        var a = e.detail.value;
        this.setData({
            arriveIndex: a
        });
    },
    goodImg: function() {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            success: function(e) {
                if (4194304 < e.tempFilePaths[0].size) app.look.alert("图片尺寸不能大于4m"); else {
                    var a = {};
                    a.path = e.tempFilePaths[0], a.temp = !0, t.setData({
                        bimg: a
                    }), console.log(t.data.bimg);
                }
            }
        });
    },
    addimgone: function(e) {
        var t = app.util.url("entry/wxapp/uploadex", {
            m: app.globalData.m
        }), a = wx.getStorageSync("userInfo").sessionid;
        t = t + "&state=we7sid-" + a;
        var n = e.target.dataset.file, o = e.target.dataset.parent, s = e.target.dataset.index, l = this;
        wx.chooseImage({
            count: 1,
            success: function(e) {
                if (4194304 < e.tempFiles[0].size) app.look.alert("上传图片大小不能超过4M"); else {
                    var a = e.tempFilePaths[0];
                    wx.uploadFile({
                        url: t,
                        filePath: a,
                        name: "file",
                        success: function(e) {
                            if (console.log(e), 0 == (e = JSON.parse(e.data)).errno) {
                                var a = {};
                                if (o) {
                                    var t = o.split("."), r = t[0], i = l.data[r];
                                    (1 == t.length ? i : i[t[1]])[s][n] = e.data, a[r] = i;
                                } else a[n] = e.data;
                                l.setData(a);
                            }
                        }
                    });
                }
            }
        });
    },
    addimgs: function(e) {
        var a = e.target.dataset.op, i = e.target.dataset.file, n = this, o = app.util.url("entry/wxapp/uploadex", {
            m: app.globalData.m
        }), t = wx.getStorageSync("userInfo").sessionid;
        if (o = o + "&state=we7sid-" + t, "add" == a) {
            var r = this.data.imgs.length;
            6 <= r && app.look.alert("最多上传6张图片"), wx.chooseImage({
                count: 6 - r,
                sizeType: [ "compressed" ],
                success: function(e) {
                    for (var a = e.tempFilePaths, t = 0, r = a.length; t < r; t++) wx.uploadFile({
                        url: o,
                        filePath: a[t],
                        name: "file",
                        success: function(e) {
                            if (console.log(e), 0 == (e = JSON.parse(e.data)).errno) {
                                console.log(e.data), n.data[i].push(e.data);
                                var a = {};
                                a[i] = n.data[i], n.setData(a);
                            }
                        }
                    });
                }
            });
        } else {
            var s = e.target.dataset.index;
            wx.chooseImage({
                count: 1,
                sizeType: [ "compressed" ],
                success: function(e) {
                    var a = e.tempFilePaths;
                    wx.uploadFile({
                        url: o,
                        filePath: a[0],
                        name: "file",
                        success: function(e) {
                            if (0 == (e = JSON.parse(e.data)).errno) {
                                n.data[i][s] = e.data;
                                var a = {};
                                a[i] = n.data[i], n.setData(a);
                            }
                        }
                    });
                }
            });
        }
    },
    delimgs: function(e) {
        this.data.imgs.splice(e.currentTarget.dataset.index, 1), this.setData({
            imgs: this.data.imgs
        }), console.log();
    },
    changePresell: function(e) {
        console.log(e), this.setData({
            presell: e.detail.value ? 1 : -1
        });
    },
    delAttrItem: function(e) {
        var a = this.data.feature.value;
        0 < this.data.feature.value.length ? (a.splice(e.currentTarget.dataset.index, 1), 
        this.setData(_defineProperty({}, "feature.value", a))) : app.look.alert("商品至少一属性");
    },
    addAttr: function() {
        var e = this.data.feature.value;
        e.push({
            attr: "",
            price: "",
            stock: ""
        }), this.setData(_defineProperty({}, "feature.value", e));
    },
    delParamItem: function(e) {
        var a = this.data.param;
        a.splice(e.currentTarget.dataset.index, 1), this.setData({
            param: a
        });
    },
    addParam: function() {
        var e = this.data.param;
        e.push({
            name: "",
            value: ""
        }), this.setData({
            param: e
        });
    },
    inputValueParam: function(e) {
        var a = e.currentTarget.dataset.index, t = e.currentTarget.dataset.current;
        this.setData(_defineProperty({}, "param[" + a + "]." + t, e.detail.value));
    },
    inputValue: function(e) {
        var a = e.currentTarget.dataset.index, t = e.currentTarget.dataset.current;
        this.setData(_defineProperty({}, "feature.value[" + a + "]." + t, e.detail.value));
    },
    addShareImg: function() {
        var t = this;
        wx.chooseImage({
            count: 1,
            success: function(e) {
                if (4194304 < e.tempFiles[0].size) app.look.alert("图片尺寸过大"); else {
                    var a = {};
                    a.path = e.tempFilePaths[0], a.temp = !0, t.setData({
                        shareImg: a
                    });
                }
            }
        });
    },
    delShareImg: function() {
        this.setData({
            shareImg: ""
        });
    },
    okEvent: function(e) {
        console.log(e), this.setData({
            content: e.detail
        });
    },
    myform: function(e) {
        var a = e.detail.value;
        if ("" !== a.name) if (0 !== a.cid) if ("" != a.bimg) if ("" != a.oprice) if ("" !== a.prices) if ("" !== a.weight) if ("" != a.attr_name) {
            var t = this.data.feature;
            if (0 != t.value.length) {
                for (var r = 0, i = t.value.length; r < i; r++) {
                    if ("" === t.value[r].attr) return void app.look.alert("属性值");
                    if ("" === t.value[r].price) return void app.look.alert("属性售价");
                    if ("" === t.value[r].stock) return void app.look.alert("库存");
                }
                var n = this.data.param;
                if (0 < n.length) for (r = 0, i = n.length; r < i; r++) {
                    if ("" == n[r].name) return void app.look.alert("参数名");
                    if ("" == n[r].value) return void app.look.alert("参数值");
                }
                this.data.content;
                var o = this.data.imgs, s = [];
                for (r = 0; r < o.length; r++) s.push(o[r].path);
                var l = this;
                app.util.request({
                    url: "entry/wxapp/manage",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "savegoodv2",
                        value: JSON.stringify(a),
                        feature: JSON.stringify(t.value),
                        content: this.data.content,
                        param: JSON.stringify(n),
                        imgs: JSON.stringify(s),
                        presell: this.data.presell,
                        id: this.options.id,
                        ecid: this.data.ecid
                    },
                    success: function(e) {
                        e.data.data;
                        0 == l.options.id ? wx.showModal({
                            title: "操作成功",
                            content: "增加成功",
                            cancelText: "返回列表",
                            confirmText: "继续增加",
                            success: function(e) {
                                e.confirm ? l.cleardata(l) : e.cancel && wx.redirectTo({
                                    url: "/xc_xinguwu/manage/goodsManage/goodsManage"
                                });
                            }
                        }) : wx.showToast({
                            title: "修改成功",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            } else app.look.alert("商品至少一个属性");
        } else app.look.alert("属性名称"); else app.look.alert("商品重量"); else app.look.alert("商品价格"); else app.look.alert("商品原价"); else app.look.alert("商品图片"); else app.look.alert("商品分类"); else app.look.alert("商品名称");
    },
    onLoad: function(e) {
        var i = this;
        (this.options = e).id || (e.id = 0), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "addGood",
                id: e.id
            },
            success: function(e) {
                var a = e.data;
                if (a.data.category && i.setData({
                    category: i.data.category.concat(a.data.category)
                }), a.data.label && i.setData({
                    arrive: i.data.arrive.concat(a.data.label)
                }), a.data.good) {
                    var t, r = a.data.good;
                    console.log(r), i.setData((_defineProperty(t = {
                        name: r.name,
                        categoryIndex: trancategoryIndex(r.cid, a.data.category),
                        bimg: r.bimg,
                        oprice: r.oprice,
                        prices: r.prices,
                        unit: r.unit,
                        number: r.number,
                        weight: r.weight
                    }, "feature.name", r.attr_name), _defineProperty(t, "feature.value", tranAttrs(r.attrs)), 
                    _defineProperty(t, "param", app.look.istrue(r.param) ? r.param : i.data.param), 
                    _defineProperty(t, "presell", r.presell), _defineProperty(t, "presellDate", r.presell_time), 
                    _defineProperty(t, "arriveIndex", tranarriveIndex(r.arrive, a.data.label)), _defineProperty(t, "shareImg", r.share.img), 
                    _defineProperty(t, "shareTitle", r.share.title), _defineProperty(t, "shareTitle", r.share.title), 
                    _defineProperty(t, "content", r.contents), _defineProperty(t, "status", r.status), 
                    _defineProperty(t, "imgs", r.imgs), t)), console.log(r.contents), i.selectComponent("#editor").setContents({
                        html: r.contents
                    });
                }
            }
        });
    },
    onReady: function() {
        var e = new app.util.date();
        this.setData({
            date: e.dateToStr("yyyy-MM-dd"),
            presellDate: e.dateToStr("yyyy-MM-dd")
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    editorinput: function(e) {
        this.data.content = e.detail.html;
    },
    editorupfileimg: function() {
        var t = this.selectComponent("#editor"), r = app.util.url("entry/wxapp/uploadex", {
            m: app.globalData.m
        }), e = wx.getStorageSync("userInfo").sessionid;
        r = r + "&state=we7sid-" + e, wx.chooseImage({
            count: 9,
            sizeType: [ "compressed" ],
            success: function(e) {
                e.tempFilePaths.forEach(function(e, a) {
                    console.log(e), wx.uploadFile({
                        url: r,
                        filePath: e,
                        name: "file",
                        success: function(e) {
                            console.log(e), 0 == (e = JSON.parse(e.data)).errno && (t.backfun(e.data.url), console.log(e.data.url));
                        }
                    });
                });
            }
        });
    }
});