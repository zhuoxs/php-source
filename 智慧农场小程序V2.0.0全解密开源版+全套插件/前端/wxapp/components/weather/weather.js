Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        weather: {
            type: Object,
            value: []
        },
        weatherSet: {
            type: Object,
            value: []
        }
    },
    data: {},
    methods: {
        intoWeather: function(e) {
            wx.navigateTo({
                url: "/kundian_farm/pages/HomePage/weather/index?farm_name=" + this.data.weather.farm_name + "&weatherSet=" + JSON.stringify(this.data.weatherSet)
            });
        }
    }
});