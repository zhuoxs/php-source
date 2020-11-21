//实现图片的滚屏加载


var lastTime = 0;
var prefixes = 'webkit moz ms o'.split(' '); //各浏览器前缀

var requestAnimationFrame = window.requestAnimationFrame;
var cancelAnimationFrame = window.cancelAnimationFrame;

//通过遍历各浏览器前缀，来得到requestAnimationFrame和cancelAnimationFrame在当前浏览器的实现形式
for( var i = 0; i < prefixes.length; i++ ) {
    if ( requestAnimationFrame && cancelAnimationFrame ) {
        break;
    }
    prefix = prefixes[i];
    requestAnimationFrame = requestAnimationFrame || window[ prefix + 'RequestAnimationFrame' ];
    cancelAnimationFrame  = cancelAnimationFrame  || window[ prefix + 'CancelAnimationFrame' ] || window[ prefix + 'CancelRequestAnimationFrame' ];
}

//如果当前浏览器不支持requestAnimationFrame和cancelAnimationFrame，则会退到setTimeout
if ( !requestAnimationFrame || !cancelAnimationFrame ) {
    requestAnimationFrame = function( callback, element ) {
        var currTime = new Date().getTime();
        //为了使setTimteout的尽可能的接近每秒60帧的效果
        var timeToCall = Math.max( 0, 16 - ( currTime - lastTime ) );
        var id = window.setTimeout( function() {
            callback( currTime + timeToCall );
        }, timeToCall );
        lastTime = currTime + timeToCall;
        return id;
    };

    cancelAnimationFrame = function( id ) {
        window.clearTimeout( id );
    };
}

//得到兼容各浏览器的API
window.requestAnimationFrame = requestAnimationFrame;
window.cancelAnimationFrame = cancelAnimationFrame;


var imgScrollIndex = 0;

//scrTop为滚动过程中的实时滚动距离 //传0表示页面最顶部
//baseH在这里主要传的当前页面的可视区域的高度
//selector 需要动态加载的图片所在的标签，




//全局异步加载
function scrollLoadingImg(scrTop, baseH, callback) {
    if (typeof scrTop == "undefined") {
        var scrTop = 0;
    }

    var baseW = document.documentElement.clientWidth;

    //开始显示图片了
    var ImgLoadedShow = function (img, imgSrc, dataSrc) {
        setTimeout(function () {

            img.querySelector(".DSbg").style.opacity = 1;
            img.querySelector(".DSbg").style.backgroundImage = "url(" + imgSrc + ")";
            img.querySelector(".inoutbg").style.opacity = 0;
            dataSrc.setAttribute("loaded", "true");

        }, 500)

    };

    var imgCanUse = function () {
        var img = $$(".allpreContainer", true);
        var imglen = img.length;
        console.log("imgScrollIndex:", imgScrollIndex);
        //只有向下滚动时或滑动时才会触发滚屏加载。
        for (var i = imgScrollIndex; i < imglen; i++) {

            if(!img[i]) {
                continue;
            }

            if (img[i].getBoundingClientRect().top < baseH && img[i].getBoundingClientRect().left < baseW) {
                var dataSrc = img[i].querySelector(".preloadbg");
                if (dataSrc.getAttribute("loaded") != "true") {
                    var imgSrc = dataSrc.getAttribute("src-data");
                    dataSrc.setAttribute("num", i);
                    var showimg = (function (i, imgSrc, dataSrc, img) {
                        var imgneed = new Image();
                        imgneed.src = imgSrc;
                        if (imgneed.complete) {
                            //从缓存中读取会执行这步
                            console.log("reload in");

                            //每张图片加载好了，都会执行一遍这个callback
                            if(typeof callback == "function") {
                                callback(img, imgSrc);
                            }

                            ImgLoadedShow(img, imgSrc, dataSrc);
                            return;
                        }
                        imgneed.onload = function () {
                            //首次加载会执行这个方法
                            console.log("first in");
                            ImgLoadedShow(img, imgSrc, dataSrc);
                        }
                    })(i, imgSrc, dataSrc, img[i])
                }


            }
        }
    };

    if (DS.pagecomplete == undefined) {
        imgCanUse()
    } else {

        var _reqAni = function () {
            var imgtimer = requestAnimationFrame(_reqAni);
            if (DS.pagecomplete == true) {
                cancelAnimationFrame(imgtimer);
                imgCanUse();
            }
        };

        _reqAni();

    }
}

//小范围图片延迟加载
function oneImglazyLoad(parent) {
    var dataSrc = makeArray(parent.querySelectorAll(".preloadbg"));
    dataSrc.forEach(function(pre) {
        //if (pre.getAttribute("loaded") != true) {
        var imgSrc = pre.getAttribute("src-data");
        pre.setAttribute("loaded", true);
        var newimg = new Image();
        newimg.src = imgSrc;
        setTimeout(function() {
            if (newimg.complete) {
                pre.parentNode.querySelector(".DSbg").style.cssText = "opacity:1;background-image: url(" + imgSrc + "); background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;";
                return;
            }
            newimg.onload = function () {
                pre.parentNode.querySelector(".DSbg").style.cssText = "opacity:1;background-image: url(" + imgSrc + "); background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;";
            }
        }, 500);

        //}
    })

}


//css3   loading动画样式
function cssLoadingAnimate() {
    var args = makeArray(arguments);
    var html = "";
    var cssloading = document.createElement("div");
    cssloading.className = "cssloading";
    html += '<div class="spinner">';
    html += '<div class="spinner-container container1">';
    html += '<div class="circle1"></div>';
    html += '<div class="circle2"></div>';
    html += '<div class="circle3"></div>';
    html += '<div class="circle4"></div>';
    html += '</div>';
    html += '<div class="spinner-container container2">';
    html += '<div class="circle1"></div>';
    html += '<div class="circle2"></div>';
    html += '<div class="circle3"></div>';
    html += '<div class="circle4"></div>';
    html += '</div>';
    html += '<div class="spinner-container container3">';
    html += '<div class="circle1"></div>';
    html += '<div class="circle2"></div>';
    html += '<div class="circle3"></div>';
    html += '<div class="circle4"></div>';
    html += '</div>';
    html += '</div>';
    html += '正在加载...';
    cssloading.innerHTML = html;
    if (args[0] == true) {
        if ($$(".cssloading")) {
            $$("body").removeChild($$(".cssloading"));
            $$("body").appendChild(cssloading);
        } else {
            $$("body").appendChild(cssloading);
        }

    } else if (args[0] == false) {
        if ($$(".cssloading")) {
            $$("body").removeChild($$(".cssloading"));
        }
    }

}


//控制滚动加载数据的方法
//dataAppendFunc  将要执行的ajax添加数据的方法。将数据数组片接字符串append到body里面去
//每次加载到  showcount * everycount的索引;
//每次加载数量  everycount
//list  ajax请求过来的数据的列表全部
//这个方法可能需要在函数执行前，插入一个DS.pagecomplete为false的属性，
// 为了保证数据如果分很多次返回，一个ajax请求无法判断是否数据已经加载完毕的时候不出错，在页面加载完成的时候将这个属性改为true，同时让DS.lll = true;

function controlLazyLaoding(dataAppendFunc, list, showcount, everycount) {

    var self = this;

    self.dataAppendFunc = dataAppendFunc;
    
    //防止多次注册事件
    window.removeEventListener("scroll", isNowScroll, false);

    //每次加载到  showcount * everycount的索引;
    if (typeof showcount == "undefined") {
        showcount = 1;
    }
    if (typeof everycount == "undefined") {
        everycount = 4;
    }
    
    //进入页面默认第一次加载；
    DS.newlist = list.slice(everycount * (showcount - 1), everycount * showcount);

    //这个方法必须放在这个位置，前面的执行完了，才能进行添加数据，
    //数据才能执行后面的变量赋值和方法。!!!!!!!!!!important

    var ajaxtimes = 0;


    this.asynLoading = function(newlist, dataAppendFunc) {


        if(ajaxtimes > 0) {
            //请求数据开始loading动画
            cssLoadingAnimate(true);

            //如果本来就没数据，就显示空空如也，本来有数据，滑到底了才会显示没有数据了
            if (newlist.length == 0) {
                if($$(".seeshopscom")) {
                    //数据加载完毕取消loading动画
                    cssLoadingAnimate(false);
                    return;
                }

                var nodata = document.createElement("div");
                nodata.className = "nodata";
                nodata.innerHTML = "没有数据了！";
                if(!$$(".nodata") && ($$("#caseList") || $$(".detailbox") || $$(".mycomment") || $$(".purchase_list") || $$(".order") || $$("#collection") || $$("#purchase_list"))) {
                    $$("body").appendChild(nodata);
                }

                //数据加载完毕取消loading动画
                cssLoadingAnimate(false);

                return;
            }

        }

        ajaxtimes++;

        //这个方法必须放在这个位置，前面的执行完了，才能进行添加数据，
        //数据才能执行后面的变量赋值和方法。!!!!!!!!!!important
        //将新数据的数组列表传入函数，，让函数遍历
        dataAppendFunc(DS.newlist);

        ////////########$#$#$%#$@$@#$@@$@$@#$%%^#&*#%$@%^@/////////

        showcount++;
        DS.newlist = list.slice(everycount * (showcount - 1), everycount * showcount);

        //数据加载完毕取消loading动画
        //cssLoadingAnimate(false);


        //新元素添加完毕，，将这个值转为true，控制下次滚动时可以有效触发  ，这个添加新元素的方法。
        //如果要自己在页面加载完成的地方加个标记，
        if (DS.pagecomplete == undefined) {
            DS.lll = true;

            //数据加载完毕取消loading动画
            cssLoadingAnimate(false);
        } else {

            if (DS.pagecomplete == false) {
                var timercol = 0;
                function reqAni() {
                    var timer = requestAnimationFrame(reqAni);
                    if(DS.pagecomplete == true || timercol++ > 500) {
                        cancelAnimationFrame(timer);
                        //数据加载完毕取消loading动画
                        cssLoadingAnimate(false);
                    }
                    timercol++;
                    console.log("nono");

                }
                reqAni();
            }

        }


    };

    //页面加载时需要默认的第一次添加元素
    self.asynLoading(DS.newlist, dataAppendFunc);


    //初始化这个值，控制添加新元素的方法什么时候执行。
    DS.lll = true;

    //页面的整体高度不需要实时计算，可以提高点性能，第一次第算一次，，，然后页面新加入元素之后计算就行。
    //如有需要可以给页面加入一个DS。complete属性，来监听页面的加载情况，避免出现bodyH获取不正常的情况。
    if (DS.pagecomplete != undefined) {

        //如果给页面加了这个属性。那么会走这一步，这个属性一定要在这个方法执行执行设置
        //监听这个值为true才会停止轮训，所以两个状态一定要设置

        if (DS.pagecomplete == false) {
            var timercol = 0;
            var _reqAni = function() {
                var bodyHtimer = requestAnimationFrame(_reqAni);
                if(DS.pagecomplete == true ||   timercol > 500) {
                    DS.bodyH = document.body.clientHeight;
                    cancelAnimationFrame(bodyHtimer);

                }
                timercol++;
                console.log("nono");
            };
            _reqAni();
        }

    } else {
        //没有DS。pagecomplete属性，说明这个页面不需要这个属性
        DS.bodyH = document.body.clientHeight;
    }


    //页面加载过慢会导致这个值为0；
    //所以在这个位置页面出来后在进行计算
    var baseH = document.documentElement.clientHeight;

    //js里面控制图片滚屏加载的方法;
    //初次加载
    if (DS.pagecomplete == undefined) {
        scrollLoadingImg(0, baseH);
    } else {
        reqAni();
        var timercol = 0;
        function reqAni() {
            var timer = requestAnimationFrame(reqAni);
            if (DS.pagecomplete == true || timercol > 500) {
                cancelAnimationFrame(timer);
                scrollLoadingImg(0, baseH);
                console.log("a")
            }
            timercol++;
        }
    }

    window.addEventListener("scroll", isNowScroll, false);

    function isNowScroll(time) {

        if(typeof time == "undefined") {
            time = 500;
        }

        if(DS.scrolltimer) {
            clearInterval(DS.scrolltimer);
        }

        var scrTop = document.documentElement.scrollTop || document.body.scrollTop;

        //图片动态添加
        DS.scrolltimer = setTimeout(function () {
            scrollLoadingImg(scrTop, baseH)
        }, time);


        //页面数据动态加载。
        //只有向下滚动时或滑动时才会触发滚屏加载。
        // var scrTop = document.documentElement.scrollTop || document.body.scrollTop;

        //baseH是js里面定义的当前页面所在客户端的屏幕的高度。
        if (baseH + scrTop > DS.bodyH - 100) {
            if (DS.lll) {
                //以免滚动时回调函数次数触发造成的bug，，只有当页面新元素添加完毕以后，这个值才能重新为true，
                //在下次滚动到页面底部要加入新元素时使函数可以继续执行。
                //复制false必须要放在函数执行之前。
                DS.lll = false;

                self.asynLoading(DS.newlist, self.dataAppendFunc);

                //新的元素加进来后重新计算body的整体高度。
                DS.bodyH = document.body.clientHeight;
            }

        }


    }
}


//对预加载背景图片的处理
//img实际的图片路径
//i暂存索引，不需要的话，随便传一个值，
// defaultbg 默认的加载背景图
function preloadbg(img, i, defaultbg) {
    //var ww = document.documentElement.clientWidth;
    var html = "";
    html += '<div class="allpreContainer">';
    html += '<div class="inoutbg" style="background-image:url(' + defaultbg + ');background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;"></div>';
    html += '<img class="preloadbg preloadbg' + i + '" src-data="' + img + '" src="" loaded="false">';
    html += '<div class="DSbg DSbg' + i + '" style="background-image: url(' + defaultbg + '); background-size: cover; background-position: 50% 50%; background-repeat: no-repeat no-repeat;"></div>';
    html += '</div>';
    return html;
}



