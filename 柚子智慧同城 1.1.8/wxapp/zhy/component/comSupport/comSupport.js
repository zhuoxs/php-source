getApp();

Component({
    properties: {
        info: {
            type: Object,
            value: {},
            observer: function(e, t) {}
        },
        root: {
            type: String,
            value: "",
            observer: function(e, t) {}
        }
    },
    methods: {
        _onCallTab: function() {
            wx.makePhoneCall({
                phoneNumber: this.data.info.jszc_tel
            });
        }
    }
});