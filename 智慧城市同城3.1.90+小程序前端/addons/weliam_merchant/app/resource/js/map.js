window.qq = window.qq || {}, qq.maps = qq.maps || {}, window.soso || (window.soso = qq), soso.maps || (soso.maps = qq.maps), qq.maps.Geolocation = function () {
    "use strict";
    var t = null,
        e = null,
        o = null,
        n = null,
        l = null,
        i = "_geoIframe_" + Math.ceil(1e7 * Math.random()),
        u = document.createElement("iframe"),
        a = null,
        s = null,
        c = null,
        r = null,
        d = function (d, m) {
            if (!d) return void alert("error key!");
            if (!m) return void alert("error referer!");
            var p = document.getElementById(i);
            if (!p) {
                u.setAttribute("id", i);
                var g = "https:";
                u.setAttribute("src", g + "//apis.map.qq.com/tools/geolocation?key=" + d + "&referer=" + m), u.setAttribute("style", "display: none; width: 100%; height: 30%"), document.body ? document.body.appendChild(u) : document.write(u.outerHTML), window.addEventListener("message", function (i) {
                    var u = i.data;
                    if (u && "geolocation" == u.module) clearTimeout(r), t && t(u), t = null, e = null, o && o(u), o = null, n = null, l && l(u);
                    else {
                        s = (new Date).getTime();
                        var d = s - a;
                        d >= c && (e && e(), e = null, t = null, clearTimeout(r)), n && n(), n = null, o = null
                    }
                }, !1)
            }
        };
    return d.prototype.getLocation = function (o, n, l) {
        t = o, e = n, a = (new Date).getTime(), c = l && l.timeout ? +l.timeout : 1e4, clearTimeout(r), r = setTimeout(function () {
            e && e(), e = null
        }, c), document.getElementById(i).contentWindow.postMessage("getLocation", "*")
    }, d.prototype.getIpLocation = function (t, e) {
        o = t, n = e, document.getElementById(i).contentWindow.postMessage("getLocation.robust", "*")
    }, d.prototype.watchPosition = function (t) {
        l = t, document.getElementById(i).contentWindow.postMessage("watchPosition", "*")
    }, d.prototype.clearWatch = function () {
        l = null, document.getElementById(i).contentWindow.postMessage("clearWatch", "*")
    }, d
}();