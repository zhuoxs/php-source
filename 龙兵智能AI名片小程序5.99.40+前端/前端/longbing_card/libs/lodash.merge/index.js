var _typeof2 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _typeof = "function" == typeof Symbol && "symbol" === _typeof2(Symbol.iterator) ? function(e) {
    return void 0 === e ? "undefined" : _typeof2(e);
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : void 0 === e ? "undefined" : _typeof2(e);
}, LARGE_ARRAY_SIZE = 200, HASH_UNDEFINED = "__lodash_hash_undefined__", HOT_COUNT = 800, HOT_SPAN = 16, MAX_SAFE_INTEGER = 9007199254740991, argsTag = "[object Arguments]", arrayTag = "[object Array]", asyncTag = "[object AsyncFunction]", boolTag = "[object Boolean]", dateTag = "[object Date]", errorTag = "[object Error]", funcTag = "[object Function]", genTag = "[object GeneratorFunction]", mapTag = "[object Map]", numberTag = "[object Number]", nullTag = "[object Null]", objectTag = "[object Object]", proxyTag = "[object Proxy]", regexpTag = "[object RegExp]", setTag = "[object Set]", stringTag = "[object String]", undefinedTag = "[object Undefined]", weakMapTag = "[object WeakMap]", arrayBufferTag = "[object ArrayBuffer]", dataViewTag = "[object DataView]", float32Tag = "[object Float32Array]", float64Tag = "[object Float64Array]", int8Tag = "[object Int8Array]", int16Tag = "[object Int16Array]", int32Tag = "[object Int32Array]", uint8Tag = "[object Uint8Array]", uint8ClampedTag = "[object Uint8ClampedArray]", uint16Tag = "[object Uint16Array]", uint32Tag = "[object Uint32Array]", reRegExpChar = /[\\^$.*+?()[\]{}|]/g, reIsHostCtor = /^\[object .+?Constructor\]$/, reIsUint = /^(?:0|[1-9]\d*)$/, typedArrayTags = {};

typedArrayTags[float32Tag] = typedArrayTags[float64Tag] = typedArrayTags[int8Tag] = typedArrayTags[int16Tag] = typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] = typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] = typedArrayTags[uint32Tag] = !0, 
typedArrayTags[argsTag] = typedArrayTags[arrayTag] = typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] = typedArrayTags[dataViewTag] = typedArrayTags[dateTag] = typedArrayTags[errorTag] = typedArrayTags[funcTag] = typedArrayTags[mapTag] = typedArrayTags[numberTag] = typedArrayTags[objectTag] = typedArrayTags[regexpTag] = typedArrayTags[setTag] = typedArrayTags[stringTag] = typedArrayTags[weakMapTag] = !1;

var freeGlobal = "object" == ("undefined" == typeof global ? "undefined" : _typeof(global)) && global && global.Object === Object && global, freeSelf = "object" == ("undefined" == typeof self ? "undefined" : _typeof(self)) && self && self.Object === Object && self, root = freeGlobal || freeSelf || Function("return this")(), freeExports = "object" == ("undefined" == typeof exports ? "undefined" : _typeof(exports)) && exports && !exports.nodeType && exports, freeModule = freeExports && "object" == ("undefined" == typeof module ? "undefined" : _typeof(module)) && module && !module.nodeType && module, moduleExports = freeModule && freeModule.exports === freeExports, freeProcess = moduleExports && freeGlobal.process, nodeUtil = function() {
    try {
        return freeProcess && freeProcess.binding && freeProcess.binding("util");
    } catch (e) {}
}(), nodeIsTypedArray = nodeUtil && nodeUtil.isTypedArray;

function apply(e, t, r) {
    switch (r.length) {
      case 0:
        return e.call(t);

      case 1:
        return e.call(t, r[0]);

      case 2:
        return e.call(t, r[0], r[1]);

      case 3:
        return e.call(t, r[0], r[1], r[2]);
    }
    return e.apply(t, r);
}

function baseTimes(e, t) {
    for (var r = -1, a = Array(e); ++r < e; ) a[r] = t(r);
    return a;
}

function baseUnary(t) {
    return function(e) {
        return t(e);
    };
}

function getValue(e, t) {
    return null == e ? void 0 : e[t];
}

function overArg(t, r) {
    return function(e) {
        return t(r(e));
    };
}

function safeGet(e, t) {
    return "__proto__" == t ? void 0 : e[t];
}

var arrayProto = Array.prototype, funcProto = Function.prototype, objectProto = Object.prototype, coreJsData = root["__core-js_shared__"], funcToString = funcProto.toString, hasOwnProperty = objectProto.hasOwnProperty, maskSrcKey = function() {
    var e = /[^.]+$/.exec(coreJsData && coreJsData.keys && coreJsData.keys.IE_PROTO || "");
    return e ? "Symbol(src)_1." + e : "";
}(), nativeObjectToString = objectProto.toString, objectCtorString = funcToString.call(Object), reIsNative = RegExp("^" + funcToString.call(hasOwnProperty).replace(reRegExpChar, "\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, "$1.*?") + "$"), Buffer = moduleExports ? root.Buffer : void 0, _Symbol = root.Symbol, Uint8Array = root.Uint8Array, allocUnsafe = Buffer ? Buffer.allocUnsafe : void 0, getPrototype = overArg(Object.getPrototypeOf, Object), objectCreate = Object.create, propertyIsEnumerable = objectProto.propertyIsEnumerable, splice = arrayProto.splice, symToStringTag = _Symbol ? _Symbol.toStringTag : void 0, defineProperty = function() {
    try {
        var e = getNative(Object, "defineProperty");
        return e({}, "", {}), e;
    } catch (e) {}
}(), nativeIsBuffer = Buffer ? Buffer.isBuffer : void 0, nativeMax = Math.max, nativeNow = Date.now, Map = getNative(root, "Map"), nativeCreate = getNative(Object, "create"), baseCreate = function() {
    function r() {}
    return function(e) {
        if (!isObject(e)) return {};
        if (objectCreate) return objectCreate(e);
        r.prototype = e;
        var t = new r();
        return r.prototype = void 0, t;
    };
}();

function Hash(e) {
    var t = -1, r = null == e ? 0 : e.length;
    for (this.clear(); ++t < r; ) {
        var a = e[t];
        this.set(a[0], a[1]);
    }
}

function hashClear() {
    this.__data__ = nativeCreate ? nativeCreate(null) : {}, this.size = 0;
}

function hashDelete(e) {
    var t = this.has(e) && delete this.__data__[e];
    return this.size -= t ? 1 : 0, t;
}

function hashGet(e) {
    var t = this.__data__;
    if (nativeCreate) {
        var r = t[e];
        return r === HASH_UNDEFINED ? void 0 : r;
    }
    return hasOwnProperty.call(t, e) ? t[e] : void 0;
}

function hashHas(e) {
    var t = this.__data__;
    return nativeCreate ? void 0 !== t[e] : hasOwnProperty.call(t, e);
}

function hashSet(e, t) {
    var r = this.__data__;
    return this.size += this.has(e) ? 0 : 1, r[e] = nativeCreate && void 0 === t ? HASH_UNDEFINED : t, 
    this;
}

function ListCache(e) {
    var t = -1, r = null == e ? 0 : e.length;
    for (this.clear(); ++t < r; ) {
        var a = e[t];
        this.set(a[0], a[1]);
    }
}

function listCacheClear() {
    this.__data__ = [], this.size = 0;
}

function listCacheDelete(e) {
    var t = this.__data__, r = assocIndexOf(t, e);
    return !(r < 0) && (r == t.length - 1 ? t.pop() : splice.call(t, r, 1), --this.size, 
    !0);
}

function listCacheGet(e) {
    var t = this.__data__, r = assocIndexOf(t, e);
    return r < 0 ? void 0 : t[r][1];
}

function listCacheHas(e) {
    return -1 < assocIndexOf(this.__data__, e);
}

function listCacheSet(e, t) {
    var r = this.__data__, a = assocIndexOf(r, e);
    return a < 0 ? (++this.size, r.push([ e, t ])) : r[a][1] = t, this;
}

function MapCache(e) {
    var t = -1, r = null == e ? 0 : e.length;
    for (this.clear(); ++t < r; ) {
        var a = e[t];
        this.set(a[0], a[1]);
    }
}

function mapCacheClear() {
    this.size = 0, this.__data__ = {
        hash: new Hash(),
        map: new (Map || ListCache)(),
        string: new Hash()
    };
}

function mapCacheDelete(e) {
    var t = getMapData(this, e).delete(e);
    return this.size -= t ? 1 : 0, t;
}

function mapCacheGet(e) {
    return getMapData(this, e).get(e);
}

function mapCacheHas(e) {
    return getMapData(this, e).has(e);
}

function mapCacheSet(e, t) {
    var r = getMapData(this, e), a = r.size;
    return r.set(e, t), this.size += r.size == a ? 0 : 1, this;
}

function Stack(e) {
    var t = this.__data__ = new ListCache(e);
    this.size = t.size;
}

function stackClear() {
    this.__data__ = new ListCache(), this.size = 0;
}

function stackDelete(e) {
    var t = this.__data__, r = t.delete(e);
    return this.size = t.size, r;
}

function stackGet(e) {
    return this.__data__.get(e);
}

function stackHas(e) {
    return this.__data__.has(e);
}

function stackSet(e, t) {
    var r = this.__data__;
    if (r instanceof ListCache) {
        var a = r.__data__;
        if (!Map || a.length < LARGE_ARRAY_SIZE - 1) return a.push([ e, t ]), this.size = ++r.size, 
        this;
        r = this.__data__ = new MapCache(a);
    }
    return r.set(e, t), this.size = r.size, this;
}

function arrayLikeKeys(e, t) {
    var r = isArray(e), a = !r && isArguments(e), n = !r && !a && isBuffer(e), o = !r && !a && !n && isTypedArray(e), i = r || a || n || o, s = i ? baseTimes(e.length, String) : [], c = s.length;
    for (var u in e) !t && !hasOwnProperty.call(e, u) || i && ("length" == u || n && ("offset" == u || "parent" == u) || o && ("buffer" == u || "byteLength" == u || "byteOffset" == u) || isIndex(u, c)) || s.push(u);
    return s;
}

function assignMergeValue(e, t, r) {
    (void 0 === r || eq(e[t], r)) && (void 0 !== r || t in e) || baseAssignValue(e, t, r);
}

function assignValue(e, t, r) {
    var a = e[t];
    hasOwnProperty.call(e, t) && eq(a, r) && (void 0 !== r || t in e) || baseAssignValue(e, t, r);
}

function assocIndexOf(e, t) {
    for (var r = e.length; r--; ) if (eq(e[r][0], t)) return r;
    return -1;
}

function baseAssignValue(e, t, r) {
    "__proto__" == t && defineProperty ? defineProperty(e, t, {
        configurable: !0,
        enumerable: !0,
        value: r,
        writable: !0
    }) : e[t] = r;
}

Hash.prototype.clear = hashClear, Hash.prototype.delete = hashDelete, Hash.prototype.get = hashGet, 
Hash.prototype.has = hashHas, Hash.prototype.set = hashSet, ListCache.prototype.clear = listCacheClear, 
ListCache.prototype.delete = listCacheDelete, ListCache.prototype.get = listCacheGet, 
ListCache.prototype.has = listCacheHas, ListCache.prototype.set = listCacheSet, 
MapCache.prototype.clear = mapCacheClear, MapCache.prototype.delete = mapCacheDelete, 
MapCache.prototype.get = mapCacheGet, MapCache.prototype.has = mapCacheHas, MapCache.prototype.set = mapCacheSet, 
Stack.prototype.clear = stackClear, Stack.prototype.delete = stackDelete, Stack.prototype.get = stackGet, 
Stack.prototype.has = stackHas, Stack.prototype.set = stackSet;

var baseFor = createBaseFor();

function baseGetTag(e) {
    return null == e ? void 0 === e ? undefinedTag : nullTag : symToStringTag && symToStringTag in Object(e) ? getRawTag(e) : objectToString(e);
}

function baseIsArguments(e) {
    return isObjectLike(e) && baseGetTag(e) == argsTag;
}

function baseIsNative(e) {
    return !(!isObject(e) || isMasked(e)) && (isFunction(e) ? reIsNative : reIsHostCtor).test(toSource(e));
}

function baseIsTypedArray(e) {
    return isObjectLike(e) && isLength(e.length) && !!typedArrayTags[baseGetTag(e)];
}

function baseKeysIn(e) {
    if (!isObject(e)) return nativeKeysIn(e);
    var t = isPrototype(e), r = [];
    for (var a in e) ("constructor" != a || !t && hasOwnProperty.call(e, a)) && r.push(a);
    return r;
}

function baseMerge(a, n, o, i, s) {
    a !== n && baseFor(n, function(e, t) {
        if (isObject(e)) s || (s = new Stack()), baseMergeDeep(a, n, t, o, baseMerge, i, s); else {
            var r = i ? i(safeGet(a, t), e, t + "", a, n, s) : void 0;
            void 0 === r && (r = e), assignMergeValue(a, t, r);
        }
    }, keysIn);
}

function baseMergeDeep(e, t, r, a, n, o, i) {
    var s = safeGet(e, r), c = safeGet(t, r), u = i.get(c);
    if (u) assignMergeValue(e, r, u); else {
        var f = o ? o(s, c, r + "", e, t, i) : void 0, y = void 0 === f;
        if (y) {
            var l = isArray(c), p = !l && isBuffer(c), g = !l && !p && isTypedArray(c);
            f = c, l || p || g ? f = isArray(s) ? s : isArrayLikeObject(s) ? copyArray(s) : p ? cloneBuffer(c, !(y = !1)) : g ? cloneTypedArray(c, !(y = !1)) : [] : isPlainObject(c) || isArguments(c) ? isArguments(f = s) ? f = toPlainObject(s) : (!isObject(s) || a && isFunction(s)) && (f = initCloneObject(c)) : y = !1;
        }
        y && (i.set(c, f), n(f, c, a, o, i), i.delete(c)), assignMergeValue(e, r, f);
    }
}

function baseRest(e, t) {
    return setToString(overRest(e, t, identity), e + "");
}

var baseSetToString = defineProperty ? function(e, t) {
    return defineProperty(e, "toString", {
        configurable: !0,
        enumerable: !1,
        value: constant(t),
        writable: !0
    });
} : identity;

function cloneBuffer(e, t) {
    if (t) return e.slice();
    var r = e.length, a = allocUnsafe ? allocUnsafe(r) : new e.constructor(r);
    return e.copy(a), a;
}

function cloneArrayBuffer(e) {
    var t = new e.constructor(e.byteLength);
    return new Uint8Array(t).set(new Uint8Array(e)), t;
}

function cloneTypedArray(e, t) {
    var r = t ? cloneArrayBuffer(e.buffer) : e.buffer;
    return new e.constructor(r, e.byteOffset, e.length);
}

function copyArray(e, t) {
    var r = -1, a = e.length;
    for (t || (t = Array(a)); ++r < a; ) t[r] = e[r];
    return t;
}

function copyObject(e, t, r, a) {
    var n = !r;
    r || (r = {});
    for (var o = -1, i = t.length; ++o < i; ) {
        var s = t[o], c = a ? a(r[s], e[s], s, r, e) : void 0;
        void 0 === c && (c = e[s]), n ? baseAssignValue(r, s, c) : assignValue(r, s, c);
    }
    return r;
}

function createAssigner(s) {
    return baseRest(function(e, t) {
        var r = -1, a = t.length, n = 1 < a ? t[a - 1] : void 0, o = 2 < a ? t[2] : void 0;
        for (n = 3 < s.length && "function" == typeof n ? (a--, n) : void 0, o && isIterateeCall(t[0], t[1], o) && (n = a < 3 ? void 0 : n, 
        a = 1), e = Object(e); ++r < a; ) {
            var i = t[r];
            i && s(e, i, r, n);
        }
        return e;
    });
}

function createBaseFor(c) {
    return function(e, t, r) {
        for (var a = -1, n = Object(e), o = r(e), i = o.length; i--; ) {
            var s = o[c ? i : ++a];
            if (!1 === t(n[s], s, n)) break;
        }
        return e;
    };
}

function getMapData(e, t) {
    var r = e.__data__;
    return isKeyable(t) ? r["string" == typeof t ? "string" : "hash"] : r.map;
}

function getNative(e, t) {
    var r = getValue(e, t);
    return baseIsNative(r) ? r : void 0;
}

function getRawTag(e) {
    var t = hasOwnProperty.call(e, symToStringTag), r = e[symToStringTag];
    try {
        var a = !(e[symToStringTag] = void 0);
    } catch (e) {}
    var n = nativeObjectToString.call(e);
    return a && (t ? e[symToStringTag] = r : delete e[symToStringTag]), n;
}

function initCloneObject(e) {
    return "function" != typeof e.constructor || isPrototype(e) ? {} : baseCreate(getPrototype(e));
}

function isIndex(e, t) {
    var r = void 0 === e ? "undefined" : _typeof(e);
    return !!(t = null == t ? MAX_SAFE_INTEGER : t) && ("number" == r || "symbol" != r && reIsUint.test(e)) && -1 < e && e % 1 == 0 && e < t;
}

function isIterateeCall(e, t, r) {
    if (!isObject(r)) return !1;
    var a = void 0 === t ? "undefined" : _typeof(t);
    return !!("number" == a ? isArrayLike(r) && isIndex(t, r.length) : "string" == a && t in r) && eq(r[t], e);
}

function isKeyable(e) {
    var t = void 0 === e ? "undefined" : _typeof(e);
    return "string" == t || "number" == t || "symbol" == t || "boolean" == t ? "__proto__" !== e : null === e;
}

function isMasked(e) {
    return !!maskSrcKey && maskSrcKey in e;
}

function isPrototype(e) {
    var t = e && e.constructor;
    return e === ("function" == typeof t && t.prototype || objectProto);
}

function nativeKeysIn(e) {
    var t = [];
    if (null != e) for (var r in Object(e)) t.push(r);
    return t;
}

function objectToString(e) {
    return nativeObjectToString.call(e);
}

function overRest(o, i, s) {
    return i = nativeMax(void 0 === i ? o.length - 1 : i, 0), function() {
        for (var e = arguments, t = -1, r = nativeMax(e.length - i, 0), a = Array(r); ++t < r; ) a[t] = e[i + t];
        t = -1;
        for (var n = Array(i + 1); ++t < i; ) n[t] = e[t];
        return n[i] = s(a), apply(o, this, n);
    };
}

var setToString = shortOut(baseSetToString);

function shortOut(r) {
    var a = 0, n = 0;
    return function() {
        var e = nativeNow(), t = HOT_SPAN - (e - n);
        if (n = e, 0 < t) {
            if (++a >= HOT_COUNT) return arguments[0];
        } else a = 0;
        return r.apply(void 0, arguments);
    };
}

function toSource(e) {
    if (null != e) {
        try {
            return funcToString.call(e);
        } catch (e) {}
        try {
            return e + "";
        } catch (e) {}
    }
    return "";
}

function eq(e, t) {
    return e === t || e != e && t != t;
}

var isArguments = baseIsArguments(function() {
    return arguments;
}()) ? baseIsArguments : function(e) {
    return isObjectLike(e) && hasOwnProperty.call(e, "callee") && !propertyIsEnumerable.call(e, "callee");
}, isArray = Array.isArray;

function isArrayLike(e) {
    return null != e && isLength(e.length) && !isFunction(e);
}

function isArrayLikeObject(e) {
    return isObjectLike(e) && isArrayLike(e);
}

var isBuffer = nativeIsBuffer || stubFalse;

function isFunction(e) {
    if (!isObject(e)) return !1;
    var t = baseGetTag(e);
    return t == funcTag || t == genTag || t == asyncTag || t == proxyTag;
}

function isLength(e) {
    return "number" == typeof e && -1 < e && e % 1 == 0 && e <= MAX_SAFE_INTEGER;
}

function isObject(e) {
    var t = void 0 === e ? "undefined" : _typeof(e);
    return null != e && ("object" == t || "function" == t);
}

function isObjectLike(e) {
    return null != e && "object" == (void 0 === e ? "undefined" : _typeof(e));
}

function isPlainObject(e) {
    if (!isObjectLike(e) || baseGetTag(e) != objectTag) return !1;
    var t = getPrototype(e);
    if (null === t) return !0;
    var r = hasOwnProperty.call(t, "constructor") && t.constructor;
    return "function" == typeof r && r instanceof r && funcToString.call(r) == objectCtorString;
}

var isTypedArray = nodeIsTypedArray ? baseUnary(nodeIsTypedArray) : baseIsTypedArray;

function toPlainObject(e) {
    return copyObject(e, keysIn(e));
}

function keysIn(e) {
    return isArrayLike(e) ? arrayLikeKeys(e, !0) : baseKeysIn(e);
}

var merge = createAssigner(function(e, t, r) {
    baseMerge(e, t, r);
});

function constant(e) {
    return function() {
        return e;
    };
}

function identity(e) {
    return e;
}

function stubFalse() {
    return !1;
}

module.exports = merge;