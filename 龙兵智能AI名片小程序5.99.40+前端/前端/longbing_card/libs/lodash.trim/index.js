var _typeof2 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(r) {
    return typeof r;
} : function(r) {
    return r && "function" == typeof Symbol && r.constructor === Symbol && r !== Symbol.prototype ? "symbol" : typeof r;
}, _typeof = "function" == typeof Symbol && "symbol" === _typeof2(Symbol.iterator) ? function(r) {
    return void 0 === r ? "undefined" : _typeof2(r);
} : function(r) {
    return r && "function" == typeof Symbol && r.constructor === Symbol && r !== Symbol.prototype ? "symbol" : void 0 === r ? "undefined" : _typeof2(r);
}, INFINITY = 1 / 0, symbolTag = "[object Symbol]", reTrim = /^\s+|\s+$/g, rsAstralRange = "\\ud800-\\udfff", rsComboMarksRange = "\\u0300-\\u036f\\ufe20-\\ufe23", rsComboSymbolsRange = "\\u20d0-\\u20f0", rsVarRange = "\\ufe0e\\ufe0f", rsAstral = "[" + rsAstralRange + "]", rsCombo = "[" + rsComboMarksRange + rsComboSymbolsRange + "]", rsFitz = "\\ud83c[\\udffb-\\udfff]", rsModifier = "(?:" + rsCombo + "|" + rsFitz + ")", rsNonAstral = "[^" + rsAstralRange + "]", rsRegional = "(?:\\ud83c[\\udde6-\\uddff]){2}", rsSurrPair = "[\\ud800-\\udbff][\\udc00-\\udfff]", rsZWJ = "\\u200d", reOptMod = rsModifier + "?", rsOptVar = "[" + rsVarRange + "]?", rsOptJoin = "(?:" + rsZWJ + "(?:" + [ rsNonAstral, rsRegional, rsSurrPair ].join("|") + ")" + rsOptVar + reOptMod + ")*", rsSeq = rsOptVar + reOptMod + rsOptJoin, rsSymbol = "(?:" + [ rsNonAstral + rsCombo + "?", rsCombo, rsRegional, rsSurrPair, rsAstral ].join("|") + ")", reUnicode = RegExp(rsFitz + "(?=" + rsFitz + ")|" + rsSymbol + rsSeq, "g"), reHasUnicode = RegExp("[" + rsZWJ + rsAstralRange + rsComboMarksRange + rsComboSymbolsRange + rsVarRange + "]"), freeGlobal = "object" == ("undefined" == typeof global ? "undefined" : _typeof(global)) && global && global.Object === Object && global, freeSelf = "object" == ("undefined" == typeof self ? "undefined" : _typeof(self)) && self && self.Object === Object && self, root = freeGlobal || freeSelf || Function("return this")();

function asciiToArray(r) {
    return r.split("");
}

function baseFindIndex(r, o, e, t) {
    for (var n = r.length, s = e + (t ? 1 : -1); t ? s-- : ++s < n; ) if (o(r[s], s, r)) return s;
    return -1;
}

function baseIndexOf(r, o, e) {
    if (o != o) return baseFindIndex(r, baseIsNaN, e);
    for (var t = e - 1, n = r.length; ++t < n; ) if (r[t] === o) return t;
    return -1;
}

function baseIsNaN(r) {
    return r != r;
}

function charsStartIndex(r, o) {
    for (var e = -1, t = r.length; ++e < t && -1 < baseIndexOf(o, r[e], 0); ) ;
    return e;
}

function charsEndIndex(r, o) {
    for (var e = r.length; e-- && -1 < baseIndexOf(o, r[e], 0); ) ;
    return e;
}

function hasUnicode(r) {
    return reHasUnicode.test(r);
}

function stringToArray(r) {
    return hasUnicode(r) ? unicodeToArray(r) : asciiToArray(r);
}

function unicodeToArray(r) {
    return r.match(reUnicode) || [];
}

var objectProto = Object.prototype, objectToString = objectProto.toString, _Symbol = root.Symbol, symbolProto = _Symbol ? _Symbol.prototype : void 0, symbolToString = symbolProto ? symbolProto.toString : void 0;

function baseSlice(r, o, e) {
    var t = -1, n = r.length;
    o < 0 && (o = n < -o ? 0 : n + o), (e = n < e ? n : e) < 0 && (e += n), n = e < o ? 0 : e - o >>> 0, 
    o >>>= 0;
    for (var s = Array(n); ++t < n; ) s[t] = r[t + o];
    return s;
}

function baseToString(r) {
    if ("string" == typeof r) return r;
    if (isSymbol(r)) return symbolToString ? symbolToString.call(r) : "";
    var o = r + "";
    return "0" == o && 1 / r == -INFINITY ? "-0" : o;
}

function castSlice(r, o, e) {
    var t = r.length;
    return e = void 0 === e ? t : e, !o && t <= e ? r : baseSlice(r, o, e);
}

function isObjectLike(r) {
    return !!r && "object" == (void 0 === r ? "undefined" : _typeof(r));
}

function isSymbol(r) {
    return "symbol" == (void 0 === r ? "undefined" : _typeof(r)) || isObjectLike(r) && objectToString.call(r) == symbolTag;
}

function toString(r) {
    return null == r ? "" : baseToString(r);
}

function trim(r, o, e) {
    if ((r = toString(r)) && (e || void 0 === o)) return r.replace(reTrim, "");
    if (!r || !(o = baseToString(o))) return r;
    var t = stringToArray(r), n = stringToArray(o);
    return castSlice(t, charsStartIndex(t, n), charsEndIndex(t, n) + 1).join("");
}

module.exports = trim;