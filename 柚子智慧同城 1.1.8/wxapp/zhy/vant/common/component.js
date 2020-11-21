function e(e, s, a) {
    return s in e ? Object.defineProperty(e, s, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[s] = a, e;
}

function s(e, s, a) {
    Object.keys(a).forEach(function(r) {
        e[r] && (s[a[r]] = e[r]);
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.VantComponent = void 0;

var a = require("../mixins/basic"), r = require("../mixins/observer/index");

exports.VantComponent = function(t) {
    void 0 === t && (t = {});
    var o = {};
    s(t, o, {
        data: "data",
        props: "properties",
        mixins: "behaviors",
        methods: "methods",
        beforeCreate: "created",
        created: "attached",
        mounted: "ready",
        relations: "relations",
        destroyed: "detached",
        classes: "externalClasses"
    });
    var i = t.relation;
    i && (o.relations = Object.assign(o.relations || {}, e({}, "../" + i.name + "/index", i))), 
    o.externalClasses = o.externalClasses || [], o.externalClasses.push("custom-class"), 
    o.behaviors = o.behaviors || [], o.behaviors.push(a.basic), t.field && o.behaviors.push("wx://form-field"), 
    o.options = {
        multipleSlots: !0,
        addGlobalClass: !0
    }, (0, r.observe)(t, o), Component(o);
};