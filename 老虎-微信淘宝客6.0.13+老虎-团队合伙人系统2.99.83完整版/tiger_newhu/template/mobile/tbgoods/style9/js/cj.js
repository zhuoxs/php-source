var kjlabox = null;
var _kjlabox, _kjladom, _kjlabg;

function kjla(bglink, money, tip, logo, ifshow) {

    if (!kjlabox) {
        kjlabox = document.createElement("div");
        kjlabox.className = "kjlabox";
        var html = "";
        html += "<div class='kjlabg'></div>";
        html += "<div class='kjladom' style='background-image:url(" + bglink + ")'>";
        html += "<div class='kjlatip'>" + tip + "</div>";
        html += "<div class='kjlamoney'>" + money + "</div>";
        html += "<div class='kjlalogo'><img src='" + logo + "'></div>";
        html += "</div>";
        kjlabox.innerHTML = html;
        document.body.appendChild(kjlabox);

        _kjlabox = document.querySelector(".kjlabox");
        _kjladom = document.querySelector(".kjladom");
        _kjlabg = document.querySelector(".kjlabg");
        _kjlabox.classList.add("showkjbox");
        _kjladom.classList.add("showkjdom");
        _kjlabg.classList.add("showkjbg");

    } else {

        _kjlabox.style.display = "-webkit-box";
        _kjlabox.classList.remove("hidekjbox");
        _kjladom.classList.remove("hidekjdom");
        _kjlabg.classList.remove("hidekjbg");

        _kjlabox.classList.add("showkjbox");
        _kjladom.classList.add("showkjdom");
        _kjlabg.classList.add("showkjbg");

    }

    var args = Array.prototype.slice.call(arguments);
    if (args[4] == true) {
        return;
    }

    setTimeout(function () {
        _kjlabox.classList.remove("showkjbox");
        _kjladom.classList.remove("showkjdom");
        _kjlabg.classList.remove("showkjbg");
        _kjlabox.classList.add("hidekjbox");
        _kjladom.classList.add("hidekjdom");
        _kjlabg.classList.add("hidekjbg");

        setTimeout(function () {
            _kjlabox.style.display = "none";
        }, 500);

    }, 3000)

}


function GoldDrop() {
    this.goldstyle = ["dropgold1", "dropgold2", "dropgold3", "dropgold4", "dropgold5", "dropgold6", "dropgold7"];
    this.goldDom = [];
};

/*金币掉落场景*/
GoldDrop.prototype.createGold = function (goldlist) {
    var _goldlist = goldlist;
    var goldlen = _goldlist.length;
    var _frag = document.createDocumentFragment();
    var smallgold, img;



    for (var i = 0; i < 200; i++) {
        smallgold = document.createElement("div");
        smallgold.className = "smallgold";
        img = document.createElement("img");
        img.src = _goldlist[Math.floor(Math.random() * goldlen)];
        smallgold.appendChild(img);
        _frag.appendChild(smallgold);
        var ran = Math.random() * 50;
        var ranw = ran < 30 ? ran + 30 : ran;
        smallgold.style.left = Math.random() * document.documentElement.clientWidth + "px";
        img.style.width = smallgold.style.width = ranw + "px";
        this.goldDom.push(smallgold);
    }

    document.body.appendChild(_frag);
}

GoldDrop.prototype.goldStyle = function () {
    return this.goldstyle;
}

GoldDrop.prototype.useGold = function () {
    var that = this;
    var _cl = this.goldStyle();
    for (var j = 0; j < 200; j++) {
        (function (j) {
            setTimeout(function () {
                that.goldDom[j].classList.add(_cl[Math.floor(Math.random() * _cl.length)])
            }, 10 * j);
        })(j)
    }
}


function util(o) {
    function F() { };
    F.prototype = new o();
    return new F;
}



var jiang = ["屁都没抢到！", 0.5, 10, 15, 20, 25, 30, 35, 40, 50];


function getJ() {
    var myj = jiang[Math.floor(Math.random() * jiang.length)];
    return myj;
}




/*中奖区滚动*/
function peopleslide() {
    var box = document.querySelector(".cjslidebox");
    var slide = document.querySelector(".cjslidebox ul");
    var _h = slide.clientHeight;
    var _bh = box.clientHeight;
    box.appendChild(slide.cloneNode(true));
    var _offset = 0;
    setInterval(function () {

        if (_offset == _h) {
            _offset = 0;
            box.scrollTop = 0;
        } else {
            box.scrollTop = _offset++;
        }

    }, 100)

}


function showhj(money, msg, fun) {
    if (money > 0) {
        $(".cjmoney2").html(money + "");
        kjla("../addons/tiger_taoke/template/mobile/tbgoods/style9/images/kjla.png", money + "元", "人品很好嘛，明天运气更好！", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/xiaoren.png");
    }
    else {
        $(".cjmoney2").html(msg);
        kjla("../addons/tiger_taoke/template/mobile/tbgoods/style9/images/kjla.png", msg, "明天10点来战！", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/kuren.png");
    }
    $(".kjle").removeClass("kjle");
    $(".cjkj").hide();

    fun();
}


function popwindow2(title, content) {
    var pop;
    if (!document.querySelector(".popw2")) {
        var popw2 = document.createElement("div");
        document.body.appendChild(popw2);
        popw2.className = "popw2";
        popw2.innerHTML = "<div class='popwbg2'></div><div class='popwbox2'><div class='popwtitle2'></div><div class='popwcontent2'></div><div><div class='popwcc2'><a href='javascript:;' class='popwcancel2'>确认</a></div></div></div>"
        canclepopw2();
    }
    $(".popwtitle2").html(title);
    $(".popwcontent2").html(content);
    pop = document.querySelector(".popw2")
    pop.style.display = "-webkit-box";
    $(".popwbox2").addClass("popwboxshow2");

}


/*取消*/
function canclepopw2() {
    $(".popwcancel2,.popwbg2,.popwcomfirm2").click(function () {
        $(".popwbox2").removeClass("popwboxshow2");
        $(".popw2").remove();
    })
}



/*首页红包特效*/
function indexHB() {

    var html = "";
    var cjUrl = $("#cj_url").val();
	var cjpicurl = $("#cjpicurl").val();	
    var hbbox = document.createElement("div");
    hbbox.className = "hbbox";
    html += "<div class='hbbg'></div>";
    html += "<a href='javascript:;' class='hbclose'></a>";
    html += "<div class='hbdxk hgboxshow'><a href='" + cjUrl + "'><img src='"+cjpicurl+"' class='hbimg hbimgshow'></a></div>";
    hbbox.innerHTML = html;
    document.body.appendChild(hbbox);

    var _date = new Date();
    var _day = _date.getDate();


    var _oldday = localStorage.getItem("day");

    if(_oldday != _day)  {
        localStorage.setItem("first", "true");
    }

    var _first = localStorage.getItem("first");

    if(_first == "false") {
        $(".hbimg").addClass("hbimghide2").css({
            position:"fixed"
        });
        $(".hbbox").css({
            width:0,
            height:0,
            overflow:"visible"
        })
        $(".hbbg,.hbclose").hide();

        //setTimeout(function() {
        $(".hbimg").addClass("hbimgsmall");
        setTimeout(function() {
            $(".hbimg").removeClass("hbimgshow").removeClass("hbimghide2").removeClass("hbimgsmall").addClass("finalhb")
        }, 1000)
        //}, 500)

        return;
    }

    var hbarr;

    if (_day == 25) {
        hbarr = ["../addons/tiger_taoke/template/mobile/tbgoods/style9/images/chiri1.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/chiri2.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/chiri3.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/chiri4.png"];
    } else {
        hbarr = ["../addons/tiger_taoke/template/mobile/tbgoods/style9/images/hb1.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/hb2.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/hb3.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/hb4.png", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/hb5.png"];
    }

    var hbani = util(GoldDrop);
    hbani.createGold(hbarr);
    hbani.useGold();





    $(".hbclose").click(function () {
        $(".hbimg").addClass("hbimghide").css({
            position: "fixed"
        });
        $(".hbbox").css({
            width: 0,
            height: 0,
            overflow: "visible"
        })
        $(".hbbg,.hbclose").fadeOut();

        setTimeout(function () {
            $(".hbimg").addClass("hbimgsmall");
            setTimeout(function() {
                $(".hbimg").removeClass("hbimgshow").removeClass("hbimghide2").removeClass("hbimgsmall").addClass("finalhb")
            }, 1000)
        }, 500)

        localStorage.setItem("first", "false");
        localStorage.setItem("day", _day);

    })



}


/*红包抢光了*/
function hbNone() {
    kjla("../addons/tiger_taoke/template/mobile/tbgoods/style9/images/kjla.png", "今天的红包抢完了!", "明天10点来战！", "../addons/tiger_taoke/template/mobile/tbgoods/style9/images/kuren.png", true);
}

/*红包还没到开奖时间倒计时*/
//12:12:12
function timeCal(servertime, finaltime) {

    var nowdate = new Date(servertime);
    var nowhour = nowdate.getHours();
    if (nowhour >= finaltime && nowhour <= 24) {
        //hbNone();
        return;
    }

    var nowyear = nowdate.getFullYear();
    var nowmonth = nowdate.getMonth();
    var nowday = nowdate.getDate();
    var nowmimute = nowdate.getMinutes();
    var nowseconds = nowdate.getSeconds();

    var html = "";
    html += "<div class='timestillbg'></div>";
    html += "<div class='timestill'>";
    html += "<span class='timehour'></span>:<span class='timeminute'></span>:<span class='timeseconds'></span>";
    html += "</div>";

    var timestillbox = document.createElement("div");
    timestillbox.className = "timestillbox";
    timestillbox.innerHTML = html;
    document.body.appendChild(timestillbox);
    var _timehour = document.querySelector(".timehour");
    var _timeminute = document.querySelector(".timeminute");
    var _timeseconds = document.querySelector(".timeseconds");
    var _hour, _minute, _seconds;
    _hour = finaltime - nowhour - 1;
    _minute = 60 - nowmimute - 1;
    _seconds = 60 - nowseconds;
    setInterval(function () {
        _timeseconds.innerHTML = --_seconds < 10 ? "0" + _seconds : _seconds;
        _timeminute.innerHTML = _minute < 10 ? "0" + _minute : _minute;
        _timehour.innerHTML = _hour < 10 ? "0" + _hour : _hour;
        if (_seconds == 0) {
            _minute--;
            _seconds = 60;
            if (_minute == 0) {
                _minute = 60;
                _hour--;
            }
        }
    }, 1000)

}


