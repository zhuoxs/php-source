function wxAutoImageCal(t, e) {
    var i = 0, g = 0, a = 0, n = {};
    return wx.getSystemInfo({
        success: function(o) {
            i = o.windowWidth, o.windowHeight, console.log("windowWidth" + i), i < t ? (g = i, 
            console.log("autoWidth" + g), a = g * e / t, console.log("autoHeight" + a), n.imageWidth = g, 
            n.imageheight = a) : (n.imageWidth = t, n.imageheight = e);
        }
    }), n;
}

module.exports = {
    wxAutoImageCal: wxAutoImageCal
};