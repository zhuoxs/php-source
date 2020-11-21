function e(e) {
    return e.length && !e[0].values;
}

(0, require("../common/component").VantComponent)({
    classes: [ "active-class", "toolbar-class", "column-class" ],
    props: {
        title: String,
        loading: Boolean,
        showToolbar: Boolean,
        confirmButtonText: String,
        cancelButtonText: String,
        visibleItemCount: {
            type: Number,
            value: 5
        },
        valueKey: {
            type: String,
            value: "text"
        },
        itemHeight: {
            type: Number,
            value: 44
        },
        columns: {
            type: Array,
            value: [],
            observer: function(t) {
                void 0 === t && (t = []), this.simple = e(t), this.children = this.selectAllComponents(".van-picker__column"), 
                Array.isArray(this.children) && this.children.length && this.setColumns().catch(function() {});
            }
        }
    },
    beforeCreate: function() {
        this.children = [];
    },
    methods: {
        noop: function() {},
        setColumns: function() {
            var e = this, t = this.data, n = (this.simple ? [ {
                values: t.columns
            } ] : t.columns).map(function(t, n) {
                return e.setColumnValues(n, t.values);
            });
            return Promise.all(n);
        },
        emit: function(e) {
            var t = e.currentTarget.dataset.type;
            this.simple ? this.$emit(t, {
                value: this.getColumnValue(0),
                index: this.getColumnIndex(0)
            }) : this.$emit(t, {
                value: this.getValues(),
                index: this.getIndexes()
            });
        },
        onChange: function(e) {
            this.simple ? this.$emit("change", {
                picker: this,
                value: this.getColumnValue(0),
                index: this.getColumnIndex(0)
            }) : this.$emit("change", {
                picker: this,
                value: this.getValues(),
                index: e.currentTarget.dataset.index
            });
        },
        getColumn: function(e) {
            return this.children[e];
        },
        getColumnValue: function(e) {
            var t = this.getColumn(e);
            return t && t.getValue();
        },
        setColumnValue: function(e, t) {
            var n = this.getColumn(e);
            return n ? n.setValue(t) : Promise.reject("setColumnValue: 对应列不存在");
        },
        getColumnIndex: function(e) {
            return (this.getColumn(e) || {}).data.currentIndex;
        },
        setColumnIndex: function(e, t) {
            var n = this.getColumn(e);
            return n ? n.setIndex(t) : Promise.reject("setColumnIndex: 对应列不存在");
        },
        getColumnValues: function(e) {
            return (this.children[e] || {}).data.options;
        },
        setColumnValues: function(e, t, n) {
            void 0 === n && (n = !0);
            var i = this.children[e];
            return i && JSON.stringify(i.data.options) !== JSON.stringify(t) ? i.set({
                options: t
            }).then(function() {
                n && i.setIndex(0);
            }) : Promise.reject("setColumnValues: 对应列不存在");
        },
        getValues: function() {
            return this.children.map(function(e) {
                return e.getValue();
            });
        },
        setValues: function(e) {
            var t = this, n = e.map(function(e, n) {
                return t.setColumnValue(n, e);
            });
            return Promise.all(n);
        },
        getIndexes: function() {
            return this.children.map(function(e) {
                return e.data.currentIndex;
            });
        },
        setIndexes: function(e) {
            var t = this, n = e.map(function(e, n) {
                return t.setColumnIndex(n, e);
            });
            return Promise.all(n);
        }
    }
});