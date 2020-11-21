Component({
    options: {
        multipleSlots: !0
    },
    behaviors: [],
    properties: {
        mapAarry: {
            type: Object,
            value: ""
        }
    },
    data: {},
    ready: function() {
        this.setData({
            mapAarry: this.data.mapAarry
        });
    },
    methods: {
        openLocation: function(t) {
            wx.openLocation({
                latitude: parseFloat(t.currentTarget.dataset.latitude),
                longitude: parseFloat(t.currentTarget.dataset.longitude),
                name: t.currentTarget.dataset.name,
                address: t.currentTarget.dataset.address
            });
        }
    }
});