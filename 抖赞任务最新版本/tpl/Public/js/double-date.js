$(function(){
    var dateStr='<div class="date-list"><div class="header clearfix"><div class="header-left fl">&lt;</div><div class="fl date-sel"><select class="year"></select></div><div class="fl date-sel"><select class="month"><option value="1">1月</option><option value="2">2月</option><option value="3">3月</option><option value="4">4月</option><option value="5">5月</option><option value="6">6月</option><option value="7">7月</option><option value="8">8月</option><option value="9">9月</option><option value="10">10月</option><option value="11">11月</option><option value="12">12月</option></select></div><div class="header-right fl">&gt;</div><div class="fr today">今日</div></div><table><thead><tr><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>日</th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div>'
    $(dateStr).appendTo($(".date"));
    var $y = $(".year"), $m = $(".month"),
        $year = $y.val(),
        $month = $m.val(),
        current = new Date(),
        current_year = current.getFullYear(),
        current_month = current.getMonth() + 1,
        current_date = current.getDate();
    $m.val(current_month);
    $y.val(current_year);
    for(var i=1917;i<2118;i++){
        var opt = '';
        opt += "<option>" + i + "</option>";
        $(opt).appendTo($y);
    }
    $y.val(current_year);
    show();
    function show() {
        $(".date").each(function () {
            var $y = $(this).find(".year"), $m = $(this).find(".month");
            var year = $y.val(), month = $m.val();
            //通过年和月 获取对应月份下有多少天
            var dates = new Date(year, month, 0).getDate();
            //根据年份和月份获取当月第一天的日期
            date = new Date(new Date(year, month - 1, 1));
            //根据年份和月份获取当月第一天是星期几:
            var firstDay = date.getDay();
            if (firstDay == 0) {
                firstDay = 7;
            }
            var num = 1;
            $(this).find("td").each(function () {
                $(this).removeClass("current");
                var $eq = $(this).index() + 1;
                //给td赋值
                if ($eq < firstDay && $(this).parent("tr").index() === 0) {
                    $(this).html("");
                } else {
                    if (num <= dates) {
                        $(this).html(num);
                        num++
                    } else {
                        $(this).html("")
                    }
                }
                //去掉内容为空的tr
                if ($(this).html() == "" && $(this).siblings().html() == "") {
                    $(this).parents("tr").css("display", "none");
                } else {
                    $(this).parents("tr").css("display", "table-row")
                }
                if ($y.val() == current_year && $m.val() == current_month && $(this).html() == current_date) {
                    $(this).addClass("current");
                } else {
                    $(this).removeClass("current")
                }
            });
            num = 1;
        });
    }

    var date = new Date();
    //点击今日跳转到今日列表
    $(".today").on("click", function () {
        $y.val(current_year);
        $m.val(current_month);
        var $parent=$(this).parents(".date");
       /* var yy=$parent.find(".year").val(),mm=$parent.find(".month");
        actTd($(this),yy,mm);*/
        show();
        $(this).parents(".date-list").css("display", "none").siblings(".date-check").val(current_year + "-" + zero(current_month) + "-" + zero(current_date));
    });
    $(".header select").on("change", function () {
        var year=$(this).parents(".date-list").find(".year").val(),
            month=$(this).parents(".date-list").find(".month").val();
        show();
        actTd($(this),year,month)
    });
    var flag = 0;
    $(".date-list").hover(function () {
        flag = 0;
    }, function () {
        flag = 1;
    });
    //input框获得焦点，让日历显示。失去焦点后，让日历隐藏
    $(".date-check").each(function () {
        $(this).on("focus", function () {
            var $outer = $(this).siblings(".date-list"),
                $this_input = $(this);
            $outer.css("display", "block");
            var val=$(this).val();
            if(val !=""){
                var reg=/^(\d{4})(-|\\|\/|)(\d{1,2})(-|\\|\/|)(\d{1,2})$/,
                    val1=reg.exec(val)[1],
                    val2=reg.exec(val)[3],
                    val3=zero(reg.exec(val)[5]);
                $(this).parents(".date").find(".year").val(val1);
                $(this).parents(".date").find(".month").val(Number(val2));
                show();
                $(this).parents(".date").find("td").each(function(){
                    if($(this).html() == val3){
                        $(this).addClass('act')
                    }
                });
            }
            $(this).parents(".date").siblings(".date").find(".date-list").css("display","none");
            $outer.find("td").each(function () {
                var $this_td = $(this);
                if($this_td.html() != ""){
                    $this_td.addClass('cursorHand');
                }
                $this_td.on("click", function () {
                    var $input_year = $(this).parents(".date-list").find(".year").val(),
                        $input_month = $(this).parents(".date-list").find(".month").val(),
                        $input_val = $(this).html(),
                        date_str = "";
                    if ($this_td.html() != "") {
                        date_str += $input_year + "-" + zero($input_month) + "-" + zero($input_val);
                        $this_input.val(date_str);
                        $this_td.siblings("td").removeClass("act");
                        $outer.css("display", "none");
                    }
                })
            })
        });
        $(this).on("blur", function () {
            if (flag == 1) {
                $(this).siblings(".date-list").css("display", "none");
                flag = 0;
            }
        })
    });
    //月份和日期小于10的补0
    function zero(num) {
        return num >= 10 ? num : "0" + num;
    }
    $("#from td,#to td,#from .today,#to .today").on("click",function(){
        var d_year=$(this).parents(".date-list").find(".year").val(),
            d_month=$(this).parents(".date-list").find(".month").val(),
            $td_val;
        if($(this).prop("tagName").toLowerCase()=="td"){
            $td_val =$(this).html();
            if($td_val!=""){
                var str=d_year+"-"+d_month+"-"+$td_val;
                $(this).parents(".date-list").siblings(".date-check").val(str);
                $(this).parents(".date-list").find("td").removeClass("act");
                $(this).addClass("act");
            }
        }else if($(this).hasClass("today")){
            $(this).parents(".date-list").find("td").removeClass("act")
        }
        var $from=$("#from .date-check").val(),
            $to=$("#to .date-check").val(),
            from_seconds=new Date($from.replace("-", "/").replace("-", "/")).getTime(),
            to_seconds=new Date($to.replace("-", "/").replace("-", "/")).getTime();
        if($from!="" && $to !="" && $(this).html() != ""){
            if(from_seconds>to_seconds){
                alert("起始日期不能大于结束日期！");
                $("#from,#to").addClass("date-error");
            }else{
                $("#from,#to").removeClass("date-error");
            }
        }
        actTd($(this),d_year,d_month);
    });
    function actTd($this,y,m){
        var reg=/^(\d{4})(-|\\|\/|)(\d{1,2})(-|\\|\/|)(\d{1,2})$/,
            _date=$this.parents(".date"),
            arg=_date.find(".date-check").val();
        _date.find("td").each(function(){
            if($(this).html()!=""){
                $(this).addClass("cursorHand")
            }else{
                $(this).removeClass("cursorHand")
            }
        });
        if(arg!=""){
            var _y=reg.exec(arg)[1],
                _m=reg.exec(arg)[3],
                _d=reg.exec(arg)[5];
            if(_y!=y || _m !=m){
                _date.find("td").removeClass("act");
            }else{
                _date.find("td").each(function(){
                    if($(this).html() == _d){
                        $(this).addClass("act")
                    }
                });
            }
        }
    }
    $(".header-left").on("click",function(){
        var $year=parseInt($(this).parents(".header").find(".year").val()),
            $mon=parseInt($(this).parents(".header").find(".month").val());
        if($mon>=2){
            $mon-=1;
        }else{
            $year-=1;
            $mon=12;
            $(this).parents(".header").find(".month").val($mon);
            $(this).parents(".header").find(".year").val($year)
        }
        $(this).parents(".header").find(".month").val($mon);
        show();
        actTd($(this),$year,$mon);
    });
    $(".header-right").on("click",function(){
        var $year=parseInt($(this).parents(".header").find(".year").val());
        var $mon=parseInt($(this).parents(".header").find(".month").val());
        if($mon<12){
            $mon+=1;
        }else{
            $year+=1;
            $mon=1;
            $(this).parents(".header").find(".month").val($mon);
            $(this).parents(".header").find(".year").val($year)
        }
        $(this).parents(".header").find(".month").val($mon);
        show();
        actTd($(this),$year,$mon);
    });
    document.body.onselectstart=document.body.ondrag=function(){
        return false;
    };
});