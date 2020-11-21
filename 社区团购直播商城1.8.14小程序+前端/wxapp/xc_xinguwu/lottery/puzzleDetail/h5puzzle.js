var _createClass = function() {
    function i(t, r) {
        for (var e = 0; e < r.length; e++) {
            var i = r[e];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), 
            Object.defineProperty(t, i.key, i);
        }
    }
    return function(t, r, e) {
        return r && i(t.prototype, r), e && i(t, e), t;
    };
}();

function _classCallCheck(t, r) {
    if (!(t instanceof r)) throw new TypeError("Cannot call a class as a function");
}

var Puzzle = function() {
    function e(t, r) {
        _classCallCheck(this, e), r = r || {}, this.page = t, this.type = r.type || 4, this.width = 0, 
        this.height = 0, this.page.gameEnd = r.gameEnd || !1, this.init();
    }
    return _createClass(e, [ {
        key: "init",
        value: function() {
            var r = this;
            wx.getSystemInfo({
                success: function(t) {
                    r.page.setData({
                        WIDTH: 320,
                        HEIGHT: 320,
                        width: 320 / r.type,
                        height: 320 / r.type
                    }), r.width = 320 / r.type, r.height = 320 / r.type;
                }
            }), this.originX = 0, this.originY = 0, this.originPX = 0, this.originPY = 0, this.currentX = 0, 
            this.currentY = 0, this.cval = null, this.val = null, this.typeArr = [], this.newTypeArr = [], 
            this.pointsArr = [], this.initTypeArr(), this.randomArr(), this.page.setData({
                imgPoints: this.newTypeArr
            }), this.bindEvent();
        }
    }, {
        key: "initTypeArr",
        value: function() {
            for (var t = [], r = 0, e = 0; e < this.type; e++) {
                t[e] = [];
                for (var i = 0; i < this.type; i++) t[e].push({
                    x: i,
                    y: e,
                    px: i,
                    py: e,
                    count: r
                }), this.pointsArr.push(r), r++;
            }
            this.typeArr = t;
        }
    }, {
        key: "randomArr",
        value: function() {
            for (var t = this.pointsArr.length - 1, r = 0; r < t; r++) {
                var e = parseInt(Math.random() * t), i = this.pointsArr[r];
                this.pointsArr[r] = this.pointsArr[e], this.pointsArr[e] = i;
            }
            for (var n = 0, s = this.typeArr.length; n < s; n++) {
                var a = this.typeArr[n];
                this.newTypeArr[n] = [];
                for (var h = 0, o = a.length; h < o; h++) {
                    var p = a[h];
                    this.newTypeArr[n].push({
                        x: p.x,
                        y: p.y,
                        px: this.pointsArr[p.count] % this.type,
                        py: parseInt(this.pointsArr[p.count] / this.type),
                        count: p.count
                    });
                }
            }
            JSON.stringify(this.typeArr) === JSON.stringify(this.newTypeArr) && this.randomArr();
        }
    }, {
        key: "checkWin",
        value: function() {
            return JSON.stringify(this.typeArr) === JSON.stringify(this.newTypeArr);
        }
    }, {
        key: "bindEvent",
        value: function() {
            var h = this, r = this.page;
            r.gameEnd || (r.onTouchStart = function(t) {
                var r = parseInt(t.touches[0].pageX / h.width - .0685 * h.type), e = parseInt(t.touches[0].pageY / h.height - .5 * h.type), i = h.newTypeArr[e][r];
                h.cval = h.newTypeArr[e][r], h.page.setData({
                    status: !0,
                    currentX: i.x * h.width,
                    currentY: i.y * h.height,
                    currentPX: i.px,
                    currentPY: i.py
                }), h.originX = i.x * h.width, h.originY = i.y * h.height, h.originPX = i.px, h.originPY = i.py, 
                h.currentX = t.touches[0].pageX, h.currentY = t.touches[0].pageY;
            }, r.onTouchMove = function(t) {
                var r = parseInt(t.touches[0].pageX / h.width - .0685 * h.type), e = parseInt(t.touches[0].pageY / h.height - .5 * h.type);
                console.log(e);
                var i = t.touches[0].pageX, n = t.touches[0].pageY, s = i - h.currentX, a = n - h.currentY;
                h.val = h.newTypeArr[e][r], h.page.setData({
                    status: !0,
                    currentX: h.originX + s,
                    currentY: h.originY + a,
                    currentPX: h.originPX,
                    currentPY: h.originPY
                });
            }, r.onTouchEnd = function(t) {
                h.cval.px = h.val.px, h.cval.py = h.val.py, h.val.px = h.originPX, h.val.py = h.originPY, 
                h.page.setData({
                    imgPoints: h.newTypeArr,
                    status: !1,
                    currentX: 0,
                    currentY: 0,
                    currentPX: 0,
                    currentPY: 0
                }), h.originX = 0, h.originY = 0, h.originPX = 0, h.originPY = 0, h.currentX = 0, 
                h.currentY = 0, h.checkWin() && r.finishFunc();
            });
        }
    } ]), e;
}();

module.exports = Puzzle;