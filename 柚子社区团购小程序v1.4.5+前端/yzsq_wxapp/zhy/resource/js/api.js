function getTimeStr(t) {
    return t = (t = t.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]).getTime() / 1e3;
}

var api = require("./baseapi");

api.getCpinBanner = function() {
    return this.post("Cpin|banner");
}, api.getCpinClassifyList = function() {
    return this.post("Cpin|classifyList").then(function(i) {
        return i.data.unshift({
            id: 0,
            name: "热销"
        }), i.data.forEach(function(t, a) {
            i.data[a].is_hot = a ? 0 : 1;
        }), Promise.resolve(i);
    });
}, api.getCpinGoodsList = function(t) {
    var e = new Date().getTime() / 1e3;
    return this.post("Cpin|goodsList", t, 0, !1).then(function(i) {
        return i.data || (i.data = []), i.data.forEach(function(t, a) {
            e < t.start_time ? i.data[a].btn_status = 1 : e >= t.start_time && e < t.end_time ? i.data[a].btn_status = 2 : i.data[a].btn_status = 3;
        }), Promise.resolve(i);
    });
}, api.getCpinGoodsDetails = function(t) {
    var d = this;
    new Date().getTime();
    return this.post("Cpin|goodsDetails", t, 0, !1).then(function(a) {
        if (0 < a.data.use_attr) {
            var i = ",", e = ",", t = "";
            for (var n in a.data.attr_group_list) i += a.data.attr_group_list[n].attr_list[0].id + ",", 
            e += a.data.attr_group_list[n].attr_list[0].name + ",", a.data.attr_group_list[n].attr_list[0].choose = !0, 
            t += a.data.attr_group_list[n].attr_list[0].name + " ";
            a.data.choose_name = t;
            var r = {
                goods_id: a.data.id,
                attr_ids: i
            };
            return d.getCpinGetAttrInfo(r).then(function(t) {
                return a.data.choose_type = t.data, a.data.attr_list = e, a.data.attr_ids = i, a.data.ladder_id = 0, 
                a.data.groupnum = a.data.need_num, a.data.groupmoney = t.data.pin_price, a.data.reduce_mopney = "拼团立省： ￥" + (a.data.original_price - t.data.pin_price).toFixed(2), 
                Promise.resolve(a);
            });
        }
        var o = {
            id: 0,
            goods_id: a.data.id,
            stock: a.data.stock,
            price: a.data.price,
            weight: a.data.weight,
            pic: a.data.pic,
            pin_price: a.data.pin_price
        };
        return a.data.attr_list = "", a.data.attr_ids = "", 0 < a.data.is_ladder ? a.data.ladder_info ? (a.data.ladder_info[0].choose = !0, 
        a.data.reduce_mopney = "拼团立省： ￥" + (a.data.original_price - a.data.ladder_info[0].groupmoney).toFixed(2), 
        a.data.ladder_id = a.data.ladder_info[0].id, a.data.groupnum = a.data.ladder_info[0].groupnum, 
        a.data.groupmoney = a.data.ladder_info[0].groupmoney, o.pin_price = a.data.ladder_info[0].groupmoney) : a.data.reduce_mopney = "阶梯团数据不完整，请商家设置！" : (a.data.ladder_id = 0, 
        a.data.groupnum = a.data.need_num, a.data.groupmoney = a.data.pin_price, a.data.reduce_mopney = "拼团立省： ￥" + (a.data.original_price - a.data.pin_price).toFixed(2)), 
        a.data.choose_type = o, Promise.resolve(a);
    });
}, api.getCpinGetAttrInfo = function(t) {
    return this.post("Cpin|getAttrInfo", t, 0, !1);
}, api.getCpinGetDistribution = function(t) {
    return this.post("Cpin|getDistribution", t, 0, !1);
}, api.getCpinGetBuy = function(t) {
    return this.post("Cpin|getBuy", t, 0, !1);
}, api.getCpinJoinGroup = function(t) {
    return this.post("Cpin|joinGroup", t, 0, !1);
}, api.getCpinOrderDetails = function(t) {
    return this.post("Cpin|orderDetails", t, 0, !1);
}, api.getCpinAgainPay = function(t) {
    return this.post("Cpin|againPay", t, 0, !1);
}, api.getCpinBalancePay = function(t) {
    return this.post("Cpin|balancePay", t, 0, !1);
}, api.getCpinJoinPage = function(t) {
    return this.post("Cpin|joinPage", t, 0, !1).then(function(t) {
        var a = new Date().getTime() / 1e3 - getTimeStr(t.data.headinfo.create_time), i = 3600 * (t.data.goodsinfo.group_time - 0), e = t.data.headinfo.groupnum, n = t.data.grouppaynum, r = t.data.groupnum;
        return t.data.btn_status = 0, t.data.btn_status = e <= n ? 2 : 0 < i - a ? e <= r ? 1 : 0 : 3, 
        Promise.resolve(t);
    });
}, api.getCpinOrderList = function(t) {
    return this.post("Cpin|orderList", t, 0, !1);
}, api.getCpinCancleOrd = function(t) {
    return this.post("Cpin|cancleOrd", t, 0, !1);
}, api.getCpinConfirmOrd = function(t) {
    return this.post("Cpin|confirmOrd", t, 0, !1);
}, api.getCpinGetRules = function() {
    return this.post("Cpin|getRules");
}, api.getCpinAddComment = function(t) {
    return this.post("Cpin|addComment", t, 0, !1);
}, api.getCpinUseOrd = function(t) {
    return this.post("Cpin|useOrd", t, 0, !1);
}, api.getcseckillGetOrder = function(t) {
    return this.post("Cseckill|getOrder", t, 0, !1);
}, api.getcseckillverifyorder = function(t) {
    return this.post("Cseckill|verifyOrder", t, 0, !1);
}, api.getCpinOrdernumFind = function(t) {
    return this.post("Cpin|ordernumFind", t, 0, !1);
}, api.getCstoreGetStore = function(t) {
    return this.post("Cstore|getStore", t, 0, !1);
}, module.exports = api;