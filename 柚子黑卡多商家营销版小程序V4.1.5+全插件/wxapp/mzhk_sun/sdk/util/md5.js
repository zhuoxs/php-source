Object.defineProperty(exports, "__esModule", {
    value: !0
});

var hexcase = 0, b64pad = "", chrsz = 8;

function hex_md5(d) {
    return binl2hex(core_md5(str2binl(d), d.length * chrsz));
}

function b64_md5(d) {
    return binl2b64(core_md5(str2binl(d), d.length * chrsz));
}

function str_md5(d) {
    return binl2str(core_md5(str2binl(d), d.length * chrsz));
}

function hex_hmac_md5(d, r) {
    return binl2hex(core_hmac_md5(d, r));
}

function b64_hmac_md5(d, r) {
    return binl2b64(core_hmac_md5(d, r));
}

function str_hmac_md5(d, r) {
    return binl2str(core_hmac_md5(d, r));
}

function md5_vm_test() {
    return "900150983cd24fb0d6963f7d28e17f72" == hex_md5("abc");
}

function core_md5(d, r) {
    d[r >> 5] |= 128 << r % 32, d[14 + (r + 64 >>> 9 << 4)] = r;
    for (var _ = 1732584193, m = -271733879, n = -1732584194, t = 271733878, e = 0; e < d.length; e += 16) {
        var h = _, f = m, i = n, c = t;
        m = md5_ii(m = md5_ii(m = md5_ii(m = md5_ii(m = md5_hh(m = md5_hh(m = md5_hh(m = md5_hh(m = md5_gg(m = md5_gg(m = md5_gg(m = md5_gg(m = md5_ff(m = md5_ff(m = md5_ff(m = md5_ff(m, n = md5_ff(n, t = md5_ff(t, _ = md5_ff(_, m, n, t, d[e + 0], 7, -680876936), m, n, d[e + 1], 12, -389564586), _, m, d[e + 2], 17, 606105819), t, _, d[e + 3], 22, -1044525330), n = md5_ff(n, t = md5_ff(t, _ = md5_ff(_, m, n, t, d[e + 4], 7, -176418897), m, n, d[e + 5], 12, 1200080426), _, m, d[e + 6], 17, -1473231341), t, _, d[e + 7], 22, -45705983), n = md5_ff(n, t = md5_ff(t, _ = md5_ff(_, m, n, t, d[e + 8], 7, 1770035416), m, n, d[e + 9], 12, -1958414417), _, m, d[e + 10], 17, -42063), t, _, d[e + 11], 22, -1990404162), n = md5_ff(n, t = md5_ff(t, _ = md5_ff(_, m, n, t, d[e + 12], 7, 1804603682), m, n, d[e + 13], 12, -40341101), _, m, d[e + 14], 17, -1502002290), t, _, d[e + 15], 22, 1236535329), n = md5_gg(n, t = md5_gg(t, _ = md5_gg(_, m, n, t, d[e + 1], 5, -165796510), m, n, d[e + 6], 9, -1069501632), _, m, d[e + 11], 14, 643717713), t, _, d[e + 0], 20, -373897302), n = md5_gg(n, t = md5_gg(t, _ = md5_gg(_, m, n, t, d[e + 5], 5, -701558691), m, n, d[e + 10], 9, 38016083), _, m, d[e + 15], 14, -660478335), t, _, d[e + 4], 20, -405537848), n = md5_gg(n, t = md5_gg(t, _ = md5_gg(_, m, n, t, d[e + 9], 5, 568446438), m, n, d[e + 14], 9, -1019803690), _, m, d[e + 3], 14, -187363961), t, _, d[e + 8], 20, 1163531501), n = md5_gg(n, t = md5_gg(t, _ = md5_gg(_, m, n, t, d[e + 13], 5, -1444681467), m, n, d[e + 2], 9, -51403784), _, m, d[e + 7], 14, 1735328473), t, _, d[e + 12], 20, -1926607734), n = md5_hh(n, t = md5_hh(t, _ = md5_hh(_, m, n, t, d[e + 5], 4, -378558), m, n, d[e + 8], 11, -2022574463), _, m, d[e + 11], 16, 1839030562), t, _, d[e + 14], 23, -35309556), n = md5_hh(n, t = md5_hh(t, _ = md5_hh(_, m, n, t, d[e + 1], 4, -1530992060), m, n, d[e + 4], 11, 1272893353), _, m, d[e + 7], 16, -155497632), t, _, d[e + 10], 23, -1094730640), n = md5_hh(n, t = md5_hh(t, _ = md5_hh(_, m, n, t, d[e + 13], 4, 681279174), m, n, d[e + 0], 11, -358537222), _, m, d[e + 3], 16, -722521979), t, _, d[e + 6], 23, 76029189), n = md5_hh(n, t = md5_hh(t, _ = md5_hh(_, m, n, t, d[e + 9], 4, -640364487), m, n, d[e + 12], 11, -421815835), _, m, d[e + 15], 16, 530742520), t, _, d[e + 2], 23, -995338651), n = md5_ii(n, t = md5_ii(t, _ = md5_ii(_, m, n, t, d[e + 0], 6, -198630844), m, n, d[e + 7], 10, 1126891415), _, m, d[e + 14], 15, -1416354905), t, _, d[e + 5], 21, -57434055), n = md5_ii(n, t = md5_ii(t, _ = md5_ii(_, m, n, t, d[e + 12], 6, 1700485571), m, n, d[e + 3], 10, -1894986606), _, m, d[e + 10], 15, -1051523), t, _, d[e + 1], 21, -2054922799), n = md5_ii(n, t = md5_ii(t, _ = md5_ii(_, m, n, t, d[e + 8], 6, 1873313359), m, n, d[e + 15], 10, -30611744), _, m, d[e + 6], 15, -1560198380), t, _, d[e + 13], 21, 1309151649), n = md5_ii(n, t = md5_ii(t, _ = md5_ii(_, m, n, t, d[e + 4], 6, -145523070), m, n, d[e + 11], 10, -1120210379), _, m, d[e + 2], 15, 718787259), t, _, d[e + 9], 21, -343485551), 
        _ = safe_add(_, h), m = safe_add(m, f), n = safe_add(n, i), t = safe_add(t, c);
    }
    return Array(_, m, n, t);
}

function md5_cmn(d, r, _, m, n, t) {
    return safe_add(bit_rol(safe_add(safe_add(r, d), safe_add(m, t)), n), _);
}

function md5_ff(d, r, _, m, n, t, e) {
    return md5_cmn(r & _ | ~r & m, d, r, n, t, e);
}

function md5_gg(d, r, _, m, n, t, e) {
    return md5_cmn(r & m | _ & ~m, d, r, n, t, e);
}

function md5_hh(d, r, _, m, n, t, e) {
    return md5_cmn(r ^ _ ^ m, d, r, n, t, e);
}

function md5_ii(d, r, _, m, n, t, e) {
    return md5_cmn(_ ^ (r | ~m), d, r, n, t, e);
}

function core_hmac_md5(d, r) {
    var _ = str2binl(d);
    16 < _.length && (_ = core_md5(_, d.length * chrsz));
    for (var m = Array(16), n = Array(16), t = 0; t < 16; t++) m[t] = 909522486 ^ _[t], 
    n[t] = 1549556828 ^ _[t];
    var e = core_md5(m.concat(str2binl(r)), 512 + r.length * chrsz);
    return core_md5(n.concat(e), 640);
}

function safe_add(d, r) {
    var _ = (65535 & d) + (65535 & r);
    return (d >> 16) + (r >> 16) + (_ >> 16) << 16 | 65535 & _;
}

function bit_rol(d, r) {
    return d << r | d >>> 32 - r;
}

function str2binl(d) {
    for (var r = Array(), _ = (1 << chrsz) - 1, m = 0; m < d.length * chrsz; m += chrsz) r[m >> 5] |= (d.charCodeAt(m / chrsz) & _) << m % 32;
    return r;
}

function binl2str(d) {
    for (var r = "", _ = (1 << chrsz) - 1, m = 0; m < 32 * d.length; m += chrsz) r += String.fromCharCode(d[m >> 5] >>> m % 32 & _);
    return r;
}

function binl2hex(d) {
    for (var r = hexcase ? "0123456789ABCDEF" : "0123456789abcdef", _ = "", m = 0; m < 4 * d.length; m++) _ += r.charAt(d[m >> 2] >> m % 4 * 8 + 4 & 15) + r.charAt(d[m >> 2] >> m % 4 * 8 & 15);
    return _;
}

function binl2b64(d) {
    for (var r = "", _ = 0; _ < 4 * d.length; _ += 3) for (var m = (d[_ >> 2] >> _ % 4 * 8 & 255) << 16 | (d[_ + 1 >> 2] >> (_ + 1) % 4 * 8 & 255) << 8 | d[_ + 2 >> 2] >> (_ + 2) % 4 * 8 & 255, n = 0; n < 4; n++) 8 * _ + 6 * n > 32 * d.length ? r += b64pad : r += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(m >> 6 * (3 - n) & 63);
    return r;
}

exports.default = {
    md5: hex_md5
};