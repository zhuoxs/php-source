
function countDown(time,day_elem,hour_elem,minute_elem,second_elem){

	//if(typeof end_time == "string")

	var end_time = new Date(time).getTime(),//月份是实际月份-1

	//current_time = new Date().getTime(),

	sys_second = (end_time-new Date().getTime())/1000;

	var timer = setInterval(function(){

		if (sys_second > 0) {

			sys_second -= 1;

			var day = Math.floor((sys_second / 3600) / 24);

			var hour = Math.floor((sys_second / 3600) % 24);

			var minute = Math.floor((sys_second / 60) % 60);

			var second = Math.floor(sys_second % 60);

			day_elem && $(day_elem).text(day);//计算天

			$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时

			$(minute_elem).text(minute<10?"0"+minute:minute);//计算分

			$(second_elem).text(second<10?"0"+second:second);// 计算秒

		} else { 

			clearInterval(timer);

		}

	}, 1000);

}
