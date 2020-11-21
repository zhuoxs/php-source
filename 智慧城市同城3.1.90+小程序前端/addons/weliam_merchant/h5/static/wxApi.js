import App from "@/common/js/app.js"
const wxApi = {
	configData: null,
	/**
	 * [wxRegister 微信Api初始化]
	 */
	wxRegister(callback) {
		let _this = this,
			signUrl = encodeURIComponent(location.href.split("#")[0]),
			jsApiList = ["onMenuShareTimeline", "onMenuShareAppMessage", "openBusinessView", "scanQRCode", "getLocation","chooseImage","uploadImage"];
		App._post_form("&do=getJssdk", {
			sign_url: signUrl
		}, (res) => {
			let data = res.data;
			jWeixin.config({
				debug: false, // 开启调试模式
				appId: data.appId, // 必填，公众号的唯一标识
				timestamp: data.timestamp, // 必填，生成签名的时间戳
				nonceStr: data.nonceStr, // 必填，生成签名的随机串
				signature: data.signature, // 必填，签名
				jsApiList: jsApiList // 必填，需要使用的JS接口列表
			});
			jWeixin.ready(() => {
				callback && callback();
			});


			_this.configData = {
				...data,
				url: signUrl
			}

			jWeixin.error((optinos) => {
				// config信息验证失败会执行error函数，
				//如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，
				//也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
				uni.showModal({
					content: JSON.stringify(optinos)
				})
			});
		});
	},
	wxShare(options) {
		jWeixin.onMenuShareAppMessage(options);
		jWeixin.onMenuShareTimeline(options);
		// jWeixin.onMenuShareTimeline({
		// 	title: options.title, // 分享标题
		// 	desc: options.desc, // 分享描述
		// 	link: options.link, // 分享链接
		// 	imgUrl: options.imgUrl, // 分享图标
		// 	success: function() {
		// 		// 用户点击了分享后执行的回调函数
		// 	},
		// })
	},
	wxPay(options) {
		jWeixin.chooseWXPay({
			timestamp: options.timeStamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
			nonceStr: options.nonceStr, // 支付签名随机串，不长于 32 位
			package: options.package, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
			signType: options.signType, // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
			paySign: options.paySign, // 支付签名
			success(res) {
				// 支付成功后的回调函数
				options.success && options.success(res)
			},
			cancel(res) {
				options.cancel && options.cancel(res)
			},
			fail(res) {
				options.fail && options.fail(res)
			}
		});
	},
	scanQRCode(callback) {
		jWeixin.scanQRCode({
			needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
			scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
			complete(res) {
				callback && callback(res);
			}
		});
	},
	getLocation(optinos) {
		jWeixin.getLocation({
			...optinos
		});
	},
	// 选取图片
	choseImage(callback) {
		jWeixin.chooseImage({
			count: 1, // 默认9
			sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			complete: function(res) {
				callback && callback(res);
			}
		});
	},
	//上传图片
	uoloadIg(localId,callback) {
		jWeixin.uploadImage({
			localId: localId, // 需要上传的图片的本地ID，由chooseImage接口获得
			isShowProgressTips: 1, // 默认为1，显示进度提示
			complete: function(res) {
				callback && callback(res)
			}
		});
	},
	/**
	 * 微信好物圈
	 */
	wxGoodsCircle(queryString, success, fail) {
		jWeixin.openBusinessView({
			businessType: 'friendGoodsRecommend',
			queryString: queryString,
			success(res) {
				success && success(res);
			},
			fail(res) {
				fail && fail(res);
			}
		})
	}
}
export default wxApi
