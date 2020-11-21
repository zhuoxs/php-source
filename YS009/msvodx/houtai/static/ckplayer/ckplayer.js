function ckplayerConfig() {
	return {
		flashvars: {}, //用来补充flashvars里的对象
		languagePath: '', //语言包文件地址
		stylePath: '', //风格包文件地址
		config: {
			fullInteractive: true, //是否开启交互功能
			schedule: 1, //是否启用进度调节栏,0不启用，1是启用，2是只能前进（向右拖动），3是只能后退，4是只能前进但能回到第一次拖动时的位置，5是看过的地方可以随意拖动
			delay: 30, //延迟加载视频，单位：毫秒
			timeFrequency: 100, //计算当前播放时间和加载量的时间频率，单位：毫秒
			autoLoad: false, //视频是否自动加载
			loadNext: 0, //多段视频预加载的段数，设置成0则全部加载
			definition: true, //是否使用清晰度组件
			smartRemove: true, //是否使用智能清理，使用该功能则在多段时当前播放段之前的段都会被清除出内存，减少对内存的使用
			bufferTime: 200, //缓存区的长度，单位：毫秒,不要小于100
			click: true, //是否支持屏幕单击暂停
			doubleClick: true, //是否支持屏幕双击全屏
			doubleClickInterval: 200, //判断双击的标准，即二次单击间隔的时间差之内判断为是双击，单位：毫秒
			keyDown: {
				space: true, //是否启用空格键切换播放/暂停
				left: true, //是否启用左方向键快退
				right: true, //是否启用右方向键快进
				up: true, //是否支持上方向键增加音量
				down: true //是否支持下方向键减少音量
			},
			timeJump: 10, //快进快退时的秒数
			volumeJump: 0.1, //音量调整的数量，大于0小于1的小数
			timeScheduleAdjust: 1, //是否可调节调节栏,0不启用，1是启用，2是只能前进（向右拖动），3是只能后退，4是只能前进但能回到第一次拖动时的位置，5是看过的地方可以随意拖动
			previewDefaultLoad: true, //预览图片是否默认加载，优点是鼠标第一次经过进度条即可显示预览图片
			promptSpotTime: false, //提示点文字是否在前面加上对应时间
			buttonMode: {
				player: false, //鼠标在播放器上是否显示可点击形态
				controlBar: false, //鼠标在控制栏上是否显示可点击形态
				timeSchedule: true, //鼠标在时间进度条上是否显示可点击形态
				volumeSchedule: true //鼠标在音量调节栏上是否显示可点击形态
			},
			liveAndVod: { //直播+点播=回播功能
				open: false, //是否开启，开启该功能需要设置flashvars里live=true
				vodTime: 2, //可以回看的整点数
				start: 'start' //回看请求参数
			},
			errorNum: 3, //错误重连次数
			playCorrect: false, //是否需要错误修正，这是针对rtmp的
			timeCorrect: true, //http视频播放时间错误纠正，有些因为视频格式的问题导致视频没有实际播放结束视频文件就返回了stop命令
			m3u8Definition: { //m3u8自动清晰度时按关键字来进行判断
				//tags:['110k','200k','400k','600k','1000k']
			},
			m3u8MaxBufferLength: 30, //m3u8每次缓冲时间，单位：秒数
			timeStamp: '', //一个地址，用来请求当前时间戳，用于播放器内部时间效准
			addCallback: 'adPlay,adPause,playOrPause,videoPlay,videoPause,videoMute,videoEscMute,videoClear,changeVolume,fastBack,fastNext,videoSeek,newVideo,getMetaDate,videoRotation,videoBrightness,videoContrast,videoSaturation,videoHue,videoZoom,videoProportion,videoError,addListener,removeListener,addElement,getElement,deleteElement,animate,animateResume,animatePause,changeConfig,getConfig,openUrl,fullScreen,quitFullScreen,switchFull,screenshot,custom,changeControlBarShow'
			//需要支持的事件
		},
		menu: { //版权名称支持
			ckkey: 'f100d40d974b1d27dfa425950c4896ea',
			name: 'msvodx.com',
			link: 'http://www.msvodx.com',
			version: '',
			domain: '',
			more: []
		},
		style: { //风格部分内容配置，这里主要配置loading和logo以及广告的部分内容
			loading: {
				file: 'data:image/swf;base64,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',
				align: 'center',
				vAlign: 'middle',
				offsetX: -200,
				offsetY: -120
			},
			logo: {
				file: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAXCAYAAADAxotdAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAcISURBVHja7JprbFVVFsd/99EH7aVAtaBWFBQVH4iM80FEQ3wEM5L4ii80EdSgEgmJiY/RITEaQ/wgzjCj8RE1GHWSGaNoQBHrA4kPQEEQCoKiIIK00BJaCqXt7d8PrEsOx3PO3u2tXwgr2ck566zH3mvtvfbaa5+UJI7CkQuZIdkHGXZGhspcqoBLA1VAuWcrAbqt+UCFNR/ZZdafLofMUutziT2ngXyRtqk0/R094OlnfCXW556snoqATpddSo3HOcZsbXOeXOlhuMuA13rQuU6gFdgJrAGWAquBjRHGKQXqgFM95XcD+4Em4CeTvQLYYPoKMBhYbAbOm969wBZgITAPaOiBsc8AFpixFwL3RkyyMuBsYAww3nhqrA9dQDOw2fr1BfAd0B630EzPSI+FkrIxttr4vgE+BVYBu/5A/daU3TSs7URSoT2s4qFLUr2k2wNykTRMUkcfyG+U9IqkoQHZCxPo6yVVh/oS10olLQ/w7pFUFfiekjRD0roe9rle0p0xOmsl7S/SJjsk/UNSOiibJVP3sa3uMAe/or6FBZJONNkX97HsXyVdb7KnOGif93TwtBDfN+ZUJP1V0idF9nmOpH4hnRf2oU0WSRp+yMELprSw/s32oLIlDgHrrUNjzWEPSDrg4FkjqVLStR4dfNxkjzP6JR4815j8RkdUOd/h3GpJW0J819q3hyS1x8jusAl0haSLJN0nqS2hL8tCUWGqxxhnmE3G2WTemEC7xaIlzL+9haVPtxUUpSV957Eiw4aZIqnbwfegpFs8BjIhwuibHDybJWUlzXfQPeNw8L9D9O8ZfpZD7vQIWZM9JnKB9ikHbWdwVVobIWlXAs9iSZl0ycAMmcp0MAsc6Njkd0bg5gLLHXw3AqMcNHmgMYRrBmY7+E4GLgS+ctBdaglNFFwJTAu8/wbcAdwAPJwgcyHwXAT+dUs04+AB4Fx7PtvR7x0Rdv/Rkqs4GA/cnW7rL9rLDyEHAoMcynbF4H928B1jGWcS7LbMMAwbPDLfWuB9B81w4KSYb38HsoH3F4A9Mc4LwuyY40reYZNyYJI9j3Do2GyngjA0OfhuTTdUdpU1leSxesdwIOdg+iUClwbOdPA1mpOTYIsZNQxjPBz8kx1FfnAY9ZoI/J3AxaEJ9TQw09HnX4FlCd9LHH0eBRwLHO+g25hwvEqC6vSOXD7XWH5oAo70MGR9BG4SMNrBN88GkwQbIs6BVcB0B9+Xdh7sBt520E4KvZ8GzAmdve8A2oDJDlkrYlYWFg2Oc9UhTH+lg25dDL7KVchK76jIV+/NydfBbbZKgnA+8C8H34fAIuBEB93K0PsAYJbtsXEg4JFAmHzXUUQ5L7TnPRky8FybMCM9VlZ9wrdBHvzbPMJz0hZV4+Brz26t7KoYUpkhdbBSeY6DYR9whVVkqoAJwNWWnMVBHXCzbfpZh/xhRlsCnGWr7WTHnn0X8FkAt9wqaeclhM0bgUeBsaGQ3QI8FihVZnq5sgBO98hn3vPY2jpjtp2cx4Jcn/0tl+9oLe8uDHy4g6HGskMf2Aa8DDxhnRztwTPdIxxj5ctlwAwrj4aTm5UJDsYm6WzbZ9MB/MxAjtFgE7qiFwknwDiPXOZ94HIHXZNl9FH7t2sLeCm9uapz5/HHZABOAIYWWaDPA18DUy0aPGrO9YkOPrAVeMaSrksinFuAxR615v8CFwRw7wD/Cela4XHJERclbnPw3m+RsNZB12wTLSqXSCXwvQjUZfdkulpr+2Wx40M/j5VzwAQXLgIabY/4GvjIwmNUgfwUj4uFFqOVTYzdZuhVFoaXxGTZYfjYivH9Y74PBCaGcHMi9vZnQ9l1GMYC8yPwEx1n248s6QQY4hhLS8RFxwjHBPrRztkw4IN1rN6zH0n3eFSZ/iZpsKQhkmqs3JbyqO/WSGpyyJ4bkD1Y0iBJZZ7146j2vx7Ub/+ZIGdOAl+LpBtC9DdJ2p7A86KVVbExNnjYJSh/jKTVCfSfW5XrYC163IcbONDVjQ0yCbZLquilsf/iUcq8pQhnRrWbPJ27SVIuQU6FpC8dMhZLesNqzEnwbGhBnGM18iRYK+lVSa+ZnqS6/7zA5Dno4JnLtxZeFjkUvV6Esa9yyO4oFMf7sA3wuNLrlHSJh6z+dhXX2yu9+TF6ruujG6Slkm62evxhOljZ0IpdXyXdxKySdFoRxp7mCHPT+ti5hXaBpJ8T7mcn9lDeaEkvSNrtYfRmW1HjE+TNKsKpByTVmWNjt7JUZ76bbDrV3woKFZbs5C2Z2gt8a+n8viKy3wl2vi3I7rKiyTb7c2LTn/hbUrVdGIyyJLIFWAv83xKx3sBQS7BGW8JWZklZu2W9a6xYst0hZ7LVB3z+bpH5pAVYb+f9711MqaM/3R3ZkD5qgiMbfh8AvLl/2IM4mWYAAAAASUVORK5CYII=',
				align: 'right',
				vAlign: 'top',
				offsetX: 100,
				offsetY: 100
			},
			advertisement: { //广告相关的配置
				time: 5, //广告默认播放时长以及多个广告时每个广告默认播放时间，单位：秒
				method: 'get', //广告监测地址默认请求方式，get/post
				videoForce: false, //频广告是否强制播放结束
				videoVolume: 0.8, //视频音量
				skipButtonShow: true, //是否显示跳过广告按钮
				linkButtonShow: true, //是否显示广告链接按钮，如果选择显示，只有在提供了广告链接地址时才会显示
				muteButtonShow: true, //是否显示跳过广告按钮
				closeButtonShow: true, //暂停时是否显示关闭广告按钮
				closeOtherButtonShow: true, //其它广告是否需要关闭广告按钮
				frontSkipButtonDelay: 0, //前置广告跳过广告按钮延时显示的时间，单位：秒
				insertSkipButtonDelay: 0, //插入广告跳过广告按钮延时显示的时间，单位：秒
				endSkipButtonDelay: 0, //后置广告跳过广告按钮延时显示的时间，单位：秒
				frontStretched: 2, //前置广告拉伸方式，0=原始大小，1=自动缩放，2=只有当广告的宽或高大于播放器宽高时才进行缩放，3=参考播放器宽高，4=宽度参考播放器宽、高度自动，5=高度参考播放器高、宽度自动
				insertStretched: 2, //插入广告拉伸方式，0=原始大小，1=自动缩放，2=只有当广告的宽或高大于播放器宽高时才进行缩放，3=参考播放器宽高，4=宽度参考播放器宽、高度自动，5=高度参考播放器高、宽度自动
				pauseStretched: 2, //暂停广告拉伸方式，0=原始大小，1=自动缩放，2=只有当广告的宽或高大于播放器宽高时才进行缩放，3=参考播放器宽高，4=宽度参考播放器宽、高度自动，5=高度参考播放器高、宽度自动
				endStretched: 2 //结束广告拉伸方式，0=原始大小，1=自动缩放，2=只有当广告的宽或高大于播放器宽高时才进行缩放，3=参考播放器宽高，4=宽度参考播放器宽、高度自动，5=高度参考播放器高、宽度自动
			},
			video: { //视频的默认比例
				defaultWidth: 4, //宽度
				defaultHeight: 3 //高度
			}
		}
	};
}
!(function() {
    var javascriptPath = '';
    ! function() {
        var scriptList = document.scripts,
            thisPath = scriptList[scriptList.length - 1].src;
        javascriptPath = thisPath.substring(0, thisPath.lastIndexOf('/') + 1);
    }();
    var ckplayer = function(obj) {
        /*
			javascript部分开发所用的注释说明：
			1：初始化-程序调用时即运行的代码部分
			2：定义样式-定义容器（div,p,canvas等）的样式表，即css
			3：监听动作-监听元素节点（单击-click，鼠标进入-mouseover，鼠标离开-mouseout，鼠标移动-mousemove等）事件
			4：监听事件-监听视频的状态（播放，暂停，全屏，音量调节等）事件
			5：共用函数-这类函数在外部也可以使用
			6：全局变量-定义成全局使用的变量
			7：其它相关注释
			全局变量说明：
			在本软件中所使用到的全局变量（变量（类型）包括Boolean，String，Int，Object（包含元素对象和变量对象），Array，Function等）
			下面列出重要的全局变量：
				V:Object：视频对象
				VA:Array：视频列表（包括视频地址，类型，清晰度说明）
				ID:String：视频ID
				CB:Object：控制栏各元素的集合对象
				PD:Object：内部视频容器对象
			---------------------------------------------------------------------------------------------
			程序开始
			下面为需要初始化配置的全局变量
			初始化配置
			config：全局变量/变量类型：Object/功能：定义一些基本配置
		*/
        this.config= {
            videoClick: true, //是否支持单击播放/暂停动作
            videoDbClick: true, //是否支持双击全屏/退出全屏动作
            errorTime: 100, //延迟判断失败的时间，单位：毫秒
            videoDrawImage: false //是否使用视频drawImage功能，注意，该功能在移动端表现不了
        };
        //全局变量/变量类型：Object/功能：播放器默认配置，在外部传递过来相应配置后，则进行相关替换
        this.varsConfig={
            container: '', //视频容器的ID
            variable: 'ckplayer', //播放函数(变量)名称
            volume: 0.8, //默认音量，范围0-1
            poster: '', //封面图片地址
            autoplay: false, //是否自动播放
            loop: false, //是否需要循环播放
            live: false, //是否是直播
            duration: 0, //指定总时间
            seek: 0, //默认需要跳转的秒数
            drag: '', //拖动时支持的前置参数
            front: '', //前一集按钮动作
            next: '', //下一集按钮动作
            loaded: '', //加载播放器后调用的函数
            flashplayer: false, //设置成true则强制使用flashplayer
            html5m3u8: false, //PC平台上是否使用h5播放器播放m3u8
            track: null, //字幕轨道
            cktrack: null, //ck字幕
            preview: null, //预览图片对象
            prompt: null, //提示点功能
            video: null, //视频地址
            config: '', //调用配置函数名称
            type: '', //视频格式
            crossorigin: '', //设置html5视频的crossOrigin属性
            crossdomain: '', //安全策略文件地址
            unescape: false, //默认flashplayer里需要解码
            mobileCkControls: false, //移动端h5显示控制栏
            playbackrate: 1, //默认倍速
            debug: false //是否开启调试模式
        };
        this.vars={};
        //全局变量/变量类型：Object/功能：语言配置
        this.language= {
            volume: '音量：',
            play: '点击播放',
            pause: '点击暂停',
            full: '点击全屏',
            escFull: '退出全屏',
            mute: '点击静音',
            escMute: '取消静音',
            front: '上一集',
            next: '下一集',
            definition: '点击选择清晰度',
            playbackRate: '点击选择速度',
            error: '加载出错'
        };
        //全局变量/变量类型：Array/功能：右键菜单：[菜单标题,类型(link:链接，default:灰色，function：调用函数，javascript:调用js函数),执行内容(包含链接地址，函数名称),[line(间隔线)]]
        this.contextMenu= [
            ['ckplayer', 'link', 'http://www.ckplayer.com'],
            ['version:X', 'default'],
            ['播放视频', 'function', 'videoPlay', 'line'],
            ['暂停视频', 'function', 'videoPause'],
            ['播放/暂停', 'function', 'playOrPause']
        ];
        //全局变量/变量类型：Array/功能：错误列表
        this.errorList= [
            ['000', 'Object does not exist'],
            ['001', 'Variables type is not a object'],
            ['002', 'Video object does not exist'],
            ['003', 'Video object format error'],
            ['004', 'Video object format error'],
            ['005', 'Video object format error'],
            ['006', '[error] does not exist '],
            ['007', 'Ajax error'],
            ['008', 'Ajax error'],
            ['009', 'Ajax object format error'],
            ['010', 'Ajax.status:[error]']
        ];
        //全局变量/变量类型：Array/功能：HTML5变速播放的值数组/如果不需要可以设置成null
        this.playbackRateArr= [
            [0.5, '0.5倍'],
            [1, '正常'],
            [1.25, '1.25倍'],
            [1.5, '1.5倍'],
            [2, '2倍速'],
            [4, '4倍速']
        ];
        //全局变量/变量类型：Array/功能：HTML5默认变速播放的值
        this.playbackRateDefault=1;
        //全局变量/变量类型：String/功能：定义logo
        this.logo='';
        //全局变量/变量类型：Boolean/功能：是否加载了播放器
        this.loaded= false;
        //全局变量/变量类型：计时器/功能：监听视频加载出错的状态
        this.timerError= null;
        //全局变量/变量类型：Boolean/功能：是否出错
        this.error= false;
        //全局变量/变量类型：Array/功能：出错地址的数组
        this.errorUrl= [];
        //全局变量/变量类型：计时器/功能：监听全屏与非全屏状态
        this.timerFull= null;
        //全局变量/变量类型：Boolean/功能：是否全屏状态
        this.full= false;
        //全局变量/变量类型：计时器/功能：监听当前的月/日 时=分=秒
        this.timerTime= null;
        //全局变量/变量类型：计时器/功能：监听视频加载
        this.timerBuffer= null;
        //全局变量/变量类型：Boolean/功能：设置进度按钮及进度条是否跟着时间变化，该属性主要用来在按下进度按钮时暂停进度按钮移动和进度条的长度变化
        this.isTimeButtonMove= true;
        //全局变量/变量类型：Boolean/功能：进度栏是否有效，如果是直播，则不需要监听时间让进度按钮和进度条变化
        this.isTimeButtonDown= false;
        //全局变量/变量类型：Boolean/功能：用来模拟双击功能的判断
        this.isClick= false;
        //全局变量/变量类型：计时器/功能：用来模拟双击功能的计时器
        this.timerClick= null;
        //全局变量/变量类型：计时器/功能：旋转loading
        this.timerLoading= null;
        //全局变量/变量类型：计时器/功能：监听鼠标在视频上移动显示控制栏
        this.timerCBar= null;
        //全局变量/变量类型：Int/功能：播放视频时如果该变量的值大于0，则进行跳转后设置该值为0
        this.needSeek= 0;
        //全局变量/变量类型：Int/功能：当前音量
        this.volume= 0;
        //全局变量/变量类型：Int/功能：静音时保存临时音量
        this.volumeTemp= 0;
        //全局变量/变量类型：Number/功能：当前播放时间
        this.time= 0;
        //全局变量/变量类型：Boolean/功能：定义首次调用
        this.isFirst= true;
        //全局变量/变量类型：Boolean/功能：是否使用HTML5-VIDEO播放
        this.html5Video= true;
        //全局变量/变量类型：Object/功能：记录视频容器节点的x;y
        this.pdCoor= {
            x: 0,
            y: 0
        };
        //全局变量/变量类型：String/功能：判断当前使用的播放器类型，html5video或flashplayer
        this.playerType= '';
        //全局变量/变量类型：Int/功能：加载进度条的长度
        this.loadTime= 0;
        //全局变量/body对象
        this.body= document.body || document.documentElement;
        //全局变量/V/播放器
        this.V= null;
        //全局变量/保存外部js监听事件数组
        this.listenerJsArr= [];
        //全局变量/保存控制栏显示元素的总宽度
        this.buttonLen= 0;
        //全局变量/保存控制栏显示元素的数组
        this.buttonArr= [];
        //全局变量/保存按钮元素的宽
        this.buttonWidth= {};
        //全局变量/保存播放器上新增元件的数组
        this.elementArr= [];
        //全局变量/字幕内容
        this.track= [];
        //全局变量/字幕索引
        this.trackIndex= 0;
        //全局变量/当前显示的字幕内容
        this.nowTrackShow= {
            sn:''
        };
        //全局变量/保存字幕元件数组
        this.trackElement= [];
        //全局变量/将视频转换为图片
        this.timerVCanvas= null;
        //全局变量/animate
        this.animateArray= [];
        //全局变量/保存animate的元件
        this.animateElementArray= [];
        //全局变量/保存需要在暂停时停止缓动的数组
        this.animatePauseArray= [];
        //全局变量/预览图片加载状态/0=没有加载，1=正在加载，2=加载完成
        this.previewStart= 0;
        //全局变量/预览图片容器
        this.previewDiv= null;
        //全局变量/预览框
        this.previewTop= null;
        //全局变量/预览框的宽
        this.previewWidth= 120;
        //全局变量/预览图片容器缓动函数
        this.previewTween= null;
        //全局变量/是否是m3u8格式，是的话则可以加载hls.js
        this.isM3u8= false;
        //全局变量/保存提示点数组
        this.promptArr= [];
        //全局变量/显示提示点文件的容器
        this.promptElement= null;
        //配置文件函数
        this.ckplayerConfig= {};
        //控制栏是否显示
        this.showFace= true;
        //是否监听过h5的错误
        this.errorAdd=false;
        //是否发送了错误
        this.errorSend=false;
        //控制栏是否隐藏
        this.controlBarIsShow=true;
        //字体
        this.fontFamily= '"Microsoft YaHei"; YaHei; "\5FAE\8F6F\96C5\9ED1"; SimHei; "\9ED1\4F53";Arial';
        if(obj) {
            this.embed(obj);
        }
    };
    ckplayer.prototype = {
        /*
			主要函数部分开始
			主接口函数：
			调用播放器需初始化该函数
		*/
        embed: function(c) {
            //c:Object：是调用接口传递的属性对象
            if(window.location.href.substr(0,7)=='file://'){
                alert('Please use the HTTP protocol to open the page');
                return;
            }
            if(c == undefined || !c) {
                this.eject(this.errorList[0]);
                return;
            }
            if(typeof(c) != 'object') {
                this.eject(this.errorList[1]);
            }
            this.vars = this.standardization(this.varsConfig, c);
            if(!this.vars['mobileCkControls'] && this.isMobile()) {
                this.vars['flashplayer']=false;
                this.showFace = false;
            }
            var videoString=this.vars['video'];
            if(!videoString){
                this.eject(this.errorList[2]);
                return;
            }
            if(typeof(videoString) == 'string') {
                if(videoString.substr(0,3)=='CK:' || videoString.substr(0,3)=='CE:' || videoString.substr(8,3)=='CK:' || videoString.substr(8,3)=='CE:'){
                    this.vars['flashplayer']=true;
                }
            }
            if(this.vars['config']) {
                this.ckplayerConfig = eval(this.vars['config'] + '()');
            } else {
                this.ckplayerConfig = ckplayerConfig();
            }
            if((!this.supportVideo() && this.vars['flashplayer'] != '') || (this.vars['flashplayer'] && this.uploadFlash()) || !this.isMsie()) {
                this.html5Video = false;
                this.getVideo();
            } else if(videoString) {
                //判断视频数据类型
                this.analysedVideoUrl(videoString);
                return this;
            } else {
                this.eject(this.errorList[2]);
            }
        },
        /*
			内部函数
			根据外部传递过来的video开始分析视频地址
		*/
        analysedVideoUrl: function(video) {
            var i = 0,
                y = 0;
            var thisTemp = this;
            //定义全局变量VA:Array：视频列表（包括视频地址，类型，清晰度说明）
            this.VA = [];
            if(typeof(video) == 'string') { //如果是字符形式的则判断后缀进行填充
                if(video.substr(0, 8) != 'website:') {
                    this.VA = [
                        [video, '', '', 0]
                    ];
                    var fileExt = this.getFileExt(video);
                    switch(fileExt) {
                        case '.mp4':
                            this.VA[0][1] = 'video/mp4';
                            break;
                        case '.ogg':
                            this.VA[0][1] = 'video/ogg';
                            break;
                        case '.webm':
                            this.VA[0][1] = 'video/webm';
                            break;
                        default:
                            break;
                    }
                    this.getVideo();
                } else {
                    if(this.html5Video) {
                        var ajaxObj = {
                            url: video.substr(8),
                            success: function(data) {
                                if(data) {
                                    thisTemp.analysedUrl(data);
                                } else {
                                    thisTemp.eject(thisTemp.errorList[5]);
                                    this.VA = video;
                                    thisTemp.getVideo();
                                }
                            }
                        };
                        this.ajax(ajaxObj);
                    } else {
                        this.VA = video;
                        this.getVideo();
                    }

                }
            } else if(typeof(video) == 'object') { //对象或数组
                if(!this.isUndefined(typeof(video.length))) { //说明是数组
                    if(!this.isUndefined(typeof(video[0].length))) { //说明是数组形式的数组
                        this.VA = video;
                    }
                    this.getVideo();
                } else {
                    /*
						如果video格式是对象形式，则分二种
						如果video对象里包含type，则直接播放
					*/
                    if(!this.isUndefined(video['type'])) {
                        this.VA.push([video['file'], video['type'], '', 0]);
                        this.getVideo();
                    } else {
                        this.eject(this.errorList[5]);
                    }
                }
            } else {
                this.eject(this.errorList[4]);
            }
        },
        /*
			对请求到的视频地址进行重新分析
		*/
        analysedUrl: function(data) {
            this.vars = this.standardization(this.vars, data);
            if(!this.isUndefined(data['video'])) {
                this.vars['video'] = data['video'];
            }
            this.analysedVideoUrl(this.vars['video']);
        },
        /*
			内部函数
			检查浏览器支持的视频格式，如果是则将支持的视频格式重新分组给播放列表
		*/
        getHtml5Video: function() {
            var va = this.VA;
            var nva = [];
            var mobile = false;
            var video = document.createElement('video');
            var codecs = function(type) {
                var cod = '';
                switch(type) {
                    case 'video/mp4':
                        cod = 'avc1.4D401E, mp4a.40.2';
                        break;
                    case 'video/ogg':
                        cod = 'theora, vorbis';
                        break;
                    case 'video/webm':
                        cod = 'vp8.0, vorbis';
                        break;
                    default:
                        break;
                }
                return cod;
            };
            var supportType = function(vidType, codType) {
                if(!video.canPlayType) {
                    this.html5Video = false;
                    return;
                }
                var isSupp = video.canPlayType(vidType + ';codecs="' + codType + '"');
                if(isSupp == '') {
                    return false
                }
                return true;
            };
            if(this.vars['flashplayer'] || !this.isMsie()) {
                this.html5Video = false;
                return;
            }
            if(this.isMobile()) {
                mobile = true;
            }
            for(var i = 0; i < va.length; i++) {
                var v = va[i];
                if(v) {
                    if(v[1] != '' && !mobile && supportType(v[1], codecs(v[1])) && v[0].substr(0, 4) != 'rtmp') {
                        nva.push(v);
                    }
                    if(this.getFileExt(v[0]) == '.m3u8' && this.vars['html5m3u8']) {
                        this.isM3u8 = true;
                        nva.push(v);
                    }
                }
            }
            if(nva.length > 0) {
                this.VA = nva;
            } else {
                if(!mobile) {
                    this.html5Video = false;
                }
            }
        },
        /*
			内部函数
			根据视频地址开始构建播放器
		*/
        getVideo: function() {
            //如果存在字幕则加载
            if(this.V) { //如果播放器已存在，则认为是从newVideo函数发送过来的请求
                this.changeVideo();
                return;
            }
            if(this.vars['cktrack']) {
                this.loadTrack();
            }
            if(this.supportVideo() && !this.vars['flashplayer']) {
                this.getHtml5Video(); //判断浏览器支持的视频格式
            }
            var thisTemp = this;
            var v = this.vars;
            var src = '',
                source = '',
                poster = '',
                loop = '',
                autoplay = '',
                track = '';
            var video = v['video'];
            var i = 0;
            this.CD = this.getByElement(v['container']);
            volume = v['volume'];
            if(!this.CD) {
                this.eject(this.errorList[6], v['container']);
                return false;
            }
            //开始构建播放容器
            var playerID = 'ckplayer' + this.randomString();
            var playerDiv = document.createElement('div');
            playerDiv.className = playerID;
            this.V = undefined;
            this.CD.innerHTML = '';
            this.CD.appendChild(playerDiv);
            this.PD = this.getByElement(playerID); //PD:定义播放器容器对象全局变量
            this.css(this.CD, {
                backgroundColor: '#000000',
                overflow: 'hidden',
                position: 'relative'
            });
            this.css(this.PD, {
                backgroundColor: '#000000',
                width: '100%',
                height: '100%',
                fontFamily: this.fontFamily
            });
            if(this.html5Video) { //如果支持HTML5-VIDEO则默认使用HTML5-VIDEO播放器
                //禁止播放器容器上鼠标选择文本
                this.PD.onselectstart = this.PD.ondrag = function() {
                    return false;
                };
                //播放容器构建完成并且设置好样式
                //构建播放器
                if(this.VA.length == 1) {
                    src = ' src="' + decodeURIComponent(this.VA[0][0]) + '"';
                } else {
                    var videoArr = this.VA.slice(0);
                    videoArr = this.arrSort(videoArr);
                    for(i = 0; i < videoArr.length; i++) {
                        var type = '';
                        var va = videoArr[i];
                        if(va[1]) {
                            type = ' type="' + va[1] + '"';
                            if(type == ' type="video/m3u8"' || type==' type="m3u8"') {
                                type = '';
                            }
                        }
                        source += '<source src="' + decodeURIComponent(va[0]) + '"' + type + '>';
                    }
                }
                //分析视频地址结束
                if(v['autoplay']) {
                    autoplay = ' autoplay="autoplay"';
                }
                if(v['poster']) {
                    poster = ' poster="' + v['poster'] + '"';
                }
                if(v['loop']) {
                    loop = ' loop="loop"';
                }
                if(v['seek'] > 0) {
                    this.needSeek = v['seek'];
                }
                if(v['track'] != null && v['cktrack'] == null) {
                    var trackArr = v['track'];
                    var trackDefault = '';
                    var defaultHave = false;
                    for(i = 0; i < trackArr.length; i++) {
                        var trackObj = trackArr[i];
                        if(trackObj['default'] && !defaultHave) {
                            trackDefault = ' default';
                            defaultHave = true;
                        } else {
                            trackDefault = '';
                        }
                        track += '<track kind="' + trackObj['kind'] + '" src="' + trackObj['src'] + '" srclang="' + trackObj['srclang'] + '" label="' + trackObj['label'] + '"' + trackDefault + '>';
                    }
                }
                var autoLoad = this.ckplayerConfig['config']['autoLoad'];
                var preload = '';
                if(!autoLoad) {
                    preload = ' preload="meta"';
                }
                var vid = this.randomString();
                var controls = '';
                if(!this.showFace) {
                    controls = ' controls="controls"';
                }
                var html = '';
                if(!this.isM3u8) {
                    html = '<video id="' + vid + '"' + src + ' width="100%" height="100%"' + autoplay + poster + loop + preload + controls + ' x5-playsinline="" playsinline="" webkit-playsinline="true">' + source + track + '</video>';
                } else {
                    html = '<video id="' + vid + '" width="100%" height="100%"' + poster + loop + preload + controls + ' x5-playsinline="" playsinline="" webkit-playsinline="true">' + track + '</video>';
                }
                this.PD.innerHTML = html;
                this.V = this.getByElement('#' + vid); //V：定义播放器对象全局变量
                if(this.vars['crossorigin']) {
                    this.V.crossOrigin = this.vars['crossorigin'];
                }
                try {
                    this.V.volume = volume; //定义音量
                    if(this.playbackRateArr && this.vars['playbackrate'] > -1) {
                        if(this.vars['playbackrate'] < this.playbackRateArr.length) {
                            this.playbackRateDefault = this.vars['playbackrate'];
                        }
                        this.V.playbackRate = this.playbackRateArr[this.playbackRateDefault][0]; //定义倍速
                    }
                } catch(error) {}
                this.css(this.V, {
                    width: '100%',
                    height: '100%'
                });
                if(this.isM3u8) {
                    var loadJsHandler = function() {
                        thisTemp.embedHls(thisTemp.VA[0][0], v['autoplay']);
                    };
                    this.loadJs(javascriptPath + 'hls/hls.min.js', loadJsHandler);
                }
                this.css(this.V, 'backgroundColor', '#000000');
                //创建一个画布容器
                if(this.config['videoDrawImage']) {
                    var canvasID = 'vcanvas' + this.randomString();
                    var canvasDiv = document.createElement('div');
                    canvasDiv.className = canvasID;
                    this.PD.appendChild(canvasDiv);
                    this.MD = this.getByElement(canvasID); //定义画布存储容器
                    this.css(this.MD, {
                        backgroundColor: '#000000',
                        width: '100%',
                        height: '100%',
                        position: 'absolute',
                        display: 'none',
                        cursor: 'pointer',
                        left: '0px',
                        top: '0px',
                        zIndex: '10'
                    });
                    var cvid = 'ccanvas' + this.randomString();
                    this.MD.innerHTML = this.newCanvas(cvid, this.PD.offsetWidth, this.PD.offsetHeight);
                    this.MDC = this.getByElement(cvid + '-canvas');
                    this.MDCX = this.MDC.getContext('2d');
                }
                this.playerType = 'html5video';
                //播放器构建完成并且设置好样式
                //建立播放器的监听函数，包含操作监听及事件监听
                this.addVEvent();
                //根据清晰度的值构建清晰度切换按钮
                if(this.showFace) {
                    this.definition();
                    if(!this.vars['live'] && this.playbackRateArr && this.vars['playbackrate'] > -1) {
                        this.playbackRate();
                    }
                    if(v['autoplay']){
                        this.loadingStart(true);
                    }
                }
                this.playerLoad();
            } else { //如果不支持HTML5-VIDEO则调用flashplayer
                this.embedSWF();
            }
        },
        /*
			内部函数
			发送播放器加载成功的消息
		*/
        playerLoad: function() {
            var thisTemp = this;
            if(this.isFirst) {
                this.isFirst = false;
                window.setTimeout(function() {
                    thisTemp.loadedHandler();
                }, 1);
            }
        },
        /*
			内部函数
			建立播放器的监听函数，包含操作监听及事件监听
		*/
        addVEvent: function() {
            var thisTemp = this;
            //监听视频单击事件
            var eventVideoClick = function(event) {
                thisTemp.videoClick();
            };
            this.addListenerInside('click', eventVideoClick);
            this.addListenerInside('click', eventVideoClick, this.MDC);
            //延迟计算加载失败事件
            this.timerErrorFun();
            //监听视频加载到元数据事件
            var eventJudgeIsLive = function(event) {
                thisTemp.sendJS('loadedmetadata');
                thisTemp.sendJS('duration', thisTemp.V.duration);
                thisTemp.judgeIsLive();
            };
            this.addListenerInside('loadedmetadata', eventJudgeIsLive);
            //监听视频播放事件
            var eventPlaying = function(event) {
                thisTemp.playingHandler();
                thisTemp.sendJS('play');
                thisTemp.sendJS('paused', false);
            };
            this.addListenerInside('playing', eventPlaying);
            //监听视频暂停事件
            var eventPause = function(event) {
                thisTemp.pauseHandler();
                thisTemp.sendJS('pause');
                thisTemp.sendJS('paused', true);
            };
            this.addListenerInside('pause', eventPause);
            //监听视频播放时间事件
            var eventTimeupdate = function(event) {
                if(thisTemp.timerLoading != null) {
                    thisTemp.loadingStart(false);
                }
                if(thisTemp.time) {
                    thisTemp.sendJS('time', thisTemp.time);
                }
            };
            this.addListenerInside('timeupdate', eventTimeupdate);
            //监听视频缓冲事件
            var eventWaiting = function(event) {
                thisTemp.loadingStart(true);
            };
            this.addListenerInside('waiting', eventWaiting);
            //监听视频seek开始事件
            var eventSeeking = function(event) {
                thisTemp.sendJS('seek', 'start');
            };
            this.addListenerInside('seeking', eventSeeking);
            //监听视频seek结束事件
            var eventSeeked = function(event) {
                thisTemp.seekedHandler();
                thisTemp.sendJS('seek', 'ended');
            };
            this.addListenerInside('seeked', eventSeeked);
            //监听视频播放结束事件
            var eventEnded = function(event) {
                thisTemp.endedHandler();
                thisTemp.sendJS('ended');
            };
            this.addListenerInside('ended', eventEnded);
            //监听视频音量
            var eventVolumeChange = function(event) {
                try {
                    thisTemp.volumechangeHandler();
                    thisTemp.sendJS('volume', thisTemp.volume || thisTemp.V.volume);
                } catch(event) {}
            };
            this.addListenerInside('volumechange', eventVolumeChange);
            //监听全屏事件
            var eventFullChange = function(event) {
                var fullState = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
                thisTemp.sendJS('full', fullState);
            };
            this.addListenerInside('fullscreenchange', eventFullChange);
            this.addListenerInside('webkitfullscreenchange', eventFullChange);
            this.addListenerInside('mozfullscreenchange', eventFullChange);
            //建立界面
            if(this.showFace) {
                this.interFace();
            }
        },
        /*
			内部函数
			重置界面元素
		*/
        resetPlayer: function() {
            this.timeTextHandler();
            if(this.showFace) {
                this.timeProgress(0, 1); //改变时间进度条宽
                this.changeLoad(0);
                this.initPlayPause(); //判断显示播放或暂停按钮
                this.definition(); //构建清晰度按钮
                this.showFrontNext(); //构建上一集下一集按钮
                this.deletePrompt(); //删除提示点
                this.deletePreview(); //删除预览图
                this.trackHide(); //重置字幕
                this.resetTrack();
                this.trackElement = [];
                this.track = [];
            }
        },
        /*
			内部函数
			构建界面元素
		 */
        interFace: function() {
            this.showFace = true;
            var thisTemp = this;
            var html = ''; //控制栏内容
            var i = 0;
            var bWidth = 38, //按钮的宽
                bHeight = 38; //按钮的高
            var bBgColor = '#FFFFFF', //按钮元素默认颜色
                bOverColor = '#0782F5'; //按钮元素鼠标经过时的颜色
            var timeInto = this.formatTime(0) + ' / ' + this.formatTime(this.vars['duration']); //时间显示框默认显示内容
            var randomS = this.randomString(10); //获取一个随机字符串
            /*
				以下定义界面各元素的ID，统一以ID结束
			*/
            var controlBarBgID = 'controlbgbar' + randomS, //控制栏背景
                controlBarID = 'controlbar' + randomS, //控制栏容器
                timeProgressBgID = 'timeprogressbg' + randomS, //播放进度条背景
                loadProgressID = 'loadprogress' + randomS, //加载进度条
                timeProgressID = 'timeprogress' + randomS, //播放进度条
                timeBOBGID = 'timebobg' + randomS, //播放进度按钮容器，该元素为一个透明覆盖在播放进度条上
                timeBOID = 'timebo' + randomS, //播放进度可拖动按钮外框
                timeBWID = 'timebw' + randomS, //播放进度可拖动按钮内框
                timeTextID = 'timetext' + randomS, //时间文本框
                playID = 'play' + randomS, //播放按钮
                pauseID = 'pause' + randomS, //暂停按钮
                frontID = 'front' + randomS, //前一集按钮
                nextID = 'next' + randomS, //下一集按钮
                fullID = 'full' + randomS, //全屏按钮
                escFullID = 'escfull' + randomS, //退出全屏按钮
                muteID = 'mute' + randomS, //静音按钮
                escMuteID = 'escmute' + randomS, //取消静音按钮
                volumeID = 'volume' + randomS, //音量调节框容器
                volumeDbgID = 'volumedbg' + randomS, //音量调节框容器背景
                volumeBgID = 'volumebg' + randomS, //音量调节框背景层
                volumeUpID = 'volumeup' + randomS, //音量调节框可变宽度层
                volumeBOID = 'volumebo' + randomS, //音量调节按钮外框
                volumeBWID = 'volumebw' + randomS, //音量调节按钮内框
                definitionID = 'definition' + randomS, //清晰度容器
                definitionPID = 'definitionp' + randomS, //清晰度列表容器
                playbackRateID = 'playbackrate' + randomS, //清晰度容器
                playbackRatePID = 'playbackratep' + randomS, //清晰度列表容器
                promptBgID = 'promptbg' + randomS, //提示框背景
                promptID = 'prompt' + randomS, //提示框
                dlineID = 'dline' + randomS, //分隔线共用前缀
                menuID = 'menu' + randomS, //右键容器
                pauseCenterID = 'pausecenter' + randomS, //中间暂停按钮
                loadingID = 'loading' + randomS, //缓冲
                errorTextID = 'errortext' + randomS, //错误文本框
                logoID = 'logo' + randomS; //logo
            //构建一些PD（播放器容器）里使用的元素
            var controlBarBg = document.createElement('div'),
                controlBar = document.createElement('div'),
                timeProgressBg = document.createElement('div'),
                timeBoBg = document.createElement('div'),
                pauseCenter = document.createElement('div'),
                errorText = document.createElement('div'),
                promptBg = document.createElement('div'),
                prompt = document.createElement('div'),
                menuDiv = document.createElement('div'),
                definitionP = document.createElement('div'),
                playbackrateP = document.createElement('div'),
                loading = document.createElement('div'),
                logo = document.createElement('div');

            controlBarBg.className = controlBarBgID;
            controlBar.className = controlBarID;
            timeProgressBg.className = timeProgressBgID;
            timeBoBg.className = timeBOBGID;
            promptBg.className = promptBgID;
            prompt.className = promptID;
            menuDiv.className = menuID;
            definitionP.className = definitionPID;
            playbackrateP.className = playbackRatePID;
            pauseCenter.className = pauseCenterID;
            loading.className = loadingID;
            logo.className = logoID;
            errorText.className = errorTextID;

            this.PD.appendChild(controlBarBg);
            this.PD.appendChild(controlBar);
            this.PD.appendChild(timeProgressBg);
            this.PD.appendChild(timeBoBg);
            this.PD.appendChild(promptBg);
            this.PD.appendChild(prompt);
            this.PD.appendChild(definitionP);
            this.PD.appendChild(playbackrateP);
            this.PD.appendChild(pauseCenter);

            this.PD.appendChild(loading);
            this.PD.appendChild(errorText);
            this.PD.appendChild(logo);
            this.body.appendChild(menuDiv);
            //构建一些PD（播放器容器）里使用的元素结束

            if(this.vars['live']) { //如果是直播，时间显示文本框里显示当前系统时间
                timeInto = this.getNowDate();
            }
            //构建控制栏的内容
            html += '<div class="' + playID + '" data-title="' + thisTemp.language['play'] + '">' + this.newCanvas(playID, bWidth, bHeight) + '</div>'; //播放按钮
            html += '<div class="' + pauseID + '" data-title="' + thisTemp.language['pause'] + '">' + this.newCanvas(pauseID, bWidth, bHeight) + '</div>'; //暂停按钮
            html += '<div class="' + dlineID + '-la"></div>'; //分隔线
            html += '<div class="' + frontID + '" data-title="' + thisTemp.language['front'] + '">' + this.newCanvas(frontID, bWidth, bHeight) + '</div>'; //前一集按钮
            html += '<div class="' + dlineID + '-lb"></div>'; //分隔线
            html += '<div class="' + nextID + '" data-title="' + thisTemp.language['next'] + '">' + this.newCanvas(nextID, bWidth, bHeight) + '</div>'; //下一集按钮
            html += '<div class="' + dlineID + '-lc"></div>'; //分隔线

            html += '<div class="' + timeTextID + '">' + timeInto + '</div>'; //时间文本
            html += '<div class="' + fullID + '" data-title="' + thisTemp.language['full'] + '">' + this.newCanvas(fullID, bWidth, bHeight) + '</div>'; //全屏按钮
            html += '<div class="' + escFullID + '" data-title="' + thisTemp.language['escFull'] + '">' + this.newCanvas(escFullID, bWidth, bHeight) + '</div>'; //退出全屏按钮
            html += '<div class="' + dlineID + '-ra"></div>'; //分隔线
            html += '<div class="' + definitionID + '" data-title="' + thisTemp.language['definition'] + '"></div>'; //清晰度容器
            html += '<div class="' + dlineID + '-rb"></div>'; //分隔线
            html += '<div class="' + playbackRateID + '" data-title="' + thisTemp.language['playbackRate'] + '"></div>'; //倍速
            html += '<div class="' + dlineID + '-rc"></div>'; //分隔线
            html += '<div class="' + volumeID + '"><div class="' + volumeDbgID + '"><div class="' + volumeBgID + '"><div class="' + volumeUpID + '"></div></div><div class="' + volumeBOID + '"><div class="' + volumeBWID + '"></div></div></div></div>'; //音量调节框,音量调节按钮
            html += '<div class="' + muteID + '" data-title="' + thisTemp.language['mute'] + '">' + this.newCanvas(muteID, bWidth, bHeight) + '</div>'; //静音按钮
            html += '<div class="' + escMuteID + '" data-title="' + thisTemp.language['escMute'] + '">' + this.newCanvas(escMuteID, bWidth, bHeight) + '</div>'; //退出静音按钮
            html += '<div class="' + dlineID + '-rd"></div>'; //分隔线
            this.getByElement(controlBarID).innerHTML = html;
            //构建控制栏内容结束
            //构建进度条内容
            this.getByElement(timeProgressBgID).innerHTML = '<div class="' + loadProgressID + '"></div><div class="' + timeProgressID + '"></div>';
            this.getByElement(timeBOBGID).innerHTML = '<div class="' + timeBOID + '"><div class="' + timeBWID + '"></div></div>';
            //构建进度条内容结束
            this.getByElement(pauseCenterID).innerHTML = this.newCanvas(pauseCenterID, 80, 80); //构建中间暂停按钮
            this.getByElement(loadingID).innerHTML = this.newCanvas(loadingID, 60, 60); //构建中间缓冲时显示的图标
            this.getByElement(errorTextID).innerHTML = this.language['error']; //构建错误时显示的文本框
            if(this.ckplayerConfig['style']['logo']) {
                if(this.ckplayerConfig['style']['logo']['file']) {
                    var logoFile = this.ckplayerConfig['style']['logo']['file'];
                    if(logoFile.substr(0, 15) == 'data:image/png;' || logoFile.substr(0, 15) == 'data:image/jpg;' || logoFile.substr(0, 15) == 'data:image/jpeg;') {
                        this.getByElement(logoID).innerHTML = '<img src="' + logoFile + '" border="0">'; //构建logo
                    }
                }
            } else {
                this.getByElement(logoID).innerHTML = this.vars['logo'] || this.logo || ''; //构建logo
            }
            //CB:Object：全局变量，将一些全局需要用到的元素统一放在CB对象里
            var pd = this.PD;
            this.CB = {
                controlBarBg: this.getByElement(controlBarBgID, pd),
                controlBar: this.getByElement(controlBarID, pd),
                promptBg: this.getByElement(promptBgID, pd),
                prompt: this.getByElement(promptID, pd),
                timeProgressBg: this.getByElement(timeProgressBgID, pd),
                loadProgress: this.getByElement(loadProgressID, pd),
                timeProgress: this.getByElement(timeProgressID, pd),
                timeBoBg: this.getByElement(timeBOBGID, pd),
                timeButton: this.getByElement(timeBOID, pd),
                timeText: this.getByElement(timeTextID, pd),
                play: this.getByElement(playID, pd),
                front: this.getByElement(frontID, pd),
                next: this.getByElement(nextID, pd),
                pause: this.getByElement(pauseID, pd),
                definition: this.getByElement(definitionID, pd),
                definitionP: this.getByElement(definitionPID, pd),
                definitionLine: this.getByElement(dlineID + '-rb', pd),
                playbackrate: this.getByElement(playbackRateID, pd),
                playbackrateP: this.getByElement(playbackRatePID, pd),
                playbackrateLine: this.getByElement(dlineID + '-rc', pd),
                full: this.getByElement(fullID, pd),
                escFull: this.getByElement(escFullID, pd),
                mute: this.getByElement(muteID, pd),
                escMute: this.getByElement(escMuteID, pd),
                volume: this.getByElement(volumeID, pd),
                volumeBg: this.getByElement(volumeBgID, pd),
                volumeUp: this.getByElement(volumeUpID, pd),
                volumeBO: this.getByElement(volumeBOID, pd),
                pauseCenter: this.getByElement(pauseCenterID, pd),
                menu: this.getByElement(menuID),
                loading: this.getByElement(loadingID, pd),
                loadingCanvas: this.getByElement(loadingID + '-canvas', pd),
                errorText: this.getByElement(errorTextID, pd),
                logo: this.getByElement(logoID, pd),
                playLine: this.getByElement(dlineID + '-la', pd),
                frontLine: this.getByElement(dlineID + '-lb', pd),
                nextLine: this.getByElement(dlineID + '-lc', pd),
                fullLine: this.getByElement(dlineID + '-ra'),
                definitionLine: this.getByElement(dlineID + '-rb', pd),
                muteLine: this.getByElement(dlineID + '-rd', pd)
            };
            this.buttonWidth = {
                play: bWidth,
                full: bWidth,
                front: bWidth,
                next: bWidth,
                mute: bWidth
            };
            //定义界面元素的样式
            //控制栏背景
            this.css(controlBarBgID, {
                width: '100%',
                height: bHeight + 'px',
                backgroundColor: '#000000',
                position: 'absolute',
                bottom: '0px',
                filter: 'alpha(opacity:0.8)',
                opacity: '0.8',
                zIndex: '90'
            });
            //控制栏容器
            this.css(controlBarID, {
                width: '100%',
                height: bHeight + 'px',
                position: 'absolute',
                bottom: '0px',
                zIndex: '90'
            });
            //中间暂停按钮
            this.css(pauseCenterID, {
                width: '80px',
                height: '80px',
                borderRadius: '50%',
                position: 'absolute',
                display: 'none',
                cursor: 'pointer',
                zIndex: '100'
            });
            //loading
            this.css(loadingID, {
                width: '60px',
                height: '60px',
                position: 'absolute',
                display: 'none',
                zIndex: '100'
            });
            //出错文本框
            this.css(errorTextID, {
                width: '120px',
                height: '30px',
                lineHeight: '30px',
                color: '#FFFFFF',
                fontSize: '14px',
                textAlign: 'center',
                position: 'absolute',
                display: 'none',
                zIndex: '101',
                cursor: 'default',
                zIndex: '100'
            });
            //定义logo文字的样式
            this.css(logoID, {
                height: '30px',
                lineHeight: '30px',
                color: '#FFFFFF',
                fontFamily: 'Arial',
                fontSize: '28px',
                textAlign: 'center',
                position: 'absolute',
                float: 'left',
                left: '-1000px',
                top: '20px',
                zIndex: '100',
                filter: 'alpha(opacity:0.8)',
                opacity: '0.8',
                cursor: 'default'
            });

            this.css(this.CB['loadingCanvas'], {
                transform: 'rotate(0deg)',
                msTransform: 'rotate(0deg)',
                mozTransform: 'rotate(0deg)',
                webkitTransform: 'rotate(0deg)',
                oTransform: 'rotate(0deg)'
            });
            //定义提示语的样式
            this.css([promptBgID, promptID], {
                height: '30px',
                lineHeight: '30px',
                color: '#FFFFFF',
                fontSize: '14px',
                textAlign: 'center',
                position: 'absolute',
                borderRadius: '5px',
                paddingLeft: '5px',
                paddingRight: '5px',
                bottom: '0px',
                display: 'none',
                zIndex: '95'
            });
            this.css(promptBgID, {
                backgroundColor: '#000000',
                filter: 'alpha(opacity:0.5)',
                opacity: '0.5'
            });
            //时间进度条背景容器
            this.css(timeProgressBgID, {
                width: '100%',
                height: '6px',
                backgroundColor: '#3F3F3F',
                overflow: 'hidden',
                position: 'absolute',
                bottom: '38px',
                zIndex: '88'
            });
            //加载进度和时间进度
            this.css([loadProgressID, timeProgressID], {
                width: '1px',
                height: '6px',
                position: 'absolute',
                bottom: '38px',
                top: '0px',
                zIndex: '91'
            });
            this.css(loadProgressID, 'backgroundColor', '#6F6F6F');
            this.css(timeProgressID, 'backgroundColor', bOverColor);
            //时间进度按钮
            this.css(timeBOBGID, {
                width: '100%',
                height: '14px',
                overflow: 'hidden',
                position: 'absolute',
                bottom: '34px',
                cursor: 'pointer',
                zIndex: '92'
            });
            this.css(timeBOID, {
                width: '14px',
                height: '14px',
                overflow: 'hidden',
                borderRadius: '50%',
                backgroundColor: bBgColor,
                cursor: 'pointer',
                position: 'absolute',
                top: '0px',
                zIndex: '20'
            });
            this.css(timeBWID, {
                width: '8px',
                height: '8px',
                overflow: 'hidden',
                borderRadius: '50%',
                position: 'absolute',
                backgroundColor: bOverColor,
                left: '3px',
                top: '3px'
            });
            this.css(timeTextID, {
                lineHeight: bHeight + 'px',
                color: '#FFFFFF',
                fontFamily: 'arial',
                fontSize: '16px',
                paddingLeft: '10px',
                float: 'left',
                overflow: 'hidden',
                cursor: 'default'
            });
            //分隔线
            this.css([dlineID + '-la', dlineID + '-lb', dlineID + '-lc', dlineID + '-ra', dlineID + '-rb', dlineID + '-rc', dlineID + '-rd'], {
                width: '0px',
                height: bHeight + 'px',
                overflow: 'hidden',
                borderLeft: '1px solid #303030',
                borderRight: '1px solid #151515',
                filter: 'alpha(opacity:0.9)',
                opacity: '0.9'
            });
            this.css([dlineID + '-la', dlineID + '-lb', dlineID + '-lc'], 'float', 'left');
            this.css([dlineID + '-ra', dlineID + '-rb', dlineID + '-rc', dlineID + '-rd'], 'float', 'right');
            this.css([dlineID + '-lb', dlineID + '-lc', dlineID + '-rb', dlineID + '-rc'], 'display', 'none');
            //播放/暂停/上一集/下一集按钮
            this.css([playID, pauseID, frontID, nextID], {
                width: bWidth + 'px',
                height: bHeight + 'px',
                float: 'left',
                overflow: 'hidden',
                cursor: 'pointer'
            });
            this.css([frontID, nextID], 'display', 'none');
            //初始化判断播放/暂停按钮隐藏项
            this.initPlayPause();

            //设置静音/取消静音的按钮样式
            this.css([muteID, escMuteID], {
                width: bWidth + 'px',
                height: bHeight + 'px',
                float: 'right',
                overflow: 'hidden',
                cursor: 'pointer'
            });
            if(this.vars['volume'] > 0) {
                this.css(escMuteID, 'display', 'none');
            } else {
                this.css(muteID, 'display', 'none');
            }
            //音量调节框
            this.css([volumeID, volumeDbgID], {
                width: '110px',
                height: bHeight + 'px',
                overflow: 'hidden',
                float: 'right'
            });
            this.css(volumeDbgID, {
                position: 'absolute'
            });
            this.css([volumeBgID, volumeUpID], {
                width: '100px',
                height: '6px',
                overflow: 'hidden',
                borderRadius: '5px',
                cursor: 'pointer'
            });
            this.css(volumeBgID, {
                position: 'absolute',
                top: '16px'
            });
            this.css(volumeBgID, 'backgroundColor', '#666666');
            this.css(volumeUpID, 'backgroundColor', bOverColor);
            this.buttonWidth['volume'] = 100;
            //音量调节按钮
            this.css(volumeBOID, {
                width: '12px',
                height: '12px',
                overflow: 'hidden',
                borderRadius: '50%',
                position: 'absolute',
                backgroundColor: bBgColor,
                top: '13px',
                left: '0px',
                cursor: 'pointer'
            });
            this.css(volumeBWID, {
                width: '6px',
                height: '6px',
                overflow: 'hidden',
                borderRadius: '50%',
                position: 'absolute',
                backgroundColor: bOverColor,
                left: '3px',
                top: '3px'
            });
            //清晰度容器
            this.css(definitionID, {
                lineHeight: bHeight + 'px',
                color: '#FFFFFF',
                float: 'right',
                fontSize: '14px',
                textAlign: 'center',
                overflow: 'hidden',
                display: 'none',
                cursor: 'pointer'
            });
            this.css(definitionPID, {
                lineHeight: (bHeight - 8) + 'px',
                color: '#FFFFFF',
                overflow: 'hidden',
                position: 'absolute',
                bottom: '4px',
                backgroundColor: '#000000',
                textAlign: 'center',
                zIndex: '95',
                cursor: 'pointer',
                display: 'none'
            });
            //倍速容器
            this.css(playbackRateID, {
                lineHeight: bHeight + 'px',
                color: '#FFFFFF',
                float: 'right',
                fontSize: '14px',
                textAlign: 'center',
                overflow: 'hidden',
                display: 'none',
                cursor: 'pointer'
            });
            this.css(playbackRatePID, {
                lineHeight: (bHeight - 8) + 'px',
                color: '#FFFFFF',
                overflow: 'hidden',
                position: 'absolute',
                bottom: '4px',
                backgroundColor: '#000000',
                textAlign: 'center',
                zIndex: '95',
                cursor: 'pointer',
                display: 'none'
            });
            //设置全屏/退出全屏按钮样式
            this.css([fullID, escFullID], {
                width: bWidth + 'px',
                height: bHeight + 'px',
                float: 'right',
                overflow: 'hidden',
                cursor: 'pointer'
            });
            this.css(escFullID, 'display', 'none');
            //构建各按钮的形状
            //播放按钮
            var cPlay = this.getByElement(playID + '-canvas').getContext('2d');
            var cPlayFillRect = function() {
                thisTemp.canvasFill(cPlay, [
                    [12, 10],
                    [29, 19],
                    [12, 28]
                ]);
            };
            cPlay.fillStyle = bBgColor;
            cPlayFillRect();
            var cPlayOver = function(event) {
                cPlay.clearRect(0, 0, bWidth, bHeight);
                cPlay.fillStyle = bOverColor;
                cPlayFillRect();
            };
            var cPlayOut = function(event) {
                cPlay.clearRect(0, 0, bWidth, bHeight);
                cPlay.fillStyle = bBgColor;
                cPlayFillRect();
            };

            this.addListenerInside('mouseover', cPlayOver, this.getByElement(playID + '-canvas'));
            this.addListenerInside('mouseout', cPlayOut, this.getByElement(playID + '-canvas'));
            //暂停按钮
            var cPause = this.getByElement(pauseID + '-canvas').getContext('2d');
            var cPauseFillRect = function() {
                thisTemp.canvasFillRect(cPause, [
                    [10, 10, 5, 18],
                    [22, 10, 5, 18]
                ]);
            };
            cPause.fillStyle = bBgColor;
            cPauseFillRect();
            var cPauseOver = function(event) {
                cPause.clearRect(0, 0, bWidth, bHeight);
                cPause.fillStyle = bOverColor;
                cPauseFillRect();
            };
            var cPauseOut = function(event) {
                cPause.clearRect(0, 0, bWidth, bHeight);
                cPause.fillStyle = bBgColor;
                cPauseFillRect();
            };
            this.addListenerInside('mouseover', cPauseOver, this.getByElement(pauseID + '-canvas'));
            this.addListenerInside('mouseout', cPauseOut, this.getByElement(pauseID + '-canvas'));
            //前一集按钮
            var cFront = this.getByElement(frontID + '-canvas').getContext('2d');
            var cFrontFillRect = function() {
                thisTemp.canvasFill(cFront, [
                    [16, 19],
                    [30, 10],
                    [30, 28]
                ]);
                thisTemp.canvasFillRect(cFront, [
                    [8, 10, 5, 18]
                ]);
            };
            cFront.fillStyle = bBgColor;
            cFrontFillRect();
            var cFrontOver = function(event) {
                cFront.clearRect(0, 0, bWidth, bHeight);
                cFront.fillStyle = bOverColor;
                cFrontFillRect();
            };
            var cFrontOut = function(event) {
                cFront.clearRect(0, 0, bWidth, bHeight);
                cFront.fillStyle = bBgColor;
                cFrontFillRect();
            };

            this.addListenerInside('mouseover', cFrontOver, this.getByElement(frontID + '-canvas'));
            this.addListenerInside('mouseout', cFrontOut, this.getByElement(frontID + '-canvas'));
            //下一集按钮
            var cNext = this.getByElement(nextID + '-canvas').getContext('2d');
            var cNextFillRect = function() {
                thisTemp.canvasFill(cNext, [
                    [8, 10],
                    [22, 19],
                    [8, 28]
                ]);
                thisTemp.canvasFillRect(cNext, [
                    [25, 10, 5, 18]
                ]);
            };
            cNext.fillStyle = bBgColor;
            cNextFillRect();
            var cNextOver = function(event) {
                cNext.clearRect(0, 0, bWidth, bHeight);
                cNext.fillStyle = bOverColor;
                cNextFillRect();
            };
            var cNextOut = function(event) {
                cNext.clearRect(0, 0, bWidth, bHeight);
                cNext.fillStyle = bBgColor;
                cNextFillRect();
            };
            this.addListenerInside('mouseover', cNextOver, this.getByElement(nextID + '-canvas'));
            this.addListenerInside('mouseout', cNextOut, this.getByElement(nextID + '-canvas'));
            //全屏按钮
            var cFull = this.getByElement(fullID + '-canvas').getContext('2d');
            var cFullFillRect = function() {
                thisTemp.canvasFillRect(cFull, [
                    [19, 10, 9, 3],
                    [25, 13, 3, 6],
                    [10, 19, 3, 9],
                    [13, 25, 6, 3]
                ]);
            };
            cFull.fillStyle = bBgColor;
            cFullFillRect();
            var cFullOver = function() {
                cFull.clearRect(0, 0, bWidth, bHeight);
                cFull.fillStyle = bOverColor;
                cFullFillRect();
            };
            var cFullOut = function() {
                cFull.clearRect(0, 0, bWidth, bHeight);
                cFull.fillStyle = bBgColor;
                cFullFillRect();
            };
            this.addListenerInside('mouseover', cFullOver, this.getByElement(fullID + '-canvas'));
            this.addListenerInside('mouseout', cFullOut, this.getByElement(fullID + '-canvas'));
            //定义退出全屏按钮样式
            var cEscFull = this.getByElement(escFullID + '-canvas').getContext('2d');
            var cEscFullFillRect = function() {
                thisTemp.canvasFillRect(cEscFull, [
                    [20, 9, 3, 9],
                    [23, 15, 6, 3],
                    [9, 20, 9, 3],
                    [15, 23, 3, 6]
                ]);
            };
            cEscFull.fillStyle = bBgColor;
            cEscFullFillRect();

            var cEscFullOver = function() {
                cEscFull.clearRect(0, 0, bWidth, bHeight);
                cEscFull.fillStyle = bOverColor;
                cEscFullFillRect();
            };
            var cEscFullOut = function() {
                cEscFull.clearRect(0, 0, bWidth, bHeight);
                cEscFull.fillStyle = bBgColor;
                cEscFullFillRect();
            };
            this.addListenerInside('mouseover', cEscFullOver, this.getByElement(escFullID + '-canvas'));
            this.addListenerInside('mouseout', cEscFullOut, this.getByElement(escFullID + '-canvas'));
            //定义全屏按钮的样式
            var cMute = this.getByElement(muteID + '-canvas').getContext('2d');
            var cMuteFillRect = function() {
                thisTemp.canvasFill(cMute, [
                    [10, 15],
                    [15, 15],
                    [21, 10],
                    [21, 28],
                    [15, 23],
                    [10, 23]
                ]);
                thisTemp.canvasFillRect(cMute, [
                    [23, 15, 2, 8],
                    [27, 10, 2, 18]
                ]);
            };
            cMute.fillStyle = bBgColor;
            cMuteFillRect();
            var cMuteOver = function() {
                cMute.clearRect(0, 0, bWidth, bHeight);
                cMute.fillStyle = bOverColor;
                cMuteFillRect();
            };
            var cMuteOut = function() {
                cMute.clearRect(0, 0, bWidth, bHeight);
                cMute.fillStyle = bBgColor;
                cMuteFillRect();
            };
            this.addListenerInside('mouseover', cMuteOver, this.getByElement(muteID + '-canvas'));
            this.addListenerInside('mouseout', cMuteOut, this.getByElement(muteID + '-canvas'));
            //定义退出全屏按钮样式
            var cEscMute = this.getByElement(escMuteID + '-canvas').getContext('2d');
            var cEscMuteFillRect = function() {
                thisTemp.canvasFill(cEscMute, [
                    [10, 15],
                    [15, 15],
                    [21, 10],
                    [21, 28],
                    [15, 23],
                    [10, 23]
                ]);
                thisTemp.canvasFill(cEscMute, [
                    [23, 13],
                    [24, 13],
                    [33, 25],
                    [32, 25]
                ]);
                thisTemp.canvasFill(cEscMute, [
                    [32, 13],
                    [33, 13],
                    [24, 25],
                    [23, 25]
                ]);
            };
            cEscMute.fillStyle = bBgColor;
            cEscMuteFillRect();
            var cEscMuteOver = function() {
                cEscMute.clearRect(0, 0, bWidth, bHeight);
                cEscMute.fillStyle = bOverColor;
                cEscMuteFillRect();
            };
            var cEscMuteOut = function() {
                cEscMute.clearRect(0, 0, bWidth, bHeight);
                cEscMute.fillStyle = bBgColor;
                cEscMuteFillRect();
            };
            this.addListenerInside('mouseover', cEscMuteOver, this.getByElement(escMuteID + '-canvas'));
            this.addListenerInside('mouseout', cEscMuteOut, this.getByElement(escMuteID + '-canvas'));
            //定义loading样式
            var cLoading = this.getByElement(loadingID + '-canvas').getContext('2d');
            var cLoadingFillRect = function() {
                cLoading.save();
                var grad = cLoading.createLinearGradient(0, 0, 60, 60);
                grad.addColorStop(0, bBgColor);
                var grad2 = cLoading.createLinearGradient(0, 0, 80, 60);
                grad2.addColorStop(1, bOverColor);
                var grad3 = cLoading.createLinearGradient(0, 0, 80, 60);
                grad3.addColorStop(1, '#FF9900');
                var grad4 = cLoading.createLinearGradient(0, 0, 80, 60);
                grad4.addColorStop(1, '#CC3300');
                cLoading.strokeStyle = grad; //设置描边样式
                cLoading.lineWidth = 8; //设置线宽
                cLoading.beginPath(); //路径开始
                cLoading.arc(30, 30, 25, 0, 0.4 * Math.PI, false); //用于绘制圆弧context.arc(x坐标，y坐标，半径，起始角度，终止角度，顺时针/逆时针)
                cLoading.stroke(); //绘制
                cLoading.closePath(); //路径结束
                cLoading.beginPath(); //路径开始
                cLoading.strokeStyle = grad2; //设置描边样式
                cLoading.arc(30, 30, 25, 0.5 * Math.PI, 0.9 * Math.PI, false); //用于绘制圆弧context.arc(x坐标，y坐标，半径，起始角度，终止角度，顺时针/逆时针)
                cLoading.stroke(); //绘制
                cLoading.beginPath(); //路径开始
                cLoading.strokeStyle = grad3; //设置描边样式
                cLoading.arc(30, 30, 25, Math.PI, 1.4 * Math.PI, false); //用于绘制圆弧context.arc(x坐标，y坐标，半径，起始角度，终止角度，顺时针/逆时针)
                cLoading.stroke(); //绘制
                cLoading.beginPath(); //路径开始
                cLoading.strokeStyle = grad4; //设置描边样式
                cLoading.arc(30, 30, 25, 1.5 * Math.PI, 1.9 * Math.PI, false); //用于绘制圆弧context.arc(x坐标，y坐标，半径，起始角度，终止角度，顺时针/逆时针)
                cLoading.stroke(); //绘制
                cLoading.closePath(); //路径结束
                cLoading.restore();
            };
            cLoading.fillStyle = bBgColor;
            cLoadingFillRect();
            //定义中间暂停按钮的样式
            var cPauseCenter = this.getByElement(pauseCenterID + '-canvas').getContext('2d');
            var cPauseCenterFillRect = function() {
                thisTemp.canvasFill(cPauseCenter, [
                    [28, 22],
                    [59, 38],
                    [28, 58]
                ]);
                /* 指定几个颜色 */
                cPauseCenter.save();
                cPauseCenter.lineWidth = 5; //设置线宽
                cPauseCenter.beginPath(); //路径开始
                cPauseCenter.arc(40, 40, 35, 0, 2 * Math.PI, false); //用于绘制圆弧context.arc(x坐标，y坐标，半径，起始角度，终止角度，顺时针/逆时针)
                cPauseCenter.stroke(); //绘制
                cPauseCenter.closePath(); //路径结束
                cPauseCenter.restore();
            };
            cPauseCenter.fillStyle = bBgColor;
            cPauseCenter.strokeStyle = bBgColor;
            cPauseCenterFillRect();
            var cPauseCenterOver = function() {
                cPauseCenter.clearRect(0, 0, 80, 80);
                cPauseCenter.fillStyle = bOverColor;
                cPauseCenter.strokeStyle = bOverColor;
                cPauseCenterFillRect();
            };
            var cPauseCenterOut = function() {
                cPauseCenter.clearRect(0, 0, 80, 80);
                cPauseCenter.fillStyle = bBgColor;
                cPauseCenter.strokeStyle = bBgColor;
                cPauseCenterFillRect();
            };
            this.addListenerInside('mouseover', cPauseCenterOver, this.getByElement(pauseCenterID + '-canvas'));
            this.addListenerInside('mouseout', cPauseCenterOut, this.getByElement(pauseCenterID + '-canvas'));

            //鼠标经过/离开音量调节按钮
            var volumeBOOver = function() {
                thisTemp.css(volumeBOID, 'backgroundColor', bOverColor);
                thisTemp.css(volumeBWID, 'backgroundColor', bBgColor);
            };
            var volumeBOOut = function() {
                thisTemp.css(volumeBOID, 'backgroundColor', bBgColor);
                thisTemp.css(volumeBWID, 'backgroundColor', bOverColor);
            };
            this.addListenerInside('mouseover', volumeBOOver, this.getByElement(volumeBOID));
            this.addListenerInside('mouseout', volumeBOOut, this.getByElement(volumeBOID));
            //鼠标经过/离开进度按钮
            var timeBOOver = function() {
                thisTemp.css(timeBOID, 'backgroundColor', bOverColor);
                thisTemp.css(timeBWID, 'backgroundColor', bBgColor);
            };
            var timeBOOut = function() {
                thisTemp.css(timeBOID, 'backgroundColor', bBgColor);
                thisTemp.css(timeBWID, 'backgroundColor', bOverColor);
            };
            this.addListenerInside('mouseover', timeBOOver, this.getByElement(timeBOID));
            this.addListenerInside('mouseout', timeBOOut, this.getByElement(timeBOID));

            this.addButtonEvent(); //注册按钮及音量调节，进度操作事件
            this.newMenu(); //单独设置右键的样式和事件
            this.controlBarHide(); //单独注册控制栏隐藏事件
            this.keypress(); //单独注册键盘事件
            //初始化音量调节框
            this.changeVolume(this.vars['volume']);
            //初始化判断是否需要显示上一集和下一集按钮
            this.showFrontNext();
            window.setTimeout(function() {
                thisTemp.elementCoordinate(); //调整中间暂停按钮/loading的位置/error的位置
            }, 100);
            this.checkBarWidth();
            var resize = function() {
                thisTemp.elementCoordinate();
                thisTemp.timeUpdateHandler();
                thisTemp.changeLoad();
                thisTemp.checkBarWidth();
                thisTemp.changeElementCoor(); //修改新加元件的坐标
                thisTemp.changePrompt();
            };
            this.addListenerInside('resize', resize, window);
        },
        /*
			内部函数
			创建按钮，使用canvas画布
		*/
        newCanvas: function(id, width, height) {
            return '<canvas class="' + id + '-canvas" width="' + width + '" height="' + height + '"></canvas>';
        },
        /*
			内部函数
			注册按钮，音量调节框，进度操作框事件
		*/
        addButtonEvent: function() {
            var thisTemp = this;
            //定义按钮的单击事件
            var playClick = function(event) {
                thisTemp.videoPlay();
            };
            this.addListenerInside('click', playClick, this.CB['play']);
            this.addListenerInside('click', playClick, this.CB['pauseCenter']);
            var pauseClick = function(event) {
                thisTemp.videoPause();
            };
            this.addListenerInside('click', pauseClick, this.CB['pause']);
            var frontClick = function(event) {
                if(thisTemp.vars['front']) {
                    eval(thisTemp.vars['front'] + '()');
                }
            };
            this.addListenerInside('click', frontClick, this.CB['front']);
            var nextClick = function(event) {
                if(thisTemp.vars['next']) {
                    eval(thisTemp.vars['next'] + '()');
                }
            };
            this.addListenerInside('click', nextClick, this.CB['next']);
            var muteClick = function(event) {
                thisTemp.videoMute();
            };
            this.addListenerInside('click', muteClick, this.CB['mute']);
            var escMuteClick = function(event) {
                thisTemp.videoEscMute();
            };
            this.addListenerInside('click', escMuteClick, this.CB['escMute']);
            var fullClick = function(event) {
                thisTemp.fullScreen();
            };
            this.addListenerInside('click', fullClick, this.CB['full']);
            var escFullClick = function(event) {
                thisTemp.quitFullScreen();
            };
            this.addListenerInside('click', escFullClick, this.CB['escFull']);
            //定义各个按钮的鼠标经过/离开事件
            var promptHide = function(event) {
                thisTemp.promptShow(false);
            };
            var playOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['play']);
            };
            this.addListenerInside('mouseover', playOver, this.CB['play']);
            this.addListenerInside('mouseout', promptHide, this.CB['play']);
            var pauseOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['pause']);
            };
            this.addListenerInside('mouseover', pauseOver, this.CB['pause']);
            this.addListenerInside('mouseout', promptHide, this.CB['pause']);
            var frontOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['front']);
            };
            this.addListenerInside('mouseover', frontOver, this.CB['front']);
            this.addListenerInside('mouseout', promptHide, this.CB['front']);
            var nextOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['next']);
            };
            this.addListenerInside('mouseover', nextOver, this.CB['next']);
            this.addListenerInside('mouseout', promptHide, this.CB['next']);
            var muteOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['mute']);
            };
            this.addListenerInside('mouseover', muteOver, this.CB['mute']);
            this.addListenerInside('mouseout', promptHide, this.CB['mute']);
            var escMuteOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['escMute']);
            };
            this.addListenerInside('mouseover', escMuteOver, this.CB['escMute']);
            this.addListenerInside('mouseout', promptHide, this.CB['escMute']);
            var fullOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['full']);
            };
            this.addListenerInside('mouseover', fullOver, this.CB['full']);
            this.addListenerInside('mouseout', promptHide, this.CB['full']);
            var escFullOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['escFull']);
            };
            this.addListenerInside('mouseover', escFullOver, this.CB['escFull']);
            this.addListenerInside('mouseout', promptHide, this.CB['escFull']);
            var definitionOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['definition']);
            };
            this.addListenerInside('mouseover', definitionOver, this.CB['definition']);
            this.addListenerInside('mouseout', promptHide, this.CB['definition']);
            var playbackrateOver = function(event) {
                thisTemp.promptShow(thisTemp.CB['playbackrate']);
            };
            this.addListenerInside('mouseover', playbackrateOver, this.CB['playbackrate']);
            this.addListenerInside('mouseout', promptHide, this.CB['playbackrate']);
            //定义音量和进度按钮的滑块事件

            var volumePrompt = function(vol) {
                var volumeBOXY = thisTemp.getCoor(thisTemp.CB['volumeBO']);
                var promptObj = {
                    title: thisTemp.language['volume'] + vol + '%',
                    x: volumeBOXY['x'] + thisTemp.CB['volumeBO'].offsetWidth * 0.5,
                    y: volumeBOXY['y']
                };
                thisTemp.promptShow(false, promptObj);
            };
            var volumeObj = {
                slider: this.CB['volumeBO'],
                follow: this.CB['volumeUp'],
                refer: this.CB['volumeBg'],
                grossValue: 'volume',
                pd: true,
                startFun: function(vol) {},
                monitorFun: function(vol) {
                    thisTemp.changeVolume(vol * 0.01, false, false);
                    volumePrompt(vol);
                },
                endFun: function(vol) {},
                overFun: function(vol) {
                    volumePrompt(vol);
                }
            };
            this.slider(volumeObj);
            var volumeClickObj = {
                refer: this.CB['volumeBg'],
                grossValue: 'volume',
                fun: function(vol) {
                    thisTemp.changeVolume(vol * 0.01, true, true);
                }
            };
            this.progressClick(volumeClickObj);
            this.timeButtonMouseDown(); //用单击的函数来判断是否需要建立控制栏监听
            //鼠标经过/离开音量调节框时的
            var volumeBgMove = function(event) {
                var volumeBgXY = thisTemp.getCoor(thisTemp.CB['volumeBg']);
                var eventX = thisTemp.client(event)['x'];
                var eventVolume = parseInt((eventX - volumeBgXY['x']) * 100 / thisTemp.CB['volumeBg'].offsetWidth);
                var buttonPromptObj = {
                    title: thisTemp.language['volume'] + eventVolume + '%',
                    x: eventX,
                    y: volumeBgXY['y']
                };
                thisTemp.promptShow(false, buttonPromptObj);
            };
            this.addListenerInside('mousemove', volumeBgMove, this.CB['volumeBg']);
            this.addListenerInside('mouseout', promptHide, this.CB['volumeBg']);
            this.addListenerInside('mouseout', promptHide, this.CB['volumeBO']);
            //注册清晰度相关事件
            this.addDefListener();
            //注册倍速相关事件
            this.addPlaybackrate();
        },
        /*
			内部函数
			注册单击视频动作
		*/
        videoClick: function() {
            var thisTemp = this;
            var clearTimerClick = function() {
                if(thisTemp.timerClick != null) {
                    if(thisTemp.timerClick.runing) {
                        thisTemp.timerClick.stop();
                    }
                    thisTemp.timerClick = null;
                }
            };
            var timerClickFun = function() {
                clearTimerClick();
                thisTemp.isClick = false;
                thisTemp.playOrPause();

            };
            clearTimerClick();
            if(this.isClick) {
                this.isClick = false;
                if(thisTemp.config['videoDbClick']) {
                    if(!this.full) {
                        thisTemp.fullScreen();
                    } else {
                        thisTemp.quitFullScreen();
                    }
                }

            } else {
                this.isClick = true;
                this.timerClick = new this.timer(300, timerClickFun, 1)
                //this.timerClick.start();
            }

        },
        /*
			内部函数
			注册鼠标经过进度滑块的事件
		*/
        timeButtonMouseDown: function() {
            var thisTemp = this;
            var timePrompt = function(time) {
                if(isNaN(time)) {
                    time = 0;
                }
                var timeButtonXY = thisTemp.getCoor(thisTemp.CB['timeButton']);
                var promptObj = {
                    title: thisTemp.formatTime(time),
                    x: timeButtonXY['x'] - thisTemp.pdCoor['x'] + thisTemp.CB['timeButton'].offsetWidth * 0.5,
                    y: timeButtonXY['y'] - thisTemp.pdCoor['y']
                };
                thisTemp.promptShow(false, promptObj);
            };
            var timeObj = {
                slider: this.CB['timeButton'],
                follow: this.CB['timeProgress'],
                refer: this.CB['timeBoBg'],
                grossValue: 'time',
                pd: false,
                startFun: function(time) {
                    thisTemp.isTimeButtonMove = false;
                },
                monitorFun: function(time) {},
                endFun: function(time) {
                    if(thisTemp.V) {
                        if(thisTemp.V.duration > 0) {
                            thisTemp.needSeek = 0;
                            thisTemp.videoSeek(parseInt(time));
                        }
                    }
                },
                overFun: function(time) {
                    timePrompt(time);
                }
            };
            var timeClickObj = {
                refer: this.CB['timeBoBg'],
                grossValue: 'time',
                fun: function(time) {
                    if(thisTemp.V) {
                        if(thisTemp.V.duration > 0) {
                            thisTemp.needSeek = 0;
                            thisTemp.videoSeek(parseInt(time));
                        }
                    }
                }
            };
            var timeBoBgmousemove = function(event) {
                var timeBoBgXY = thisTemp.getCoor(thisTemp.CB['timeBoBg']);
                var eventX = thisTemp.client(event)['x'];
                var eventTime = parseInt((eventX - timeBoBgXY['x']) * thisTemp.V.duration / thisTemp.CB['timeBoBg'].offsetWidth);
                var buttonPromptObj = {
                    title: thisTemp.formatTime(eventTime),
                    x: eventX,
                    y: timeBoBgXY['y']
                };
                thisTemp.promptShow(false, buttonPromptObj);
                var def = false;
                if(!thisTemp.isUndefined(thisTemp.CB['definitionP'])) {
                    if(thisTemp.css(thisTemp.CB['definitionP'], 'display') != 'block') {
                        def = true;
                    }
                }
                if(thisTemp.vars['preview'] != null && def) {
                    buttonPromptObj['time'] = eventTime;
                    thisTemp.preview(buttonPromptObj);
                }
            };
            var promptHide = function(event) {
                thisTemp.promptShow(false);
                if(thisTemp.previewDiv != null) {
                    thisTemp.css([thisTemp.previewDiv, thisTemp.previewTop], 'display', 'none');
                }
            };
            if(!this.vars['live']) { //如果不是直播
                this.isTimeButtonDown = true;
                this.addListenerInside('mousemove', timeBoBgmousemove, this.CB['timeBoBg']);
                this.addListenerInside('mouseout', promptHide, this.CB['timeBoBg']);
            } else {
                this.isTimeButtonDown = false;
                timeObj['removeListenerInside'] = true;
                timeClickObj['removeListenerInside'] = true;
            }
            this.slider(timeObj);
            this.progressClick(timeClickObj);
        },
        /*
			内部函数
			注册调节框上单击事件，包含音量调节框和播放时度调节框
		*/
        progressClick: function(obj) {
            /*
				refer:参考对象
				fun:返回函数
				refer:参考元素，即背景
				grossValue:调用的参考值类型
				pd:
			*/
            //建立参考元素的mouseClick事件，用来做为鼠标在其上按下时触发的状态
            var thisTemp = this;
            var referMouseClick = function(event) {
                var referX = thisTemp.client(event)['x'] - thisTemp.getCoor(obj['refer'])['x'];
                var rWidth = obj['refer'].offsetWidth;
                var grossValue = 0;
                if(obj['grossValue'] == 'volume') {
                    grossValue = 100;
                } else {
                    if(thisTemp.V) {
                        grossValue = thisTemp.V.duration;
                    }
                }
                var nowZ = parseInt(referX * grossValue / rWidth);
                if(obj['fun']) {
                    obj['fun'](nowZ);
                }
            };
            if(this.isUndefined(obj['removeListenerInside'])) {
                this.addListenerInside('click', referMouseClick, obj['refer']);
            } else {
                this.removeListenerInside('click', referMouseClick, obj['refer']);
            }

        },

        /*
			内部函数
			共用的注册滑块事件
		*/
        slider: function(obj) {
            /*
				obj={
					slider:滑块元素
					follow:跟随滑块的元素
					refer:参考元素，即背景
					grossValue:调用的参考值类型
					startFun:开始调用的元素
					monitorFun:监听函数
					endFun:结束调用的函数
					overFun:鼠标放上去后调用的函数
					pd:是否需要修正
				}
			*/
            var thisTemp = this;
            var clientX = 0,
                criterionWidth = 0,
                sliderLeft = 0,
                referLeft = 0;
            var value = 0;
            var calculation = function() { //根据滑块的left计算百分比
                var sLeft = parseInt(thisTemp.css(obj['slider'], 'left'));
                var rWidth = obj['refer'].offsetWidth - obj['slider'].offsetWidth;
                var grossValue = 0;
                if(thisTemp.isUndefined(sLeft) || isNaN(sLeft)) {
                    sLeft = 0;
                }
                if(obj['grossValue'] == 'volume') {
                    grossValue = 100;
                } else {
                    if(thisTemp.V) {
                        grossValue = thisTemp.V.duration;
                    }
                }
                return parseInt(sLeft * grossValue / rWidth);
            };
            var mDown = function(event) {
                thisTemp.addListenerInside('mousemove', mMove, document);
                thisTemp.addListenerInside('mouseup', mUp, document);
                var referXY = thisTemp.getCoor(obj['refer']);
                var sliderXY = thisTemp.getCoor(obj['slider']);
                clientX = thisTemp.client(event)['x'];
                referLeft = referXY['x'];
                sliderLeft = sliderXY['x'];
                criterionWidth = clientX - sliderLeft;
                if(obj['startFun']) {
                    obj['startFun'](calculation());
                }
            };
            var mMove = function(event) {
                clientX = thisTemp.client(event)['x'];
                var newX = clientX - criterionWidth - referLeft;
                if(newX < 0) {
                    newX = 0;
                }
                if(newX > obj['refer'].offsetWidth - obj['slider'].offsetWidth) {
                    newX = obj['refer'].offsetWidth - obj['slider'].offsetWidth;
                }
                thisTemp.css(obj['slider'], 'left', newX + 'px');
                thisTemp.css(obj['follow'], 'width', (newX + obj['slider'].offsetWidth * 0.5) + 'px');
                var nowZ = calculation();
                if(obj['monitorFun']) {
                    obj['monitorFun'](nowZ);
                }
            };
            var mUp = function(event) {
                thisTemp.removeListenerInside('mousemove', mMove, document);
                thisTemp.removeListenerInside('mouseup', mUp, document);
                if(obj['endFun']) {
                    obj['endFun'](calculation());
                }
            };
            var mOver = function(event) {
                if(obj['overFun']) {
                    obj['overFun'](calculation());
                }

            };
            if(this.isUndefined(obj['removeListenerInside'])) {
                this.addListenerInside('mousedown', mDown, obj['slider']);
                this.addListenerInside('mouseover', mOver, obj['slider']);
            } else {
                this.removeListenerInside('mousedown', mDown, obj['slider']);
                this.removeListenerInside('mouseover', mOver, obj['slider']);
            }
        },
        /*
			内部函数
			显示loading
		*/
        loadingStart: function(rot) {
            var thisTemp = this;
            if(this.isUndefined(rot)) {
                rot = true;
            }
            if(this.showFace) {
                this.css(thisTemp.CB['loading'], 'display', 'none');
            }
            if(this.timerLoading != null) {
                if(this.timerLoading.runing) {
                    this.timerLoading.stop();
                }
                this.timerLoading = null;
            }
            var buffer = 0;
            var loadingFun = function() {
                var nowRotate = '0';
                try {
                    nowRotate = thisTemp.css(thisTemp.CB['loadingCanvas'], 'transform') || thisTemp.css(thisTemp.CB['loadingCanvas'], '-ms-transform') || thisTemp.css(thisTemp.CB['loadingCanvas'], '-moz-transform') || thisTemp.css(thisTemp.CB['loadingCanvas'], '-webkit-transform') || thisTemp.css(thisTemp.CB['loadingCanvas'], '-o-transform') || '0';
                } catch(event) {}
                nowRotate = parseInt(nowRotate.replace('rotate(', '').replace('deg);', ''));
                nowRotate += 4;
                if(nowRotate > 360) {
                    nowRotate = 0;
                }
                if(thisTemp.showFace) {
                    thisTemp.css(thisTemp.CB['loadingCanvas'], {
                        transform: 'rotate(' + nowRotate + 'deg)',
                        msTransform: 'rotate(' + nowRotate + 'deg)',
                        mozTransform: 'rotate(' + nowRotate + 'deg)',
                        webkitTransform: 'rotate(' + nowRotate + 'deg)',
                        oTransform: 'rotate(' + nowRotate + 'deg)'
                    });
                }
                buffer++;
                if(buffer >= 99) {
                    buffer = 99;
                }
                thisTemp.sendJS('buffer', buffer);
            };
            if(rot) {
                this.timerLoading = new this.timer(10, loadingFun);
                //this.timerLoading.start();
                if(this.showFace) {
                    this.css(thisTemp.CB['loading'], 'display', 'block');
                }
            } else {
                thisTemp.sendJS('buffer', 100);
            }
        },
        /*
			内部函数
			判断是否需要显示上一集和下一集
		*/
        showFrontNext: function() {
            if(!this.showFace) {
                return;
            }
            if(this.vars['front']) {
                this.css([this.CB['front'], this.CB['frontLine']], 'display', 'block');
            } else {
                this.css([this.CB['front'], this.CB['frontLine']], 'display', 'none');
            }
            if(this.vars['next']) {
                this.css([this.CB['next'], this.CB['nextLine']], 'display', 'block');
            } else {
                this.css([this.CB['next'], this.CB['nextLine']], 'display', 'none');
            }
        },
        /*
			内部函数
			显示提示语
		*/
        promptShow: function(ele, data) {
            if(!this.showFace) {
                return;
            }
            var obj = {};
            if(ele || data) {
                if(!this.isUndefined(data)) {
                    obj = data;
                } else {
                    var offsetCoor = this.getCoor(ele);
                    obj = {
                        title: this.getDataset(ele, 'title'),
                        x: offsetCoor['x'] + ele.offsetWidth * 0.5,
                        y: offsetCoor['y']
                    };
                }
                this.CB['prompt'].innerHTML = obj['title'];
                this.css(this.CB['prompt'], 'display', 'block');
                var promoptWidth = this.getStringLen(obj['title']) * 10;
                this.css(this.CB['promptBg'], 'width', promoptWidth + 'px');
                this.css(this.CB['prompt'], 'width', promoptWidth + 'px');
                promoptWidth += 10;
                var x = obj['x'] - (promoptWidth * 0.5);
                var y = this.PD.offsetHeight - obj['y'] + 8;
                if(x < 0) {
                    x = 0;
                }
                if(x > this.PD.offsetWidth - promoptWidth) {
                    x = this.PD.offsetWidth - promoptWidth;
                }
                this.css([this.CB['promptBg'], this.CB['prompt']], {
                    display: 'block',
                    left: x + 'px',
                    bottom: y + 'px'
                });
            } else {
                this.css([this.CB['promptBg'], this.CB['prompt']], {
                    display: 'none'
                });
            }
        },
        /*
			内部函数
			监听错误
		*/
        timerErrorFun: function() {
            var thisTemp = this;
            this.errorSend=false;
            var clearIntervalError = function(event) {
                if(thisTemp.timerError != null) {
                    if(thisTemp.timerError.runing) {
                        thisTemp.timerError.stop();
                    }
                    thisTemp.timerError = null;
                }
            };
            var errorFun = function(event) {
                clearIntervalError();
                thisTemp.error = true;
                //提取错误播放地址
                thisTemp.errorUrl = thisTemp.getVideoUrl();
                //提取错误播放地址结束
                if(!thisTemp.errorSend){
                    thisTemp.errorSend=true;
                    thisTemp.sendJS('error');
                }
                if(thisTemp.showFace) {
                    thisTemp.css(thisTemp.CB['errorText'], 'display', 'block');
                    thisTemp.css(thisTemp.CB['pauseCenter'], 'display', 'none');
                    thisTemp.css(thisTemp.CB['loading'], 'display', 'none');
                }
                thisTemp.V.removeAttribute('poster');
                thisTemp.resetPlayer();
            };
            var errorListenerFun = function(event) {
                window.setTimeout(function() {
                    if(isNaN(thisTemp.V.duration)) {
                        errorFun(event);
                    }
                }, 500);

            };
            if(!this.errorAdd){
                this.errorAdd=true;
                this.addListenerInside('error', errorListenerFun, this.V);
            }
            clearIntervalError();
            var timerErrorFun = function() {
                if(thisTemp.V && parseInt(thisTemp.V.networkState) == 3) {
                    errorFun();
                }
            };
            this.timerError = new this.timer(this.config['errorTime'], timerErrorFun);
            //this.timerError.start();
        },
        /*
			内部函数
			构建判断全屏还是非全屏的判断
		*/
        judgeFullScreen: function() {
            var thisTemp = this;
            if(this.timerFull != null) {
                if(this.timerFull.runing) {
                    this.timerFull.stop();
                }
                this.timerFull = null;
            }
            var fullFun = function() {
                thisTemp.isFullScreen();
            };
            this.timerFull = new this.timer(20, fullFun);
        },
        /*
			内部函数
			判断是否是全屏
		*/
        isFullScreen: function() {
            if(!this.showFace) {
                return;
            }
            var fullState = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen || document.msFullscreenElement;
            if(fullState && !this.full) {
                this.full = true;
                this.sendJS('full', true);
                this.elementCoordinate();
                this.css(this.CB['full'], 'display', 'none');
                this.css(this.CB['escFull'], 'display', 'block');
                if(this.vars['live'] == 0) {
                    this.timeUpdateHandler();
                }
                this.PD.appendChild(this.CB['menu']);
            }
            if(!fullState && this.full) {
                this.full = false;
                this.sendJS('full', false);
                this.elementCoordinate();
                this.css(this.CB['full'], 'display', 'block');
                this.css(this.CB['escFull'], 'display', 'none');
                if(this.timerFull != null) {
                    if(this.timerFull.runing) {
                        this.timerFull.stop();
                    }
                    this.timerFull = null;
                }
                if(this.vars['live'] == 0) {
                    this.timeUpdateHandler();
                }
                this.body.appendChild(this.CB['menu']);
            }
        },
        /*
			内部函数
			构建右键内容及注册相关动作事件
		*/
        newMenu: function() {
            var thisTemp = this;
            var i = 0;
            this.css(this.CB['menu'], {
                backgroundColor: '#FFFFFF',
                padding: '5px',
                position: 'absolute',
                left: '10px',
                top: '20px',
                display: 'none',
                zIndex: '999',
                color: '#A1A9BE',
                boxShadow: '2px 2px 3px #AAAAAA'
            });
            var mArr = this.contextMenu;
            var html = '';
            for(i = 0; i < mArr.length; i++) {
                var me = mArr[i];
                switch(me[1]) {
                    case 'default':
                        html += '<p>' + me[0] + '</p>';
                        break;
                    case 'link':
                        html += '<p><a href="' + me[2] + '" target="_blank">' + me[0] + '</a></p>';
                        break;
                    case 'javascript':
                        html += '<p><a href="javascript:' + me[2] + '()">' + me[0] + '</a></p>';
                        break;
                    case 'function':
                        html += '<p><a href="javascript:' + this.vars['variable'] + '.' + me[2] + '()">' + me[0] + '</a></p>';
                        break;
                    default:
                        break;
                }
            }
            this.CB['menu'].innerHTML = html;
            var pArr = this.CB['menu'].childNodes;
            for(i = 0; i < pArr.length; i++) {
                this.css(pArr[i], {
                    height: '30px',
                    lineHeight: '30px',
                    margin: '0px',
                    fontFamily: this.fontFamily,
                    fontSize: '12px',
                    paddingLeft: '10px',
                    paddingRight: '30px'
                });
                if(mArr[i].length >= 4) {
                    if(mArr[i][3] == 'line') {
                        this.css(pArr[i], 'borderTop', '1px solid #e9e9e9');
                    }
                }
                var aArr = pArr[i].childNodes;
                for(var n = 0; n < aArr.length; n++) {
                    if(aArr[n].localName == 'a') {
                        this.css(aArr[n], {
                            color: '#000000',
                            textDecoration: 'none'
                        });
                    }
                }
            }
            this.PD.oncontextmenu = function(event) {
                var eve = event || window.event;
                var client = thisTemp.client(event);
                if(eve.button == 2) {
                    eve.returnvalue = false;
                    var x = client['x'] + thisTemp.pdCoor['x'] - 2;
                    var y = client['y'] + thisTemp.pdCoor['y'] - 2;
                    thisTemp.css(thisTemp.CB['menu'], {
                        display: 'block',
                        left: x + 'px',
                        top: y + 'px'
                    });
                    return false;
                }
                return true;
            };
            var setTimeOutPClose = function() {
                if(setTimeOutP) {
                    window.clearTimeout(setTimeOutP);
                    setTimeOutP = null;
                }
            };
            var setTimeOutP = null;
            var mouseOut = function(event) {
                setTimeOutPClose();
                setTimeOutP = window.setTimeout(function(event) {
                    thisTemp.css(thisTemp.CB['menu'], 'display', 'none');
                }, 500);
            };
            this.addListenerInside('mouseout', mouseOut, thisTemp.CB['menu']);
            var mouseOver = function(event) {
                setTimeOutPClose();
            };
            this.addListenerInside('mouseover', mouseOver, thisTemp.CB['menu']);

        },
        /*
			内部函数
			构建控制栏隐藏事件
		*/
        controlBarHide: function(hide) {
            var thisTemp = this;
            var client = {
                    x: 0,
                    y: 0
                },
                oldClient = {
                    x: 0,
                    y: 0
                };
            var cShow = true,force=false;
            var oldCoor = [0, 0];
            var controlBarShow = function(show) {
                if(show && !cShow && thisTemp.controlBarIsShow) {
                    cShow = true;
                    thisTemp.sendJS('controlBar',true);
                    thisTemp.css(thisTemp.CB['controlBarBg'], 'display', 'block');
                    thisTemp.css(thisTemp.CB['controlBar'], 'display', 'block');
                    thisTemp.css(thisTemp.CB['timeProgressBg'], 'display', 'block');
                    thisTemp.css(thisTemp.CB['timeBoBg'], 'display', 'block');
                    thisTemp.changeVolume(thisTemp.volume);
                    thisTemp.changeLoad();
                    if(!thisTemp.timerBuffer) {
                        thisTemp.bufferEdHandler();
                    }
                } else {
                    if(cShow) {
                        cShow = false;
                        var paused = thisTemp.getMetaDate()['paused'];
                        if(force){
                            paused=false;
                        }
                        if(!paused) {
                            thisTemp.sendJS('controlBar',false);
                            thisTemp.css(thisTemp.CB['controlBarBg'], 'display', 'none');
                            thisTemp.css(thisTemp.CB['controlBar'], 'display', 'none');
                            thisTemp.css(thisTemp.CB['timeProgressBg'], 'display', 'none');
                            thisTemp.css(thisTemp.CB['timeBoBg'], 'display', 'none');
                            thisTemp.promptShow(false);

                        }
                    }
                }
            };
            var cbarFun = function(event) {
                if(client['x'] == oldClient['x'] && client['y'] == oldClient['y']) {
                    var cdH = parseInt(thisTemp.CD.offsetHeight);
                    if((client['y'] < cdH - 50 || client['y'] > cdH - 2) && cShow) {
                        controlBarShow(false);
                    }
                } else {
                    if(!cShow) {
                        controlBarShow(true);
                    }
                }
                oldClient = {
                    x: client['x'],
                    y: client['y']
                }
            };
            this.timerCBar = new this.timer(2000, cbarFun);
            var cdMove = function(event) {
                var getClient = thisTemp.client(event);
                client['x'] = getClient['x'];
                client['y'] = getClient['y'];
                if(!cShow) {
                    controlBarShow(true);
                }
            };
            this.addListenerInside('mousemove', cdMove, thisTemp.CD);
            this.addListenerInside('ended', cdMove);
            this.addListenerInside('resize', cdMove, window);
            if(hide===true){
                cShow=true;
                force=true;
                controlBarShow(false);
            }
            if(hide===false){
                cShow=false;
                force=true;
                controlBarShow(true);
            }
        },

        /*
			内部函数
			注册键盘按键事件
		*/
        keypress: function() {
            var thisTemp = this;
            var keyDown = function(eve) {
                var keycode = eve.keyCode || eve.which;
                switch(keycode) {
                    case 32:
                        thisTemp.playOrPause();
                        break;
                    case 37:
                        thisTemp.fastBack();
                        break;
                    case 39:
                        thisTemp.fastNext();
                        break;
                    case 38:
                        now = thisTemp.volume + thisTemp.ckplayerConfig['config']['volumeJump'];
                        thisTemp.changeVolume(now > 1 ? 1 : now);
                        break;
                    case 40:
                        now = thisTemp.volume - thisTemp.ckplayerConfig['config']['volumeJump'];
                        thisTemp.changeVolume(now < 0 ? 0 : now);
                        break;
                    default:
                        break;
                }
            };
            this.addListenerInside('keydown', keyDown, window || document);
        },
        /*
			内部函数
			注册倍速相关
		*/
        playbackRate: function() {
            if(!this.showFace) {
                return;
            }
            var thisTemp = this;
            var vArr = this.playbackRateArr;
            var html = '';
            var nowD = ''; //当前的清晰度
            var i = 0;
            if(!nowD) {
                nowD = vArr[this.playbackRateDefault][1];
            }
            if(vArr.length > 1) {
                var zlen = 0;
                for(i = 0; i < vArr.length; i++) {
                    html = '<p>' + vArr[i][1] + '</p>' + html;
                    var dlen = this.getStringLen(vArr[i][1]);
                    if(dlen > zlen) {
                        zlen = dlen;
                    }
                }
                if(html) {
                    html += '<p>' + nowD + '</p>';
                }
                this.CB['playbackrate'].innerHTML = nowD;
                this.CB['playbackrateP'].innerHTML = html;
                this.css([this.CB['playbackrate'], this.CB['playbackrateLine']], 'display', 'block');
                var pArr = this.CB['playbackrateP'].childNodes;
                for(var i = 0; i < pArr.length; i++) {
                    var fontColor = '#FFFFFF';
                    if(pArr[i].innerHTML == nowD) {
                        fontColor = '#0782F5';
                    }
                    this.css(pArr[i], {
                        color: fontColor,
                        margin: '0px',
                        padding: '0px',
                        fontSize: '14px'
                    });
                    if(i < pArr.length - 1) {
                        this.css(pArr[i], 'borderBottom', '1px solid #282828')
                    }
                    var defClick = function(event) {
                        if(nowD != this.innerHTML) {
                            thisTemp.css(thisTemp.CB['playbackrateP'], 'display', 'none');
                            thisTemp.newPlaybackrate(this.innerHTML);
                        }
                    };
                    this.addListenerInside('click', defClick, pArr[i]);

                }
                var pW = (zlen * 10) + 20;
                this.css(this.CB['playbackrateP'], {
                    width: pW + 'px'
                });
                this.css(this.CB['playbackrate'], {
                    width: pW + 'px'
                });
                this.buttonWidth['playbackrate'] = this.CB['playbackrate'].offsetWidth;
            } else {
                this.CB['playbackrate'].innerHTML = '';
                this.CB['playbackrateP'].innerHTML = '';
                this.css([this.CB['playbackrate'], this.CB['playbackrateLine']], 'display', 'none');
            }
        },
        /*
			内部函数
			注册清晰度相关事件
		*/
        addPlaybackrate: function() {
            var thisTemp = this;
            var setTimeOutP = null;
            var defClick = function(event) {
                thisTemp.css(thisTemp.CB['playbackrateP'], {
                    left: thisTemp.getCoor(thisTemp.CB['playbackrate'])['x'] + 'px',
                    display: 'block'
                });
            };
            this.addListenerInside('click', defClick, this.CB['playbackrate']);
            var defMouseOut = function(event) {
                if(setTimeOutP) {
                    window.clearTimeout(setTimeOutP);
                    setTimeOutP = null;
                }
                setTimeOutP = window.setTimeout(function(event) {
                    thisTemp.css(thisTemp.CB['playbackrateP'], 'display', 'none');
                }, 500);
            };
            this.addListenerInside('mouseout', defMouseOut, thisTemp.CB['playbackrateP']);
            var defMouseOver = function(event) {
                if(setTimeOutP) {
                    window.clearTimeout(setTimeOutP);
                    setTimeOutP = null;
                }
            };
            this.addListenerInside('mouseover', defMouseOver, thisTemp.CB['playbackrateP']);
        },
        /*
			内部函数
			切换倍速后发生的动作
		*/
        newPlaybackrate: function(title) {
            var vArr = this.playbackRateArr;
            var nVArr = [];
            var i = 0;
            for(i = 0; i < vArr.length; i++) {
                var v = vArr[i];
                if(v[1] == title) {
                    this.playbackRateDefault = i;
                    this.V.playbackRate = v[0];
                    if(this.showFace) {
                        this.CB['playbackrate'].innerHTML = v[1];
                        this.playbackRate();
                    }
                    this.sendJS('playbackRate',v);
                }
            }
        },

        /*
			内部函数
			构建清晰度按钮及切换事件(Click事件)
		*/
        definition: function() {
            if(!this.showFace) {
                return;
            }
            var thisTemp = this;
            var vArr = this.VA;
            var dArr = [];
            var html = '';
            var nowD = ''; //当前的清晰度
            var i = 0;
            for(i = 0; i < vArr.length; i++) {
                var d = vArr[i][2];
                if(dArr.indexOf(d) == -1) {
                    dArr.push(d);
                }
                if(this.V) {
                    if(vArr[i][0] == this.V.currentSrc) {
                        nowD = d;
                    }
                }
            }
            if(!nowD) {
                nowD = dArr[0];
            }
            if(dArr.length > 1) {
                var zlen = 0;
                for(i = dArr.length - 1; i > -1; i--) {
                    html = '<p>' + dArr[i] + '</p>' + html;
                    var dlen = this.getStringLen(dArr[i]);
                    if(dlen > zlen) {
                        zlen = dlen;
                    }
                }
                if(html) {
                    html += '<p>' + nowD + '</p>';
                }
                this.CB['definition'].innerHTML = nowD;
                this.CB['definitionP'].innerHTML = html;
                this.css([this.CB['definition'], this.CB['definitionLine']], 'display', 'block');
                var pArr = this.CB['definitionP'].childNodes;
                for(var i = 0; i < pArr.length; i++) {
                    var fontColor = '#FFFFFF';
                    if(pArr[i].innerHTML == nowD) {
                        fontColor = '#0782F5';
                    }
                    this.css(pArr[i], {
                        color: fontColor,
                        margin: '0px',
                        padding: '0px',
                        fontSize: '14px'
                    });
                    if(i < pArr.length - 1) {
                        this.css(pArr[i], 'borderBottom', '1px solid #282828')
                    }
                    var defClick = function() {
                        if(nowD != this.innerHTML) {
                            thisTemp.css(thisTemp.CB['definitionP'], 'display', 'none');
                            thisTemp.newDefinition(this.innerHTML);
                        }
                    };
                    this.addListenerInside('click', defClick, pArr[i]);

                }
                var pW = (zlen * 10) + 20;
                this.css(this.CB['definitionP'], {
                    width: pW + 'px'
                });
                this.css(this.CB['definition'], {
                    width: pW + 'px'
                });
                this.buttonWidth['definition'] = this.CB['definition'].offsetWidth;
            } else {
                this.CB['definition'].innerHTML = '';
                this.CB['definitionP'].innerHTML = '';
                this.css([this.CB['definition'], this.CB['definitionLine']], 'display', 'none');
            }
        },
        /*
			内部函数
			注册清晰度相关事件
		*/
        addDefListener: function() {
            var thisTemp = this;
            var setTimeOutP = null;
            var defClick = function(event) {
                thisTemp.css(thisTemp.CB['definitionP'], {
                    left: thisTemp.getCoor(thisTemp.CB['definition'])['x'] + 'px',
                    display: 'block'
                });
            };
            this.addListenerInside('click', defClick, this.CB['definition']);
            var defMouseOut = function(event) {
                if(setTimeOutP) {
                    window.clearTimeout(setTimeOutP);
                    setTimeOutP = null;
                }
                setTimeOutP = window.setTimeout(function(event) {
                    thisTemp.css(thisTemp.CB['definitionP'], 'display', 'none');
                }, 500);
            };
            this.addListenerInside('mouseout', defMouseOut, thisTemp.CB['definitionP']);
            var defMouseOver = function(event) {
                if(setTimeOutP) {
                    window.clearTimeout(setTimeOutP);
                    setTimeOutP = null;
                }
            };
            this.addListenerInside('mouseover', defMouseOver, thisTemp.CB['definitionP']);
        },
        /*
			内部函数
			切换清晰度后发生的动作
		*/
        newDefinition: function(title) {
            var vArr = this.VA;
            var nVArr = [];
            var i = 0;
            for(i = 0; i < vArr.length; i++) {
                var v = vArr[i];
                if(v[2] == title) {
                    nVArr.push(v);
                }
            }
            if(nVArr.length < 1) {
                return;
            }
            if(this.V != null && this.needSeek == 0) {
                this.needSeek = this.V.currentTime;
            }
            if(this.getFileExt(nVArr[0][0]) != '.m3u8') {
                this.isM3u8 = false;
            }
            if(!this.isM3u8) {
                if(nVArr.length == 1) {
                    this.V.innerHTML = '';
                    this.V.src = nVArr[0][0];
                } else {
                    var source = '';
                    nVArr = this.arrSort(nVArr);
                    for(i = 0; i < nVArr.length; i++) {
                        var type = '';
                        var va = nVArr[i];
                        if(va[1]) {
                            type = ' type="' + va[1] + '"';
                        }
                        source += '<source src="' + va[0] + '"' + type + '>';
                    }
                    this.V.removeAttribute('src');
                    this.V.innerHTML = source;
                }
            } else {
                this.embedHls(vArr[0][0], this.vars['autoplay']);
            }
            this.V.autoplay = 'autoplay';
            this.V.load();
            this.timerErrorFun();
        },
        /*
			内置函数
			播放hls
		*/
        embedHls: function(url, autoplay) {
            var thisTemp = this;
            if(Hls.isSupported()) {
                var hls = new Hls();
                hls.loadSource(url);
                hls.attachMedia(this.V);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    thisTemp.playerLoad();
                    if(autoplay) {
                        thisTemp.videoPlay();
                    }
                });
            }
        },
        /*
			内部函数
			构建提示点
		*/
        prompt: function() {
            if(!this.showFace) {
                return;
            }
            var thisTemp = this;
            var prompt = this.vars['promptSpot'];
            if(prompt == null || this.promptArr.length > 0) {
                return;
            }
            var showPrompt = function(event) {
                if(thisTemp.promptElement == null) {
                    var random2 = 'prompte' + thisTemp.randomString(5);
                    var ele2 = document.createElement('div');
                    ele2.className = random2;
                    thisTemp.PD.appendChild(ele2);
                    thisTemp.promptElement = thisTemp.getByElement(random2);
                    thisTemp.css(thisTemp.promptElement, {
                        overflowX: 'hidden',
                        lineHeight: '22px',
                        fontSize: '14px',
                        color: '#FFFFFF',
                        position: 'absolute',
                        display: 'block',
                        zIndex: '90'
                    });
                }
                var pcon = thisTemp.getPromptTest();
                var pW = pcon['pW'],
                    pT = pcon['pT'],
                    pL = parseInt(thisTemp.css(this, 'left')) - parseInt(pW * 0.5);
                if(pcon['pL'] > 10) {
                    pL = pcon['pL'];
                }
                if(pL < 0) {
                    pL = 0;
                }
                thisTemp.css(thisTemp.promptElement, {
                    width: pW + 'px',
                    left: (-pW - 10) + 'px',
                    display: 'block'
                });
                thisTemp.promptElement.innerHTML = thisTemp.getDataset(this, 'words');
                thisTemp.css(thisTemp.promptElement, {
                    left: pL + 'px',
                    top: (pT - thisTemp.promptElement.offsetHeight - 10) + 'px'
                });
            };
            var hidePrompt = function(event) {
                if(thisTemp.promptElement != null) {
                    thisTemp.css(thisTemp.promptElement, {
                        display: 'none'
                    });
                }
            };
            var i = 0;
            for(i = 0; i < prompt.length; i++) {
                var pr = prompt[i];
                var words = pr['words'];
                var time = pr['time'];
                var random = 'prompt' + this.randomString(5);
                var ele = document.createElement('div');
                ele.className = random;
                this.CB['timeBoBg'].appendChild(ele);
                var div = this.getByElement(random);
                div.setAttribute('data-time', time);
                div.setAttribute('data-words', words);
                this.css(div, {
                    width: '6px',
                    height: '6px',
                    backgroundColor: '#FFFFFF',
                    position: 'absolute',
                    top: '4px',
                    left: '-100px',
                    display: 'none',
                    zIndex: '1'
                });

                this.addListenerInside('mouseover', showPrompt, div);
                this.addListenerInside('mouseout', hidePrompt, div);
                this.promptArr.push(div);
            }
            this.changePrompt();
        },
        /*
			内部函数
			计算提示文本的位置
		*/
        getPromptTest: function() {
            var pW = this.previewWidth,
                pT = this.getCoor(this.CB['timeButton'])['y'],
                pL = 0;
            if(this.previewTop != null) {
                pT -= parseInt(this.css(this.previewTop, 'height'));
                pL = parseInt(this.css(this.previewTop, 'left'));
            } else {
                pT -= 35;
            }
            pL += 2;
            if(pL < 0) {
                pL = 0;
            }
            if(pL > this.PD.offsetWidth - pW) {
                pL = this.PD.offsetWidth - pW;
            }
            return {
                pW: pW,
                pT: pT,
                pL: pL
            };
        },
        /*
			内部函数
			删除提示点
		*/
        deletePrompt: function() {
            var arr = this.promptArr;
            if(arr.length > 0) {
                for(var i = 0; i < arr.length; i++) {
                    if(arr[i]) {
                        this.deleteChild(arr[i]);
                    }
                }
            }
            this.promptArr = [];
        },
        /*
			内部函数
			计算提示点坐标
		*/
        changePrompt: function() {
            if(this.promptArr.length == 0) {
                return;
            }
            var arr = this.promptArr;
            var duration = this.getMetaDate()['duration'];
            var bw = this.CB['timeBoBg'].offsetWidth;
            for(var i = 0; i < arr.length; i++) {
                var time = parseInt(this.getDataset(arr[i], 'time'));
                var left = parseInt(time * bw / duration) - parseInt(arr[i].offsetWidth * 0.5);
                if(left < 0) {
                    left = 0;
                }
                if(left > bw - parseInt(arr[i].offsetWidth * 0.5)) {
                    left = bw - parseInt(arr[i].offsetWidth * 0.5);
                }
                this.css(arr[i], {
                    left: left + 'px',
                    display: 'block'
                });
            }
        },
        /*
			内部函数
			构建预览图片效果
		*/
        preview: function(obj) {
            var thisTemp = this;
            var preview = {
                file: null,
                scale: 0
            };
            preview = this.standardization(preview, this.vars['preview']);
            if(preview['file'] == null || preview['scale'] <= 0) {
                return;
            }
            var srcArr = preview['file'];
            if(this.previewStart == 0) { //如果还没有构建，则先进行构建
                this.previewStart = 1;
                if(srcArr.length > 0) {
                    var i = 0;
                    var imgW = 0,
                        imgH = 0;
                    var random = thisTemp.randomString(10);
                    var loadNum = 0;
                    var loadImg = function(i) {
                        srcArr[i] = thisTemp.getNewUrl(srcArr[i]);
                        var n = 0;
                        var img = new Image();
                        img.src = srcArr[i];
                        img.className = random + i;
                        img.onload = function(event) {
                            loadNum++;
                            if(thisTemp.previewDiv == null) { //如果没有建立DIV，则建
                                imgW = img.width;
                                imgH = img.height;
                                thisTemp.previewWidth = parseInt(imgW * 0.1);
                                var ele = document.createElement('div');
                                ele.className = random;
                                thisTemp.PD.appendChild(ele);
                                thisTemp.previewDiv = thisTemp.getByElement(random);
                                var eleTop = (obj['y'] - parseInt(imgH * 0.1) + 2);
                                thisTemp.css(thisTemp.previewDiv, {
                                    width: srcArr.length * imgW * 10 + 'px',
                                    height: parseInt(imgH * 0.1) + 'px',
                                    backgroundColor: '#000000',
                                    position: 'absolute',
                                    left: '0px',
                                    top: eleTop + 'px',
                                    display: 'none',
                                    zIndex: '80'
                                });
                                ele.setAttribute('data-x', '0');
                                ele.setAttribute('data-y', eleTop);
                                var ele2 = document.createElement('div');
                                ele2.className = random + 'd2';
                                thisTemp.PD.appendChild(ele2);
                                thisTemp.previewTop = thisTemp.getByElement(ele2.className);
                                thisTemp.css(thisTemp.previewTop, {
                                    width: parseInt(imgW * 0.1) + 'px',
                                    height: parseInt(imgH * 0.1) + 'px',
                                    position: 'absolute',
                                    border: '5px solid ' + thisTemp.css(thisTemp.CB['timeProgress'], 'backgroundColor'),
                                    left: '0px',
                                    top: (obj['y'] - parseInt(imgH * 0.1) + 2) + 'px',
                                    display: 'none',
                                    zIndex: '81'
                                });
                                var html = '';
                                for(n = 0; n < srcArr.length; n++) {
                                    html += thisTemp.newCanvas(random + n, imgW * 10, parseInt(imgH * 0.1))
                                }
                                thisTemp.previewDiv.innerHTML = html;
                            }
                            thisTemp.previewDiv.appendChild(img);
                            var cimg = thisTemp.getByElement(img.className);
                            var canvas = thisTemp.getByElement(img.className + '-canvas');
                            var context = canvas.getContext('2d');
                            var sx = 0,
                                sy = 0,
                                x = 0,
                                h = parseInt(imgH * 0.1);
                            for(n = 0; n < 100; n++) {
                                x = parseInt(n * imgW * 0.1);
                                context.drawImage(cimg, sx, sy, parseInt(imgW * 0.1), h, x, 0, parseInt(imgW * 0.1), h);
                                sx += parseInt(imgW * 0.1);
                                if(sx >= imgW) {
                                    sx = 0;
                                    sy += h;
                                }
                                thisTemp.css(cimg, 'display', 'none');
                            }
                            if(loadNum == srcArr.length) {
                                thisTemp.previewStart = 2;
                            } else {
                                i++;
                                loadImg(i);
                            }
                        };
                    };
                }
                loadImg(i);
                return;
            }
            if(this.previewStart == 2) {
                var isTween = true;
                var nowNum = parseInt(obj['time'] / this.vars['preview']['scale']);
                var numTotal = parseInt(thisTemp.getMetaDate()['duration'] / this.vars['preview']['scale']);
                if(thisTemp.css(thisTemp.previewDiv, 'display') == 'none') {
                    isTween = false;
                }
                thisTemp.css(thisTemp.previewDiv, 'display', 'block');
                var imgWidth = thisTemp.previewDiv.offsetWidth * 0.01 / srcArr.length;
                var left = (imgWidth * nowNum) - obj['x'] + parseInt(imgWidth * 0.5),
                    top = obj['y'] - thisTemp.previewDiv.offsetHeight;
                thisTemp.css(thisTemp.previewDiv, 'top', top + 2 + 'px');
                var topLeft = obj['x'] - parseInt(imgWidth * 0.5);
                var timepieces = 0;
                if(topLeft < 0) {
                    topLeft = 0;
                    timepieces = obj['x'] - topLeft - imgWidth * 0.5;
                }
                if(topLeft > thisTemp.PD.offsetWidth - imgWidth) {
                    topLeft = thisTemp.PD.offsetWidth - imgWidth;
                    timepieces = obj['x'] - topLeft - imgWidth * 0.5;
                }
                if(left < 0) {
                    left = 0;
                }
                if(left > numTotal * imgWidth - thisTemp.PD.offsetWidth) {
                    left = numTotal * imgWidth - thisTemp.PD.offsetWidth;
                }
                thisTemp.css(thisTemp.previewTop, {
                    left: topLeft + 'px',
                    top: top + 2 + 'px',
                    display: 'block'
                });
                if(thisTemp.previewTop.offsetHeight > thisTemp.previewDiv.offsetHeight) {
                    thisTemp.css(thisTemp.previewTop, {
                        height: thisTemp.previewDiv.offsetHeight - (thisTemp.previewTop.offsetHeight - thisTemp.previewDiv.offsetHeight) + 'px'
                    });
                }
                if(this.previewTween != null) {
                    this.animatePause(this.previewTween);
                    this.previewTween = null
                }
                var nowLeft = parseInt(thisTemp.css(thisTemp.previewDiv, 'left'));
                var leftC = nowLeft + left;
                if(nowLeft == -(left + timepieces)) {
                    return;
                }
                if(isTween) {
                    var obj = {
                        element: thisTemp.previewDiv,
                        start: null,
                        end: -(left + timepieces),
                        speed: 0.3
                    };
                    this.previewTween = this.animate(obj);
                } else {
                    thisTemp.css(thisTemp.previewDiv, 'left', -(left + timepieces) + 'px')
                }
            }
        },
        /*
			内部函数
			删除预览图节点
		*/
        deletePreview: function() {
            if(this.previewDiv != null) {
                this.deleteChild(this.previewDiv);
                this.previewDiv = null;
                this.previewStart = 0;
            }
        },
        /*
			内部函数
			修改视频地址，属性
		*/
        changeVideo: function() {
            if(!this.html5Video) {
                this.getVarsObject();
                this.V.newVideo(this.vars);
                return;
            }
            var vArr = this.VA;
            var v = this.vars;
            var i = 0;
            if(vArr.length < 1) {
                return;
            }
            if(this.V != null && this.needSeek == 0) {
                this.needSeek = this.V.currentTime;
            }
            if(v['poster']) {
                this.V.poster = v['poster'];
            } else {
                this.V.removeAttribute('poster');
            }
            if(v['loop']) {
                this.V.loop = 'loop';
            } else {
                this.V.removeAttribute('loop');
            }
            if(v['seek'] > 0) {
                this.needSeek = v['seek'];
            } else {
                this.needSeek = 0;
            }
            if(this.getFileExt(vArr[0][0]) != '.m3u8') {
                this.isM3u8 = false;
            }
            if(!this.isM3u8) {
                if(vArr.length == 1) {
                    this.V.innerHTML = '';
                    this.V.src = vArr[0][0];
                } else {
                    var source = '';
                    vArr = this.arrSort(vArr);
                    for(i = 0; i < vArr.length; i++) {
                        var type = '';
                        var va = vArr[i];
                        if(va[1]) {
                            type = ' type="' + va[1] + '"';
                        }
                        source += '<source src="' + va[0] + '"' + type + '>';
                    }
                    this.V.removeAttribute('src');
                    this.V.innerHTML = source;
                }
                //分析视频地址结束
                if(v['autoplay']) {
                    this.V.autoplay = 'autoplay';
                } else {
                    this.V.removeAttribute('autoplay');
                }
                this.V.load();
            } else {
                this.embedHls(vArr[0][0], v['autoplay']);
            }
            if(!this.isUndefined(v['volume'])) {
                this.changeVolume(v['volume']);
            }
            this.resetPlayer(); //重置界面元素
            this.timerErrorFun();
            //如果存在字幕则加载
            if(this.vars['cktrack']) {
                this.loadTrack();
            }
        },
        /*
			内部函数
			调整中间暂停按钮,缓冲loading，错误提示文本框的位置
		*/
        elementCoordinate: function() {
            this.pdCoor = this.getXY(this.PD);
            this.css(this.CB['pauseCenter'], {
                left: parseInt((this.PD.offsetWidth - 80) * 0.5) + 'px',
                top: parseInt((this.PD.offsetHeight - 80) * 0.5) + 'px'
            });
            this.css(this.CB['loading'], {
                left: parseInt((this.PD.offsetWidth - 60) * 0.5) + 'px',
                top: parseInt((this.PD.offsetHeight - 60) * 0.5) + 'px'
            });
            this.css(this.CB['errorText'], {
                left: parseInt((this.PD.offsetWidth - 120) * 0.5) + 'px',
                top: parseInt((this.PD.offsetHeight - 30) * 0.5) + 'px'
            });
            this.css(this.CB['logo'], {
                left: parseInt(this.PD.offsetWidth - this.CB['logo'].offsetWidth - 20) + 'px',
                top: '20px'
            });
            this.checkBarWidth();
        },
        /*
			内部函数
			当播放器尺寸变化时，显示和隐藏相关节点
		*/
        checkBarWidth: function() {
            if(!this.showFace) {
                return;
            }
            var controlBarW = this.CB['controlBar'].offsetWidth;
            var ele = [];
            ele.push([
                [this.CB['full'], this.CB['escFull'], this.CB['fullLine']], this.buttonWidth['full'] + 2, 'full'
            ]);
            if(this.vars['front'] != '') {
                ele.push([
                    [this.CB['front'], this.CB['frontLine']], this.buttonWidth['front'] + 2
                ]);
            }
            if(this.vars['next'] != '') {
                ele.push([
                    [this.CB['next'], this.CB['nextLine']], this.buttonWidth['next'] + 2
                ]);
            }
            if(this.CB['definition'].innerHTML != '') {
                ele.push([
                    [this.CB['definition'], this.CB['definitionLine']], this.buttonWidth['definition'] + 2
                ]);
            }
            ele.push([
                [this.CB['volume']], this.buttonWidth['volume']
            ]);
            ele.push([
                [this.CB['mute'], this.CB['escMute'], this.CB['muteLine']], this.buttonWidth['mute'] + 2, 'mute'
            ]);
            ele.push([
                [this.CB['timeText']], this.buttonWidth['timeText']
            ]);
            ele.push([
                [this.CB['play'], this.CB['pause'], this.CB['playLine']], this.buttonWidth['play'] + 2, 'play'
            ]);

            var i = 0;
            var len = 0;
            var isc = true;
            //计算所有要显示的节点的总宽度
            for(var i = 0; i < ele.length; i++) {
                var nlen = ele[i][1];
                if(nlen > 2) {
                    len += nlen;
                } else {
                    isc = false;
                }
            }
            if(isc) {
                this.buttonLen = len;
                this.buttonArr = ele;
            }
            len = this.buttonLen;
            ele = this.buttonArr;
            for(var i = 0; i < ele.length; i++) {
                if(len > controlBarW) {
                    len -= ele[i][1];
                    this.css(ele[i][0], 'display', 'none');
                } else {
                    this.css(ele[i][0], 'display', 'block');
                    if(ele[i].length == 3) {
                        var name = ele[i][2];
                        switch(name) {
                            case 'mute':
                                if(this.volume == 0) {
                                    this.css(this.CB['mute'], 'display', 'none');
                                } else {
                                    this.css(this.CB['escMute'], 'display', 'none');
                                }
                                break;
                            case 'play':
                                this.playShow(this.V.paused ? false : true);
                                break;
                            case 'full':
                                if(this.full) {
                                    this.css(this.CB['full'], 'display', 'none');
                                } else {
                                    this.css(this.CB['escFull'], 'display', 'none');
                                }
                                break;
                        }
                    }
                }
            }
        },
        /*
			内部函数
			初始化暂停或播放按钮
		*/
        initPlayPause: function() {
            if(!this.showFace) {
                return;
            }
            if(this.vars['autoplay']) {
                this.css([this.CB['play'], this.CB['pauseCenter']], 'display', 'none');
                this.css(this.CB['pause'], 'display', 'block');
            } else {
                this.css(this.CB['play'], 'display', 'block');
                if(this.css(this.CB['errorText'], 'display') == 'none') {
                    this.css(this.CB['pauseCenter'], 'display', 'block');
                }
                this.css(this.CB['pause'], 'display', 'none');
            }
        },

        /*
			下面为监听事件
			内部函数
			监听元数据已加载
		*/
        loadedHandler: function() {
            this.loaded = true;
            if(this.vars['loaded'] != '') {
                try {
                    eval(this.vars['loaded'] + '()');
                } catch(event) {
                    this.log(event);
                }
            }
        },
        /*
			内部函数
			监听播放
		*/
        playingHandler: function() {
            this.playShow(true);
            if(this.needSeek > 0) {
                this.videoSeek(this.needSeek);
                this.needSeek = 0;
            }
            if(this.animatePauseArray.length > 0) {
                this.animateResume('pause');
            }
            if(this.playerType == 'html5video' && this.V != null && this.config['videoDrawImage']) {
                this.sendVCanvas();
            }
        },
        /*
			内部函数
			使用画布附加视频
		*/
        sendVCanvas: function() {
            if(this.timerVCanvas == null) {
                this.css(this.V, 'display', 'none');
                this.css(this.MD, 'display', 'block');
                var thisTemp = this;
                var videoCanvas = function() {
                    if(thisTemp.MDCX.width != thisTemp.PD.offsetWidth) {
                        thisTemp.MDC.width = thisTemp.PD.offsetWidth;
                    }
                    if(thisTemp.MDCX.height != thisTemp.PD.offsetHeight) {
                        thisTemp.MDC.height = thisTemp.PD.offsetHeight;
                    }
                    thisTemp.MDCX.clearRect(0, 0, thisTemp.MDCX.width, thisTemp.MDCX.height);
                    var coor = thisTemp.getProportionCoor(thisTemp.PD.offsetWidth, thisTemp.PD.offsetHeight, thisTemp.V.videoWidth, thisTemp.V.videoHeight);
                    thisTemp.MDCX.drawImage(thisTemp.V, 0, 0, thisTemp.V.videoWidth, thisTemp.V.videoHeight, coor['x'], coor['y'], coor['width'], coor['height']);
                };
                this.timerVCanvas = new this.timer(0, videoCanvas);
            }
        },
        /*
			内部函数
			监听暂停
		*/
        pauseHandler: function() {
            this.playShow(false);
            if(this.animatePauseArray.length > 0) {
                this.animatePause('pause');
            }
            if(this.playerType == 'html5video' && this.V != null && this.config['videoDrawImage']) {
                this.stopVCanvas();
            }
        },
        /*
			内部函数
			停止画布
		*/
        stopVCanvas: function() {
            if(this.timerVCanvas != null) {
                this.css(this.V, 'display', 'block');
                this.css(this.MD, 'display', 'none');
                if(this.timerVCanvas.runing) {
                    this.timerVCanvas.stop();
                }
                this.timerVCanvas = null;
            }
        },
        /*
			内部函数
			根据当前播放还是暂停确认图标显示
		*/
        playShow: function(b) {
            if(!this.showFace) {
                return;
            }
            if(b) {
                this.css(this.CB['play'], 'display', 'none');
                this.css(this.CB['pauseCenter'], 'display', 'none');
                this.css(this.CB['pause'], 'display', 'block');
            } else {
                this.css(this.CB['play'], 'display', 'block');
                if(this.css(this.CB['errorText'], 'display') == 'none') {
                    this.css(this.CB['pauseCenter'], 'display', 'block');
                } else {
                    this.css(this.CB['pauseCenter'], 'display', 'none');
                }
                this.css(this.CB['pause'], 'display', 'none');
            }
        },
        /*
			内部函数
			监听seek结束
		*/
        seekedHandler: function() {
            this.resetTrack();
            this.isTimeButtonMove = true;
            if(this.V.paused) {
                this.videoPlay();
            }
        },
        /*
			内部函数
			监听播放结束
		*/
        endedHandler: function() {
            if(!this.vars['loop']) {
                this.videoPause();
            }
        },
        /*
			内部函数
			监听音量改变
		*/
        volumechangeHandler: function() {
            if(!this.showFace) {
                return;
            }
            try {
                if(this.V.volume > 0) {
                    this.css(this.CB['mute'], 'display', 'block');
                    this.css(this.CB['escMute'], 'display', 'none');
                } else {
                    this.css(this.CB['mute'], 'display', 'none');
                    this.css(this.CB['escMute'], 'display', 'block');
                }
            } catch(event) {}
        },

        /*
			内部函数
			监听播放时间调节进度条
		*/
        timeUpdateHandler: function() {
            var duration = 0;
            if(this.playerType == 'html5video') {
                try {
                    duration = this.V.duration;
                } catch(event) {}
            }
            if(duration > 0) {
                this.time = this.V.currentTime;
                this.timeTextHandler();
                this.trackShowHandler();
                if(this.isTimeButtonMove) {
                    this.timeProgress(this.time, duration);
                }
            }
        },
        /*
			内部函数
			按时间改变进度条
		*/
        timeProgress: function(time, duration) {
            if(!this.showFace) {
                return;
            }
            var timeProgressBgW = this.CB['timeProgressBg'].offsetWidth;
            var timeBOW = parseInt((time * timeProgressBgW / duration) - (this.CB['timeButton'].offsetWidth * 0.5));
            if(timeBOW > timeProgressBgW - this.CB['timeButton'].offsetWidth) {
                timeBOW = timeProgressBgW - this.CB['timeButton'].offsetWidth;
            }
            if(timeBOW < 0) {
                timeBOW = 0;
            }
            this.css(this.CB['timeProgress'], 'width', timeBOW + 'px');
            this.css(this.CB['timeButton'], 'left', parseInt(timeBOW) + 'px');
        },
        /*
			内部函数
			监听播放时间改变时间显示文本框
		*/
        timeTextHandler: function() { //显示时间/总时间
            if(!this.showFace) {
                return;
            }
            var duration = this.V.duration;
            var time = this.V.currentTime;
            if(isNaN(duration) || parseInt(duration) < 0.2) {
                duration = this.vars['duration'];
            }
            this.CB['timeText'].innerHTML = this.formatTime(time) + ' / ' + this.formatTime(duration);
            if(this.CB['timeText'].offsetWidth > 0) {
                this.buttonWidth['timeText'] = this.CB['timeText'].offsetWidth;
            }
        },
        /*
			内部函数
			监听是否是缓冲状态
		*/
        bufferEdHandler: function() {
            if(!this.showFace) {
                return;
            }
            var thisTemp = this;
            var clearTimerBuffer = function() {
                if(thisTemp.timerBuffer != null) {
                    if(thisTemp.timerBuffer.runing) {
                        thisTemp.sendJS('buffer', 100);
                        thisTemp.timerBuffer.stop();
                    }
                    thisTemp.timerBuffer = null;
                }
            };
            clearTimerBuffer();
            var bufferFun = function() {
                if(thisTemp.V.buffered.length > 0) {
                    var duration = thisTemp.V.duration;
                    var len = thisTemp.V.buffered.length;
                    var bufferStart = thisTemp.V.buffered.start(len - 1);
                    var bufferEnd = thisTemp.V.buffered.end(len - 1);
                    var loadTime = bufferStart + bufferEnd;
                    var loadProgressBgW = thisTemp.CB['timeProgressBg'].offsetWidth;
                    var timeButtonW = thisTemp.CB['timeButton'].offsetWidth;
                    var loadW = parseInt((loadTime * loadProgressBgW / duration) + timeButtonW);
                    if(loadW >= loadProgressBgW) {
                        loadW = loadProgressBgW;
                        clearTimerBuffer();
                    }
                    thisTemp.changeLoad(loadTime);
                }
            };
            this.timerBuffer = new this.timer(200, bufferFun);
        },
        /*
			内部函数
			单独计算加载进度
		*/
        changeLoad: function(loadTime) {
            if(this.V == null) {
                return;
            }
            if(!this.showFace) {
                return;
            }
            var loadProgressBgW = this.CB['timeProgressBg'].offsetWidth;
            var timeButtonW = this.CB['timeButton'].offsetWidth;
            var duration = this.V.duration;
            if(this.isUndefined(loadTime)) {
                loadTime = this.loadTime;
            } else {
                this.loadTime = loadTime;
            }
            var loadW = parseInt((loadTime * loadProgressBgW / duration) + timeButtonW);
            this.css(this.CB['loadProgress'], 'width', loadW + 'px');
        },
        /*
			内部函数
			判断是否是直播
		*/
        judgeIsLive: function() {
            var thisTemp = this;
            if(this.timerError != null) {
                if(this.timerError.runing) {
                    this.timerError.stop();
                }
                this.timerError = null;
            }
            this.error = false;
            if(this.showFace) {
                this.css(this.CB['errorText'], 'display', 'none');
            }
            var timeupdate = function(event) {
                thisTemp.timeUpdateHandler();
            };
            if(!this.vars['live']) {
                if(this.V != null && this.playerType == 'html5video') {
                    this.addListenerInside('timeupdate', timeupdate);
                    thisTemp.timeTextHandler();
                    thisTemp.prompt(); //添加提示点
                    window.setTimeout(function() {
                        thisTemp.bufferEdHandler();
                    }, 200);
                }
            } else {
                this.removeListenerInside('timeupdate', timeupdate);
                if(this.timerTime != null) {
                    window.clearInterval(this.timerTime);
                    timerTime = null;
                }
                if(this.timerTime != null) {
                    if(this.timerTime.runing) {
                        this.timerTime.stop();
                    }
                    this.timerTime = null;
                }
                var timeFun = function() {
                    if(thisTemp.V != null && !thisTemp.V.paused && thisTemp.showFace) {
                        thisTemp.CB['timeText'].innerHTML = thisTemp.getNowDate();
                    }
                };
                this.timerTime = new this.timer(1000, timeFun);
                //timerTime.start();
            }
            this.definition();
        },
        /*
			内部函数
			加载字幕
		*/
        loadTrack: function() {
            if(this.playerType == 'flashplayer' || this.vars['flashplayer'] == true) {
                return;
            }
            var thisTemp = this;
            var track = this.vars['cktrack'];
            var obj = {
                method: 'get',
                dataType: 'text',
                url: track,
                charset: 'utf-8',
                success: function(data) {
                    thisTemp.track = thisTemp.parseSrtSubtitles(data);
                    thisTemp.trackIndex = 0;
                    thisTemp.nowTrackShow = {
                        sn: ''
                    };
                }
            };
            this.ajax(obj);
        },
        /*
			内部函数
			重置字幕
		*/
        resetTrack: function() {
            this.trackIndex = 0;
            this.nowTrackShow = {
                sn: ''
            };
        },
        /*
			内部函数
			根据时间改变读取显示字幕
		*/
        trackShowHandler: function() {
            if(!this.showFace) {
                return;
            }
            if(this.track.length < 1) {
                return;
            }
            if(this.trackIndex >= this.track.length) {
                this.trackIndex = 0;
            }
            var nowTrack = this.track[this.trackIndex]; //当前编号对应的字幕内容
            /*
				this.nowTrackShow=当前显示在界面上的内容
				如果当前时间正好在nowTrack时间内，则需要判断
			*/
            if(this.time >= nowTrack['startTime'] && this.time <= nowTrack['endTime']) {
                /*
				 	如果当前显示的内容不等于当前需要显示的内容时，则需要显示正确的内容
				*/
                var nowShow = this.nowTrackShow;
                if(nowShow['sn'] != nowTrack['sn']) {
                    this.trackHide();
                    this.trackShow(nowTrack);
                }
            } else {
                /*
				 * 如果当前播放时间不在当前编号字幕内，则需要先清空当前的字幕内容，再显示新的字幕内容
				 */
                this.trackHide();
                this.checkTrack();
            }
        },
        /*
			内部函数
			显示字幕内容
		*/
        trackShow: function(track) {
            this.nowTrackShow = track;
            var arr = track['content'];
            for(var i = 0; i < arr.length; i++) {
                var obj = {
                    list: [{
                        type: 'text',
                        text: arr[i],
                        color: '#FFFFFF',
                        size: 16,
                        font: this.fontFamily,
                        lineHeight: 30
                    }],
                    position: [1, 2, null, -(arr.length - i) * 30 - 50]
                };
                var ele = this.addElement(obj);
                this.trackElement.push(ele);
            }
        },
        /*
			内部函数
			隐藏字字幕内容
		*/
        trackHide: function() {
            for(var i = 0; i < this.trackElement.length; i++) {
                this.deleteElement(this.trackElement[i]);
            }
            this.trackElement = [];
        },
        /*
			内部函数
			重新计算字幕的编号
		*/
        checkTrack: function() {
            var num = this.trackIndex;
            var arr = this.track;
            var i = 0;
            for(i = num; i < arr.length; i++) {
                if(this.time >= arr[i]['startTime'] && this.time <= arr[i]['endTime']) {
                    this.trackIndex = i;
                    break;
                }
            }
        },
        /*
		-----------------------------------------------------------------------------接口函数开始
			接口函数
			在播放和暂停之间切换
		*/
        playOrPause: function() {
            if(!this.loaded) {
                return;
            }
            if(this.config['videoClick']) {
                if(this.V == null) {
                    return;
                }
                if(this.playerType == 'flashplayer') {
                    this.V.playOrPause();
                    return;
                }
                if(this.V.paused) {
                    this.videoPlay();
                } else {
                    this.videoPause();
                }
            }
        },
        /*
			接口函数
			播放动作
		*/
        videoPlay: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoPlay();
                return;
            }
            this.V.play();
        },
        /*
			接口函数
			暂停动作
		*/
        videoPause: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoPause();
                return;
            }
            this.V.pause();
        },
        /*
			接口函数
			跳转时间动作
		*/
        videoSeek: function(time) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoSeek(time);
                return;
            }
            var meta = this.getMetaDate();
            var duration = meta['duration'];
            if(duration > 0 && time > duration) {
                time = duration;
            }
            if(time>=0){
                this.V.currentTime = time;
                this.sendJS('seekTime', time);
            }
        },
        /*
			接口函数
			调节音量/获取音量
		*/
        changeVolume: function(vol, bg, button) {
            if(this.loaded) {
                if(this.playerType == 'flashplayer') {
                    this.V.changeVolume(time);
                    return;
                }
            }
            if(isNaN(vol) || this.isUndefined(vol)) {
                vol = 0;
            }
            if(!this.loaded) {
                this.vars['volume'] = vol;
            }
            if(!this.html5Video) {
                this.V.changeVolume(vol);
                return;
            }
            try {
                if(this.isUndefined(bg)) {
                    bg = true;
                }
            } catch(e) {}
            try {
                if(this.isUndefined(button)) {
                    button = true;
                }
            } catch(e) {}
            if(!vol) {
                vol = 0;
            }
            if(vol < 0) {
                vol = 0;
            }
            if(vol > 1) {
                vol = 1;
            }
            try {
                this.V.volume = vol;
            } catch(error) {}
            this.volume = vol;
            if(bg && this.showFace) {
                var bgW = vol * this.CB['volumeBg'].offsetWidth;
                if(bgW < 0) {
                    bgW = 0;
                }
                if(bgW > this.CB['volumeBg'].offsetWidth) {
                    bgW = this.CB['volumeBg'].offsetWidth;
                }
                this.css(this.CB['volumeUp'], 'width', bgW + 'px');
            }

            if(button && this.showFace) {
                var buLeft = parseInt(this.CB['volumeUp'].offsetWidth - (this.CB['volumeBO'].offsetWidth * 0.5));
                if(buLeft > this.CB['volumeBg'].offsetWidth - this.CB['volumeBO'].offsetWidth) {
                    buLeft = this.CB['volumeBg'].offsetWidth - this.CB['volumeBO'].offsetWidth
                }
                if(buLeft < 0) {
                    buLeft = 0;
                }
                this.css(this.CB['volumeBO'], 'left', buLeft + 'px');
            }
        },
        /*
			接口函数
			静音
		*/
        videoMute: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoMute();
                return;
            }
            this.volumeTemp = this.V ? (this.V.volume > 0 ? this.V.volume : this.vars['volume']) : this.vars['volume'];
            this.changeVolume(0);
        },
        /*
			接口函数
			取消静音
		*/
        videoEscMute: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoEscMute();
                return;
            }
            this.changeVolume(this.volumeTemp > 0 ? this.volumeTemp : this.vars['volume']);
        },
        /*
			接口函数
			快退
		*/
        fastBack: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.fastBack();
                return;
            }
            var time = this.time - this.ckplayerConfig['config']['timeJump'];
            if(time < 0) {
                time = 0;
            }
            this.videoSeek(time);
        },
        /*
			接口函数
			快进
		*/
        fastNext: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.fastNext();
                return;
            }
            var time = this.time + this.ckplayerConfig['config']['timeJump'];
            if(time > this.V.duration) {
                time = this.V.duration;
            }
            this.videoSeek(time);
        },

        /*
			内置函数
			全屏/退出全屏动作，该动作只能是用户操作才可以触发，比如用户点击按钮触发该事件
		*/
        switchFull: function() {
            if(this.full) {
                this.quitFullScreen();
            } else {
                this.fullScreen();
            }
        },
        /*
			内置函数
			全屏动作，该动作只能是用户操作才可以触发，比如用户点击按钮触发该事件
		*/
        fullScreen: function() {
            if(this.html5Video && this.playerType == 'html5video') {
                var element = this.PD;
                if(element.requestFullscreen) {
                    element.requestFullscreen();
                } else if(element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if(element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if(element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                } else if(element.oRequestFullscreen) {
                    element.oRequestFullscreen();
                }
                this.judgeFullScreen();
            } else {
                //this.V.fullScreen();
            }
        },
        /*
			接口函数
			退出全屏动作
		*/
        quitFullScreen: function() {
            if(this.html5Video && this.playerType == 'html5video') {
                if(document.exitFullscreen) {
                    document.exitFullscreen();
                } else if(document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if(document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if(document.oRequestFullscreen) {
                    document.oCancelFullScreen();
                } else if(document.requestFullscreen) {
                    document.requestFullscreen();
                } else if(document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else {
                    this.css(document.documentElement, 'cssText', '');
                    this.css(document.document.body, 'cssText', '');
                    this.css(this.PD, 'cssText', '');
                }
                this.judgeFullScreen();
            }
        },
        /*
		 下面列出只有flashplayer里支持的
		 */
        videoRotation: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoRotation(n);
                return;
            }
            if(this.isUndefined(n)) {
                n = 0;
            }
            var tf = this.css(this.V, 'transform');
            if(this.isUndefined(tf) && !tf) {
                tf = 'rotate(0deg)';
            }
            var reg = tf.match(/rotate\([^)]+\)/);
            reg = reg ? reg[0].replace('rotate(', '').replace('deg)', '') : '';
            if(reg == '') {
                reg = 0;
            } else {
                reg = parseInt(reg);
            }
            if(n == -1) {
                reg -= 90;
            } else if(n == 1) {
                reg += 90;
            } else {
                if(n != 90 && n != 180 && n != 270 && n != -90 && n != -180 && n != -270) {
                    reg = 0;
                } else {
                    reg = n;
                }
            }
            n = reg;
            tf = tf.replace(/rotate\([^)]+\)/, '') + ' rotate(' + n + 'deg)';
            this.css(this.V, 'transform', tf);
            return;
        },
        videoBrightness: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoBrightness(n);
                return;
            }
        },
        videoContrast: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoContrast(n);
                return;
            }
        },
        videoSaturation: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoSaturation(n);
                return;
            }
        },
        videoHue: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoHue(n);
                return;
            }
        },
        videoZoom: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoZoom(n);
                return;
            }
            if(this.isUndefined(n)) {
                n = 1;
            }
            if(n < 0) {
                n = 0;
            }
            if(n > 2) {
                n = 2;
            }
            var tf = this.css(this.V, 'transform');
            tf = tf.replace(/scale\([^)]+\)/, '') + ' scale(' + n + ')';
            this.css(this.V, 'transform', tf);
            return;
        },
        videoProportion: function(w, h) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoProportion(w, h);
                return;
            }
        },
        adPlay: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.adPlay();
                return;
            }
        },
        adPause: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.adPause();
                return;
            }
        },
        videoError: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoError(n);
                return;
            }
        },
        changeConfig: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.changeConfig(arguments);
                return;
            }
        },
        custom: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.custom(arguments);
                return;
            }
        },
        getConfig: function() {
            if(!this.loaded) {
                return null;
            }
            if(this.playerType == 'flashplayer') {
                return this.V.getConfig(arguments);
            }
        },
        openUrl: function(n) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.openUrl(n);
                return;
            }
        },
        /*
			接口函数
			清除视频
		*/
        videoClear: function() {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.videoClear();
                return;
            }
        },
        /*
			接口函数
			向播放器传递新的视频地址
		*/
        newVideo: function(c) {
            if(this.playerType == 'flashplayer') {
                this.V.newVideo(c);
                return;
            } else {
                this.embed(c);
            }
        },
        /*
			接口函数
			截图
		*/
        screenshot: function(obj, save, name) {
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                try{
                    this.V.screenshot(obj, save, name);
                }catch(error) {
                    this.log(error);
                }
                return;
            }
            if(obj == 'video') {
                var newCanvas = document.createElement('canvas');
                newCanvas.width = this.V.videoWidth;
                newCanvas.height = this.V.videoHeight;
                newCanvas.getContext('2d').drawImage(this.V, 0, 0, this.V.videoWidth, this.V.videoHeight);
                try {
                    var base64 = newCanvas.toDataURL('image/jpeg');
                    this.sendJS('screenshot', {
                        object: obj,
                        save: save,
                        name: name,
                        base64: base64
                    });
                } catch(error) {
                    this.log(error);
                }
            }
        },
        /*
			接口函数
			改变播放器尺寸
		*/
        changeSize: function(w, h) {
            if(this.isUndefined(w)) {
                w = 0;
            }
            if(this.isUndefined(h)) {
                h = 0;
            }
            if(w > 0) {
                this.css(this.CD, 'width', w + 'px');
            }
            if(h > 0) {
                this.css(this.CD, 'height', h + 'px');
            }
            if(this.html5Video) {
                this.elementCoordinate();
            }
        },
        /*
			接口函数
			改变视频播放速度
		*/
        changePlaybackRate: function(n) {
            if(this.html5Video) {
                var arr=this.playbackRateArr;
                n=parseInt(n);
                if(n<arr.length){
                    this.newPlaybackrate(arr[n][1]);
                }
            }
        },
        /*
			内部函数
			注册控制控制栏显示与隐藏函数
		*/
        changeControlBarShow:function(show){
            if(!this.loaded) {
                return;
            }
            if(this.playerType == 'flashplayer') {
                this.V.changeControlBarShow(show);
                return;
            }
            if(show){
                this.controlBarIsShow=true;
                this.controlBarHide(false);
            }
            else{
                this.controlBarIsShow=false;
                this.controlBarHide(true);
            }
        },
        /*
			-----------------------------------------------------------------------
			调用flashplayer
		*/
        embedSWF: function() {
            var vid = this.randomString();
            var flashvars = this.getFlashVars();
            var param = this.getFlashplayerParam();
            var flashplayerUrl = 'http://www.macromedia.com/go/getflashplayer';
            var html = '',
                src = javascriptPath + 'ckplayer.swf';
            id = 'id="' + vid + '" name="' + vid + '" ';
            html += '<object pluginspage="' + flashplayerUrl + '" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=11,3,0,0" width="100%" height="100%" ' + id + ' align="middle">';
            html += param['v'];
            html += '<param name="movie" value="' + src + '">';
            html += '<param name="flashvars" value="' + flashvars + '">';
            html += '<embed ' + param['w'] + ' src="' + src + '" flashvars="' + flashvars + '" width="100%" height="100%" ' + id + ' align="middle" type="application/x-shockwave-flash" pluginspage="' + flashplayerUrl + '" />';
            html += '</object>';
            this.PD.innerHTML = html;
            this.V = this.getObjectById(vid); //V：定义播放器对象全局变量
            this.playerType = 'flashplayer';
            //this.loaded=true;
        },
        /*
			内置函数
			将vars对象转换成字符
		*/
        getFlashVars: function() {
            this.getVarsObject();
            var v = this.vars;
            var z = '';
            for(k in v) {
                if(k != 'flashplayer' && k != 'container' && v[k] != '') {
                    if(z != '') {
                        z += '&';
                    }
                    var vk = v[k];
                    if(vk == true) {
                        vk = 1;
                    }
                    if(vk == false) {
                        vk = 0;
                    }
                    z += k + '=' + vk;
                }

            }
            if(!v.hasOwnProperty('volume') || !v['volume']){
                if(z != '') {
                    z += '&';
                }
                z+='volume=0';
            }
            return z;
        },
        /*
			内置函数
			将vars格式化成flash能接受的对象。再由getFlashVars函数转化成字符串或由newVideo直接使用
		*/
        getVarsObject: function() {
            var v = this.vars;
            var f = '',
                d = '',
                w = ''; //f=视频地址，d=清晰度地址,w=权重，z=最终地址
            var arr = this.VA;
            var prompt = v['promptSpot'];
            var i = 0;
            var video = this.vars['video'];
            if(typeof(video) == 'object') { //对象或数组
                if(!this.isUndefined(typeof(video.length))) { //说明是数组
                    var arr = video;
                    for(i = 0; i < arr.length; i++) {
                        var arr2 = arr[i];
                        if(arr2) {
                            if(f != '') {
                                f += this.ckplayerConfig['config']['split'];
                                d += ',';
                                w += ',';
                            }
                            f += encodeURIComponent(decodeURIComponent(arr2[0]));
                            d += arr2[2];
                            w += arr2[3];
                        }
                    }
                } else {
                    f = encodeURIComponent(decodeURIComponent(video['file']));
                    if(!this.isUndefined(video['type'])) {
                        v['type'] = video['type']
                    }
                    d = '';
                    w = '';
                }
            } else {
                f = encodeURIComponent(decodeURIComponent(video));
            }
            if(v['preview'] != null) {
                v['previewscale'] = v['preview']['scale'];
                v['preview'] = v['preview']['file'].join(',');

            }
            if(prompt != null) {
                v['promptspot'] = '';
                v['promptspottime'] = '';
                for(i = 0; i < prompt.length; i++) {
                    if(v['promptspot'] != '') {
                        v['promptspot'] += ',';
                        v['promptspottime'] += ',';
                    }
                    v['promptspot'] += prompt[i]['words'];
                    v['promptspottime'] += prompt[i]['time'];
                }

            }
            if(f != '') {
                v['video'] = f;
                v['definition'] = d;
                v['weight'] = w;
            }
            if(!v['volume']){
                v['volume']=0;
            }
            var newV = {};
            for(var k in v) {
                if(v[k] != null) {
                    newV[k] = v[k];
                }
                if(k=='type'){
                    newV[k] = v[k].replace('video/m3u8','m3u8');
                }
            }

            this.vars = newV;
        },
        /*
			内置函数
			将embedSWF里的param的对象进行转换
		*/
        getFlashplayerParam: function() {
            var w = '',
                v = '',
                o = {
                    allowScriptAccess: 'always',
                    allowFullScreen: true,
                    quality: 'high',
                    bgcolor: '#000'
                };
            for(var e in o) {
                w += e + '="' + o[e] + '" ';
                v += '<param name="' + e + '" value="' + o[e] + '" />';
            }
            w = w.replace('movie=', 'src=');
            return {
                w: w,
                v: v
            };
        },

        /*
			操作动作结束
			-----------------------------------------------------------------------

			接口函数
			获取元数据部分
		*/
        getMetaDate: function() {
            if(!this.loaded || this.V == null) {
                return false;
            }
            if(this.playerType == 'html5video') {
                var duration = 0;
                try {
                    duration = !isNaN(this.V.duration) ? this.V.duration : 0;
                } catch(event) {}
                var data = {
                    duration: duration,
                    volume: this.V.volume,
                    playbackRate: this.V.playbackRate,
                    width: this.PD.offsetWidth || this.V.offsetWidth || this.V.width,
                    height: this.PD.offsetHeight || this.V.offsetHeight || this.V.height,
                    streamWidth: this.V.videoWidth,
                    streamHeight: this.V.videoHeight,
                    videoWidth: this.V.offsetWidth,
                    videoHeight: this.V.offsetHeight,
                    paused: this.V.paused
                };
                return data;
            } else {
                return this.V.getMetaDate();
            }
            return false;
        },
        /*
			接口函数
			取当前提供给播放器播放的视频列表
		*/
        getVideoUrl: function() {
            var arr = [];
            if(this.V.src) {
                arr.push(this.V.src);
            } else {
                var uArr = this.V.childNodes;
                for(var i = 0; i < uArr.length; i++) {
                    arr.push(uArr[i].src);
                }
            }
            return arr;
        },
        /*
			内置函数
			格式化函数
		*/
        clickEvent: function(call) {
            if(call == "none" || call == "" || call == null) {
                return {
                    type: 'none'
                };
            }
            var callArr = call.split("->");
            var type = '',
                fun = '',
                link = '',
                target = '';
            if(callArr.length == 2) {
                var callM = callArr[0];
                var callE = callArr[1];
                if(!callE) {
                    return {
                        type: 'none'
                    };
                }
                var val = '';
                var eArr = [];
                type = callM;
                switch(callM) {
                    case 'actionScript':
                        //trace(THIS.hasOwnProperty(callE));

                        if(callE.indexOf('(') > -1) {
                            eArr = callE.split('(');
                            callE = eArr[0];
                            val = eArr[1].replace(')', '');
                        }
                        if(val == '') {
                            fun = 'thisTemp.' + callE + '()';
                        } else {
                            fun = 'thisTemp.' + callE + '(' + val + ')';
                        }
                        break;
                    case 'javaScript':
                        if(callE.substr(0, 11) == '[flashvars]') {
                            callE = callE.substr(11);
                            if(this.vars.hasOwnProperty(callE)) {
                                callE = this.vars[callE];
                            } else {
                                break;
                            }

                        }
                        if(callE.indexOf('(') > -1) {
                            eArr = callE.split('(');
                            callE = eArr[0];
                            val = eArr[1].replace(')', '');
                        }
                        if(val == '') {
                            fun = callE + '()';
                        } else {
                            fun = callE + '(' + val + ')';
                        }
                        break;
                    case "link":
                        var callLink = (callE + ',').split(',');
                        if(callLink[0].substr(0, 11) == '[flashvars]') {
                            var fl = callLink[0].replace('[flashvars]', '');
                            if(this.vars.hasOwnProperty(fl)) {
                                callLink[0] = this.vars[fl];
                            } else {
                                break;
                            }
                        }
                        if(!callLink[1]) {
                            callLink[1] = '_blank';
                        }
                        link = callLink[0];
                        target = callLink[1];
                        break;
                }
            }
            return {
                type: type,
                fun: fun,
                link: link,
                target: target
            }
        },
        /*
			内置函数
			向播放器界面添加一个文本
		*/
        addElement: function(attribute) {
            var thisTemp = this;
            if(this.playerType == 'flashplayer') {
                return this.V.addElement(attribute);
            }
            var i = 0;
            var obj = {
                list: null,
                x: '100%',
                y: "50%",
                position: null,
                alpha: 1,
                backgroundColor: '',
                backAlpha: 1,
                backRadius: 0,
                clickEvent: ''
            };
            obj = this.standardization(obj, attribute);
            var list = obj['list'];
            if(list == null) {
                return '';
            }
            var id = 'element' + this.randomString(10);
            var ele = document.createElement('div');
            ele.className = id;
            if(obj['x']) {
                ele.setAttribute('data-x', obj['x']);
            }
            if(obj['y']) {
                ele.setAttribute('data-y', obj['y']);
            }
            if(obj['position'] != null) {
                ele.setAttribute('data-position', obj['position'].join(','));
            }

            this.PD.appendChild(ele);
            var eid = this.getByElement(id);
            this.css(eid, {
                position: 'absolute',
                filter: 'alpha(opacity:' + obj['alpha'] + ')',
                opacity: obj['alpha'].toString(),
                width: '800px',
                zIndex: '20'
            });
            var bgid = 'elementbg' + this.randomString(10);
            var bgAlpha = obj['alpha'].toString();
            var bgColor = obj['backgroundColor'].replace('0x', '#');
            var html = '';
            var idArr = [];
            var clickArr = [];
            if(!this.isUndefined(list) && list.length > 0) {
                var textObj, returnObj, clickEvent;
                for(i = 0; i < list.length; i++) {
                    var newEleid = 'elementnew' + this.randomString(10);
                    switch(list[i]['type']) {
                        case 'image':
                        case 'png':
                        case 'jpg':
                        case 'jpeg':
                        case 'gif':
                            textObj = {
                                type: 'image',
                                file: '',
                                radius: 0, //圆角弧度
                                width: 30, //定义宽，必需要定义
                                height: 30, //定义高，必需要定义
                                alpha: 1, //透明度
                                paddingLeft: 0, //左边距离
                                paddingRight: 0, //右边距离
                                paddingTop: 0,
                                paddingBottom: 0,
                                marginLeft: 0,
                                marginRight: 0,
                                marginTop: 0,
                                marginBottom: 0,
                                backgroundColor: '',
                                clickEvent: ''
                            };

                            list[i] = this.standardization(textObj, list[i]);
                            clickEvent = this.clickEvent(list[i]['clickEvent']);
                            clickArr.push(clickEvent);
                            if(clickEvent['type'] == 'link') {
                                html += '<div class="' + newEleid + '" data-i="' + i + '"><a href="' + clickEvent['link'] + '" target="' + clickEvent['target'] + '"><img class="' + newEleid + '_image" src="' + list[i]['file'] + '" style="border:0;"></a></div>';
                            } else {
                                html += '<div class="' + newEleid + '" data-i="' + i + '"><img class="' + newEleid + '_image" src="' + list[i]['file'] + '" style="border:0;"></div>';
                            }
                            break;
                        case 'text':
                            textObj = {
                                type: 'text', //说明是文本
                                text: '', //文本内容
                                color: '0xFFFFFF',
                                size: 14,
                                font: this.fontFamily,
                                leading: 0,
                                alpha: 1, //透明度
                                paddingLeft: 0, //左边距离
                                paddingRight: 0, //右边距离
                                paddingTop: 0,
                                paddingBottom: 0,
                                marginLeft: 0,
                                marginRight: 0,
                                marginTop: 0,
                                marginBottom: 0,
                                backgroundColor: '',
                                backAlpha: 1,
                                backRadius: 0, //背景圆角弧度，支持数字统一设置，也支持分开设置[30,20,20,50]，对应上左，上右，下右，下左
                                clickEvent: ''
                            };
                            list[i] = this.standardization(textObj, list[i]);
                            clickEvent = this.clickEvent(list[i]['clickEvent']);
                            clickArr.push(clickEvent);
                            if(clickEvent['type'] == 'link') {
                                html += '<div class="' + newEleid + '" data-i="' + i + '"><div class="' + newEleid + '_bg"></div><div class="' + newEleid + '_text"><a href="' + clickEvent['link'] + '" target="' + clickEvent['target'] + '">' + list[i]['text'] + '</a></div></div>';
                            } else {
                                html += '<div  class="' + newEleid + '" data-i="' + i + '"><div class="' + newEleid + '_bg"></div><div class="' + newEleid + '_text">' + list[i]['text'] + '</div></div>';
                            }
                            break;
                        default:
                            break;
                    }
                    idArr.push(newEleid);
                }
            }
            var objClickEvent = this.clickEvent(obj['clickEvent']);
            /*if(objClickEvent['type']=='link'){
				html = '<a href="'+objClickEvent['link']+'" target="'+objClickEvent['target']+'">' + html + '</a>';
			}*/
            eid.innerHTML = '<div class="' + bgid + '"></div><div class="' + bgid + '_c">' + html + '</div>';
            if(objClickEvent['type'] == 'javaScript' || objClickEvent['type'] == 'actionScript') {
                var objClickHandler = function() {
                    eval(objClickEvent['fun']);
                };
                this.addListenerInside('click', objClickHandler, this.getByElement(bgid + '_c'))
            }
            this.css(bgid + '_c', {
                position: 'absolute',
                zIndex: '2'
            });
            for(i = 0; i < idArr.length; i++) {
                var clk = clickArr[i];

                if(clk['type'] == 'javaScript' || clk['type'] == 'actionScript') {
                    var clickHandler = function() {
                        clk = clickArr[this.getAttribute('data-i')];
                        eval(clk['fun']);
                    };
                    this.addListenerInside('click', clickHandler, this.getByElement(idArr[i]))
                }
                switch(list[i]['type']) {
                    case 'image':
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'gif':
                        this.css(idArr[i], {
                            float: 'left',
                            width: list[i]['width'] + 'px',
                            height: list[i]['height'] + 'px',
                            filter: 'alpha(opacity:' + list[i]['alpha'] + ')',
                            opacity: list[i]['alpha'].toString(),
                            marginLeft: list[i]['marginLeft'] + 'px',
                            marginRight: list[i]['marginRight'] + 'px',
                            marginTop: list[i]['marginTop'] + 'px',
                            marginBottom: list[i]['marginBottom'] + 'px',
                            borderRadius: list[i]['radius'] + 'px',
                            cursor: 'pointer'
                        });
                        this.css(idArr[i] + '_image', {
                            width: list[i]['width'] + 'px',
                            height: list[i]['height'] + 'px',
                            borderRadius: list[i]['radius'] + 'px'
                        });
                        break;
                    case 'text':
                        this.css(idArr[i] + '_text', {
                            filter: 'alpha(opacity:' + list[i]['alpha'] + ')',
                            opacity: list[i]['alpha'].toString(),
                            borderRadius: list[i]['radius'] + 'px',
                            fontFamily: list[i]['font'],
                            fontSize: list[i]['size'] + 'px',
                            color: list[i]['color'].replace('0x', '#'),
                            lineHeight: list[i]['leading'] > 0 ? list[i]['leading'] + 'px' : '',
                            paddingLeft: list[i]['paddingLeft'] + 'px',
                            paddingRight: list[i]['paddingRight'] + 'px',
                            paddingTop: list[i]['paddingTop'] + 'px',
                            paddingBottom: list[i]['paddingBottom'] + 'px',
                            whiteSpace: 'nowrap',
                            position: 'absolute',
                            zIndex: '3',
                            cursor: 'pointer'
                        });
                        this.css(idArr[i], {
                            float: 'left',
                            width: this.getByElement(idArr[i] + '_text').offsetWidth + 'px',
                            height: this.getByElement(idArr[i] + '_text').offsetHeight + 'px',
                            marginLeft: list[i]['marginLeft'] + 'px',
                            marginRight: list[i]['marginRight'] + 'px',
                            marginTop: list[i]['marginTop'] + 'px',
                            marginBottom: list[i]['marginBottom'] + 'px'
                        });
                        this.css(idArr[i] + '_bg', {
                            width: this.getByElement(idArr[i] + '_text').offsetWidth + 'px',
                            height: this.getByElement(idArr[i] + '_text').offsetHeight + 'px',
                            filter: 'alpha(opacity:' + list[i]['backAlpha'] + ')',
                            opacity: list[i]['backAlpha'].toString(),
                            borderRadius: list[i]['backRadius'] + 'px',
                            backgroundColor: list[i]['backgroundColor'].replace('0x', '#'),
                            position: 'absolute',
                            zIndex: '2'
                        });
                        break;
                    default:
                        break;
                }
            }
            this.css(bgid, {
                width: this.getByElement(bgid + '_c').offsetWidth + 'px',
                height: this.getByElement(bgid + '_c').offsetHeight + 'px',
                position: 'absolute',
                filter: 'alpha(opacity:' + bgAlpha + ')',
                opacity: bgAlpha,
                backgroundColor: bgColor.replace('0x', '#'),
                borderRadius: obj['backRadius'] + 'px',
                zIndex: '1'
            });
            this.css(eid, {
                width: this.getByElement(bgid).offsetWidth + 'px',
                height: this.getByElement(bgid).offsetHeight + 'px'
            });
            var eidCoor = this.calculationCoor(eid);
            this.css(eid, {
                left: eidCoor['x'] + 'px',
                top: eidCoor['y'] + 'px'
            });

            this.elementArr.push(eid.className);
            return eid;
        },
        /*
			内置函数
			获取元件的属性，包括x,y,width,height,alpha
		*/
        getElement: function(element) {
            if(this.playerType == 'flashplayer') {
                return this.V.getElement(element);
            }
            var ele = element;
            if(typeof(element) == 'string') {
                ele = this.getByElement(element);
            }
            var coor = this.getCoor(ele);
            return {
                x: coor['x'],
                y: coor['y'],
                width: ele.offsetWidth,
                height: ele.offsetHeight,
                alpha: !this.isUndefined(this.css(ele, 'opacity')) ? parseFloat(this.css(ele, 'opacity')) : 1
            };
        },
        /*
			内置函数
			根据节点的x,y计算在播放器里的坐标
		*/
        calculationCoor: function(ele) {
            if(this.playerType == 'flashplayer') {
                return this.V.calculationCoor(ele);
            }
            if(ele == []) {
                return;
            }
            var x, y, position = [];
            var w = this.PD.offsetWidth,
                h = this.PD.offsetHeight;
            var ew = ele.offsetWidth,
                eh = ele.offsetHeight;
            if(!this.isUndefined(this.getDataset(ele, 'x'))) {
                x = this.getDataset(ele, 'x');
            }
            if(!this.isUndefined(this.getDataset(ele, 'y'))) {
                y = this.getDataset(ele, 'y');
            }
            if(!this.isUndefined(this.getDataset(ele, 'position'))) {
                position = this.getDataset(ele, 'position').split(',');
            }
            if(position.length > 0) {
                position.push(null, null, null, null);
                var i = 0;
                for(i = 0; i < position.length; i++) {
                    if(this.isUndefined(position[i]) || position[i] == null || position[i] == 'null' || position[i] == '') {
                        position[i] = null;
                    } else {
                        position[i] = parseFloat(position[i]);
                    }
                }

                if(position[2] == null) {
                    switch(position[0]) {
                        case 0:
                            x = 0;
                            break;
                        case 1:
                            x = parseInt((w - ew) * 0.5);
                            break;
                        default:
                            x = w - ew;
                            break;
                    }
                } else {
                    switch(position[0]) {
                        case 0:
                            x = position[2];
                            break;
                        case 1:
                            x = parseInt(w * 0.5) + position[2];
                            break;
                        default:
                            x = w + position[2];
                            break;
                    }
                }
                if(position[3] == null) {
                    switch(position[1]) {
                        case 0:
                            y = 0;
                            break;
                        case 1:
                            y = parseInt((h - eh) * 0.5);
                            break;
                        default:
                            y = h - eh;
                            break;
                    }
                } else {
                    switch(position[1]) {
                        case 0:
                            y = position[3];
                            break;
                        case 1:
                            y = parseInt(h * 0.5) + position[3];
                            break;
                        default:
                            y = h + position[3];
                            break;
                    }
                }
            } else {
                if(x.substring(x.length - 1, x.length) == '%') {
                    x = Math.floor(parseInt(x.substring(0, x.length - 1)) * w * 0.01);
                }
                if(y.substring(y.length - 1, y.length) == '%') {
                    y = Math.floor(parseInt(y.substring(0, y.length - 1)) * h * 0.01);
                }
            }
            return {
                x: x,
                y: y
            }

        },
        /*
			内置函数
			修改新增元件的坐标
		*/
        changeElementCoor: function() {
            for(var i = 0; i < this.elementArr.length; i++) {
                if(this.getByElement(this.elementArr[i]) != []) {
                    var c = this.calculationCoor(this.getByElement(this.elementArr[i]));
                    this.css(this.elementArr[i], {
                        top: c['y'] + 'px',
                        left: c['x'] + 'px'
                    });
                }
            }
        },
        /*
			内置函数
			缓动效果集
		*/
        tween: function() {
            var Tween = {
                None: { //均速运动
                    easeIn: function(t, b, c, d) {
                        return c * t / d + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return c * t / d + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        return c * t / d + b;
                    }
                },
                Quadratic: {
                    easeIn: function(t, b, c, d) {
                        return c * (t /= d) * t + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return -c * (t /= d) * (t - 2) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if((t /= d / 2) < 1) return c / 2 * t * t + b;
                        return -c / 2 * ((--t) * (t - 2) - 1) + b;
                    }
                },
                Cubic: {
                    easeIn: function(t, b, c, d) {
                        return c * (t /= d) * t * t + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return c * ((t = t / d - 1) * t * t + 1) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if((t /= d / 2) < 1) return c / 2 * t * t * t + b;
                        return c / 2 * ((t -= 2) * t * t + 2) + b;
                    }
                },
                Quartic: {
                    easeIn: function(t, b, c, d) {
                        return c * (t /= d) * t * t * t + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
                        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
                    }
                },
                Quintic: {
                    easeIn: function(t, b, c, d) {
                        return c * (t /= d) * t * t * t * t + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
                        return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
                    }
                },
                Sine: {
                    easeIn: function(t, b, c, d) {
                        return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return c * Math.sin(t / d * (Math.PI / 2)) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
                    }
                },
                Exponential: {
                    easeIn: function(t, b, c, d) {
                        return(t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return(t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if(t == 0) return b;
                        if(t == d) return b + c;
                        if((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
                        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
                    }
                },
                Circular: {
                    easeIn: function(t, b, c, d) {
                        return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
                    },
                    easeOut: function(t, b, c, d) {
                        return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
                    },
                    easeInOut: function(t, b, c, d) {
                        if((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
                        return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
                    }
                },
                Elastic: {
                    easeIn: function(t, b, c, d, a, p) {
                        if(t == 0) return b;
                        if((t /= d) == 1) return b + c;
                        if(!p) p = d * .3;
                        if(!a || a < Math.abs(c)) {
                            a = c;
                            var s = p / 4;
                        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
                        return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
                    },
                    easeOut: function(t, b, c, d, a, p) {
                        if(t == 0) return b;
                        if((t /= d) == 1) return b + c;
                        if(!p) p = d * .3;
                        if(!a || a < Math.abs(c)) {
                            a = c;
                            var s = p / 4;
                        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
                        return(a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b);
                    },
                    easeInOut: function(t, b, c, d, a, p) {
                        if(t == 0) return b;
                        if((t /= d / 2) == 2) return b + c;
                        if(!p) p = d * (.3 * 1.5);
                        if(!a || a < Math.abs(c)) {
                            a = c;
                            var s = p / 4;
                        } else var s = p / (2 * Math.PI) * Math.asin(c / a);
                        if(t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
                        return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
                    }
                },
                Back: {
                    easeIn: function(t, b, c, d, s) {
                        if(s == undefined) s = 1.70158;
                        return c * (t /= d) * t * ((s + 1) * t - s) + b;
                    },
                    easeOut: function(t, b, c, d, s) {
                        if(s == undefined) s = 1.70158;
                        return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
                    },
                    easeInOut: function(t, b, c, d, s) {
                        if(s == undefined) s = 1.70158;
                        if((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
                        return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
                    }
                },
                Bounce: {
                    easeIn: function(t, b, c, d) {
                        return c - Tween.Bounce.easeOut(d - t, 0, c, d) + b;
                    },
                    easeOut: function(t, b, c, d) {
                        if((t /= d) < (1 / 2.75)) {
                            return c * (7.5625 * t * t) + b;
                        } else if(t < (2 / 2.75)) {
                            return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
                        } else if(t < (2.5 / 2.75)) {
                            return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
                        } else {
                            return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
                        }
                    },
                    easeInOut: function(t, b, c, d) {
                        if(t < d / 2) return Tween.Bounce.easeIn(t * 2, 0, c, d) * .5 + b;
                        else return Tween.Bounce.easeOut(t * 2 - d, 0, c, d) * .5 + c * .5 + b;
                    }
                }
            };
            return Tween;
        },
        /*
			接口函数
			缓动效果
			ele:Object=需要缓动的对象,
			parameter:String=需要改变的属性：x,y,width,height,alpha,
			effect:String=效果名称,
			start:Int=起始值,
			end:Int=结束值,
			speed:Number=运动的总秒数，支持小数
		*/
        animate: function(attribute) {
            if(this.playerType == 'flashplayer') {
                return this.V.animate(attribute);
            }
            var thisTemp = this;
            var animateId = 'animate_' + this.randomString();
            var obj = {
                element: null,
                parameter: 'x',
                static: false,
                effect: 'None.easeIn',
                start: null,
                end: null,
                speed: 0,
                overStop: false,
                pauseStop: false, //暂停播放时缓动是否暂停
                callBack: null
            };
            obj = this.standardization(obj, attribute);
            if(obj['element'] == null || obj['speed'] == 0) {
                return false;
            }
            var w = this.PD.offsetWidth,
                h = this.PD.offsetHeight;
            var effArr = (obj['effect'] + '.').split('.');
            var tweenFun = this.tween()[effArr[0]][effArr[1]];
            var eleCoor = {
                x: 0,
                y: 0
            };
            if(this.isUndefined(tweenFun)) {
                return false;
            }
            //先将该元件从元件数组里删除，让其不再跟随播放器的尺寸改变而改变位置
            var def = this.arrIndexOf(this.elementArr, obj['element'].className);
            if(def > -1) {
                this.elementArr.splice(def, 1);
            }
            //var run = true;
            var css = {};
            //对传递的参数进行转化，x和y转化成left,top
            var pm = this.getElement(obj['element']); //包含x,y,width,height,alpha属性
            var t = 0; //当前时间
            var b = 0; //初始值
            var c = 0; //变化量
            var d = obj['speed'] * 1000; //持续时间
            var timerTween = null;
            var tweenObj = null;
            var start = obj['start'] == null ? '' : obj['start'].toString();
            var end = obj['end'] == null ? '' : obj['end'].toString();
            switch(obj['parameter']) {
                case 'x':
                    if(obj['start'] == null) {
                        b = pm['x'];
                    } else {
                        if(start.substring(start.length - 1, start.length) == '%') {
                            b = parseInt(start) * w * 0.01;
                        } else {
                            b = parseInt(start);
                        }

                    }
                    if(obj['end'] == null) {
                        c = pm['x'] - b;
                    } else {
                        if(end.substring(end.length - 1, end.length) == '%') {
                            c = parseInt(end) * w * 0.01 - b;
                        } else if(end.substring(0, 1) == '-' || end.substring(0, 1) == '+') {
                            if(typeof(obj['end']) == 'number') {
                                c = parseInt(obj['end']) - b;
                            } else {
                                c = parseInt(end);
                            }

                        } else {
                            c = parseInt(end) - b;
                        }
                    }
                    break;
                case 'y':
                    if(obj['start'] == null) {
                        b = pm['y'];
                    } else {
                        if(start.substring(start.length - 1, start.length) == '%') {
                            b = parseInt(start) * h * 0.01;
                        } else {
                            b = parseInt(start);
                        }

                    }
                    if(obj['end'] == null) {
                        c = pm['y'] - b;
                    } else {
                        if(end.substring(end.length - 1, end.length) == '%') {
                            c = parseInt(end) * h * 0.01 - b;
                        } else if(end.substring(0, 1) == '-' || end.substring(0, 1) == '+') {
                            if(typeof(obj['end']) == 'number') {
                                c = parseInt(obj['end']) - b;
                            } else {
                                c = parseInt(end);
                            }
                        } else {
                            c = parseInt(end) - b;
                        }
                    }
                    break;
                case 'alpha':
                    if(obj['start'] == null) {
                        b = pm['alpha'] * 100;
                    } else {
                        if(start.substring(start.length - 1, start.length) == '%') {
                            b = parseInt(obj['start']);
                        } else {
                            b = parseInt(obj['start'] * 100);
                        }

                    }
                    if(obj['end'] == null) {
                        c = pm['alpha'] * 100 - b;
                    } else {
                        if(end.substring(end.length - 1, end.length) == '%') {
                            c = parseInt(end) - b;
                        } else if(end.substring(0, 1) == '-' || end.substring(0, 1) == '+') {
                            if(typeof(obj['end']) == 'number') {
                                c = parseInt(obj['end']) * 100 - b;
                            } else {
                                c = parseInt(obj['end']) * 100;
                            }
                        } else {
                            c = parseInt(obj['end']) * 100 - b;
                        }
                    }
                    break;
            }
            var callBack = function() {
                var index = thisTemp.arrIndexOf(thisTemp.animateElementArray, animateId);
                if(index > -1) {
                    thisTemp.animateArray.splice(index, 1);
                    thisTemp.animateElementArray.splice(index, 1);
                }
                index = thisTemp.arrIndexOf(thisTemp.animatePauseArray, animateId);
                if(index > -1) {
                    thisTemp.animatePauseArray.splice(index, 1);
                }
                if(obj['callBack'] != null && obj['element'] && obj['callBack'] != 'callBack' && obj['callBack'] != 'tweenX' && obj['tweenY'] != 'callBack' && obj['callBack'] != 'tweenAlpha') {
                    var cb = eval(obj['callBack']);
                    cb(obj['element']);
                    obj['callBack'] = null;
                }
            };
            var stopTween = function() {
                if(timerTween != null) {
                    if(timerTween.runing) {
                        timerTween.stop();
                    }
                    timerTween = null;
                }
            };
            var tweenX = function() {
                if(t < d) {
                    t += 10;
                    css = {
                        left: Math.ceil(tweenFun(t, b, c, d)) + 'px'
                    };
                    if(obj['static']) {
                        eleCoor = thisTemp.calculationCoor(obj['element']);
                        css['top'] = eleCoor['y'] + 'px';
                    }
                    thisTemp.css(obj['element'], css);

                } else {
                    stopTween();
                    thisTemp.elementArr.push(obj['element'].className);
                    callBack();
                }
            };
            var tweenY = function() {
                if(t < d) {
                    t += 10;
                    css = {
                        top: Math.ceil(tweenFun(t, b, c, d)) + 'px'
                    };
                    if(obj['static']) {
                        eleCoor = thisTemp.calculationCoor(obj['element']);
                        css['left'] = eleCoor['x'] + 'px';
                    }
                    thisTemp.css(obj['element'], css);
                } else {
                    stopTween();
                    thisTemp.elementArr.push(obj['element'].className);
                    callBack();
                }
            };
            var tweenAlpha = function() {
                if(t < d) {
                    t += 10;
                    eleCoor = thisTemp.calculationCoor(obj['element']);
                    var ap = Math.ceil(tweenFun(t, b, c, d)) * 0.01;
                    css = {
                        filter: 'alpha(opacity:' + ap + ')',
                        opacity: ap.toString()
                    };
                    if(obj['static']) {
                        eleCoor = thisTemp.calculationCoor(obj['element']);
                        css['top'] = eleCoor['y'] + 'px';
                        css['left'] = eleCoor['x'] + 'px';
                    }
                    thisTemp.css(obj['element'], css);
                } else {
                    stopTween();
                    thisTemp.elementArr.push(obj['element'].className);
                    callBack();
                }
            };
            switch(obj['parameter']) {
                case 'x':
                    tweenObj = tweenX;
                    break;
                case 'y':
                    tweenObj = tweenY;
                    break;
                case 'alpha':
                    tweenObj = tweenAlpha;
                    break;
                default:
                    break;
            }
            timerTween = new thisTemp.timer(10, tweenObj);
            if(obj['overStop']) {
                var mouseOver = function() {
                    if(timerTween != null && timerTween.runing) {
                        timerTween.stop();
                    }
                };
                this.addListenerInside('mouseover', mouseOver, obj['element']);
                var mouseOut = function() {
                    var start = true;
                    if(obj['pauseStop'] && thisTemp.getMetaDate()['paused']) {
                        start = false;
                    }
                    if(timerTween != null && !timerTween.runing && start) {
                        timerTween.start();
                    }
                };
                this.addListenerInside('mouseout', mouseOut, obj['element']);
            }

            this.animateArray.push(timerTween);
            this.animateElementArray.push(animateId);
            if(obj['pauseStop']) {
                this.animatePauseArray.push(animateId);
            }
            return animateId;
        },
        /*
			接口函数函数
			继续运行animate
		*/
        animateResume: function(id) {
            if(this.playerType == 'flashplayer') {
                this.V.animateResume(this.isUndefined(id) ? '' : id);
                return;
            }
            var arr = [];
            if(id != '' && !this.isUndefined(id) && id != 'pause') {
                arr.push(id);
            } else {
                if(id === 'pause') {
                    arr = this.animatePauseArray;
                } else {
                    arr = this.animateElementArray;
                }
            }
            for(var i = 0; i < arr.length; i++) {
                var index = this.arrIndexOf(this.animateElementArray, arr[i]);
                if(index > -1) {
                    this.animateArray[index].start();
                }
            }

        },
        /*
			接口函数
			暂停运行animate
		*/
        animatePause: function(id) {
            if(this.playerType == 'flashplayer') {
                this.V.animatePause(this.isUndefined(id) ? '' : id);
                return;
            }
            var arr = [];
            if(id != '' && !this.isUndefined(id) && id != 'pause') {
                arr.push(id);
            } else {
                if(id === 'pause') {
                    arr = this.animatePauseArray;
                } else {
                    arr = this.animateElementArray;
                }
            }
            for(var i = 0; i < arr.length; i++) {
                var index = this.arrIndexOf(this.animateElementArray, arr[i]);
                if(index > -1) {
                    this.animateArray[index].stop();
                }
            }
        },
        /*
			内置函数
			根据ID删除数组里对应的内容
		*/
        deleteAnimate: function(id) {
            var index = this.arrIndexOf(this.animateElementArray, id);
            if(index > -1) {
                this.animateArray.splice(index, 1);
                this.animateElementArray.splice(index, 1);
            }
        },
        /*
			内置函数
			删除外部新建的元件
		*/
        deleteElement: function(ele) {
            if(this.playerType == 'flashplayer' && this.V) {
                try {
                    this.V.deleteElement(ele);
                } catch(event) {}
                return;
            }
            //先将该元件从元件数组里删除，让其不再跟随播放器的尺寸改变而改变位置
            var def = this.arrIndexOf(this.elementArr, ele.className);
            if(def > -1) {
                this.elementArr.splice(def, 1);
            }
            this.deleteAnimate(ele);
            this.deleteChild(ele);

        },
        /*
			--------------------------------------------------------------
			共用函数部分
			以下函数并非只能在本程序中使用，也可以在页面其它项目中使用
			根据ID获取元素对象
		*/
        getByElement: function(obj, parent) {
            if(this.isUndefined(parent)) {
                parent = document;
            }
            var num = obj.substr(0, 1);
            var res = [];
            if(num != '#') {
                if(num == '.') {
                    obj = obj.substr(1, obj.length);
                }
                if(parent.getElementsByClassName) {
                    res = parent.getElementsByClassName(obj);
                } else {
                    var reg = new RegExp(' ' + obj + ' ', 'i');
                    var ele = parent.getElementsByTagName('*');

                    for(var i = 0; i < ele.length; i++) {
                        if(reg.test(' ' + ele[i].className + ' ')) {
                            res.push(ele[i]);
                        }
                    }
                }

                if(res.length > 0) {
                    return res[0];
                } else {
                    return res;
                }
            } else {
                if(num == '#') {
                    obj = obj.substr(1, obj.length);
                }
                return document.getElementById(obj);
            }
        },
        /*
		 	共用函数
			功能：修改样式或获取指定样式的值，
				elem：ID对象或ID对应的字符，如果多个对象一起设置，则可以使用数组
				attribute：样式名称或对象，如果是对象，则省略掉value值
				value：attribute为样式名称时，定义的样式值
				示例一：
				this.css(ID,'width','100px');
				示例二：
				this.css('id','width','100px');
				示例三：
				this.css([ID1,ID2,ID3],'width','100px');
				示例四：
				this.css(ID,{
					width:'100px',
					height:'100px'
				});
				示例五(获取宽度)：
				var width=this.css(ID,'width');
		*/
        css: function(elem, attribute, value) {
            var i = 0;
            var k = '';
            if(typeof(elem) == 'object') { //对象或数组
                if(!this.isUndefined(typeof(elem.length))) { //说明是数组
                    for(i = 0; i < elem.length; i++) {
                        var el;
                        if(typeof(elem[i]) == 'string') {
                            el = this.getByElement(elem[i])
                        } else {
                            el = elem[i];
                        }
                        if(typeof(attribute) != 'object') {
                            if(!this.isUndefined(value)) {
                                el.style[attribute] = value;
                            }
                        } else {
                            for(k in attribute) {
                                if(!this.isUndefined(attribute[k])) {
                                    el.style[k] = attribute[k];
                                }
                            }
                        }
                    }
                    return;
                }

            }
            if(typeof(elem) == 'string') {
                elem = this.getByElement(elem);
            }

            if(typeof(attribute) != 'object') {
                if(!this.isUndefined(value)) {
                    elem.style[attribute] = value;
                } else {
                    if(!this.isUndefined(this.getStyle(elem,attribute))) {
                        return this.getStyle(elem,attribute);
                    } else {
                        return false;
                    }
                }
            } else {
                for(k in attribute) {
                    if(!this.isUndefined(attribute[k])) {
                        elem.style[k] = attribute[k];
                    }
                }
            }

        },
        /*
			内置函数
			兼容型获取style
		*/
        getStyle:function (obj, attr){
            if(!this.isUndefined(obj.style[attr])){
                return obj.style[attr];
            }
            else{
                if(obj.currentStyle){
                    return obj.currentStyle[attr];
                }
                else{
                    return getComputedStyle(obj, false)[attr];
                }
            }
        },
        /*
			共用函数
			判断变量是否存在或值是否为undefined
		*/
        isUndefined: function(value) {
            try {
                if(value == 'undefined' || value == undefined) {
                    return true;
                }
            } catch(event) {}
            return false;
        },
        /*
		 	共用函数
			外部监听函数
		*/
        addListener: function(name, funName) {
            if(name && funName) {
                if(this.playerType == 'flashplayer') {
                    var ff = ''; //定义用来向flashplayer传递的函数字符
                    if(typeof(funName) == 'function') {
                        ff = this.getParameterNames(funName);
                    }
                    this.V.addListener(name, ff);
                    return;
                }
                var have = false;
                for(var i = 0; i < this.listenerJsArr.length; i++) {
                    var arr = this.listenerJsArr[i];
                    if(arr[0] == name && arr[1] == funName) {
                        have = true;
                        break;
                    }
                }
                if(!have) {
                    this.listenerJsArr.push([name, funName]);
                }
            }
        },
        /*
			共用函数
			外部删除监听函数
		*/
        removeListener: function(name, funName) {
            if(name && funName) {
                if(this.playerType == 'flashplayer') {
                    var ff = ''; //定义用来向flashplayer传递的函数字符
                    if(typeof(funName) == 'function') {
                        ff = this.getParameterNames(funName);
                    }
                    this.V.removeListener(name, ff);
                    return;
                }
                for(var i = 0; i < this.listenerJsArr.length; i++) {
                    var arr = this.listenerJsArr[i];
                    if(arr[0] == name && arr[1] == funName) {
                        this.listenerJsArr.splice(i, 1);
                        break;
                    }
                }
            }
        },
        /*
			内部监听函数，调用方式：
			this.addListenerInside('click',function(event){},[ID]);
			d值为空时，则表示监听当前的视频播放器
		*/
        addListenerInside: function(e, f, d, t) {
            if(this.isUndefined(t)) {
                t = false
            }
            var o = this.V;
            if(!this.isUndefined(d)) {
                o = d;
            }
            if(o.addEventListener) {
                try {
                    o.addEventListener(e, f, t);
                } catch(event) {}
            } else if(o.attachEvent) {
                try {
                    o.attachEvent('on' + e, f);
                } catch(event) {}
            } else {
                o['on' + e] = f;
            }
        },
        /*
			删除内部监听函数，调用方式：
			this.removeListenerInside('click',function(event){}[,ID]);
			d值为空时，则表示监听当前的视频播放器
		*/
        removeListenerInside: function(e, f, d, t) {
            /*if(this.playerType=='flashplayer' && this.getParameterNames(f) && this.isUndefined(d)) {
				return;
			}*/
            if(this.isUndefined(t)) {
                t = false
            }
            var o = this.V;
            if(!this.isUndefined(d)) {
                o = d;
            }
            if(o.removeEventListener) {
                try {
                    this.addNum--;
                    o.removeEventListener(e, f, t);
                } catch(e) {}
            } else if(o.detachEvent) {
                try {
                    o.detachEvent('on' + e, f);
                } catch(e) {}
            } else {
                o['on' + e] = null;
            }
        },
        /*
			共用函数
			统一分配监听，以达到跟as3同样效果
		*/
        sendJS: function(name, val) {
            var list = this.listenerJsArr;
            for(var i = 0; i < list.length; i++) {
                var arr = list[i];
                if(arr[0] == name) {
                    if(val) {
                        arr[1](val);
                    } else {
                        arr[1]();
                    }
                }
            }
        },
        /*
			共用函数
			获取函数名称，如 function ckplayer(){} var fun=ckplayer，则getParameterNames(fun)=ckplayer
		*/
        getParameterNames: function(fn) {
            if(typeof(fn) !== 'function') {
                return false;
            }
            var COMMENTS = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg;
            var code = fn.toString().replace(COMMENTS, '');
            var result = code.slice(code.indexOf(' ') + 1, code.indexOf('('));
            return result === null ? false : result;
        },
        /*
			共用函数
			获取当前本地时间
		*/
        getNowDate: function() {
            var nowDate = new Date();
            var month = nowDate.getMonth() + 1;
            var date = nowDate.getDate();
            var hours = nowDate.getHours();
            var minutes = nowDate.getMinutes();
            var seconds = nowDate.getSeconds();
            var tMonth = '',
                tDate = '',
                tHours = '',
                tMinutes = '',
                tSeconds = '',
                tSeconds = (seconds < 10) ? '0' + seconds : seconds + '',
                tMinutes = (minutes < 10) ? '0' + minutes : minutes + '',
                tHours = (hours < 10) ? '0' + hours : hours + '',
                tDate = (date < 10) ? '0' + date : date + '',
                tMonth = (month < 10) ? '0' + month : month + '';
            return tMonth + '/' + tDate + ' ' + tHours + ':' + tMinutes + ':' + tSeconds;
        },
        /*
			共用函数
			格式化时分秒
			seconds:Int：秒数
			ishours:Boolean：是否显示小时，如果设置成false，则会显示如80:20，表示1小时20分钟20秒
		*/
        formatTime: function(seconds, ishours) {
            var tSeconds = '',
                tMinutes = '',
                tHours = '';
            if(isNaN(seconds)) {
                seconds = 0;
            }
            var s = Math.floor(seconds % 60),
                m = 0,
                h = 0;
            if(ishours) {
                m = Math.floor(seconds / 60) % 60;
                h = Math.floor(seconds / 3600);
            } else {
                m = Math.floor(seconds / 60);
            }
            tSeconds = (s < 10) ? '0' + s : s + '';
            tMinutes = (m > 0) ? ((m < 10) ? '0' + m + ':' : m + ':') : '00:';
            tHours = (h > 0) ? ((h < 10) ? '0' + h + ':' : h + ':') : '';
            if(ishours) {
                return tHours + tMinutes + tSeconds;
            } else {
                return tMinutes + tSeconds;
            }
        },
        /*
			共用函数
			获取一个随机字符
			len：随机字符长度
		*/
        randomString: function(len) {
            len = len || 16;
            var chars = 'abcdefghijklmnopqrstuvwxyz';
            var maxPos = chars.length;
            var val = '';
            for(i = 0; i < len; i++) {
                val += chars.charAt(Math.floor(Math.random() * maxPos));
            }
            return 'ch' + val;
        },
        /*
			共用函数
			获取字符串长度,中文算两,英文数字算1
		*/
        getStringLen: function(str) {
            var len = 0;
            for(var i = 0; i < str.length; i++) {
                if(str.charCodeAt(i) > 127 || str.charCodeAt(i) == 94) {
                    len += 2;
                } else {
                    len++;
                }
            }
            return len;
        },
        /*
			内部函数
			用来为ajax提供支持
		*/
        createXHR: function() {
            if(window.XMLHttpRequest) {
                //IE7+、Firefox、Opera、Chrome 和Safari
                return new XMLHttpRequest();
            } else if(window.ActiveXObject) {
                //IE6 及以下
                try {
                    return new ActiveXObject('Microsoft.XMLHTTP');
                } catch(event) {
                    try {
                        return new ActiveXObject('Msxml2.XMLHTTP');
                    } catch(event) {
                        this.eject(this.errorList[7]);
                    }
                }
            } else {
                this.eject(this.errorList[8]);
            }
        },
        /*
			共用函数
			ajax调用
		*/
        ajax: function(cObj) {
            var thisTemp = this;
            var callback = null;
            var obj = {
                method: 'get', //请求类型
                dataType: 'json', //请求的数据类型
                charset: 'utf-8',
                async: false, //true表示异步，false表示同步
                url: '',
                data: null,
                success: null
            };
            if(typeof(cObj) != 'object') {
                this.eject(this.errorList[9]);
                return;
            }
            obj = this.standardization(obj, cObj);
            if(obj.dataType === 'json' || obj.dataType === 'text' || obj.dataType === 'html') {
                var xhr = this.createXHR();
                callback = function() {
                    //判断http的交互是否成功
                    if(xhr.status == 200) {
                        if(obj.success == null) {
                            return;
                        }
                        if(obj.dataType === 'json') {
                            try {
                                obj.success(eval('(' + xhr.responseText + ')')); //回调传递参数
                            } catch(event) {
                                obj.success(null);
                            }
                        } else {
                            obj.success(xhr.responseText); //回调传递参数
                        }
                    } else {
                        thisTemp.eject(thisTemp.errorList[10], 'Ajax.status:' + xhr.status);
                    }
                };
                obj.url = obj.url + '?rand=' + this.randomString(6);
                obj.data = this.formatParams(obj.data); //通过params()将名值对转换成字符串
                if(obj.method === 'get' && !this.isUndefined(obj.data)) {
                    obj.url += obj.url.indexOf('?') == -1 ? '?' + obj.data : '&' + obj.data;
                }
                if(obj.async === true) { //true表示异步，false表示同步
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState == 4) { //判断对象的状态是否交互完成
                            callback(); //回调
                        }
                    };
                }
                xhr.open(obj.method, obj.url, obj.async);
                if(obj.method === 'post') {
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader('charset', obj['charset']);
                    xhr.send(obj.data);
                } else {
                    xhr.send(null); //get方式则填null
                }
                if(obj.async === false) { //同步
                    callback();
                }

            } else if(obj.dataType === 'jsonp') {
                var oHead = document.getElementsByTagName('head')[0];
                var oScript = document.createElement('script');
                var callbackName = 'callback' + new Date().getTime();
                var params = this.formatParams(obj.data) + '&callback=' + callbackName; //按时间戳拼接字符串
                callback = obj.success;
                //拼接好src
                oScript.src = obj.url.split('?') + '?' + params;
                //插入script标签
                oHead.insertBefore(oScript, oHead.firstChild);
                //jsonp的回调函数
                window[callbackName] = function(json) {
                    callback(json);
                    oHead.removeChild(oScript);
                };
            }
        },
        /*
			内置函数
			动态加载js
		*/
        loadJs: function(path, success) {
            var oHead = document.getElementsByTagName('HEAD').item(0);
            var oScript = document.createElement('script');
            oScript.type = 'text/javascript';
            oScript.src = this.getNewUrl(path);
            oHead.appendChild(oScript);
            oScript.onload = function() {
                success();
            }
        },
        /*
			共用函数
			排除IE6-9
		*/
        isMsie: function() {
            var browser = navigator.appName
            var b_version = navigator.appVersion
            var version = b_version.split(';');
            var trim_Version = '';
            if(version.length > 1) {
                trim_Version = version[1].replace(/[ ]/g, '');
            }
            if(browser == 'Microsoft Internet Explorer' && (trim_Version == 'MSIE6.0' || trim_Version == 'MSIE7.0' || trim_Version == 'MSIE8.0' || trim_Version == 'MSIE9.0' || trim_Version == 'MSIE10.0')) {
                return false;
            }
            return true;
        },
        /*
			共用函数
			判断是否安装了flashplayer
		*/
        uploadFlash: function() {
            var swf;
            if(navigator.userAgent.indexOf('MSIE') > 0) {
                try {
                    var swf = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
                    return true;
                } catch(e) {
                    return false;
                }
            }
            //if(navigator.userAgent.indexOf('Firefox') > 0 || navigator.userAgent.indexOf('Chrome') > 0) {
            if(navigator.userAgent.indexOf('Firefox') > 0) {
                swf = navigator.plugins['Shockwave Flash'];
                if(swf) {
                    return true
                } else {
                    return false;
                }
            }
            return true;
        },
        /*
			共用函数
			检测浏览器是否支持HTML5-Video
		*/
        supportVideo: function() {
            if(!this.isMsie()) {
                return false;
            }
            if(!!document.createElement('video').canPlayType) {
                var vidTest = document.createElement('video');
                var oggTest;
                try {
                    oggTest = vidTest.canPlayType('video/ogg; codecs="theora, vorbis"');
                } catch(error) {
                    oggTest = false;
                }
                if(!oggTest) {
                    var h264Test;
                    try {
                        h264Test = vidTest.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"');
                    } catch(error) {
                        h264Test = false;
                    }
                    if(!h264Test) {
                        return false;
                    } else {
                        if(h264Test == "probably") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                } else {
                    if(oggTest == "probably") {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        },
        /*
			共用函数
			获取属性值
		*/
        getDataset: function(ele, z) {
            try {
                return ele.dataset[z];
            } catch(error) {
                try {
                    return ele.getAttribute('data-' + z)
                } catch(error) {
                    return false;
                }
            }
        },
        /*
			共用函数
			返回flashplayer的对象
		*/
        getObjectById: function(id) {
            var x = null;
            var y = this.getByElement('#' + id);
            var r = 'embed';
            if(y && y.nodeName == 'OBJECT') {
                if(typeof(y.SetVariable) != 'undefined') {
                    x = y;
                } else {
                    var z = y.getElementsByTagName(r)[0];
                    if(z) {
                        x = z;
                    }
                }
            }
            return x;
        },
        /*
			共用函数
			对象转地址字符串
		*/
        formatParams: function(data) {
            var arr = [];
            for(var i in data) {
                arr.push(encodeURIComponent(i) + '=' + encodeURIComponent(data[i]));
            }
            return arr.join('&');
        },
        /*
			内置函数
			对地址进行冒泡排序
		*/
        arrSort: function(arr) {
            var temp = [];
            for(var i = 0; i < arr.length; i++) {
                for(var j = 0; j < arr.length - i; j++) {
                    if(!this.isUndefined(arr[j + 1]) && arr[j][3] < arr[j + 1][3]) {
                        temp = arr[j + 1];
                        arr[j + 1] = arr[j];
                        arr[j] = temp;
                    }
                }
            }
            return arr;
        },
        /*
			内置函数
			判断文件后缀
		*/
        getFileExt: function(filepath) {
            if(filepath != '' && !this.isUndefined(filepath)) {
                if(filepath.indexOf('?') > -1) {
                    filepath = filepath.split('?')[0];
                }
                var pos = '.' + filepath.replace(/.+\./, '');
                return pos;
            }
            return '';
        },
        /*
			内置函数
			判断是否是移动端
		*/
        isMobile: function() {
            if(navigator.userAgent.match(/(iPhone|iPad|iPod|Android|ios)/i)) {
                return true;
            }
            return false;
        },
        /*
			内置函数
			搜索字符串str是否包含key
		*/
        isContains: function(str, key) {
            return str.indexOf(key) > -1;
        },
        /*
			内置函数
			给地址添加随机数
		*/
        getNewUrl: function(url) {
            if(this.isContains(url, '?')) {
                return url += '&' + this.randomString(8) + '=' + this.randomString(8);
            } else {
                return url += '?' + this.randomString(8) + '=' + this.randomString(8);
            }
        },
        /*
			共用函数
			获取clientX和clientY
		*/
        client: function(event) {
            var eve = event || window.event;
            if(this.isUndefined(eve)) {
                eve = {
                    clientX: 0,
                    clientY: 0
                };
            }
            return {
                x: eve.clientX + (document.documentElement.scrollLeft || this.body.scrollLeft) - this.pdCoor['x'],
                y: eve.clientY + (document.documentElement.scrollTop || this.body.scrollTop) - this.pdCoor['y']
            }
        },
        /*
			内置函数
			获取节点的绝对坐标
		*/
        getCoor: function(obj) {
            var coor = this.getXY(obj);
            return {
                x: coor['x'] - this.pdCoor['x'],
                y: coor['y'] - this.pdCoor['y']
            };
        },
        getXY: function(obj) {
            var parObj = obj;
            var left = obj.offsetLeft;
            var top = obj.offsetTop;
            while(parObj = parObj.offsetParent) {
                left += parObj.offsetLeft;
                top += parObj.offsetTop;
            }
            return {
                x: left,
                y: top
            };
        },
        /*
			内置函数
			删除本对象的所有属性
		*/
        removeChild: function() {
            if(this.playerType == 'html5video') {
                //删除计时器
                var i = 0;
                var timerArr = [this.timerError, this.timerFull, this.timerTime, this.timerBuffer, this.timerClick, this.timerLoading, this.timerCBar, this.timerVCanvas];
                for(i = 0; i < timerArr.length; i++) {
                    if(timerArr[i] != null) {
                        if(timerArr[i].runing) {
                            timerArr[i].stop();
                        }
                        timerArr[i] = null;
                    }
                }
                //删除事件监听
                var ltArr = this.listenerJsArr;
                for(i = 0; i < ltArr.length; i++) {
                    this.removeListener(ltArr[i][0], ltArr[i][1]);
                }
            }
            this.playerType == '';
            this.V = null;
            if(this.showFace) {
                this.deleteChild(this.CB['menu']);
            }
            this.deleteChild(this.PD);
            this.CD.innerHTML = '';
        },
        /*
			内置函数
			画封闭的图形
		*/
        canvasFill: function(name, path) {
            name.beginPath();
            for(var i = 0; i < path.length; i++) {
                var d = path[i];
                if(i > 0) {
                    name.lineTo(d[0], d[1]);
                } else {
                    name.moveTo(d[0], d[1]);
                }
            }
            name.closePath();
            name.fill();
        },
        /*
			内置函数
			画矩形
		*/
        canvasFillRect: function(name, path) {
            for(var i = 0; i < path.length; i++) {
                var d = path[i];
                name.fillRect(d[0], d[1], d[2], d[3]);
            }
        },
        /*
			共用函数
			删除容器节点
		*/
        deleteChild: function(f) {
            var def = this.arrIndexOf(this.elementArr, f.className);
            if(def > -1) {
                this.elementArr.splice(def, 1);
            }
            var childs = f.childNodes;
            for(var i = childs.length - 1; i >= 0; i--) {
                f.removeChild(childs[i]);
            }

            if(f && f != null && f.parentNode) {
                try {
                    if(f.parentNode) {
                        f.parentNode.removeChild(f);

                    }

                } catch(event) {}
            }
        },
        /*
			内置函数
		 	根据容器的宽高,内部节点的宽高计算出内部节点的宽高及坐标
		*/
        getProportionCoor: function(stageW, stageH, vw, vh) {
            var w = 0,
                h = 0,
                x = 0,
                y = 0;
            if(stageW / stageH < vw / vh) {
                w = stageW;
                h = w * vh / vw;
            } else {
                h = stageH;
                w = h * vw / vh;
            }
            x = (stageW - w) * 0.5;
            y = (stageH - h) * 0.5;
            return {
                width: parseInt(w),
                height: parseInt(h),
                x: parseInt(x),
                y: parseInt(y)
            };
        },
        /*
			共用函数
			将字幕文件内容转换成数组
		*/
        parseSrtSubtitles: function(srt) {
            var subtitles = [];
            var textSubtitles = [];
            var i = 0;
            var arrs = srt.split('\n');
            var arr = [];
            var delHtmlTag = function(str) {
                return str.replace(/<[^>]+>/g, ''); //去掉所有的html标记
            };
            for(i = 0; i < arrs.length; i++) {
                if(arrs[i].replace(/\s/g, '').length > 0) {
                    arr.push(arrs[i]);
                } else {
                    if(arr.length > 0) {
                        textSubtitles.push(arr);
                    }
                    arr = [];
                }
            }
            for(i = 0; i < textSubtitles.length; ++i) {
                var textSubtitle = textSubtitles[i];
                if(textSubtitle.length >= 2) {
                    var sn = textSubtitle[0]; // 字幕的序号
                    var startTime = this.toSeconds(this.trim(textSubtitle[1].split(' --> ')[0])); // 字幕的开始时间
                    var endTime = this.toSeconds(this.trim(textSubtitle[1].split(' --> ')[1])); // 字幕的结束时间
                    var content = [delHtmlTag(textSubtitle[2])]; // 字幕的内容
                    // 字幕可能有多行
                    if(textSubtitle.length > 2) {
                        for(var j = 3; j < textSubtitle.length; j++) {
                            content.push(delHtmlTag(textSubtitle[j]));
                        }
                    }
                    // 字幕对象
                    var subtitle = {
                        sn: sn,
                        startTime: startTime,
                        endTime: endTime,
                        content: content
                    };
                    subtitles.push(subtitle);
                }
            }
            return subtitles;
        },
        /*
			共用函数
			计时器,该函数模拟as3中的timer原理
			time:计时时间,单位:毫秒
			fun:接受函数
			number:运行次数,不设置则无限运行
		*/
        timer: function(time, fun, number) {
            var thisTemp = this;
            this.time = 10; //运行间隔
            this.fun = null; //监听函数
            this.timeObj = null; //setInterval对象
            this.number = 0; //已运行次数
            this.numberTotal = null; //总至需要次数
            this.runing = false; //当前状态
            this.startFun = function() {
                thisTemp.number++;
                thisTemp.fun();
                if(thisTemp.numberTotal != null && thisTemp.number >= thisTemp.numberTotal) {
                    thisTemp.stop();
                }
            };
            this.start = function() {
                if(!thisTemp.runing) {
                    thisTemp.runing = true;
                    thisTemp.timeObj = window.setInterval(thisTemp.startFun, time);
                }
            };
            this.stop = function() {
                if(thisTemp.runing) {
                    thisTemp.runing = false;
                    window.clearInterval(thisTemp.timeObj);
                    thisTemp.timeObj = null;
                }
            };
            if(time) {
                this.time = time;
            }
            if(fun) {
                this.fun = fun;
            }
            if(number) {
                this.numberTotal = number;
            }
            this.start();
        },
        /*
			共用函数
			将时分秒转换成秒
		*/
        toSeconds: function(t) {
            var s = 0.0;
            if(t) {
                var p = t.split(':');
                for(i = 0; i < p.length; i++) {
                    s = s * 60 + parseFloat(p[i].replace(',', '.'));
                }
            }
            return s;
        },
        /*
			共用函数
			将对象Object标准化
		*/
        standardization: function(o, n) { //n替换进o
            var h = {};
            var k;
            for(k in o) {
                h[k] = o[k];
            }
            for(k in n) {
                var type = typeof(h[k]);
                switch(type) {
                    case 'number':
                        h[k] = parseFloat(n[k]);
                        break;
                    default:
                        h[k] = n[k];
                        break;
                }

            }
            return h;
        },
        /*
			共用函数
			搜索数组
		 */
        arrIndexOf: function(arr, key) {
            var re = new RegExp(key, ['']);
            return(arr.toString().replace(re, '┢').replace(/[^,┢]/g, '')).indexOf('┢');
        },
        /*
			共用函数
			去掉空格
		 */
        trim: function(str) {
            return str.replace(/(^\s*)|(\s*$)/g, '');
        },
        /*
			共用函数
			输出内容到控制台
		*/
        log: function(val) {
            try {
                console.log(val);
            } catch(e) {}
        },
        /*
			共用函数
			弹出提示
		*/
        eject: function(er, val) {
            if(!this.vars['debug']) {
                return;
            }
            var errorVal = er[1];
            if(!this.isUndefined(val)) {
                errorVal = errorVal.replace('[error]', val);
            }
            var value = 'error ' + er[0] + ':' + errorVal;
            try {
                this.log(value);
            } catch(e) {}
        }
    };
    window.ckplayer = ckplayer;
})();