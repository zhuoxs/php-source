var t = getApp(), e = t.requirejs("core"), a = t.requirejs("jquery"), r = t.requirejs("biz/selectdate"), i = t.requirejs("foxui");

Page({
    data: {
        status: "0",
        currentDate: "",
        dayList: "",
        currentDayList: "",
        currentObj: "",
        currentDay: "",
        cycelData: {},
        nowDate: "",
        maxday: "",
        cycelbuy_periodic: "",
        period_index: 1,
        cycelid: "",
        orderid: "",
        refundstate: 0
    },
    onLoad: function(e) {
        t.getCache("isIpx") ? this.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : this.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), this.get_list();
    },
    show_cycelbuydate: function() {
        var t = this, e = r.getCurrentDayString(this, t.data.nowDate), a = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ];
        t.setData({
            currentObj: e,
            currentDate: e.getFullYear() + "年" + (e.getMonth() + 1) + "月" + e.getDate() + "日 " + a[e.getDay()],
            currentYear: e.getFullYear(),
            currentMonth: e.getMonth() + 1,
            currentDay: e.getDate(),
            initDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            checkedDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            maxday: t.data.maxday,
            cycelbuy_periodic: t.data.cycelbuy_periodic,
            period_index: t.data.period_index
        });
    },
    cycle: function(t) {
        var e = t.currentTarget.dataset.status + 1;
        this.setData({
            status: t.currentTarget.dataset.status,
            cycelid: t.currentTarget.dataset.id,
            period_index: e
        });
    },
    syclecancle: function() {
        this.setData({
            cycledate: !1
        });
    },
    sycleconfirm: function() {
        var t = this, a = t.data.cycelid, r = t.data.checkedDate / 1e3, c = t.data.orderid, s = t.data.isdelay;
        e.get("order/do_deferred", {
            cycelid: a,
            time: r,
            orderid: c,
            is_all: s
        }, function(e) {
            0 == e.error && i.toast(t, "修改成功");
        }), this.setData({
            cycledate: !1
        });
    },
    editdate: function(t) {
        var a = this, i = t.currentTarget.dataset.isdelay, c = t.currentTarget.dataset.id;
        e.get("order/getCycelbuyDate", {
            cycelid: c
        }, function(t) {
            a.setData({
                nowDate: t.receipttime
            }), a.show_cycelbuydate(), r.setSchedule(a);
        }), this.setData({
            isdelay: i
        }), this.setData({
            cycledate: !0
        });
    },
    doDay: function(t) {
        r.doDay(t, this);
    },
    selectDay: function(t) {
        r.selectDay(t, this), r.setSchedule(this);
    },
    get_list: function() {
        var t = this;
        e.get("order/cycelbuy_list", t.options, function(r) {
            r.error > 0 && 5e4 != list.error && e.toast(list.message, "loading"), 0 == r.notStart && a.each(r.list, function(e, a) {
                1 == a.status ? t.setData({
                    status: e
                }) : t.setData({
                    status: r.period_index
                });
            }), t.setData({
                cycelid: r.list[0].id,
                orderid: r.orderid
            }), t.setData(r);
        });
    },
    confirm_receipt: function(t) {
        var a = this, r = t.currentTarget.dataset.id, c = a.data.orderid;
        e.get("order/confirm_receipt", {
            id: r,
            orderid: c
        }, function(t) {
            0 == t.error && (i.toast(a, "修改成功"), a.onLoad());
        });
    }
});