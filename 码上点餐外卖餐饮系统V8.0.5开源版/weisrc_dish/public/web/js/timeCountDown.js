/* by zhangxinxu 2010-07-27 
* http://www.zhangxinxu.com/
* 倒计时的实现
*/
var fnTimeCountDown = function(d, o){
	

	var f = {
		haomiao: function(n){
			if(n < 10)return "00" + n.toString();
			if(n < 100)return "0" + n.toString();
			return n.toString();
		},
		zero: function(n){
			var n = parseInt(n, 10);//解析字符串,返回整数
			if(n > 0){
				if(n <= 9){
					n = "0" + n;	
				}
				return String(n);
			}else{
				return "00";	
			}
		},
		dv: function(){
			
			//d = d || Date.UTC(2050, 0, 1); //如果未定义时间，则我们设定倒计时日期是2050年1月1日
			var now = new Date();
			//现在将来秒差值
			//alert(future.getTimezoneOffset());
			var dur = (now.getTime() - d) / 1000 , mss = now.getTime() - d ,pms = {
				hm:"000",
				sec: "00",
				mini: "00",
				hour: "00",
				day: "00",
				month: "00",
				year: "0"
			};
			if(mss > 0){
				pms.hm = f.haomiao(mss % 1000);
				pms.sec = f.zero(dur % 60);
				pms.mini = Math.floor((dur / 60)) > 0? f.zero(Math.floor((dur / 60)) % 60) : "00";
				pms.hour = Math.floor((dur / 3600)) > 0? f.zero(Math.floor((dur / 3600)) % 24) : "00";
				pms.day = Math.floor((dur / 86400)) > 0? f.zero(Math.floor((dur / 86400))) : "00";// % 30
				//月份，以实际平均每月秒数计算
				pms.month = Math.floor((dur / 2629744)) > 0? f.zero(Math.floor((dur / 2629744)) % 12) : "00";
				//年份，按按回归年365天5时48分46秒算
				pms.year = Math.floor((dur / 31556926)) > 0? Math.floor((dur / 31556926)) : "0";
			}else{
				pms.year=pms.month=pms.day=pms.hour=pms.mini=pms.sec="00";
				pms.hm = "000";
				location.reload(true);
				return;
			}
			return pms;
		},
		ui: function(){
			
			
			if(o.hm){
				o.hm.html(f.dv().hm);
			}
			if(o.sec){
				o.sec.html(f.dv().sec);
			}
			if(o.mini){
				o.mini.html(f.dv().mini);
			}
			if(o.hour){
				o.hour.html(f.dv().hour);
			}
			if(o.day){
				o.day.html(f.dv().day);
			}
			if(o.month){
				o.month.html(f.dv().month);
			}
			if(o.year){
				o.year.html(f.dv().year);
			}			
			setTimeout(f.ui, 1);			
		}
	};	
f.ui();
};