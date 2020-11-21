var city = require("../../utils/city.js"), city1 = require("../../utils/city1.js");

Page({
    data: {
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            circular: !0,
            interval: 3e3,
            duration: 500,
            color: "rgba(0,0,0,.3)",
            acolor: "#000",
            imgUrls: [ {
                img: "../resource/images/swiper_item.png",
                id: 0
            }, {
                img: "../resource/images/swiper_item.png",
                id: 1
            } ]
        },
        nav: {
            nav_list: [ "门诊", "脑外科", "妇科", "妇产科", "血液科", "皮肤科" ],
            currentTab: 0
        },
        footer: {
            footdex: 0,
            txtcolor: "#A2A2A2",
            seltxt: "#EC6464",
            background: "#fff",
            list: [ {
                url: "/pages/index/index",
                icons: "/pages/resource/images/f_1.png",
                selIcon: "/pages/resource/images/f_1_sel.png",
                text: "探一探"
            }, {
                url: "/pages/mine/mine",
                icons: "/pages/resource/images/f_2.png",
                selIcon: "/pages/resource/images/f_2_sel.png",
                text: "个人"
            } ]
        },
        citys: {
            currentCity: "定位中...",
            letterArr: [],
            city1: [],
            hotCitys: [ {
                id: "105",
                provincecode: "340000",
                city: "安庆市",
                code: "340800",
                initial: "A"
            }, {
                id: "7",
                provincecode: "130000",
                city: "保定市",
                code: "130600",
                initial: "B"
            } ]
        }
    },
    swichNav: function(t) {
        var e = this.data.nav;
        e.currentTab = t.currentTarget.dataset.current, this.setData({
            nav: e
        });
    },
    choose: function(t, e, i, a) {
        var n = this, r = n.data.multiArray, s = n.data.multiIndex, c = [];
        for (var l in a) {
            c.push(a[l].name);
            var u = [];
            for (var o in a[t].children) {
                u.push(a[t].children[o].name);
                var d = [];
                for (var h in a[t].children[e].children) d.push(a[t].children[e].children[h].name);
            }
        }
        r.push(c), r.push(u), r.push(d), s.push(t), s.push(e), s.push(i), n.setData({
            multiArray: r,
            multiIndex: s
        });
    },
    onLoad: function(t) {
        var e = this;
        if (null != t.index) {
            var i = this.data.footer;
            i.footdex = t.index, this.setData({
                footer: i
            });
            var a = city.citys();
            e.choose(0, 1, 2, a);
        }
        var n = city.searchLetter, r = city.cityList(), s = n;
        (a = e.data.citys).city1 = r, a.letterArr = s, e.setData({
            citys: a
        });
    },
    confirmClick: function(t) {
        var e = t.target.dataset.a_id, i = new RegExp("[一-龥]+", "g");
        e.search(i) || "定位中..." === e || "获取定位失败" === e || wx.reLaunch({
            url: "/hyb_jianzhi/index/index?a_id=" + e
        });
    },
    anchorClick: function(t) {
        var e = this.data.citys, i = t.currentTarget.dataset.a_id;
        e.toView = i, this.setData({
            citys: e
        });
    },
    getLocation: function() {
        var a = this;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.longitude, i = t.latitude;
                a.loadCity(e, i);
            }
        });
    },
    loadCity: function(t, e) {
        var i = this;
        wx.request({
            url: "https://api.map.baidu.com/geocoder/v2/?ak=RU9iE3025rdZ1lzrxEYWje7DyInsLD2L&location=" + e + "," + t + "&output=json",
            data: {},
            header: {
                "Content-Type": "application/json"
            },
            success: function(t) {
                var e = t.data.result.addressComponent.city;
                i.setData({
                    currentCity: e
                });
            },
            fail: function() {
                i.setData({
                    currentCity: "获取定位失败"
                });
            }
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var e = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        e.multiIndex[t.detail.column] = t.detail.value;
        for (var i = city.citys(), a = [], n = [], r = 0; r < i.length; r++) {
            var s = [];
            if (null == i[r].children) s.push(), n.push(); else {
                for (var c = [], l = 0; l < i[r].children.length; l++) {
                    if (s.push(i[r].children[l].name), null == i[r].children) c.push(); else if (null == i[r].children[l].children) c.push(); else for (var u = [], o = 0; o < i[r].children[l].children.length; o++) u.push(i[r].children[l].children[o].name);
                    c.push(u);
                }
                n.push(c);
            }
            a.push(s);
        }
        for (var d = 0; d < i.length; d++) switch (t.detail.column) {
          case 0:
            if (null == i[d].children) {
                switch (e.multiIndex[0]) {
                  case d:
                    e.multiArray[1] = [], e.multiArray[2] = [];
                }
                e.multiIndex[1] = 0, e.multiIndex[2] = 0;
                break;
            }
            for (var h = 0; h < i[d].children.length; h++) {
                switch (e.multiIndex[0]) {
                  case d:
                    e.multiArray[1] = a[d], e.multiArray[2] = n[d][h];
                }
                e.multiIndex[1] = 0, e.multiIndex[2] = 0;
                break;
            }

          case 1:
            if (null == i[d].children) switch (e.multiIndex[0]) {
              case d:
                switch (e.multiIndex[1]) {
                  case d:
                    e.multiArray[2] = [];
                }
            } else for (var m = 0; m < i[d].children.length; m++) switch (e.multiIndex[0]) {
              case d:
                switch (e.multiIndex[1]) {
                  case m:
                    e.multiArray[2] = n[d][m];
                }
            }
            e.multiIndex[2] = 0;
        }
        this.setData(e);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});