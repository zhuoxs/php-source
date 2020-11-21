function systemInfo() {
    var e;
    return wx.getSystemInfo({
        success: function(s) {
            e = s.system;
        }
    }), e = e.slice(0, 3);
}

module.exports = {
    ClientVersion: "3.8.0",
    systemInfo: systemInfo
};