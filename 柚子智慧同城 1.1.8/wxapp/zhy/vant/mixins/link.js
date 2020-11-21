Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.link = Behavior({
    properties: {
        url: String,
        linkType: {
            type: String,
            value: "navigateTo"
        }
    },
    methods: {
        jumpLink: function(e) {
            void 0 === e && (e = "url");
            var t = this.data[e];
            t && wx[this.data.linkType]({
                url: t
            });
        }
    }
});