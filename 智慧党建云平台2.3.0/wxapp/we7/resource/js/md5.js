!function(n) {
    function r(n, r) {
        var t = (65535 & n) + (65535 & r);
        return (n >> 16) + (r >> 16) + (t >> 16) << 16 | 65535 & t;
    }
    function t(n, r) {
        return n << r | n >>> 32 - r;
    }
    function e(n, e, u, o, c, f) {
        return r(t(r(r(e, n), r(o, f)), c), u);
    }
    function u(n, r, t, u, o, c, f) {
        return e(r & t | ~r & u, n, r, o, c, f);
    }
    function o(n, r, t, u, o, c, f) {
        return e(r & u | t & ~u, n, r, o, c, f);
    }
    function c(n, r, t, u, o, c, f) {
        return e(r ^ t ^ u, n, r, o, c, f);
    }
    function f(n, r, t, u, o, c, f) {
        return e(t ^ (r | ~u), n, r, o, c, f);
    }
    function i(n, t) {
        n[t >> 5] |= 128 << t % 32, n[14 + (t + 64 >>> 9 << 4)] = t;
        var e, i, a, h, g, l = 1732584193, d = -271733879, v = -1732584194, C = 271733878;
        for (e = 0; e < n.length; e += 16) i = l, a = d, h = v, g = C, d = f(d = f(d = f(d = f(d = c(d = c(d = c(d = c(d = o(d = o(d = o(d = o(d = u(d = u(d = u(d = u(d, v = u(v, C = u(C, l = u(l, d, v, C, n[e], 7, -680876936), d, v, n[e + 1], 12, -389564586), l, d, n[e + 2], 17, 606105819), C, l, n[e + 3], 22, -1044525330), v = u(v, C = u(C, l = u(l, d, v, C, n[e + 4], 7, -176418897), d, v, n[e + 5], 12, 1200080426), l, d, n[e + 6], 17, -1473231341), C, l, n[e + 7], 22, -45705983), v = u(v, C = u(C, l = u(l, d, v, C, n[e + 8], 7, 1770035416), d, v, n[e + 9], 12, -1958414417), l, d, n[e + 10], 17, -42063), C, l, n[e + 11], 22, -1990404162), v = u(v, C = u(C, l = u(l, d, v, C, n[e + 12], 7, 1804603682), d, v, n[e + 13], 12, -40341101), l, d, n[e + 14], 17, -1502002290), C, l, n[e + 15], 22, 1236535329), v = o(v, C = o(C, l = o(l, d, v, C, n[e + 1], 5, -165796510), d, v, n[e + 6], 9, -1069501632), l, d, n[e + 11], 14, 643717713), C, l, n[e], 20, -373897302), v = o(v, C = o(C, l = o(l, d, v, C, n[e + 5], 5, -701558691), d, v, n[e + 10], 9, 38016083), l, d, n[e + 15], 14, -660478335), C, l, n[e + 4], 20, -405537848), v = o(v, C = o(C, l = o(l, d, v, C, n[e + 9], 5, 568446438), d, v, n[e + 14], 9, -1019803690), l, d, n[e + 3], 14, -187363961), C, l, n[e + 8], 20, 1163531501), v = o(v, C = o(C, l = o(l, d, v, C, n[e + 13], 5, -1444681467), d, v, n[e + 2], 9, -51403784), l, d, n[e + 7], 14, 1735328473), C, l, n[e + 12], 20, -1926607734), v = c(v, C = c(C, l = c(l, d, v, C, n[e + 5], 4, -378558), d, v, n[e + 8], 11, -2022574463), l, d, n[e + 11], 16, 1839030562), C, l, n[e + 14], 23, -35309556), v = c(v, C = c(C, l = c(l, d, v, C, n[e + 1], 4, -1530992060), d, v, n[e + 4], 11, 1272893353), l, d, n[e + 7], 16, -155497632), C, l, n[e + 10], 23, -1094730640), v = c(v, C = c(C, l = c(l, d, v, C, n[e + 13], 4, 681279174), d, v, n[e], 11, -358537222), l, d, n[e + 3], 16, -722521979), C, l, n[e + 6], 23, 76029189), v = c(v, C = c(C, l = c(l, d, v, C, n[e + 9], 4, -640364487), d, v, n[e + 12], 11, -421815835), l, d, n[e + 15], 16, 530742520), C, l, n[e + 2], 23, -995338651), v = f(v, C = f(C, l = f(l, d, v, C, n[e], 6, -198630844), d, v, n[e + 7], 10, 1126891415), l, d, n[e + 14], 15, -1416354905), C, l, n[e + 5], 21, -57434055), v = f(v, C = f(C, l = f(l, d, v, C, n[e + 12], 6, 1700485571), d, v, n[e + 3], 10, -1894986606), l, d, n[e + 10], 15, -1051523), C, l, n[e + 1], 21, -2054922799), v = f(v, C = f(C, l = f(l, d, v, C, n[e + 8], 6, 1873313359), d, v, n[e + 15], 10, -30611744), l, d, n[e + 6], 15, -1560198380), C, l, n[e + 13], 21, 1309151649), v = f(v, C = f(C, l = f(l, d, v, C, n[e + 4], 6, -145523070), d, v, n[e + 11], 10, -1120210379), l, d, n[e + 2], 15, 718787259), C, l, n[e + 9], 21, -343485551), 
        l = r(l, i), d = r(d, a), v = r(v, h), C = r(C, g);
        return [ l, d, v, C ];
    }
    function a(n) {
        var r, t = "", e = 32 * n.length;
        for (r = 0; r < e; r += 8) t += String.fromCharCode(n[r >> 5] >>> r % 32 & 255);
        return t;
    }
    function h(n) {
        var r, t = [];
        for (t[(n.length >> 2) - 1] = void 0, r = 0; r < t.length; r += 1) t[r] = 0;
        var e = 8 * n.length;
        for (r = 0; r < e; r += 8) t[r >> 5] |= (255 & n.charCodeAt(r / 8)) << r % 32;
        return t;
    }
    function g(n) {
        return a(i(h(n), 8 * n.length));
    }
    function l(n, r) {
        var t, e, u = h(n), o = [], c = [];
        for (o[15] = c[15] = void 0, u.length > 16 && (u = i(u, 8 * n.length)), t = 0; t < 16; t += 1) o[t] = 909522486 ^ u[t], 
        c[t] = 1549556828 ^ u[t];
        return e = i(o.concat(h(r)), 512 + 8 * r.length), a(i(c.concat(e), 640));
    }
    function d(n) {
        var r, t, e = "";
        for (t = 0; t < n.length; t += 1) r = n.charCodeAt(t), e += "0123456789abcdef".charAt(r >>> 4 & 15) + "0123456789abcdef".charAt(15 & r);
        return e;
    }
    function v(n) {
        return unescape(encodeURIComponent(n));
    }
    function C(n) {
        return g(v(n));
    }
    function s(n) {
        return d(C(n));
    }
    function A(n, r) {
        return l(v(n), v(r));
    }
    function m(n, r) {
        return d(A(n, r));
    }
    module.exports = function(n, r, t) {
        return r ? t ? A(r, n) : m(r, n) : t ? C(n) : s(n);
    };
}();