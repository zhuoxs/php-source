var weekday = [ "周天", "周一", "周二", "周三", "周四", "周五", "周六" ], times = [ "10:00", "10:30", "11:00", "11:30", "12:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00" ], myDate = new Date();

myDate.setDate(myDate.getDate());

for (var dateTemp, dateArray = [], c = [], flag = 1, i = 0; i < 7; i++) {
    var m = "", d = "";
    m = myDate.getMonth() + 1 < 10 ? "0" + (myDate.getMonth() + 1) : myDate.getMonth() + 1, 
    d = myDate.getDate() < 10 ? "0" + myDate.getDate() : myDate.getDate(), dateTemp = weekday[myDate.getDay()] + " " + m + "-" + d, 
    dateArray.push(dateTemp), myDate.setDate(myDate.getDate() + flag);
}

c[0] = dateArray, c[1] = times;

var formatTime = function(e) {
    return c;
}, formatNumber = function(e) {
    return (e = e.toString())[1] ? e : "0" + e;
};

module.exports = {
    formatTime: formatTime
};