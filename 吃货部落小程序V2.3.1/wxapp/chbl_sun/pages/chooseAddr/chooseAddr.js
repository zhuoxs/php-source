var app = getApp();

Page({
    data: {
        select: 0,
        multiArray: [],
        multiIndex: [ 1, 0, 0 ],
        proArray: [],
        cityArray: {},
        countyArray: []
    },
    bindRegionChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            region: t.detail.value
        });
    },
    backIndex: function() {
        wx.navigateBack({});
    },
    refreshAddr: function(t) {
        wx.chooseLocation({
            type: "gcj02",
            success: function(t) {
                console.log(t);
                t.latitude, t.longitude;
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        });
    },
    bindMultiPickerChange: function(t) {
        console.log(t);
    },
    bindMultiPickerColumnChange: function(t) {
        var a = t.detail.column, i = t.detail.value, n = this.data.multiArray, o = this.data.multiIndex || [];
        if (0 === a) {
            var e = n[0][i].id;
            o[0] = i, o[1] = 0, o[2] = 0, n[1] = this.data.cityArray[e], n[2] = this.data.countyArray[n[1][0].id], 
            this.setData({
                multiArray: n,
                multiIndex: o
            });
        } else if (1 === a) {
            o[1] = i, o[2] = 0;
            var r = n[1][i].id;
            n[2] = this.data.countyArray[r], this.setData({
                multiArray: n,
                multiIndex: o
            });
        } else 2 === a && (o[2] = i, this.setData({
            multiIndex: o
        }));
        var c = {};
        c.province_id = n[0][o[0]].id, c.city_id = n[1][o[1]].id, c.id = n[2][o[2]].id, 
        c.name = n[2][o[2]].name, app.set_current_county(c);
    },
    chooseL: function(t) {
        console.log(t);
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {
        var c = this, d = [ 0, 0, 0 ];
        app.util.request({
            url: "entry/wxapp/GetProCityCountyList",
            success: function(o) {
                var e = o.data.pro[0].id, r = o.data.city[e][0].id;
                app.get_current_county().then(function(t) {
                    for (var a = t.province_id, i = t.city_id, n = (t = t.id, 0); n < o.data.pro.length; n++) if (o.data.pro[n].id == a) {
                        d[0] = n, e = o.data.pro[n].id;
                        break;
                    }
                    for (n = 0; n < o.data.city[e].length; n++) if (o.data.city[e][n].id == i) {
                        d[1] = n, r = o.data.city[e][n].id;
                        break;
                    }
                    for (n = 0; n < o.data.county[r].length; n++) if (o.data.county[r][n].id == t) {
                        d[2] = n;
                        break;
                    }
                    c.setData({
                        proArray: o.data.pro,
                        cityArray: o.data.city,
                        countyArray: o.data.county,
                        multiArray: [ o.data.pro, o.data.city[e], o.data.county[r] ],
                        multiIndex: d
                    });
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});