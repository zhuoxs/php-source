function t(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
}

var e = function() {
    function t(t, e) {
        for (var n = 0; n < e.length; n++) {
            var i = e[n];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), 
            Object.defineProperty(t, i.key, i);
        }
    }
    return function(e, n, i) {
        return n && t(e.prototype, n), i && t(e, i), e;
    };
}(), n = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
}, i = function() {
    function n(e) {
        t(this, n);
        var i = {
            from: 50,
            speed: 2e3,
            refreshTime: 100,
            decimals: 2,
            onUpdate: function() {},
            onComplete: function() {}
        };
        this.tempValue = 0, this.opt = Object.assign(i, e), this.loopCount = 0, this.loops = Math.ceil(this.opt.speed / this.opt.refreshTime), 
        this.increment = this.opt.from / this.loops, this.interval = null, this.init();
    }
    return e(n, [ {
        key: "init",
        value: function() {
            var t = this;
            this.interval = setInterval(function() {
                t.updateTimer();
            }, this.opt.refreshTime);
        }
    }, {
        key: "updateTimer",
        value: function() {
            this.loopCount++, this.tempValue = this.formatFloat(this.tempValue, this.increment).toFixed(this.opt.decimals), 
            this.loopCount >= this.loops && (clearInterval(this.interval), this.tempValue = this.opt.from, 
            this.opt.onComplete()), this.opt.onUpdate();
        }
    }, {
        key: "formatFloat",
        value: function(t, e) {
            var n = void 0, i = void 0, o = void 0;
            try {
                i = t.toString().split(".")[1].length;
            } catch (t) {
                i = 0;
            }
            try {
                o = e.toString().split(".")[1].length;
            } catch (t) {
                o = 0;
            }
            return n = Math.pow(10, Math.max(i, o)), (t * n + e * n) / n;
        }
    } ]), n;
}();

module.exports = {
    formatTime: function(t) {
        var e = t.getFullYear(), i = t.getMonth() + 1, o = t.getDate(), r = t.getHours(), a = t.getMinutes(), s = t.getSeconds();
        return [ e, i, o ].map(n).join("/") + " " + [ r, a, s ].map(n).join(":");
    },
    randomNum: function(t, e) {
        return Math.floor(Math.random() * (t - e + 1) + e);
    },
    NumberAnimate: i,
    getDate: function() {
        var t = new Date();
        return [ t.getFullYear(), t.getMonth() + 1, t.getDate() ].map(n).join("-");
    }
};