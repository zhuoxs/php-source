var countDown = function (that, endtime) {

  var curTime = Date.parse(new Date());/**当前时间戳 */
  var total_micro_second = endtime - curTime;/**总秒数 */
  var countdown = [];
  countdown = date_format(total_micro_second);
  if (total_micro_second <= 0) {
    countdown = "";
  }
  setTimeout(function () {
    total_micro_second -= 100;
    countDown(that, endtime);
  }, 1000)

  return countdown;
}

/* 时间格式化输出*/
function date_format(micro_second) {
  var time = [];
  var second = Math.floor(micro_second / 1000);
  var day = Math.floor(second / 3600 / 24);
  var h = Math.floor((second - day * 60 * 60 * 24) / 3600);
  var hr = Math.floor(second / 3600);
  var min = fill_zero_prefix(Math.floor((second - hr * 3600) / 60));
  var sec = fill_zero_prefix((second - hr * 3600 - min * 60));
  time.push(day);
  time.push(h);
  time.push(hr);
  time.push(min);
  time.push(sec);
  // return '距离结束还剩：' + day + '天' + h + "时" + min + "分" + sec + "秒";
  return time;
}
/*位数不足补零*/
function fill_zero_prefix(num) {
  return num < 10 ? "0" + num : num
}

module.exports = {
  countDown: countDown
}