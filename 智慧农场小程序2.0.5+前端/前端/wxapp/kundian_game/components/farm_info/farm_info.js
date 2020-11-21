Component({
    properties: {
        farmExplain: {
            type: String,
            value: ""
        },
        farmName: {
            type: String,
            value: ""
        }
    },
    data: {},
    methods: {
        closeFarm: function() {
            this.triggerEvent("ShowFarm");
        }
    }
});