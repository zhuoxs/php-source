var params = { "keyword": "", "class": 0, "order": 0, "page": 1 };
$(function ($) {
  /*region 封装方法*/
  //载入商品
  var reload = function () {
    /*更新分类UI*/
    $("#filter-classify li").removeClass("cur");
    var _class = $("#filter-classify li[data-id='" + params.class + "']").addClass("cur").text().replace("\u6240\u6709", "");
    $("#filter .filter-box li:first-child label").text(_class);
    /*--------*/

    /*更新排序UI*/
    $("#filter .filter-box li:not(:first-child)").removeClass("cur").eq(params.order).addClass("cur");
    /*--------*/

    /*重置iscroll*/
    $(".content-box").empty();
    pageNoEL.value = params.page;
    myScroll.refresh();
    endLoadEl.html('<i class="loading"></i>' + message_loading);
    /*--------*/

    $.post("?act=getlist&r=" + Math.random(), params, function (result) {
      lockEndLoad = false;
      EndCallback();
      if ($.trim(result.message) == "") {
        lockEndLoad = true;
        endLoadEl.html(message_nogoods);
      }
      else {
        $(".content-box").html(result.message);
      }
      myScroll.refresh();
    }, 'json');
  }

  //搜索记录
  var updateLocalStorage = function () {
    if (typeof (localStorage.searchhistory) != "undefined" && localStorage.searchhistory != "") {
      var arr = JSON.parse(localStorage.searchhistory);
      $("#search-box1 ul").empty();
      for (var i in arr) {
        $("#search-box1 ul").append('<li><a href="javascript:void(0);">' + arr[i] + '</a></li>');
      }
      $("#search-box1").show();
    }
    else {
      $("#search-box1").hide();
    }
  }
  /*end 封装方法*/

  //点击logo返回首页
  $("header .logo").on("tap", function () { location.href = "index.php"; });

  /*region 搜索*/
  //焦点搜索框后触发搜索页
  $("header .keyword").on("focusin tap", function () {
    $("body").addClass("search-box");
    if ($(this).val() != "") $("header em").show();
    updateLocalStorage();
  });

  //监听搜索框显示清空搜索框内容小按钮
  $("header .keyword").on("input propertychange", function () {
    if (!$(this).val()) {
      $("header em").hide();
    } else {
      $("header em").show();
    }
  });

  //清空搜索框内容小按钮
  $("header em").on("tap", function () {
    $("header .keyword").val('');
    $(this).hide();
  });

  //触击关闭按钮关闭搜索页
  $("header .close").on("touchstart", function () {
    searchClose();
  });

  //关闭搜索页
  var searchClose = function () {
    $("header .keyword").val(params.keyword);
    $("header em").hide();
    $("body").removeClass("search-box");
    $("header .keyword").blur();
  }

  //搜索提交
  $("header form").eq(0).on("submit", function (e) {
    e.preventDefault();
    var arr = new Array();
    if (typeof (localStorage.searchhistory) != "undefined" && localStorage.searchhistory != "") {
      arr = JSON.parse(localStorage.searchhistory);
    }
    if ($("header .keyword").val() != "" && $.inArray($("header .keyword").val(), arr) < 0) {
      if (arr.length == 18) {
        arr.pop();
      }
      else if (arr.length > 18) {
        arr = arr.slice(0, 17);
      }
      arr.unshift($("header .keyword").val());
      try {
        localStorage.searchhistory = JSON.stringify(arr);
      } catch (e) { }
    }
    params.keyword = $("header .keyword").val();
    params.class = params.order = 0;
    params.page = 1;

    searchClose();
    reload();
    return false;
  });

  //清空搜索记录
  $("#search-box1 p a").on("click", function () { localStorage.searchhistory = ''; $("#search-box1").hide(); });

  //最近搜索，热门搜索按钮提交搜索
  $("#search-box li a").live("tap", function () {
    $("header .keyword").val($(this).text());
    $("header form").eq(0).submit();
  });
  /*end 搜索*/

  /*region 分类*/
  var classifyScroll = new IScroll('#filter-classify', {
    tap: true, click: false, scrollbars: true, fadeScrollbars: true, interactiveScrollbars: false, keyBindings: false, deceleration: 0.0002
  });

  $("#filter .filter-box li:first-child").on("tap", function (e) {
    $(".container").addClass("show");
  });

  $(".container-box .container header .icon-goback").on("tap", function (e) {
    $(".container").removeClass("show");
  });

  $("#filter-classify li").on("tap", function () {
    if ($(this).hasClass("cur")) return false;
    $(".container-box .container header .icon-goback").trigger("tap");
    params.class = $(this).data("id");
    params.order = 0;
    params.page = 1;
    reload();
  });
  /*end 分类*/

  /*region 排序方式*/
  $("#filter .filter-box li:not(:first-child)").on("tap", function (e) {
    if ($(this).hasClass("cur")) return false;
    params.order = $(this).index() - 1;
    params.page = 1;
    reload();
  });
  /*end 排序方式*/

  //立即发送
  $(".content-box .btn a:first-child").live("tap", function () {
    var that = $(this);
    if (that.hasClass("disabled")) return false;
    that.addClass("disabled").text("加入队列");
    var goods = new Object();
    goods.goods_id = $(this).parents("li").data("id");
    goods.goods_name = $(this).parents("li").find("h3").text();
    goods.goods_url = $(this).parents("li").find(".thumb").prop("href");
    goods.goods_pic = $(this).parents("li").find(".thumb img").prop("src");
    goods.goods_price = $(this).parents("li").data("price");
    goods.goods_favprice = $(this).parents("li").data("favprice");
    goods.goods_commission = $(this).parents("li").data("commission");
    goods.goods_time = $(this).parents("li").data("time");
    $.post("?act=send&r=" + Math.random(), goods, function (result) {
      if (result.error == 0) {
        that.parents("li").find(".num").each(function () {
          $(this).text(parseInt($(this).text()) + 1);
        });
        that.text("已入队列");
      }
      else if (result.error == 1) {
        alert(result.message);
        that.siblings().trigger("tap");
      }
      else {
        that.removeClass("disabled").text(result.message);
      }
    }, 'json');
  })

  //收藏
  $(".content-box .btn a:nth-child(2)").live("tap", function () {
    var that = $(this);
    if (that.hasClass("disabled")) return false;
    that.addClass("disabled");
    var goods = new Object();
    goods.goods_id = $(this).parents("li").data("id");
    goods.goods_name = $(this).parents("li").find("h3").text();
    goods.goods_url = $(this).parents("li").find(".thumb").prop("href");
    goods.goods_pic = $(this).parents("li").find(".thumb img").prop("src");
    goods.goods_price = $(this).parents("li").data("price");
    goods.goods_favprice = $(this).parents("li").data("favprice");
    goods.goods_commission = $(this).parents("li").data("commission");
    goods.goods_time = $(this).parents("li").data("time");
    $.post("?act=favorite&r=" + Math.random(), goods, function (result) {
      if (result.error == 0) {
        that.text("已收藏");
        $("nav em").text(parseInt($("nav em").text()) + 1);
      }
    }, 'json');
  })

  //托管
  $(".auto-msg").on("tap", function () {
    var that = $(this);
    if (that.hasClass("disabled")) return false;
    that.addClass("disabled");
    var e = true;
    if (that.hasClass("on")) e = false;
    $.post("?act=automsg&r=" + Math.random(), { v: e }, function (result) {
      that.removeClass("disabled");
      if (e) {
        that.addClass("on");
      }
      else {
        that.removeClass("on");
      }
    }, 'json');
  })

  //手工
  $(".content-box .btn a:nth-child(3)").live("tap", function () {
    var that = $(this);
    if (that.hasClass("disabled")) return false;
    that.addClass("disabled");
    var goods = new Object();
    goods.goods_id = $(this).parents("li").data("id");
    goods.goods_name = $(this).parents("li").find("h3").text();
    goods.goods_url = $(this).parents("li").find(".thumb").prop("href");
    goods.goods_pic = $(this).parents("li").find(".thumb img").prop("src");
    goods.goods_price = $(this).parents("li").data("price");
    goods.goods_favprice = $(this).parents("li").data("favprice");
    goods.goods_commission = $(this).parents("li").data("commission");
    goods.goods_time = $(this).parents("li").data("time");
    $.post("?act=manual&r=" + Math.random(), goods, function (result) {
      if (result.error == 0) {
        var coupon = $(that).parents("li").find(".coupon");
        coupon.show();
        coupon.find(".coupon p").text(result.message);
        coupon.find(".coupon .textarea").data("text", result.message).text(result.message);
        myScroll.refresh();
      }
      else {
        alert(result.message);
        that.removeClass("disabled");
      }
    }, 'json');
  })

  document.addEventListener("selectionchange", function (e) {
    sel = window.getSelection().anchorNode;
    if (sel != null && sel.parentNode.tagName == 'P' && sel.parentNode.className == 'coupon-text') {
      window.getSelection().selectAllChildren(sel.parentNode);
    }
  }, false);

  $(".content-box .textarea").bind("tap input propertychange", function (e) {
    e.preventDefault();
    $(this).blur();
    return false;
  }).on("blur", function () {
    $(this).text($(this).data("text"));
  });

  //后退重计收藏数量
  window.addEventListener('popstate', function (e) {
    $.post("?act=getfavorinum&r=" + Math.random(), params, function (result) {
      if (result.error == 0) $("nav em").text(result.message);
    }, 'json');
  }, false);

  trigger_myScroll();

  //iscroll
  var filter_top = $("#filter").position().top;
  var goods_rows_height = $(".content-box li:first-child").height();
  var PageEvent, topLoadEl, endLoadEl, lockTopLoad = false, lockEndLoad = false, pageNoEL;
  var message_loading = "加载中...",
      message_nodate = "没有更多了",
      message_nogoods = "暂无相关商品";

  var TopCallback = function () {
    if (topLoadEl) topLoadEl.hide().empty();
  }

  var EndCallback = function () {
    if (endLoadEl) endLoadEl.empty();
  }

  var pullActionDetect = function () {

    if (myScroll.y <= filter_top * -1) {
      $("#filter").addClass("scroll");
      $("#content").addClass("scroll");
      myScroll.refresh();
    } else {
      $("#filter").removeClass("scroll");
      $("#content").removeClass("scroll");
      myScroll.refresh();
    }

    var el = document.querySelectorAll(".page-container"),
        i = 0,
        offset = goods_rows_height * 2;
    for (; i < el.length; i++) {
      if (myScroll.y <= el[i].offsetTop * -1 + offset) {
        pageNoEL.value = el[i].dataset.page;
      }
    }

    if (myScroll.y >= 0 && topLoadEl) {
      var first_el = document.querySelector(".page-container:first-child");
      if (lockTopLoad || first_el.dataset.page <= 1) { return; }
      lockTopLoad = true;
      topLoadEl.show().html('<i class="loading"></i>' + message_loading);
      params.page = first_el.dataset.page - 1;
      $.ajax({
        type: 'POST',
        url: '?act=getlist&r=' + Math.random(),
        data: params,
        dataType: 'json',
        success: function (result) {
          lockTopLoad = false;
          TopCallback();
          if ($.trim(result.message) == "") {
            lockTopLoad = true;
          }
          else {
            $(".content-box").prepend(result.message);
          }
          myScroll.refresh();
          if (PageEvent == "prev") {
            PageEvent = null;
            pageNoEL.value = params.page;
            myScroll.scrollToElement(".page-container.page_" + params.page, 0, 300);
          }
          else {
            myScroll.scrollToElement(first_el, 0, 0, goods_rows_height / 2 * -1);
          }
        },
        error: function (xhr, type) {

          myScroll.refresh();
          TopCallback();
        }
      });
    }

    if (myScroll.y <= (myScroll.maxScrollY + goods_rows_height * 3) && endLoadEl) {
      if (lockEndLoad) { return; }
      lockEndLoad = true;
      endLoadEl.html('<i class="loading"></i>' + message_loading);
      params.page = parseInt(document.querySelector(".page-container:last-child").dataset.page) + 1;
      $.ajax({
        type: 'POST',
        url: '?act=getlist&r=' + Math.random(),
        data: params,
        dataType: 'json',
        success: function (result) {
          lockEndLoad = false;
          EndCallback();
          if ($.trim(result.message) == "") {
            lockEndLoad = true;
            endLoadEl.html(message_nodate);
          }
          else {
            $(".content-box").append(result.message);
          }
          myScroll.refresh();
          if (PageEvent == "next") {
            PageEvent = null;
            pageNoEL.value = params.page;
            myScroll.scrollToElement(".page-container.page_" + params.page, 0, 300);
          }
        },
        error: function (xhr, type) {
          myScroll.refresh();
          EndCallback();
        }
      });
    }
  }

  function trigger_myScroll(offset) {
    topLoadEl = $('#content .topLoad');
    endLoadEl = $('#content .endLoad');
    pageNoEL = document.querySelector("input[name=pageNo]");
    myScroll = new IScroll('#content', {
      //probeType: 1,
      //preventDefaultException: { tagName: /.*/ },
      //momentum: false,
      preventDefault: false, bounce: false, tap: true, click: false, mouseWheel: false, scrollbars: true, fadeScrollbars: false, interactiveScrollbars: false, keyBindings: false, //deceleration: 0.0002
    });

    //myScroll.on('scrollStart', function () {});
    myScroll.on('scroll', function () {
      pullActionDetect();
    });
    myScroll.on('scrollEnd', function () {
      pullActionDetect();
    });
  }

  $(".pager .pager-btn").on('touchend', function (e) {
    e.preventDefault();
    $(this).parents('.pager').toggleClass('expended');
  })

  $(".pager .pager-prev").on('tap', function () {
    if ($(this).hasClass("disabled")) return;
    params.page = parseInt(pageNoEL.value) - 1;
    gotopage("prev");
  });

  $(".pager .pager-next").on('tap', function () {
    if ($(this).hasClass("disabled")) return;
    params.page = parseInt(pageNoEL.value) + 1;
    gotopage("next");
  });

  pageNoEL.addEventListener('focusin', function () { this.placeholder = this.value; this.value = ''; }, false);
  pageNoEL.addEventListener('focusout', function () { if (this.value == "" || this.value <= 0) { this.value = this.placeholder; this.placeholder = ''; } }, false);
  document.querySelector("form[name=pageForm]").addEventListener('submit', function (e) {
    e.preventDefault();
    params.page = pageNoEL.value;
    gotopage("page");
    return false;
  }, false);

  var gotopage = function (v) {
    var page_el = document.querySelector(".page-container.page_" + params.page);
    if (page_el) {
      if (page_el === document.querySelector(".page-container:first-child")) {
        myScroll.scrollToElement(page_el, 0);
      }
      else {
        myScroll.scrollToElement(page_el, 300);
      }
      pageNoEL.value = params.page;
      return;
    }
    if (v == "prev") {
      PageEvent = "prev";
      myScroll.scrollTo(0, endLoadEl.height(), 0);
      pullActionDetect();
      return;
    }
    else if (v == "next") {
      PageEvent = "next";
      myScroll.scrollTo(0, myScroll.maxScrollY, 300);
      return;
    }
    else if (v == "page") {
      reload();
    }
  }

  document.addEventListener('touchmove', preventDefault, false);

});