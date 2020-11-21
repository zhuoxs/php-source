var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var o = arguments[e];
        for (var r in o) Object.prototype.hasOwnProperty.call(o, r) && (t[r] = o[r]);
    }
    return t;
}, defaultData = require("./data");

function Dialog(t, e) {
    var o = _extends({}, defaultData, t), r = e;
    if (!r) {
        var n = getCurrentPages();
        r = n[n.length - 1];
    }
    var a = r.selectComponent(o.selector);
    if (!a) return console.error("无法找到对应的dialog组件，请于页面中注册并在 wxml 中声明 dialog 自定义组件"), 
    Promise.reject({
        type: "component error"
    });
    var s = o.buttons, c = void 0 === s ? [] : s, l = !1;
    if (0 === c.length) {
        if (o.showConfirmButton && c.push({
            type: "confirm",
            text: o.confirmButtonText,
            color: o.confirmButtonColor
        }), o.showCancelButton) {
            var i = {
                type: "cancel",
                text: o.cancelButtonText,
                color: o.cancelButtonColor
            };
            o.buttonsShowVertical ? c.push(i) : c.unshift(i);
        }
    } else l = !0;
    return new Promise(function(t, e) {
        a.setData(_extends({}, o, {
            buttons: c,
            showCustomBtns: l,
            key: "" + new Date().getTime(),
            show: !0,
            promiseFunc: {
                resolve: t,
                reject: e
            }
        }));
    });
}

module.exports = Dialog;