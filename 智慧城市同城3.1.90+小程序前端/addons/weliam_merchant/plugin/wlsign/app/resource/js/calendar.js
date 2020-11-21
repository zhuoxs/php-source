
var $$ = function(id) {
	return "string" == typeof id ? document.getElementById(id) : id;
};
var Class = {
	create: function() {
		return function() {
			this.initialize.apply(this, arguments);
		}
	}
}
Object.extend = function(destination, source) {
	for(var property in source) {
		destination[property] = source[property];
	}
	return destination;
}
var Calendar = Class.create();
Calendar.prototype = {
	initialize: function(container, options) {
		this.Container = $$(container);
		this.Days = [];
		this.SetOptions(options);
		this.Year = this.options.Year;
		this.Month = this.options.Month;
		this.onToday = this.options.onToday;
		this.onSignIn = this.options.onSignIn;
		this.onFinish = this.options.onFinish;
		this.qdDay = this.options.qdDay;
		this.isSignIn = false;
		this.Draw();
	},
	SetOptions: function(options) {
		this.options = {
			Year: new Date().getFullYear(),
			Month: new Date().getMonth() + 1,
			qdDay: null,
			onToday: function() {},
			onSignIn: function(){},
			onFinish: function() {}
		};
		Object.extend(this.options, options || {});
	},
	PreMonth: function() {
		var d = new Date(this.Year, this.Month - 2, 1);
		this.Year = d.getFullYear();
		this.Month = d.getMonth() + 1;
		this.Draw();
	},
	NextMonth: function() {
		var d = new Date(this.Year, this.Month, 1);
		this.Year = d.getFullYear();
		this.Month = d.getMonth() + 1;
		this.Draw();
	},
	Draw: function(state) {
		var day = this.qdDay;
		var arr = [];
		for(var i = 1, firstDay = new Date(this.Year, this.Month - 1, 1).getDay(); i <= firstDay; i++) {
			arr.push("&nbsp;");
		}
		for(var i = 1, monthDay = new Date(this.Year, this.Month, 0).getDate(); i <= monthDay; i++) {
			arr.push(i);
		}
		var frag = document.createDocumentFragment();
		this.Days = [];
        //获取当前时间
        var myDate  = new Date();
        var toDay   = myDate.getDate();//获取当前日
		while(arr.length > 0) {
			var row = document.createElement("tr");
			for(var i = 1; i <= 7; i++) {
				var cell = document.createElement("td");
				cell.innerHTML = "&nbsp;";
				if(arr.length > 0) {
					var d = arr.shift();
					cell.innerHTML = "<span>" + d + "</span>";
					if(d > 0 && day.length) {
						for(var ii = 0; ii < day.length; ii++) {
							this.Days[d] = cell;
							if(this.IsSame(new Date(this.Year, this.Month - 1, d), day[ii])) {
								this.onToday(cell);
							}else if(cell.className != 'onToday' && d <= toDay){
                                cell.className = 'onsign';//没有签到的时间
							}
						}
					}
				}
				row.appendChild(cell);
			}
			frag.appendChild(row);
		}
		while(this.Container.hasChildNodes()) {
			this.Container.removeChild(this.Container.firstChild);
		}
		this.Container.appendChild(frag);
        //签到页面数据获取状态
		this.onFinish(state);
		if(this.isSignIn) {
			this.isSignIn = false;
			return this.SignIn();
		}
	},
	IsSame: function(d1, d2) {
		d2 = new Date(d2 * 1000);
		return(d1.getFullYear() == d2.getFullYear() && d1.getMonth() == d2.getMonth() && d1.getDate() == d2.getDate());
	},
	checkSignIn: function(d1, d2) {
		d2 = new Date(d2 * 1000);
		return(d1.getFullYear() == d2.getFullYear() && d1.getMonth() == d2.getMonth() && d1.getDate() == d2.getDate());
	},
	SignIn: function() {
		var now = new Date();
		var Year = now.getFullYear();
		var Month = now.getMonth() + 1;
		if(Year != this.Year || Month != this.Month) {
			this.Year = Year;
			this.Month = Month;
			this.isSignIn = true;
			return this.Draw();
		}
		var day = now.getDate();
		var arr = new Array();
		var tb = document.getElementById('idCalendar');
		for(var i = 0; i < tb.rows.length; i++) {
			for(var j = 0; j < tb.rows[i].cells.length; j++) {
				if(day == tb.rows[i].cells[j].innerText && Year == this.Year && Month == this.Month) {
					if(tb.rows[i].cells[j].className == "onToday"){
						return 2;
					}
					tb.rows[i].cells[j].className = "onToday";
					this.qdDay.push(Date.parse(new Date()) / 1000);
					return 1;
				}
			}
		}
	}
};
