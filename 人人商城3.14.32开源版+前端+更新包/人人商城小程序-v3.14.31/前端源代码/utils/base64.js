var r = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", o = function(r) {
    r = r.replace(/\r\n/g, "\n");
    for (var o = "", e = 0; e < r.length; e++) {
        var t = r.charCodeAt(e);
        t < 128 ? o += String.fromCharCode(t) : t > 127 && t < 2048 ? (o += String.fromCharCode(t >> 6 | 192), 
        o += String.fromCharCode(63 & t | 128)) : (o += String.fromCharCode(t >> 12 | 224), 
        o += String.fromCharCode(t >> 6 & 63 | 128), o += String.fromCharCode(63 & t | 128));
    }
    return o;
}, e = function(r) {
    for (var o = "", e = 0, t = 0, a = 0, n = 0; e < r.length; ) (t = r.charCodeAt(e)) < 128 ? (o += String.fromCharCode(t), 
    e++) : t > 191 && t < 224 ? (a = r.charCodeAt(e + 1), o += String.fromCharCode((31 & t) << 6 | 63 & a), 
    e += 2) : (a = r.charCodeAt(e + 1), n = r.charCodeAt(e + 2), o += String.fromCharCode((15 & t) << 12 | (63 & a) << 6 | 63 & n), 
    e += 3);
    return o;
};

module.exports.encode = function(e) {
    var t, a, n, h, C, d, c, f = "", i = 0;
    for (e = o(e); i < e.length; ) h = (t = e.charCodeAt(i++)) >> 2, C = (3 & t) << 4 | (a = e.charCodeAt(i++)) >> 4, 
    d = (15 & a) << 2 | (n = e.charCodeAt(i++)) >> 6, c = 63 & n, isNaN(a) ? d = c = 64 : isNaN(n) && (c = 64), 
    f = f + r.charAt(h) + r.charAt(C) + r.charAt(d) + r.charAt(c);
    return f;
}, module.exports.decode = function(o) {
    var t, a, n, h, C, d, c = "", f = 0;
    for (o = o.replace(/[^A-Za-z0-9\+\/\=]/g, ""); f < o.length; ) t = r.indexOf(o.charAt(f++)) << 2 | (h = r.indexOf(o.charAt(f++))) >> 4, 
    a = (15 & h) << 4 | (C = r.indexOf(o.charAt(f++))) >> 2, n = (3 & C) << 6 | (d = r.indexOf(o.charAt(f++))), 
    c += String.fromCharCode(t), 64 != C && (c += String.fromCharCode(a)), 64 != d && (c += String.fromCharCode(n));
    return c = e(c);
};