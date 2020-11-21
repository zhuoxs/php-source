var weekday = [ "周天", "周一", "周二", "周三", "周四", "周五", "周六" ], myDate = new Date();

myDate.setDate(myDate.getDate());

for (var dateTemp, dateArray = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1, 
    d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate(), dateTemp = weekday[myDate.getDay()] + " " + m + "-" + d, 
    dateArray.push(dateTemp), myDate.setDate(myDate.getDate() + flag);
}

c[0] = dateArray;

var formatTime = function(e) {
    return c;
}, formatNumber = function(e) {
    return (e = e.toString())[1] ? e : "0" + e;
};

module.exports = {
    formatTime: formatTime
};