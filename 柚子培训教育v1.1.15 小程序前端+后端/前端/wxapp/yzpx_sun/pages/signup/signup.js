var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (t[s] = e[s]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        schoolChoose: 0,
        lessonChoose: 0,
        username: "",
        tel: "",
        remark: "",
        nonePage: !1
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("shopinfo");
        this.setData({
            sid: a.sid
        }), this.onloadData();
    },
    onloadData: function() {
        var o = this, s = this;
        0 == this.data.sid ? Promise.all([ (0, _api.WeData)(), (0, _api.SchoolListData)({
            page: 1,
            length: 1e3,
            select_type: 2
        }), (0, _api.AllCourseData)({
            sid: 0
        }) ]).then(function(t) {
            var a = {
                name: t[0].name + "(总校)",
                id: 0
            };
            t[1].unshift(a);
            var e = [];
            for (var s in t[2]) 1 == t[2][s].status && e.push(t[2][s]);
            o.setData({
                schoollist: t[1],
                lesson: e
            }), e.length < 1 && wx.showModal({
                title: "提示",
                content: "该分校暂无预约课程，请选择其他分校！",
                showCancel: !1,
                success: function(t) {}
            });
        }) : Promise.all([ (0, _api.AllCourseData)({
            sid: this.data.sid
        }) ]).then(function(t) {
            var a = [];
            for (var e in t[0]) 1 == t[0][e].status && a.push(t[0][e]);
            o.setData({
                lesson: a
            }), a.length < 1 && wx.showModal({
                title: "提示",
                content: "本校暂无预约课程！",
                showCancel: !1,
                success: function(t) {
                    s.lunchTo("../home/home?sid=" + s.data.sid);
                }
            });
        });
    },
    onChangeLessonTab: function(t) {
        this.setData({
            lessonChoose: t.detail.value
        });
    },
    onChangeSchoolTab: function(t) {
        var s = this;
        this.setData({
            schoolChoose: t.detail.value
        }), (0, _api.AllCourseData)({
            sid: this.data.schoollist[t.detail.value].id
        }).then(function(t) {
            var a = [];
            for (var e in t) 1 == t[e].status && a.push(t[e]);
            s.setData({
                lesson: a
            }), a.length < 1 && wx.showModal({
                title: "提示",
                content: "该分校暂无预约课程，请选择其他分校！",
                showCancel: !1,
                success: function(t) {}
            });
        });
    },
    onSendTab: function(t) {
        var a = this, e = t.detail.formId, s = wx.getStorageSync("userInfo"), o = {
            cid: this.data.lesson[this.data.lessonChoose].id,
            uid: s.wxInfo.id,
            username: this.data.username,
            tel: this.data.tel,
            remark: this.data.remark,
            formId: e
        };
        0 < this.data.sid ? o.sid = this.data.sid : o.sid = this.data.schoollist[this.data.schoolChoose].id, 
        o.username.length < 2 ? wx.showToast({
            title: "请填写正确姓名！",
            icon: "none",
            duration: 2e3
        }) : o.tel.length < 11 ? wx.showToast({
            title: "请填写正确手机号码！",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CourseOrderData)(o).then(function(t) {
            wx.showToast({
                title: "恭喜您，预约课程成功！",
                icon: "none",
                duration: 2e3
            }), setTimeout(function() {
                a.lunchTo("../home/home");
            }, 1e3);
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    getName: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            username: a
        });
    },
    getTel: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            tel: a
        });
    },
    getRemark: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            remark: a
        });
    }
}));