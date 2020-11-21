var t, i, a = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../utils/animal.js"));

Component({
    properties: {
        animalList: {
            type: Array,
            value: [],
            observer: function(a, n, e) {
                0 == a.length && (clearTimeout(t), clearTimeout(i));
            }
        }
    },
    data: {
        isRun: !1,
        action: {},
        animalList: []
    },
    attached: function() {
        this.data.animalList.length > 0 && this.initialize();
    },
    lifetimes: {
        detached: function() {
            clearTimeout(t), clearTimeout(i);
        }
    },
    methods: {
        initialize: function() {
            var t = [];
            this.data.animalList.map(function(i) {
                var n = new a.default(), e = {
                    id: i.id,
                    animal: n
                };
                t.push(e);
            }), this.run(), this.animations(t);
        },
        animations: function(i) {
            var a = this;
            t = setTimeout(function() {
                a.action(i), a.animations(i);
            }, 17);
        },
        action: function(t) {
            var i = this.data.animalList;
            t.map(function(t, a) {
                i.map(function(i) {
                    if (i.id == t.id) {
                        var a = t.animal.move();
                        i.left = a.left, i.top = a.top, i.rotateY = a.rotateY, i.zindex = Number(a.top.toFixed(0)) + 100;
                    }
                });
            }), this.setData({
                animalList: i
            });
        },
        run: function() {
            var t = this, a = !1;
            i = setTimeout(function() {
                a = !t.data.isRun, t.setData({
                    isRun: a
                }), t.run();
            }, 400);
        },
        details: function(t) {
            var i = t.currentTarget.dataset.id;
            console.log(i), this.triggerEvent("animalDetail", i);
        }
    }
});