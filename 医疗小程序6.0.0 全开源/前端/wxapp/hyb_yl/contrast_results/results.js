Component({
    properties: {
        yearContrastArr: {
            type: Array
        },
        current: {
            type: Number,
            observer: "tips"
        }
    },
    data: {},
    methods: {
        tips: function() {
            for (var t = this, r = t.data.yearContrastArr, e = 0, a = r.length; e < a; e++) t.healthy(r[e]) && (r[e].healthy = !0), 
            t.unhealthy(r[e]) && (r[e].unhealthy = !0);
            t.setData({
                yearContrastArr: r
            });
        },
        healthy: function(t) {
            for (var r = 0, e = t.labels.length; r < e; r++) if (0 == t.labels[r].abnormal) return !1;
            return !0;
        },
        unhealthy: function(t) {
            for (var r = 0, e = t.labels.length; r < e; r++) if (1 == t.labels[r].abnormal) return !1;
            return !0;
        }
    },
    ready: function() {
        this.tips();
    }
});