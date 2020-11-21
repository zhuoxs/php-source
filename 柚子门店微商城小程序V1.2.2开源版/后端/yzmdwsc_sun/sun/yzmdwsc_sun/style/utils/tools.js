var weekday = ["周天", "周一", "周二", "周三", "周四", "周五", "周六"];
var times = [ '10:00', '10:30', '11:00', '11:30', '12:00', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '22:00', '20:30', '21:00', '21:30','22:00'];
var myDate = new Date();
myDate.setDate(myDate.getDate());
var dateArray = [];
var dateTemp;
var c = [];
var flag = 1;
for (var i = 0; i < 7; i++) {
  var m='';
  var d='';
  if ((myDate.getMonth() + 1)<10){
    m = '0' + (myDate.getMonth() + 1);
  }else{
    m =myDate.getMonth() + 1;
  }
  if (myDate.getDate()<10){
    d = '0' + myDate.getDate();
  }else{
    d = myDate.getDate();
  }
  dateTemp = weekday[myDate.getDay()]+' '+m + "-" + d;
  dateArray.push(dateTemp);
  myDate.setDate(myDate.getDate() + flag);
}
c[0] = dateArray;
c[1] = times;
const formatTime = date => {
  return c;
}
const formatNumber = n => {
  n = n.toString()
  return n[1] ? n : '0' + n
}

module.exports = {
  formatTime: formatTime
}

