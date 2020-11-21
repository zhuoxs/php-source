var t = require("../common/component"), e = require("../common/utils");

(0, t.VantComponent)({
    relation: {
        name: "badge",
        type: "descendant",
        linked: function(t) {
            this.badges.push(t), this.setActive();
        },
        unlinked: function(t) {
            this.badges = this.badges.filter(function(e) {
                return e !== t;
            }), this.setActive();
        }
    },
    props: {
        active: {
            type: Number,
            value: 0
        }
    },
    watch: {
        active: "setActive"
    },
    beforeCreate: function() {
        this.badges = [], this.currentActive = -1;
    },
    methods: {
        setActive: function(t) {
            var i = this.data.active, s = this.badges;
            t && !(0, e.isNumber)(t) && (i = s.indexOf(t)), i !== this.currentActive && (-1 !== this.currentActive && s[this.currentActive] && (this.$emit("change", i), 
            s[this.currentActive].setActive(!1)), s[i] && (s[i].setActive(!0), this.currentActive = i));
        }
    }
});