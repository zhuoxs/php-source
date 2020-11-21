var html2wxml = require("html2wxml-main.js");

Component({
    data: {},
    properties: {
        text: {
            type: String,
            value: null,
            observer: function(t, a) {
                var e = this;
                if ("" != t && ("html" == this.data.type || "markdown" == this.data.type || "md" == this.data.type)) {
                    var i = {
                        text: this.data.text,
                        type: this.data.type,
                        highlight: this.data.highlight,
                        linenums: this.data.linenums
                    };
                    null != this.data.imghost && (i.imghost = this.data.imghost), wx.request({
                        url: "https://www.qwqoffice.com/html2wxml/",
                        data: i,
                        method: "POST",
                        header: {
                            "content-type": "application/x-www-form-urlencoded"
                        },
                        success: function(t) {
                            html2wxml.html2wxml(t.data, e, e.data.padding);
                        }
                    });
                }
            }
        },
        json: {
            type: Object,
            value: {},
            observer: function(t, a) {
                html2wxml.html2wxml(this.data.json, this, this.data.padding);
            }
        },
        type: {
            type: String,
            value: "html"
        },
        highlight: {
            type: Boolean,
            value: !0
        },
        highlightStyle: {
            type: String,
            value: "darcula"
        },
        linenums: {
            type: Boolean,
            value: !0
        },
        padding: {
            type: Number,
            value: 5
        },
        imghost: {
            type: String,
            value: null
        },
        showLoading: {
            type: Boolean,
            value: !0
        }
    },
    methods: {
        wxmlTagATap: function(t) {
            this.triggerEvent("WxmlTagATap", {
                src: t.currentTarget.dataset.src
            });
        }
    },
    attached: function() {}
});