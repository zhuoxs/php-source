/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
var t = getApp(),
    e = require("../../zhy/template/wxParse/wxParse.js");
t.Base({
    data: {
        page: 0
    },
    onLoad: function(t) {
        var e = t.info;
        "null" != t.info && t.info || (e = "暂无设置该信息"), this.setData({
            page: t.id,
            info: e
        }), this.onLoadData()
    },
    onLoadData: function() {
        switch (this.data.page - 0) {
            case 1:
                wx.setNavigationBarTitle({
                    title: "提现须知"
                }), e.wxParse("content", "html", this.data.info, this, 10), this.setData({
                    show: !0
                });
                break;
            case 2:
                wx.setNavigationBarTitle({
                    title: "拼团流程说明"
                }), this.getSpellRule();
                break;
            case 3:
                wx.setNavigationBarTitle({
                    title: "免单流程说明"
                }), this.getFreeRule();
                break;
            default:
                e.wxParse("content", "html", "不存在该页面", this, 10), this.setData({
                    show: !0
                })
        }
    },
    getSpellRule: function() {
        var a = this;
        t.api.apiPinGetRules().then(function(t) {
            e.wxParse("content", "html", t.data, a, 10), a.setData({
                show: !0
            })
        }).
        catch (function(e) {
            t.tips(e.msg)
        })
    },
    getFreeRule: function() {
        var a = this;
        t.api.apiFreesheetRuleset().then(function(t) {
            e.wxParse("content", "html", t.data.freesheet_rules, a, 10), a.setData({
                show: !0
            })
        }).
        catch (function(e) {
            t.tips(e.msg)
        })
    }
});