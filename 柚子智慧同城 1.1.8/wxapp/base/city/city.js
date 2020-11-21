/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            text: "选择省",
            state: 0,
            sadcode: ""
        }, {
            text: "选择市",
            state: 1,
            sadcode: ""
        }, {
            text: "选择区/县",
            state: 2,
            sadcode: ""
        }],
        currentcity: "厦门",
        curHdIndex: 0,
        sadcode: ""
    },
    swichNav: function(a) {
        var e = this,
            c = this,
            n = a.currentTarget.dataset.state,
            i = a.currentTarget.dataset.sadcode;
        c.data.city;
        if (0 == n) t.api.apiCityGetProvinceList({
            state: n
        }).then(function(t) {
            e.setData({
                city: t.data,
                curHdIndex: 0,
                show: !0
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        });
        else if (1 == n) {
            if (!i) return wx.showModal({
                title: "提示",
                content: "请选择省份",
                showCancel: !1
            }), !1;
            t.api.apiCityGetProvinceList({
                state: n,
                adcode: i
            }).then(function(t) {
                e.setData({
                    city: t.data,
                    curHdIndex: 1,
                    show: !0
                })
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        }
    },
    onLoad: function(a) {
        var e = this,
            c = this,
            n = wx.getStorageSync("currentcity");
        c.data.currcurrentcityCity;
        c.setData({
            currentcity: n
        }), t.api.apiCityGetProvinceList().then(function(t) {
            e.setData({
                city: t.data,
                show: !0
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    selectprovince: function(a) {
        var e = this,
            c = e.data.curHdIndex,
            n = a.currentTarget.dataset.adcode,
            i = a.currentTarget.dataset.name,
            d = (e.data.nav, a.currentTarget.dataset.id);
        0 == c && e.setData({
            "nav[0].text": i,
            curHdIndex: c + 1,
            "nav[1].sadcode": n,
            parent_id: d,
            level: "city"
        }), 1 == c && e.setData({
            "nav[1].text": i,
            curHdIndex: c + 1,
            "nav[2].sadcode": n,
            parent_id: d,
            level: "district"
        }), 2 == c && e.setData({
            "nav[2].text": i,
            curHdIndex: 0,
            "nav[2].sadcode": n
        }), 3 == c && e.setData({
            curHdIndex: 0
        }), t.api.apiCityGetCityArea({
            parent_id: this.data.parent_id,
            level: this.data.level
        }).then(function(a) {
            2 == c ? t.api.apiCityGetCityByAdcode({
                adcode: n
            }).then(function(a) {
                wx.setStorageSync("currentcity", a.data.name);
                var e = {
                    citylng: a.data.lng,
                    citylat: a.data.lat,
                    cityadcode: a.data.adcode
                };
                wx.setStorageSync("cityaddress", e), t.lunchTo("/pages/home/home")
            }).
            catch (function(a) {
                t.tips(a.msg)
            }) : e.setData({
                city: a.data
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    commitSearch: function(a) {
        var e = this,
            c = a.detail.value;
        "" != c ? t.api.apiCityGetSearchCity({
            key: c
        }).then(function(t) {
            e.setData({
                city: t.data,
                curHdIndex: 2
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        }) : wx.showModal({
            title: "提示",
            content: "请输入搜索内容",
            showCancel: !1
        })
    },
    cancel: function() {
        this.setData({
            curHdIndex: 0
        }), t.lunchTo("/pages/home/home")
    }
});