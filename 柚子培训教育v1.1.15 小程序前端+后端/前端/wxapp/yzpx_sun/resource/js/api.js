var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _rewx = require("./rewx.js"), app = getApp(), IndexData = function(i) {
    return (0, _rewx.post)("Index", i).then(function(o) {
        return new Promise(function(e, n) {
            o.nav = {};
            var t = o.icon;
            o.nav.txtA = t.logo_name_one ? t.logo_name_one : "关于我们", o.nav.txtB = t.logo_name_two ? t.logo_name_two : "新闻动态", 
            o.nav.txtC = t.logo_name_three ? t.logo_name_three : "精品课程", o.nav.txtD = t.logo_name_four ? t.logo_name_four : "授课老师", 
            o.nav.txtE = t.logo_name_five ? t.logo_name_five : "预约报名", o.nav.txtF = t.logo_name_six ? t.logo_name_six : "集卡活动", 
            o.nav.txtG = t.fx_name ? t.fx_name : "分校列表", o.nav.txtH = t.kanjia_name ? t.kanjia_name : "砍价活动", 
            o.nav.imgA = t.logo_img_one ? t.logo_img_one : "../../resource/images/home/11.png", 
            o.nav.imgB = t.logo_img_two ? t.logo_img_two : "../../resource/images/home/12.png", 
            o.nav.imgC = t.logo_img_three ? t.logo_img_three : "../../resource/images/home/13.png", 
            o.nav.imgD = t.logo_img_four ? t.logo_img_four : "../../resource/images/home/14.png", 
            o.nav.imgE = t.logo_img_five ? t.logo_img_five : "../../resource/images/home/1.png", 
            o.nav.imgF = t.logo_img_six ? t.logo_img_six : "../../resource/images/home/2.png", 
            o.nav.imgG = t.fx_icon ? t.fx_icon : "../../resource/images/home/1.png", o.nav.imgH = t.kanjia_icon ? t.kanjia_icon : "../../resource/images/home/2.png", 
            o.nav.imgI = t.coupon_img ? t.coupon_img : "../../resource/images/index.jpg", o.nav.imgAH = !!t.logo_img_one, 
            o.nav.imgBH = !!t.logo_img_two, o.nav.imgCH = !!t.logo_img_three, o.nav.imgDH = !!t.logo_img_four, 
            o.nav.imgEH = !!t.logo_img_five, o.nav.imgFH = !!t.logo_img_six, o.nav.imgGH = !!t.fx_icon, 
            o.nav.imgHH = !!t.kanjia_icon, o.nav.imgIH = !!t.coupon_img, 0 == i.sid && (o.we.join_card = 1), 
            e(o);
        });
    });
}, NearbyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Nearby", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DefaultSchoolData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DefaultSchool", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, WeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("We", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdsignData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Adsign", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NewsclassifyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Newsclassify", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].choose = !1;
            e(o);
        });
    });
}, NewslistData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Newslist", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NewsDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("NewsDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardlistData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Cardlist", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardDetails", e).then(function(r) {
        return new Promise(function(e, n) {
            var t = [], o = [], i = r.prizelist;
            for (var a in i) o.push(i[a]), a % 2 != 0 && (t.push(o), o = []), a % 2 == 0 && i.length < 2 && (t.push(o), 
            o = []);
            r.getter = t, e(r);
        });
    });
}, CardShareData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardShare", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardDrawData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardDraw", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardGetprizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardGetprize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AllCourseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AllCourse", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CourseOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseOrder", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CourseClassifyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseClassify", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].choose = !1;
            e(o);
        });
    });
}, CourseListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].choose = !1, o[t].showTime = (0, _rewx.getFullDay)(o[t].start_time);
            e(o);
        });
    });
}, TeacherListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("TeacherList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].choose = !1;
            e(o);
        });
    });
}, TeacherDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("TeacherDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, TeachCourseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("TeachCourse", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CourseDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            t.showTime = (0, _rewx.getFullDay)(t.info.start_time), e(t);
        });
    });
}, CourseSignData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseSign", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, LessonInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("LessonInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            t.showtime = (0, _rewx.getFullDay)(t.start_time), e(t);
        });
    });
}, SchoolListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("SchoolList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].dist = (o[t].distance - 0).toFixed(2);
            e(o);
        });
    });
}, GetPrizeSchoolData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("GetPrizeSchool", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].dist = (o[t].distance - 0).toFixed(2);
            e(o);
        });
    });
}, QrpicData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Qrpic", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DelimgData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Delimg", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CouponListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CouponList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showtime = (0, _rewx.getFullDay)(o[t].end_time);
            e(o);
        });
    });
}, GetCouponData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("GetCoupon", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CanUseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CanUse", e).then(function(i) {
        return new Promise(function(e, n) {
            var t = [];
            for (var o in i) i[o].showtime = (0, _rewx.getFullDay)(i[o].end_time), t.push(i[o]);
            e(t);
        });
    });
}, BargainListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BargainList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showtime = (0, _rewx.getFullDay)(o[t].start_time - 0);
            e(o);
        });
    });
}, BargainInfoData = function(u) {
    return "object" !== (void 0 === u ? "undefined" : _typeof(u)) && (u = {}), (0, _rewx.post)("BargainInfo", u).then(function(r) {
        return new Promise(function(e, n) {
            r.showTime = (0, _rewx.getFullDay)(r.info.start_time), 0 < r.bid - 0 && (r.cutMoney = (r.info.money - r.kjinfo.now_money).toFixed(2));
            var t = null, o = null, i = Math.floor(new Date().getTime() / 1e3 - 0), a = r.info.end_time - 0;
            0 < u.help_uid - 0 ? i < a ? 0 < r.ishelp - 0 ? (t = {
                name: "我也要",
                status: 2,
                show: !0
            }, o = {
                name: "TA的帮砍记录",
                status: 3,
                show: !0
            }) : (t = {
                show: !1
            }, o = {
                name: "帮TA砍",
                status: 4,
                show: !0
            }) : (t = {
                show: !1
            }, o = {
                name: "活动已结束",
                status: 6,
                show: !0
            }) : i < a ? 0 < r.bid - 0 ? "1" == r.kjinfo.isbuy ? (t = {
                show: !1
            }, o = {
                name: "您已购买",
                status: 5,
                show: !0
            }) : r.kjinfo.now_money - 0 <= r.info.nowmoney - 0 ? t = {
                show: !(o = {
                    name: "报名购买",
                    status: 7,
                    show: !0
                })
            } : "0" != r.info.is_floor_price ? t = {
                show: !(o = {
                    name: "好友帮砍",
                    status: 1,
                    show: !0
                })
            } : (t = {
                name: "好友帮砍",
                status: 1,
                show: !0
            }, o = {
                name: "现价购买",
                status: 7,
                show: !0
            }) : (t = {
                show: !1
            }, o = {
                name: "立即砍价",
                status: 0,
                show: !0
            }) : (t = {
                show: !1
            }, o = {
                name: "活动已结束",
                status: 6,
                show: !0
            }), r.btn = {
                a: t,
                b: o
            }, e(r);
        });
    });
}, JoinBargainData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("JoinBargain", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HelpBargainData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HelpBargain", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BargainPayData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BargainPay", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BargainPaySuccessData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BargainPaySuccess", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HelpBargainListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HelpBargainList", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showTime = (0, _rewx.getFullDay)(o[t].createtime);
            e(o);
        });
    });
}, MylessonData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Mylesson", e).then(function(a) {
        return new Promise(function(e, n) {
            var t = new Date().getTime() / 1e3;
            for (var o in a) {
                a[o].showTime = (0, _rewx.getFullDay)(a[o].start_time);
                var i = a[o].end_time;
                a[o].btn = i < t ? "课程结束" : "查看课程";
            }
            e(a);
        });
    });
}, TodayLessonData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("TodayLesson", e).then(function(a) {
        return new Promise(function(e, n) {
            var t = new Date().getTime() / 1e3;
            for (var o in a) {
                a[o].showTime = (0, _rewx.getFullDay)(a[o].start_time);
                var i = a[o].end_time;
                a[o].btn = i < t ? "课程结束" : "查看课程";
            }
            e(a);
        });
    });
}, BreakclassifyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Breakclassify", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].choose = !1;
            e(o);
        });
    });
}, BreaklistData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Breaklist", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BreakDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BreakDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BreakComData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BreakCom", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CollectData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Collect", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BreakComListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BreakComList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, UserAuthData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("UserAuth", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, PrizeInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("PrizeInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DelPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DelPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, OrderLogData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("OrderLog", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showTime = (0, _rewx.getFullDay)(o[t].start_time);
            e(o);
        });
    });
}, MycourseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Mycourse", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showTime = (0, _rewx.getFullDay)(o[t].courseinfo.start_time);
            e(o);
        });
    });
}, MyteacherData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Myteacher", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].like = !0;
            e(o);
        });
    });
}, MyPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyBreakData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyBreak", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].like = !0;
            e(o);
        });
    });
}, CourseCollectData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CourseCollect", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].like = !0;
            e(o);
        });
    });
}, SignInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("SignInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdminInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AdminInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindUserData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindUser", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AddAdminData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AddAdmin", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, QxAdminData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("QxAdmin", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyCouponData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyCoupon", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].info.showtime = (0, _rewx.getFullDay)(o[t].info.end_time);
            e(o);
        });
    });
}, MyBargainData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyBargain", e).then(function(o) {
        return new Promise(function(e, n) {
            for (var t in o) o[t].showtime = (0, _rewx.getFullDay)(o[t].course_info.start_time);
            e(o);
        });
    });
}, BargainOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BargainOrder", e).then(function(t) {
        return new Promise(function(e, n) {
            t.showtime = (0, _rewx.getFullDay)(t.kjinfo.buytime), e(t);
        });
    });
}, OrderListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("OrderList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, OrderStatusData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("OrderStatus", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdpicData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Adpic", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NavsetData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Navset", e).then(function(o) {
        return new Promise(function(e, n) {
            var t = {
                foot: [ {}, {}, {}, {} ],
                mine: {}
            };
            t.foot[0].txt = o.nav_name_one ? o.nav_name_one : "首页", t.foot[1].txt = o.nav_name_two ? o.nav_name_two : "课表", 
            t.foot[2].txt = o.nav_name_three ? o.nav_name_three : "课间", t.foot[3].txt = o.nav_name_four ? o.nav_name_four : "我的", 
            t.foot[0].imgH = o.nav_img_a ? o.nav_img_a : "../../../resource/images/shouye-h.png", 
            t.foot[1].imgH = o.nav_img_b ? o.nav_img_b : "../../../resource/images/kebiao-h.png", 
            t.foot[2].imgH = o.nav_img_c ? o.nav_img_c : "../../../resource/images/kejian-h.png", 
            t.foot[3].imgH = o.nav_img_d ? o.nav_img_d : "../../../resource/images/wode-h.png", 
            t.foot[0].img = o.nav_img_one ? o.nav_img_one : "../../../resource/images/shouye.png", 
            t.foot[1].img = o.nav_img_two ? o.nav_img_two : "../../../resource/images/kebiao.png", 
            t.foot[2].img = o.nav_img_three ? o.nav_img_three : "../../../resource/images/kejian.png", 
            t.foot[3].img = o.nav_img_four ? o.nav_img_four : "../../../resource/images/wode.png", 
            t.foot[0].imgS = !!o.nav_img_one, t.foot[1].imgS = !!o.nav_img_two, t.foot[2].imgS = !!o.nav_img_three, 
            t.foot[3].imgS = !!o.nav_img_four, t.mine.txtA = o.my_name_one ? o.my_name_one : "我的课程", 
            t.mine.txtB = o.my_name_two ? o.my_name_two : "约课记录", t.mine.txtC = o.my_name_three ? o.my_name_three : "授课老师", 
            t.mine.txtD = o.my_name_four ? o.my_name_four : "我的收藏", t.mine.txtE = o.my_name_five ? o.my_name_five : "集卡奖品", 
            t.mine.txtF = o.my_name_six ? o.my_name_six : "管理入口", t.mine.txtG = o.mycoupon_name ? o.mycoupon_name : "我的优惠券", 
            t.mine.txtH = o.mykanjia_name ? o.mykanjia_name : "我的砍价", t.mine.txtI = o.kf_name ? o.kf_name : "客服", 
            t.mine.imgAF = o.my_img_one ? o.my_img_one : "../../resource/images/mine/watch.png", 
            t.mine.imgBF = o.my_img_two ? o.my_img_two : "../../resource/images/mine/record.png", 
            t.mine.imgCF = o.my_img_three ? o.my_img_three : "../../resource/images/mine/teacher.png", 
            t.mine.imgDF = o.my_img_four ? o.my_img_four : "../../resource/images/home/11.png", 
            t.mine.imgEF = o.my_img_five ? o.my_img_five : "../../resource/images/home/12.png", 
            t.mine.imgFF = o.my_img_six ? o.my_img_six : "../../resource/images/home/13.png", 
            t.mine.imgGF = o.mycoupon_icon ? o.mycoupon_icon : "../../resource/images/home/11.png", 
            t.mine.imgHF = o.mykanjia_icon ? o.mykanjia_icon : "../../resource/images/home/12.png", 
            t.mine.imgIF = o.kf_icon ? o.kf_icon : "../../resource/images/home/11.png", t.mine.imgA = !!o.my_img_one, 
            t.mine.imgB = !!o.my_img_two, t.mine.imgC = !!o.my_img_three, t.mine.imgD = !!o.my_img_four, 
            t.mine.imgE = !!o.my_img_five, t.mine.imgF = !!o.my_img_six, t.mine.imgG = !!o.mycoupon_icon, 
            t.mine.imgH = !!o.mykanjia_icon, t.mine.imgI = !!o.kf_icon, e(t);
        });
    });
}, ColorData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Color", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FootnavData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Footnav", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, SupportData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Support", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, UrlData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Url", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, OpenidData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Openid", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    }, function(t) {
        return new Promise(function(e, n) {
            n(t);
        });
    });
}, SaveAvatarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Login", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    }, function(t) {
        return new Promise(function(e, n) {
            n(t);
        });
    });
}, checkSessions = function() {
    return new Promise(function(e, n) {
        var t = wx.getStorageSync("userInfo");
        t.session_key ? wx.checkSession({
            success: function() {
                n(t);
            },
            fail: function() {
                t.session_key = "", wx.removeStorageSync("userInfo"), e();
            }
        }) : e();
    });
}, getUserInfo = function() {
    return checkSessions().then(function(e) {
        return Login();
    });
}, Login = function() {
    return new Promise(function(e, t) {
        var o = {
            openid: "",
            session_key: "",
            wxInfo: ""
        };
        wx.login({
            success: function(e) {
                var n = e.code;
                OpenidData({
                    code: n
                }).then(function(e) {
                    (e = JSON.parse(e)).openid ? (o.openid = e.openid, o.session_key = e.session_key, 
                    o.code = n, o.login = !1, wx.setStorageSync("userInfo", o), t(o)) : wx.showModal({
                        title: e.errcode + "",
                        content: e.errmsg,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && getUserInfo();
                        }
                    });
                });
            }
        });
    });
}, gps = function() {
    return new Promise(function(n, e) {
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                n(e);
            },
            fail: function(e) {
                n(0);
            }
        });
    });
}, PaySuccessData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("PaySuccess", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, appPay = function(e) {
    return new Promise(function(n, t) {
        wx.requestPayment({
            timeStamp: res.timeStamp,
            nonceStr: res.nonceStr,
            package: res.package,
            signType: res.signType,
            paySign: res.paySign,
            success: function(e) {
                n(data);
            },
            fail: function(e) {
                t(e);
            }
        });
    });
};

function getDate(e, n) {
    var t = null;
    return 0 == e ? t = new Date() : 1 == e ? (t = new Date()).setDate(t.getDate() + 1) : 2 == e ? t = new Date(1e3 * n) : 3 == e && (t = new Date(1e3 * n)).setDate(t.getDate() + 1), 
    t.getFullYear() + "-" + (9 < t.getMonth() + 1 ? t.getMonth() + 1 : "0" + (t.getMonth() + 1)) + "-" + (9 < t.getDate() ? t.getDate() : "0" + t.getDate());
}

function getTime(e, n) {
    var t = null;
    return 0 == e ? t = new Date() : 1 == e ? (t = new Date()).setDate(t.getDate() + 1) : 2 == e ? t = new Date(1e3 * n) : 3 == e && (t = new Date(1e3 * n)).setDate(t.getDate() + 1), 
    (9 < t.getHours() ? t.getHours() : "0" + t.getHours()) + ":" + (9 < t.getMinutes() ? t.getMinutes() : "0" + t.getMinutes());
}

function getTimeStr(e) {
    return e = (e = e.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(e[0], e[1] - 1, e[2], e[3], e[4]).getTime() / 1e3;
}

module.exports = {
    IndexData: IndexData,
    NearbyData: NearbyData,
    DefaultSchoolData: DefaultSchoolData,
    WeData: WeData,
    AdsignData: AdsignData,
    NewsclassifyData: NewsclassifyData,
    NewslistData: NewslistData,
    NewsDetailsData: NewsDetailsData,
    CardlistData: CardlistData,
    CardDetailsData: CardDetailsData,
    CardShareData: CardShareData,
    CardDrawData: CardDrawData,
    CardGetprizeData: CardGetprizeData,
    AllCourseData: AllCourseData,
    CourseOrderData: CourseOrderData,
    CourseClassifyData: CourseClassifyData,
    CourseListData: CourseListData,
    TeacherListData: TeacherListData,
    TeacherDetailsData: TeacherDetailsData,
    TeachCourseData: TeachCourseData,
    CourseDetailsData: CourseDetailsData,
    CourseSignData: CourseSignData,
    LessonInfoData: LessonInfoData,
    SchoolListData: SchoolListData,
    GetPrizeSchoolData: GetPrizeSchoolData,
    QrpicData: QrpicData,
    DelimgData: DelimgData,
    CouponListData: CouponListData,
    GetCouponData: GetCouponData,
    CanUseData: CanUseData,
    BargainListData: BargainListData,
    BargainInfoData: BargainInfoData,
    JoinBargainData: JoinBargainData,
    HelpBargainData: HelpBargainData,
    BargainPayData: BargainPayData,
    BargainPaySuccessData: BargainPaySuccessData,
    HelpBargainListData: HelpBargainListData,
    MylessonData: MylessonData,
    TodayLessonData: TodayLessonData,
    BreakclassifyData: BreakclassifyData,
    BreaklistData: BreaklistData,
    BreakDetailsData: BreakDetailsData,
    BreakComData: BreakComData,
    CollectData: CollectData,
    BreakComListData: BreakComListData,
    UserAuthData: UserAuthData,
    PrizeInfoData: PrizeInfoData,
    DelPrizeData: DelPrizeData,
    OrderLogData: OrderLogData,
    MycourseData: MycourseData,
    MyteacherData: MyteacherData,
    MyPrizeData: MyPrizeData,
    MyBreakData: MyBreakData,
    CourseCollectData: CourseCollectData,
    SignInfoData: SignInfoData,
    AdminInfoData: AdminInfoData,
    FindUserData: FindUserData,
    AddAdminData: AddAdminData,
    QxAdminData: QxAdminData,
    MyCouponData: MyCouponData,
    MyBargainData: MyBargainData,
    BargainOrderData: BargainOrderData,
    OrderListData: OrderListData,
    OrderStatusData: OrderStatusData,
    AdpicData: AdpicData,
    NavsetData: NavsetData,
    ColorData: ColorData,
    FootnavData: FootnavData,
    SupportData: SupportData,
    UrlData: UrlData,
    OpenidData: OpenidData,
    SaveAvatarData: SaveAvatarData,
    getUserInfo: getUserInfo,
    gps: gps,
    PaySuccessData: PaySuccessData,
    appPay: appPay
};