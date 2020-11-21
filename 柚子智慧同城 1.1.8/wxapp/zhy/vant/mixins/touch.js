Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.touch = Behavior({
    methods: {
        touchStart: function(t) {
            this.direction = "", this.deltaX = 0, this.deltaY = 0, this.offsetX = 0, this.offsetY = 0, 
            this.startX = t.touches[0].clientX, this.startY = t.touches[0].clientY;
        },
        touchMove: function(t) {
            var s = t.touches[0];
            this.deltaX = s.clientX - this.startX, this.deltaY = s.clientY - this.startY, this.offsetX = Math.abs(this.deltaX), 
            this.offsetY = Math.abs(this.deltaY), this.direction = this.offsetX > this.offsetY ? "horizontal" : this.offsetX < this.offsetY ? "vertical" : "";
        }
    }
});