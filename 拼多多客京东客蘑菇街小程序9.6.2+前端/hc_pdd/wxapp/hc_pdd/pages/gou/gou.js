var _data;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var selectIndex, attrIndex, app = getApp(), selectIndexArray = [], selectAttrid = [];

Page({
    data: (_data = {
        picture: [ {
            img: "https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=3438576193,3301397209&fm=27&gp=0.jpg"
        }, {
            img: "https://ss3.bdstatic.com/70cFv8Sh_Q1YnxGkpoWK1HF6hhy/it/u=1525546566,2404337493&fm=27&gp=0.jpg"
        }, {
            img: "https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=3028702483,4182396631&fm=27&gp=0.jpg"
        } ],
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0,
        num: 1,
        amount: 0,
        minusStatus: "disabled",
        choose_modal: "block",
        flag: 0
    }, _defineProperty(_data, "choose_modal", !0), _defineProperty(_data, "spec", [ {
        id: 1,
        name: "颜色分类",
        child: [ {
            id: 11,
            name: "宝蓝色【送地毯】",
            isSelect: !0
        }, {
            id: 111,
            name: "湖蓝色【送地毯】",
            isSelect: !1
        }, {
            id: 111,
            name: "灰色【送地毯】",
            isSelect: !1
        }, {
            id: 111,
            name: "深咖啡色【送地毯】",
            isSelect: !1
        }, {
            id: 111,
            name: "三件套【送地毯+茶几+电视柜】",
            isSelect: !1
        } ]
    }, {
        id: 2,
        name: "几人做",
        child: [ {
            id: 21,
            name: "3人坐",
            isSelect: !0
        }, {
            id: 22,
            name: "1+3+转",
            isSelect: !1
        }, {
            id: 22,
            name: "海绵版【纯海绵座包】",
            isSelect: !1
        } ]
    }, {
        id: 3,
        name: "尺寸",
        child: [ {
            id: 21,
            name: "1号",
            isSelect: !0
        }, {
            id: 22,
            name: "2号",
            isSelect: !1
        } ]
    } ]), _defineProperty(_data, "selectName", ""), _defineProperty(_data, "selectAttrid", []), 
    _defineProperty(_data, "goods_info", {}), _data),
    onLoad: function(t) {
        var e = this;
        wx.request({
            url: app.globalData.host + "/index.php/app/goods/goodsDetails/goods_id/34",
            header: {
                "Content-type": "application/json"
            },
            success: function(t) {
                console.log(t.data.data.goods_info), e.setData({
                    goods_info: t.data.data.goods_info
                }), e.init_attr();
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindMinus: function() {
        var t = this.data.num;
        1 < t && t--;
        var e = t <= 1 ? "disabled" : "normal";
        this.setData({
            num: t,
            minusStatus: e
        }), this.change_spec(), this.change_price();
    },
    bindPlus: function() {
        var t = this.data.num, e = ++t < 1 ? "disabled" : "normal";
        this.setData({
            num: t,
            minusStatus: e
        }), this.change_spec(), this.change_price();
    },
    bindManual: function(t) {
        var e = t.detail.value;
        isNaN(e) && (e = 1), this.setData({
            num: parseInt(e)
        }), this.change_spec(), this.change_price();
    },
    modal_show: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            flag: e,
            choose_modal: "block"
        });
    },
    modal_none: function() {
        this.setData({
            choose_modal: "none"
        });
    },
    clickAttr: function(t) {
        for (var e = t.currentTarget.dataset.selectIndex, a = t.currentTarget.dataset.attrIndex, i = this.data.spec, n = i[e].child.length, s = 0; s < n; s++) i[e].child[s].isSelect = !1;
        i[e].child[a].isSelect = !0;
        i[e].child[a].name, i[e].child[a].id;
        console.log(""), this.setData({
            spec: i,
            selectName: "",
            selectAttrid: selectAttrid
        });
    },
    init_attr: function() {
        for (var t = "", e = this.data.spec, a = e.length, i = 0; i < a; i++) selectIndexArray.push({
            key: i,
            value: e[i].child[0].name
        }), selectAttrid.push(e[i].child[0].id), t += ' "' + selectIndexArray[i].value + '" ';
        var n = this.data.selectName;
        n = t, this.setData({
            selectName: n,
            selectAttrid: selectAttrid
        });
    }
});