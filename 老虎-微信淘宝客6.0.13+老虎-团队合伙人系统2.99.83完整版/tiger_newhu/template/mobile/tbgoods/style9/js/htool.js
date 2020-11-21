function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != "function") {
        window.onload = func;
    } else {
        window.onload = function () {
            oldonload();
            func();
        }
    }
}

//通过正则的方式判断是否为数字；
var isNumber = /^[0-9]+.?[0-9]*$/;
function isNum(obj) {
    //console.log(obj);
    if (obj == null || obj == undefined) {
        return false;
    } else {
        return isNumber.test(obj);
    }

}

var DS = {};


//ready function的实现
//调用$(function(){........})

DS.$ = ready = window.ready = function (fn) {
    if (document.addEventListener) {//兼容非IE
        document.addEventListener("DOMContentLoaded", function () {
            //注销事件，避免反复触发
            //多次调用会导致这个方法多次触发，所以在每次调用结束，就取消掉。
            document.removeEventListener("DOMContentLoaded", arguments.callee, false);
            fn();//调用参数函数
        }, false);
    } else if (document.attachEvent) {//兼容IE
        document.attachEvent("onreadystatechange", function () {
            if (document.readyState === "complete") {
                document.detachEvent("onreadystatechange", arguments.callee);
                fn();
            }
        });
    }
};

/////******定义一个全局的对象DS，用来存储方法****////



//依赖注入。。registry = {
//                          key1: value,
//                          key2: function() {},
//                          key3: {
//                                 a: b,
//                                  c: function() {}
//                                  }
//
//                  }
//这里的key1，key2，，，分别对应着不同的服务，把这些作为实参传到方法的形参里去，通过依赖注入
//方法就可以使用参数对应的服务和服务对应的方法，对象，参数


DS.inject = function (func, registry) {
    //registry是保存有服务对象和方法的对象；func是要被注入服务的对象方法

    //将方法整个转为字符串，可以就正则对其里面的参数可以进行匹配
    var source = func.toString();
    var matchers = source.match(/^function\s*[^\(]*\(\s*([^\)]*)\)/m);
    //只有matchers的长度大于1才表示，传进去的函数带有形参
    if (matchers && matchers.length > 1) {
        var args = [];

        //得到形参列表转成数组，其实本来就是一个数组
        var argnames = matchers.slice(1)[0].split(",");
        //这里的args将会得到func里面所拥有的key对应的registry里面的value，value是什么类型，就
        //会给这个func里面对应的参数指定为什么类型，，
        //比如func（key1, key2, key3）{
        //
        //                              在函数体内就会有对应的
        //                                              key1 = value；
        //                                              key2 = function（）{}；
        //                                              key3 = {
        //                                                         a:b，
        //                                                          c:function() {}
        //                                                      }
        //                              在函数体内这些对象和方法可以拿来直接调用，其实就相当于在函数里面new了一个registry，
        //                               只不过是通过依赖注入来完成了这一步，这样做可以节省内存空间，
        //
        //
        //                      }
        for (var i = 0, len = argnames.length; i < len; i++) {
            args[i] = registry[argnames[i].trim()];
        }
        func.apply(null, args);
    }
};

//dom选择器

var $$ = function (selector) {
    "use strict";
    var arg = makeArray(arguments);
    var newArr = [];
    if (!document.querySelector(selector)) {
        return false;
    } else if (document.querySelectorAll(selector).length === 1) {
        if (arg[1] != true) {
            return document.querySelector(selector);
        } else if (arg[1] == true) {
            newArr.push(document.querySelector(selector));

            return newArr;
        }
    } else {
        return Array.prototype.slice.call(document.querySelectorAll(selector));
    }
};

//原型继承

function inherits(a, b) {
    var c = function () {
    };
    c.prototype = b.prototype;
    a.prototype = new c;
}

//得到样式

function getCss(ele, attr) {
    if (window.getComputedStyle) {
        return parseFloat(getComputedStyle(ele, null)[attr]);
    } else {
        if (attr === "opacity") {
            if (ele.currentStyle[attr] === undefined) {
                var reg = /alpha\(opacity=(\d{1,3})\)/;
                var opacityVal = ele.currentStyle.filter;
                if (reg.test(opacityVal)) {
                    ele.style.opacity = parseFloat(RegExp.$1) / 100;
                    return parseFloat(RegExp.$1) / 100;
                } else {
                    return 1;
                }
            }
        }
        return parseFloat(ele.currentStyle[attr]);
    }
}

//设置样式

function setCss(ele, attr, val) {
    if (attr === "opacity") {
        ele.style.opacity = val;
        ele.style.filter = "alpha(opacity=" + val * 100 + ")"
    } else {
        ele.style[attr] = val;
    }
}

//animate及fadein等动画实现

function move(ele, obj, interval, duration, callback) {
    window.clearInterval(ele.timer);
    //var begin=getCss(ele,attr);
    //var interval=15;//每一步时间
    var times = 0;//动画累计时间
    //var change=target-begin;
    var oBegin = {};
    var oChange = {};
    for (var attr in obj) {
        var begin = getCss(ele, attr);
        var target = obj[attr];
        var change = target - begin;
        if (change) {
            oBegin[attr] = begin;
            oChange[attr] = change;
        }
    }
    function step() {
        times += interval;
        if (times < duration) {
            for (var attr in oChange) {
                if (attr === "opacity") {
                    var val = (times / duration) * oChange[attr] + oBegin[attr];
                    setCss(ele, attr, val)
                } else {
                    var val = (times / duration) * oChange[attr] + oBegin[attr] + "px";
                    setCss(ele, attr, val);
                }
            }
        } else {
            for (var attr in obj) {
                if (attr === "opacity") {
                    var target = obj[attr];
                    var val = target;
                    setCss(ele, attr, val);
                } else {
                    var target = obj[attr];
                    var val = target + "px";
                    setCss(ele, attr, val);
                }
            }
            window.clearInterval(ele.timer);
            if (typeof callback === "function") {
                callback.call(ele);
            }
        }
    }

    ele.timer = window.setInterval(step, interval);
}

//转数组

var makeArray = function (obj) {
    if (!obj || obj.length === 0) {
        return []
    }
    if (!obj.length) {
        return obj;
    }
    try {
        return [].slice.call(obj);
    } catch (e) {
        var i = 0;
        var j = obj.length;
        var a = [];
        for (; i < j; i++) {
            a.push(obj[i])
        }
        return a;
    }
};

//定义一个全局的对象，用来存储我的方法。


//////*****给元素添加类名***/////

DS.addClass = function (selector, name) {
    var str = name;
    var test = new RegExp(str, "g");
    var tClass = selector.className;
    if (selector.nodeType !== 1 || tClass.match(test)) {
        return
    }
    var cn = selector.className.trim();
    return selector.className = (cn + " " + name).trim();
};

////******移除元素的指定类名***8///////

DS.removeClass = function (selector, name) {
    if (selector.nodeType !== 1) return;
    var cn = selector.className;
    var str = name;
    var Ncn = "";
    var test = new RegExp(str, "g");
    if (!cn.match(test)) return;
    var cnL = cn.split(" ");
    for (var i = 0; i < cnL.length; i++) {
        if (cnL[i] !== str) {
            Ncn += cnL[i] + " ";
        }
    }
    return selector.className = Ncn.trim();
};

////////****************寻找元素的某一父级，并判断该父级是否存在****///

DS.parentsUntil = function (selector, name) {
    //如果该元素没有父级，或者不存在该元素，
    if (!selector.parentNode || !document.querySelectorAll(name)[0]) return;
    var pn = selector.parentNode, _selfname;
    if (name.slice(0, 1) === "." && pn.nodeType === 1) {
        _selfname = new RegExp(name.slice(1), "g");
        try {
            while (!_selfname.test(pn.className)) {
                pn = pn.parentNode;
            }
        } catch (e) {
            return;
        }
        return pn;
    } else if (name.slice(0, 1) === "#") {
        _selfname = new RegExp(name.slice(1), "g");
        try {
            while (!_selfname.test(pn.id)) {
                pn = pn.parentNode;
            }
        } catch (e) {
            return;
        }
        return pn;
    } else {
        _selfname = new RegExp(name, "i");
        try {
            while (!_selfname.test(pn.tagName)) {
                pn = pn.parentNode;
            }
        } catch (e) {
            return;
        }
    }
    return pn;
};


/////////**********客户端user-Agent验证************/////
/////////**********验证当前用户是通过什么浏览器或者什么类型的客户端访问该页面************/////
////***if(browser.versions.ios||browser.versions.iPhone||browser.versions.iPad){do what you want}*****/////

var browser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return { //移动终端浏览器版本信息
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1 || u.indexOf("Adr"), //android终端或uc浏览器
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
};

/////////**********验证当前用户是通过什么浏览器或者什么类型的客户端访问该页面************/////


////////************监听事件的注册************//////
//注册触摸事件
//触摸事件后，touched对象会保存四个值
// {
//      spanX:触摸的起始水平坐标（相对于body）,
//      spanY:触摸的起始垂直坐标（相对于body），
//      moveX:水平手指划过距离，
//      moveY:垂直手指划过距离，
//  }

var touched = {};

//注册触摸开始事件

function touchS(event) {
    //event.preventDefault();
    var touches = event.targetTouches.length;
    if (touches == 1) {
        //event.preventDefault();
        var mytouch = event.targetTouches[0];
        touched.moveX = 0;
        touched.moveY = 0;
        var spanX = mytouch.pageX;
        var spanY = mytouch.pageY;
        touched.spanX = spanX;
        touched.spanY = spanY;
    }
}

//touch控制
//触摸move事件触发

function touchM(event) {
    //event.preventDefault();
    var touches = event.targetTouches.length;
    if (touches == 1) {
        //event.preventDefault();
        var mytouch = event.targetTouches[0];
        var goX = mytouch.pageX;
        var goY = mytouch.pageY;
        var moveX = goX - touched.spanX;
        var moveY = goY - touched.spanY;
        touched.moveX = moveX;
        touched.moveY = moveY;
    }
}


function preventTouch(event) {
    event.preventDefault();
}
//添加监听事件，监听touch事件

document.addEventListener("touchstart", touchS, false);
document.addEventListener("touchmove", touchM, false);


//滑动距离小于5 的判断
function moveClick() {
    return (Math.abs(touched.moveX) < 5 && Math.abs(touched.moveY) < 5) || (touched.moveX == undefined && touched.moveY == undefined);
}
////////***********监听事件注册结束，页面有触摸事件时触发*************//////


//获取id,参数代表id所在查询字符串中的位置,,也可以直接传参数的名称
function getId(index) {
    var href = window.location.href;
    //如果不传值，index默认为0
    /*if (typeof index === undefined) {
     index = 0;
     }*/
    if (isNum(index)) {
        if (href.indexOf("?") > -1) {
            var query = href.split("?")[1];
            if (query.indexOf("&") > -1) {
                var querystring = query.split("&");
                if (index > querystring.length - 1) {
                    console.warn("can not get query what you find, please check you url is contain the query what needed");
                    return null
                } else {
                    var id = querystring[index];
                    return id.split("=")[1];
                }
            } else {
                if (index > 0) {
                    console.warn("can not get query what you find, please check you url is contain the query what needed");
                    return null
                } else if (index == 0) {
                    return query.split("=")[1]
                }
            }
        } else {
            console.warn("can not get query what you find, please check you url is contain the query what needed");
        }
    } else if (!isNum(index)) {
        if (href.indexOf("?") > -1) {
            var query = href.split("?")[1];
            if (query.indexOf(index) == -1) {
                return
            } else {
                //if (query.indexOf("&") == -1) {
                 //   return query.split("=")[1];
                //} else {
                    var queryObj = {};
                    query.split("&").forEach(function (que) {
                        queryObj[que.split("=")[0]] = que.split("=")[1]
                    });
                    return queryObj[index]

                //}
            }
        }
    }
}


//是否为ios   if(isIos()) {}
function isIos() {
    return browser.versions.ios || browser.versions.iPhone || browser.versions.iPad
}



//进度条样式和dom结构
DS.$(function() {
    var loadingbar = document.createElement("div");
    loadingbar.className = "loadingbar";
    loadingbar.innerHTML = "<div class='loading'><img src='/addons/tiger_taoke/template/mobile/tbgoods/style9/images/loading.gif'></div>";
    document.querySelector("body").appendChild(loadingbar);
});


//loading进度条开启和结束

var loadingAndLoadedservices = {

    //进度条开始
    loading: function () {

        var $loadingbar = $$(".loadingbar");
        var $loading = $$(".loading");

        console.log($$(".loading"));
        $loadingbar.style.display = "-webkit-box";
        var nomove = document.createElement("div");
        nomove.className = "nomove";
        nomove.addEventListener("touchstart", function (event) {
            event.preventDefault();
        });
        if (!$$(".nomove")) {
            $$("body").appendChild(nomove);
        }

    },

    //进度条结束
    loaded: function (tips, callback, time, opacitytime) {

        var $loadingbar = $$(".loadingbar");
        var $loading = $$(".loading");

        if(tips == "") {
            $loadingbar.setAttribute("style", "");
            $loading.setAttribute("style", "");
        } else {
            var style = $loading.style.cssText;
            $loadingbar.style.display = "-webkit-box";
            $loading.style.cssText = style + "height:30px;width:auto;padding:0 10px;line-height:30px;opacity:0.6;";
            $loading.innerHTML = tips;
        }

        if(DS.alphatime) {
            clearTimeout(DS.alphatime);
        }
        if(DS.hidetime) {
            clearTimeout(DS.hidetime);
        }

        //$$(".loading").style.display = "block";
        /*move($$(".loading"), {opacity:0}, 13, 1000, function() {
         $$(".loading").style.cssText = "display: none;width: 2rem;height: 2rem;opacity: 0.6;position: fixed;top: 50%;margin-top: -1rem;left: 50%;margin-left: -1rem;z-index: 100;font-size: 12px;color: #fff;background: #000;text-align: center;";
         if($$(".nomove")) {
         $$(".nomove").remove();
         }
         });*/
        if(typeof time == "undefined") {
            time = (tips == "") ? 0 :500;
        }
        if(typeof opacitytime == "undefined") {
            opacitytime = (tips == "") ? 0 :1000;
        }
        DS.alphatime = setTimeout(function () {
            $loading.style.opacity = 0;
            $loading.style.transition = "opacity " + opacitytime + "ms";
        }, time);

        DS.hidetime = setTimeout(function () {
            $loadingbar.setAttribute("style", "");
            $loading.setAttribute("style", "");
            //$$(".loadingbar").style.cssText = "display:none;width: 100%;height: 2rem; -webkit-box-pack: center; -webkit-box-align: center;position: fixed;top: 50%;margin-top: -1rem;z-index: 100;";
            $loading.innerHTML = "<img src='/addons/tiger_taoke/template/mobile/tbgoods/style9/images/loading.gif'>";


            if ($$(".nomove")) {
                $$("body").removeChild($$(".nomove"));
            }


            if (typeof callback == "function") {
                callback();
            }

        }, opacitytime + time);
    }
};

//不同页面执行不同的loadingandloaded方法.

//第二个参数为true时执行loading动画，，第三个参数为true执行loaded动画

//tips要对用户展示的小提示，，
function isLoadingOrIsLoaded(tips) {
    "use strict";
    var args = makeArray(arguments);

    //执行loading动画
    function loading(loading) {
        loading();
    }

    //执行loaded动画
    function loaded(loaded) {
        loaded(tips, args[3], args[4], args[5]);
    }

    if (args[1] === true && args[2] === true) {

        //这里可以做加的loading效果
        DS.inject(loading, loadingAndLoadedservices);

        setTimeout(function () {
            DS.inject(loaded, loadingAndLoadedservices);
        }, 3000)

    } else if (args[1] === true && args[2] === false || args[2] === undefined || args[2] == "") {

        //这里只loading不loaded
        DS.inject(loading, loadingAndLoadedservices);
    } else if (args[1] == "false" || args[1] == "" || args[1] === undefined && args[2] == "true") {

        //这里只loaded不loading
        DS.inject(loaded, loadingAndLoadedservices);
    }

}

//isLoadingOrIsLoaded("", true, false);开始加载条
//isLoadingOrIsLoaded("要显示的值", false, true, callback, time(显示时间), opacitytime（到渐隐消失进行的时间）)
