function t() {
    this.left = e.randomNum(250, 40), this.top = e.randomNum(200, 40), this.tempX = this.left, 
    this.tempY = this.top, this.width = 40, this.height = 40, this.speedx = Number(((e.randomNum(16, 14) - 15.5) / e.randomNum(5, 2)).toFixed(2)), 
    this.speedy = Number(((e.randomNum(15, 14) - 15.5) / e.randomNum(5, 2)).toFixed(2));
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var e = require("./util.js");

t.prototype.move = function() {
    this.tempX = this.tempX + this.speedx, this.tempY = this.tempY + this.speedy;
    var t = !1;
    return (this.tempX + this.width >= 300 || this.tempX <= 0) && (this.speedx = -this.speedx), 
    (this.tempY + this.width >= 250 || this.tempY <= 0) && (this.speedy = -this.speedy), 
    this.speedx > 0 && (t = !0), {
        left: this.tempX,
        top: this.tempY,
        rotateY: t
    };
}, exports.default = t;