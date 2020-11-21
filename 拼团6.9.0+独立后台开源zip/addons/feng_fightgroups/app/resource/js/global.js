$.config = {
	router: false,
    routerFilter: function($link) {
        var href = $($link).attr('href');
        if ($link.hasClass('redirect') && href != '') {
            $.toast('跳转中...');
            return false;
        }
//      if ($link.hasClass('external')) {
//          $.showIndicator();
//      }
        if ($link.hasClass('disable-router')) {
            return false;
        }
        return true;
        
    }
};
function hideinde(){
	$.hideIndicator();
}
setInterval(hideinde,1500);

var Light7Timer = function (container, params) {
    var defaults = {
        startLabel: "距离开始",
        endLabel: "距离结束",
        endText: "活动已结束",
        label: '.label'
    };
    var self = this;
    self.params = $.extend(defaults, params || {});
    self.container = $(container);
    self.params.now = self.container.data('now');
    if (self.params.now) {
        self.params.now = new Date(Date.parse(self.params.now.replace(/-/g, "/")));
    } else {
        self.params.now = new Date();
    }

    self.params.nowTime = self.params.now.getTime();
    self.params.start = self.container.data('start') || self.params.start || false;
    self.params.end = self.container.data('end') || self.params.end || false;
    self.params.startLabel = self.container.data('startLabel') || self.params.startLabel || '';		// 开始 文字
    self.params.endLabel = self.container.data('endLabel') || self.params.endLabel || '';		// 结束文字
    self.params.endText = self.container.data('endText') || self.params.endText || '';		// 结束描述文字
    self.params.label = self.container.data('label') || self.params.label;					// 文字投放元素
    self.params.labelChange = self.params.labelChange;	// 是否自动修改标签
    if (self.container.data('label-change') === false) {
        self.params.labelChange = false;
    }
    self.timeD = self.container.find('.day');
    self.timeH = self.container.find('.hour');
    self.timeM = self.container.find('.minute');
    self.timeS = self.container.find('.second');
    self.timer = 0;

    self.stop = function () {
        clearTimeout(self.timer);
        return;
    };
    self.update = function () {

        var startTime = false, endTime = false;
        if (self.params.start) {
            startTime = +new Date(Date.parse(self.params.start.replace(/-/g, "/")));
        }
        if (self.params.end) {
            endTime = +new Date(Date.parse(self.params.end.replace(/-/g, "/")));
        }
        var status = 0;
        if (startTime && endTime) {
            //两个时间都有
            if (startTime > self.params.nowTime) {
                //未开始
                status = -1;
            } else if (endTime < self.params.nowTime) {
                //已结束
                status = 1;
            } else if(startTime == self.params.nowTime){
                if (self.params.onStart) {
                    self.params.onStart(self.container);
                }
            }
        } else if (startTime) {
            //只有开始时间
            if (startTime > self.params.nowTime) {
                //未开始
                status = -1;
            }else if(startTime == self.params.nowTime){
                if (self.params.onStart) {
                    self.params.onStart(self.container);
                }
            }
        } else if (endTime) {
            //只有开始时间
            if (endTime < self.params.nowTime) {
                //未开始
                status = 1;
            }
        }
        var time = 0;
        if (status == -1) {
            //未开始
            time = startTime;
            if (self.params.startLabel !=='') {
                $(self.params.label, self.container).html(self.params.startLabel);
            }
        } else if (status == 1) {
            //已结束
            if (self.params.endText !== '') {
                $(self.timeD).parent().html(self.params.endText);
            }
            return;
        } else {
            time = endTime;
            if (self.params.endLabel !== '') {

                $(self.params.label, self.container).html(self.params.endLabel);
            }
        }

        //正在进行
        if (time > 0) {
            var lag = (time - self.params.nowTime) / 1000; //当前时间和结束时间之间的秒数

            if (lag > 0) {
                var second = Math.floor(lag % 60) + "";
                var minute = Math.floor((lag / 60) % 60) + "";
                var hour = Math.floor((lag / 3600) % 24) + "";
                var day = Math.floor((lag / 3600) / 24) + "";
                $(self.timeD).text(day);
                $(self.timeH).text(hour.length == 1 ? '0' + hour : hour);
                $(self.timeM).text(minute.length == 1 ? '0' + minute : minute);
                $(self.timeS).text(second.length == 1 ? '0' + second : second);

            } else {
                if (self.params.onEnd) {
                    self.stop();
                    self.params.onEnd(self.container);
                }
                return;
            }
            self.timer = setTimeout(function () {
                self.params.nowTime += 1000;
                self.update();
            }, 1000);
        }
    };
    self.update();
};
$.fn.timer = function (params) {
    var args = arguments;
    return this.each(function () {
        if (!this)
            return;
        var $this = $(this);
        var timer = $this.data("timer");
        if (!timer) {
            timer = new Light7Timer(this, params || {});
            $this.data("timer", timer);
        }
        if (typeof params === typeof "a") {
            timer[params].apply(timer, Array.prototype.slice.call(args, 1));
        }
    });
};
