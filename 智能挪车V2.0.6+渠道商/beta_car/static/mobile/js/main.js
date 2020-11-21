function autosize(){			//根据屏幕尺寸错保持元素比例
	//
	var rowh;
	rowh = autoheight('.zhuanpan',1080,934);
	rowh = rowh/3.47;
	$('.item').height(rowh);

	var lineheight;
	lineheight = autoheight('#time',892,129);
	$(".lh-100").css("line-height",lineheight+"px");
	autoheight('#duijiang',1126,719);

	autoheight('#duibtn',439,128);

	var msgh;
	msgh = $('.msg').height();
	$('.msg').css('border-radius',msgh+"px");
	msgh = msgh*2;
	$('.mstext').css('line-height',msgh+'px');

	autoheight('#conbtn',801,154)
}

function autoheight(id,w,h){  //根据宽度按一定比例计算高度
	var height;
	height = $(id).width()/w*h;
	$(id).height(height);		//自动设置元素高度
	return height;				//返回高度值
}

window.onresize = function(){
	autosize();
}


var jiang = {
		index: -1,    //当前转动到哪个位置，起点位置
		count: 8,     //总共有多少个位置
		timer: 0,     //setTimeout的ID，用clearTimeout清除
		speed: 20,    //初始转动速度
		times: 0,     //转动次数
		cycle: 50,    //转动基本次数：即至少需要转动多少次再进入抽奖环节
		prize: 6,    //中奖位置
		init: function(id) {
			if ($('#' + id).find('.item').length > 0) {
				$jiang = $('#' + id);
				$units = $jiang.find('.item');
				this.obj = $jiang;
				this.count = $units.length;
				$jiang.find('#g' + this.index).addClass('active');
			};
		},
		roll: function() {
			var index = this.index;
			var count = this.count;
			var jiang = this.obj;
			$(jiang).find('#g' + index).removeClass('active');
			index += 1;
			if (index > count - 1) {
				index = 0;
			};
			$(jiang).find('#g' + index).addClass('active');
			this.index = index;
			return false;
		},
		stop: function(index) {
			this.prize = index;
			return false;
		}
};

function roll() {
	jiang.times += 1;
	jiang.roll(); //转动过程调用的是jiang的roll方法，这里是第一次调用初始化
	
	if (jiang.times > jiang.cycle + 10 && jiang.prize == jiang.index) {
		clearTimeout(jiang.timer);
		jiang.prize = -1;
		jiang.times = 0;
		click = false;
	} else {
		if (jiang.times < jiang.cycle) {
			jiang.speed -= 10;
		} else if (jiang.times == jiang.cycle) {			/*↓↓↓↓↓这里是中奖位置接口，把随机数替换即可↓↓↓↓↓*/
			var index = Math.random() * (jiang.count) | 0; //静态演示，随机产生一个奖品序号，实际需请求接口产生
			jiang.prize = index;							//中奖位置取值0,1,2,3,4,5,6,7
		} else {
			if (jiang.times > jiang.cycle + 10 && ((jiang.prize == 0 && jiang.index == 7) || jiang.prize == jiang.index + 1)) {
				jiang.speed += 110;
			} else {
				jiang.speed += 20;
			}
		}
		if (jiang.speed < 40) {
			jiang.speed = 40;
		};
		jiang.timer = setTimeout(roll, jiang.speed); //循环调用
	}
	return false;
}

var click = false;

	var i=0;
function dan(){
	var dan0w,dan1w,dan3w;
	dan0w = $('#dan-0').width() + 30;
	$('#dan-0').css('margin-left',"-" + dan0w + "px");
	dan1w = $('#dan-1').width() + 30;
	$('#dan-1').css('margin-left',"-" + dan1w + "px");
	dan2w = $('#dan-2').width() + 30;
	$('#dan-2').css('margin-left',"-" + dan2w + "px");
	var ddelay = Math.random() * 2000;					//随机数弹出时间，用于效果演示
	if(i==0){
		$('#dan-0').css('margin-left',"30px");
		i++;
	} else if (i==1) {
		$('#dan-1').css('margin-left',"30px");
		i++;
	} else if (i==2) {
		$('#dan-2').css('margin-left',"30px");
		i++;
	} else {
		i = 0;
	}
	setTimeout(dan,ddelay);
	
}

window.onload = function(){
	// alert(123);
	dan();
	autosize();
	jiang.init('jiang');

	$('.start').click(function() {
		if (click) { //click控制一次抽奖过程中不能重复点击抽奖按钮，后面的点击不响应
			return false;
		} else {
			jiang.speed = 100;
			roll(); //转圈过程不响应click事件，会将click置为false
			click = true; //一次抽奖完成后，设置click为true，可继续抽奖
			return false;
		}
	});
}

