var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(o) {
    return typeof o;
} : function(o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
}, __notices = [], isDebug = !0;

function addNotification(o, t, i) {
    o && t ? (i || console.log("addNotification Warning: no observer will can't remove notice"), 
    console.log("addNotification:" + o), addNotices({
        name: o,
        selector: t,
        observer: i
    })) : console.log("addNotification error: no selector or name");
}

function addOnceNotification(o, t, i) {
    if (0 < __notices.length) for (var e = 0; e < __notices.length; e++) {
        var n = __notices[e];
        if (n.name === o && n.observer === i) return;
    }
    this.addNotification(o, t, i);
}

function addNotices(o) {
    __notices.push(o);
}

function removeNotification(o, t) {
    console.log("removeNotification:" + o);
    for (var i = 0; i < __notices.length; i++) {
        var e = __notices[i];
        if (e.name === o && e.observer === t) return void __notices.splice(i, 1);
    }
}

function postNotificationName(o, t) {
    if (console.log("postNotificationName:" + o), 0 != __notices.length) for (var i = 0; i < __notices.length; i++) {
        var e = __notices[i];
        e.name === o && e.selector(t);
    } else console.log("postNotificationName error: u hadn't add any notice.");
}

function cmp(o, t) {
    if (o === t) return !0;
    if (!(o instanceof Object && t instanceof Object)) return !1;
    if (o.constructor !== t.constructor) return !1;
    for (var i in o) if (o.hasOwnProperty(i)) {
        if (!t.hasOwnProperty(i)) return !1;
        if (o[i] === t[i]) continue;
        if ("object" !== _typeof(o[i])) return !1;
        if (!Object.equals(o[i], t[i])) return !1;
    }
    for (i in t) if (t.hasOwnProperty(i) && !o.hasOwnProperty(i)) return !1;
    return !0;
}

module.exports = {
    addNotification: addNotification,
    removeNotification: removeNotification,
    postNotificationName: postNotificationName,
    addOnceNotification: addOnceNotification
};