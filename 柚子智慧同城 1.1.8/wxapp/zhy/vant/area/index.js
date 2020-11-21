(0, require("../common/component").VantComponent)({
    classes: [ "active-class", "toolbar-class", "column-class" ],
    props: {
        title: String,
        value: String,
        loading: Boolean,
        itemHeight: {
            type: Number,
            value: 44
        },
        visibleItemCount: {
            type: Number,
            value: 5
        },
        columnsNum: {
            type: [ String, Number ],
            value: 3
        },
        areaList: {
            type: Object,
            value: {}
        }
    },
    data: {
        columns: [ {
            values: []
        }, {
            values: []
        }, {
            values: []
        } ],
        displayColumns: [ {
            values: []
        }, {
            values: []
        }, {
            values: []
        } ]
    },
    watch: {
        value: function(e) {
            this.code = e, this.setValues();
        },
        areaList: "setValues",
        columnsNum: function(e) {
            this.set({
                displayColumns: this.data.columns.slice(0, +e)
            });
        }
    },
    methods: {
        getPicker: function() {
            return null == this.picker && (this.picker = this.selectComponent(".van-area__picker")), 
            this.picker;
        },
        onCancel: function(e) {
            this.emit("cancel", e.detail);
        },
        onConfirm: function(e) {
            this.emit("confirm", e.detail);
        },
        emit: function(e, t) {
            t.values = t.value, delete t.value, this.$emit(e, t);
        },
        onChange: function(e) {
            var t = e.detail, i = t.index, n = t.picker, s = t.value;
            this.code = s[i].code, this.setValues(), this.$emit("change", {
                picker: n,
                values: n.getValues(),
                index: i
            });
        },
        getConfig: function(e) {
            var t = this.data.areaList;
            return t && t[e + "_list"] || {};
        },
        getList: function(e, t) {
            var i = [];
            if ("province" !== e && !t) return i;
            var n = this.getConfig(e);
            return i = Object.keys(n).map(function(e) {
                return {
                    code: e,
                    name: n[e]
                };
            }), t && ("9" === t[0] && "city" === e && (t = "9"), i = i.filter(function(e) {
                return 0 === e.code.indexOf(t);
            })), i;
        },
        getIndex: function(e, t) {
            var i = "province" === e ? 2 : "city" === e ? 4 : 6, n = this.getList(e, t.slice(0, i - 2));
            "9" === t[0] && "province" === e && (i = 1), t = t.slice(0, i);
            for (var s = 0; s < n.length; s++) if (n[s].code.slice(0, i) === t) return s;
            return 0;
        },
        setValues: function() {
            var e = this, t = this.getConfig("county"), i = this.code || Object.keys(t)[0] || "", n = this.getList("province"), s = this.getList("city", i.slice(0, 2)), c = this.getPicker();
            if (c) {
                var u = [];
                return u.push(c.setColumnValues(0, n)), u.push(c.setColumnValues(1, s)), s.length && "00" === i.slice(2, 4) && (i = s[0].code), 
                u.push(c.setColumnValues(2, this.getList("county", i.slice(0, 4)))), Promise.all(u).then(function() {
                    return c.setIndexes([ e.getIndex("province", i), e.getIndex("city", i), e.getIndex("county", i) ]);
                }).catch(function() {});
            }
        },
        getValues: function() {
            var e = this.getPicker();
            return e ? e.getValues().filter(function(e) {
                return !!e;
            }) : [];
        },
        getDetail: function() {
            var e = this.getValues(), t = {
                code: "",
                country: "",
                province: "",
                city: "",
                county: ""
            };
            if (!e.length) return t;
            var i = e.map(function(e) {
                return e.name;
            });
            return t.code = e[e.length - 1].code, "9" === t.code[0] ? (t.country = i[1] || "", 
            t.province = i[2] || "") : (t.province = i[0] || "", t.city = i[1] || "", t.county = i[2] || ""), 
            t;
        },
        reset: function() {
            return this.code = "", this.setValues();
        }
    }
});