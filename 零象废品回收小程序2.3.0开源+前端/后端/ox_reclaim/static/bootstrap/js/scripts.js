
// common scripts

(function() {
    "use strict";

   // Sidebar toggle

   jQuery('.menu-list > a').click(function() {
      
      var parent = jQuery(this).parent();
      var sub = parent.find('> ul');
      
      if(!jQuery('body').hasClass('sidebar-collapsed')) {
         if(sub.is(':visible')) {
            sub.slideUp(300, function(){
               parent.removeClass('nav-active');
               jQuery('.body-content').css({height: ''});
               adjustMainContentHeight();
            });
         } else {
            visibleSubMenuClose();
            parent.addClass('nav-active');
            sub.slideDown(300, function(){
                adjustMainContentHeight();
            });
         }
      }
      return false;
   });

   function visibleSubMenuClose() {

      jQuery('.menu-list').each(function() {
         var t = jQuery(this);
         if(t.hasClass('nav-active')) {
            t.find('> ul').slideUp(300, function(){
               t.removeClass('nav-active');
            });
         }
      });
   }

   function adjustMainContentHeight() {

      // Adjust main content height
      var docHeight = jQuery(document).height();
      if(docHeight > jQuery('.body-content').height())
         jQuery('.body-content').height(docHeight);
   }

   // add class mouse hover

   jQuery('.side-navigation > li').hover(function(){
      jQuery(this).addClass('nav-hover');
   }, function(){
      jQuery(this).removeClass('nav-hover');
   });


   // Toggle Menu

   jQuery('.toggle-btn').click(function(){

      var body = jQuery('body');
      var bodyposition = body.css('position');

      if(bodyposition != 'relative') {

         if(!body.hasClass('sidebar-collapsed')) {
            body.addClass('sidebar-collapsed');
            jQuery('.side-navigation ul').attr('style','');

         } else {
            body.removeClass('sidebar-collapsed chat-view');
            jQuery('.side-navigation li.active ul').css({display: 'block'});

         }
      } else {

         if(body.hasClass('sidebar-open'))
            body.removeClass('sidebar-open');
         else
            body.addClass('sidebar-open');

         adjustMainContentHeight();
      }


   });
   

   searchform_reposition();

   jQuery(window).resize(function(){

      if(jQuery('body').css('position') == 'relative') {

         jQuery('body').removeClass('sidebar-collapsed');

      } else {

         jQuery('body').css({left: '', marginRight: ''});
      }

      searchform_reposition();

   });

   function searchform_reposition() {
      if(jQuery('.search-content').css('position') == 'relative') {
         jQuery('.search-content').insertBefore('.sidebar-left-info .search-field');
      } else {
         jQuery('.search-content').insertAfter('.right-notification');
      }
   }

    // right slidebar

    $(function(){
        $.slidebars();
    });

    // body scroll

//     $("html").niceScroll({
//         styler: "fb",
//         cursorcolor: "#a979d1",
//         cursorwidth: '5',
//         cursorborderradius: '15px',
//         background: '#404040',
//         cursorborder: '',
//         zindex: '12000'
//     });
//
//     $(".notification-list-scroll").niceScroll({
//         styler: "fb",
//         cursorcolor: "#DFDFE2",
//         cursorwidth: '3',
//         cursorborderradius: '15px',
// //        background: '#404040',
//         cursorborder: '',
//         zindex: '12000'
//     });



    // collapsible panel
    
    $('.panel .tools .t-collapse').click(function () {
        var el = $(this).parents(".panel").children(".panel-body");
        if ($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200); }
    });


    // close panel 
    $('.panel .tools .t-close').click(function () {
        $(this).parents(".panel").parent().remove();
    });


    // side widget close

    $('.side-w-close').on('click', function(ev) {
        ev.preventDefault();
        $(this).parents('.aside-widget').slideUp();
    });
    $('.info .add-people').on('click', function(ev) {
        ev.preventDefault();
        $(this).parents('.tab-pane').children('.aside-widget').slideDown();

    });


    // refresh panel

    $('.box-refresh').on('click', function(br) {
        br.preventDefault();
        $("<div class='refresh-block'><span class='refresh-loader'><i class='fa fa-spinner fa-spin'></i></span></div>").appendTo($(this).parents('.tools').parents('.panel-heading').parents('.panel'));

        setTimeout(function() {
            $('.refresh-block').remove();
        }, 1000);

    });

    // tool tips

    $('.tooltips').tooltip();

    // popovers

    $('.popovers').popover();
	
	
//表单提交
	 $(function () {
        $('form').on('submit', function (e) {
			if($(this).attr('form-jump')!=1)
			{
				e.preventDefault();
				getSubmit(e.target, function (res) {
					layer.msg(res.msg);
						//跳转类型
						if(res.type ==1)
						{
							setTimeout(function () {
								window.location.href = res.url;
							}, 2000)
						}
						else if(res.type ==2)
						{
							setTimeout(function () {
								location.reload();
							}, 2000)
						}
						else if(res.type ==3)
						{
							setTimeout(function () {
								window.history.back(-1);
							}, 2000)
						}
				})
			}
			else
			{
				e.preventDefault();
				var url = $(this).attr('action');
            	var data = $(this).serialize();
				window.location.href = url+'&'+data;
			}
        });
		$('.btn-ajax').click(function (e) {
		    e.preventDefault();
			var title = $(this).attr('title');
			//有title属性时弹出确认层
			if(title !='')
			{
				if(confirm(title))
				{
					getajsx(this, function (res) {
						layer.msg(res.msg);
						//跳转类型
						if(res.type ==1)
						{
							setTimeout(function () {
								window.location.href = res.url;
							}, 2000)
						}
						else if(res.type ==2)
						{
							setTimeout(function () {
								location.reload();
							}, 2000)
						}
						else if(res.type ==3)
						{
							setTimeout(function () {
								window.history.back(-1);
							}, 2000)
						}
					})
				}
			}
			else
			{
				getajsx(this, function (res) {
					layer.msg(res.msg);
						//跳转类型
						if(res.type ==1)
						{
							setTimeout(function () {
								window.location.href = res.url;
							}, 2000)
						}
						else if(res.type ==2)
						{
							setTimeout(function () {
								location.reload();
							}, 2000)
						}
						else if(res.type ==3)
						{
							setTimeout(function () {
								window.history.back(-1);
							}, 2000)
						}
				})
			}
			
        });
		$('.label').click(function (e) {
		    e.preventDefault();
			getlabel(e.target, function (res) {
				console.log(res)
			})
			
        });
    })
    function getSubmit(elm, callback) {
        $.ajax({
            url: $(elm).attr('action'),
            data: $(elm).serialize(),
			type : $(elm).attr('method'),
            // success: callback
            success: function (res) {
				var res = $.parseJSON(res);
				/*bootoast({
                    message: res.msg,
                    type: res.state,
                    position:'top',
                    timeout:2
                });*/
				layer.msg(res.msg);
				//跳转类型
				if(res.type ==1)
				{
					setTimeout(function () {
						window.location.href = res.url;
					}, 2000)
				}
				else if(res.type ==2)
				{
					setTimeout(function () {
                    	location.reload();
                	}, 2000)
				}
				else if(res.type ==3)
				{
					setTimeout(function () {
                    	window.history.back(-1);
                	}, 2000)
				}
                
            },
            fail: function (res) {
                console.log(res)
            }
        })
	}
	function getajsx(elm, callback) {
        $.ajax({
            url: $(elm).attr('data-ajax'),
            data: '',
			type : 'post',
            // success: callback
            success: function (res) {
				var res = $.parseJSON(res);
				/*bootoast({
                    message: res.msg,
                    type: res.state,
                    position:'top',
                    timeout:2
                });*/
				layer.msg(res.msg);
				//跳转类型
				if(res.type ==1)
				{
					setTimeout(function () {
						window.location.href = res.url;
					}, 2000)
				}
				else if(res.type ==2)
				{
					setTimeout(function () {
                    	location.reload();
                	}, 2000)
				}
				else if(res.type ==3)
				{
					setTimeout(function () {
                    	window.history.back(-1);
                	}, 2000)
				}
                
            },
            fail: function (res) {
                console.log(res)
            }
        });
    }
	function getlabel(elm, callback) {
		var dmsg = $(elm).html();
		var lmsg = $(elm).attr('list-html');
		$(elm).html('<img src="http://p5h2w2596.bkt.clouddn.com/images/50/2018/05/Qh8AyhZghHcaZndAagdH0dHhGDPnOp.gif" height="15px">');
		var dclass = $(elm).attr('class');
		var lclass = $(elm).attr('list-class');
		$.ajax({
            url: $(elm).attr('data-ajax'),
            data: '',
			type : 'post',
            // success: callback
            success: function (res) {
				var res = $.parseJSON(res);
				if(res.state == 'danger')
				{
					$(elm).html(dmsg);
					/*bootoast({
						message: res.msg,
						type: res.state,
						position:'top',
						timeout:2
					});*/
					layer.msg(res.msg);
				}
				else
				{
					//修改文字
					$(elm).html(lmsg);
					$(elm).attr('list-html',dmsg);
					//修改背景
					$(elm).attr('class',lclass);
					$(elm).attr('list-class',dclass);
				}
			}
        });
    }



})(jQuery);