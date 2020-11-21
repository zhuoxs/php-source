var t = getApp();

Page({
    data: {
        buzhou: 0,
        buzhouButtom: "下一步",
        loucengArray: [],
        loucengIndex: [ 0, 0 ],
        picker: [ "东", "南", "西", "北", "南北", "东西", "东南", "东北", "西南", "西北" ],
        pickerindex: "",
        zhuangxiu: [ "精装修", "简装修", "毛坯" ],
        zhuangxiuindex: "",
        huxingArray: [],
        huxingIndex: [ 0, 0, 0 ],
        yafuArray: [ [ "无押金", "押1", "押2", "押3", "押4", "押5", "押6", "押7", "押8", "押9", "押10", "押11", "押12" ], [ "付1", "付2", "付3", "付4", "付5", "付6", "付7", "付8", "付9", "付10", "付11", "付12" ] ],
        yafuIndex: [ 0, 0 ],
        iconList: [],
        taglist: [],
        id: "",
        type_id: "",
        name: "",
        area: "",
        price: "",
        imgList: [],
        loading: !0,
        esheshi: [],
        mapx: "",
        mapy: "",
        address: "",
        tagcheck: []
    },
    bindViewTap: function() {
        wx.navigateTo({
            url: "../logs/logs"
        });
    },
    onShow: function() {
        var t = [], e = [];
        t[0] = "请选择楼层", e[0] = "";
        for (s = 1; s < 103; s++) t[s] = s - 3 + "层", e[s] = "共" + s + "层";
        var a = [ t, e ];
        this.setData({
            loucengArray: a
        });
        var i = [], n = [], u = [];
        i[0] = "请选择户型", n[0] = "0厅", u[0] = "0卫";
        for (var s = 1; s < 10; s++) i[s] = s + "室", n[s] = s + "厅", u[s] = s + "卫";
        var o = [ i, n, u ];
        this.setData({
            huxingArray: o
        });
    },
    onLoad: function() {
        var e = this, a = {
            uid: wx.getStorageSync("uid"),
            m: "ox_reathouse",
            r: "publish.add_power"
        };
        t.util.request({
            url: "entry/wxapp/Api",
            data: a,
            method: "POST",
            success: function(a) {
                e.setData({
                    iconList: a.data.data.other.sheshi,
                    taglist: a.data.data.other.tag
                }), "no" == a.data.data.uid ? (console.log(a), t.util.message({
                    title: "您没有权限发布",
                    type: "error"
                }), setTimeout(function() {
                    wx.switchTab({
                        url: "../index/index"
                    });
                }, 3e3)) : "0" != a.data.data.id && (console.log(a), wx.showModal({
                    title: "提示",
                    content: "您有未填写完的数据是否继续",
                    success: function(t) {
                        t.confirm && e.loaddata(a.data.data);
                    }
                }));
            }
        });
    },
    loaddata: function(t) {
        console.log(t), this.setData({
            id: t.id,
            type_id: t.type_id,
            name: t.name,
            loucengIndex: [ Number(t.floor1) + 3, t.floor2 - 1 ],
            pickerindex: t.oriented_id,
            huxingIndex: [ t.house_type_shi, t.house_type_ting, t.house_type_wei ],
            area: t.area,
            zhuangxiuindex: t.renovation,
            price: t.price,
            yafuIndex: [ t.yafu_ya, t.yafu_fu - 1 ],
            imgList: t.imgs,
            esheshi: t.sheshi
        });
    },
    loucengChange: function(t) {
        this.setData({
            loucengIndex: t.detail.value
        });
    },
    loucengColumnChange: function(t) {},
    huxingChange: function(t) {
        this.setData({
            huxingIndex: t.detail.value
        });
    },
    huxingColumnChange: function(t) {},
    yafuChange: function(t) {
        this.setData({
            yafuIndex: t.detail.value
        });
    },
    yafuColumnChange: function(t) {},
    PickerChange: function(t) {
        this.setData({
            pickerindex: t.detail.value
        });
    },
    zhuangxiuChange: function(t) {
        this.setData({
            zhuangxiuindex: t.detail.value
        });
    },
    tijiao: function() {
        1 == this.data.buzhou && this.setData({
            buzhouButtom: "提交"
        }), this.setData({
            buzhou: this.data.buzhou + 1
        });
    },
    fantijiao: function() {
        2 == this.data.buzhou && this.setData({
            buzhouButtom: "下一步"
        }), this.setData({
            buzhou: this.data.buzhou - 1
        });
    },
    hometype: function(t) {
        this.setData({
            type_id: t.currentTarget.dataset.id
        });
    },
    formSubmit: function(e) {
        var a = this;
        if (0 == a.data.buzhou) {
            if (0 == a.data.type_id) return void t.util.message({
                title: "请选择出租类型",
                type: "error"
            });
            if ("" == e.detail.value.name || "undefined" == e.detail.value.name) return void t.util.message({
                title: "请填写小区名称",
                type: "error"
            });
            if (0 == a.data.loucengIndex[0] || 0 == a.data.loucengIndex[1]) return void t.util.message({
                title: "请选择楼层",
                type: "error"
            });
            if ("" == a.data.pickerindex) return void t.util.message({
                title: "请选择朝向",
                type: "error"
            });
            if (0 == a.data.huxingIndex[0]) return void t.util.message({
                title: "请选择户型",
                type: "error"
            });
            if ("" == e.detail.value.area || "undefined" == e.detail.value.area) return void t.util.message({
                title: "请填写房屋面积",
                type: "error"
            });
            if ("" == a.data.zhuangxiuindex) return void t.util.message({
                title: "请选择装修类型",
                type: "error"
            });
            if ("" == e.detail.value.price || "undefined" == e.detail.value.price) return void t.util.message({
                title: "请填写月租金",
                type: "error"
            });
            a.data.yafuIndex[0], a.setData({
                name: e.detail.value.name,
                area: e.detail.value.area,
                price: e.detail.value.price
            });
            var i = {
                id: a.data.id,
                type_id: a.data.type_id,
                name: a.data.name,
                floor1: a.data.loucengIndex[0],
                floor2: a.data.loucengIndex[1],
                oriented_id: a.data.pickerindex,
                house_type_shi: a.data.huxingIndex[0],
                house_type_ting: a.data.huxingIndex[1],
                house_type_wei: a.data.huxingIndex[2],
                area: a.data.area,
                renovation: a.data.zhuangxiuindex,
                price: a.data.price,
                yafu_ya: a.data.yafuIndex[0],
                yafu_fu: a.data.yafuIndex[1],
                uid: wx.getStorageSync("uid"),
                m: "ox_reathouse",
                r: "publish.add_one"
            };
            t.util.request({
                url: "entry/wxapp/Api",
                data: i,
                method: "POST",
                success: function(t) {
                    a.setData({
                        id: t.data.data.id
                    }), console.log(a.data.id), a.nexbuzhou();
                }
            });
        } else if (1 == a.data.buzhou) {
            if (a.data.imgList.length < 1) return void t.util.message({
                title: "请上传图片",
                type: "error"
            });
            if (a.data.esheshi.length < 1) return void t.util.message({
                title: "请选择设施",
                type: "error"
            });
            var n = {
                id: a.data.id,
                esheshi: a.data.esheshi,
                imgs: JSON.stringify(a.data.imgList),
                uid: wx.getStorageSync("uid"),
                m: "ox_reathouse",
                r: "publish.add_two"
            };
            t.util.request({
                url: "entry/wxapp/Api",
                data: n,
                method: "POST",
                success: function(t) {
                    a.nexbuzhou();
                }
            });
        } else {
            if ("" == a.data.address) return void t.util.message({
                title: "请点击获取位置",
                type: "error"
            });
            if ("" == e.detail.value.desc || "undefined" == e.detail.value.desc) return void t.util.message({
                title: "请填写房源描述",
                type: "error"
            });
            if (a.data.tagcheck.length < 1) return void t.util.message({
                title: "请选择标签",
                type: "error"
            });
            var u = {
                id: a.data.id,
                address: a.data.address,
                mapx: a.data.mapx,
                mapy: a.data.mapy,
                tagcheck: a.data.tagcheck,
                desc: e.detail.value.desc,
                uid: wx.getStorageSync("uid"),
                m: "ox_reathouse",
                r: "publish.add_three"
            };
            t.util.request({
                url: "entry/wxapp/Api",
                data: u,
                method: "POST",
                success: function(e) {
                    t.util.message({
                        title: "发布完成",
                        type: "success"
                    }), setTimeout(function() {
                        wx.switchTab({
                            url: "../index/index"
                        });
                    }, 3e3);
                }
            });
        }
    },
    nexbuzhou: function() {
        1 == this.data.buzhou && this.setData({
            buzhouButtom: "提交"
        }), this.setData({
            buzhou: this.data.buzhou + 1
        });
    },
    iconselect: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.iconList;
        a[e].xzicon = !a[e].xzicon;
        for (var i = [], n = 0; n < this.data.iconList.length; n++) this.data.iconList[n].xzicon && i.push(this.data.iconList[n].id);
        this.setData({
            iconList: a,
            esheshi: i
        });
    },
    deleteImg: function(t) {
        var e = t.currentTarget.dataset.id, a = this.data.imgList;
        a.splice(e, 1), this.setData({
            imgList: a
        });
    },
    uplaod: function() {
        var e = this;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            success: function(a) {
                var i = a.tempFilePaths, n = a.tempFilePaths.length, u = 1;
                e.setData({
                    loading: !1
                });
                for (var s in i) wx.uploadFile({
                    url: t.util.url("entry/wxapp/Api", {
                        m: "ox_reathouse",
                        r: "upload.save"
                    }),
                    filePath: i[s],
                    name: "file",
                    success: function(t) {
                        var a = JSON.parse(t.data), i = e.data.imgList;
                        i.push(a.data), e.setData({
                            imgList: i
                        }), u == n && e.setData({
                            loading: !0
                        }), u += 1;
                    }
                });
            }
        });
    },
    tomap: function() {
        var t = this;
        wx.chooseLocation({
            success: function(e) {
                console.log(e), t.setData({
                    mapx: e.latitude,
                    mapy: e.longitude,
                    address: e.address
                });
            },
            fail: function() {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || wx.showModal({
                            content: "请允许获取地理位置后再次尝试",
                            success: function(t) {
                                t.confirm ? wx.openSetting({
                                    success: function(t) {
                                        t.authSetting = {
                                            "scope.userInfo": !0,
                                            "scope.userLocation": !0
                                        };
                                    },
                                    fail: function(t) {
                                        console.log(t);
                                    }
                                }) : t.cancel && console.log("用户点击取消");
                            }
                        });
                    }
                });
            }
        });
    },
    tagselect: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.taglist;
        a[e].xuanzhong = !a[e].xuanzhong, this.setData({
            taglist: a
        });
        for (var i = [], n = 0; n < this.data.taglist.length; n++) this.data.taglist[n].xuanzhong && i.push(this.data.taglist[n].id);
        this.setData({
            tagcheck: i
        });
    }
});