Component({
    properties: {},
    data: {
        formats: {},
        bottom: 0,
        readOnly: !1,
        placeholder: "开始输入...",
        _focus: !1,
        htmldata: "<p>1345</p>"
    },
    methods: {
        onEditorReady: function() {
            var e = this;
            this.createSelectorQuery().select("#editor").context(function(t) {
                console.log("createSelectorQuery"), console.log(t.context), e.editorCtx = t.context;
            }).exec();
        },
        setContents: function(t, e) {
            e || (e = 0), this.editorCtx ? (console.log(t), this.editorCtx.setContents(t)) : e < 5 && setTimeout(function() {
                this.setContents(t, ++e);
            }, 1e3);
        },
        undo: function() {
            this.editorCtx.undo();
        },
        redo: function() {
            this.editorCtx.redo();
        },
        format: function(t) {
            var e = t.target.dataset, o = e.name, i = e.value;
            o && this.editorCtx.format(o, i);
        },
        onStatusChange: function(t) {
            var e = t.detail;
            this.setData({
                formats: e
            });
        },
        insertDivider: function() {
            this.editorCtx.insertDivider({
                success: function() {
                    console.log("insert divider success");
                }
            });
        },
        clear: function() {
            this.editorCtx.clear({
                success: function(t) {
                    console.log("clear success");
                }
            });
        },
        removeFormat: function() {
            this.editorCtx.removeFormat();
        },
        insertDate: function() {
            var t = new Date(), e = t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate();
            this.editorCtx.insertText({
                text: e
            });
        },
        insertImage: function() {
            this.triggerEvent("editorupfileimg", {}, {});
        },
        bindinput: function(t) {
            this.triggerEvent("editorinput", t.detail, null);
        },
        backfun: function(t) {
            this.editorCtx.insertImage({
                src: t,
                data: {
                    id: "abcd",
                    role: "god"
                },
                success: function() {
                    console.log("insert image success");
                }
            });
        }
    }
});