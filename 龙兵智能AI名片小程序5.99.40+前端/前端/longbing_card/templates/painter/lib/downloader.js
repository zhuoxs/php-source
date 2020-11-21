Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _createClass = function() {
    function n(e, t) {
        for (var i = 0; i < t.length; i++) {
            var n = t[i];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(e, t, i) {
        return t && n(e.prototype, t), i && n(e, i), e;
    };
}();

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var util = require("./util"), SAVED_FILES_KEY = "savedFiles", KEY_TOTAL_SIZE = "totalSize", KEY_PATH = "path", KEY_TIME = "time", KEY_SIZE = "size", MAX_SPACE_IN_B = 6291456, savedFiles = {}, Dowloader = function() {
    function e() {
        _classCallCheck(this, e), getApp().PAINTER_MAX_LRU_SPACE && (MAX_SPACE_IN_B = getApp().PAINTER_MAX_LRU_SPACE), 
        wx.getStorage({
            key: SAVED_FILES_KEY,
            success: function(e) {
                e.data && (savedFiles = e.data);
            }
        });
    }
    return _createClass(e, [ {
        key: "download",
        value: function(o) {
            return new Promise(function(t, i) {
                if (o && util.isValidUrl(o)) {
                    var n = getFile(o);
                    n ? wx.getSavedFileInfo({
                        filePath: n[KEY_PATH],
                        success: function(e) {
                            t(n[KEY_PATH]);
                        },
                        fail: function(e) {
                            console.error("the file is broken, redownload it, " + JSON.stringify(e)), downloadFile(o).then(function(e) {
                                t(e);
                            }, function() {
                                i();
                            });
                        }
                    }) : downloadFile(o).then(function(e) {
                        t(e);
                    }, function() {
                        i();
                    });
                } else t(o);
            });
        }
    } ]), e;
}();

function downloadFile(r) {
    return new Promise(function(n, o) {
        wx.downloadFile({
            url: r,
            success: function(t) {
                if (200 !== t.statusCode) return console.error("downloadFile " + r + " failed res.statusCode is not 200"), 
                void o();
                var i = t.tempFilePath;
                wx.getFileInfo({
                    filePath: i,
                    success: function(e) {
                        var t = e.size;
                        doLru(t).then(function() {
                            saveFile(r, t, i).then(function(e) {
                                n(e);
                            });
                        }, function() {
                            n(i);
                        });
                    },
                    fail: function(e) {
                        console.error("getFileInfo " + t.tempFilePath + " failed, " + JSON.stringify(e)), 
                        n(t.tempFilePath);
                    }
                });
            },
            fail: function(e) {
                console.error("downloadFile failed, " + JSON.stringify(e) + " "), o();
            }
        });
    });
}

function saveFile(n, o, t) {
    return new Promise(function(i, e) {
        wx.saveFile({
            tempFilePath: t,
            success: function(e) {
                var t = savedFiles[KEY_TOTAL_SIZE] ? savedFiles[KEY_TOTAL_SIZE] : 0;
                savedFiles[n] = {}, savedFiles[n][KEY_PATH] = e.savedFilePath, savedFiles[n][KEY_TIME] = new Date().getTime(), 
                savedFiles[n][KEY_SIZE] = o, savedFiles.totalSize = o + t, wx.setStorage({
                    key: SAVED_FILES_KEY,
                    data: savedFiles
                }), i(e.savedFilePath);
            },
            fail: function(e) {
                console.error("saveFile " + n + " failed, then we delete all files, " + JSON.stringify(e)), 
                i(t), reset();
            }
        });
    });
}

function reset() {
    wx.removeStorage({
        key: SAVED_FILES_KEY,
        success: function() {
            wx.getSavedFileList({
                success: function(e) {
                    removeFiles(e.fileList);
                },
                fail: function(e) {
                    console.error("getSavedFileList failed, " + JSON.stringify(e));
                }
            });
        }
    });
}

function doLru(d) {
    return new Promise(function(e, t) {
        var i = savedFiles[KEY_TOTAL_SIZE] ? savedFiles[KEY_TOTAL_SIZE] : 0;
        if (d + i <= MAX_SPACE_IN_B) e(); else {
            var n = [], o = JSON.parse(JSON.stringify(savedFiles));
            delete o[KEY_TOTAL_SIZE];
            var r = Object.keys(o).sort(function(e, t) {
                return o[e][KEY_TIME] - o[t][KEY_TIME];
            }), l = !0, s = !1, a = void 0;
            try {
                for (var f, u = r[Symbol.iterator](); !(l = (f = u.next()).done); l = !0) {
                    var c = f.value;
                    if (i -= savedFiles[c].size, n.push(savedFiles[c][KEY_PATH]), delete savedFiles[c], 
                    i + d < MAX_SPACE_IN_B) break;
                }
            } catch (e) {
                s = !0, a = e;
            } finally {
                try {
                    !l && u.return && u.return();
                } finally {
                    if (s) throw a;
                }
            }
            savedFiles.totalSize = i, wx.setStorage({
                key: SAVED_FILES_KEY,
                data: savedFiles,
                success: function() {
                    0 < n.length && removeFiles(n), e();
                },
                fail: function(e) {
                    console.error("doLru setStorage failed, " + JSON.stringify(e)), t();
                }
            });
        }
    });
}

function removeFiles(e) {
    var t = !0, i = !1, n = void 0;
    try {
        for (var o, r = function() {
            var t = o.value, e = t;
            "object" === (void 0 === t ? "undefined" : _typeof(t)) && (e = t.filePath), wx.removeSavedFile({
                filePath: e,
                fail: function(e) {
                    console.error("removeSavedFile " + t + " failed, " + JSON.stringify(e));
                }
            });
        }, l = e[Symbol.iterator](); !(t = (o = l.next()).done); t = !0) r();
    } catch (e) {
        i = !0, n = e;
    } finally {
        try {
            !t && l.return && l.return();
        } finally {
            if (i) throw n;
        }
    }
}

function getFile(e) {
    if (savedFiles[e]) return savedFiles[e].time = new Date().getTime(), wx.setStorage({
        key: SAVED_FILES_KEY,
        data: savedFiles
    }), savedFiles[e];
}

exports.default = Dowloader;