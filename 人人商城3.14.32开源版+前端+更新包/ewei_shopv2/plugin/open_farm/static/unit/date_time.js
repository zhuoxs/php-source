var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var checkin = $('#start_time').fdatepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    pickTime: true,
    onRender: function (date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    // if (ev.date.valueOf() >checkout.date.valueOf()) {
    //     // var newDate = new Date(ev.date);
    // }
}).data('datepicker');
var checkout = $('#end_time').fdatepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    pickTime: true,
    onRender: function (date) {
        var checkin_data =new Date(timeFormat(checkin.date.valueOf()));
        return date.valueOf() <checkin_data.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
}).data('datepicker');
function add0(m){return m<10?'0'+m:m }
//时间戳转化成时间格式
function timeFormat(timestamp){
    //timestamp是整数，否则要parseInt转换,不会出现少个0的情况
    var time = new Date(timestamp);
    var year = time.getFullYear();
    var month = time.getMonth()+1;
    var date = time.getDate();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();
    return year+'-'+add0(month)+'-'+add0(date);
}