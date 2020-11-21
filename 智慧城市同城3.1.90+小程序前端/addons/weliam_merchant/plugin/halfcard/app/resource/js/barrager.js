(function($) {
	function Barrager(dom, drawW, drawH) {
		var _this = this; //保存Barrager指向
		this.canvas = dom.get(0);
		this.ctx = this.canvas.getContext("2d");
		this.canvas.style.width = drawW +'px';
		this.canvas.style.height = drawH +'px';
		this.bufferingBefore = 0;
		this.msgs = new Array(300); //缓冲池，长度越大，屏幕上显示的就越多
		this.imgs = [];
		this.flag = 0;
		this.width = drawW*2;
		this.height = drawH*2;
		this.arcSize = 20;
		this.rectW = 0;
		this.rectH = 60;
		this.rectR = this.rectH/2;
		this.fontL = this.arcSize * 4;
		this.fontT = (this.rectH - this.rectH / 2) + this.arcSize / 2;
		this.imgL = 5;
		this.imgT = this.rectH / 2 - this.arcSize;
		this.canvas.width = this.width;
		this.canvas.height = this.height;
		this.font = "30px 微软雅黑"; //字体和字体大小
		this.ctx.font = this.font;
		//颜色数组，在绘制过程中从这里取出颜色
		this.colorArr = ['rgba(255,255,255,1)'];
		this.draw = function() { //绘制方法
			var _that = this,_data = _this.imgs;
			_this.interval = null;
			clearInterval(_this.interval);
			if(_this.interval != null) return;
			//挂载定时器
			_this.interval = setInterval(function() { //每隔20毫秒重新绘制一次，间隔最好小于40，要不然效果就跟播放图片差不多
				//1，清除屏幕
				_this.ctx.clearRect(0, 0, _this.width, _this.height);
				_this.ctx.save();
				//2，将当前缓冲区内的数据对象没有设置Left，Top，Speed，Color先赋值，赋值的就改变left值（产生移动效果），left值小于200就会从缓冲区移除
				for(var i = 0; i < _data.length; i++) {
					if(!(_data == null || _data[i] == "" || typeof(_data[i]) == "undefined")) {
						if(_data[i].L == null || typeof(_data[i].L) == "undefined") {
							_data[i].L = _this.width;
							_data[i].T = parseInt(_this.random(2,(_this.height-_this.rectH)));
							_data[i].S = parseInt(_this.random(1,6));
							_data[i].C = _this.colorArr[Math.floor(Math.random() * _this.colorArr.length)];
						} else {
							//设置渐变背景宽度,根据文字数量计算，并且加上图片大小以及图片边距，文字的边距
							_this.rectW = _this.ctx.measureText(_data[i].msg).width + _this.arcSize + _this.imgL + _this.fontL;
							if(_data[i].L < _this.rectW * -1) {
								_data[i].L = _this.width;
							} else {
								/* 指定渐变区域 */
								_this.ctx.beginPath();
								/* 设置渐变fillStyle */
								_this.ctx.fillStyle = _this.linearGradient(_this.ctx, _data[i].L, _data[i].T, _data[i].L + _this.rectW, _data[i].T + _this.rectH, 'rgba(255, 130, 50,.9)', 'rgba(254, 67, 63,9)');
								/* 绘制圆角矩形 */
								_this.roundRect(_data[i].L, _data[i].T, _this.rectW, _this.rectH, _this.rectR, _this.ctx);
								_this.ctx.fill();
								//绘制图片
								_this.ctx.beginPath();
								_this.circleImg(_this.ctx, _data[i], _data[i].L + _this.imgL * 2, _data[i].T + _this.imgT, _this.arcSize);
								//绘制文字
								_this.ctx.beginPath();
								_data[i].L = parseInt(_data[i].L - _data[i].S);
								_this.ctx.fillStyle = _data[i].C;
								_this.ctx.fillText(_data[i].msg, _data[i].L + _this.fontL, _data[i].T + _this.fontT);
								_this.ctx.restore();
							}
						}
					}
				}
			}, 20);
		};

		// 绘制圆形图片
		this.circleImg = function(ctx, img, x, y, r) {
			ctx.save();
			var d = 2 * r;
			var cx = x + r;
			var cy = y + r;
			ctx.arc(cx, cy, r, 0, 2 * Math.PI);
			ctx.clip();
			ctx.drawImage(img, x, y, d, d);
			ctx.restore();
		};

		//绘制圆角矩形
		this.roundRect = function(x, y, w, h, r, cxt) {
			cxt.beginPath();
			cxt.lineWidth = 0; //线条的宽度
			cxt.strokeStyle = "rgba(0,0,0,0)"; //线条的颜色
			cxt.moveTo(x + r, y);
			cxt.arcTo(x + w, y, x + w, y + h, r);
			cxt.arcTo(x + w, y + h, x, y + h, r);
			cxt.arcTo(x, y + h, x, y, r);
			cxt.arcTo(x, y, x + w, y, r);
			cxt.closePath();
			cxt.stroke();
		};
		this.linearGradient = function(ctx, left, top, leftSize, topSize, startC, endC) {
			var grad = ctx.createLinearGradient(left, top, leftSize, topSize);
			grad.addColorStop(0, startC);
			grad.addColorStop(1, endC);
			return grad;
		};
		//添加数据，格式[{"key":"value"}]
		this.putMsg = function(datas) {
			//存储数据缓冲前的长度
			_this.bufferingBefore = datas.length;
//			//循环缓冲区，把位置是空的装填上数据
			for(var j = 0; j < datas.length; j++) {
				for(var i = 0; i < _this.msgs.length; i++) {
					if(_this.msgs[i] == null || _this.msgs[i] == "" || typeof(_this.msgs[i]) == "undefined") {
						_this.msgs[i] = datas[j];
						break;
					}
				}
			}
			//获取图片资源并填充剩余数据
			_this.loadImg.call(this, this.msgs);
		};
		this.random = function RandomNum(Min,Max){
      		var Range = Max - Min;
      		var Rand = Math.random();
      		var num = Min + Number((Rand * Range).toFixed(2)); 
      		return num;
		}
		this.loadImg = function(dataMsg) {
			for(var i = 0; i <= _this.bufferingBefore; i++) {
				if(dataMsg[i] != null && dataMsg[i] != "" && typeof(dataMsg[i]) != "undefined") {
					var newImg = new Image();
					newImg.src = dataMsg[i].imgurl;
					newImg.msg = dataMsg[i].msg;
					newImg.onload = function() {
						_this.flag += 1;
						//存储img图片资源
						_this.imgs.push(this);
						//第一张图片加载完成后调用绘图，之后根据加载完成的图片数量来增加绘图
						(_this.flag === 1)&&_this.draw.call(this);
					}
				}
			}
		};
		//清除定时器，清除屏幕，清空缓冲区
		this.clear = function() {
			_this.interval = null;
			clearInterval(_this.interval);
			_this.ctx.clearRect(0, 0, _this.width, _this.height);
			_this.ctx.save();
			for(var i = 0; i < _this.msgs.length; i++) {
				_this.msgs[i] = null;
			}
		};
	}

	$.fn.barrager = function(para, drawW, drawH) {
		if(typeof para == 'object' || !para && Object.prototype.toString.call(para) === "[object Array]") {
			$this = $(this);
			var api = new Barrager($this, drawW, drawH);
			api.putMsg(para);
		} else {
			$.error('does not exist on jQuery');
		}
		return this;
	}
})(jQuery);