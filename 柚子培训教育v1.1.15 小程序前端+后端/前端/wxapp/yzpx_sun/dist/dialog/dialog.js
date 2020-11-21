var defaultData = require("./data");

function Dialog(t, e) {
    var o = Object.assign({}, defaultData, t), n = e;
    if (!n) {
        var r = getCurrentPages();
        n = r[r.length - 1];
    }
    var a = n.selectComponent(o.selector);
    if (!a) return console.error("无法找到对应的dialog组件，请于页面中注册并在 wxml 中声明 dialog 自定义组件"), 
    Promise.reject({
        type: "component error"
    });
    var s = o.buttons, c = void 0 === s ? [] : s, i = !1;
    if (0 === c.length) {
        if (o.showConfirmButton && c.push({
            type: "confirm",
            text: o.confirmButtonText,
            color: o.confirmButtonColor
        }), o.showCancelButton) {
            var l = {
                type: "cancel",
                text: o.cancelButtonText,
                color: o.cancelButtonColor
            };
            o.buttonsShowVertical ? c.push(l) : c.unshift(l);
        }
    } else i = !0;
    return new Promise(function(t, e) {
        a.setData(Object.assign({}, o, {
            buttons: c,
            showCustomBtns: i,
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