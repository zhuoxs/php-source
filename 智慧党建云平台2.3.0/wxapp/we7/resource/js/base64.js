module.exports = {
    base64_encode: function(r) {
        for (var e, a, t, h = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", o = 0, c = r.length, d = ""; o < c; ) {
            if (e = 255 & r.charCodeAt(o++), o == c) {
                d += h.charAt(e >> 2), d += h.charAt((3 & e) << 4), d += "==";
                break;
            }
            if (a = r.charCodeAt(o++), o == c) {
                d += h.charAt(e >> 2), d += h.charAt((3 & e) << 4 | (240 & a) >> 4), d += h.charAt((15 & a) << 2), 
                d += "=";
                break;
            }
            t = r.charCodeAt(o++), d += h.charAt(e >> 2), d += h.charAt((3 & e) << 4 | (240 & a) >> 4), 
            d += h.charAt((15 & a) << 2 | (192 & t) >> 6), d += h.charAt(63 & t);
        }
        return d;
    },
    base64_decode: function(r) {
        for (var e, a, t, h, o = new Array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1), c = 0, d = r.length, i = ""; c < d; ) {
            do {
                e = o[255 & r.charCodeAt(c++)];
            } while (c < d && -1 == e);
            if (-1 == e) break;
            do {
                a = o[255 & r.charCodeAt(c++)];
            } while (c < d && -1 == a);
            if (-1 == a) break;
            i += String.fromCharCode(e << 2 | (48 & a) >> 4);
            do {
                if (61 == (t = 255 & r.charCodeAt(c++))) return i;
                t = o[t];
            } while (c < d && -1 == t);
            if (-1 == t) break;
            i += String.fromCharCode((15 & a) << 4 | (60 & t) >> 2);
            do {
                if (61 == (h = 255 & r.charCodeAt(c++))) return i;
                h = o[h];
            } while (c < d && -1 == h);
            if (-1 == h) break;
            i += String.fromCharCode((3 & t) << 6 | h);
        }
        return i;
    }
};