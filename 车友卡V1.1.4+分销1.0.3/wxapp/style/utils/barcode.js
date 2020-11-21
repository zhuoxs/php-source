var CHAR_TILDE = 126, CODE_FNC1 = 102, SET_STARTA = 103, SET_STARTB = 104, SET_STARTC = 105, SET_SHIFT = 98, SET_CODEA = 101, SET_CODEB = 100, SET_STOP = 106, REPLACE_CODES = {
    CHAR_TILDE: CODE_FNC1
}, CODESET = {
    ANY: 1,
    AB: 2,
    A: 3,
    B: 4,
    C: 5
};

function getBytes(t) {
    for (var E = [], r = 0; r < t.length; r++) E.push(t.charCodeAt(r));
    return E;
}

function stringToCode128(t) {
    var E, r, e, T = {
        currcs: CODESET.C
    }, i = getBytes(t), C = i[0] == CHAR_TILDE ? 1 : 0, s = 0 < i.length ? codeSetAllowedFor(i[C++]) : CODESET.AB, S = 0 < i.length ? codeSetAllowedFor(i[C++]) : CODESET.AB;
    T.currcs = (r = S, e = 0, e += (E = s) == CODESET.A ? 1 : 0, e += E == CODESET.B ? -1 : 0, 
    e += r == CODESET.A ? 1 : 0, 0 < (e += r == CODESET.B ? -1 : 0) ? CODESET.A : CODESET.B), 
    T.currcs = function(t, E) {
        for (var r = 0; r < t.length; r++) {
            var e = t[r];
            if ((e < 48 || 57 < e) && e != CHAR_TILDE) return E;
        }
        return CODESET.C;
    }(i, T.currcs);
    var h = new Array();
    switch (T.currcs) {
      case CODESET.A:
        h.push(SET_STARTA);
        break;

      case CODESET.B:
        h.push(SET_STARTB);
        break;

      default:
        h.push(SET_STARTC);
    }
    for (var c = 0; c < i.length; c++) {
        var o = i[c];
        o in REPLACE_CODES && (h.push(REPLACE_CODES[o]), o = i[++c]);
        var a = i.length > c + 1 ? i[c + 1] : -1;
        h = h.concat(D(o, a, T.currcs)), T.currcs == CODESET.C && c++;
    }
    for (var n = h[0], l = 1; l < h.length; l++) n += l * h[l];
    return h.push(n % 103), h.push(SET_STOP), h;
    function D(t, E, r) {
        var e = [], i = -1;
        if (charCompatible(t, r)) r == CODESET.C && (-1 == E ? (i = SET_CODEB, r = CODESET.B) : -1 == E || charCompatible(E, r) || (charCompatible(E, CODESET.A) ? (i = SET_CODEA, 
        r = CODESET.A) : (i = SET_CODEB, r = CODESET.B))); else if (-1 == E || charCompatible(E, r)) i = SET_SHIFT; else switch (r) {
          case CODESET.A:
            i = SET_CODEB, r = CODESET.B;
            break;

          case CODESET.B:
            i = SET_CODEA, r = CODESET.A;
        }
        return -1 != i ? (e.push(i), e.push(codeValue(t))) : r == CODESET.C ? e.push(codeValue(t, E)) : e.push(codeValue(t)), 
        T.currcs = r, e;
    }
}

function codeValue(t, E) {
    return void 0 === E ? 32 <= t ? t - 32 : t + 64 : parseInt(String.fromCharCode(t) + String.fromCharCode(E));
}

function charCompatible(t, E) {
    var r = codeSetAllowedFor(t);
    return r == CODESET.ANY || (r == CODESET.AB || (r == CODESET.A && E == CODESET.A || r == CODESET.B && E == CODESET.B));
}

function codeSetAllowedFor(t) {
    return 48 <= t && t <= 57 ? CODESET.ANY : 32 <= t && t <= 95 ? CODESET.AB : t < 32 ? CODESET.A : CODESET.B;
}

exports.code128 = function(t, E, r, e) {
    r = parseInt(r), e = parseInt(e);
    for (var i = stringToCode128(E), T = new Graphics(t, r, e), C = T.area.width / (11 * (i.length - 3) + 35), s = T.area.left, S = T.area.top, h = 0; h < i.length; h++) for (var c = i[h], o = 0; o < 8; o += 2) {
        var a = PATTERNS[c][o] * C, n = e - S, l = PATTERNS[c][o + 1] * C;
        0 < a && T.fillFgRect(s, S, a, n), s += a + l;
    }
    t.draw();
};

var Graphics = function(t, E, r) {
    this.width = E, this.height = r, this.quiet = Math.round(this.width / 40), this.border_size = 0, 
    this.padding_width = 0, this.area = {
        width: E - 2 * this.padding_width - 2 * this.quiet,
        height: r - 2 * this.border_size,
        top: this.border_size - 4,
        left: this.padding_width + this.quiet
    }, this.ctx = t, this.fg = "#000000", this.bg = "#ffffff", this.fillBgRect(0, 0, E, r), 
    this.fillBgRect(0, this.border_size, E, r - 2 * this.border_size);
};

Graphics.prototype._fillRect = function(t, E, r, e, i) {
    this.ctx.setFillStyle(i), this.ctx.fillRect(t, E, r, e);
}, Graphics.prototype.fillFgRect = function(t, E, r, e) {
    this._fillRect(t, E, r, e, this.fg);
}, Graphics.prototype.fillBgRect = function(t, E, r, e) {
    this._fillRect(t, E, r, e, this.bg);
};

var PATTERNS = [ [ 2, 1, 2, 2, 2, 2, 0, 0 ], [ 2, 2, 2, 1, 2, 2, 0, 0 ], [ 2, 2, 2, 2, 2, 1, 0, 0 ], [ 1, 2, 1, 2, 2, 3, 0, 0 ], [ 1, 2, 1, 3, 2, 2, 0, 0 ], [ 1, 3, 1, 2, 2, 2, 0, 0 ], [ 1, 2, 2, 2, 1, 3, 0, 0 ], [ 1, 2, 2, 3, 1, 2, 0, 0 ], [ 1, 3, 2, 2, 1, 2, 0, 0 ], [ 2, 2, 1, 2, 1, 3, 0, 0 ], [ 2, 2, 1, 3, 1, 2, 0, 0 ], [ 2, 3, 1, 2, 1, 2, 0, 0 ], [ 1, 1, 2, 2, 3, 2, 0, 0 ], [ 1, 2, 2, 1, 3, 2, 0, 0 ], [ 1, 2, 2, 2, 3, 1, 0, 0 ], [ 1, 1, 3, 2, 2, 2, 0, 0 ], [ 1, 2, 3, 1, 2, 2, 0, 0 ], [ 1, 2, 3, 2, 2, 1, 0, 0 ], [ 2, 2, 3, 2, 1, 1, 0, 0 ], [ 2, 2, 1, 1, 3, 2, 0, 0 ], [ 2, 2, 1, 2, 3, 1, 0, 0 ], [ 2, 1, 3, 2, 1, 2, 0, 0 ], [ 2, 2, 3, 1, 1, 2, 0, 0 ], [ 3, 1, 2, 1, 3, 1, 0, 0 ], [ 3, 1, 1, 2, 2, 2, 0, 0 ], [ 3, 2, 1, 1, 2, 2, 0, 0 ], [ 3, 2, 1, 2, 2, 1, 0, 0 ], [ 3, 1, 2, 2, 1, 2, 0, 0 ], [ 3, 2, 2, 1, 1, 2, 0, 0 ], [ 3, 2, 2, 2, 1, 1, 0, 0 ], [ 2, 1, 2, 1, 2, 3, 0, 0 ], [ 2, 1, 2, 3, 2, 1, 0, 0 ], [ 2, 3, 2, 1, 2, 1, 0, 0 ], [ 1, 1, 1, 3, 2, 3, 0, 0 ], [ 1, 3, 1, 1, 2, 3, 0, 0 ], [ 1, 3, 1, 3, 2, 1, 0, 0 ], [ 1, 1, 2, 3, 1, 3, 0, 0 ], [ 1, 3, 2, 1, 1, 3, 0, 0 ], [ 1, 3, 2, 3, 1, 1, 0, 0 ], [ 2, 1, 1, 3, 1, 3, 0, 0 ], [ 2, 3, 1, 1, 1, 3, 0, 0 ], [ 2, 3, 1, 3, 1, 1, 0, 0 ], [ 1, 1, 2, 1, 3, 3, 0, 0 ], [ 1, 1, 2, 3, 3, 1, 0, 0 ], [ 1, 3, 2, 1, 3, 1, 0, 0 ], [ 1, 1, 3, 1, 2, 3, 0, 0 ], [ 1, 1, 3, 3, 2, 1, 0, 0 ], [ 1, 3, 3, 1, 2, 1, 0, 0 ], [ 3, 1, 3, 1, 2, 1, 0, 0 ], [ 2, 1, 1, 3, 3, 1, 0, 0 ], [ 2, 3, 1, 1, 3, 1, 0, 0 ], [ 2, 1, 3, 1, 1, 3, 0, 0 ], [ 2, 1, 3, 3, 1, 1, 0, 0 ], [ 2, 1, 3, 1, 3, 1, 0, 0 ], [ 3, 1, 1, 1, 2, 3, 0, 0 ], [ 3, 1, 1, 3, 2, 1, 0, 0 ], [ 3, 3, 1, 1, 2, 1, 0, 0 ], [ 3, 1, 2, 1, 1, 3, 0, 0 ], [ 3, 1, 2, 3, 1, 1, 0, 0 ], [ 3, 3, 2, 1, 1, 1, 0, 0 ], [ 3, 1, 4, 1, 1, 1, 0, 0 ], [ 2, 2, 1, 4, 1, 1, 0, 0 ], [ 4, 3, 1, 1, 1, 1, 0, 0 ], [ 1, 1, 1, 2, 2, 4, 0, 0 ], [ 1, 1, 1, 4, 2, 2, 0, 0 ], [ 1, 2, 1, 1, 2, 4, 0, 0 ], [ 1, 2, 1, 4, 2, 1, 0, 0 ], [ 1, 4, 1, 1, 2, 2, 0, 0 ], [ 1, 4, 1, 2, 2, 1, 0, 0 ], [ 1, 1, 2, 2, 1, 4, 0, 0 ], [ 1, 1, 2, 4, 1, 2, 0, 0 ], [ 1, 2, 2, 1, 1, 4, 0, 0 ], [ 1, 2, 2, 4, 1, 1, 0, 0 ], [ 1, 4, 2, 1, 1, 2, 0, 0 ], [ 1, 4, 2, 2, 1, 1, 0, 0 ], [ 2, 4, 1, 2, 1, 1, 0, 0 ], [ 2, 2, 1, 1, 1, 4, 0, 0 ], [ 4, 1, 3, 1, 1, 1, 0, 0 ], [ 2, 4, 1, 1, 1, 2, 0, 0 ], [ 1, 3, 4, 1, 1, 1, 0, 0 ], [ 1, 1, 1, 2, 4, 2, 0, 0 ], [ 1, 2, 1, 1, 4, 2, 0, 0 ], [ 1, 2, 1, 2, 4, 1, 0, 0 ], [ 1, 1, 4, 2, 1, 2, 0, 0 ], [ 1, 2, 4, 1, 1, 2, 0, 0 ], [ 1, 2, 4, 2, 1, 1, 0, 0 ], [ 4, 1, 1, 2, 1, 2, 0, 0 ], [ 4, 2, 1, 1, 1, 2, 0, 0 ], [ 4, 2, 1, 2, 1, 1, 0, 0 ], [ 2, 1, 2, 1, 4, 1, 0, 0 ], [ 2, 1, 4, 1, 2, 1, 0, 0 ], [ 4, 1, 2, 1, 2, 1, 0, 0 ], [ 1, 1, 1, 1, 4, 3, 0, 0 ], [ 1, 1, 1, 3, 4, 1, 0, 0 ], [ 1, 3, 1, 1, 4, 1, 0, 0 ], [ 1, 1, 4, 1, 1, 3, 0, 0 ], [ 1, 1, 4, 3, 1, 1, 0, 0 ], [ 4, 1, 1, 1, 1, 3, 0, 0 ], [ 4, 1, 1, 3, 1, 1, 0, 0 ], [ 1, 1, 3, 1, 4, 1, 0, 0 ], [ 1, 1, 4, 1, 3, 1, 0, 0 ], [ 3, 1, 1, 1, 4, 1, 0, 0 ], [ 4, 1, 1, 1, 3, 1, 0, 0 ], [ 2, 1, 1, 4, 1, 2, 0, 0 ], [ 2, 1, 1, 2, 1, 4, 0, 0 ], [ 2, 1, 1, 2, 3, 2, 0, 0 ], [ 2, 3, 3, 1, 1, 1, 2, 0 ] ];