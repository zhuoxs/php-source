$(function(){
  /*折叠 一级菜单 */
  $(".sidebar-fold").click(function(){
    $(this).toggleClass("first_sidebar-unfold");
    $(this).parents('.sidebar-part').toggleClass("sidebar-mini");
    $(this).parents('.sidebar-part').siblings('.main-body').toggleClass("main-body-max");
    
  });
  $(".sidebar-nav-child .sidebar-title").click(function(){
    $(this).parent().toggleClass("sidebar-nav-active").siblings().removeClass("sidebar-nav-active");
  });

  /*折叠 二级菜单 */
  $(".main_navbar-button").click(function(){
    $(this).parent().toggleClass('main_navbar-mini');
    $(this).parent().siblings('.main_mbody').toggleClass('main_mbody-max');
    $(this).children().find('.glyphicon').toggleClass('glyphicon-indent-right').toggleClass('glyphicon-indent-left');
  });

  $(".main_navbar .nav-showchild .nav-showchild-a").click(function(){
    $(this).parent().toggleClass("sidebar-nav-active");
  });

  /*全选s */
  $(".main-table .selectAll").click(function(){
    if($(this).parent().hasClass("selected")){
      $(".main-table .selct-checkbox:not([disabled]").prop('checked',false).parent().removeClass("selected").parents('tr').removeClass("selected");
      $(".main-table .selectAll").prop('checked',false).parent().removeClass("selected").removeClass("notall");
    }else{
      $(".main-table .selct-checkbox:not([disabled])").prop('checked',true).parent().addClass("selected").parents('tr').addClass("selected");
      $(".main-table .selectAll").prop('checked',true).parent().addClass("selected");
    }
  });
  $(".main-table .selct-checkbox").click(function(){
    if($(this).parent().hasClass("selected")){
      $(this).parent().removeClass("selected").parents('tr').removeClass("selected");
    }else{
      $(this).parent().addClass("selected").parents('tr').addClass("selected");
    }
    checkboxCheck();
  });

  /*数据统计 -S-----------------------------------------------  */
  var today = new Date();
  var oneDay = 1000*60*60*24;
  var yestoday = new Date(today-oneDay);
  if($('.index-body').length>0){
    //开始时间：
    $("#new_start_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : false,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
			language : 'zh-CN',
      startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        console.log(e)
          console.log(startTime)
          $('#new_end_time').datetimepicker('setStartDate',startTime);
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : false,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
      language : 'zh-CN',
			startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        console.log(endTime)
        $('#new_start_time').datetimepicker('setEndDate',endTime);
    });
    
    $('#new_start_time').datetimepicker('setDatesDisabled',[today]);
    $('#new_end_time').datetimepicker('setDatesDisabled',[today]);
    
    $('#new_start_time').datetimepicker('remove');
    $('#new_end_time').datetimepicker('remove');

    var timing;
    $('.index_databox .control ul li').click(function(){
    //开始时间：
    $("#new_start_time").datetimepicker({
      format : "yyyy-mm-dd",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 5
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        console.log(e)
          console.log(startTime)
          $('#new_end_time').datetimepicker('setStartDate',startTime);
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
      format : "yyyy-mm-dd",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 5
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        console.log(endTime)
        $('#new_start_time').datetimepicker('setEndDate',endTime);
    });

      $(this).addClass('active').siblings().removeClass('active');
      console.log($(this).index())
      var day_type = '';
      switch($(this).index()){
        case 0:{
          timing = yestoday;
          day_type = 1;
          console.log(timing)
          break;
        }
        case 1:{
          timing =new Date(today - 7*oneDay);
          day_type = 7;
          console.log(timing)
          break;
        }
        case 2:{
          timing =new Date(today - 30*oneDay);
          day_type = 30;
          console.log(timing)
          break;
        }
      }
      
      $('#new_start_time').datetimepicker('setDate',timing);
      $('#new_end_time').datetimepicker('setDate',yestoday);
      $('#new_end_time').datetimepicker('setStartDate',timing);
      var st = $('#new_start_time').val();
      var et = $('#new_end_time').val();
      getData(day_type,st,et);
      $('#new_start_time').datetimepicker('remove');
      $('#new_end_time').datetimepicker('remove');
      $('#new_start_time').val(st);
      $('#new_end_time').val(et);

    });
  }
  /*数据统计 -E-----------------------------------------------  */
  /*文章管理 -S-----------------------------------------------  */
  if($('.neirong-con').length>0){
    $('.neirong-con .magic-radio input').click(function(){
      var index = $(this).data('value');
      $('#sortable').attr('data-maxvalue',index);
      $('#sortable').siblings('.control-tips').children('i').text(index);
      $('#sortable').children().each(function(i,item){
        if(index<=i){
          item.remove();
        }
      });
      if(index<=$('#sortable').children().length){
        $('.pro-img-add').hide();
      }else{
        $('.pro-img-add').show();
      }
    });
  }
  /*文章管理 -E-----------------------------------------------  */
  /*三级分销s-----------------------------------------------  */
  /*radio 样式添加 */
  $(".radio-checkbox-label .selct-checkbox,.magic-radio .selct-checkbox").click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
  });

  /*checkbox 样式添加 */
  $(".selct-checkbox-label .selct-checkbox").click(function(){
    $(this).parent().hasClass("selected")?$(this).parent().removeClass("selected"):$(this).parent().addClass("selected");
  });

  $(".set-sanji .set-level .selct-checkbox").click(function(){
    if($(this).val()==0){
      $(".radio-show").hide();
    }else{
      $(".radio-show").show();
      for(var i=0; i<3;i++){
        if(i<$(this).val()){
          $(".radio-show .radio-show-box").eq(i).show();
        }else{
          $(".radio-show .radio-show-box").eq(i).hide();
        }
      }
    }
  });

  $(".set-sanji .set-type .selct-checkbox").click(function(){
    if($(this).val()=="true"){
      $(this).parents(".radio-show").addClass("set-type1").removeClass("set-type2");
    }else{
      $(this).parents(".radio-show").addClass("set-type2").removeClass("set-type1");
    }
  });

  $(".set-sanji .sanji_term1 .selct-checkbox").click(function(){
    if($(this).val()=="0"){
      $(this).parents(".form-group").siblings(".term-show").hide();
    }else{
      $(this).parents(".form-group").siblings(".term-show").show().find(".addon-msg").text($(this).data("msg"));
    }
  });


  /*三级分销e -----------------------------------------------*/

  /*系统设置S -----------------------------------------------*/
  $(".control-hide").click(function(){
    $(this).hide();
  })

  /*modal */
  $(".massage_modal").click(function(){
    var msgTitle = $(this).data("title");
    var imgSrc = $(this).data("imgsrc");

    $('body').append("<div class='modal fade'id='msgModal'tabindex='-1'role='dialog'aria-labelledby='myModalLabel'><div class='modal-dialog'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>"+msgTitle+"</h4></div><div class='modal-body'><ol class='pl-3'><li><div>进入微信小程序官方后台，找到模板库</div><div style='text-align: center'><img style='max-width: 100%'src='images/tplmsg/0.png'></div></li><li><div>查找指定模板，点击选用</div><div style='text-align: center'><img style='max-width: 100%'src='images/tplmsg/"+imgSrc+"/1.png'></div></li><li><div>选择下图关键词，并按下图调好顺序；点击提交</div><div style='text-align: center'><img style='max-width: 100%'src='images/tplmsg/"+imgSrc+"/2.png'></div></li><li><div>复制模板ID</div><div style='text-align: center'><img style='max-width: 100%'src='images/tplmsg/"+imgSrc+"/3.png'></div></li></ol></div><div class='modal-footer'><button type='button'class='btn btn-default'data-dismiss='modal'>关闭</button></div></div></div></div>")

    $(".modal .btn-default").click(function(){
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      // 执行一些动作...
      $(this).remove()
    })
  });
  /*系统设置E----------------------------------------------- */

  if($(window).width()<=768){
    $('.sidebar-part').addClass("sidebar-mini");
    $('.main-body').addClass("main-body-max");
  }

  //上下架、审核
  $(".state-pro").click(function(){
    var statePro = $(this).data("statepro");
    var stateSeel = $(this).data("stateseel");
    var stateMoney = $(this).data("statemoney");
    var stateShow;
    if(statePro==true){
      stateShow = "下架";
    }else if(statePro==false){
      stateShow = "上架";
    }
    if(stateSeel==true){
      stateShow = "取消审核";
    }else if(stateSeel==false){
      stateShow = "通过审核";
    }
    if(stateMoney==false){
      stateShow = "提交审核";
    }else if(stateMoney==true){
      stateShow = "标记已打款";
    }


    $('body').append("<div class='modal fade bs-example-modal-sm pro-state'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要"+stateShow+"？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");

    $('.modal').on('hidden.bs.modal', function () {
      $(this).remove();
    });
  });

  $('[data-toggle="tooltip"]').tooltip()


  //窗口调整变化 resize 
  $(window).resize(function(){
    if($(window).width()<=768){
      $('.sidebar-part').addClass("sidebar-mini");
      $('.main-body').addClass("main-body-max");
    }
  });


  /*用户管理-S-----------------------------------------------*/
    //性别
  $(".member-list .min-img").each(function(){
    if($(this).data('sex')=="man"){
      $(this).children().addClass('man')
    }
    if($(this).data('sex')=="lady"){
      $(this).children().addClass('lady')
    }
  })
  

  $(".mem-distribution").click(function(){
    var distribution_state = $(this).parent().siblings(".distribution_state").data("distributionstate");
    var distribution_stateA = distribution_state.split(',');

    $('body').append("<div class='modal fade bs-example-modal-lg modal-member'tabindex='-1'role='dialog'aria-labelledby='myLargeModalLabel'><div class='modal-dialog modal-lg'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>分配负责人</h4></div><div class='modal-body'><ul class='modal-con'><li>*进行分配负责人操作后，负责人可查看分配给自己的会员信息;</li><li>*未分配负责人的会员，所有人均可查看会员信息；</li></ul><div class='modal-checkbox'><ul><li><span class='title'>分配负责人</span></li></ul></div></div><div class='modal-footer'><button type='button'class='btn btn-primary'>分配</button><button type='button'class='btn btn-default'data-dismiss='modal'>关闭</button></div></div></div></div>");

    for(var i=0,pass=true;i<distributionList.length;i++){
      for(var j=0;j<distribution_stateA.length;j++){
        if(distribution_stateA[j]==distributionList[i]){
          $(".modal-member .modal-checkbox ul").append("<li><label class='selct-checkbox-label selected'><input class='selct-checkbox' type='checkbox' name='distribution' checked='checked'>"+distributionList[i]+"</label></li>")
          pass=false;
        }
      }
      if(pass){
        $(".modal-member .modal-checkbox ul").append("<li><label class='selct-checkbox-label'><input class='selct-checkbox' type='checkbox' name='distribution'>"+distributionList[i]+"</label></li>")
      }else{
        pass=true;
      }
    }

    $(".modal .btn-default").click(function(){
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      // 执行一些动作...
      $(this).remove();
    })

    $(".selct-checkbox-label .selct-checkbox").click(function(){
      $(this).parent().hasClass("selected")?$(this).parent().removeClass("selected"):$(this).parent().addClass("selected");
    });
  });

  //批量操作 分配
  $(".mem-distribution-all").click(function(){

    $('body').append("<div class='modal fade bs-example-modal-lg modal-member'tabindex='-1'role='dialog'aria-labelledby='myLargeModalLabel'><div class='modal-dialog modal-lg'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>分配负责人</h4></div><div class='modal-body'><ul class='modal-con'><li>*进行分配负责人操作后，负责人可查看分配给自己的会员信息;</li><li>*未分配负责人的会员，所有人均可查看会员信息；</li></ul><div class='modal-checkbox'><ul><li><span class='title'>分配负责人</span></li></ul></div></div><div class='modal-footer'><button type='button'class='btn btn-primary'>分配</button><button type='button'class='btn btn-default'data-dismiss='modal'>关闭</button></div></div></div></div>");

    for(var i=0;i<distributionList.length;i++){
        $(".modal-member .modal-checkbox ul").append("<li><label class='selct-checkbox-label'><input class='selct-checkbox' type='checkbox' name='distribution'>"+distributionList[i]+"</label></li>")
    }

    $(".modal .btn-default").click(function(){
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      // 执行一些动作...
      $(this).remove();
    })

    $(".selct-checkbox-label .selct-checkbox").click(function(){
      $(this).parent().hasClass("selected")?$(this).parent().removeClass("selected"):$(this).parent().addClass("selected");
    });
  });

  $('.member-set ul a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    e.target // newly activated tab
    e.relatedTarget // previous active tab
  })
  
  
  /*用户管理-E-----------------------------------------------*/

  /*魔方推荐-S-----------------------------------------------*/
  $(".magic-inputfile .control-input").click(function(){
    $(this).siblings(".inputfile").click();
  });
  $(".magic-inputfile .btn").click(function(){
    $(this).parent().siblings(".inputfile").click();
  });

  /*删除魔方 */
  // $(".delete-tr").click(function(){
  //   $(this).parents("tr").remove();
  //   changeMagicNum(magicNum-1);
  //   console.log("第一次删除")
  // });
  //添加魔方
  var magicSortableId=1;
  $(".magic-add").click(function(){
    var magicNum = $(this).parents("tfoot").siblings("tbody").children().length+1;
    if(magicNum>4){
      $.Toast("提示", "最多添加4张图片！", "notice", {});
    }else{
      $(this).parents("tfoot").siblings("tbody").append("<tr data-sortable='"+magicSortableId+"'><td><botton class='bttn btn-default btn-sortable ui-state-active'><span class='ui-icon ui-icon-arrow-4'></span></botton></td><td class='input-img'><div class='input-group magic-inputfile  img-item'><div class='input-group-addon'style='padding: 0 5px;'data-container='body'data-toggle='popover'data-placement='bottom'data-content=''><img src='images/img01.jpg'style='height:20px;width:20px'onerror=''></div><input type='text'class='control-input form-control'name='magic_img0'value='images.jpg'readonly><div class='input-group-btn'><button type='button'class='bttn  btn-default'>选择图片</button></div><input type='file'name=''class='inputfile'></div></td><td><div class='input-group img-item'><input type='text'class=' control-input form-control valid'name='magic_img'value='images/331/2018/03/teF6qIbDFQtbGl5fCZLt7D44g7IZ7b.jpg'readonly><div class='input-group-btn'><button type='button'class='bttn  btn-default btn-select-pic'>选择链接</button></div></div></td><td><a href='javascript:;'class='delete-tr'onclick='deleteTr(this)'><span class='label label-danger'>删除</span></a></td></tr>a");
      magicSortableId++;
    //  console.log(magicNum)
      changeMagicNum();
     console.log("添加事件触发选项变动")
    }
  });


  



  /*魔方图片选择hover特效 */
  $('.magic-radio>label').each(function(){
    $(this).hover(function(){
      $(this).find('.border-left,.border-right').stop().animate({height:$(this).height()+'px'},400);
      $(this).find('.border-top,.border-bottom').stop().animate({width:$(this).width()+'px'},400);
    },function(){
      $(this).find('.border-left,.border-right').stop().animate({height:'0'},400);
      $(this).find('.border-top,.border-bottom').stop().animate({width:'0'},400);
    });
  });

  /*魔方推荐-E-----------------------------------------------*/

  
  /*店员管理-S-----------------------------------------------*/
  //状态启动
  $(".clerk-switch:not(.disabled)").click(function(){
    var that = this,stateShow;
    var stateClerk = $(this).data("stateclerk");
    if(stateClerk){
      stateShow = "停用";
    }else{
      stateShow = "启用";
    }
    $('body').append("<div class='modal fade bs-example-modal-sm clerk-switch-modal'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要"+stateShow+"？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
     //点击确认
    $(".modal .btn-primary").click(function(){
      if(stateClerk){
        $(that).data("stateclerk",!stateClerk);
        $(that).children().removeClass("label-success").addClass("label-warning").text("停用");
      }else{
        $(that).data("stateclerk",!stateClerk);
        $(that).children().removeClass("label-warning").addClass("label-success").text("正常");
      }
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      $(this).remove();
    });
  });
  //删除店员 -删除职位
  $(".clerk-delete:not(.disabled)").click(function(){
    var that = this;
    $('body').append("<div class='modal fade bs-example-modal-sm clerk-delete-modal'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要删除该用户？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
    //点击确认
    $(".modal .btn-primary").click(function(){
      $(that).parents("tr").remove();
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      $(this).remove();
    });
  });
  //设置排班 
  $(".clerk-scheduling").click(function(){
    var that = this;
    
    // $('body').append("<div class='modal fade bs-example-modal-lg clerk-scheduling-modal'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要删除该用户？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
    // $('body').append("<div class='modal fade bs-example-modal-lg clerk-scheduling-modal'tabindex='-1'role='dialog'aria-labelledby='myLargeModalLabel'><div class='modal-dialog modal-lg'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>排班安排</h4></div><div class='modal-body'><h5>统一设定员工每周工作时间，员工可自行修改,排班开始时间必须小于结束时间</h5><ul class='modal-con clearit'><li><label class='col-md-3 control-label'>星期一</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'/></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期二</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期三</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期四</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期五</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期六</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li><li><label class='col-md-3 control-label'>星期日</label><div class='col-md-9'><div class='work-state'><input type='checkbox'name='work-state'></div><div class='input-group input-large  input-daterange'><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-str'value='8:00'></div><span class='input-group-addon'>至</span><div class='input-group'><input type='text'class='form-control control-input timepicker timepicker-end'value='22:00'></div></div></div></li></ul></div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>关闭</button></div></div></div></div>");
    //swith-开关初始化
    $('.clerk-scheduling-modal .work-state input[type="checkbox"]').bootstrapSwitch({
      size:"small", 
      onText:"工作",  
      offText:"休息",
    });
    //时间初始化-24小时制
    $('.timepicker').datetimepicker({
      format: 'HH:mm'
    });
    //禁止选择比开始时间早
    $(".input-daterange .timepicker-str").on("dp.change",function (e) {
      $(this).parents('.input-daterange').find('.timepicker-end').data("DateTimePicker").minDate(e.date);
      if($(this).val()>$(this).parents('.input-daterange').find('.timepicker-end').val()){
        $.Toast("提示", "开始时间不可小于结束时间", "notice", {});
      }
    });
    //禁止选择比结束时间晚
    $(".input-daterange .timepicker-end").on("dp.change",function (e) {
      $(this).parents('.input-daterange').find('.timepicker-str').data("DateTimePicker").maxDate(e.date);
      if($(this).parents('.input-daterange').find('.timepicker-str').val()>$(this).val()){
        $.Toast("提示", "开始时间不可小于结束时间", "notice", {});
      }
    });
    //选择模板
    $('.modal .template-select .template-select-btn').click(function(){
      var Tjson=$(this).data('templatejosn');
      console.log(schedulingJson[Tjson])
      $('.modal .scheduling-con li').each(function(i){
        $(this).find('.work-state input[type="checkbox"]').bootstrapSwitch('state',schedulingJson[Tjson][i].state);
        $(this).find('.timepicker-str').val(schedulingJson[Tjson][i].strtime);
        $(this).find('.timepicker-end').val(schedulingJson[Tjson][i].endtime);
      });
    });
    //删除模板
    $('.modal .template-select .template-select-remove').click(function(){
      $(this).parent().remove();
    });
    //点击确认
    $(".modal .btn-primary").click(function(){
      var schedulingJson=[],str_end_State=true;
      // var schedulingJson={},schedulingJsonDay=[];
      $('.modal .scheduling-con li').each(function(){
        var obj={};
        obj['id']=$(this).children('.control-label').text();
        obj['state']=$(this).find('.work-state input[type="checkbox"]').prop("checked");
        obj['strtime']=$(this).find('.timepicker-str').val();
        obj['endtime']=$(this).find('.timepicker-end').val();
        //比较开始时间与结束时间
        if(obj['strtime']>obj['endtime']){
          $.Toast("提示", "<b>"+obj['id']+"</b>-开始时间不可小于结束时间", "notice", {});
          str_end_State=false;
        }
        schedulingJson.push(obj);
        // schedulingJson['content']=schedulingJsonDay;
      });
      console.log(schedulingJson)
      // $('.modal #template-select1').data('templatejosn',schedulingJson);
      // $.each(schedulingJson, function(i, item) {
      //   if(item.strtime>item.endtime){
      //     $.Toast("提示", item.id+"开始时间不可小于结束时间", "warning", {});
      //     str_end_State=false;
      //   }
      // });
      if(str_end_State){
        $(this).parents(".modal").modal("hide");
      }
    });
    //删除模态框
    // $('.modal').on('hidden.bs.modal', function () {
    //   $(this).remove();
    // });
  });
  //批量删除
  $('.delete-all').click(function(){
    var deleteNum=0,that= this;
    $(this).parents('.main-table').find('tbody').children('tr').each(function(){
      if($(this).find('.id').children().hasClass('selected')){
        deleteNum++;
      }
    });
    if(deleteNum==0){
      return false;
    }else{
      $('body').append("<div class='modal fade bs-example-modal-sm clerk-deleteall-modal'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要删除"+deleteNum+"项数据？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
      //点击确认
      $(".modal .btn-primary").click(function(){
        $(that).parents('.main-table').find('tbody').find('.selected').parents('tr').remove();
        $(this).parents(".modal").modal("hide");
      });
      $('.modal').on('hidden.bs.modal', function () {
        $(this).remove();
      });
    }
  });


  //店员管理-职位管理 添加、编辑
  $(".clerk-edit").click(function(){
    var newClerk = $(this).data('newclerk');
    var modalTitle,modalTitle1,inputText;
    if(newClerk==true){
      modalTitle =  "新增职位";
      modalTitle1 = "新增职位名称";
    }else{
      modalTitle =  "修改职称";
      modalTitle1 = "职位名称";
    }
    $('body').append('<div class="modal fade bs-example-modal-md clerk-edit-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">'+modalTitle+'</h4></div><div class="modal-body clearit"><div class="form-group col-xs-12 row"style="margin-bottom: 8px;"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">'+modalTitle1+'</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input"name="clerk-edit-name"type="text"autocomplete="off"></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
    if(newClerk==false){
      inputText =  $(this).parent().siblings().text();
      console.log(inputText)
      $('.clerk-edit-modal').find('input[name=clerk-edit-name]').val(inputText);
    }
    //点击确认
    $(".modal .btn-primary").click(function(){
      $(that).parents("tr").remove();
      $(this).parents(".modal").modal("hide");
    });
    $('.modal').on('hidden.bs.modal', function () {
      $(this).remove();
    });
  });
  


  /*店员管理-E-----------------------------------------------*/
  /*经营范围-S-----------------------------------------------*/
  //添加新的特殊时间
  var  special_time = 0; 
  $('.main-ditu .main-table .ditu-btn-add').click(function(){
    $(this).parents('.main-table').find('tbody').append('<tr class="ditu-daterange"id="special_time'+special_time+'"><td><div class="input-group input-large input-daterange"><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-str"value=""></div><span class="input-group-addon">至</span><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-end"value=""></div></div></td><td><input class="control-input start_price"type="number"autocomplete="off"></td><td><input class="control-input dispatch_price"type="number"autocomplete="off"></td><td><a href="javascript:;"onclick="deleteit(this)"><span class="label label-danger">删除</span></a></td></tr>');
    $('.main-ditu #special_time'+special_time+' .timepicker').datetimepicker({
      format: 'HH:mm',
      widgetPositioning: {
        horizontal: 'left'
      }
    });
    $("#special_time"+special_time+" .timepicker-str").on("dp.change",function (e) {
      $(this).parents('.input-daterange').find('.timepicker-end').data("DateTimePicker").minDate(e.date);
      if($(this).val()>$(this).parents('.input-daterange').find('.timepicker-end').val()){
        $.Toast("提示", "开始时间不可小于结束时间", "notice", {});
      }
      //跟上一级比较结束时间
      if($(this).parents('.ditu-daterange').prev().length){
        if($(this).val()<$(this).parents('.ditu-daterange').prev().find('.timepicker-end').val()){
          $.Toast("提示", "时间设置不能重叠", "notice", {});
        }
      }
    });
    //禁止选择比结束时间晚
    $("#special_time"+special_time+" .timepicker-end").on("dp.change",function (e) {
      $(this).parents('.input-daterange').find('.timepicker-str').data("DateTimePicker").maxDate(e.date);
      if($(this).parents('.input-daterange').find('.timepicker-str').val()>$(this).val()){
        $.Toast("提示", "开始时间不可小于结束时间", "notice", {});
      }
      //跟上一级比较结束时间
      if($(this).parents('.ditu-daterange').next().length){
        if($(this).parents('.ditu-daterange').next().find('.timepicker-str').val()<$(this).val()){
          $.Toast("提示", "时间设置不能重叠", "notice", {});
        }
      }
    });
    special_time++;
  });
  //经营范围-保持
  $('.main-ditu .control-submit').click(function(){
      var specialTimeJson=[],specialTimeState=true;
      $(this).parents('.main-ditu').find('tbody').children().each(function(){
        var obj={};
        obj['strtime']=$(this).find('.timepicker-str').val();
        obj['endtime']=$(this).find('.timepicker-end').val();
        obj['start']=$(this).find('.start_price').val();
        obj['dispatch']=$(this).find('.dispatch_price').val();
  
        //比较开始时间与结束时间
        if($(this).find('.timepicker-str').val()>$(this).find('.timepicker-end').val()){
          $.Toast("提示", "请检查，开始时间不可小于结束时间", "notice", {});
          specialTimeState=false;
          return false;
        }
          //比较前一个
        if($(this).find('.timepicker-str').val()<$(this).prev().find('.timepicker-end').val()){
          $.Toast("提示", "请检查，时间设置不能重叠", "notice", {});
          specialTimeState=false;
          return false;
        }
        specialTimeJson.push(obj);
      });
      console.log(specialTimeJson)
      if(!specialTimeState){
        return false;
      }

  });
  //地图按钮切换
  $('.ditu-button-group').children().click(function(){
    $(this).hide().siblings().show();
  });
  /*经营范围-E-----------------------------------------------*/
  /*预约时间设置-S-----------------------------------------------*/
  // $('.bookingtime-ul .bt_li1 .timepicker').datetimepicker({
  //   format: 'HH:mm'
  // });
  //赋值第一个li
  //点击星期导航切换
  // var bt_monday=[],bt_tuesday=[],bt_wednesday=[],bt_thursday=[],bt_frisday=[],bt_saturday=[],bt_sunday=[];
  var bt_week={
    'monday':[
      {strtime:'12:00',endtime:'13:00',tostore:'12',todoor:'2'},
      {strtime:'14:00',endtime:'15:00',tostore:'12',todoor:'2'},
      {strtime:'16:00',endtime:'17:00',tostore:'2',todoor:'33'}
    ],
    'tuesday':[
      {strtime:'12:00',endtime:'13:00',tostore:'12',todoor:'2'},
      {strtime:'14:00',endtime:'15:00',tostore:'12',todoor:'2'},
      {strtime:'16:00',endtime:'17:00',tostore:'2',todoor:'33'}
    ],
    'wednesday':[],
    'thursday':[],
    'frisday':[],
    'saturday':[],
    'sunday':[]
  };
  
  //切换星期
  $('.bookingtime-nav li a').click(function(){
    //读取
    var nowstate=$(this).attr('aria-controls');
    $('#'+nowstate+' .bookingtime-ul').html('');
    if(!bt_week[nowstate].length==0){
      $.each(bt_week[nowstate],function(i,item){
        $('#'+nowstate+' .bookingtime-ul').append('<li class="bt_li'+i+'"><div class="input-group input-large input-daterange"><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-str"value="'+item['strtime']+'"></div><div class="input-group"><span class="input-group-addon">至</span></div><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-end"value="'+item['endtime']+'"></div><div class="bt-set-box"><input class="control-input tostore"type="text"placeholder="到店预约人数"autocomplete="off"value="'+item['tostore']+'"></div><div class="bt-set-box"><input class="control-input todoor"type="text"placeholder="上门预约人数"autocomplete="off"value="'+item['todoor']+'"></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn"onclick="bookingtime_add(this)"><i class="glyphicon glyphicon-plus"></i></a></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn bttn-remove"onclick="bookingtime_remove(this)"><i class="glyphicon glyphicon-remove"></i></a></div></div></li>');
        bt_addtime('',i);
      });
    }else{
      $('#'+nowstate+' .bookingtime-ul').append('<li class="bt_li1"><div class="input-group input-large input-daterange"><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-str"value=""></div><div class="input-group"><span class="input-group-addon">至</span></div><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-end"value=""></div><div class="bt-set-box"><input class="control-input tostore"type="text"placeholder="到店预约人数"autocomplete="off"></div><div class="bt-set-box"><input class="control-input todoor"type="text"placeholder="上门预约人数"autocomplete="off"></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn"onclick="bookingtime_add(this)"><i class="glyphicon glyphicon-plus"></i></a></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn bttn-remove"onclick="bookingtime_remove(this)"><i class="glyphicon glyphicon-remove"></i></a></div></div></li>');
    }

    //录入
    bt_week[bt_action_day]=[];
    $('#'+bt_action_day+' .bookingtime-ul li').each(function(){
      var obj={};
      obj['strtime']=$(this).find('.timepicker-str').val();
      obj['endtime']=$(this).find('.timepicker-end').val();
      obj['tostore']=$(this).find('.tostore').val();
      obj['todoor']=$(this).find('.todoor').val();
      bt_week[bt_action_day].push(obj);
    });
    console.log(bt_week);

    bt_action_day = $(this).attr('aria-controls');
  });


  $('.bookingtime-footer .template-save-btn').click(function(){
    var objBox=[];
    var name = $(this).siblings().val();
    $(this).parents('.bookingtime-con').find('.bookingtime-main').find('.tab-pane.active').find('.bookingtime-ul').children().each(function(){
      var obj={};
      obj['strtime']=$(this).find('.timepicker-str').val();
      obj['endtime']=$(this).find('.timepicker-end').val();
      obj['tostore']=$(this).find('.tostore').val();
      obj['todoor']=$(this).find('.todoor').val();
      objBox.push(obj);
    });
    templateJosn[name]=objBox;
    console.log(templateJosn);

    $(this).parents('.bookingtime-footer').find('.template-select-box').append('<div class="btn-box"><a href="javascript:void(0)"class="btn btn-default template-select-btn"onclick="settemplate(this)"title="点击选择时间段模板"data-templatejosn="'+name+'">'+name+'</a><a href="javascript:void(0)"class="btn btn-default template-select-remove"onclick="deletetemplate(this)"><i class="glyphicon glyphicon-remove"></i></a></div>');

    //重置信息
    $(this).siblings().val('');
    $(this).parent().siblings().removeClass('selected').children().prop('checked',false);


  });

  /*预约时间设置-E-----------------------------------------------*/
 
  /*商品管理-S-----------------------------------------------*/
  //商品添加-----------------
  if($('.product-con').length>0){

    $('.commodity_type-radio .selct-checkbox').click(function(){
      $(this).parents('.product-con').attr('data-styleid',$(this).attr('data-styleid'));
    });

    $('.addselect-add').click(function(){
      $(this).toggleClass('action');
    });
    $('.radio-box.shangpin_video .selct-checkbox').click(function(){
      $(this).parents('.shangpin_video').siblings().attr('data-editid',$(this).val())
    });
  
    /*多规格读取 */
    console.log(specMsg != false)
    if(specMsg != false){
      var specMsgHtml;
      $.each(specMsg,function(idx,items){
        specMsgHtml = '';
        var htmlTitle='<div class="title">'+
            '<h5>'+items.name+'</h5>'+
            '<a href="javascript:void(0);" class="btn btn-set" onclick="readSpecName(this)"><i class="glyphicon glyphicon-pencil"></i></a>'+
            '<a href="#" class="btn btn-remove" onclick="specRemove(this)" data-toggle="modal" data-target=".spec-remove"><i class="glyphicon glyphicon-remove"></i></a>'+
            '<div class="reset-box">'+
              '<input class="control-input" type="text" autocomplete="off">'+
              '<div class="control">'+
                '<a href="javasctipt:void(0);" class="btn control-save" onclick="specNameSave(this)">保存</a>'+
                '<a href="javasctipt:void(0);" class="btn control-cancel" onclick="specNameCancel(this)">取消</a>'+
              '</div>'+
            '</div>'+
          '</div>';
          var htmlLi='',active='';
          if(items.arr.length!=0){
            active='active';
            $.each(items.arr,function(i,item){
              console.log(item)
              htmlLi+='<li>'+
                    '<span class="name">'+item+'</span>'+
                    '<a href="javascript:void(0);" class="btn option-remove" onclick="deleteConfirm(this)"><i class="glyphicon glyphicon-remove"></i></a>'+
                  '</li>';
            });
          }
          htmlLi='<ul class="option clearit">'+htmlLi+
                    '<div class="option-add">'+
                      '<div class="input-group">'+
                        '<span class="input-group-addon">规格值</span>'+
                        '<input type="text" placeholder="如红色、白色" class="control-input">'+
                        '<a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" onclick="addOption(this)">添加</a>'+
                      '</div>'+
                    '</div>'+
                  '</ul>';
        specMsgHtml = '<div class="spec-box '+active+'">'+htmlTitle+htmlLi+'</div>';
        $('.pro-more-spec').append(specMsgHtml);
      });
  
    }
    /*多规格表读取 */
    if(specMsg != false){
      $('.pro-more-table').show().siblings().hide();
      var specArr=[],spec_sort=[],specExArr=[];
  
      $('.pro-more-spec').children('.active').each(function(i){
        var obj=new Array();
        var tit = $(this).find('.title').find('h5').text();
  
        $(this).children('.option').children('li').each(function(i){
          obj[i]= $(this).children('.name').text();
        });
        /*判断非空数组-才录入数据 */
        if(JSON.stringify(obj) !== '[]'){
          spec_sort.push(tit);
          specArr.push(obj);
        }
      });
      console.log(specArr)
      console.log(doExchange(specArr))
      specArrTable = doExchange(specArr);
  
      //打印表头表尾
      var list="";
      for (var i = 0; i < spec_sort.length; i++) {
        list +='<th class="spec">'+spec_sort[i]+'</th>';
      };
      $('.pro-more-table thead tr .spec').remove();
      $('.pro-more-table thead tr .th_img').before(list);
      var footlist=spec_sort.length?'<td class="foot_td" colspan="'+spec_sort.length+'">批量设置</td>':'';
      $('.pro-more-table tfoot tr .foot_td').remove();
      $('.pro-more-table tfoot tr .min-img-all').before(footlist);
  
      specExArr=specExArrTable;
      //打印表内容
      $('.pro-more-table tbody').html('');
      $.each(specExArr,function(i,item){
        var list_tbody='';
        var arr=item.id.split('-');
        var arrid=item.id;
        var img = item.img!=''?item.img:'http://elink.boguanweb.com/public/boguan//images/default_add.png';
        var imghtml='<div class="imgbox"><img class="lay_imgsrc" src="'+img+'" ondragstart="return false" alt="" title="" draggable="false"><div class="imgNavUp"><span title="本地上传" onclick="iconLibrary(this)" data-laymodal="spec_img" data-toggle="modal" data-target=".icon-lib">点击上传</span></div></div>';
        console.log("arr:"+arr)
        console.log("item:"+item)
        console.log("arrid"+arrid)
        for (var i = 0; i < arr.length; i++) {
          list_tbody +='<td>'+arr[i]+'</td>';
        };
        $('.pro-more-table tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="min-img">'+imghtml+'</td><td class="price"><input type="number" class="control-input" value="'+item.price+'"></td><td class="stock"><input type="number" class="control-input" value="'+item.stock+'"></td><td class="code"><input type="number" class="control-input" value="'+item.code+'"></td><td class="barcode"><input type="number" class="control-input" value="'+item.barcode+'"></td></tr>');
      });
      //合并新建的行
      for (var i = 0; i < spec_sort.length; i++) {
        $(".pro-more-table tbody").rowspan(i);
      };

      if($('.shangpin-price').length>0){
        priceAndInventory(specArr);
      }

      if($('.table_weight').length>0){
        console.log($('.radio_weight input:checked').attr('data-styleid'))
        console.log(specArrTable)
        $('.table_weight').html('');
        var weightTableDiv = $('<div></div>');
        weightTableDiv.addClass('main-table table-responsive table-condensed');
        $('.table_weight').append(weightTableDiv);
        var weightTable = $('<table></table>');
        weightTable.addClass('table table-bordered');
        weightTableDiv.append(weightTable);
        var list="";
        for (var i = 0; i < spec_sort.length; i++) {
          list +='<th class="spec">'+spec_sort[i]+'</th>';
        };
        list += '<th>重量</th>'
        var weightTableHead = $('<thead><tr>'+list+'</tr></thead>');
        weightTable.append(weightTableHead);
        var weightTableBody = $('<tbody></tbody>');
        weightTable.append(weightTableBody);

        $.each(specExArrTable,function(i,item){
          var list_tbody='';
          var arr=item.id.split('-');
          var arrid=item.id;
          console.log("item:"+item)
          console.log("arrid"+arrid)
          for (var i = 0; i < arr.length; i++) {
            list_tbody +='<td>'+arr[i]+'</td>';
          };
          $('.table_weight tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="weight"><div class="input-group min-input"><input class="control-input" type="number" autocomplete="off" value="'+item.weight+'" onkeyup="decimalPoint(this)" style="width:100px;height:29px;margin:0;"><span class="input-group-addon" style="line-height:15px;">Kg</span></div></td></tr>');
        });

          //合并新建的行
        for (var i = 0; i < spec_sort.length; i++) {
          $('.table_weight tbody').rowspan(i);
        };
      }
  
    }

    //备货时间
    var stockHtml='';
    for(var i=0;i<60;i++){
      stockHtml += '<option>'+i+'</option>';
      if(i==7){
        $('.stock_up .stock_up-box .stock_up-day').append(stockHtml);
      }
      if(i==23){
        $('.stock_up .stock_up-box .stock_up-hour').append(stockHtml);
      }
    }
    $('.stock_up .stock_up-box .stock_up-minute').append(stockHtml);
  
    //添加分组-保存
    // $('.addselect .addselect-box .control-save').click(function(){
    //   var name=$(this).parent().siblings().val();
    //   if(name!=''){
    //     $(this).parents('.addselect-set').find('.control-chosen').append('<option value="'+name+'">'+name+'</option>');
    //     $(this).parents('.addselect-set').find('.control-chosen').trigger("chosen:updated");
    //   }
  
    //   $(this).parents('.addselect').children('.addselect-add').removeClass('action');
    //   $(this).parent().siblings().val('');
    // });
    $('.addselect .addselect-add').click(function(){
      var that = this;
      $(this).popModal({
        html : '<div class="sorting-content"><input type="text"class="control-input"><div class="control"><a href="javascript:;"data-popModalBut="ok"class="btn control-save">保存</a><a href="javascript:;"data-popModalBut="close"class="btn control-cancel">取消</a></div></div>',
        placement : 'bottomLeft',
        showCloseBut : false,
        onDocumentClickClose : true,
        onOkBut : function(ev){
          var name = $(ev.target).parent().siblings().val();
          if(name!=''){
            $(that).parents('.addselect-set').find('.control-chosen').append('<option value="'+name+'">'+name+'</option>');
            $(that).parents('.addselect-set').find('.control-chosen').trigger("chosen:updated");
          }
        },
        onCancelBut : function(){},
        onLoad : function(){},
        onClose : function(){}
      });
    });
    //添加分组-取消
    // $('.addselect .addselect-box .control-cancel').click(function(){
    //   $(this).parents('.addselect').children('.addselect-add').removeClass('action');
    //   $(this).parent().siblings().val('');
    // });
    //商品规格选择
    $('.product-con .pro-oneormore .selct-checkbox').click(function(){
      if($(this).val()=='0'){
        $(this).parents('.group').children('.pro-one-box').addClass('active');
        $(this).parents('.group').children('.pro-more-box').removeClass('active');
      }else{
        $(this).parents('.group').children('.pro-one-box').removeClass('active');
        $(this).parents('.group').children('.pro-more-box').addClass('active');
      }
    });
  
    //添加规格-保存
    $('.pro-more-addspec .addspec-box .control-save').click(function(){
      var name = $(this).parent().siblings().val();
      name = $.trim(name);//删除空格符
      if(!name==''){
        $(this).parents('.pro-more-addspec').siblings().append('<div class="spec-box"><div class="title"><h5>'+name+'</h5><a href="javascript:void(0);" class="btn btn-set" onclick="readSpecName(this)"><i class="glyphicon glyphicon-pencil"></i></a><a href="#" class="btn btn-remove" onclick="specRemove(this)" data-toggle="modal" data-target=".spec-remove"><i class="glyphicon glyphicon-remove"></i></a><div class="reset-box"><input class="control-input" type="text" autocomplete="off"><div class="control"><a href="javasctipt:void(0);" class="btn control-save" onclick="specNameSave(this)">保存</a><a href="javasctipt:void(0);" class="btn control-cancel" onclick="specNameCancel(this)">取消</a></div></div></div><ul class="option clearit"><div class="option-add"><div class="input-group"><span class="input-group-addon">规格值</span><input type="text" placeholder="如红色、白色" class="control-input"><a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" onclick="addOption(this)">添加</a></div></div></ul></div>');
      }
      $(this).parents('.pro-more-addspec').children('.addselect-add').removeClass('action');
      $(this).parent().siblings().val('');
  
      // specNum();
    });
    //添加规格-取消
    $('.pro-more-addspec .addspec-box .control-cancel').click(function(){
      $(this).parents('.pro-more-addspec').children('.addselect-add').removeClass('action');
      $(this).parent().siblings().val('');
    });
    //快递运费-点击第一个消失第二个内容
    $('.radio-shangpin > .radio-checkbox-label .selct-checkbox').click(function(){
      if($(this).attr('data-styleid')=='all'){
        $(this).parents('.radio-shangpin').find('.pro_weight_group').hide();
      }
    });
    //快递运费-显示隐藏-按件按重模板选择
    $('.radio-shangpin .control-chosen').change(function(){
      $(this).parents('label').addClass('selected').siblings().removeClass('selected');
      $(this).parents('label').children('input').attr('checked',true);
      if($(this).children('option:selected').attr('data-freight')=='weight'){
        $(this).parents('.radio-shangpin').find('.pro_weight_group').show();
      }else{
        $(this).parents('.radio-shangpin').find('.pro_weight_group').hide();
      }
      console.log($(this).children('option:selected').attr('data-freight'))
    });
    //快递运费-物流重量
    $('.radio_weight .selct-checkbox').click(function(){
      if($(this).attr('data-styleid')=='single'){
        $(this).parents('.radio_weight').siblings('.table_weight').show();
      }else{
        $(this).parents('.radio_weight').siblings('.table_weight').hide();
      }
    });
  
    //新增商品-保存
    var specAllArr=[],specTableAll=[];
    $('.product-con .layout-bottom .control-submit').click(function(){
      console.log($('.radio-shangpin .control-chosen').val())
      console.log($('.radio-shangpin .control-chosen option:selected').attr('data-freight'))
  
      //记录表头信息
      specMsg=[];
      $('.pro-more-spec .spec-box').each(function(i){
        var obj={};
        obj['name']=$(this).find('.title').find('h5').text();
        var aObj=[];
        $(this).children('.option').children('li').each(function(){
          aObj.push($(this).children('.name').text());
        });
        obj['arr']=aObj;
        specMsg.push(obj);
      });
      console.log(specMsg)
      //记录表内容
      $('.pro-more-table tbody tr').each(function(){
        var obj={},state=true;
        obj['id']=$(this).attr('id');
        obj['img']=$(this).find('.min-img').find('img').prop('src');
        obj['price']=$(this).find('.price').children().val();
        obj['stock']=$(this).find('.stock').children().val();
        obj['code']=$(this).find('.code').children().val();
        obj['barcode']=$(this).find('.code').children().val();
        $.each(specExArrTable,function(i,item){
          if(item.id==obj['id']){
            item.img=obj['img'];
            item.price=obj['price'];
            item.stock=obj['stock'];
            item.code=obj['code'];
            item.barcode=obj['barcode'];
            state=false;
            return false;
          }
        });
        if(state){
          specExArrTable.push(obj);
        }
      });
      console.log(specExArrTable)
      if(!$('.table_weight').is(':hidden')){
        $('.table_weight tbody tr').each(function(){
          var thisId = $(this).attr('id');
          var thisWeight = $(this).find('.weight').find('input').val();
          $.each(specExArrTable,function(i,item){
            if(item.id==thisId){
              item.weight = thisWeight;
              return false;
            }
          });
        });
        console.log(specExArrTable)
      }
      
      if(!$('.stock_up-box').is(':hidden')){
        console.log($('.stock_up-box select[data-styleid=day]').val())
        console.log($('.stock_up-box select[data-styleid=hour]').val())
        console.log($('.stock_up-box select[data-styleid=minute]').val())
      }
    });
  
  }
  
  /*商品分类 */
  if($('.neirong-con').length>0){
    if($('#classify_link-sel').children('option:selected').val()==0){
      $('#classify_link-sel').parents('.main-con').find('.classify_link').show();
    }else{
      $('#classify_link-sel').parents('.main-con').find('.classify_link').hide();
    }
    $('#classify_link-sel').change(function(){
      if($(this).children('option:selected').val()==0){
        $(this).parents('.main-con').find('.classify_link').show();
      }else{
        $(this).parents('.main-con').find('.classify_link').hide();
      }
    });
  }
  /*商品管理-E-----------------------------------------------*/
  /*订单筛选-S-----------------------------------------------*/
  if($('.order-main').length>0){
    //多选
    $('.control-chosen').chosen({
      allow_single_deselect: true,
      disable_search:true
    });
    //开始时间：
    $("#new_start_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : false,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
			language : 'zh-CN',
      startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        console.log(e)
          console.log(startTime)
          $('#new_end_time').datetimepicker('setStartDate',startTime);
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : false,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
      language : 'zh-CN',
			startView : 2,//月视图
      minView: 2,
      endDate: today,
      // datesDisabled:[today],
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        console.log(endTime)
        $('#new_start_time').datetimepicker('setEndDate',endTime);
    });
    
    $('#new_start_time').datetimepicker('setDatesDisabled',[today]);
    $('#new_end_time').datetimepicker('setDatesDisabled',[today]);

    var timing;
    $('.order_screening-time ul li').click(function(){
      $(this).addClass('active').siblings().removeClass('active');
      console.log($(this).index())
      switch($(this).index()){
        case 0:{
          timing = yestoday;
          console.log(timing)
          break;
        }
        case 1:{
          timing =new Date(today - 7*oneDay);
          console.log(timing)
          break;
        }
        case 2:{
          timing =new Date(today - 30*oneDay);
          console.log(timing)
          break;
        }
      }
      
      $('#new_start_time').datetimepicker('setDate',timing);
      $('#new_end_time').datetimepicker('setDate',yestoday);
      $('#new_end_time').datetimepicker('setStartDate',timing);

    });


  }
  /*订单筛选-E-----------------------------------------------*/
  /*订单详情-S-----------------------------------------------*/
  if($('.order-con').length>0){
    
    $('.state-action-msg').click(function(){
      var that = this;
      $(this).popModal({
        html : '<div class="sorting-content"><textarea name="" id="" cols="15" rows="10"></textarea><div class="control"><a href="javascript:;"data-popModalBut="ok"class="btn control-save">保存</a><a href="javascript:;"data-popModalBut="close"class="btn control-cancel">取消</a></div></div>',
        placement : 'bottomLeft',
        showCloseBut : false,
        onDocumentClickClose : true,
        onOkBut : function(ev){
          console.log($(ev.target).parent().siblings().val())
          // console.log($(that).siblings('.serial_number').val())
          $(that).parents('.state-action').siblings('.state-action-msg-box').find('.massage-box').html($(ev.target).parent().siblings().val());
        },
        onCancelBut : function(){},
        onLoad : function(){},
        onClose : function(){}
      });

    });
  }
  /*订单详情-E-----------------------------------------------*/
  /*订单详情-退款维权-S-----------------------------------------------*/
  // if($('.order-con').length>0){

  // }
  /*订单详情-退款维权-E-----------------------------------------------*/
  
  /*布局排版-S-----------------------------------------------*/
if($('.main-layout').length>0){
  if(layoutModalSelectOrder!=undefined||layoutModalSelectOrder!==''){
    console.log(layoutModalSelectOrder)
    $.each(layoutModalSelectOrder,function(i,item){
      $.each(layoutModalSelect,function(idx,items){
        if(item==items.id){
          
          var addHtml =
          '<li class="con-item" data-laymodal="'+items.lm+'" data-id="'+items.id+'" onclick="stateEdit(this)" draggable="false">'+
            '<a href="#'+items.id+'" draggable="false">'+
              '<div class="con-item-icon" style="background-color:'+items.iconColor+'">'+
                '<i class="iconfont '+items.icon+'"></i>'+
              '</div>'+
              '<h5>'+items.title+'</h5>'+
            '</a>'+
          '</li>';

          $('#layout_show').append(items.code);
          $('#layout_show').children().last().attr('id',items.id);
          $('#layout_show').children().last().attr('data-id',items.id);
          $('#layout_show').children().last().attr('data-laymodal',items.lm);
          $('#layout_typeset').append(addHtml);
          
          LoadLMData(items.id,items.lm);
          
          // $('#layout_typeset').children('li[data-id="'+items.id+'"]').children().attr('href','#'+items.id);
          return false;
        }
      });
    });
  }
  //扫码预览
  // $('.layout-saoma').click(function(){
  //   $(this).parent().toggleClass('action');
  //   layoutHtml = $('#layout_show').html();
  //   console.log(layoutHtml);
  //   $(this).siblings().find('.imgbox').html('');
  //   $(this).siblings().find('.imgbox').qrcode({
  //       render : "canvas",    //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
  //       text : "http://chen.boguanweb.com/ob/layout-show.html",    //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接
  //       width : "200",            // //二维码的宽度
  //       height : "200",              //二维码的高度
  //       background : "#ffffff",       //二维码的后景色
  //       foreground : "#000000",        //二维码的前景色
  //       src: 'images/default_handsome.jpg'             //二维码中间的图片
  //     });
  // });

  $('#layout_show').find(".imgbox").children('img').each(function(i){
    var img = $(this);
    var _w = parseInt($(this).parents('.imgbox').width());
    var _h = parseInt($(this).parents('.imgbox').height());
    var realWidth;//真实的宽度
    var realHeight;//真实的高度
    var realPro;//宽高比
    var falsityWH;//乘绩数
    //这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
    $("<img/>").attr("src", $(img).attr("src")).load(function() {
      realWidth = this.width;
      realHeight = this.height;
      realPro = realWidth / realHeight;
      //如果真实的宽度大于盒子的宽度就按照100%显示
      if(realWidth>=realHeight){
        falsityWH = parseInt(_h*realPro);//等高的情况下,获取图片的宽度
        if(falsityWH>=_w){//与盒子比较宽度
          $(img).css("height","100%").css("width","auto");
        }
        else{
          $(img).css("width","100%").css("height","auto");
        }
      }
      else{
        falsityWH = parseInt(_w/realPro);//等宽的情况下,获取图片的高度
        if(falsityWH>=_h){//与盒子比较宽度
          $(img).css("width","100%").css("height","auto");
        }
        else{
          $(img).css("height","100%").css("width","auto");
        }
      }
    });
  });
  //表单状态-切换
  $('.layout-section .layout_nav li').click(function(){
    if(!$(this).hasClass('active')){
      $(this).addClass('active').siblings().removeClass('active');
      $(this).parents('.layout-section').children('.layout_navbox').children().eq($(this).index()).addClass('active').siblings().removeClass('active');
    }
  });
  //初始状态-赋值
  if($('.layout-section').length>0){
    $.each(layoutModalSelect,function(i,item){
      if(item.id=='basicSetup'){
        $('.layout-show .iphone-head').find('[data-editid=laysf_name]').text(item.title);
        $('.layout-edit input[data-editid=laysf_name]').val(item.title);
        $('.layout-show .iphone-screen').css('background-color',item.bgColor);
        $('.layout-edit .screencolor_bg').attr('data-original',item.bgColor).attr('data-newcol',item.bgColor).css('background-color',item.bgColor);
        
        LMData.prototype.colorBox('basicSetup');
      }
    });
  }

  //布局排版-保存
  $('.main-layout .control-submit').click(function(){
    console.log(111)
    var order = layoutShow.toArray();
    var obj=[];
    console.log(order)
    console.log(layoutModalSelect)
    // $.each(order,function(i,item){
    //   $.each(layoutModalSelect,function(idx,items){
    //     if(item==items.id){
    //       obj[item]=items.lm;
    //       return false;
    //     }
    //   });
    // });
    // console.log(layoutModalSelect)
    // console.log(obj)
    // $.each(obj,function(i,item){
    //   console.log(i)
    // })
    // for(var i = 0;i<obj.length;i++){
    // }
    // console.log(obj['a12'])
  });


}
  /*布局排版-E-----------------------------------------------*/

  /*分类设置-S-----------------------------------------------*/
  
  if($('.classifystyle_select').length>0){
    $('.classifystyle_select .select-control .bttn').click(function(){
      $(this).parents('li').addClass('selected').siblings().removeClass('selected').find('.bttn').text('选择这个');
      $(this).text('已选择');
    });

  }
  /*分类设置-E-----------------------------------------------*/
  
  /*底部菜单-S-----------------------------------------------*/
  
  if($('.layout_bottom-show').length>0){
    $('.iphone-bottom').click();
  }
  /*底部菜单-E-----------------------------------------------*/
  /*运费设置-新增模板-读取信息-S-----------------------------------------------*/
  if($('.freight-con').length>0){
    $('.freight-con').find('.freight-name').val(freightSel.name);
    $('.freight-con .pro-oneormore input[data-styleid='+freightSel.default.styleid+']').attr('checked',true).parent().addClass('selected').siblings().removeClass('selected');
    $('.freight-con .main-table tbody').children('tr#default').find('.first_weight').val(freightSel.default.first_weight);
    $('.freight-con .main-table tbody').children('tr#default').find('.first_price').val(freightSel.default.first_price);
    $('.freight-con .main-table tbody').children('tr#default').find('.second_weight').val(freightSel.default.second_weight);
    $('.freight-con .main-table tbody').children('tr#default').find('.second_price').val(freightSel.default.second_price);
    $.each(freightSel.rules,function(i,item){
        $('.freight-con .main-table tbody').append('<tr id="'+item.id+'"><td class="yf-tab-3"><div class="yunfei-address">'+item.area+'</div><div class="yunfei-control"><button class="yunfei-edit label label-primary btn"type="button"onclick="freight(this)"data-toggle="modal"data-target=".modal-freight"><i class="iconfont icon-bianji"></i></button><button class="yunfei-remove label label-danger btn"type="button"onclick="delFreight(this)"><i class="iconfont icon-shanchu"></i></button></div></td><td class="yf-tab-4"><input class="control-input first_weight"type="text"autocomplete="off"placeholder="请输入首件重量"value="'+item.mode.first_weight+'"></td><td class="yf-tab-4"><input class="control-input first_price"value="'+item.mode.first_price+'"type="text"autocomplete="off"placeholder="请输入首费"></td><td class="yf-tab-4"><input class="control-input second_weight"value="'+item.mode.second_weight+'"type="text"autocomplete="off"placeholder="请输入续件重量"></td><td class="yf-tab-4"><input class="control-input second_price"value="'+item.mode.second_price+'"type="text"autocomplete="off"placeholder="请输入续费"></td></tr>');
    });
    if(freightSel.default.styleid == 'piece'){
      $('.freight-con .main-table thead tr').children().eq(1).text('首件(个)');
      $('.freight-con .main-table thead tr').children().eq(3).text('续件(个)');
    }else{
      $('.freight-con .main-table thead tr').children().eq(1).text('首重(KG)');
      $('.freight-con .main-table thead tr').children().eq(3).text('续重(KG)');
    }

    $('.pro-oneormore .selct-checkbox').click(function(){
      if($(this).attr('data-styleid') == 'piece'){
        $('.freight-con .main-table thead tr').children().eq(1).text('首件(个)');
        $('.freight-con .main-table thead tr').children().eq(3).text('续件(个)');
      }else{
        $('.freight-con .main-table thead tr').children().eq(1).text('首重(KG)');
        $('.freight-con .main-table thead tr').children().eq(3).text('续重(KG)');
      }
    });
  }
  /*运费设置-新增模板-E-----------------------------------------------*/
  /*优惠券-S-----------------------------------------------*/
  if($('.coupons-con').length>0){
    $('.radio-control input[type=radio]').click(function(){
      var index = $(this).parent().index();
      $(this).parents('.radio-control').siblings('.radio-related').children().eq(index).attr('data-stylediy',true);
      $(this).parents('.radio-control').siblings('.radio-related').children().eq(index).siblings().attr('data-stylediy',false);
    });

    //开始时间：
    $("#new_start_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : true,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
      minView: "month",//设置只显示到月份
			language : 'zh-CN',
			startView : 2,//月视图
			// showMeridian : false,
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        $('#new_end_time').datetimepicker('setStartDate',startTime);
        // LMData.prototype.saveJson(layoutModalSelect,'basicSetup','deadline_str',e.delegateTarget.value);
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
			format : "yyyy-mm-dd",
			autoclose : true,
			todayBtn : true,
			todayHighlight : true,
			startDate : 2000 - 1 - 1,
      minView: "month",//设置只显示到月份
			language : 'zh-CN',
			startView : 2,//月视图
			// showMeridian : false,
			pickerPosition : "bottom-left",
			minuteStep : 5
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        $('#new_start_time').datetimepicker('setEndDate',endTime);
        // LMData.prototype.saveJson(layoutModalSelect,'basicSetup','deadline_end',e.delegateTarget.value);
    });

    if(productSel==''){
      $('.activity-pro').hide();
    }else{
      $('.activity-pro').show();

      $.each(productSel,function(i,items){
        var $tr = $('<tr></tr>');
        $tr.attr('data-id',items.id);
        var trHtml = 
          '<td class="sanji-pro min-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+items.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td>'+
            '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
          '</td>';
        $tr.append(trHtml);
        $('.activity-pro tbody').append($tr);
      });

      
    }



  }
  /*优惠券-E-----------------------------------------------*/
   /*优惠券-S-----------------------------------------------*/
   if($('.vipcard-con').length>0){
    $('.radio-control input[type=radio]').click(function(){
      var index = $(this).parent().index();
      $(this).parents('.radio-control').siblings('.radio-related').children().eq(index).attr('data-stylediy',true);
      $(this).parents('.radio-control').siblings('.radio-related').children().eq(index).siblings().attr('data-stylediy',false);
    });
  }

  /*权限管理-角色权限 -S---------------------------------------------- */
  if($('.permissions_role-con').length>0){
    var newListLevel1=[];
    var newListLevel2={};
    var newListLevel3={};
    var selArea = freightSel.rules.area;
    $.each(freightList,function(idx,items){
      // console.log(items)
      if(items.level=='1'){
        newListLevel2[items.id]=[];
        newListLevel1.push(items);
      }else if(items.level=='3'){
        if(!newListLevel3[items.parentId]){
          newListLevel3[items.parentId]=[];
        }
        newListLevel3[items.parentId].push(items);
      }else{
        newListLevel2[items.parentId].push(items);
      }
    });
    console.log(newListLevel1)
    console.log(newListLevel2)
    console.log(newListLevel3)


    var level1_html='';
    $.each(newListLevel2,function(idx,items){
      var level2_html='';checkAll = true,checked = false,checkNum=0,checkHasArea = false;
      var selectAll = false;
      if(selArea.indexOf(idx)!='-1'){/*是否属于已选-一级*/
        selectAll = true;
        checked = true;
      }
      $.each(items,function(i,item){
        var labelClassName = '',inputClassName = '';
        var level3_more = '';
        var level3_html='';
        var hasArea = false;
        var hasAreaLevel3 = false;

        if(selArea.indexOf(item.id)!='-1'){/*是否属于已选-二级*/
          hasArea = true;
          checked = true;
          // if(selAreaAll.indexOf(item.name)=='-1'){/*是否在全部已选数组*/
          //   item.state = true;
          // }else{
          //   item.state = false;
          // }
        }

        $.each(newListLevel3,function(n,itemx){/*三级下拉-内容 */
          if(n==item.id){
            level3_more = '<span class="glyphicon glyphicon-plus-sign"></span>';
            var level3_content = '';
            $.each(itemx,function(ns,itemxs){
              var labelCName = '',inputCName = '';
              if(hasArea){/*是否已全选 */
                labelCName = 'selected',inputCName = 'checked';
              }else if(selArea.indexOf(itemxs.id)!='-1'){/*是否已选*/
                labelCName = 'selected',inputCName = 'checked';
                hasAreaLevel3 = true;
                checked = true;
              }
              level3_content +=
                '<label class="freight-label '+labelCName+'" >'+
                  '<input class="selct-checkbox" type="checkbox" data-multlevel="dist" name="area" value="" '+inputCName+'>'+
                  '<span class="area-name" data-id="'+itemxs.id+'">'+itemxs.name+'</span>'+
                '</label>';
            });
            level3_html ='<div class="city" data-mult_district>'+level3_content+'</div> ';
            return false;
          }
        });

        if(selectAll){
          /*已全选*/
          labelClassName = 'selected',inputClassName = 'checked';
        }else if(hasArea){
          /*激活已选*/
          labelClassName = 'selected',inputClassName = 'checked';
        }else if(hasAreaLevel3){
          labelClassName = 'notall',inputClassName = '';
        }

        level2_html += 
          '<li class="role_item"><div data-mult_citylabel><label class="freight-label '+labelClassName+'" >'+
            '<input class="selct-checkbox" type="checkbox" data-multlevel="city" name="area" value="" '+inputClassName+'>'+
            '<span class="area-name" data-id="'+item.id+'">'+item.name+'</span>'+level3_more+
          '</label></div>'+level3_html+'</li>';

      });

      var labelClassName = '',inputClassName = '';
      console.log(checked)
      if(checked){
        if(selectAll){
            labelClassName = 'selected';
            inputClassName = 'checked';
        }else{
          labelClassName = 'notall';
          inputClassName = '';
        }
      }

      // level2_html +=l2_con;
      console.log(items)
      level1_html += '<li class="role-item" data-mult_prov>'+
        '<div class="role_left" data-mult_provlabel>'+
          '<label class="freight-label '+labelClassName+'" data-id="'+idx+'">'+
            '<input class="selct-checkbox" type="checkbox" data-multlevel="prov" name="area" value="" '+inputClassName+'>'+
            '<span class="area-name" data-id="'+idx+'">'+findName(newListLevel1,idx)+'</span>'+
          '</label>'+
        '</div><ul class="role_right" data-mult_city>'+level2_html+'</ul>'
      '</li>';

    });

    $('.role_list').append(level1_html);
    $('.role_name').val(freightSel.name);
    $('.role_textarea').val(freightSel.default.description);

    $(".freight-label .selct-checkbox").click(function(){
      if($(this).parent().hasClass("selected")){
        $(this).parent().removeClass("selected");
      }else{
        $(this).parent().addClass("selected");
      }
      console.log($(this).prop('checked'))
      multDD_checkClick(this);
    });

    $('.control-submit').click(function(){
      var newSelArea = [];
      $(".role_list .role-item").each(function(){
        if($(this).children('[data-mult_provlabel]').children().hasClass('selected')){
          var newSelArea_li = [];
          var $parThis = $(this);
          newSelArea_li.push($parThis.children('[data-mult_provlabel]').find('.area-name').attr('data-id'));
        }else if($(this).children('[data-mult_provlabel]').children().hasClass('notall')){
          
          var newSelArea_li = [];
          var $parThis = $(this);
          $parThis.children('[data-mult_city]').children('.role_item').each(function(){
            if($(this).children('[data-mult_citylabel]').children().hasClass('selected')){
              newSelArea_li.push($(this).children('[data-mult_citylabel]').find('.area-name').attr('data-id'));
            }else if($(this).children('[data-mult_citylabel]').children().hasClass('notall')){
              $(this).children('[data-mult_district]').children().each(function(){
                if($(this).hasClass('selected')){
                  newSelArea_li.push($(this).find('.area-name').attr('data-id'));
                }
              })
            }
          });
        }
        newSelArea.push(newSelArea_li);
      });
      newSelArea=newSelArea.join(",");
      freightSel.rules.area=newSelArea;
      freightSel.name=$('.role_name').val();
      freightSel.default.description=$('.role_textarea').val();



      console.log(freightSel)
    });



  }
  /*权限管理 -E---------------------------------------------- */

  /*上门自提-新增自提点 -S---------------------------------------------- */
  if($('.door_to_door-con').length>0){

    var day='',hour='';
    for(var i=1;i<32;i++){
      day += '<option>'+i+'</option>'
    }
    $('.select-day').html(day);

    for(var i=1;i<49;i++){
      hour += '<option>'+i+'</option>'
    }
    $('.select-hour').html(hour);

    day='';
    for(var i=1;i<31;i++){
      day += '<option>'+i+'</option>'
    }
    day += '<option>60</option><option>90</option>';
    $('.select-day2').html(day);

    var selOption = $('.select-day').attr('data-value');
    if(selOption!=''){
      $('.select-day').children().each(function(){
        if(selOption==$(this).text()){
          $(this).attr('selected',true);
          return false;
        }
      });
    }
    selOption = $('.select-hour').attr('data-value');
    if(selOption!=''){
      $('.select-hour').children().each(function(){
        if(selOption==$(this).text()){
          $(this).attr('selected',true);
          return false;
        }
      });
    }
    selOption = $('.select-day2').attr('data-value');
    if(selOption!=''){
      $('.select-day2').children().each(function(){
        if(selOption==$(this).text()){
          $(this).attr('selected',true);
          return false;
        }
      });
    }
    
    //多选
    $('.control-chosen').chosen({
      allow_single_deselect: true
    });


    

    if(reception!=[]){
      loadingTimeQuantum('reception',reception);
    }else{
      var $parent=$('.time_quantum-box[data-parent=reception]');
      //开始时间：
      $parent.find(".new_start_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
      	language : 'zh-CN',
        startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var startTime = e.date;  
          console.log(e)
          console.log(this)
          $(this).siblings('.new_end_time').datetimepicker('setStartDate',startTime);
      });
      //结束时间：
      $parent.find(".new_end_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
        language : 'zh-CN',
      	startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var endTime = e.date;  
          console.log(e.date)
          $(this).siblings('.new_start_time').datetimepicker('setEndDate',endTime);
      });

      $parent.find(".new_start_time").val('00:00');
      $parent.find(".new_end_time").val('00:00');
    }
    if(pickup!=[]){
      loadingTimeQuantum('pickup',pickup);
    }else{
      var $parent=$('.time_quantum-box[data-parent=pickup]');
      //开始时间：
      $parent.find(".new_start_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
      	language : 'zh-CN',
        startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var startTime = e.date;  
          console.log(e)
          console.log(this)
          $(this).siblings('.new_end_time').datetimepicker('setStartDate',startTime);
      });
      //结束时间：
      $parent.find(".new_end_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
        language : 'zh-CN',
      	startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var endTime = e.date;  
          console.log(e.date)
          $(this).siblings('.new_start_time').datetimepicker('setEndDate',endTime);
      });

      $parent.find(".new_start_time").val('00:00');
      $parent.find(".new_end_time").val('00:00');
    }



    $('.time_quantum-box .week li').click(function(){
      if(!$(this).hasClass('disabled')){
        $(this).hasClass('selected')?$(this).removeClass('selected'):$(this).addClass('selected');
      }
    });
    /*新增 */
    $('.time_quantum-box .addnew_li').click(function(){

      var $li = $('<li></li>');
      $li.html('<div class="time"><div class="input-daterange input-group"><input type="text"class="control-input form-control new_start_time"name="start"placeholder="开始时间"><span class="input-group-addon">至</span><input type="text"class="control-input form-control new_end_time"name="end"placeholder="结束时间"></div></div><div class="week"><ul><li>周一</li><li>周二</li><li>周三</li><li>周四</li><li>周五</li><li>周六</li><li>周日</li></ul><p class="curr-weeks"></p></div><div class="control"><a href="javasript:;"class="control_save"onclick="time_quantumSave(this)">确定</a></div>');
      $(this).siblings('ul').append($li);
      $(this).parent().addClass('editting');

      //开始时间：
      $li.find(".new_start_time").datetimepicker({
        format : "hh:ii",
        autoclose : true,
        language : 'zh-CN',
        startView : 1,//时视图
        maxView: 1,
        pickerPosition : "bottom-left",
        minuteStep : 5
      }).on('changeDate',function(e){  
          var startTime = e.date;  
          $li.find('.new_end_time').datetimepicker('setStartDate',startTime);
      });
      //结束时间：
      $li.find(".new_end_time").datetimepicker({
        format : "hh:ii",
        autoclose : true,
        language : 'zh-CN',
        startView : 1,//时视图
        maxView: 1,
        pickerPosition : "bottom-left",
        minuteStep : 5
      }).on('changeDate',function(e){  
          var endTime = e.date;  
          $li.find('.new_start_time').datetimepicker('setEndDate',endTime);
      });
      
      $li.find(".new_start_time").val('00:00');
      $li.find(".new_end_time").val('00:00');
      
      weekCheck(this);

      $li.find('.week').children('ul').children('li').click(function(){
        if(!$(this).hasClass('disabled')){
          $(this).hasClass('selected')?$(this).removeClass('selected'):$(this).addClass('selected');
        }
      });
    });
  }
  /*上门自提 -E---------------------------------------------- */
  /*同城配送 -S---------------------------------------------- */
  if($('.city_distribution-con').length>0){
    if(reception!=[]){
      loadingTimeQuantum('reception',reception);
    }else{
      var $parent=$('.time_quantum-box[data-parent=reception]');
      //开始时间：
      $parent.find(".new_start_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
      	language : 'zh-CN',
        startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var startTime = e.date;  
          console.log(e)
          console.log(this)
          $(this).siblings('.new_end_time').datetimepicker('setStartDate',startTime);
      });
      //结束时间：
      $parent.find(".new_end_time").datetimepicker({
      	format : "hh:ii",
      	autoclose : true,
        language : 'zh-CN',
      	startView : 1,//时视图
        maxView: 1,
      	pickerPosition : "bottom-left",
      	minuteStep : 5
      }).on('changeDate',function(e){  
          var endTime = e.date;  
          console.log(e.date)
          $(this).siblings('.new_start_time').datetimepicker('setEndDate',endTime);
      });

      $parent.find(".new_start_time").val('00:00');
      $parent.find(".new_end_time").val('00:00');
    }

    if($('.city_timing .selct-checkbox').is(':checked')){
      $('.city_timingbox').show();
    }else{
      $('.city_timingbox').hide();
    }

    $('.city_timing .selct-checkbox').click(function(){
      if($(this).is(':checked')){
        $('.city_timingbox').show();
      }else{
        $('.city_timingbox').hide();
      }
    });

    $('.control-submit').click(function(){
      var $parent=$('.time_quantum-box[data-parent=reception]');
      reception = [];
      $parent.children('ul').children('li').each(function(){
        var obj={};
        obj['startTime']=$(this).find('.new_start_time').val();
        obj['endTime']=$(this).find('.new_end_time').val();
        obj['week']=$(this).find('.curr-weeks').text();
        reception.push(obj);
      });
      console.log(reception)
    })


  }
  /*同城配送 -E---------------------------------------------- */
  /*三级分销-分销海报 -S---------------------------------------------- */
  if($('.poster-con').length>0){
    var width = parseFloat(saveJson[0].width);
    var left = parseFloat(saveJson[0].left);
    var top = parseFloat(saveJson[0].top);
    $(".poster-con").find('[data-target]').children('.imgbox').css('width',width*300/750);
    $(".poster-con").find('[data-target]').children('.imgbox').css('top',top*300/750);
    $(".poster-con").find('[data-target]').children('.imgbox').css('left',left*482/1206);
    var codeWidth = width;
    $( ".code_width.slider" ).slider({
      value: width,
      max: 750,
      create: function() {
        $(this).children().text(width);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *300/750;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.imgbox').css(target,thisVal);
        codeWidth = ui.value;
        LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
        $( ".code_left.slider" ).slider({
          max: 750-codeWidth,
          create: function() {
            $(this).children().text( $( this ).slider( "value" ) );
          },
          slide: function( event, ui ) {
            var target = $(this).data('edit');
            var thisVal = ui.value *300/750;
            $(this).children().text( ui.value );
            $(".poster-con").find('[data-target]').children('.imgbox').css(target,thisVal);
            LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
          }
        });
        $( ".code_height.slider" ).slider({
          max: 1206-codeWidth,
          create: function() {
            $(this).children().text( $( this ).slider( "value" ) );
          },
          slide: function( event, ui ) {
            var target = $(this).data('edit');
            var thisVal = ui.value *482/1206;
            $(this).children().text( ui.value );
            $(".poster-con").find('[data-target]').children('.imgbox').css(target,thisVal);
            LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
          }
        });
      }
    });
    $( ".code_left.slider" ).slider({
      value: left,
      max: 750-codeWidth,
      create: function() {
        $(this).children().text(left);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *300/750;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.imgbox').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
      }
    });
    $( ".code_height.slider" ).slider({
      value: top,
      max: 1206-codeWidth,
      create: function() {
        $(this).children().text(top);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *482/1206;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.imgbox').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
      }
    });

    var leftImg = parseFloat(saveJson[1].left);
    var topImg = parseFloat(saveJson[1].top);
    var widthImg = parseFloat(saveJson[1].width);
    $(".poster-con").find('[data-target]').children('.user_img').css('width',widthImg*300/750);
    $(".poster-con").find('[data-target]').children('.user_img').css('height',widthImg*300/750);
    $(".poster-con").find('[data-target]').children('.user_img').css('top',topImg*300/750);
    $(".poster-con").find('[data-target]').children('.user_img').css('left',leftImg*482/1206);
    $( ".user_img_width.slider" ).slider({
      value: widthImg,
      max: 750,
      create: function() {
        $(this).children().text(widthImg);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *300/750;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.user_img').css(target,thisVal);
        $(".poster-con").find('[data-target]').children('.user_img').css('height',thisVal);
        widthImg = ui.value;
        LMData.prototype.saveJson(saveJson,'userimg',target,ui.value);
        $( ".user_img_left.slider" ).slider({
          max: 750-widthImg,
          create: function() {
            $(this).children().text(leftImg);
          },
          slide: function( event, ui ) {
            var target = $(this).data('edit');
            var thisVal = ui.value *300/750;
            $(this).children().text( ui.value );
            $(".poster-con").find('[data-target]').children('.user_img').css(target,thisVal);
            LMData.prototype.saveJson(saveJson,'userimg',target,ui.value);
          }
        });
        $( ".user_img_top.slider" ).slider({
          max: 1206-widthImg,
          create: function() {
            $(this).children().text(topImg);
          },
          slide: function( event, ui ) {
            var target = $(this).data('edit');
            var thisVal = ui.value *482/1206;
            $(this).children().text( ui.value );
            $(".poster-con").find('[data-target]').children('.user_img').css(target,thisVal);
            LMData.prototype.saveJson(saveJson,'userimg',target,ui.value);
          }
        });
      }
    });
    $( ".user_img_left.slider" ).slider({
      value: leftImg,
      max: 750-widthImg,
      create: function() {
        $(this).children().text(leftImg);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *300/750;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.user_img').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'userimg',target,ui.value);
      }
    });
    $( ".user_img_top.slider" ).slider({
      value: topImg,
      max: 1206-widthImg,
      create: function() {
        $(this).children().text(topImg);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *482/1206;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.user_img').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'userimg',target,ui.value);
      }
    });
    var leftName = parseFloat(saveJson[2].left);
    var topName = parseFloat(saveJson[2].top);
    var fontSize = parseFloat(saveJson[2].fontSize);
    $(".poster-con").find('[data-target]').children('.user').css('font-size',fontSize+'px');
    $(".poster-con").find('[data-target]').children('.user').css('top',topName*300/750);
    $(".poster-con").find('[data-target]').children('.user').css('left',leftName*482/1206);
    $(".poster-con .poster-user_name").val(fontSize);
    var widthName = $(".poster-con").find('[data-target]').children('.user').outerWidth()*750/300;
    var heightName = $(".poster-con").find('[data-target]').children('.user').outerHeight()*1206/482;
    $( ".user_name_left.slider" ).slider({
      value: leftName,
      max: 750-widthName,
      create: function() {
        $(this).children().text(leftName);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *300/750;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.user').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'userName',target,ui.value);
      }
    });
    $( ".user_name_top.slider" ).slider({
      value: topName,
      max: 1206-heightName,
      create: function() {
        $(this).children().text(topName);
      },
      slide: function( event, ui ) {
        var target = $(this).data('edit');
        var thisVal = ui.value *482/1206;
        $(this).children().text( ui.value );
        $(".poster-con").find('[data-target]').children('.user').css(target,thisVal);
        LMData.prototype.saveJson(saveJson,'userName',target,ui.value);
      }
    });
    $(".poster-con .poster-user_name").keyup(function(){
      var widthName = $(".poster-con").find('[data-target]').children('.user').outerWidth()*750/300;
      var heightName = $(".poster-con").find('[data-target]').children('.user').outerHeight()*1206/482;
      $( ".user_name_left.slider" ).slider({
        // value: leftName,
        max: 750-widthName,
        create: function() {
          $(this).children().text(leftName);
        },
        slide: function( event, ui ) {
          var target = $(this).data('edit');
          var thisVal = ui.value *300/750;
          $(this).children().text( ui.value );
          $(".poster-con").find('[data-target]').children('.user').css(target,thisVal);
          LMData.prototype.saveJson(saveJson,'userName',target,ui.value);
        }
      });
      $( ".user_name_top.slider" ).slider({
        // value: topName,
        max: 1206-heightName,
        create: function() {
          $(this).children().text(topName);
        },
        slide: function( event, ui ) {
          var target = $(this).data('edit');
          var thisVal = ui.value *482/1206;
          $(this).children().text( ui.value );
          $(".poster-con").find('[data-target]').children('.user').css(target,thisVal);
          LMData.prototype.saveJson(saveJson,'userName',target,ui.value);
        }
      });
      console.log(saveJson)
    });

    var colorUser = saveJson[2].color;
    $(".poster-con").find('[data-target]').children('.user').css('color','#'+colorUser);
    $(".poster-con .btn_titlecolor").attr('data-original',colorUser).attr('data-newcol',colorUser).css('background-color','#'+colorUser);
    $('.poster-con .color-box').colpick({
      colorScheme:'light',
      layout:'rgbhex',
      // color:colorUser,
      onBeforeShow:function(hsb,hex,rgb,el){
        $(this).colpickSetColor($(this).attr('data-newcol'));
      },
      onSubmit:function(hsb,hex,rgb,el) {
        $(el).attr('data-newcol','#'+hex);
        $(el).css('background-color','#'+hex);
        
        $(".poster-con").find('[data-target]').children('.user').css('color','#'+hex);
        LMData.prototype.saveJson(saveJson,'userName','color',hex);
        $(el).colpickHide();
      }
    });
    
  }
  /*三级分销-分销海报 -E---------------------------------------------- */
  /*评价管理 -S---------------------------------------------- */
  if($('.evaluation-con').length>0){


  }
  if($('.evaluation_page-con').length>0){

    $("#new_start_time").datetimepicker({
      format : "yyyy-mm-dd hh:ii:ss",
      autoclose : true,
      language : 'zh-CN',
      startView : 2,//时视图
      maxView: 1,
      pickerPosition : "bottom-left",
      minuteStep : 5
    }).on('changeDate',function(e){  
    });

    
    $('#score').raty({ 
      cancel: true,
      cancelHint: '取消评分',
      target: '#score-hint',
      targetKeep: true,
      hints: ['1分','2分','3分','4分','5分'],
      
    });
  }
  /*评价管理 -E---------------------------------------------- */
  /*打印设置 -S---------------------------------------------- */
  if($('.printer-con').length>0){
    $('.printer_trigger > .selct-checkbox-label > .selct-checkbox').click(function(){
      if($(this).is(':checked')){
        $(this).siblings('.trigger_box').find('.selct-checkbox-label').removeClass('disabled');
        $(this).siblings('.trigger_box').find('.selct-checkbox').removeAttr('disabled');
      }else{
        $(this).siblings('.trigger_box').find('.selct-checkbox-label').removeClass('selected').addClass('disabled');
        $(this).siblings('.trigger_box').find('.selct-checkbox').removeAttr('checked').attr('disabled',true);
      }
    });
  }
  /*打印设置 -E---------------------------------------------- */
  /*活动管理-精品团购-限时活动 -S---------------------------------------------- */
  if($('.activity-con').length>0){
    

    if(productSel==''){
      $('.activity-pro').hide();
    }else{
      $('.activity-pro').show();

      $.each(productSel,function(i,items){
        var $tr = $('<tr></tr>');
        $tr.attr('data-id',items.id);
        $tr.attr('data-multispec',items.multiSpec);
        var actHtml = items.activity.length>0?'<a href="javascript:void(0);" data-toggle="modal" data-title="查看活动" data-target=".other-activity-modal" onclick="otherActivityCheck(this)">'+items.activity.length+'</a>':'<a href="javascript:;">0</a>';
        if(items.multiSpec){//多规格
          var liHtml = '';
          $.each(items.spec,function(idx,item){
            liHtml += 
            '<li>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name spec-id">'+item.id+'</div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name">￥<span>'+item.price+'</span></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name activity_price"><input type="number" class="control-input" value="'+item.priceAct+'"></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name activity_inventory"><input type="number" class="control-input" value="'+item.inventoryAct+'"></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name"><span>'+item.inventory+'</span></div>'+
            '</div>'+
          '</li>';
          });
          var ulHtml='<ul>'+liHtml+'</ul>';
          var trHtml = 
          '<td class="sanji-pro min-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+items.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td class="sanji-pro min-pro spec-box" colspan="5">'+ulHtml+'</td>'+
          '<td class="limit-item">'+
            '<input type="number" class="control-input" value="'+items.limit+'">'+
          '</td>'+
          '<td class="sort">'+
            '<input type="number" class="control-input" value="'+items.sort+'">'+
          '</td>'+
          '<td class="other_act">'+actHtml+
          '</td>'+
          '<td>'+
            '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
          '</td>';
        }else{//单规格
          var trHtml = 
          '<td class="sanji-pro min-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+items.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td>单规格</td>'+
          '<td class="line_price">￥'+items.price+'</td>'+
          '<td class="activity_price">'+
            '<input type="number" class="control-input" value="'+items.priceActivity+'">'+
          '</td>'+
          '<td class="activity_inventory">'+
            '<input type="number" class="control-input" value="'+items.inventoryAct+'">'+
          '</td>'+
          '<td class="inventory">'+items.inventory+'</td>'+
          '<td class="limit-item">'+
            '<input type="number" class="control-input" value="'+items.limit+'">'+
          '</td>'+
          '<td class="sort">'+
            '<input type="number" class="control-input" value="'+items.sort+'">'+
          '</td>'+
          '<td class="other_act">'+actHtml+
          '</td>'+
          '<td>'+
            '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
          '</td>';
        }
        $tr.append(trHtml);
        $('.activity-pro tbody').append($tr);
      });

      
    }
      
    switch(proSelTable.default.state){
      case 'readonly':{
        $('.activity-con .control-input').attr('readonly',true);
        $('.activity-con .table-a').addClass('disabled');
        $('.activity-con .control-chosen,.activity-con .form-control').attr('disabled',true);
        $('.activity-con .limit-box').hide();
        break;
      }
      case 'edit':{
        break;
      }
    }

    //多选
    $('.control-chosen').chosen({
      allow_single_deselect: true,
      disable_search:true
    });
    //开始时间：
    $("#new_start_time").datetimepicker({
      format : "yyyy-mm-dd hh:ii",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      // endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 1
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        console.log(e)
        $('#new_end_time').datetimepicker('setStartDate',startTime);

        var endTime = $('#new_end_time').val();
        var startTime = $('#new_start_time').val();
        console.log(startTime)
        var obj = [];
        
        if(startTime!=''&&endTime!=''){
        $.each(productSel,function(i,item){

          if(item.activity!=''){
            var actLength = item.activity.length;
            var lastState = false;
            if(actLength==1){
              console.log(item.activity[0].startTime)
              if(endTime<item.activity[0].startTime&&endTime!=''){
                // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                // proSelObj.push(item);
                return false;
              }else if(startTime>item.activity[0].endTime&&startTime!=''){
                // lastState = true;
                // stateTime = false;
                // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                // return false;
              }else{
                obj.push(item.id);
                $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
              }
            }else{

              $.each(item.activity,function(n,itm){
                console.log(n)
                switch(true){
                  case n==0:{
                    if(endTime<itm.startTime&&endTime!=''){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else if(startTime>itm.endTime&&startTime!=''){
                      lastState = true;
                      // stateTime = false;
                      // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      // return false;
                    }
                    break;
                  }
                  case n!=0&&n!=(actLength-1):{
                    if(endTime<itm.startTime&&endTime!=''&&lastState){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else{
                      lastState = false;
                    }
                    if(startTime>itm.endTime&&startTime!=''){
                      lastState = true;
                    // }else if(startTime==''&&endTime==''){
                    //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                    //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                    //   proSelObj.push(item);
                    //   return false;
                    // }else{
                      // stateTime = false;
                      // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      // return false;
                    }
                    break;
                  }
                  case n==(actLength-1):{
                    if(endTime<itm.startTime&&endTime!=''&&lastState){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else if(startTime>itm.endTime&&startTime!=''){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else{
                      obj.push(item.id);
                      $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      return false;
                    }
                    break;
                  }
                }
              });

            }
          }else{
            // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            // proSelObj.push(item);
          }

          // if(item.startTime!=undefined&&item.endTime!=undefined){
          //   console.log(item.endTime<startTime)
          //   console.log(item.startTime>endTime)
          //   if(item.startTime>endTime&&endTime!=''){
          //     // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //     // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          //   }else if(item.endTime<startTime&&startTime!=''){
          //     // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //     // $(ev)addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          //   }else{
          //     // stateTime = false;
          //     obj.push(item.id);
          //     $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
          //     // return false;
          //   }
          // }else{
          //   // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //   // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          // }


        });
        
        }else{
          $.Toast("提示", "请选择活动结束时间！", "notice", {});
        }

        $('.activity-pro tbody>tr').each(function(){
          var dataId = $(this).attr('data-id');
          var ev = this;
          $(this).removeClass('error-tips');
          $.each(obj,function(i,item){
            if(dataId == item){
              $(ev).addClass('error-tips');
              return false;
            };
          })
        });
        
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
      format : "yyyy-mm-dd hh:ii",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      // endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 1
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        console.log(endTime)
        $('#new_start_time').datetimepicker('setEndDate',endTime);

        var endTime = $('#new_end_time').val();
        var startTime = $('#new_start_time').val();
        console.log(startTime)
        var obj = [];
        
        if(startTime!=''&&endTime!=''){
          $.each(productSel,function(i,item){

            if(item.activity!=''){
              var actLength = item.activity.length;
              var lastState = false;
              if(actLength==1){
                if(endTime<item.activity[0].startTime||startTime>item.activity[0].endTime){
                }else{
                  obj.push(item.id);
                  $.Toast("提示", "商品: "+item.id+" ,在其他活动优惠中，请重新选择", "notice", {});
                }
              }else{
                $.each(item.activity,function(n,itm){
                  console.log(n)
                  switch(true){
                    case n==0:{
                      if(endTime<itm.startTime){
                        return false;
                      }else if(startTime>itm.endTime){
                        lastState = true;
                      }
                      break;
                    }
                    case n!=0&&n!=(actLength-1):{
                      if(endTime<itm.startTime&&lastState){
                        return false;
                      }else{
                        lastState = false;
                      }
                      if(startTime>itm.endTime){
                        lastState = true;
                      }
                      break;
                    }
                    case n==(actLength-1):{
                      if(endTime<itm.startTime&&lastState){
                        return false;
                      }else if(startTime>itm.endTime){
                        return false;
                      }else{
                        obj.push(item.id);
                        $.Toast("提示", "商品: "+item.id+" ,在其他活动优惠中，请重新选择", "notice", {});
                        return false;
                      }
                      break;
                    }
                  }
                });
              }
            }
          });
        }else{
          $.Toast("提示", "请选择活动开始时间！", "notice", {});
        }

        $('.activity-pro tbody>tr').each(function(){
          var dataId = $(this).attr('data-id');
          var ev = this;
          $(this).removeClass('error-tips');
          $.each(obj,function(i,item){
            if(dataId == item){
              $(ev).addClass('error-tips');
              return false;
            };
          })
        });

    });

    $('.limit-box .selct-checkbox').click(function(){
      $('.activity-pro').attr('data-limit',$(this).val());
      $('.activity-pro .limit-item').find('input').val('');
    });
    
    /*确认保存*/
    $('.layout-bottom .control-submit').click(function(){

      var startTime = $('#new_start_time').val();
      var endTime = $('#new_end_time').val();



      proSelTable.rules = productSel.slice();
      $('.activity-pro tbody>tr').each(function(){
        var thisId = $(this).data('id');
        if($(this).attr('data-multispec')=='true'){
          var obj = [];
          var ev = this;
          $(ev).find('.spec-box>ul>li').each(function(){
            var objJson = {};
            objJson['id'] = $(this).find('.spec-id').text();
            objJson['priceAct'] = $(this).find('.activity_price').children().val();
            objJson['inventoryAct'] = $(this).find('.activity_inventory').children().val();
            obj.push(objJson);
          });
          var limit =  $(ev).find('.limit-item').children().val();
          var sort =  $(ev).find('.sort').children().val();
        }else{
          var obj = {};
          obj['priceAct'] = $(this).children('.activity_price').children().val();
          obj['inventoryAct'] = $(this).children('.activity_inventory').children().val();
          obj['limit'] = $(this).children('.limit-item').children().val();
          obj['sort'] = $(this).children('.sort').children().val();
          obj['startTime'] = startTime;
          obj['endTime'] = endTime;
        }
        $.each(proSelTable.rules,function(i,item){
          if(thisId == item.id){
            if(item.multiSpec){
              item.spec = $.extend(true,item.spec,obj);
              item.limit = limit;
              item.sort = sort;
              item.startTime = startTime;
              item.endTime = endTime;
            }else{
              item=$.extend(true,item,obj);
            }
            return false;
          }
        });
      });

      console.log(proSelTable)

    });



  }
  /*活动管理-精品团购-限时活动-E---------------------------------------------- */
  /*社区拼团-采购单 -S---------------------------------------------- */
  if($('.community-products-con').length>0){
    

    if(productSel==''){
      $('.activity-pro').hide();
    }else{
      $('.activity-pro').show();

      $.each(productSel,function(i,items){
        var $tr = $('<tr></tr>');
        $tr.attr('data-id',items.id);
        $tr.attr('data-multispec',items.multiSpec);
        var actHtml = items.activity.length>0?'<a href="javascript:void(0);" data-toggle="modal" data-title="查看活动" data-target=".other-activity-modal" onclick="otherActivityCheck(this)">'+items.activity.length+'</a>':'<a href="javascript:;">0</a>';
        if(items.multiSpec){//多规格
          var liHtml = '';
          $.each(items.spec,function(idx,item){
            liHtml += 
            '<li>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name spec-id">'+item.id+'</div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name">￥<span>'+item.price+'</span></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name activity_price"><input type="number" class="control-input" value="'+item.priceAct+'"></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name activity_inventory"><input type="number" class="control-input" value="'+item.inventoryAct+'"></div>'+
            '</div>'+
            '<div class="sanji-activity-pro">'+
              '<div class="name"><span>'+item.inventory+'</span></div>'+
            '</div>'+
          '</li>';
          });
          var ulHtml='<ul>'+liHtml+'</ul>';
          var trHtml = 
          '<td class="sanji-pro min-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+items.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td class="sanji-pro min-pro spec-box" colspan="5">'+ulHtml+'</td>'+
          // '<td class="limit-item">'+
          //   '<input type="number" class="control-input" value="'+items.limit+'">'+
          // '</td>'+
          // '<td class="sort">'+
          //   '<input type="number" class="control-input" value="'+items.sort+'">'+
          // '</td>'+
          // '<td class="other_act">'+actHtml+
          // '</td>'+
          '<td>'+
            '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
          '</td>';
        }else{//单规格
          var trHtml = 
          '<td class="sanji-pro min-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+items.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td>单规格</td>'+
          '<td class="line_price">￥'+items.price+'</td>'+
          '<td class="activity_price">'+
            '<input type="number" class="control-input" value="'+items.priceActivity+'">'+
          '</td>'+
          '<td class="activity_inventory">'+
            '<input type="number" class="control-input" value="'+items.inventoryAct+'">'+
          '</td>'+
          '<td class="inventory">'+items.inventory+'</td>'+
          // '<td class="limit-item">'+
          //   '<input type="number" class="control-input" value="'+items.limit+'">'+
          // '</td>'+
          // '<td class="sort">'+
          //   '<input type="number" class="control-input" value="'+items.sort+'">'+
          // '</td>'+
          // '<td class="other_act">'+actHtml+
          // '</td>'+
          '<td>'+
            '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
          '</td>';
        }
        $tr.append(trHtml);
        $('.activity-pro tbody').append($tr);
      });

      
    }
      
    switch(proSelTable.default.state){
      case 'readonly':{
        $('.community-products-con .control-input').attr('readonly',true);
        $('.community-products-con .table-a').addClass('disabled');
        $('.community-products-con .control-chosen,.community-products-con .form-control').attr('disabled',true);
        break;
      }
      case 'edit':{
        break;
      }
    }

    //多选
    $('.control-chosen').chosen({
      allow_single_deselect: true,
      disable_search:true
    });
    //开始时间：
    $("#new_start_time").datetimepicker({
      format : "yyyy-mm-dd hh:ii",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      // endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 1
    }).on('changeDate',function(e){  
        var startTime = e.date;  
        console.log(e)
        $('#new_end_time').datetimepicker('setStartDate',startTime);

        var endTime = $('#new_end_time').val();
        var startTime = $('#new_start_time').val();
        console.log(startTime)
        var obj = [];
        
        if(startTime!=''&&endTime!=''){
        $.each(productSel,function(i,item){

          if(item.activity!=''){
            var actLength = item.activity.length;
            var lastState = false;
            if(actLength==1){
              console.log(item.activity[0].startTime)
              if(endTime<item.activity[0].startTime&&endTime!=''){
                // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                // proSelObj.push(item);
                return false;
              }else if(startTime>item.activity[0].endTime&&startTime!=''){
                // lastState = true;
                // stateTime = false;
                // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                // return false;
              }else{
                obj.push(item.id);
                $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
              }
            }else{

              $.each(item.activity,function(n,itm){
                console.log(n)
                switch(true){
                  case n==0:{
                    if(endTime<itm.startTime&&endTime!=''){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else if(startTime>itm.endTime&&startTime!=''){
                      lastState = true;
                      // stateTime = false;
                      // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      // return false;
                    }
                    break;
                  }
                  case n!=0&&n!=(actLength-1):{
                    if(endTime<itm.startTime&&endTime!=''&&lastState){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else{
                      lastState = false;
                    }
                    if(startTime>itm.endTime&&startTime!=''){
                      lastState = true;
                    // }else if(startTime==''&&endTime==''){
                    //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                    //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                    //   proSelObj.push(item);
                    //   return false;
                    // }else{
                      // stateTime = false;
                      // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      // return false;
                    }
                    break;
                  }
                  case n==(actLength-1):{
                    if(endTime<itm.startTime&&endTime!=''&&lastState){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else if(startTime>itm.endTime&&startTime!=''){
                      // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
                      // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
                      // proSelObj.push(item);
                      return false;
                    }else{
                      obj.push(item.id);
                      $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
                      return false;
                    }
                    break;
                  }
                }
              });

            }
          }else{
            // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            // proSelObj.push(item);
          }

          // if(item.startTime!=undefined&&item.endTime!=undefined){
          //   console.log(item.endTime<startTime)
          //   console.log(item.startTime>endTime)
          //   if(item.startTime>endTime&&endTime!=''){
          //     // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //     // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          //   }else if(item.endTime<startTime&&startTime!=''){
          //     // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //     // $(ev)addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          //   }else{
          //     // stateTime = false;
          //     obj.push(item.id);
          //     $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
          //     // return false;
          //   }
          // }else{
          //   // $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
          //   // $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
          // }


        });
        
        }else{
          $.Toast("提示", "请选择活动结束时间！", "notice", {});
        }

        $('.activity-pro tbody>tr').each(function(){
          var dataId = $(this).attr('data-id');
          var ev = this;
          $(this).removeClass('error-tips');
          $.each(obj,function(i,item){
            if(dataId == item){
              $(ev).addClass('error-tips');
              return false;
            };
          })
        });
        
    });
    //结束时间：
    $("#new_end_time").datetimepicker({
      format : "yyyy-mm-dd hh:ii",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      // endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 1
    }).on('changeDate',function(e){  
        var endTime = e.date;  
        console.log(endTime)
        $('#new_start_time').datetimepicker('setEndDate',endTime);

        var endTime = $('#new_end_time').val();
        var startTime = $('#new_start_time').val();
        console.log(startTime)
        var obj = [];
        
        if(startTime!=''&&endTime!=''){
          $.each(productSel,function(i,item){

            if(item.activity!=''){
              var actLength = item.activity.length;
              var lastState = false;
              if(actLength==1){
                if(endTime<item.activity[0].startTime||startTime>item.activity[0].endTime){
                }else{
                  obj.push(item.id);
                  $.Toast("提示", "商品: "+item.id+" ,在其他活动优惠中，请重新选择", "notice", {});
                }
              }else{
                $.each(item.activity,function(n,itm){
                  console.log(n)
                  switch(true){
                    case n==0:{
                      if(endTime<itm.startTime){
                        return false;
                      }else if(startTime>itm.endTime){
                        lastState = true;
                      }
                      break;
                    }
                    case n!=0&&n!=(actLength-1):{
                      if(endTime<itm.startTime&&lastState){
                        return false;
                      }else{
                        lastState = false;
                      }
                      if(startTime>itm.endTime){
                        lastState = true;
                      }
                      break;
                    }
                    case n==(actLength-1):{
                      if(endTime<itm.startTime&&lastState){
                        return false;
                      }else if(startTime>itm.endTime){
                        return false;
                      }else{
                        obj.push(item.id);
                        $.Toast("提示", "商品: "+item.id+" ,在其他活动优惠中，请重新选择", "notice", {});
                        return false;
                      }
                      break;
                    }
                  }
                });
              }
            }
          });
        }else{
          $.Toast("提示", "请选择活动开始时间！", "notice", {});
        }

        $('.activity-pro tbody>tr').each(function(){
          var dataId = $(this).attr('data-id');
          var ev = this;
          $(this).removeClass('error-tips');
          $.each(obj,function(i,item){
            if(dataId == item){
              $(ev).addClass('error-tips');
              return false;
            };
          })
        });

    });

    $('.limit-box .selct-checkbox').click(function(){
      $('.activity-pro').attr('data-limit',$(this).val());
      $('.activity-pro .limit-item').find('input').val('');
    });
    
    /*确认保存*/
    $('.layout-bottom .control-submit').click(function(){

      var startTime = $('#new_start_time').val();
      var endTime = $('#new_end_time').val();



      proSelTable.rules = productSel.slice();
      $('.activity-pro tbody>tr').each(function(){
        var thisId = $(this).data('id');
        if($(this).attr('data-multispec')=='true'){
          var obj = [];
          var ev = this;
          $(ev).find('.spec-box>ul>li').each(function(){
            var objJson = {};
            objJson['id'] = $(this).find('.spec-id').text();
            objJson['priceAct'] = $(this).find('.activity_price').children().val();
            objJson['inventoryAct'] = $(this).find('.activity_inventory').children().val();
            obj.push(objJson);
          });
          var limit =  $(ev).find('.limit-item').children().val();
          var sort =  $(ev).find('.sort').children().val();
        }else{
          var obj = {};
          obj['priceAct'] = $(this).children('.activity_price').children().val();
          obj['inventoryAct'] = $(this).children('.activity_inventory').children().val();
          obj['limit'] = $(this).children('.limit-item').children().val();
          obj['sort'] = $(this).children('.sort').children().val();
          obj['startTime'] = startTime;
          obj['endTime'] = endTime;
        }
        $.each(proSelTable.rules,function(i,item){
          if(thisId == item.id){
            if(item.multiSpec){
              item.spec = $.extend(true,item.spec,obj);
              item.limit = limit;
              item.sort = sort;
              item.startTime = startTime;
              item.endTime = endTime;
            }else{
              item=$.extend(true,item,obj);
            }
            return false;
          }
        });
      });

      console.log(proSelTable)

    });



  }
  /*社区拼团-采购单 -E---------------------------------------------- */
  /*权限管理 -S---------------------------------------------- */
  if($('.permissions-con').length>0){
    if(productSel!=''){
      $('.permissions-con .service-section').html('');
      $.each(productSel,function(i,items){
        $('.permissions-con .service-section').prepend('<div class="service-box"><span class="label"data-serviceid="'+items.id+'"title="'+items.name+'"><div class="min-imgbox"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div><div class="wx-name">'+items.name+'</div></div>');
      });
    }
  }
  /*权限管理 -E---------------------------------------------- */
  /*采购单 -S---------------------------------------------- */
  if($('.community-products-con').length>0){
    //结束时间：
    $("#delivery_time").datetimepicker({
      format : "yyyy-mm-dd",
      autoclose : true,
      todayBtn : false,
      todayHighlight : true,
      startDate : 2000 - 1 - 1,
      language : 'zh-CN',
      startView : 2,//月视图
      minView: 2,
      // endDate: today,
      // datesDisabled:[today],
      pickerPosition : "bottom-left",
      minuteStep : 5
    }).on('changeDate',function(e){  
    });

  }
  /*采购单 -E---------------------------------------------- */


});
/*订单设置-上门自提 -S---------------------------------------------- */
/*loading */
function loadingTimeQuantum(parent,json){
  var hasArea='',allArea='',liHtml='';
  var $parent=$('.time_quantum-box[data-parent='+parent+']');
  $parent.removeClass('editting').children('ul').html('');
  $.each(json,function(i,item){
    allArea+=item.week+'、';
  });
  allArea = allArea.split('、');
  /*删除空数组 */
  allArea=$.grep(allArea,function(n,i){  
    return n;  
  },false);
  console.log(allArea)
  $.each(json,function(i,item){
    hasArea = item.week.split(',');
    var $li = $('<li class="disabled"></li>');
    liHtml = 
      '<div class="time">'+
        '<div class="input-daterange input-group">'+
          '<input type="text" class="control-input form-control new_start_time" name="start" placeholder="开始时间">'+
          '<span class="input-group-addon">至</span>'+
          '<input type="text" class="control-input form-control new_end_time" name="end" placeholder="结束时间">'+
        '</div>'+
      '</div>'+
      '<div class="week">'+
        '<ul>'+
          '<li>周一</li><li>周二</li><li>周三</li><li>周四</li><li>周五</li><li>周六</li><li>周日</li>'+
        '</ul>'+
        '<p class="curr-weeks">'+item.week+'</p>'+
      '</div>'+
      '<div class="control">'+
        '<a href="javasript:;" class="control_edit" onclick="time_quantumEdit(this)">编辑</a><span class="split">|</span><a href="javasript:;" class="control_cancel" onclick="time_quantumRemove(this)">删除</a>'+
      '</div>';
    $li.html(liHtml);

    $li.children('.week').find('li').each(function(idx,items){
      if(hasArea.indexOf($(items).text())>=0){
        $(items).addClass('selected');
      }else if(allArea.indexOf($(items).text())>=0){
        $(items).addClass('disabled');
      }
    });
    
    $li.find('.control-input').attr('readonly',true);
    
    $li.find(".new_start_time").val(item.startTime);
    $li.find(".new_end_time").val(item.endTime);
    
    $parent.children('ul').append($li);
  });
  if(hasweek($parent.children('ul')).length==7){
    $parent.find('.addnew_li').hide();
  }else{
    $parent.find('.addnew_li').removeAttr('style');
  }
}
function hasweek(parent){
  var hasArea = '';
  $(parent).parents('.time_quantum-box').children('ul').children('li').each(function(i,item){
    hasArea += $(item).find('.curr-weeks').text() + ',';
  });
  hasArea = hasArea.split(',');
  /*删除空数组 */
  hasArea=$.grep(hasArea,function(n,i){  
    return n;  
  },false);
  
  return hasArea;
  
}
function weekCheck(parent){
  var hasArea='';
  var $target;
  $(parent).parents('.time_quantum-box').children('ul').children('li').each(function(i,item){
    if($(item).hasClass('disabled')){
      hasArea += $(item).find('.curr-weeks').text() + ',';
    }else{
      $target = $(item);
    }
  });
  hasArea = hasArea.split(',');
  hasArea=$.grep(hasArea,function(n,i){  
    return n;  
  },false);
  console.log(hasArea)

  $target.children('.week').find('li').each(function(idx,items){
    if(hasArea.indexOf($(items).text())>=0){
      $(items).addClass('disabled');
    }else{
      $(items).removeClass('disabled');
    }
  });
}
function time_quantumRemove(ev){

  $(ev).parents('.time_quantum-box').removeClass('editting');
  $(ev).parents('.time_quantum-box').find('.addnew_li').removeAttr('style');
  $(ev).parents('li').remove();
  
}
function time_quantumSave(ev){
  var edit_controlHtml = '<a href="javasript:;" class="control_edit" onclick="time_quantumEdit(this)">编辑</a><span class="split">|</span><a href="javasript:;" class="control_cancel" onclick="time_quantumRemove(this)">删除</a>'
  var $this = $(ev);
  var startTime = $this.parent().siblings('.time').find('.new_start_time').val();
  var endTime = $this.parent().siblings('.time').find('.new_end_time').val();
  if(startTime>=endTime){
    $.Toast("提示", "关门时间必须大于开门时间", "notice", {});
    return false;
  }else{
    var text='';
    $this.parent().siblings('.week').find('li').each(function(){
      if($(this).hasClass('selected')){
        text=text==''?$(this).text():text+','+$(this).text();
      }
    });
    if(text==''){
      $.Toast("提示", "请至少选择一天", "notice", {});
      return false;
    }
    $this.parent().siblings('.week').children('.curr-weeks').text(text);

    $this.parents('li').addClass('disabled');
    $this.parents('.time_quantum-box').removeClass('editting');

    $this.parent().siblings('.time').find('.control-input').attr('readonly',true).datetimepicker('remove');

    if(hasweek(ev).length==7){
      $this.parents('.time_quantum-box').find('.addnew_li').hide();
    }else{
      $this.parents('.time_quantum-box').find('.addnew_li').removeAttr('style');
    }

    $this.parent().html(edit_controlHtml);
  }
}
function time_quantumEdit(ev){
  var add_controlHtml = '<a href="javasript:;" class="control_save" onclick="time_quantumSave(this)">确定</a>'
  var starVal = $(ev).parent().siblings('.time').find(".new_start_time").val();
  var endVal = $(ev).parent().siblings('.time').find(".new_end_time").val();
  var today = new Date();
  var year = today.getFullYear(); //获取完整的年份(4位,1970)
  var month = today.getMonth()+1; //获取当前月份(0-11,0代表1月)
  var day = today.getDate(); //获取当前日(1-31)
  today = year+'-'+month+'-'+day;
  $(ev).parents('li').removeClass('disabled');
  $(ev).parents('.time_quantum-box').addClass('editting');

  weekCheck(ev);
  
  $(ev).parent().siblings('.time').find('.control-input').removeAttr('readonly');
  
  $(ev).parent().siblings('.time').find(".new_start_time").val(today+" "+starVal);
  $(ev).parent().siblings('.time').find(".new_end_time").val(today+" "+endVal);

  $(ev).parent().siblings('.time').find(".new_start_time").datetimepicker({
    format : "hh:ii",
    autoclose : true,
    language : 'zh-CN',
    startView : 1,//时视图
    maxView: 1,
    pickerPosition : "bottom-left",
    minuteStep : 5
  }).on('changeDate',function(e){  
      var startTime = e.date;  
      console.log(e)
      $(ev).siblings('.new_end_time').datetimepicker('setStartDate',startTime);
  });
  //结束时间：
  $(ev).parent().siblings('.time').find(".new_end_time").datetimepicker({
    format : "hh:ii",
    autoclose : true,
    language : 'zh-CN',
    startView : 1,//时视图
    maxView: 1,
    pickerPosition : "bottom-left",
    minuteStep : 5
  }).on('changeDate',function(e){  
      var endTime = e.date;  
      $(ev).siblings('.new_start_time').datetimepicker('setEndDate',endTime);
  });
  
  $(ev).parent().siblings('.time').find(".new_start_time").val(starVal);
  $(ev).parent().siblings('.time').find(".new_end_time").val(endVal);

  $(ev).parent().html(add_controlHtml);

}
/*订单设置-上门自提 -E---------------------------------------------- */

function findName(json,id){
  var name;
  $.each(json,function(i,item){
    if(id==item.id){
      name = item.name;
      return false;
    }
  });
  return name;
}
//非负的正整数
function positiveInteger(ev) {
  var ss = /^[1-9]\d*$/;
  if (!ss.test(ev.value)) {
    $(ev).val('');
    $.Toast("提示", "请输入正确的格式", "notice", {});
    return false;
  }
}
/*带两位小数*/
function decimalPoint(ev) {
  var ss =  /^([\+ \-]?(([1-9]\d*)|(0)))([.]\d{0,2})?$/;
  if (!ss.test(ev.value)) {
    if(ev.value!=='+'&&ev.value!=='-'){
      $(ev).val('');
      $.Toast("提示", "请输入正确的格式", "notice", {});
      return false;
    }
  }
}
//超级表单-存储数据
function superformInput(ev,type){
  var dataId = 'basicSetup';
  var thisId = $(ev).attr('data-editid');
  var address = $(ev).attr('data-address');
  var thisVal = $(ev).val();
  switch(type){
    case 'text':{
      $('.layout-show').find('[data-editid='+thisId+']').text(thisVal);
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'radio':{
      $(ev).parents('.radio-box').siblings().attr('data-stylediy',thisVal);
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'times_day':{
      positiveInteger(ev);
      if(parseInt($(ev).val())>parseInt($(ev).parents('.superform_times-box').find('.add_daytimes').val())){
        $.Toast("提示", "累计次数必须大于或等于每天次数", "notice", {});
        thisVal = $(ev).parents('.superform_times-box').find('.add_daytimes').val();
        $(ev).val(thisVal);
      }
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'positiveInteger':{
      positiveInteger(ev);
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'decimalPoint':{
      decimalPoint(ev);
      // LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'layout_set-text':{
      $('.layout-show').find('[data-editid='+thisId+']').text(thisVal);
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
    case 'layout_set-bgColor':{
      $('.layout-show .iphone-screen').css('background-color',thisVal);
      LMData.prototype.saveJson(layoutModalSelect,dataId,address,thisVal);
      break;
    }
  }
}


/*布局排版-S-----------------------------------------------*/
//生成扫码浏览页面内容
// var layoutHtml='<li class="" id="a3_1" data-id="a3_1" data-laymodal="dianzhao3" onclick="stateEdit(this)"><div class="lay_dianzhao"><img src="images/dz_bg.png" class="lay_dianzhao-bg" ondragstart="return false" alt="" title=""><div class="lay_dianzhao-img"><img src="images/default_men.jpg" class="lay_dianzhao-logo" ondragstart="return false" alt="" title=""></div><div class="lay_dianzhao-title"><span class="name" data-editid="dianzhao_name">店名3</span></div><a href="javascript:void(0);" class="layshow_remove" onclick="deletelayout(this)"><i class="glyphicon glyphicon-trash"></i></a></div></li><li class="" id="a1_2" data-id="a1_2" data-laymodal="dianzhao1" onclick="stateEdit(this)"><div class="lay_dianzhao"><img src="images/dz_bg.png" class="lay_dianzhao-bg" ondragstart="return false" alt="" title=""><div class="lay_dianzhao-img"><img src="images/default_men.jpg" class="lay_dianzhao-logo" ondragstart="return false" alt="" title=""></div><div class="lay_dianzhao-title"><span class="name" data-editid="dianzhao_name">店名1</span></div><a href="javascript:void(0);" class="layshow_remove" onclick="deletelayout(this)"><i class="glyphicon glyphicon-trash"></i></a></div></li><li class="action" id="a0_3" data-id="a0_3" data-laymodal="dianzhao" onclick="stateEdit(this)"><div class="lay_dianzhao"><img src="images/dz_bg.png" class="lay_dianzhao-bg" ondragstart="return false" alt="" title=""><div class="lay_dianzhao-img"><img src="images/default_men.jpg" class="lay_dianzhao-logo" ondragstart="return false" alt="" title=""></div><div class="lay_dianzhao-title"><span class="name" data-editid="dianzhao_name">店名</span></div><a href="javascript:void(0);" class="layshow_remove" onclick="deletelayout(this)"><i class="glyphicon glyphicon-trash"></i></a></div></li>';
//快速排版-手机预览：状态切换
 function stateEdit(ev){
   if($(ev).hasClass('action')){
      return false;
   }else{

     var dataId = $(ev).attr('data-id');
     var LM = $(ev).attr('data-laymodal');
     var exDataId = $(ev).parent().children('.action').attr('data-id');
     var exLM = $(ev).parent().children('.action').attr('data-laymodal');
     var ftnLoad = new LMData(dataId,LM);
     SaveLMData(exDataId,exLM);
     console.log(layoutModalSelect)
    if($(ev).parent().attr('id')=='layout_typeset'){//点击快速排版----------
      $(ev).addClass('action').siblings().removeClass('action');
      $(ev).parents('.main-layout').find('.iphone-screen-box').children('li[data-id="'+dataId+'"]').addClass('action').siblings().removeClass('action');
    }else if($(ev).parent().attr('id')=='layout_show'){//点击手机展示----------
      $(ev).addClass('action').siblings().removeClass('action');
      $(ev).parents('.main-layout').find('.layout-typeset-box').children('li[data-id="'+dataId+'"]').addClass('action').siblings().removeClass('action');
    }else if($(ev).parent().attr('id')=='layout_control'){//点击组件库----------
      return false;
    }else if($(ev).hasClass('iphone-bottom')||$(ev).hasClass('suspension')||$(ev).hasClass('music')){//底部菜单----------
      $(ev).parents('.iphone').find('.action').removeClass('action');
      $(ev).addClass('action');
    }

    //超级表单-切换
    if($(ev).parent().hasClass('iphone-switch')){
      $('.superform-install .layout-install').addClass('active').siblings().removeClass('active');
      $('.superform-install .superform_nav li').eq(0).addClass('active').siblings().removeClass('active');
      
      $('.layout-section .layout-install').addClass('active').siblings().removeClass('active');
      $('.layout-section .layout_nav li').eq(0).addClass('active').siblings().removeClass('active');
    }
  
    // $(ev).addClass('action').siblings().removeClass('action');
    //设置框内容边度
    $('.layout-install').html(ftnLoad.findJson(layoutModalSelect,dataId,'codeEdit'));
    $('.layout-install').children().attr('data-id',dataId);
    $('.layout-install').children().attr('data-laymodal',LM);
    LoadLMData(dataId,LM);
   }

}
//布局排版-设置框-删除按钮
function editRemove(ev){
  var dataId=$(ev).parents('.edit-box').data('id');
  var num;
  

  var stateShow = '删除';
  $('body').append("<div class='modal fade bs-example-modal-sm del-confirm'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要"+stateShow+"？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
  //点击确认
  $(".modal .btn-primary").click(function(){
    $.each(layoutModalSelect,function(i,item){
      if(item.id==dataId){
        num = i;
        return false;
      }
    });
    layoutModalSelect.splice(num,1);//delete
    console.log(layoutModalSelect);
    $('#layout_typeset').children('li[data-id="'+dataId+'"]').remove();
    $('#layout_show').children('li[data-id="'+dataId+'"]').remove();
    $(ev).parents('.edit-box').remove();
    
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
//布局排版-手机展示-删除按钮
function deletelayout(ev){
  var dataId=$(ev).parents('li').attr('data-id');
  var num;
  
  var stateShow = '删除';
  $('body').append("<div class='modal fade bs-example-modal-sm del-confirm'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要"+stateShow+"？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");
  //点击确认
  $(".modal .btn-primary").click(function(){
    $.each(layoutModalSelect,function(i,item){
      if(item.id==dataId){
        num = i;
        return false;
      }
    });
    layoutModalSelect.splice(num,1);//delete
    console.log(layoutModalSelect)
    $('#layout_typeset').children('li[data-id="'+dataId+'"]').remove();
    $('.layout-install').children().remove();
    $(ev).parents('li').remove();
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}

//布局排版-设置框-轮播删除按钮
function lay_imgDel(ev){
  if($(ev).parents('ul').children().length==1){
    $.Toast("提示", "不能再删除了", "notice", {});
    return false;
  }
  var dataId=$(ev).parents('.edit-box').attr('data-id');
  var styleDiy=$(ev).parents('.edit-box').attr('data-laymodal');
  var num = $(ev).parents('li').index();
  switch (styleDiy){
    case 'lunbotu':{
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup.splice(num,1);//delete
      if($(ev).parents('ul').children().length<=2){
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').hide();
      }else{
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').show();
      }
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').children().eq(0).remove();
      break;
    }
    case 'cenNav':{
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup.splice(num,1);//delete
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(num).remove();
      console.log(imgGroup)
      break;
    }
    case 'bottomNav':{
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup.splice(num,1);//delete
      $('#layout_bottomnav').children().eq(num).remove();
      console.log(imgGroup)
      break;
    }
    case 'sf_radio':{
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      var type =  LMData.prototype.findJson(layoutModalSelect,dataId,'type');
      imgGroup.splice(num,1);//delete

      $( "#slider-range" ).slider({
        max: imgGroup.length,
      });
      $( "#amount" ).val("最少选择："+ $("#slider-range").slider("values",0) +"   "+"最多选择：" + $("#slider-range").slider("values",1));

      if(num==0){//改第一个默认图标
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.sf-right').children().eq(num+1).find('.sf_icon').children().attr('src','images/sf-'+type+'.png');
      }
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.sf-right').children().eq(num).remove();
      console.log(imgGroup)
      
      break;
    }
  }
  
  $(ev).parents('li').remove();
}

function SaveLMData(idx,modal){
  var ftnLoad = new LMData(idx,modal);
  switch(modal){
    case 'dianzhao':{
      // layoutModalSelect
      var nameVal = $.trim($('.edit-box [data-editid="dianzhao_name"]').val());//删除空格符
      ftnLoad.saveJson(layoutModalSelect,idx,'name',nameVal);
      console.log(layoutModalSelect)
      break;
    }
    case 'lunbotu':{
      var nameVal = $.trim($('.edit-box [data-editid="lunbotu_height"]').val());//删除空格符
      ftnLoad.saveJson(layoutModalSelect,idx,'height',nameVal);
      console.log(layoutModalSelect)
      break;
    }
    case 'mofang':{
      var nameVal = $.trim($('.edit-box [data-editid="lunbotu_height"]').val());//删除空格符
      ftnLoad.saveJson(layoutModalSelect,idx,'height',nameVal);
      var pic_Space = $.trim($('.edit-box [data-editid="pic_space"]').val());//删除空格符
      ftnLoad.saveJson(layoutModalSelect,idx,'picSpace',pic_Space);
      var box_Padding = $.trim($('.edit-box [data-editid="pic_padding"]').val());//删除空格符
      ftnLoad.saveJson(layoutModalSelect,idx,'boxPadding',box_Padding);
      console.log(layoutModalSelect)
      break;
    }
    case 'laytitle':{
      var titName = $.trim($('.edit-box [data-editid=laytitle_name]').val());
      var titColor = $.trim($('.edit-box .titlecolor').attr('data-newcol'));
      var bgColor = $.trim($('.edit-box .color_bg').attr('data-newcol'));
      var linkName = $.trim($('.edit-box .linkname').val());
      var linkColor = $.trim($('.edit-box .linkcolor').attr('data-newcol'));

      ftnLoad.saveJson(layoutModalSelect,idx,'titName',titName);
      ftnLoad.saveJson(layoutModalSelect,idx,'titColor',titColor);
      ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      ftnLoad.saveJson(layoutModalSelect,idx,'linkName',linkName);
      ftnLoad.saveJson(layoutModalSelect,idx,'linkColor',linkColor);
      break;
    }
    case 'placeholder':{
      // var nameVal = $.trim($('.edit-box [data-editid="lay_placeholder"]').val());//删除空格符
      var height = $.trim($('.edit-box .input-height').val());
      var bgColor = $('.edit-box .color_bg').attr('data-newcol');
      ftnLoad.saveJson(layoutModalSelect,idx,'height',height);
      ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      break;
    }
    case 'video':{
      // var titColor = $.trim($('.edit-box .titlecolor').attr('data-newcol'));
      // var bgColor = $.trim($('.edit-box .color_bg').attr('data-newcol'));
      // ftnLoad.saveJson(layoutModalSelect,idx,'titColor',titColor);
      // ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      break;
    }
    case 'notice':{
      var titColor = $.trim($('.edit-box .titlecolor').attr('data-newcol'));
      var bgColor = $.trim($('.edit-box .color_bg').attr('data-newcol'));
      ftnLoad.saveJson(layoutModalSelect,idx,'titColor',titColor);
      ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      break;
    }
    case 'search':{
      var bgColor = $.trim($('.edit-box .color_bg').attr('data-newcol'));
      ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      break;
    }
    case 'laymap':{
      var titName = $.trim($('.edit-box [data-editid=laymap_name]').val());
      var titColor = $.trim($('.edit-box .titlecolor').attr('data-newcol'));
      var bgColor = $.trim($('.edit-box .color_bg').attr('data-newcol'));

      ftnLoad.saveJson(layoutModalSelect,idx,'titName',titName);
      ftnLoad.saveJson(layoutModalSelect,idx,'titColor',titColor);
      ftnLoad.saveJson(layoutModalSelect,idx,'bgColor',bgColor);
      break;
    }
    case 'sf_name':{
      var name = $.trim($('.edit-box input[data-editid=sfName_title]').val());
      var placeholder = $.trim($('.edit-box input[data-editid=sf_placeholder]').val());
      var img = $('.edit-box .layout_img-box img').attr('src');

      ftnLoad.saveJson(layoutModalSelect,idx,'name',name);
      ftnLoad.saveJson(layoutModalSelect,idx,'placeholder',placeholder);
      ftnLoad.saveJson(layoutModalSelect,idx,'img',img);
      break;
    }
    case 'sf_sex':{
      var name = $.trim($('.edit-box input[data-editid=sfName_title]').val());

      ftnLoad.saveJson(layoutModalSelect,idx,'name',name);
      break;
    }
    case 'sf_input':{
      var name = $.trim($('.edit-box input[data-editid=sfName_title]').val());
      var placeholder = $.trim($('.edit-box input[data-editid=sf_placeholder]').val());
      var img = $('.edit-box .layout_img-box img').attr('src');
      // var min = $.trim($('.edit-box input[data-editid=sf-min_input]').val());
      // var max = $.trim($('.edit-box input[data-editid=sf-max_input]').val());

      ftnLoad.saveJson(layoutModalSelect,idx,'name',name);
      ftnLoad.saveJson(layoutModalSelect,idx,'placeholder',placeholder);
      ftnLoad.saveJson(layoutModalSelect,idx,'img',img);
      // ftnLoad.saveJson(layoutModalSelect,idx,'min_input',min);
      // ftnLoad.saveJson(layoutModalSelect,idx,'max_input',max);
      break;
    }
    case 'sf_file':case 'sf_radio':case 'sf_select':{
      var name = $.trim($('.edit-box input[data-editid=sfName_title]').val());

      ftnLoad.saveJson(layoutModalSelect,idx,'name',name);
      break;
    }
    case 'sf_date':{
      var name = $.trim($('.edit-box input[data-editid=sfName_title]').val());
      var placeholder = $.trim($('.edit-box input[data-editid=sf_placeholder]').val());
      var img = $('.edit-box .layout_img-box img').attr('src');

      ftnLoad.saveJson(layoutModalSelect,idx,'name',name);
      ftnLoad.saveJson(layoutModalSelect,idx,'placeholder',placeholder);
      ftnLoad.saveJson(layoutModalSelect,idx,'img',img);
      break;
    }
  }
}

function LoadLMData(idx,modal){
  var ftnLoad = new LMData(idx,modal);
  var dataId = idx;
  switch(modal){
    case 'lunbotu':{

      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var height = ftnLoad.findJson(layoutModalSelect,dataId,'height');
      
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      $('.edit-box [data-editid="lunbotu_height"]').val(height);

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').html('');
      $('.edit-box .lay_lbt-modal ul').html('');
      $.each(imgGroup,function(i,item){
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').append('<span></span>');
        
        var listUrlCon = item.img.split("/images/")[0];
        var nowImg = item.img.split("/images/")[1]=='dz_bg.png'?listUrlCon+'/images/default_add.png':item.img;
        var showImg = item.img.split("/images/")[1]=='dz_bg.png'?'':item.img;
        var linkMSG = item.hasOwnProperty("linkId")?'data-linkid="'+item.linkId+'"data-type="'+item.linkType+'"data-link="'+item.link+'"value="'+item.linkName+'"':'data-type="'+item.linkType+'" data-link="'+item.link+'" value="'+item.linkName+'"';
        $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group"><input type="text"class="control-input form-control lay_imgsrc"name="magic_img0"readonly value="'+showImg+'"><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">选择图片</button></div><input type="file"name=""class="inputfile"></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly '+linkMSG+'><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
      });
      if($('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').children().length<2){
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').hide();
      }else{
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').show();
      }
      ftnLoad.imgManage('#layout_show');
      ftnLoad.layLbtAdd(dataId);
      ftnLoad.layLbtRadio(dataId);
      
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').attr('data-stylediy',styleDiySel);

      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          // var order = layImgEditmodal.toArray();
          // layoutShow.sort(order.slice());
          var Oarr=new Array();
          $('.edit-box .lay_lbt-modal ul>li').each(function(){
            var obj={};
            obj['img'] = $(this).find('input.lay_imgsrc').val()==''?'images/dz_bg.png':$(this).find('img.lay_imgsrc').attr('src');
            obj['link'] = $(this).find('.lay_imglink').attr('data-link');
            obj['linkName'] = $(this).find('.lay_imglink').val();
            obj['linkType'] = $(this).find('.lay_imglink').attr('data-type');
            if($(this).find('.lay_imglink').attr('data-linkid')!=''){
              obj['linkId'] = $(this).find('.lay_imglink').attr('data-linkid');
            }
            Oarr.push(obj);
          });
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
          console.log(evt.oldIndex=='0'||evt.newIndex=='0')
          if(evt.oldIndex=='0'||evt.newIndex=='0'){
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('img').attr('src',Oarr[0].img);
            ftnLoad.imgManage('#layout_show');
          }
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
        
      });
      break;
    }
    case 'mofang':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var picSpace = ftnLoad.findJson(layoutModalSelect,dataId,'picSpace');
      var boxPadding = ftnLoad.findJson(layoutModalSelect,dataId,'boxPadding');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box [data-editid="lunbotu_height"]').val(ftnLoad.findJson(layoutModalSelect,idx,'height'));
      $('.edit-box [data-editid="pic_space"]').val(picSpace);
      $('.edit-box [data-editid="pic_padding"]').val(boxPadding);

      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_mofang').css('padding',boxPadding+'px');

      $('.edit-box .lay_lbt-modal ul').html('');
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_mofang').attr('data-stylediy',styleDiySel).html('');
      $.each(ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup'),function(i,item){
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_mofang').append('<div class="clum"><div class="imgbox middle_center"data-editid="lunbotu_height"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div></div>');
        
        var listUrlCon = item.img.split("/images/")[0];
        var nowImg = item.img.split("/images/")[1]=='dz_bg.png'?listUrlCon+'/images/default_add.png':item.img;
        var showImg = item.img.split("/images/")[1]=='dz_bg.png'?'':item.img;
        var linkMSG = item.hasOwnProperty("linkId")?'data-linkid="'+item.linkId+'"data-type="'+item.linkType+'"data-link="'+item.link+'"value="'+item.linkName+'"':'data-type="'+item.linkType+'" data-link="'+item.link+'" value="'+item.linkName+'"';
        $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group"><input type="text"class="control-input form-control lay_imgsrc"name="magic_img0"readonly value="'+showImg+'"><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">选择图片</button></div><input type="file"name=""class="inputfile"></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly '+linkMSG+'><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div></li>');
      });
      $('.edit-box .magic-radio input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      
      layMfPicSpace(dataId,styleDiySel,picSpace);
      ftnLoad.imgManage('#layout_show');
      ftnLoad.layMfRadio(dataId);

      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
          var picSpace = ftnLoad.findJson(layoutModalSelect,dataId,'picSpace');
          var Oarr=new Array();
          $('.edit-box .lay_lbt-modal ul>li').each(function(){
            var obj={};
            obj['img'] = $(this).find('input.lay_imgsrc').val()==''?'images/dz_bg.png':$(this).find('img.lay_imgsrc').attr('src');
            obj['link'] = $(this).find('.lay_imglink').attr('data-link');
            obj['linkName'] = $(this).find('.lay_imglink').val();
            obj['linkType'] = $(this).find('.lay_imglink').attr('data-type');
            if($(this).find('.lay_imglink').attr('data-linkid')!=''){
              obj['linkId'] = $(this).find('.lay_imglink').attr('data-linkid');
            }
            Oarr.push(obj);
          });
          console.log(Oarr)
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_mofang').attr('data-stylediy',styleDiySel).html('');
          $.each(Oarr,function(i,item){
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_mofang').append('<div class="clum"><div class="imgbox middle_center"data-editid="lunbotu_height"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div></div>');
          });
          layMfPicSpace(dataId,styleDiySel,picSpace);
          ftnLoad.imgManage('#layout_show');
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
      });
      break;
    }
    case 'cenNav':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var selectNum = ftnLoad.findJson(layoutModalSelect,dataId,'selectNum');
      var perPage = ftnLoad.findJson(layoutModalSelect,dataId,'perpage');
      var maxPerPage = ftnLoad.findJson(layoutModalSelect,dataId,'maxperpage');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      
      $('.edit-box [data-editid=cennav_navstyle] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=cennav_navnum] input[value='+selectNum+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=cennav_navshow] input[value='+perPage+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      if(parseInt(perPage)){
        $('.edit-box [data-editid=cennav_navshow] input[value='+perPage+']').parents('.edit-con').find('.cennav_navslider').show();
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').show();;
      }else{
        $('.edit-box [data-editid=cennav_navshow] input[value='+perPage+']').parents('.edit-con').find('.cennav_navslider').hide();
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').hide();
      }

      $('.edit-box .lay_lbt-modal ul').html('');
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').attr('data-stylediy',styleDiySel).attr('data-selectnum',selectNum).html('');
      $.each(ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup'),function(i,item){

        var listUrlCon = item.img.split("/images/")[0];
        var nowImg = item.img.split("/images/")[1]=='dz_bg.png'?listUrlCon+'/images/default_add.png':item.img;
        var nowColor = item.newCol==''?item.original:item.newCol;
        var linkMSG = item.hasOwnProperty("linkId")?'data-linkid="'+item.linkId+'"data-type="'+item.linkType+'"data-link="'+item.link+'"value="'+item.linkName+'"':'data-type="'+item.linkType+'" data-link="'+item.link+'" value="'+item.linkName+'"';
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').append('<div class="clum"><div class="imgbox middle_center"data-editid="cennav_img"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><h3 class="name"data-editid="cennav_linkname" style="color:'+nowColor+'" >'+item.name+'</h3></div>');
        $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"value="'+item.name+'"data-editid="cennav_linkname"onkeyup="inputChange(this,&quot;textName&quot;)"><div class="color-box" data-original="'+item.original+'"data-newcol="'+nowColor+'"style="background-color:'+nowColor+'"></div><div class="input-group-btn reset-btn"><button type="button"class="btn btn-default"onclick="inputColorReset(this)">重置</button></div></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly '+linkMSG+'><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
        // $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"value="'+item.name+'"data-editid="cennav_linkname"onkeyup="inputChange(this,&quot;textName&quot;)"><input type="color"class="control-input form-control color-input"name="navname"data-original="'+item.original+'"value="'+nowColor+'"onchange="inputChange(this,&quot;textColor&quot;)"><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="inputColorReset(this)">重置</button></div></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly value="'+item.link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
      });


      ftnLoad.colorBox(dataId);
      ftnLoad.layCenNavRadio(dataId);
      ftnLoad.layCenNavAdd(dataId);
      ftnLoad.imgManage('#layout_show');

      $("#cennav_navslider").slider({
        value: maxPerPage,
        min: 3,
        max: 20,
        change: function( event, ui ) {
          console.log(ui.value) 
          LMData.prototype.saveJson(layoutModalSelect,dataId,'maxperpage',ui.value)
        },
        create: function() {
          $("#custom-handle").text( $( this ).slider( "value" ) + '个' );
        },
        slide: function( event, ui ) {
          $("#custom-handle").text( ui.value + '个' );
        }
      });
      // $("#cennav_navslider").slider('value',maxPerPage);

      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
          var picSpace = ftnLoad.findJson(layoutModalSelect,dataId,'picSpace');
          var Oarr=new Array();
          $('.edit-box .lay_lbt-modal ul>li').each(function(){
            var obj={};
            obj['name'] = $(this).find('.text-input').val();
            obj['original'] = $(this).find('.color-box').data('original');
            obj['newCol'] = $(this).find('.color-box').attr('data-newcol')==obj['original']?'':$(this).find('.color-box').attr('data-newcol');
            obj['img'] = $(this).find('.lay_imgsrc').attr('src').split("/images/")[1]=='default_add.png'?$(this).find('.lay_imgsrc').attr('src').split("/images/")[0]+'/images/dz_bg.png':$(this).find('.lay_imgsrc').attr('src');
            obj['link'] = $(this).find('.lay_imglink').attr('data-link');
            obj['linkName'] = $(this).find('.lay_imglink').val();
            obj['linkType'] = $(this).find('.lay_imglink').attr('data-type');
            Oarr.push(obj);
          });
          console.log(Oarr)
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').attr('data-stylediy',styleDiySel).html('');
          $.each(Oarr,function(i,item){
            var nowColor = item.newCol==''?item.original:item.newCol;
            var nowImg = item.img.split("/images/")[1]=='default_add.png'?item.img.split("/images/")[0]+'/images/dz_bg.png':item.img;
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').append('<div class="clum"><div class="imgbox middle_center"data-editid="cennav_img"><img src="'+nowImg+'"ondragstart="return false"alt=""title=""></div><h3 class="name"data-editid="cennav_linkname" style="color:'+nowColor+'" >'+item.name+'</h3></div>');
          });
          ftnLoad.imgManage('#layout_show');
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
      });

      break;
    }
    case 'video':{
      // var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var videoStyle = ftnLoad.findJson(layoutModalSelect,dataId,'videoStyle');
      var videoImg = ftnLoad.findJson(layoutModalSelect,dataId,'videoImg');
      var videolink = ftnLoad.findJson(layoutModalSelect,dataId,'videolink');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box [data-editid=video_source] input[value='+videoStyle+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box .lay_imgsrc').attr('src',videoImg);
      $('.edit-box .lay_imglink').val(videolink);

      if(videoStyle=='chooseVideo'){
        //1:选择视频
        $('.edit-box .video_source-box[data-editid=chooseVideo]').show();
        $('.edit-box .video_source-box[data-editid=videoAddress]').hide();

      }else if(videoStyle=='videoAddress'){
        //0:视频地址
        $('.edit-box .video_source-box[data-editid=chooseVideo]').hide();
        $('.edit-box .video_source-box[data-editid=videoAddress]').show();
      }

      ftnLoad.layCenNavRadio(dataId);
      ftnLoad.imgManage('#layout_show');


      break;
    }
    case 'laytitle':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var titName = ftnLoad.findJson(layoutModalSelect,dataId,'titName');
      var titColor = ftnLoad.findJson(layoutModalSelect,dataId,'titColor');
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var link = ftnLoad.findJson(layoutModalSelect,dataId,'link');
      var linkName = ftnLoad.findJson(layoutModalSelect,dataId,'linkName');
      var linkMinName = ftnLoad.findJson(layoutModalSelect,dataId,'linkMinName');
      var linkType = ftnLoad.findJson(layoutModalSelect,dataId,'linkType');
      var linkColor = ftnLoad.findJson(layoutModalSelect,dataId,'linkColor');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .lay_lbt input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="laytitle"]').attr('data-stylediy',styleDiySel).css('background-color',bgColor); 
      $('.edit-box [data-editid=laytitle_name]').val(titName);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="laytitle_name"]').text(titName).css('color',titColor); 
      $('.edit-box .titlecolor').css('background-color',titColor).attr('data-original',titColor).attr('data-newcol',titColor);
      $('.edit-box .color_bg').css('background-color',bgColor).attr('data-original',bgColor).attr('data-newcol',bgColor); 
      $('.edit-box .lay_imglink').val(linkMinName).attr('data-type',linkType).attr('data-link',link); 
      $('.edit-box .linkcolor').css('background-color',linkColor).attr('data-original',linkColor).attr('data-newcol',linkColor); 
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="laytitle_link"]').text(linkName).css('color',linkColor).siblings('i').css('color',linkColor); 

      ftnLoad.colorBox(dataId,modal);
      ftnLoad.layLbtRadio(dataId);

      break;
    }
    case 'placeholder':{
      var height = ftnLoad.findJson(layoutModalSelect,dataId,'height');
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var opacity = ftnLoad.findJson(layoutModalSelect,dataId,'opacity');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .input-height').val(height); 
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_placeholder').css('opacity',opacity/100);
      $('.edit-box .color_bg').css('background-color',bgColor).attr('data-original',bgColor).attr('data-newcol',bgColor);  
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_placeholder').css('background-color',bgColor);

      $("#placeholder_transparency").slider({
        value: opacity,
        min: 0,
        max: 100,
        change: function( event, ui ) {
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_placeholder').css('opacity',ui.value/100);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'opacity',ui.value);
        },
        create: function() {
          $("#placeholder-handle").text( $( this ).slider( "value" ) );
        },
        slide: function( event, ui ) {
          $("#placeholder-handle").text( ui.value);
        }
      });
      ftnLoad.colorBox(dataId,modal);

      break;
    }
    case 'bottomNav':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var original = ftnLoad.findJson(layoutModalSelect,dataId,'original');
      var newCol = ftnLoad.findJson(layoutModalSelect,dataId,'newCol');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box .bottomcolor_bg').attr('data-original',bgColor).attr('data-newcol',bgColor).css('background-color',bgColor);
      $('.edit-box .bottomcolor_original').attr('data-original',original).attr('data-newcol',original).css('background-color',original);
      $('.edit-box .bottomcolor_sel').attr('data-original',newCol).attr('data-newcol',newCol).css('background-color',newCol);
      $('.edit-box [data-editid=bottomnav_navshow] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      $('#layout_bottomnav').html('');
      $('.edit-box .lay_lbt-modal ul').html('');
      $.each(ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup'),function(i,item){
        var nowImg = item.img=='images/default_img.png'?'images/default_add.png':item.img;
        var nowImgSel = item.img_sel=='images/default_img.png'?'images/default_add.png':item.img_sel;
        $('#layout_bottomnav').append('<li data-editid="botnav_li"><span class="icon"><img class="imgauto" src="'+item.img+'" ondragstart="return false" alt="" title=""><img class="imgsel" src="'+item.img_sel+'" ondragstart="return false" alt="" title=""></span><span class="name" data-editid="botnav_linkname" style="color:'+original+'">'+item.name+'</span></li>');
        $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg lay_bottomimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-sel"src="'+nowImgSel+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"value="'+item.name+'"data-editid="botnav_linkname"onkeyup="inputChange(this,&quot;bottomName&quot;)"></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+item.link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
      });
      ftnLoad.colorBox(dataId,modal);
      ftnLoad.layBottomNavAdd(dataId);
      ftnLoad.layBottomActive(dataId);
      ftnLoad.layLbtRadio(dataId);

      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          var Oarr=new Array();
          $('.edit-box .lay_lbt-modal ul>li').each(function(){
            var obj={};
            obj['name'] = $(this).find('.text-input').val();
            obj['img'] = $(this).find('.lay_imgsrc-auto').attr('src')=='images/default_add.png'?'images/default_img.png':$(this).find('.lay_imgsrc-auto').attr('src');
            obj['img_sel'] = $(this).find('.lay_imgsrc-sel').attr('src')=='images/default_add.png'?'images/default_img.png':$(this).find('.lay_imgsrc-sel').attr('src');
            obj['link'] = $(this).find('.lay_imglink').val();
            Oarr.push(obj);
          });
          console.log(Oarr)
          $('#layout_bottomnav').html('');
          var original = LMData.prototype.findJson(layoutModalSelect,dataId,'original')
          $.each(Oarr,function(i,item){
            var nowImg = item.img=='images/default_add.png'?'images/default_img.png':item.img;
            var nowImgSel = item.img_sel=='images/default_add.png'?'images/default_img.png':item.img_sel;
            $('#layout_bottomnav').append('<li data-editid="botnav_li"><span class="icon"><img class="imgauto" src="'+nowImg+'" ondragstart="return false" alt="" title=""><img class="imgsel" src="'+nowImgSel+'" ondragstart="return false" alt="" title=""></span><span class="name" data-editid="botnav_linkname" style="color:'+original+'">'+item.name+'</span></li>');
          });
          ftnLoad.layBottomActive(dataId);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
      });

      break;
    }
    // case 'music':{
    //   var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
    //   var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
    //   $('.edit-box .title_box .title h5').text(title+'设置');
      
    //   $('.edit-box [data-editid=music_show] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

    //   $('.music ul').html('');
    //   $('.edit-box .lay_lbt-modal ul').html('');
    //   var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
    //   console.log(imgGroup[0].img)
    //   $('.music ul').append('<li class="imgbox"><img src="'+imgGroup[0].img+'" ondragstart="return false" alt="" title=""></li>');
    //   $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_onlyimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="'+imgGroup[0].img+'"ondragstart="return false"alt=""title=""></div><div class="input-box"><div class="input-group input-text-color"><input type="text"class="control-input form-control text-input"name="navname"value="'+imgGroup[0].img+'"data-editid="botnav_linkname"readonly onkeyup="inputChange(this,&quot;bottomName&quot;)"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="图标库"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">图标库</button></div><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="本地上传"onclick="inputFileNav(this)">本地上传</button></div></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"readonly=""name="magic_img"value="'+imgGroup[0].link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
    //   ftnLoad.layLbtRadio(dataId);

    //   break;
    // }
    // case 'suspension':{
    //   var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
    //   var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
    //   $('.edit-box .title_box .title h5').text(title+'设置');
      
    //   $('.edit-box [data-editid=suspension_show] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

    //   $('.suspension ul').html('');
    //   $('.edit-box .lay_lbt-modal ul').html('');
    //   $.each(ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup'),function(i,item){
    //     var newImg = item.img=='images/default_img.png'?'images/default_add.png':item.img;
    //     var newImgInput = item.img=='images/default_img.png'?'':item.img;
    //     $('.suspension ul').append('<li class="imgbox"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></li>');
    //     $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_onlyimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="'+newImg+'"ondragstart="return false"alt=""title=""></div><div class="input-box"><div class="input-group input-text-color"><input type="text"class="control-input form-control text-input"name="navname"value="'+newImgInput+'"data-editid="botnav_linkname"readonly onkeyup="inputChange(this,&quot;bottomName&quot;)"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="图标库"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">图标库</button></div><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="本地上传"onclick="inputFileNav(this)">本地上传</button></div></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+item.link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
    //   });
    //   ftnLoad.layLbtRadio(dataId);
    //   ftnLoad.laySusAdd(dataId);

    //   var layImgEditmodal = Sortable.create(lay_img_editmodal,{
    //     group:{ 
    //       pull: false,
    //       put: false
    //     },
    //     chosenClass: "sortable-chosen",
    //     onUpdate: function (evt) {
    //       console.log("排序触发")
    //       var Oarr=new Array();
    //       $('.edit-box .lay_lbt-modal ul>li').each(function(){
    //         var obj={};
    //         obj['img'] = $(this).find('.lay_imgsrc').attr('src')=='images/default_add.png'?'images/default_img.png':$(this).find('.lay_imgsrc').attr('src');
    //         obj['link'] = $(this).find('.lay_imglink').val();
    //         Oarr.push(obj);
    //       });
    //       console.log(Oarr)
    //       $('.suspension ul').html('');
    //       var original = LMData.prototype.findJson(layoutModalSelect,dataId,'original')
    //       $.each(Oarr,function(i,item){
    //         $('.suspension ul').append('<li class="imgbox"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></li>');
    //       });
    //       LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
    //       console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
    //     },
    //   });

    //   break;
    // }
    case 'customGoods':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var elementSel = ftnLoad.findJson(layoutModalSelect,dataId,'elementSel');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var perPage = ftnLoad.findJson(layoutModalSelect,dataId,'perpage');
      var sorttype = ftnLoad.findJson(layoutModalSelect,dataId,'sorttype');
      var maxPerPage = ftnLoad.findJson(layoutModalSelect,dataId,'maxperpage');
      var classifyId = ftnLoad.findJson(layoutModalSelect,dataId,'classifyId');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box [data-editid=customgoods_classify] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=customGoods_show] input[value='+perPage+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=customGoods_sortorder] input[value='+sorttype+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').attr('data-stylediy',styleDiySel).html('');

      $.each(elementSel,function(i,item){
        if(item){
          $(".edit-box .lay_checkbox .selct-checkbox[value="+i+"]").attr('checked',item).parent().addClass("selected");
        }else{
          $(".edit-box .lay_checkbox .selct-checkbox[value="+i+"]").attr('checked',item).parent().removeClass("selected");
        }
      });
      
      if(parseInt(perPage)){
        //1:选择分类
        $('.edit-box .cennav_navslider').show();
        $('.edit-box .customGoods_selclassify').show();
        $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').show();
        $('.edit-box .lay_cg-modal').hide();
        $('.edit-box .lay_img-add').hide();
        // <div class="tab" data-editid="tab" data-state="'+elementSel.tab+'"><span>限时购买</span><span>满100减50</span></div>
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('<div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div>');

      }else{
        //0:手动选择
        $('.edit-box .cennav_navslider').hide();
        $('.edit-box .customGoods_selclassify').hide();
        $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').hide();
        $('.edit-box .lay_cg-modal').show();
        $('.edit-box .lay_img-add').show();

        $('.edit-box .lay_cg-modal ul').html('');
        $.each(imgGroup,function(i,item){
          // var tabHtml = '';
          // $.each(item.tab,function(idx,items){
          //   tabHtml += '<span>'+items+'</span>'
          // });<div class="tab"data-editid="tab"data-state="'+elementSel.tab+'">'+tabHtml+'</div>
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').append('<div class="clum"><div class="imgbox"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><div class="msg"><span class="name"data-editid="name"data-state="'+elementSel.name+'">'+item.name+'</span><div class="msg-bottom"><div class="price-box"><span class="price"data-editid="price"data-state="'+elementSel.price+'">'+item.price+'</span><span class="price-ex"data-editid="priceEx"data-state="'+elementSel.priceEx+'">'+item.priceEx+'</span></div><div class="vip"data-editid="priceVip"data-state="'+elementSel.priceVip+'"><span>会员价</span><span>'+item.priceVip+'</span></div></div></div></div>');
          $('.edit-box .lay_cg-modal ul').append('<li class="lay_cg-box"><div class="imgbox"data-serviceid="'+item.id+'"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><a href="javascript:void(0);"class="lay_img-del"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
        });
        productSel = imgGroup;
      }
      /*生成选择分类select */
      selectOption('.customGoods_selclassify .control-chosen');
      
      $(".edit-box[data-id="+dataId+"] .customGoods_selclassify .control-chosen").children('[data-classifyid="'+classifyId+'"]').attr("selected", true);

      //多选
      $('.customGoods_selclassify .control-chosen').chosen({
        allow_single_deselect: true,
        width: '100%',
      });
      
      // $(".edit-box[data-id="+dataId+"] .control-chosen").on("change",function(){
      //   var classifyId = $(this).children('option:selected').data('classifyid');
        
      //   LMData.prototype.saveJson(layoutModalSelect,dataId,'classifyId',classifyId);
      //   console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'classifyId'))
      // });
      
      ftnLoad.layCenNavRadio(dataId);
      ftnLoad.layCGSelect(dataId);
      ftnLoad.layCGAdd(dataId);
      ftnLoad.imgManage('#layout_show');
      
      //滑动条
      $("#cennav_navslider").slider({
        value: maxPerPage,
        min: 2,
        max: 20,
        change: function( event, ui ) {
          console.log(ui.value)
          LMData.prototype.saveJson(layoutModalSelect,dataId,'maxperpage',ui.value)
        },
        create: function() {
          $("#custom-handle").text( $( this ).slider( "value" ) + '个' );
        },
        slide: function( event, ui ) {
          $("#custom-handle").text( ui.value + '个' );
        }
      });

      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          var styleDiySel = LMData.prototype.findJson(layoutModalSelect,dataId,'stylediy');
          var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          var Oarr=new Array();
          $('.edit-box .lay_cg-modal ul>li').each(function(){
            var id = $(this).find('.imgbox').data('serviceid');
            Oarr.push(id);
          });
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('');
          /*重新排序 */
          var obj=[];
          $.each(Oarr,function(i,item){
            $.each(imgGroup,function(idx,items){
              if(item==items.id){
                obj.push(items);
              }
            });
          });
          $.each(obj,function(i,item){
            // var tabHtml = '';
            // $.each(item.tab,function(idx,items){
            //   tabHtml += '<span>'+items+'</span>'
            // });
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').append('<div class="clum"><div class="imgbox"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><div class="msg"><span class="name"data-editid="name"data-state="'+elementSel.name+'">'+item.name+'</span><div class="msg-bottom"><div class="price-box"><span class="price"data-editid="price"data-state="'+elementSel.price+'">'+item.price+'</span><span class="price-ex"data-editid="priceEx"data-state="'+elementSel.priceEx+'">'+item.priceEx+'</span></div><div class="vip"data-editid="priceVip"data-state="'+elementSel.priceVip+'"><span>会员价</span><span>'+item.priceVip+'</span></div></div></div></div>');
          });
          ftnLoad.imgManage('#layout_show');
          productSel = obj;
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',obj);
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
      });

      break;
    }
    case 'consulting':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var elementSel = ftnLoad.findJson(layoutModalSelect,dataId,'elementSel');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var perPage = ftnLoad.findJson(layoutModalSelect,dataId,'perpage');
      var maxPerPage = ftnLoad.findJson(layoutModalSelect,dataId,'maxperpage');
      var classifyId = ftnLoad.findJson(layoutModalSelect,dataId,'classifyId');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box [data-editid=customgoods_classify] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=consulting_show] input[value='+perPage+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=customGoods_sortorder] input[value='+sorttype+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').attr('data-stylediy',styleDiySel);
      
        //0:手动选择
      // $('.edit-box .cennav_navslider').hide();
      // $('.edit-box .customGoods_selclassify').hide();
      // $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').hide();
      // $('.edit-box .lay_cg-modal').show();
      // $('.edit-box .lay_img-add').show();
      
      $.each(elementSel,function(i,item){
        if(item){
          $(".edit-box .lay_checkbox .selct-checkbox[value="+i+"]").attr('checked',item).parent().addClass("selected");
        }else{
          $(".edit-box .lay_checkbox .selct-checkbox[value="+i+"]").attr('checked',item).parent().removeClass("selected");
        }
      });

      if(parseInt(perPage)){
        //1:选择分类
        $('.edit-box .cennav_navslider').show();
        $('.edit-box .customGoods_selclassify').show();
        $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').show();
        $('.edit-box .lay_cg-modal').hide();
        $('.edit-box .lay_img-add').hide();
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').html('<div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div><div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div><div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div>');

      }else{
        //0:手动选择
        $('.edit-box .cennav_navslider').hide();
        $('.edit-box .customGoods_selclassify').hide();
        $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').hide();
        $('.edit-box .lay_cg-modal').show();
        $('.edit-box .lay_img-add').show();

        $('.edit-box .lay_cg-modal ul').html('');
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').html('');
        $.each(imgGroup,function(i,item){
          // var tabHtml = '';
          // $.each(item.tab,function(idx,items){
          //   tabHtml += '<span>'+items+'</span>'
          // });
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').append('<div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">'+item.name+'</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>'+item.time+'</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>'+item.reading+'</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="'+item.img+'"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div>');
          $('.edit-box .lay_cg-modal ul').append('<li class="lay_cg-box"><div class="imgbox"data-serviceid="'+item.id+'"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><a href="javascript:void(0);"class="lay_img-del"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
        });
        productSel = imgGroup;
      }

      /*生成选择分类select */
      selectOption('.customGoods_selclassify .control-chosen');

      $(".edit-box[data-id="+dataId+"] .customGoods_selclassify .control-chosen").children('[data-classifyid="'+classifyId+'"]').attr("selected", true);
      
      //多选
      $('.customGoods_selclassify .control-chosen').chosen({
        allow_single_deselect: true,
        width: '100%',
      });

      ftnLoad.layCenNavRadio(dataId);
      ftnLoad.layCGSelect(dataId);
      ftnLoad.layCGAdd(dataId);
      ftnLoad.imgManage('#layout_show');

      //滑动条
      $("#cennav_navslider").slider({
        value: maxPerPage,
        min: 2,
        max: 20,
        change: function( event, ui ) {
          console.log(ui.value)
          LMData.prototype.saveJson(layoutModalSelect,dataId,'maxperpage',ui.value)
        },
        create: function() {
          $("#custom-handle").text( $( this ).slider( "value" ) + '个' );
        },
        slide: function( event, ui ) {
          $("#custom-handle").text( ui.value + '个' );
        }
      });
      
      var layImgEditmodal = Sortable.create(lay_img_editmodal,{
        group:{ 
          pull: false,
          put: false
        },
        chosenClass: "sortable-chosen",
        onUpdate: function (evt) {
          console.log("排序触发")
          var styleDiySel = LMData.prototype.findJson(layoutModalSelect,dataId,'stylediy');
          var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          var Oarr=new Array();
          $('.edit-box .lay_cg-modal ul>li').each(function(){
            var id = $(this).find('.imgbox').data('serviceid');
            Oarr.push(id);
          });
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').html('');
          /*重新排序 */
          var obj=[];
          $.each(Oarr,function(i,item){
            $.each(imgGroup,function(idx,items){
              if(item==items.id){
                obj.push(items);
              }
            });
          });
          $.each(obj,function(i,item){
            // var tabHtml = '';
            // $.each(item.tab,function(idx,items){
            //   tabHtml += '<span>'+items+'</span>'
            // });
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').append('<div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">'+item.name+'</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="glyphicon glyphicon-time"></i>'+item.time+'</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="glyphicon glyphicon-eye-open"></i>'+item.reading+'</span><span class="like"data-editid="like"data-state="'+elementSel.like+'"><i class="glyphicon glyphicon-heart-empty"></i>'+item.like+'</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="'+item.img+'"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div>');
          });
          ftnLoad.imgManage('#layout_show');
          productSel = obj;
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',obj);
          console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
        },
      });

      break;
    }
    case 'coupons':{
      var unreceived = ftnLoad.findJson(layoutModalSelect,dataId,'unreceived');
      var received = ftnLoad.findJson(layoutModalSelect,dataId,'received');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .coupons_unreceived').attr('src',unreceived);
      $('.edit-box .coupons_received').attr('src',received);
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.coupons-box .unreceived').css('background-image','url('+unreceived+')');
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.coupons-box .received').css('background-image','url('+received+')');
      
      console.log(unreceived)
      // ftnLoad.layCenNavRadio(dataId);
      // ftnLoad.layCGSelect(dataId);
      // ftnLoad.layCGAdd(dataId);
      ftnLoad.imgManage('#layout_show');

      break;
    }
    case 'notice':{
      var titColor = ftnLoad.findJson(layoutModalSelect,dataId,'titColor');
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var ggImg = ftnLoad.findJson(layoutModalSelect,dataId,'img');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box .layout_logo').attr('src',ggImg);
      $('.edit-box .titlecolor').css('background-color',titColor).attr('data-original',titColor).attr('data-newcol',titColor);
      $('.edit-box .color_bg').css('background-color',bgColor).attr('data-original',bgColor).attr('data-newcol',bgColor);

      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var perPage = ftnLoad.findJson(layoutModalSelect,dataId,'perpage');
      var maxPerPage = ftnLoad.findJson(layoutModalSelect,dataId,'maxperpage');
      var classifyId = ftnLoad.findJson(layoutModalSelect,dataId,'classifyId');
      
      // $('.edit-box [data-editid=customgoods_classify] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box [data-editid=notice_radio] input[value='+perPage+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      // $('.edit-box [data-editid=customGoods_sortorder] input[value='+sorttype+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').attr('data-stylediy',styleDiySel).html('');
      
      if(parseInt(perPage)){
        //1:选择分类
        $('.edit-box .cennav_navslider').show();
        $('.edit-box .notice_selclassify').show();
        $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.content').text('这里将读取商城的公告进行滚动显示');
        $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.more').show();
        // $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').show();
        $('.edit-box .lay_cg-modal').hide();
        // $('.edit-box .lay_img-add').hide();
        // <div class="tab" data-editid="tab" data-state="'+elementSel.tab+'"><span>限时购买</span><span>满100减50</span></div>
        // $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('<div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div>');

      }else{
        //0:手动选择
        $('.edit-box .cennav_navslider').hide();
        $('.edit-box .notice_selclassify').hide();
        $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.content').text(imgGroup);
        $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.more').hide();
        // $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').hide();
        $('.edit-box .lay_cg-modal').show();
        // $('.edit-box .lay_img-add').show();

        $('.edit-box .lay_cg-modal .control-textarea').val(imgGroup);
        console.log(imgGroup)

        // $('.edit-box .lay_cg-modal ul').html('');
        // $.each(imgGroup,function(i,item){
        //   $('.edit-box .lay_cg-modal ul').append('<li class="lay_img-box lay_notice-box"><div class="imgbox"></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">标题</span><input type="text"class="control-input form-control linkname"name="titlename"value="'+item.name+'"data-editid="laytitle_link"onkeyup="inputChange(this,&quot;textNameNotice&quot;)"></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+item.link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
        // });
        // productSel = imgGroup;
      }
      /*生成选择分类select */
      selectOption('.notice_selclassify .control-chosen');
      
      $(".edit-box[data-id="+dataId+"] .notice_selclassify .control-chosen").children('[data-classifyid="'+classifyId+'"]').attr("selected", true);

      //多选
      $('.notice_selclassify .control-chosen').chosen({
        allow_single_deselect: true,
        width: '100%',
      });
      
      ftnLoad.colorBox(dataId,modal);
      ftnLoad.layCenNavRadio(dataId);
      ftnLoad.layCGSelect(dataId);
      ftnLoad.layNoticeAdd(dataId);
      
      //滑动条
      $("#cennav_navslider").slider({
        value: maxPerPage,
        min: 2,
        max: 20,
        change: function( event, ui ) {
          console.log(ui.value)
          LMData.prototype.saveJson(layoutModalSelect,dataId,'maxperpage',ui.value)
        },
        create: function() {
          $("#custom-handle").text( $( this ).slider( "value" ) + '个' );
        },
        slide: function( event, ui ) {
          $("#custom-handle").text( ui.value + '个' );
        }
      });

      // var layImgEditmodal = Sortable.create(lay_img_editmodal,{
      //   group:{ 
      //     pull: false,
      //     put: false
      //   },
      //   chosenClass: "sortable-chosen",
      //   onUpdate: function (evt) {
      //     console.log("排序触发")
      //     var Oarr=new Array();
      //     $('.edit-box .lay_cg-modal ul>li').each(function(){
      //       var obj={};
      //       obj['name'] = $(this).find('.linkname').val();
      //       obj['link'] = $(this).find('.lay_imglink').val();
      //       Oarr.push(obj);
      //     });
      //     LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',Oarr);
      //   },
      // });
      break;
    }
    case 'search':{
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box .color_bg').css('background-color',bgColor).attr('data-original',bgColor).attr('data-newcol',bgColor); 
      
      ftnLoad.colorBox(dataId,modal);
      break;
    }
    case 'laymap':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var titName = ftnLoad.findJson(layoutModalSelect,dataId,'titName');
      var titColor = ftnLoad.findJson(layoutModalSelect,dataId,'titColor');
      var bgColor = ftnLoad.findJson(layoutModalSelect,dataId,'bgColor');
      var location = ftnLoad.findJson(layoutModalSelect,dataId,'location');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .lay_lbt input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="lay_map"]').attr('data-stylediy',styleDiySel).css('background-color',bgColor); 
      $('.edit-box [data-editid=laymap_name]').val(titName);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="laymap_name"]').text(titName).css('color',titColor); 
      $('.edit-box .titlecolor').css('background-color',titColor).attr('data-original',titColor).attr('data-newcol',titColor);
      $('.edit-box .color_bg').css('background-color',bgColor).attr('data-original',bgColor).attr('data-newcol',bgColor); 
      $('.edit-box .map_baidu').val(location); 

      if($('.map_baidu').length>0){
        new MapGrid('.map_baidu',{
          type : gouldMap,
          callback : function(lng,lat){
            ftnLoad.saveJson(layoutModalSelect,idx,'location',lng+','+lat);
          }
        });
      }

      ftnLoad.layLbtRadio(dataId);
      ftnLoad.colorBox(dataId,modal);

      break;
    }
    case 'sf_name':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var img = ftnLoad.findJson(layoutModalSelect,dataId,'img');
      var placeholder = ftnLoad.findJson(layoutModalSelect,dataId,'placeholder');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfName_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      switch(styleDiySel){
        case 'trueImg':{
          $('.edit-box .sfedit_img').show();
          break;
        }
        default:{
          $('.edit-box .sfedit_img').hide();
          break;
        }
      }
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_name"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name);
      $('.edit-box .layout_img-box img').attr('src',img);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf_icon').children().attr('src',img);
      $('.edit-box [data-editid=sf_placeholder]').val(placeholder);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf_name-pho').text(placeholder);
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected");
      }

      ftnLoad.sfRadioImg(dataId);
      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'sf_sex':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfName_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_sex"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected");
      }

      ftnLoad.layLbtRadio(dataId);
      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'sf_address':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfName_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_address"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected");
      }

      ftnLoad.sfRadioImg(dataId);
      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'sf_input':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var img = ftnLoad.findJson(layoutModalSelect,dataId,'img');
      var placeholder = ftnLoad.findJson(layoutModalSelect,dataId,'placeholder');
      var minInput = ftnLoad.findJson(layoutModalSelect,dataId,'min_input');
      var maxInput = ftnLoad.findJson(layoutModalSelect,dataId,'max_input');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfName_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      switch(styleDiySel){
        case 'trueImg':{
          $('.edit-box .sfedit_img').show();
          break;
        }
        default:{
          $('.edit-box .sfedit_img').hide();
          break;
        }
      }
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_input"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      $('.edit-box .layout_img-box img').attr('src',img);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf_icon').children().attr('src',img);
      $('.edit-box [data-editid=sf_placeholder]').val(placeholder);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid=sf_placeholder]').text(placeholder);
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected"); 
      }

      ftnLoad.sfRadioImg(dataId);
      ftnLoad.sfRequired(dataId);
      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 500,
        values: [ minInput,maxInput ],
        slide: function( event, ui ) {
          $( "#amount" ).val("最少输入："+ ui.values[ 0 ] + "   "+ "最多输入：" + ui.values[ 1 ]);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'min_input',ui.values[0])
          LMData.prototype.saveJson(layoutModalSelect,dataId,'max_input',ui.values[1])
        },
      });
      $( "#amount" ).val("最少输入："+ $("#slider-range").slider("values",0) +"   "+"最多输入：" + $("#slider-range").slider("values",1));


      break;
    }
    case 'sf_radio':{
      var type = ftnLoad.findJson(layoutModalSelect,dataId,'type');
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var min_input = ftnLoad.findJson(layoutModalSelect,dataId,'min_input')||'';
      var max_input = ftnLoad.findJson(layoutModalSelect,dataId,'max_input')||'';
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfName_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box .edit-con .radio-select').attr('data-stylediy',styleDiySel); 
      $('.edit-box').attr('data-type',type); 
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_radio"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected"); 
      }

      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').html('');
      $('.edit-box .edit-con .radio-select .select-group').html('');
      $.each(imgGroup,function(i,item){
        var checkLogo = i==0?'images/sf-'+type+'.png':'images/sf-'+type+'2.png';
        var phoneHtml ='<div class="sf_radio-box"><div class="imgbox"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div><div class="sf_sex-box"><div class="sf_icon"><img src="'+checkLogo+'" ondragstart="return false" alt="" title=""></div><span>'+item.name+'</span></div></div>';
        var editHtml='<li class="select-box"><div class="imgbox"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div><div class="input-group"><span class="input-group-addon">选项'+(i+1)+'</span><input class="control-input input-height" data-editid="" type="text" autocomplete="off" value="'+item.name+'" onkeyup="inputChange(this,&quot;radioText&quot;)"><div class="input-group-btn"><button type="button" class="btn btn-default" onclick="lay_imgDel(this)">删除</button></div></div><a href="javascript:void(0);" class="sfselect_del" onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>';
        $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').append(phoneHtml);
        $('.edit-box .edit-con .radio-select .select-group').append(editHtml);
      });

      ftnLoad.sfSelectRadio(dataId);
      ftnLoad.sfSelectAdd(dataId);
      ftnLoad.sfRequired(dataId);

      //滑动条
      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: imgGroup.length,
        values: [ min_input,max_input ],
        slide: function( event, ui ) {
          $( "#amount" ).val("最少选择："+ ui.values[ 0 ] + "   "+ "最多选择：" + ui.values[ 1 ]);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'min_input',ui.values[0])
          LMData.prototype.saveJson(layoutModalSelect,dataId,'max_input',ui.values[1])
        },
      });
      $( "#amount" ).val("最少选择："+ $("#slider-range").slider("values",0) +"   "+"最多选择：" + $("#slider-range").slider("values",1));
      

      break;
    }
    case 'sf_select':{
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfSelect_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_select"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected"); 
      }

      // $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').html('');
      $('.edit-box .edit-con .radio-select .select-group').html('');
      $.each(imgGroup,function(i,item){
        var checkLogo = i==0?'images/sf-'+type+'.png':'images/sf-'+type+'2.png';
        // var phoneHtml ='<div class="sf_radio-box"><div class="imgbox"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div><div class="sf_sex-box"><div class="sf_icon"><img src="'+checkLogo+'" ondragstart="return false" alt="" title=""></div><span>'+item.name+'</span></div></div>';
        var editHtml='<li class="select-box"><div class="input-group"><span class="input-group-addon">选项'+(i+1)+'</span><input class="control-input input-height" data-editid="" type="text" autocomplete="off" value="'+item.name+'" onkeyup="inputChange(this,&quot;radioText&quot;)"><div class="input-group-btn"><button type="button" class="btn btn-default" onclick="lay_imgDel(this)">删除</button></div></div><a href="javascript:void(0);" class="sfselect_del" onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>';
        // $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').append(phoneHtml);
        $('.edit-box .edit-con .radio-select .select-group').append(editHtml);
      });

      ftnLoad.sfSelectRadio(dataId);
      ftnLoad.sfSelectAdd(dataId);
      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'sf_date':{
      var type = ftnLoad.findJson(layoutModalSelect,dataId,'type');
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var placeholder = ftnLoad.findJson(layoutModalSelect,dataId,'placeholder');
      var img = ftnLoad.findJson(layoutModalSelect,dataId,'img');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .edit-con [data-editid=sfSelect_style] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('.edit-box .edit-con [data-editid=sfdate_type] input[value='+type+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_date"]').attr('data-stylediy',styleDiySel).attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      $('.edit-box [data-editid=sf_placeholder]').val(placeholder);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid=sf_placeholder]').text(placeholder);
      $('.edit-box .layout_img-box img').attr('src',img);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf_icon').children().attr('src',img);
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected"); 
      }
      switch(styleDiySel){
        case 'trueImg':{
          $('.edit-box .sfedit_img').show();
          break;
        }
        default:{
          $('.edit-box .sfedit_img').hide();
          break;
        }
      }

      ftnLoad.sfRadioImg(dataId);
      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'sf_file':{
      var name = ftnLoad.findJson(layoutModalSelect,dataId,'name');
      var required = ftnLoad.findJson(layoutModalSelect,dataId,'required');
      var maxlength = ftnLoad.findJson(layoutModalSelect,dataId,'maxlength');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sf_file"]').attr('data-required',required); 
      $('.edit-box [data-editid=sfName_title]').val(name);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="sfName_title"]').text(name); 
      // $('.edit-box .layout_img-box img').attr('src',img);
      // $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf_icon').children().attr('src',img);
      $('.edit-box .edit-con .sf_required input').attr('checked',required);
      if(required){
        $('.edit-box .edit-con .sf_required').children().addClass("selected");
      }else{
        $('.edit-box .edit-con .sf_required').children().removeClass("selected"); 
      }

      //多选
      $('.customGoods_selclassify .control-chosen').chosen({
        allow_single_deselect: true,
        width: '100%',
      });

      ftnLoad.sfRequired(dataId);

      break;
    }
    case 'layFlash':{
      
      var styleDiySel = ftnLoad.findJson(layoutModalSelect,dataId,'stylediy');
      var elementSel = ftnLoad.findJson(layoutModalSelect,dataId,'elementSel');
      var imgGroup = ftnLoad.findJson(layoutModalSelect,dataId,'imgGroup');
      var perPage = ftnLoad.findJson(layoutModalSelect,dataId,'perpage');
      var sorttype = ftnLoad.findJson(layoutModalSelect,dataId,'sorttype');
      var maxPerPage = ftnLoad.findJson(layoutModalSelect,dataId,'maxperpage');
      var classifyId = ftnLoad.findJson(layoutModalSelect,dataId,'classifyId');
      var title = ftnLoad.findJson(layoutModalSelect,dataId,'title');
      $('.edit-box .title_box .title h5').text(title+'设置');

      $('.edit-box .title_box .title h5').text(title+'设置');
      
      $('.edit-box [data-editid=customgoods_classify] input[value='+styleDiySel+']').attr('checked',true).parent().addClass("selected").siblings().removeClass("selected");

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').attr('data-stylediy',styleDiySel);

      ftnLoad.layCenNavRadio(dataId);

       //滑动条
       $("#cennav_navslider").slider({
        value: maxPerPage,
        min: 2,
        max: 20,
        change: function( event, ui ) {
          console.log(ui.value)
          LMData.prototype.saveJson(layoutModalSelect,dataId,'maxperpage',ui.value)
        },
        create: function() {
          $("#custom-handle").text( $( this ).slider( "value" ) + '个' );
        },
        slide: function( event, ui ) {
          $("#custom-handle").text( ui.value + '个' );
        }
      });


      break;
    }
  }
}
function inputChange(ev,type){
  var dataId = $(ev).parents('.edit-box').attr('data-id');
  var dataLm = $(ev).parents('.edit-box').attr('data-laymodal');
  var thisId = $(ev).attr('data-editid');
  var thisVal = $(ev).val();
  switch(type){
    case 'text':{
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+thisId+'"]').text(thisVal);
      SaveLMData(dataId,dataLm);
      break;
    }
    case 'color':{
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+thisId+'"]').css('color',thisVal).siblings('i').css('color',thisVal);
      SaveLMData(dataId,dataLm);
      break;
    }
    case 'bgcolor':{
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+thisId+'"]').css('background-color',thisVal);
      SaveLMData(dataId,dataLm);
      break;
    }
    case 'height':{
      thisVal = parseInt(thisVal.replace(/[^0-9]/g,''));
      if(thisVal>$(ev).attr('data-maxvalue')){
        $.Toast("提示", "最大可输入"+$(ev).attr('data-maxvalue'), "notice", {});
        thisVal = $(ev).attr('data-maxvalue');
      }
      $(ev).val(thisVal);
      $('#layout_show').children('li[data-id="'+dataId+'"]').children().css('height',thisVal);
      SaveLMData(dataId,dataLm);
      break;
    }
    case 'picSpace':{
      thisVal = parseInt(thisVal.replace(/[^0-9]/g,''));
      if(thisVal>$(ev).attr('data-maxvalue')){
        $.Toast("提示", "最大可输入"+$(ev).attr('data-maxvalue'), "notice", {});
        thisVal = $(ev).attr('data-maxvalue');
      }
      $(ev).val(thisVal);
      var styleDiy = $(ev).parents('.edit-con').find('.magic-radio').find('.selected').find('.selct-checkbox').val();
      layMfPicSpace(dataId,styleDiy,thisVal);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'picSpace',thisVal);
      break;
    }
    case 'boxPadding':{
      thisVal = parseInt(thisVal.replace(/[^0-9]/g,''));
      if(thisVal>$(ev).attr('data-maxvalue')){
        $.Toast("提示", "最大可输入"+$(ev).attr('data-maxvalue'), "notice", {});
        thisVal = $(ev).attr('data-maxvalue');
      }
      $(ev).val(thisVal);
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_mofang').css('padding',thisVal+'px');
      LMData.prototype.saveJson(layoutModalSelect,dataId,'boxPadding',thisVal);
      break;
    }
    // case 'textColor':{
    //   var evIndex = $(ev).parents('.lay_fileimg').index();
    //   $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(evIndex).find('[data-editid=cennav_linkname]').css('color',thisVal);
    //   var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
    //   imgGroup[evIndex].newCol = thisVal;
    //   LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
    //   break;
    // }
    case 'textName':{
      var evIndex = $(ev).parents('.lay_fileimg').index();
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(evIndex).find('[data-editid="'+thisId+'"]').text(thisVal);
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup[evIndex].name = thisVal;
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
      break;
    }
    case 'textNameNotice':{
      var evIndex = $(ev).parents('.lay_img-box').index();
      console.log(evIndex)
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup[evIndex].name = thisVal;
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
      break;
    }
    case 'bottomName':{
      var evIndex = $(ev).parents('.lay_fileimg').index();
      console.log(evIndex)
      if(thisVal==''){
        $('#layout_bottomnav').children().eq(evIndex).find('[data-editid="'+thisId+'"]').hide().parent().addClass('namehide');
      }else{
        $('#layout_bottomnav').children().eq(evIndex).find('[data-editid="'+thisId+'"]').show().text(thisVal).parent().removeClass('namehide');
      }
      console.log(dataId)
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup[evIndex].name = thisVal;
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
      break;
    }
    case 'max_input':{
      thisVal = parseInt(thisVal.replace(/[^0-9]/g,''));
      if(thisVal>$(ev).attr('data-maxvalue')){
        $.Toast("提示", "最大可输入"+$(ev).attr('data-maxvalue'), "notice", {});
        thisVal = $(ev).attr('data-maxvalue');
      }
      $(ev).val(thisVal);
      SaveLMData(dataId,dataLm);
      break;
    }
    case 'radioText':{
      var evIndex = $(ev).parents('.select-box').index();
      console.log(evIndex)
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').children().eq(evIndex).find('.sf_sex-box').children('span').text(thisVal);
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      imgGroup[evIndex].name = thisVal;
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
      break;
    }
    case 'video':{
      var videoLink = $.trim($(ev).val());
      LMData.prototype.saveJson(layoutModalSelect,dataId,'videolink',videoLink);
      break;
    }
    case 'notice':{
      var imgGroup = $.trim($('.edit-box .lay_cg-modal .control-textarea').val());
      $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.content').text(imgGroup);
      console.log(imgGroup)
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
      break;
    }
    case 'fontsize':{
      console.log(thisVal)
      thisVal = parseInt(thisVal.replace(/[^0-9]/g,''));
      if(thisVal>$(ev).attr('data-maxvalue')){
        $.Toast("提示", "最大可输入"+$(ev).attr('data-maxvalue'), "notice", {});
        thisVal = $(ev).attr('data-maxvalue');
      }
      $(ev).val(thisVal);
      $(".poster-con").find('[data-target]').children('.user').css('font-size',thisVal+'px');
      LMData.prototype.saveJson(saveJson,'userName','fontSize',imgGroup);
      break;
    }
  }
}
function layMfPicSpace(dataId,stylediy,val){
  var $layMoFang = $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_mofang');
  $layMoFang.find('.clum').removeAttr('style');
  switch (stylediy){
    case 'mofang01':{
      break;
    }
    case 'mofang02':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(2)').css('margin-right','0px');
      break;
    }
    case 'mofang03':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)',
        width: '-moz-calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)',
        width: 'calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(3)').css('margin-right','0px');
      break;
    }
    case 'mofang04':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: '-moz-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: 'calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(4)').css('margin-right','0px');
      break;
    }
    case 'mofang05':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum:nth-of-type(2)').css({
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum:nth-of-type(3)').css({
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(2)').css({
        'margin-right':'0px',
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(3)').css('margin-right','0px');
      break;
    }
    case 'mofang06':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum:nth-of-type(2)').css({
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum:nth-of-type(3)').css({
        width: '-webkit-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: '-moz-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: 'calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum:nth-of-type(4)').css({
        width: '-webkit-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: '-moz-calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        width: 'calc(25% - '+parseFloat(val*3/4).toFixed(2)+'px)',
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(2)').css({
        'margin-right':'0px',
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(4)').css('margin-right','0px');
      break;
    }
    case 'mofang07':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        width: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(2)').css({
        'margin-right':'0px',
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(1)').css({
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(4)').css('margin-right','0px');
      break;
    }
    case 'mofang08':{
      $layMoFang.find('.clum').css({
        width: '-webkit-calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)',
        width: '-moz-calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)',
        width: 'calc(33.33% - '+parseFloat(val*2/3).toFixed(2)+'px)',
        height: '-webkit-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: '-moz-calc(50% - '+parseFloat(val/2).toFixed(2)+'px)',
        height: 'calc(50% - '+parseFloat(val/2).toFixed(2)+'px)'
      });
      $layMoFang.find('.clum').css('margin-right',val+'px');
      $layMoFang.find('.clum:nth-of-type(1)').css({
        height: '100%',
      });
      $layMoFang.find('.clum:nth-of-type(2)').css({
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(3)').css({
        'margin-right':'0px',
        'margin-bottom':val+'px'
      });
      $layMoFang.find('.clum:nth-of-type(5)').css('margin-right','0px');
      break;
    }
  }
}
function LMData(idx,modal){
  this.idx = idx;
  this.modal = modal;
}
LMData.prototype = {
  imgManage:function(ev){
    $(ev).find(".imgbox").children('img').each(function(i){
      var img = $(this);
      var _w = parseInt($(this).parents('.imgbox').width());
      var _h = parseInt($(this).parents('.imgbox').height());
      var realWidth;//真实的宽度
      var realHeight;//真实的高度
      var realPro;//宽高比
      var falsityWH;//乘绩数
      //这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
      $("<img/>").attr("src", $(img).attr("src")).load(function() {
        realWidth = this.width;
        realHeight = this.height;
        realPro = realWidth / realHeight;
        //如果真实的宽度大于盒子的宽度就按照100%显示
        if(realWidth>=realHeight){
          falsityWH = parseInt(_h*realPro);//等高的情况下,获取图片的宽度
          if(falsityWH>=_w){//与盒子比较宽度
            $(img).css("height","100%").css("width","auto");
          }
          else{
            $(img).css("width","100%").css("height","auto");
          }
        }
        else{
          falsityWH = parseInt(_w/realPro);//等宽的情况下,获取图片的高度
          if(falsityWH>=_h){//与盒子比较宽度
            $(img).css("width","100%").css("height","auto");
          }
          else{
            $(img).css("height","100%").css("width","auto");
          }
        }
      });
    });
  },
  findJson:function(json,val,target){
    var answer;
    $.each(json,function(i,items){
      if(items.id==val){
        answer = items[target];
        return false;
      }
    });
    return answer;
  },
  saveJson:function(json,val,target,targetCon){
    $.each(json,function(i,items){
      if(items.id==val){
        items[target] = targetCon;
        return false;
      }
    });
  },
  colorBox:function(idx,dataLm){
    var dataId = idx;
    $('.color-box').colpick({
      colorScheme:'light',
      layout:'rgbhex',
      onBeforeShow:function(hsb,hex,rgb,el){
        $(this).colpickSetColor($(this).attr('data-newcol'));
      },
      onSubmit:function(hsb,hex,rgb,el) {
        $(el).attr('data-newcol','#'+hex);
        $(el).css('background-color','#'+hex);
        if($(el).parents('.lay_fileimg').length){/*列表-颜色 */
          var evIndex = $(el).parents('.lay_fileimg').index();
      
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(evIndex).find('[data-editid=cennav_linkname]').css('color','#'+hex);
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          imgGroup[evIndex].newCol = '#'+hex;
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
        }else{
          if($(el).hasClass('color_bg')){/*背景颜色 */
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+$(el).attr('data-editid')+'"]').css('background-color','#'+hex);
            SaveLMData(dataId,dataLm);
          }else if($(el).hasClass('screencolor_bg')){/*小程序背景颜色 */
            $('.layout-show').find('[data-editid="'+$(el).attr('data-editid')+'"]').css('background-color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,$(el).data('address'),'#'+hex);
          }else if($(el).hasClass('btn_titlecolor')){/*超级表单-按钮颜色 */
            $('.layout-show').find('[data-editid="'+$(el).attr('data-editid')+'"]').css('color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,$(el).data('address'),'#'+hex);
          }else if($(el).hasClass('btn_color_bg')){/*超级表单-背景颜色 */
            $('.layout-show').find('[data-editid="'+$(el).attr('data-editid')+'"]').css('background-color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,$(el).data('address'),'#'+hex);
          }else if($(el).hasClass('bottomcolor_bg')){/*底部菜单-背景颜色 */
            $('.iphone-bottom').css('background-color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,'bgColor','#'+hex);
          }else if($(el).hasClass('bottomcolor_original')){/*底部菜单-默认颜色 */
            $('.iphone-bottom').find('[data-editid="'+$(el).attr('data-editid')+'"]:not(.active)').children('.name').css('color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,'original','#'+hex);
          }else if($(el).hasClass('bottomcolor_sel')){/*底部菜单-选中颜色 */
            $('.iphone-bottom').find('.active[data-editid="'+$(el).attr('data-editid')+'"]').children('.name').css('color','#'+hex);
            LMData.prototype.saveJson(layoutModalSelect,dataId,'newCol','#'+hex);
          }else{/*文字颜色 */
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+$(el).attr('data-editid')+'"]').css('color','#'+hex).siblings('i').css('color','#'+hex);
            SaveLMData(dataId,dataLm);
          }
        }
        $(el).colpickHide();
      }
    });
  },
  layLbtAdd:function(idx){
    var dataId = idx;
    console.log(dataId)
    //布局排版，图片模块-添加图片
    $('#lay_imgAdd').click(function(){
      console.log(dataId)
      if($(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().children().length>=5){
        $.Toast("提示", "最多添加5张图片！", "notice", {});
        return false;
      }
      // swiper.appendSlide('<div class="swiper-slide imgbox middle_center"><img src="images/dz_bg.png" ondragstart="return false" alt="" title=""></div>');
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').append('<span></span>');
      if($('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').children().length<2){
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').hide();
      }else{
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').show();
      }
      var url= getUrl();
      $(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+url+'images/default_add.png"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group"><input type="text"class="control-input form-control lay_imgsrc"name="magic_img0"readonly><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">选择图片</button></div><input type="file"name=""class="inputfile"></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      // $('.edit-box .lay_lbt-modal ul').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+nowImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group"><input type="text"class="control-input form-control lay_imgsrc"name="magic_img0"readonly value="'+showImg+'"><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">选择图片</button></div><input type="file"name=""class="inputfile"></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly '+linkMSG+'><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      var obj ={};
      obj['img'] = url+'images/dz_bg.png';
      obj['link'] = '';
      obj['linkName'] = '';
      obj['linkType'] = '';
      var exImgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      exImgGroup.push(obj);
      console.log(exImgGroup);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',exImgGroup)
      console.log(layoutModalSelect)

    });
  },
  layCenNavAdd:function(idx){
    var dataId = idx;
    //布局排版，图片模块-添加图片
    $('#lay_imgAdd').click(function(){
      var url = getUrl();
      var obj ={};
      obj['name'] = '按钮文字';
      obj['original'] = '#000000';
      obj['newCol'] = '';
      obj['img'] = url+'images/dz_bg.png';
      obj['link'] = '';
      obj['linkName'] = '';
      obj['linkType'] = '';
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').append('<div class="clum"><div class="imgbox middle_center"data-editid="cennav_img"><img src="'+obj['img']+'"ondragstart="return false"alt=""title=""></div><h3 class="name"data-editid="cennav_linkname" style="color:'+obj['original']+'" >'+obj['name']+'</h3></div>');
      $(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img src="'+url+'images/default_add.png"class="lay_imgsrc"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"data-editid="cennav_linkname"onkeyup="inputChange(this,&quot;textName&quot;)"value="'+obj['name']+'"><div class="color-box"data-newcol="'+obj['original']+'"style="background-color:'+obj['original']+'"data-original="'+obj['original']+'"></div><div class="input-group-btn reset-btn"><button type="button"class="btn btn-default"onclick="inputColorReset(this)">重置</button></div></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn linkchoose_input control-input form-control valid lay_imglink"name="magic_img"readonly value="'+obj['link']+'"><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      // $(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img src="images/default_add.png"class="lay_imgsrc"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"data-editid="cennav_linkname"onkeyup="inputChange(this,&quot;textName&quot;)"value="'+obj['name']+'"><input type="color"class="control-input form-control color-input"name="navname"data-original="'+obj['original']+'"value="'+obj['original']+'"onchange="inputChange(this,&quot;textColor&quot;)"><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="inputColorReset(this)">重置</button></div></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly value="'+obj['link']+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      var exImgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      exImgGroup.push(obj);
      console.log(exImgGroup);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',exImgGroup)
      console.log(layoutModalSelect)

      LMData.prototype.imgManage('#layout_show');
      LMData.prototype.colorBox(dataId);

    });
  },
  layBottomNavAdd:function(idx){
    var dataId = idx;
    var url = getUrl();
    //底部菜单-添加图片
    $('#lay_imgAdd').click(function(){
      if($(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().children().length>=6){
        $.Toast("提示", "最多添加6个！", "notice", {});
        return false;
      }
      var obj ={};
      var original = LMData.prototype.findJson(layoutModalSelect,dataId,'original')
      obj['name'] = '按钮文字';
      obj['img'] = url+'images/default_img.png';
      obj['img_sel'] = url+'images/default_img.png';
      var newImg = url+'images/default_add.png';
      obj['link'] = '';
      $('#layout_bottomnav').append('<li data-editid="botnav_li"><span class="icon"><img class="imgauto" src="'+obj['img']+'" ondragstart="return false" alt="" title=""><img class="imgsel" src="'+obj['img_sel']+'" ondragstart="return false" alt="" title=""></span><span class="name" data-editid="botnav_linkname" style="color:'+original+'">'+obj['name']+'</span></li>');
      $(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().append('<li class="lay_img-box lay_fileimg lay_bottomimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="'+newImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-sel"src="'+newImg+'"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">文字</span><input type="text"class="control-input form-control text-input"name="navname"value="'+obj['name']+'"data-editid="botnav_linkname"onkeyup="inputChange(this,&quot;bottomName&quot;)"></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+obj['link']+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      LMData.prototype.layBottomActive(dataId);
      var exImgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      exImgGroup.push(obj);
      console.log(exImgGroup);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',exImgGroup)
      console.log(layoutModalSelect)

    });
  },
  layNoticeAdd:function(idx){
    var dataId = idx;
    //底部菜单-添加图片
    $('#lay_imgAdd').click(function(){
      var obj ={};
      obj['name'] = '这里填写公告的标题';
      obj['link'] = '';
      $(this).parents('.lay_img-add').siblings('.lay_cg-modal').children().append('<li class="lay_img-box lay_notice-box"><div class="imgbox"></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">标题</span><input type="text" class="control-input form-control linkname" name="titlename" value="'+obj['name']+'" data-editid="laytitle_link" onkeyup="inputChange(this,&quot;textNameNotice&quot;)"></div><div class="input-group" style="margin-top: 8px;"><input type="text" class=" control-input form-control valid lay_imglink" name="magic_img" readonly="" value="'+obj['link']+'"><div class="input-group-btn"><button type="button" class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);" class="lay_img-del" onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      LMData.prototype.layBottomActive(dataId);
      var exImgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      exImgGroup.push(obj);
      console.log(exImgGroup);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',exImgGroup)
      console.log(layoutModalSelect)

    });
  },
  laySusAdd:function(idx){
    var dataId = idx;
    var url = getUrl();
    //底部菜单-添加图片
    $('#lay_imgAdd').click(function(){
      if($(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().children().length>=6){
        $.Toast("提示", "最多添加6个！", "notice", {});
        return false;
      }
      var obj ={};
      var original = LMData.prototype.findJson(layoutModalSelect,dataId,'original')
      obj['img'] = url+'images/default_img.png';
      obj['link'] = '';
      var newImg = url+'images/default_add.png';

      $('.suspension ul').append('<li class="imgbox"><img src="'+obj['img']+'" ondragstart="return false" alt="" title=""></li>');
      $(this).parents('.lay_img-add').siblings('.lay_lbt-modal').children().append('<li class="lay_img-box lay_onlyimg"><div class="imgbox"><img class="lay_imgsrc lay_imgsrc-auto"src="'+newImg+'"ondragstart="return false"alt=""title=""></div><div class="input-box"><div class="input-group input-text-color"><input type="text"class="control-input form-control text-input"name="navname"value=""data-editid="botnav_linkname"readonly onkeyup="inputChange(this,&quot;bottomName&quot;)"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="图标库"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">图标库</button></div><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic"title="本地上传"onclick="inputFileNav(this)">本地上传</button></div></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+obj['link']+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

      var exImgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      exImgGroup.push(obj);
      console.log(exImgGroup);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',exImgGroup)
      console.log(layoutModalSelect)

    });
  },
  layBottomActive:function(idx){
    var dataId = idx;
    //底部菜单-点击状态
    $('#layout_bottomnav li').click(function(){
      var original = LMData.prototype.findJson(layoutModalSelect,dataId,'original');
      var newCol = LMData.prototype.findJson(layoutModalSelect,dataId,'newCol');
      $(this).addClass('active').children('.name').css('color',newCol);
      $(this).siblings().removeClass('active').children('.name').css('color',original);
    });
  },
  layLbtRadio:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .radio-box .selct-checkbox").click(function(){
      if($(this).parent().hasClass("selected")){
        return false;
      }
      var styleDiy = $(this).val();
      console.log(styleDiy)
      $(this).parent().addClass("selected").siblings().removeClass("selected");
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
      
      LMData.prototype.imgManage('#layout_show');
    });
  },
  layCenNavRadio:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .radio-box .selct-checkbox").click(function(){
      if($(this).parent().hasClass("selected")){
        return false;
      }
      var styleDiy = $(this).val();
      var editId = $(this).parents('.radio-box').attr('data-editid');
      $(this).parent().addClass("selected").siblings().removeClass("selected");
      switch (editId){
        case 'cennav_navstyle':{
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
          break;
        }
        case 'cennav_navnum':{
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').attr('data-selectnum',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'selectNum',styleDiy);
          break;
        }
        case 'cennav_navshow':{
          if(parseInt(styleDiy)){
            $(this).parents('.edit-con').find('.cennav_navslider').fadeIn();
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').fadeIn();
          }else{
            $(this).parents('.edit-con').find('.cennav_navslider').fadeOut();
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt-pagination').fadeOut();
          }
          LMData.prototype.saveJson(layoutModalSelect,dataId,'perpage',parseInt(styleDiy));
          break;
        }
        case 'customGoods_show':{
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
          if(parseInt(styleDiy)){
            //1：选择商品
            $(this).parents('.edit-con').find('.cennav_navslider').show();
            $(this).parents('.edit-con').find('.customGoods_selclassify').show();
            $(this).parents('.edit-con').find('[data-editid=customGoods_sortorder]').parents('.form-group').show();
            $('.edit-box .lay_cg-modal').hide();
            $('.edit-box .lay_img-add').hide();

            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('<div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div>');
          }else{
            //0：手动选择
            $(this).parents('.edit-con').find('.cennav_navslider').hide();
            $(this).parents('.edit-con').find('.customGoods_selclassify').hide();
            $(this).parents('.edit-con').find('[data-editid=customGoods_sortorder]').parents('.form-group').hide();
            $('.edit-box .lay_cg-modal').show();
            $('.edit-box .lay_img-add').show();

            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('');
            $('.edit-box .lay_cg-modal ul').html('');
            $.each(imgGroup,function(i,item){
              // var tabHtml = '';
              // $.each(item.tab,function(idx,items){
              //   tabHtml += '<span>'+items+'</span>'
              // });<div class="tab"data-editid="tab"data-state="'+elementSel.tab+'">'+tabHtml+'</div>
              $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').append('<div class="clum"><div class="imgbox"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><div class="msg"><span class="name"data-editid="name"data-state="'+elementSel.name+'">'+item.name+'</span><div class="msg-bottom"><div class="price-box"><span class="price"data-editid="price"data-state="'+elementSel.price+'">'+item.price+'</span><span class="price-ex"data-editid="priceEx"data-state="'+elementSel.priceEx+'">'+item.priceEx+'</span></div><div class="vip"data-editid="priceVip"data-state="'+elementSel.priceVip+'"><span>会员价</span><span>'+item.priceVip+'</span></div></div></div></div>');
              $('.edit-box .lay_cg-modal ul').append('<li class="lay_cg-box"><div class="imgbox"data-serviceid="'+item.id+'"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><a href="javascript:void(0);"class="lay_img-del"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');

            });

          }
          LMData.prototype.imgManage('#layout_show');
          LMData.prototype.saveJson(layoutModalSelect,dataId,'perpage',parseInt(styleDiy));
          break;
        }
        case 'consulting_show':{
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
          if(parseInt(styleDiy)){
            //1:选择分类
            $('.edit-box .cennav_navslider').show();
            $('.edit-box .customGoods_selclassify').show();
            $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').show();
            $('.edit-box .lay_cg-modal').hide();
            $('.edit-box .lay_img-add').hide();
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').html('<div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div><div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div><div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">文章标题-文章标题-文章标题</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>2018-07-30</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>2010</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="images/lb_bg.png"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div>');
    
          }else{
            //0:手动选择
            $('.edit-box .cennav_navslider').hide();
            $('.edit-box .customGoods_selclassify').hide();
            $('.edit-box [data-editid=customGoods_sortorder]').parents('.form-group').hide();
            $('.edit-box .lay_cg-modal').show();
            $('.edit-box .lay_img-add').show();
    
            $('.edit-box .lay_cg-modal ul').html('');
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').html('');
            $.each(imgGroup,function(i,item){
              // var tabHtml = '';
              // $.each(item.tab,function(idx,items){
              //   tabHtml += '<span>'+items+'</span>'
              // });
              $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_consulting').append('<div class="clum"><div class="msg"><span class="title"data-editid="title"data-state="true">'+item.name+'</span><div class="msg-bottom"><span class="time"data-editid="time"data-state="'+elementSel.time+'"><i class="iconfont icon-shizhong"></i>'+item.time+'</span><span class="reading"data-editid="reading"data-state="'+elementSel.reading+'"><i class="iconfont icon-liulan"></i>'+item.reading+'</span></div></div><div class="imgboxs"><div class="imgbox middle_center"><img src="'+item.img+'"ondragstart="return false"alt=""title=""style="height: 100%; width: auto;"></div></div></div>');
              $('.edit-box .lay_cg-modal ul').append('<li class="lay_cg-box"><div class="imgbox"data-serviceid="'+item.id+'"><img src="'+item.img+'"ondragstart="return false"alt=""title=""></div><a href="javascript:void(0);"class="lay_img-del"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            });
          }

          LMData.prototype.imgManage('#layout_show');
          LMData.prototype.saveJson(layoutModalSelect,dataId,'perpage',parseInt(styleDiy));
          break;
        }
        case 'customGoods_sortorder':{
          LMData.prototype.saveJson(layoutModalSelect,dataId,'sorttype',styleDiy);
          break;
        }
        case 'customgoods_classify':{
          console.log(styleDiy)
          $(this).parent().addClass("selected").siblings().removeClass("selected");
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
          break;
        }
        case 'coupons_radio':{
          console.log(styleDiy)
          $(this).parent().addClass("selected").siblings().removeClass("selected");
          // $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
          break;
        }
        case 'notice_radio':{
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          if(parseInt(styleDiy)){
            //1:选择分类
            $('.edit-box .cennav_navslider').show();
            $('.edit-box .notice_selclassify').show();
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.content').text('这里将读取商城的公告进行滚动显示');
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.more').show();
            $('.edit-box .lay_cg-modal').hide();
            // $('.edit-box .lay_img-add').hide();
            // <div class="tab" data-editid="tab" data-state="'+elementSel.tab+'"><span>限时购买</span><span>满100减50</span></div>
            // $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('<div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div><div class="clum"><div class="imgbox"><img src="images/default_img.png" ondragstart="return false" alt="" title="" style="height: 100%; width: auto;"></div><div class="msg"><span class="name" data-editid="name" data-state="'+elementSel.name+'">商品标题-商品标题-商品标题</span><div class="msg-bottom"><div class="price-box"><span class="price" data-editid="price" data-state="'+elementSel.price+'">￥100.00</span><span class="price-ex" data-editid="priceEx" data-state="'+elementSel.priceEx+'">￥200.00</span></div><div class="vip" data-editid="priceVip" data-state="'+elementSel.priceVip+'"><span>会员价</span><span>￥90.00</span></div></div></div></div>');
    
          }else{
            //0:手动选择
            $('.edit-box .cennav_navslider').hide();
            $('.edit-box .notice_selclassify').hide();
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.content').text(imgGroup);
            $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_notice').children('.more').hide();
            $('.edit-box .lay_cg-modal').show();
            // $('.edit-box .lay_img-add').show();
    
            $('.edit-box .lay_cg-modal .control-textarea').val(imgGroup);
            // $('.edit-box .lay_cg-modal ul').html('');
            // $.each(imgGroup,function(i,item){
            //   $('.edit-box .lay_cg-modal ul').append('<li class="lay_img-box lay_notice-box"><div class="imgbox"></div><div class="input-box"><div class="input-group input-text-color"><span class="input-group-addon">标题</span><input type="text"class="control-input form-control linkname"name="titlename"value="'+item.name+'"data-editid="laytitle_link"onkeyup="inputChange(this,&quot;textNameNotice&quot;)"></div><div class="input-group"style="margin-top: 8px;"><input type="text"class=" control-input form-control valid lay_imglink"name="magic_img"readonly=""value="'+item.link+'"><div class="input-group-btn"><button type="button"class="btn btn-default btn-select-pic">选择链接</button></div></div></div><a href="javascript:void(0);"class="lay_img-del"onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            // });
            // productSel = imgGroup;
          }
          LMData.prototype.saveJson(layoutModalSelect,dataId,'perpage',parseInt(styleDiy));
          break;
        }
        case 'video_source':{
          if(styleDiy=='chooseVideo'){
            //1:选择视频
            $('.edit-box .video_source-box[data-editid=chooseVideo]').show();
            $('.edit-box .video_source-box[data-editid=videoAddress]').hide();
    
          }else{
            //0:视频地址
            $('.edit-box .video_source-box[data-editid=chooseVideo]').hide();
            $('.edit-box .video_source-box[data-editid=videoAddress]').show();
          }
          LMData.prototype.saveJson(layoutModalSelect,dataId,'videoStyle',styleDiy);
          break;
        }
      }
    });
  },
  layMfRadio:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .radio-box .selct-checkbox").click(function(){
      var styleDiy = $(this).val();
      var picLen = $(this).data('mflen');
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      var imgEditLen = $(this).parents('.edit-con').find('#lay_img_editmodal').children().length;
      var picSpace = LMData.prototype.findJson(layoutModalSelect,dataId,'picSpace');
      var $layMoFang = $('#layout_show').children('li[data-id="'+dataId+'"]').find('.lay_mofang');
      console.log('layMfRadio:'+picSpace)

      $(this).parent().addClass("selected").siblings().removeClass("selected");
      $layMoFang.attr('data-stylediy',styleDiy)
      LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
      //设置框增删图片框
      if(picLen-imgEditLen>0){
        var url = getUrl();
        for(var i=0;i<(picLen-imgEditLen);i++){
          $(this).parents('.edit-con').find('#lay_img_editmodal').append('<li class="lay_img-box lay_fileimg"><div class="imgbox"><img class="lay_imgsrc" src="'+url+'images/default_add.png"ondragstart="return false"alt=""title=""><input type="file"name=""class="inputfile"><div class="imgNavUp"><span class=""title="点击重新选择"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">重新选择</span></div></div><div class="input-box"><div class="input-group"><input type="text"class="control-input form-control lay_imgsrc"name="magic_img0"readonly><div class="input-group-btn"><button type="button"class="btn btn-default"onclick="iconLibrary(this)"data-toggle="modal"data-target=".icon-lib">选择图片</button></div><input type="file"name=""class="inputfile"></div><div class="input-group linkchoose"style="margin-top: 8px;"><input type="text"class="input_btn control-input form-control valid lay_imglink linkchoose_input"name="magic_img"readonly><div class="input-group-btn"><button type="button"class="btn btn-default linkchoose_btn" onclick="LinkToChoose(this)" data-toggle="modal" data-target=".link-lib">选择链接</button></div></div></div></li>');
          $layMoFang.append('<div class="clum"><div class="imgbox middle_center"data-editid="lunbotu_height"><img src="'+url+'images/dz_bg.png"ondragstart="return false"alt=""title=""></div></div>');
          var obj ={};
          obj['img'] = url+'images/dz_bg.png';
          obj['link'] = '';
          obj['linkName'] = '';
          obj['linkType'] = '';
          imgGroup.push(obj);
        }
      }else{
        $(this).parents('.edit-con').find('#lay_img_editmodal').children().eq(picLen-1).nextAll().remove();
        $layMoFang.children().eq(picLen-1).nextAll().remove();
        for(var i=0;i<imgEditLen-picLen;i++){
          imgGroup.splice(picLen,1);//delete
        }
      }
      //布局-手机-宽度调整
      layMfPicSpace(dataId,styleDiy,picSpace);
      LMData.prototype.imgManage('#layout_show');

      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
    });
  },
  layCGAdd:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .lay_checkbox .selct-checkbox").click(function(){
      var element = $(this).val();
      var state;
      if($(this).parent().hasClass("selected")){
        $(this).parent().removeClass("selected");
        state = false;
      }else{
        $(this).parent().addClass("selected");
        state = true;
      }

      $('#layout_show').find('li[data-id="'+dataId+'"]').find('[data-editid="'+element+'"]').attr('data-state',state);
      var obj = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
      obj[element] = state;
      LMData.prototype.saveJson(layoutModalSelect,dataId,'elementSel',obj);
    });
  },
  layCGSelect:function(idx){
    var dataId = idx;
    
    $(".edit-box[data-id="+dataId+"] .control-chosen").on("change",function(){
      var classifyId = $(this).children('option:selected').data('classifyid');
      
      LMData.prototype.saveJson(layoutModalSelect,dataId,'classifyId',classifyId);
      console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'classifyId'))
    });
  },
  sfRadioImg:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .radio-box .selct-checkbox").click(function(){
      if($(this).parent().hasClass("selected")){
        return false;
      }
      var styleDiy = $(this).val();
      console.log(styleDiy)
      switch(styleDiy){
        case 'ytd':case 'time':{
          // $(this).parents('.edit-box').find('.sfedit_img').show();
          
          $(this).parent().addClass("selected").siblings().removeClass("selected");
          // $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'type',styleDiy);

          break;
        }
        case 'trueImg':{
          $(this).parents('.edit-box').find('.sfedit_img').show();
          
          $(this).parent().addClass("selected").siblings().removeClass("selected");
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);

          break;
        }
        default:{
          $(this).parents('.edit-box').find('.sfedit_img').hide();
          
          $(this).parent().addClass("selected").siblings().removeClass("selected");
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);

          break;
        }
      }
      // $(this).parent().addClass("selected").siblings().removeClass("selected");
      // $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
      // LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
      
      LMData.prototype.imgManage('#layout_show');
    });
  },
  sfRequired:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .sf_required .selct-checkbox").click(function(){
      var state;
      if($(this).parent().hasClass("selected")){
        state = false;
        $(this).parent().removeClass("selected");
      }else{
        state = true;
        $(this).parent().addClass("selected");
      }
      
      $(this).parents('.sf_required').siblings('.required-limit').attr('data-stylediy',state);

      $('#layout_show').find('li[data-id="'+dataId+'"]').children('div').attr('data-required',state);
      LMData.prototype.saveJson(layoutModalSelect,dataId,'required',state);
    });
  },
  sfSelectRadio:function(idx){
    var dataId = idx;
    $(".edit-box[data-id="+dataId+"] .radio-box .selct-checkbox").click(function(){
      if($(this).parent().hasClass("selected")){
        return false;
      }
      var styleDiy = $(this).val();
      var editId = $(this).parents('.radio-box').attr('data-editid');
      $(this).parent().addClass("selected").siblings().removeClass("selected");
      switch (editId){
        case 'sfName_style':{
          $('.edit-box .radio-select').attr('data-stylediy',styleDiy); 
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          break;
        }
        case 'sfSelect_style':{
          // $('.edit-box .radio-select').attr('data-stylediy',styleDiy); 
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lbt_stylediy').attr('data-stylediy',styleDiy);
          break;
        }
      }
      LMData.prototype.saveJson(layoutModalSelect,dataId,'stylediy',styleDiy);
    });
  },
  sfSelectAdd:function(idx){
    var dataId = idx;
    //布局排版，图片模块-添加图片
    $('#select-control').click(function(){
      var type = LMData.prototype.findJson(layoutModalSelect,dataId,'type');
      var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');

      var lm = $(this).parents('.edit-box').data('laymodal');
      var url = getUrl();
      switch (lm){
        case 'sf_select':{
          var obj ={};
          obj['name'] = '选项'+(imgGroup.length+1);
          // obj['img'] = 'images/default_add.png';

          var editHtml='<li class="select-box"><div class="input-group"><span class="input-group-addon">选项'+(imgGroup.length+1)+'</span><input class="control-input input-height" data-editid="" type="text" autocomplete="off" value="'+obj['name']+'" onkeyup="inputChange(this,&quot;radioText&quot;)"><div class="input-group-btn"><button type="button" class="btn btn-default" onclick="lay_imgDel(this)">删除</button></div></div><a href="javascript:void(0);" class="sfselect_del" onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>';
          $('.edit-box .edit-con .radio-select .select-group').append(editHtml);
          
          imgGroup.push(obj);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        default :{
          var obj ={};
          obj['name'] = '选项'+(imgGroup.length+1);
          obj['img'] = url+'images/default_add.png';

          var phoneHtml ='<div class="sf_radio-box"><div class="imgbox"><img src="'+obj['img']+'" ondragstart="return false" alt="" title=""></div><div class="sf_sex-box"><div class="sf_icon"><img src="images/sf-'+type+'2.png" ondragstart="return false" alt="" title=""></div><span>'+obj['name']+'</span></div></div>';
          var editHtml='<li class="select-box"><div class="imgbox"><img src="'+obj['img']+'" ondragstart="return false" alt="" title=""></div><div class="input-group"><span class="input-group-addon">选项'+(imgGroup.length+1)+'</span><input class="control-input input-height" data-editid="" type="text" autocomplete="off" value="'+obj['name']+'" onkeyup="inputChange(this,&quot;radioText&quot;)"><div class="input-group-btn"><button type="button" class="btn btn-default" onclick="lay_imgDel(this)">删除</button></div></div><a href="javascript:void(0);" class="sfselect_del" onclick="lay_imgDel(this)"><i class="glyphicon glyphicon-remove"></i></a></li>';
          $('#layout_show').children('li[data-id="'+dataId+'"]').find('.sf-right').append(phoneHtml);
          $('.edit-box .edit-con .radio-select .select-group').append(editHtml);
          
          imgGroup.push(obj);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);

          $( "#slider-range" ).slider({
            max: imgGroup.length,
          });

          break;
        }
      }
      console.log(layoutModalSelect)
      
    });
  },
}

function inputFile(ev){
  $(ev).parents('.input-group').find('input[type=file]').click();
}
function inputFileNav(ev){
  $(ev).parents('.imgbox').find('input[type=file]').click();
}
function inputColorReset(ev){
  var dataId = $(ev).parents('.edit-box').data('id');
  var original = $(ev).parent().siblings('.color-box').data('original');
  var evIndex = $(ev).parents('.lay_fileimg').index();
  var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
  imgGroup[evIndex].newCol = '';
  LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
  $(ev).parent().siblings('.color-box').css('background-color',original);
  $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(evIndex).find('[data-editid=cennav_linkname]').css('color',original);
}
function colorReset(ev){
  var $this = $(ev).parent().siblings('.color-box');
  var dataId = $(ev).parents('.edit-box').data('id');
  var original = $this.attr('data-original');
  var thisId = $this.attr('data-editid');
  $this.css('background-color',original);
  if($this.hasClass('color_bg')){/*背景颜色 */
    $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+thisId+'"]').css('background-color',original);
  }else if($this.hasClass('screencolor_bg')){/*小程序背景颜色 */
    $('.layout-show').find('[data-editid="'+$this.attr('data-editid')+'"]').css('background-color',original);
    LMData.prototype.saveJson(layoutModalSelect,'basicSetup',$this.data('address'),original);
  }else if($this.hasClass('btn_titlecolor')){/*超级表单-按钮颜色 */
    $('.layout-show').find('[data-editid="'+$this.attr('data-editid')+'"]').css('color',original);
    LMData.prototype.saveJson(layoutModalSelect,'basicSetup',$this.data('address'),original);
  }else if($this.hasClass('btn_color_bg')){/*超级表单-背景颜色 */
    $('.layout-show').find('[data-editid="'+$this.attr('data-editid')+'"]').css('background-color',original);
    LMData.prototype.saveJson(layoutModalSelect,'basicSetup',$this.data('address'),original);
  }else{/*文字颜色 */
    $('#layout_show').children('li[data-id="'+dataId+'"]').find('[data-editid="'+thisId+'"]').css('color',original);
  }
}

//图标库----start----------------------------------------------------------------
var pageCou;//翻页-回传总页数
var pageJson;//翻页-回传json
var pageDisplayIcon = 24;//翻页-每页显示数-icon
var pageDisplay = 10;//翻页-每页显示数-icon
var pageDisplayWx = 8;//翻页-每页显示数-微信
//翻页回调函数
function pageNavCallBack(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack);
  iconPageShow(pageJson,clickPage,pageDisplayIcon);
}
function iconLibrary(ev){
  $('body').append('<div class="modal fade bs-example-modal-lg icon-lib"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择图片</h4></div><div class="modal-body clearit"><ul class="nav nav-tabs icon-lib-control"role="tablist"><li role="presentation"><a href="#iconLibrary"aria-controls="iconLibrary"role="tab"data-toggle="tab">图标库</a></li><li role="presentation"class="active"><a href="#onlineup"aria-controls="onlineup"role="tab"data-toggle="tab">图片库</a></li></ul><div class="tab-content col-sm-3"><div role="tabpanel"class="tab-pane icon_section"id="iconLibrary"><div class="icon-nav panel-group"id="icon_section"role="tablist"aria-multiselectable="true"><div class="panel panel-default"><div class="panel-heading action"data-showlib="all"role="tab"><a class="collapsed"role="button"data-toggle="collapse"data-parent="#icon_section"href="#collapseOne1"aria-expanded="true"aria-controls="collapseOne">全部</a></div><div id="collapseOne1"class="panel-collapse collapse in"role="tabpanel"></div></div></div></div><div role="tabpanel"class="tab-pane active image_section"id="onlineup"><div class="icon-nav panel-group"id="image_section"role="tablist"aria-multiselectable="true"><div class="panel panel-default"><div class="panel-heading action"data-showlib="all"role="tab"><a class="collapsed"role="button"data-toggle="collapse"data-parent="#image_section"href="#imagelistOne1"aria-expanded="true"aria-controls="collapseOne">全部</a></div><div id="imagelistOne1"class="panel-collapse collapse in"role="tabpanel"></div></div></div></div></div><div class="col-sm-9 icon-show"><ul class="icon-main clearit"></ul><div class="icon-bottom"><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"></nav><div class="icon-control"><button type="button" class="btn btn-danger icon-remove-btn disabled" onclick="imgUploadDel()">删除</button><input type="file"class="inputfile" name="image" id="file"autocomplete="off" required onchange="imageUpload()"><input type="button"class="btn icon-upload-btn"value="上传图片"></div></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary disabled">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  var obj = iconAll(imageLib);
  iconPageShow(obj,1,pageDisplayIcon);
  $('.icon-bottom .icon-control').show();
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplayIcon);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack);
  /*createIconNav(iconLib,iconLibCE,'icon_section','collapse',pageNavCallBack);*/

  createIconNav(imageLib,imageLibCE,'image_section','imagelist',pageNavCallBack);

  obj=[];
  /*切换 */
  $('.icon-lib-control li a').click(function(){
    if($(this).attr('href')=='#iconLibrary'){
      obj = iconAll(iconLib);
      iconPageShow(obj,1,pageDisplayIcon);
      $('.icon-bottom .icon-control').hide();
    }else{
      obj = iconAll(imageLib);
      iconPageShow(obj,1,pageDisplayIcon);
      $('.icon-bottom .icon-control').show();
    }

    pageNavObj = null;//用于储存分页对象
    pageCou = Math.ceil(obj.length/pageDisplayIcon);
    pageJson = obj;
    pageNavObj = new PageNavCreate("PageNavId",{
          pageCount:pageCou, 
          currentPage:1, 
          perPageNum:5, 
    });
    pageNavObj.afterClick(pageNavCallBack);
  });
  //点击确认
  $(".modal .btn-primary").click(function(){
    if(!$(this).hasClass('disabled')){
      var dataId = $(ev).parents('.edit-box').attr('data-id');
      var dataLm = $(ev).parents('.edit-box').attr('data-laymodal')||$(ev).attr('data-laymodal');
      var url = $('.modal .icon-main .active img').attr('src');
      switch (dataLm){
        case 'bottomNav':{
          var evIndex = $(ev).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          if($(ev).parents('.imgbox').find('.lay_imgsrc').hasClass('lay_imgsrc-sel')){
            $(ev).parents('.imgbox').find('.lay_imgsrc').attr('src',url);
            $('#layout_bottomnav').children().eq(evIndex).find('.imgsel').attr('src',url);
            imgGroup[evIndex].img_sel = url;
          }else{
            $(ev).parents('.imgbox').find('.lay_imgsrc').attr('src',url);
            $('#layout_bottomnav').children().eq(evIndex).find('.imgauto').attr('src',url);
            imgGroup[evIndex].img = url;
          }
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'suspension':{
          var evIndex = $(ev).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          $(ev).parent().siblings('.text-input').val(url);
          $(ev).parents('.lay_img-box').find('.lay_imgsrc').attr('src',url);
          $('.suspension ul').children().eq(evIndex).find('img').attr('src',url);
          imgGroup[evIndex].img = url;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'music':{
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          $(ev).parent().siblings('.text-input').val(url);
          $(ev).parents('.lay_img-box').find('.lay_imgsrc').attr('src',url);
          $('.music ul').children().find('img').attr('src',url);
          imgGroup[0].img = url;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'cenNav':{
          var evIndex = $(ev).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          $(ev).parents('.lay_img-box').find('.lay_imgsrc').attr('src',url);
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_cennav').children().eq(evIndex).find('img').attr('src',url);
          imgGroup[evIndex].img = url;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'mofang':{
          var evIndex = $(ev).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_mofang').children().eq(evIndex).find('img').attr('src',url);
          $(ev).parents('.lay_img-box').find('img.lay_imgsrc').attr('src',url);
          $(ev).parents('.lay_img-box').find('input.lay_imgsrc').val(url);
          console.log(url)
          imgGroup[evIndex].img = url;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'lunbotu':{
          var evIndex = $(ev).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          if(evIndex==0){
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_lunbotu').children('.imgbox').find('img').attr('src',url);
          }
          $(ev).parents('.lay_img-box').find('img.lay_imgsrc').attr('src',url);
          $(ev).parents('.lay_img-box').find('input.lay_imgsrc').val(url);
          console.log(url)
          imgGroup[evIndex].img = url;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'product_img':{
          var maxValue = $(ev).siblings('.pro-img').attr('data-maxvalue');
          var length = $(ev).siblings('.pro-img').children().length;
          console.log(maxValue)
          console.log(length)
          $.each(imgUpload_find(),function(i,item){
            if(i<maxValue-length){
              $(ev).siblings('.pro-img').append('<li class="ui-state-default middle_center" data-id="'+item.id+'"><img src="'+item.url+'" ondragstart="return false" alt="" title=""><a href="javascript:;" class="pro-img-remove" onclick="deleteimg(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            }else
            console.log(i)
            console.log(maxValue-length-1)
            if(i==maxValue-length-1){
              $(ev).hide();
            }
          });
          
          break;
        }
        case 'spec_img':{
          $(ev).parents('.imgbox').children('img').attr('src',imgUpload_find()[0].url).attr('data-id',imgUpload_find()[0].id);
          
          break;
        }
        case 'notice':{
          var url = imgUpload_find()[0].url;
          $(ev).children('img').attr('src',url);
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.logo').children().attr('src',url);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'img',url);
          break;
        }
        case 'video':{
          var url = imgUpload_find()[0].url;
          $(ev).children('img').attr('src',url);
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.imgbox').children().attr('src',url);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'videoImg',url);
          break;
        }
        case 'coupons':{
          var url = imgUpload_find()[0].url;
          var targetClass = $(ev).attr('data-targetclass');

          $(ev).children('img').attr('src',url);

          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.coupons-box .'+targetClass).css('background-image','url('+url+')');
    
          LMData.prototype.saveJson(layoutModalSelect,dataId,targetClass,url);
          break;
        }
        default:{

        }
      }
      $(this).parents(".modal").modal("hide");
    }
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
  
  $(".icon-control .icon-upload-btn").click(function(){
    $(this).siblings(".inputfile").click();
  });
}

function imgUpload_find(protocol,host){
  var obj =[];
  
  $('.icon-lib .icon-show .icon-main li.active').each(function(){
    var url = $(this).find('img').attr('src');
    var id = $(this).find('.name').attr('data-id');
    var url_pro = protocol+'//'+host+'/';
    url = url.replace(url_pro,'');
    var aObj={};
    aObj['id']=id;
    aObj['url']=url;
    obj.push(aObj);
  })
  return obj;
}
/*生成左侧导航栏 */
function createIconNav(json,jsonCE,parent,childname,pageNavCallBack){
  var num = 0;
  $.each(json,function(i,items){
    var id_name = childname+num;
    $('.'+parent+' .icon-nav').append('<div class="panel panel-default"></div>');
    $('.'+parent+' .icon-nav').children().last().append('<div class="panel-heading" data-showlib="'+i+'" role="tab"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#'+parent+'" href="#'+id_name+'" aria-expanded="false " aria-controls="'+id_name+'">'+jsonCE[i]+'</a></div><div id="'+id_name+'" class="panel-collapse collapse" role="tabpanel"><ul class="list-group"></ul></div>');
    var obj=[];
    $.each(items,function(idx,item){
      var repeat= false;
      if(obj.length!==0){
        for(var n=0;n<obj.length;n++){
          if(obj[n]==item.id){
            repeat=true;
            break;
          }
        }
      }
      if(!repeat&&item.id!=''&&item.classify!=undefined){
        obj.push(item.id);
        $('.'+parent+' #'+id_name).children().append('<li class="list-group-item" data-parlib="'+i+'" data-showlib="'+item.id+'"><a href="#">'+item.classify+'</a></li>')
      }
    });
    obj=[];
    num++;
  });
  iconAction(json,parent,pageNavCallBack);
}
/*添加点击事件-生成右侧图片列表 */
function iconAction(json,parent,pageNavCallBack){
  $('.'+parent+' .icon-nav .panel-heading > a,.'+parent+' .icon-nav .collapse .list-group-item > a').click(function(){
    if(!$(this).parent().hasClass('action')){
      $(this).parents('.icon-nav').find('.action').removeClass('action');
      $(this).parent().addClass('action');
      var parLib = $(this).parent().data('parlib')||undefined;
      var showLib = $(this).parent().data('showlib');
      console.log(showLib)
      var obj=[];
      if(parLib){//二级分类
        $.each(json,function(i,items){
          if(i==parLib){
            $.each(items,function(idx,item){
              if(item.id==showLib){
                obj.push(item);
              }
            });
          }
        });
      }else{//一级分类
        $.each(json,function(i,items){
          if(i==showLib){
            obj=items;
          }
        });
      }
      if(showLib=='all'){
        obj = iconAll(json);
      }
      iconPageShow(obj,1,pageDisplayIcon);
      var pageNavObj = null;//用于储存分页对象
      pageCou = Math.ceil(obj.length/pageDisplayIcon);
      pageJson = obj;
      pageNavObj = new PageNavCreate('PageNavId',{
            pageCount:pageCou, 
            currentPage:1, 
            perPageNum:5, 
      });
      pageNavObj.afterClick(pageNavCallBack);
      obj=[];
    }
  });
}
function iconAll(json){
  var obj=[];
  $.each(json,function(i,items){
    $.each(items,function(idx,item){
      obj.push(item);
    });
  });
  return obj;
}
//每页输出
function iconPageShow(pageJson,clickPage,pageDisplay){
  $('.icon-lib .icon-show .icon-main').html('');
  $(".icon-lib .btn-primary").addClass('disabled');
  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){
      var name = items.chn?items.chn:items.name;
      $('.icon-lib .icon-show .icon-main').append('<li><div class="imgbox"><img src="'+items.url+'"ondragstart="return false"alt=""title=""><div class="name" data-id="'+items.id+'">'+name+'</div></div></li>');
    }
  });
  $('.icon-lib .icon-show .icon-main li').click(function(){
    if(!$(this).hasClass('active')){
      $(this).addClass('active');
      $(".icon-lib .btn-primary").removeClass('disabled');
      $('.icon-lib .icon-show .icon-remove-btn').removeClass('disabled');
    }else{
      $(this).removeClass('active');
    }
    if($('.icon-lib .icon-show .icon-main li.active').length==0){
      $(".icon-lib .btn-primary").addClass('disabled');
      $('.icon-lib .icon-show .icon-remove-btn').addClass('disabled');
    }
  });
}
//图标库----end----------------------------------------------------------------

//产品库----Start----------------------------------------------------------------
//翻页回调函数
var proSelObj=[];
function pageNavCallBack_pro(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_pro);
  proPageShow('.service-select-modal',pageJson,clickPage,pageDisplay);
}
function proSelection(ev){
  var modalTitle = $(ev).val();
  $('body').append('<div class="modal fade bs-example-modal-lg service-select-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">'+modalTitle+'</h4></div><div class="modal-body main-con"><ul class="nav-contral clearit"role="tablist"><li role="presentation"class="nav-tabs-li active"><select name=""id="classify-filter"class="control-input"><option data-classifyid="all" selected="selected">全部</option></select></li><li><input type="text"class="right-input search-input"placeholder="请输入商品名称"><a href="javascript:;" class="search-input-remove" onclick="clearSearch_pro(this)"><i class="glyphicon glyphicon-remove"></i></a></li><li><input type="submit"class="right-input search-input-btn btn"value="搜索"></li></ul><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th style="width: 10%;text-align: left;"><label><input class="selectAll"type="checkbox"name="products"></label></th><th style="width: 10%;">分类</th><th style="width: 50%;"colspan="2">产品名称</th><th style="width: 10%;">价格</th><th style="width: 20%;">操作</th></tr></thead><tbody></tbody><tfoot><tr><td class="id"><label><input class="selectAll"type="checkbox"name="products"></label></td><td colspan="9"style="text-align: left;"class="tfoot-control"><a href="javascript:;"class="bttn service-selectAll-add"><i class="glyphicon glyphicon-ok"></i>批量添加</a><a href="javascript:;"class="bttn service-selectAll-remove"><i class="glyphicon glyphicon-remove"></i>批量移除</a><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div><div class="service-footer "><div class="alert alert-info clearit"role="alert"><h5>已添加：</h5><ul class="service-select"></ul></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  
  var obj = iconAll(productList);
  proPageShow('.service-select-modal',obj,1,pageDisplay);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplay);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_pro);
  obj=[];
  /*分类下拉生成-select */
  selectOption('.modal #classify-filter');
  /*生成已选择-select */
  proSelObj = productSel.slice();
  $.each(proSelObj,function(i,items){
    $('.modal .service-select').append('<li><span class="title">'+items.name+'</span><a href="javascript:void(0)" class="service-select-remove" data-selectnum="'+items.id+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
  });

  proSelAction();

  //输入框
  $('.modal .search-input').on('keyup', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).val());
    if(value!=''){
      $('.search-input-remove').show();
    }else{
      $('.search-input-remove').hide();
    }
  });

  //搜索
  var resultJson = [];
  $('.modal .search-input-btn').on('click', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).parent().siblings().children('input').val());
    var obj = iconAll(productList);
    $.each(obj,function(i,item){
      if(item.name.indexOf(value) != -1){
        resultJson.push(item);
      }
    });
    if(resultJson == ''){
      $('.modal .main-table tbody').html('<tr class="data-empty"><td colspan="4"></td></tr>');
    }else{
      proPageShow('.service-select-modal',resultJson,1,pageDisplay);
      var pageNavObj = null;//用于储存分页对象
      pageCou = Math.ceil(resultJson.length/pageDisplay);
      pageJson = resultJson;
      pageNavObj = new PageNavCreate("PageNavId",{
            pageCount:pageCou, 
            currentPage:1, 
            perPageNum:5, 
      });
      pageNavObj.afterClick(pageNavCallBack_pro);
      resultJson=[];

    }

  });

  
  $(".service-select-modal .btn-primary").click(function(){
    if($(".service-select-modal .service-footer .service-select").children().length==0){
      $.Toast("提示", "最少添加1个商品！", "notice", {});
    }else{
      proJsonSave(ev,proSelObj);
      $(this).parents(".modal").modal("hide");
    }
  });

  $('.modal').on('hidden.bs.modal', function () {
    // proJsonSave(ev);
    $(this).remove();
  });

}
function clearSearch_pro(ev){
  $(ev).siblings().val('');
  var obj = iconAll(productList);
  proPageShow('.service-select-modal',obj,1,pageDisplay);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplay);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_pro);
  obj=[];
  $(ev).hide();
}

/*分类下拉生成-select */
function selectOption(parent){
  var obj=[];
  var Pro_Child = '&nbsp;&nbsp;&nbsp;&nbsp;';
  $.each(productList,function(i,items){
    console.log(i)
    var nameCE;
    $.each(productListCE,function(idx,item){
      if(i==item.cla_id){
        nameCE = item.name
        return false;
      }
    });
    $(parent).append('<option data-classifyid="'+i+'">'+nameCE+'</option>');
    if(i!==items[0].cla_id){
      var obj=[];
      $.each(items,function(idx,item){
        var repeat= false;
        if(obj.length!==0){
          for(var n=0;n<obj.length;n++){
            if(obj[n]==item.cla_id){
              repeat=true;
              break;
            }
          }
        }
        if(!repeat){
          obj.push(item.cla_id);
          $(parent).append('<option data-classifyid="'+item.cla_id+'">'+Pro_Child+item.classify+'</option>');
        }
      });
      obj=[];
    }
  });
}
/*存储数据 */
function proJsonSave(ev,json){
  var $parent = $(ev).parents('[data-parent=proBox]');
  var $target = $parent.find('[data-target=proBox]');
  var editId = $parent.attr("data-prostyle");
  switch(editId){
    case 'serviceSel':{
      
      productSel = json.slice();
      $target.html('');
      $.each(productSel,function(i,items){
        $target.prepend('<div class="service-box"><span class="label label-primary"data-serviceid="'+items.id+'"title="'+items.name+'">'+items.name+'</span><button class="btn btn-default service-remove"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></button></div>');
      });
      console.log('productSel:'+productSel)
      break;
    }
    case 'wxSel':{
      productSel = json.slice();
      console.log(productSel)
      $target.html('');
      $.each(productSel,function(i,items){
        $target.prepend('<div class="service-box"><span class="label"data-serviceid="'+items.id+'"title="'+items.name+'"><div class="min-imgbox"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div><div class="wx-name">'+items.name+'</div></div>');
      });
      break;
    }
    case 'proSel':{
      productSel = json.slice();
      var dataId = $(ev).parents('.edit-box').data('id');
      // var styleDiySel = LMData.prototype.findJson(layoutModalSelect,dataId,'stylediy');
      // var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
      var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
      

      $target.html('');
      $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('');
      $.each(productSel,function(i,items){
        // var tabHtml = '';
        // $.each(items.tab,function(idx,item){
        //   tabHtml += '<span>'+item+'</span>'
        // });<div class="tab"data-editid="tab"data-state="'+elementSel.tab+'">'+tabHtml+'</div>
        $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').append('<div class="clum"><div class="imgbox"><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div><div class="msg"><span class="name"data-editid="name"data-state="'+elementSel.name+'">'+items.name+'</span><div class="msg-bottom"><div class="price-box"><span class="price"data-editid="price"data-state="'+elementSel.price+'">'+items.price+'</span><span class="price-ex"data-editid="priceEx"data-state="'+elementSel.priceEx+'">'+items.priceEx+'</span></div><div class="vip"data-editid="priceVip"data-state="'+elementSel.priceVip+'"><span>会员价</span><span>'+items.priceVip+'</span></div></div></div></div>');
        $target.append('<li class="lay_cg-box"><div class="imgbox"data-serviceid="'+items.id+'"><img src="'+items.img+'"ondragstart="return false"alt=""title="'+items.name+'"></div><a href="javascript:void(0);"class="lay_img-del"onclick="serviceRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
      });
      LMData.prototype.imgManage('#layout_show');
      LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',productSel);
      console.log(LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup'))
      break;
    }
    /*活动管理-精品团购*/
    case 'comActSel':{
      console.log(json)
      var jsonArr = new Array();
      var selArr = new Array();
      $.each(json,function(i,item){
        jsonArr.push(item.id);
      });
      if(productSel!=''){
        $.each(productSel,function(i,item){
          selArr.push(item.id);
        });
      }else{
        $target.show();
      }
      console.log(jsonArr)
      console.log(selArr)
      var startTime = $('#new_start_time').val();
      var endTime = $('#new_end_time').val();

      console.log(startTime)
      // $.each(jsonArr,function(i,item){
      //   if($.inArray(items.id, jsonArr)<0){
  
      //   }
      // });
      /*新选择的，是否在已选列表中出现，如没有，则添加 */
      var stateTime = true;
      $.each(json,function(i,items){
        if($.inArray(items.id, selArr)<0){
          // if(items.startTime!=undefined&&items.endTime!=undefined){
          //   console.log(items.endTime<startTime)
          //   console.log(items.startTime>endTime)
          //   if(items.startTime>endTime||items.endTime<startTime){

          //   }else{
          //     stateTime = false;
          //     $.Toast("提示", "商品:"+items.id+",在其他活动优惠中，请重新选择", "notice", {});
          //     return false;
          //   }
          // }
          var $tr = $('<tr></tr>');
          $tr.attr('data-id',items.id);
          $tr.attr('data-multispec',items.multiSpec);
          var actHtml = items.activity.length>0?'<a href="javascript:void(0)" data-toggle="modal" data-title="查看活动" data-target=".other-activity-modal" onclick="otherActivityCheck(this)">'+items.activity.length+'</a>':'<a href="javascript:void(0)">0</a>';
          if(items.multiSpec){//多规格
            var liHtml = '';
            $.each(items.spec,function(idx,item){
              liHtml += 
              '<li>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name spec-id">'+item.id+'</div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name">￥<span>'+item.price+'</span></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name activity_price"><input type="number" class="control-input" value=""></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name activity_inventory"><input type="number" class="control-input" value=""></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name"><span>'+item.inventory+'</span></div>'+
                '</div>'+
              '</li>';
            });
            var ulHtml='<ul>'+liHtml+'</ul>';
            var trHtml = 
            '<td class="sanji-pro min-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                  '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+items.name+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td class="sanji-pro min-pro spec-box" colspan="5">'+ulHtml+'</td>'+
            '<td class="limit-item">'+
              '<input type="number" class="control-input" value="'+items.limit+'">'+
            '</td>'+
            '<td class="sort">'+
              '<input type="number" class="control-input" value="'+items.sort+'">'+
            '</td>'+
            '<td class="other_act">'+actHtml+
            '</td>'+
            '<td>'+
              '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
            '</td>';
          }else{//单规格
            var trHtml = 
            '<td class="sanji-pro min-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                  '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+items.name+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>单规格</td>'+
            '<td class="line_price">￥'+items.price+'</td>'+
            '<td class="activity_price">'+
              '<input type="number" class="control-input" value="'+items.priceActivity+'">'+
            '</td>'+
            '<td class="activity_inventory">'+
              '<input type="number" class="control-input" value="'+items.inventoryAct+'">'+
            '</td>'+
            '<td class="inventory">'+items.inventory+'</td>'+
            '<td class="limit-item">'+
              '<input type="number" class="control-input" value="'+items.limit+'">'+
            '</td>'+
            '<td class="sort">'+
              '<input type="number" class="control-input" value="'+items.sort+'">'+
            '</td>'+
            '<td class="other_act">'+actHtml+
            '</td>'+
            '<td>'+
              '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
            '</td>';
          }
          $tr.append(trHtml);
          $('.activity-pro tbody').append($tr);
        }
      });
      /*已选列表中，是否在新增表中出现，如没有，则删除 */
      $.each(productSel,function(i,item){
        if($.inArray(item.id, jsonArr)<0){
          $target.find('tbody').find('tr[data-id='+item.id+']').remove();
        }
      });
      if(stateTime){
        productSel = json.slice();
      }
      console.log(productSel)
      break;
    }
    /*活动管理-精品团购*/
    case 'purchaseSel':{
      console.log(json)
      var jsonArr = new Array();
      var selArr = new Array();
      $.each(json,function(i,item){
        jsonArr.push(item.id);
      });
      if(productSel!=''){
        $.each(productSel,function(i,item){
          selArr.push(item.id);
        });
      }else{
        $target.show();
      }
      console.log(jsonArr)
      console.log(selArr)
      var startTime = $('#new_start_time').val();
      var endTime = $('#new_end_time').val();

      console.log(startTime)
      // $.each(jsonArr,function(i,item){
      //   if($.inArray(items.id, jsonArr)<0){
  
      //   }
      // });
      /*新选择的，是否在已选列表中出现，如没有，则添加 */
      var stateTime = true;
      $.each(json,function(i,items){
        if($.inArray(items.id, selArr)<0){
          // if(items.startTime!=undefined&&items.endTime!=undefined){
          //   console.log(items.endTime<startTime)
          //   console.log(items.startTime>endTime)
          //   if(items.startTime>endTime||items.endTime<startTime){

          //   }else{
          //     stateTime = false;
          //     $.Toast("提示", "商品:"+items.id+",在其他活动优惠中，请重新选择", "notice", {});
          //     return false;
          //   }
          // }
          var $tr = $('<tr></tr>');
          $tr.attr('data-id',items.id);
          $tr.attr('data-multispec',items.multiSpec);
          // var actHtml = items.activity.length>0?'<a href="javascript:void(0)" data-toggle="modal" data-title="查看活动" data-target=".other-activity-modal" onclick="otherActivityCheck(this)">'+items.activity.length+'</a>':'<a href="javascript:void(0)">0</a>';
          if(items.multiSpec){//多规格
            var liHtml = '';
            $.each(items.spec,function(idx,item){
              liHtml += 
              '<li>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name spec-id">'+item.id+'</div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name">￥<span>'+item.price+'</span></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name activity_price"><input type="number" class="control-input" value=""></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name activity_inventory"><input type="number" class="control-input" value=""></div>'+
                '</div>'+
                '<div class="sanji-activity-pro">'+
                  '<div class="name"><span>'+item.inventory+'</span></div>'+
                '</div>'+
              '</li>';
            });
            var ulHtml='<ul>'+liHtml+'</ul>';
            var trHtml = 
            '<td class="sanji-pro min-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                  '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+items.name+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td class="sanji-pro min-pro spec-box" colspan="5">'+ulHtml+'</td>'+
            // '<td class="limit-item">'+
            //   '<input type="number" class="control-input" value="'+items.limit+'">'+
            // '</td>'+
            // '<td class="sort">'+
            //   '<input type="number" class="control-input" value="'+items.sort+'">'+
            // '</td>'+
            // '<td class="other_act">'+actHtml+
            // '</td>'+
            '<td>'+
              '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
            '</td>';
          }else{//单规格
            var trHtml = 
            '<td class="sanji-pro min-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                  '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+items.name+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>单规格</td>'+
            '<td class="line_price">￥'+items.price+'</td>'+
            '<td class="activity_price">'+
              '<input type="number" class="control-input" value="'+items.priceActivity+'">'+
            '</td>'+
            '<td class="activity_inventory">'+
              '<input type="number" class="control-input" value="'+items.inventoryAct+'">'+
            '</td>'+
            '<td class="inventory">'+items.inventory+'</td>'+
            // '<td class="limit-item">'+
            //   '<input type="number" class="control-input" value="'+items.limit+'">'+
            // '</td>'+
            // '<td class="sort">'+
            //   '<input type="number" class="control-input" value="'+items.sort+'">'+
            // '</td>'+
            // '<td class="other_act">'+actHtml+
            // '</td>'+
            '<td>'+
              '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
            '</td>';
          }
          $tr.append(trHtml);
          $('.activity-pro tbody').append($tr);
        }
      });
      /*已选列表中，是否在新增表中出现，如没有，则删除 */
      $.each(productSel,function(i,item){
        if($.inArray(item.id, jsonArr)<0){
          $target.find('tbody').find('tr[data-id='+item.id+']').remove();
        }
      });
      if(stateTime){
        productSel = json.slice();
      }
      console.log(productSel)
      break;
    }
    /*营销-优惠券-添加商品*/
    case 'couponsSel':{
      console.log(json)
      var jsonArr = new Array();/*全部选择 */
      var selArr = new Array();/*已选择*/
      $.each(json,function(i,item){
        jsonArr.push(item.id);
      });
      if(jsonArr.length>$target.attr('data-limit')){
        $.Toast("提示", "超出数量限制，请重新选择", "notice", {});
        return false;
      }else{
        
      if(productSel!=''){
        $.each(productSel,function(i,item){
          selArr.push(item.id);
        });
      }else{
        $target.show();
      }
      /*新选择的，是否在已选列表中出现，如没有，则添加 */
      $.each(json,function(i,items){
        if($.inArray(items.id, selArr)<0){
          var $tr = $('<tr></tr>');
          $tr.attr('data-id',items.id);
          var trHtml = 
            '<td class="sanji-pro min-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="" data-original-title="'+items.name+'">'+
                  '<div class="min-img"><img src="'+items.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+items.name+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>'+
              '<a href="javascript:;" onclick="serviceRemove(this)" class="table-a">删除</a>'+
            '</td>';
          $tr.append(trHtml);
          $target.find('tbody').append($tr);
        }
      });
      /*已选列表中，是否在新增表中出现，如没有，则删除 */
      $.each(productSel,function(i,item){
        if($.inArray(item.id, jsonArr)<0){
          $target.find('tbody').find('tr[data-id='+item.id+']').remove();
        }
      });
      
      productSel = json.slice();
      console.log(productSel)
      
      }
      break;
    }
  }
}
/*下拉切换，获取数组 */
function proSelAction(){
  $('.modal #classify-filter').on("change",function(){
    var parLib = $(this).children('option:selected').data('classifyid');
    // var showLib = $(this).val();
    // console.log(showLib)
    var obj=[],state = true;
    $.each(productListCE,function(i,items){
      if(items.cla_id==parLib){
        state = false;
        return false;
      }
    });
    if(state){
      //二级分类
      $.each(productList,function(i,items){
        // if(i==parLib){
          $.each(items,function(idx,item){
            if(item.cla_id==parLib){
              obj.push(item);
            }
          });
        // }
      });
    }else{
      //一级分类
      $.each(productList,function(i,items){
        if(i==parLib){
          obj=items;
        }
      });
    }
    if(parLib=='all'){
      obj = iconAll(productList);
    }
    proPageShow('.service-select-modal',obj,1,pageDisplay);
    var pageNavObj = null;//用于储存分页对象
    pageCou = Math.ceil(obj.length/pageDisplay);
    pageJson = obj;
    pageNavObj = new PageNavCreate("PageNavId",{
          pageCount:pageCou, 
          currentPage:1, 
          perPageNum:5, 
    });
    pageNavObj.afterClick(pageNavCallBack_pro);
    obj=[];
  });
}
//每页输出
function proPageShow(parent,pageJson,clickPage,pageDisplay){
  $(parent+' .main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');
  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){
      var state = false;
      $.each(productSel,function(idx,item){
        if(items.id==item.id){
          state = true;
          return false;
        }
      });
      if(state){
        //已添加
        $(parent+' .main-table tbody').append('<tr data-id="'+items.id+'" data-classifyid="'+items.cla_id+'"><td class="id"><label><input class="selct-checkbox"type="checkbox"name="products">'+items.id+'</label></td><td class="classify">'+items.classify+'</td><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td>'+items.price+'</td><td><button type="button"class="service-state clerk-btn action"><span class="label label-danger">移除</span></button></td></tr>');
      }else{
        //未添加
        $(parent+' .main-table tbody').append('<tr data-id="'+items.id+'" data-classifyid="'+items.cla_id+'"><td class="id"><label><input class="selct-checkbox"type="checkbox"name="products">'+items.id+'</label></td><td class="classify">'+items.classify+'</td><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td>'+items.price+'</td><td><button type="button"class="service-state clerk-btn"><span class="label label-success">添加</span></button></td></tr>');
      }
      //清除全选状态
      $(parent+" .main-table .selectAll").attr('checked',false);
      $(parent+" .main-table .selectAll").parent().removeClass("selected");
    }
  });
  /*全选s */
  $(parent+" .main-table .selectAll").click(function(){
    if($(this).is(':checked')){
      $(parent+" .main-table .selct-checkbox:not([disabled]").prop('checked',true).parent().addClass("selected").parents('tr').addClass("selected");
      $(parent+" .main-table .selectAll").prop('checked',true).parent().addClass("selected");
    }else{
      $(parent+" .main-table .selct-checkbox:not([disabled]").prop('checked',false).parent().removeClass("selected").parents('tr').removeClass("selected");
      $(parent+" .main-table .selectAll").prop('checked',false).parent().removeClass("selected");
    }
  });
  $(parent+" .main-table .selct-checkbox").click(function(){
    if($(this).parent().hasClass("selected")){
      $(this).parent().removeClass("selected").parents('tr').removeClass("selected");
    }else{
      $(this).parent().addClass("selected").parents('tr').addClass("selected");
    }
    //全选检测
    checkboxCheck();
  });

  
  //店员管理-新增店员-批量添加服务
  $('.service-selectAll-add').click(function(){
    var selectNum;
    $('.service-select-modal .main-table tbody tr').each(function(){
      if($(this).hasClass('selected')&&!$(this).find('.service-state').hasClass('action')){
        serviceState($(this).find('.service-state'));
        selectNum = $(this).data('id');
        $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(this).find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectNum+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
        
      }
    });
  });
  //店员管理-新增店员-批量删除服务
  $('.service-selectAll-remove').click(function(){
    var selectNum;
    $('.service-select-modal .main-table tbody tr').each(function(){
      if($(this).hasClass('selected')&&$(this).find('.service-state').hasClass('action')){
        serviceState($(this).find('.service-state'));
        selectNum = $(this).data('id');
        $('.service-select-modal .main-con .service-select').find('a[data-selectnum="'+selectNum+'"]').parent().remove();
      }
    });
  });
  //添加已经选择的服务1
  $('.service-state').click(function(){
    // var selectNum = $(this).parents('tr').data('id');

    // if($(this).hasClass('action')){
    //   //移除
    //   serviceState(this);
    // }else{
      //添加
      serviceState(this);
    // }
  });

}

  //店员管理-新增店员-状态-弹窗
  function serviceState(ev){
    var selectID = $(ev).parents('tr').data('id');
    if($(ev).hasClass('action')){
      //移除
      $.each(proSelObj,function(i,item){
        if(item.id==selectID){
          $('.service-select-modal .main-con .service-select').find('a[data-selectnum="'+selectID+'"]').parent().remove();

          $(ev).removeClass('action').children().removeClass('label-danger').addClass('label-success').text('添加');
          proSelObj.splice(i,1);//delete
          return false;
        }
      });
    }else{
      //添加
      $.each(productList,function(i,items){
        $.each(items,function(idx,item){
          if(item.id==selectID){

            var startTime = $('#new_start_time').val();
            var endTime = $('#new_end_time').val();
            console.log(item.activity)

            // if(startTime==''&&endTime==''){
            //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //   proSelObj.push(item);
            // }else if(item.activity!=''){
            //   var actLength = items.activity.length;
            //   var lastState = false;
            //   $.each(item.activity,function(n,itm){
            //     console.log(n)
            //     switch(true){
            //       case n==0:{
            //         if(endTime<itm.startTime&&endTime!=''){
            //           $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //           $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //           proSelObj.push(item);
            //           return false;
            //         }else if(startTime>itm.endTime&&startTime!=''){
            //           lastState = true;
            //           // stateTime = false;
            //           // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
            //           // return false;
            //         }
            //         break;
            //       }
            //       case n!=0&&n!=(actLength-1):{
            //         if(endTime<itm.startTime&&endTime!=''&&lastState){
            //           $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //           $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //           proSelObj.push(item);
            //           return false;
            //         }else{
            //           lastState = false;
            //         }
            //         if(startTime>itm.endTime&&startTime!=''){
            //           lastState = true;
            //         // }else if(startTime==''&&endTime==''){
            //         //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //         //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //         //   proSelObj.push(item);
            //         //   return false;
            //         // }else{
            //           // stateTime = false;
            //           // $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
            //           // return false;
            //         }
            //         break;
            //       }
            //       case n==(actLength-1):{
            //         if(endTime<itm.startTime&&endTime!=''&&lastState){
            //           $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //           $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //           proSelObj.push(item);
            //           return false;
            //         }else if(startTime>itm.endTime&&startTime!=''){
            //           $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //           $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //           proSelObj.push(item);
            //           return false;
            //         }else{
            //           $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
            //           return false;
            //         }
            //         break;
            //       }
            //     }
            //     console.log(lastState)
            //   })
            // }else{
            //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //   proSelObj.push(item);
            // }

            $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            proSelObj.push(item);

            // if(item.startTime!=undefined&&item.endTime!=undefined){
            //   console.log(item.endTime<startTime)
            //   console.log(item.startTime>endTime)
            //   if(item.startTime>endTime&&endTime!=''){
            //     $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //     $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //     proSelObj.push(item);
            //   }else if(item.endTime<startTime&&startTime!=''){
            //     $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //     $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //     proSelObj.push(item);
            //   }else if(startTime==''&&endTime==''){
            //     $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //     $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //     proSelObj.push(item);
            //   }else{
            //     // stateTime = false;
            //     $.Toast("提示", "商品:"+item.id+",在其他活动优惠中，请重新选择", "notice", {});
            //     return false;
            //   }
            // }else{
            //   $('.service-select-modal .main-con .service-select').append('<li><span class="title">'+$(ev).parents('tr').find('.title').text()+'</span><a href="javascript:void(0)"class="service-select-remove" data-selectnum="'+selectID+'" onclick="serviceSelectRemove(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
            //   $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
            //   proSelObj.push(item);
            // }





            return false;
          }
        });
      });
    }
  }

  //店员管理-新增店员-删除已选服务项目
  function serviceRemove(ev){
    var selectID = $(ev).siblings().data('serviceid')||$(ev).parents('tr').attr('data-id');
    var $parent = $(ev).parents('[data-parent=proBox]');
    var $target = $parent.find('[data-target=proBox]');
    var parentStyle = $parent.data('prostyle');
    switch(parentStyle){
      case 'proSel':{
        if($(ev).parents('ul').children().length==1){
          $.Toast("提示", "至少保留1个商品！", "notice", {});
        }else{
          var dataId = $(ev).parents('.edit-box').data('id');
          // var styleDiySel = LMData.prototype.findJson(layoutModalSelect,dataId,'stylediy');
          // var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          var elementSel = LMData.prototype.findJson(layoutModalSelect,dataId,'elementSel');
          
          $.each(productSel,function(i,item){
            if(item.id==selectID){
              productSel.splice(i,1);//delete
              return false;
            }
          });
          $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').html('');
          $.each(productSel,function(i,items){
            var tabHtml = '';
            // $.each(items.tab,function(idx,item){
            //   tabHtml += '<span>'+item+'</span>'
            // });
            $('#layout_show').find('li[data-id="'+dataId+'"]').find('.lay_customgoods').append('<div class="clum"><div class="imgbox"><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div><div class="msg"><span class="name"data-editid="name"data-state="'+elementSel.name+'">'+items.name+'</span><div class="msg-bottom"><div class="price-box"><span class="price"data-editid="price"data-state="'+elementSel.price+'">'+items.price+'</span><span class="price-ex"data-editid="priceEx"data-state="'+elementSel.priceEx+'">'+items.priceEx+'</span></div><div class="vip"data-editid="priceVip"data-state="'+elementSel.priceVip+'"><span>会员价</span><span>'+items.priceVip+'</span></div></div></div></div>');
          });
          LMData.prototype.imgManage('#layout_show');
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',productSel);

          $(ev).parent().remove();
        }
        break;
      }
      case 'couponsSel':
      case 'comActSel':{
        if(!$(ev).hasClass('disabled')){
          if($(ev).parents('tbody').children('tr').length-1<1){
            // $.Toast("提示", "至少保留1个商品！", "notice", {});
            $target.hide();
          }
            $(ev).parents('tr').remove();
            
            $.each(productSel,function(i,item){
              if(item.id==selectID){
                productSel.splice(i,1);//delete
                return false;
              }
            });
          // }
        }
        break;
      }
      default:{
        $.each(productSel,function(i,item){
          if(item.id==selectID){
            productSel.splice(i,1);//delete
            return false;
          }
        });
        $(ev).parent().remove();
        break;
      }
    }
    console.log(productSel)
  }


  //店员管理-新增店员-删除已选服务
  function serviceSelectRemove(ev){
    var selectNum = $(ev).data('selectnum');
    $(ev).parent().remove();
    $('.service-select-modal .main-table tbody tr').each(function(){
      if($(this).data('id')==selectNum){
        serviceState($(this).find('.service-state'));
        return false;
      }
    });
  }
  // function serviceState(ev){
  //   if($(ev).hasClass('action')){
  //     //移除
  //     $(ev).removeClass('action').children().removeClass('label-danger').addClass('label-success').text('添加');
  //   }else{
  //     //添加
  //     $(ev).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
  //   }
  // }
//产品库----end----------------------------------------------------------------

/*视频库-S-----------------------------------------------*/
//翻页回调函数
function pageNavCallBack_video(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_video);
  videoPageShow(pageJson,clickPage,pageDisplayWx);
}
function videoLibrary(ev){
  $('body').append('<div class="modal fade bs-example-modal-lg video-lib"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择视频</h4></div><div class="modal-body clearit main-con"><ul class="nav nav-tabs icon-lib-control"role="tablist"><li role="presentation"><a href="#iconLibrary"aria-controls="iconLibrary"role="tab"data-toggle="tab">我的视频</a></li><li role="presentation"class="active"><a href="#onlineup"aria-controls="onlineup"role="tab"data-toggle="tab">本地上传</a></li></ul><div class="tab-content"><div role="tabpanel"class="tab-pane icon_section"id="iconLibrary"><ul class="nav-contral clearit"role="tablist"><li><input type="text"class="right-input search-input"placeholder="请输入微信号"><a href="javascript:;"class="search-input-remove"onclick="clearSearch(this)"><i class="glyphicon glyphicon-remove"></i></a></li><li><input type="submit"class="right-input search-input-btn btn"value="搜索"></li></ul><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th colspan="2">视频名称</th><th>时长</th><th>大小</th><th>上传时间</th><th>预览</th><th>操作</th></tr></thead><tbody></tbody><tfoot><tr><td colspan="9"style="text-align: left;"class="tfoot-control"><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div><!--<div class="icon-show"><ul class="icon-main clearit"></ul></div>--></div><div role="tabpanel"class="tab-pane active image_section"id="onlineup"><div class="form-group fileinput_box "><label class="control-label col-xs-6 col-sm-4"><span class="text-title">本地视频</span><span class="text-danger2">:</span></label><div class="input_box"><div class="file-loading"><input id="video_fileinput"type="file"data-min-file-count="1"></div></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">名称</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><div class="input-group min-input"><input class="control-input"type="number"autocomplete="off"value=""></div></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">封面图</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><ul class="pro-img"data-maxvalue="1"></ul><a href="javascript:;"class="pro-img-add"onclick="iconLibrary(this)"data-laymodal="product_img"data-toggle="modal"data-target=".icon-lib"><img src="images/default_add.png"ondragstart="return false"alt=""title=""></a><div class="clearit"></div><span class="control-tips">建议尺寸：750 x 750像素，支持jpg、gif、png三种格式，大小不超过3 MB。如果不添加封面，系统会默认截取视频的第一个画面作为封面</span></div></div></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary disabled">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
  videoFtnPart();

  // $("#video_fileinput").on("filecleared",function(event, data, msg){
  //   console.log(123)
  // });
  var obj = iconAll(productList);
  console.log(obj)
  videoPageShow(obj,1,pageDisplayWx);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplayWx);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_video);
  obj=[];

  $('.modal').on('hidden.bs.modal', function () {
    // proJsonSave(ev);
    $(this).remove();
  });

  //输入框
  $('.video-lib .search-input').on('keyup', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).val());
    if(value!=''){
      $('.search-input-remove').show();
    }else{
      $('.search-input-remove').hide();
    }
  });

  //搜索
  var resultJson = [];
  $('.video-lib .search-input-btn').on('click', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).parent().siblings().children('input').val());
    $.each(iconAll(productList),function(i,item){
      if(item.name.indexOf(value) != -1){
        resultJson.push(item);
      }
    });
    if(resultJson == ''){
      $('.video-lib .main-table tbody').html('<tr class="data-empty"><td colspan="4"></td></tr>');
    }else{
      videoPageShow(resultJson,1,pageDisplayWx);
      var pageNavObj = null;//用于储存分页对象
      pageCou = Math.ceil(resultJson.length/pageDisplayWx);
      pageJson = resultJson;
      pageNavObj = new PageNavCreate("PageNavId",{
            pageCount:pageCou, 
            currentPage:1, 
            perPageNum:5, 
      });
      pageNavObj.afterClick(pageNavCallBack_wx);
      resultJson=[];
    }

  });


}

//每页输出
function videoPageShow(pageJson,clickPage,pageDisplay){
  $('.main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');
  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){
        //未添加
        // var vSize = items.size>1024?parseFloat(items.size/1024).toFixed(2):items.size;
        // vSize = items.size>1024?vSize+'Mb':vSize+'Kb';
        
        var vSize = parseFloat(items.size/1024).toFixed(2)+'Mb';
        $('.main-table tbody').append('<tr data-id="'+items.id+'" data-classfiyid="'+items.cla_id+'"><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td>'+items.length+'</td><td>'+vSize+'</td><td>'+items.time+'</td><td><a href="'+items.link+'"target="_blank">查看</a></td><td><button type="button"class="service-state clerk-btn"><span class="label label-success">添加</span></button></td></tr>');
      // }
      //清除全选状态
      $(".main-table .selectAll").attr('checked',false);
      $(".main-table .selectAll").parent().removeClass("selected");
    }
  });
  
  //添加已经选择的服务1
  $('.service-state').click(function(){
    // var selectNum = $(this).parents('tr').data('id');

    wxState(this);

    proJsonSave('.service-section',productSel);
    $(this).parents(".modal").modal("hide");
  });

}
/*视频库-E-----------------------------------------------*/

/*布局排版-E-----------------------------------------------*/
/*运费模板----start----------------------------------------------------------------*/
function saveFreight(){
  freightSel.name = $('.freight-con').find('.freight-name').val();
  freightSel.default.styleid = $('.freight-con .pro-oneormore input:checked').attr('data-styleid');
  freightSel.default.first_weight = $('.freight-con .yunfei-table tbody').children('#default').find('.first_weight').val();
  freightSel.default.first_price = $('.freight-con .yunfei-table tbody').children('#default').find('.first_price').val();
  freightSel.default.second_weight = $('.freight-con .yunfei-table tbody').children('#default').find('.second_weight').val();
  freightSel.default.second_price = $('.freight-con .yunfei-table tbody').children('#default').find('.second_price').val();

  $.each(freightSel.rules,function(i,item){
      item.mode.first_weight = $('.freight-con .yunfei-table tbody').children('#'+item.id).find('.first_weight').val();
      item.mode.first_price = $('.freight-con .yunfei-table tbody').children('#'+item.id).find('.first_price').val();
      item.mode.second_weight = $('.freight-con .yunfei-table tbody').children('#'+item.id).find('.second_weight').val();
      item.mode.second_price = $('.freight-con .yunfei-table tbody').children('#'+item.id).find('.second_price').val();
  });
}
function addFreight(ev){
  var $this=$(ev);
  var dataId = Date.parse(new Date());
  $this.parents('tfoot').siblings('tbody').append('<tr id="'+dataId+'"><td class="yf-tab-3"><div class="yunfei-address">未添加地区</div><div class="yunfei-control"><button class="yunfei-edit label label-primary btn"type="button"onclick="freight(this)"data-toggle="modal"data-target=".modal-freight"><i class="iconfont icon-bianji"></i></button><button class="yunfei-remove label label-danger btn"type="button"onclick="delFreight(this)"><i class="iconfont icon-shanchu"></i></button></div></td><td class="yf-tab-4"><input class="control-input first_weight"type="text"autocomplete="off"placeholder="请输入首件重量"></td><td class="yf-tab-4"><input class="control-input first_price"type="text"autocomplete="off"placeholder="请输入首费"></td><td class="yf-tab-4"><input class="control-input second_weight"type="text"autocomplete="off"placeholder="请输入续件重量"></td><td class="yf-tab-4"><input class="control-input second_price"type="text"autocomplete="off"placeholder="请输入续费"></td></tr>');
  var obj={};
  obj['id'] = dataId;
  obj['area'] = [];
  obj['mode'] = {
    first_weight:"",
    first_price:"",
    second_weight:"",
    second_price:""
  };
  freightSel.rules.push(obj);
  console.log(freightSel)
}
function delFreight(ev){
  var $this = $(ev);
  var dataId = $this.parents('tr').attr('id');
  $.each(freightSel.rules,function(i,item){
    if(dataId == item.id){
      freightSel.rules.splice(i,1);
      return false;
    }
  });
  $this.parents('tr').remove();
}
function freight(ev){
  var $this = $(ev);
  var dataId = $this.parents('tr').attr('id');
  $('body').append('<div class="modal fade bs-example-modal-lg modal-freight"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择区域</h4></div><div class="modal-body clearit"><ul class="freight-ul col-xs-10 col-xs-offset-1"></ul></div><div class="modal-footer"><button type="button"class="btn btn-primary">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  // $('.modal-freight .freight-ul').html('');
  /*陈列已选数组 */
  var selArea = [],selAreaAll = [];
  $.each(freightSel.rules,function(i,item){
    if(dataId == item.id){
      selArea = item.area;
    }
    selAreaAll = selAreaAll.concat(item.area);
  });
  console.log(selAreaAll)
  var newList={};
  var newProvList=[];
  $.each(freightList,function(idx,items){
    // console.log(items)
    if(items.level=='1'){
      newList[items.id]=[];
      newProvList.push(items);
    }else{
      newList[items.parentId].push(items);
    }
  });
  /*展开已选数组中-全省数据 */
  $.each(newProvList,function(idx,items){
    $.each(selAreaAll,function(i,item){
      if(item == items.name){
        var spreadList=[]
        selAreaAll.splice(i,1);
        $.each(newList[items.id],function(n,itemx){
          spreadList.push(itemx.name);
        });
        selAreaAll = selAreaAll.concat(spreadList);
      }
    });
    $.each(selArea,function(i,item){
      if(item == items.name){
        var spreadList=[]
        selArea.splice(i,1);
        $.each(newList[items.id],function(n,itemx){
          spreadList.push(itemx.name);
        });
        selArea = selArea.concat(spreadList);
      }
    });
  });
  console.log(newList)
  console.log(selArea)
  $.each(newList,function(idx,items){
    var cityCon = '',checkAll = true,checked = false,checkNum=0,checkHasArea = false;
    $.each(items,function(i,item){
      var labelClassName = '',inputClassName = '';
      
      var hasArea = false;
      if(selArea.indexOf(item.name)!='-1'){/*是否在当前数组*/
        hasArea = true;
      }else{
        if(selAreaAll.indexOf(item.name)=='-1'){/*是否在全部已选数组*/
          item.state = true;
        }else{
          item.state = false;
        }
      }
      if(hasArea){
        /*激活已选*/
        labelClassName = 'selected',inputClassName = 'checked';
        checkHasArea = true;
        checked = true;
        checkNum ++;
      }else{
        if(item.state){
          /*激活未选 */
          checkAll = false;
        }else{
          /*禁选 */
          labelClassName = 'disabled selected',inputClassName = 'disabled checked';
          checked = true;
          checkNum ++;
        }
      }

      cityCon +='<label class="freight-label '+labelClassName+'">'+
                  '<input class="selct-checkbox" type="checkbox" data-multlevel="city" '+inputClassName+' name="area" value="">'+
                  '<span>'+item.name+'</span>'+
                '</label>';
    });
    var city = '<div class="city" data-mult_city>'+cityCon+'</div>';

    var labelClassName = '',inputClassName = '';
    if(checked){
      if(checkAll){
        if(checkHasArea){
          labelClassName = 'selected';
          inputClassName = 'checked';
        }else{
          labelClassName = 'disabled selected';
          inputClassName = 'disabled checked';
        }
      }else{
        labelClassName = 'notall';
        inputClassName = '';
      }
    }
    var provName;
    $.each(newProvList,function(i,item){
      if(idx==item.id){
        provName = item.name
        return false;
      }
    });
    var numshow='';
    if(checkNum>0){
      numshow = ' numshow';
    }
    var prov ='<div class="prov" data-mult_provlabel>'+
                '<label class="freight-label '+labelClassName+'">'+
                  '<input class="selct-checkbox" type="checkbox" data-multlevel="prov" '+inputClassName+' name="area" value="">'+
                  '<span class="area-name">'+provName+'</span>'+
                  '<span class="area-num'+numshow+'">('+checkNum+')</span>'+
                '</label>'+
              '</div>';

    var html = '<li class="freight-item" data-mult_prov>'+prov+city+'</li>';
    $('.modal-freight .freight-ul').append(html);
    
  });
  // console.log(freightList)
  
  $(".freight-label .selct-checkbox").click(function(){
    if($(this).parent().hasClass("selected")){
      $(this).parent().removeClass("selected");
    }else{
      $(this).parent().addClass("selected");
    }
    multDD_checkClick(this);
  });
  /*模态框-保持点击 */
  $(".modal-freight .btn-primary").click(function(){
    var newSelArea = [];
    $(".modal-freight .freight-ul .freight-item").each(function(){
      var newSelArea_li = [];
      var parThis = this;
      if($(parThis).children('.prov').children().hasClass('notall')||$(parThis).children('.prov').children().hasClass('selected')){
        var noDisabled = true,unCheck = true;
        // console.log($(parThis))
        $(parThis).children('.city').children('.freight-label').each(function(){
          
          if($(this).children('input').prop('checked')==true){
            if($(this).children('input').prop('disabled')==false){
              newSelArea_li.push($(this).children('span').text());
            }else{
              noDisabled = false;
            }
          }else{
            unCheck = false;
          }
        });
        if(noDisabled&&unCheck){
          newSelArea_li = $(parThis).children('.prov').find('.area-name').text();
          newSelArea.push(newSelArea_li);
        }else{
          newSelArea = newSelArea.concat(newSelArea_li);
        }
      }
    });
    $.each(freightSel.rules,function(i,item){
      if(dataId == item.id){
        item.area = newSelArea;
        return false;
      }
    });
    newSelArea=newSelArea.join(",");
    $this.parent().siblings('.yunfei-address').text(newSelArea);

    console.log(freightSel.rules)

    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
/*运费--检查点击 */
function multDD_checkClick(ev){
  var multlevel = $(ev).attr('data-multlevel');
  var $target;
  var $targetSib;
  switch(multlevel){
    case 'prov':{/*全部市 */
      
      var $child = $(ev).parents('[data-mult_provlabel]').siblings('[data-mult_city]').find('.freight-label:not(.disabled)');
      if($(ev).prop('checked')){
        $child.addClass("selected").children('input').prop('checked',true);
      }else{
        $child.children('input').prop('checked',false);
        $child.removeClass("selected");
        $child.removeClass("notall");
        console.log(123)
      }

      $target = $(ev).parents('[data-mult_provlabel]').siblings('[data-mult_city]');
      $targetSib = $(ev).parents('[data-mult_provlabel]');
      getNotall_check($target,$targetSib);
      break;
    }
    case 'city':{/*全部区 */

      /*是否有区 */
      if($(ev).parents('[data-mult_citylabel]').siblings('[data-mult_district]').length==1){
        var $child = $(ev).parents('[data-mult_citylabel]').siblings('[data-mult_district]').find('.freight-label:not(.disabled)');
        if($(ev).prop('checked')){
          $child.addClass("selected").children('input').prop('checked',true);
        }else{
          $(ev).parent().removeClass("notall");
          $child.removeClass("selected").children('input').prop('checked',false);
        }
      }
      $target = $(ev).parents('[data-mult_city]');
      $targetSib = $(ev).parents('[data-mult_city]').siblings('[data-mult_provlabel]');
      
      getNotall_check($target,$targetSib);
      break;
    }
    case 'dist':{

      $target = $(ev).parents('[data-mult_district]');
      $targetSib = $(ev).parents('[data-mult_district]').siblings('[data-mult_citylabel]');
      
      getNotall_check($target,$targetSib);

      var $parent = $(ev).parents('[data-mult_city]');
      var $parentSib = $(ev).parents('[data-mult_city]').siblings('[data-mult_provlabel]');
      getNotall_check($parent,$parentSib);
      break;
    }
  }
}
function getNotall_check($target,$targetSib){
  var hasClick=false,allClick=true,clickNum=0;
  $target.find('input[type=checkbox]').each(function(){
    console.log($(this).prop('checked'))
    if($(this).prop('checked')){
      hasClick=true;
      clickNum++;
    }else{
      allClick=false;
    }
  });
  if(hasClick){/*是否点击 */
    $targetSib.children().addClass('notall');
    $targetSib.find('.area-num').addClass('numshow').text('('+clickNum+')');
  }else{
    $targetSib.children().removeClass('notall');
    $targetSib.find('.area-num').removeClass('numshow');
  }
  if($target.find('input[type=checkbox]').length>0){
    if(allClick){
      $targetSib.children().addClass('selected').children('input').prop('checked',true);
    }else{
      $targetSib.children().removeClass('selected').children('input').prop('checked',false);
    }
  }
}

/*运费模板----end----------------------------------------------------------------*/

/*全选检测-弹窗*/
function checkboxCheck(){
  var checkedNum = 0;
  var checkLength=$(".main-table .selct-checkbox:not([disabled])").length;
  $(".main-table .selct-checkbox").each(function(){
    if($(this).parent().hasClass("selected")){
      checkedNum++;
    }
  });
  if(checkLength==checkedNum){
    $(".main-table .selectAll").prop('checked',true).parent().addClass("selected");
  }else if(checkedNum==0){
    $(".main-table .selectAll").prop('checked',false).parent().removeClass("selected").removeClass("notall");
  }else{
    $(".main-table .selectAll").prop('checked',false).parent().addClass("notall").removeClass("selected");
  }
  // console.log(checkedNum)
}

//计算规格组方案数
function doExchange(arr){
  var len = arr.length;
  // 当数组大于等于2个的时候
  if(len >= 2){
      // 第一个数组的长度
      var len1 = arr[0].length;
      // 第二个数组的长度
      var len2 = arr[1].length;
      // 2个数组产生的组合数
      var lenBoth = len1 * len2;
      //  申明一个新数组,做数据暂存
      var items = new Array(lenBoth);
      // 申明新数组的索引
      var index = 0;
      // 2层嵌套循环,将组合放到新数组中
      for(var i=0; i<len1; i++){
          for(var j=0; j<len2; j++){
              items[index] = arr[0][i] +","+ arr[1][j];
              index++;
          }
      }
      // 将新组合的数组并到原数组中
      var newArr = new Array(len -1);
      for(var i=2;i<arr.length;i++){
          newArr[i-1] = arr[i];
      }
      newArr[0] = items;
      // 执行回调
      return doExchange(newArr);
  }else{
      return arr[0];
  }
}
//商品管理-编辑商品-添加规格值
var specArr=[];/*收集各规格组数据 */
var spec_sort=new Array();/*记录添加的规格组规格名 */
var specArrTable=[];/*记录各规格组的各种方案 */
var specExArrTable=[];/*记录各规格组的各种方案 */
function addOption(ev){
  // specArr=[],spec_sort=[],specExArrTable=[];
  $(ev).parents('.spec-box').addClass('active');
  
  var name = $(ev).siblings('input').val();
  name=name.replace(/\\|\//g,'');//顶替斜杠为空字符
  name = $.trim(name);//删除空格符
  console.log(name)
  if(name==""){
    $.Toast("提示", "内容不能为空！", "notice", {});
    return false;
  }

    
  //control-添加选项
  $(ev).parents('.option-add').before('<li><span class="name">'+name+'</span><a href="javascript:void(0);" class="btn option-remove" onclick="deleteConfirm(this)"><i class="glyphicon glyphicon-remove"></i></a></li>');
  $(ev).siblings('input').val('');

  
  madeTable();

  // $(ev).parents('.pro-more-spec').children('.active').each(function(i){
  //   var obj=new Array();
  //   var tit = $(this).find('.title').find('h5').text();
  //   spec_sort.push(tit);

  //   $(this).children('.option').children('li').each(function(i){
  //     obj[i]= $(this).children('.name').text();
  //   });
  //   specArr.push(obj);
  // });
  // console.log(specArr)
  // console.log(doExchange(specArr))
  // specArrTable = doExchange(specArr);

  
  if($(ev).parents('.spec-box').children('ul.option').children('li').length>0){
    // $('.pro-more-showbox .pro-more-alert').hide();
    $('.pro-more-showbox .pro-more-table').show();
  }

  // //打印表头表尾
  // var list="";
  // for (var i = 0; i < spec_sort.length; i++) {
  //   list +='<th class="spec">'+spec_sort[i]+'</th>';
  // };
  // $('.pro-more-table thead tr .spec').remove();
  // $('.pro-more-table thead tr .th_img').before(list);
  // var footlist=spec_sort.length?'<td class="foot_td" colspan="'+spec_sort.length+'"></td>':'';
  // $('.pro-more-table tfoot tr .foot_td').remove();
  // $('.pro-more-table tfoot tr .min-img-all').before(footlist);

  // //记录表内容-读取
  // $('.pro-more-table tbody tr').each(function(){
  //   var obj={};
  //   obj['id']=$(this).attr('id');
  //   // obj['img']=$(this).find('.min-img').children().prop('src');
  //   obj['price']=$(this).find('.price').children().val();
  //   obj['stock']=$(this).find('.stock').children().val();
  //   obj['code']=$(this).find('.code').children().val();
  //   obj['barcode']=$(this).find('.code').children().val();
  //   if(obj['price']==''&&obj['stock']==''&&obj['code']==''){
  //     return true;//跳出本次循环
  //   }else{
  //     specExArrTable.push(obj);
  //   }
  // });
  // console.log(specExArrTable)
  // //打印表内容
  // $('.pro-more-table tbody').html('');
  // $.each(specArrTable,function(i,item){
  //   var list_tbody='';
  //   var arr=item.split(',');
  //   var arrid=arr.join('-');
  //   console.log("item:"+item)
  //   console.log("arrid"+arrid)
  //   for (var i = 0; i < arr.length; i++) {
  //     list_tbody +='<td>'+arr[i]+'</td>';
  //   };
  //   $('.pro-more-table tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="min-img"><img src="" ondragstart="return false" alt="" title=""></td><td class="price"><input type="number" class="control-input"></td><td class="stock"><input type="number" class="control-input"></td><td class="code"><input type="number" class="control-input"></td><td class="barcode"><input type="number" class="control-input"></td></tr>');
  // });
  
  // //合并新建的行
  // for (var i = 0; i < spec_sort.length; i++) {
  //   $(".pro-more-table tbody").rowspan(i);
  // };

  // //记录表内容-设置
  // if(!specExArrTable.length=='0'){
  //   $.each(specExArrTable,function(idx,item){
  //     var Otr=$('.pro-more-table tbody').children('#'+item['id']);
  //     Otr.find('.price').children().val(item['price']);
  //     Otr.find('.stock').children().val(item['stock']);
  //     Otr.find('.code').children().val(item['code']);
  //     Otr.find('.barcode').children().val(item['barcode']);
  //   })
  // }


}
/*批量设置*/
function batchSet(ev){
  var name = $(ev).siblings('input').val();
  var address = $(ev).attr('data-editid');
  name=name.replace(/\\|\//g,'');//顶替斜杠为空字符
  name = $.trim(name);//删除空格符
  console.log(name)
  if(name==""){
    $.Toast("提示", "内容不能为空！", "notice", {});
    return false;
  }
  $(".pro-more-table tbody tr").find('.'+address).children().val(name);
}
//表格合并单元格，colIdx要合并的列序号，从0开始  
$.fn.extend({
  "rowspan": function (colIdx) {  
      return this.each(function () {  
          var that;  
          $('tr', this).each(function (row) {  
              $('td:eq(' + colIdx + ')', this).filter(':visible').each(function (col) {  
                  if (that != null && $(this).html() == $(that).html()) {  
                      rowspan = $(that).attr("rowSpan");  
                      if (rowspan == undefined) {  
                          $(that).attr("rowSpan", 1);  
                          rowspan = $(that).attr("rowSpan");  
                      }  
                      rowspan = Number(rowspan) + 1;  
                      $(that).attr("rowSpan", rowspan);  
                      $(this).hide();  
                  } else {  
                      that = this;  
                  }  
              });  
          });  
      });  
  }
}); 

//排序
function sortNumber(a,b){
  return a.id - b.id;
}
//商品管理-编辑商品-删除规格值***
function deleteConfirm(ev){
  $(ev).toggleClass('action');
  
  $('.confirm_box').remove();
  // if($(ev).hasClass('action')){
    $(ev).after('<div class="confirm_box">确定删除？<div class="control"><a href="javasctipt:void(0);"class="btn control-save">確定</a><a href="javasctipt:void(0);"class="btn control-cancel">取消</a></div></div>');
  
    $(ev).siblings('.confirm_box').find('.control-save').click(function(){
      deleteOption(ev);
    });
  
    $(ev).siblings('.confirm_box').find('.control-cancel').click(function(){
      $(ev).removeClass('action').siblings('.confirm_box').remove();
    });
  
}
function deleteOption(ev){

  // specArr=[],spec_sort=[];
  // $(ev).parents('.spec-box').addClass('active');

  $(ev).parent().remove();
  //control-添加选项
  madeTable();
  // $('.pro-more-spec').children('.active').each(function(i){
  //   var obj=new Array();
  //   var $this=$(this);

  //   var tit = $this.find('.title').find('h5').text();

  //   $this.children('.option').children('li').each(function(i){
  //     obj[i]= $(this).children('.name').text();
  //   });
  //   /*判断非空数组-才录入数据 */
  //   if(JSON.stringify(obj) !== '[]'){
  //     spec_sort.push(tit);
  //     specArr.push(obj);
  //   }
  // });
  // console.log(specArr)
  // console.log(doExchange(specArr))
  // specArrTable = doExchange(specArr);

  // //打印
  // var list="";
  // for (var i = 0; i < spec_sort.length; i++) {
  //   list +='<th class="spec">'+spec_sort[i]+'</th>';
  // };
  // $('.pro-more-table thead tr .spec').remove();
  // $('.pro-more-table thead tr .th_img').before(list);
  // var footlist=spec_sort.length?'<td class="foot_td" colspan="'+spec_sort.length+'"></td>':'';
  // $('.pro-more-table tfoot tr .foot_td').remove();
  // $('.pro-more-table tfoot tr .min-img-all').before(footlist);

  
  // $('.pro-more-table tbody').html('');
  // $.each(specArrTable,function(i,item){
  //   var list_tbody='';
  //   var arr=item.split(',');
  //   var arrid=arr.join('-');
  //   console.log("item:"+item)
  //   console.log("arrid"+arrid)
  //   for (var i = 0; i < arr.length; i++) {
  //     list_tbody +='<td>'+arr[i]+'</td>';
  //   };
  //   $('.pro-more-table tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="min-img"><img src="" ondragstart="return false" alt="" title=""></td><td class="price"><input type="number" class="control-input"></td><td class="stock"><input type="number" class="control-input"></td><td class="code"><input type="number" class="control-input"></td><td class="barcode"><input type="number" class="control-input"></td></tr>');
  // });
  
  // //合并新建的行
  // for (var i = 0; i < spec_sort.length; i++) {
  //   $(".pro-more-table tbody").rowspan(i);
  // };

}

//商品管理-编辑商品-删除规格***
function specRemove(ev){
  var that= ev;
  var name = $(ev).siblings('h5').text();

  $('body').append("<div class='modal fade bs-example-modal-sm spec-remove'tabindex='-1'role='dialog'aria-labelledby='mySmallModalLabel'><div class='modal-dialog modal-sm'role='document'><div class='modal-content'><div class='modal-header'><button type='button'class='close'data-dismiss='modal'aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title'id='myModalLabel'>提示</h4></div><div class='modal-body'>确定要删除"+name+"？</div><div class='modal-footer'><button type='button'class='btn btn-primary'>确定</button><button type='button'class='btn btn-default'data-dismiss='modal'>取消</button></div></div></div></div>");

  //点击确认
  $(".spec-remove .btn-primary").click(function(){
    $(that).parents('.spec-box').remove();
    $(this).parents(".modal").modal("hide");
    
    if($('.pro-more-spec .spec-box').length==0){
      // $('.pro-more-showbox .pro-more-alert').show();
      $('.shangpin-price').attr('readonly',false).parent().removeClass('not_editable');
      $('.shangpin-inventory').attr('readonly',false).parent().removeClass('not_editable');
      $('.shangpin-code').attr('readonly',false).parent().removeClass('not_editable');
      $('.pro-more-showbox .pro-more-table').hide();
    }else{
      // $('.pro-more-showbox .pro-more-alert').hide();
      $('.pro-more-showbox .pro-more-table').show();
      madeTable();
    }
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}

//商品管理-编辑商品-读取规格名称
function readSpecName(ev){
  $('.spec-box .reset-box').hide();
  $(ev).toggleClass('action');
  $(ev).siblings('.reset-box').show().children('input').val($(ev).siblings('h5').text());
}
//商品管理-编辑商品-修改规格名称-保存
function specNameSave(ev){
  var name = $(ev).parent().siblings().val();
  name = $.trim(name);
  if(name!==''){
    var idx=$(ev).parents('.active').index();
    if(idx>=0){
      $('.pro-more-table thead tr').children().eq(idx).text(name);
    }
    $(ev).parents('.title').children('h5').text(name);
    specNameCancel(ev);
  }else{
    $.Toast("提示", "请输入有效字符", "notice", {});
  }
}
//商品管理-编辑商品-修改规格名称-取消
function specNameCancel(ev){
  $(ev).parents('.title').children('.btn-set').removeClass('action');
  $(ev).parents('.reset-box').hide();
}
/*商品管理-编辑商品-多规格-制造表格 */
function madeTable(){
  specArr=[],spec_sort=[],specExArrTable=[];

  $('.pro-more-spec').children('.active').each(function(i){
    var obj=new Array();
    var tit = $(this).find('.title').find('h5').text();

    $(this).children('.option').children('li').each(function(i){
      obj[i]= $(this).children('.name').text();
    });
    /*判断非空数组-才录入数据 */
    if(JSON.stringify(obj) !== '[]'){
      spec_sort.push(tit);
      specArr.push(obj);
    }
  });
  console.log(specArr)
  console.log(doExchange(specArr))
  specArrTable = doExchange(specArr);

  //打印表头表尾
  var list="";
  for (var i = 0; i < spec_sort.length; i++) {
    list +='<th class="spec">'+spec_sort[i]+'</th>';
  };
  $('.pro-more-table thead tr .spec').remove();
  $('.pro-more-table thead tr .th_img').before(list);
  var footlist=spec_sort.length?'<td class="foot_td" colspan="'+spec_sort.length+'">批量设置</td>':'';
  $('.pro-more-table tfoot tr .foot_td').remove();
  $('.pro-more-table tfoot tr .min-img-all').before(footlist);

  //记录表内容-读取
  $('.pro-more-table tbody tr').each(function(){
    var obj={};
    obj['id']=$(this).attr('id');
    // obj['img']=$(this).find('.min-img').children().prop('src');
    obj['price']=$(this).find('.price').children().val();
    obj['stock']=$(this).find('.stock').children().val();
    obj['code']=$(this).find('.code').children().val();
    obj['barcode']=$(this).find('.code').children().val();
    if(obj['price']==''&&obj['stock']==''&&obj['code']==''){
      return true;//跳出本次循环
    }else{
      specExArrTable.push(obj);
    }
  });
  console.log(specExArrTable)
  if(specArr!=''){

    //打印表内容
    $('.pro-more-table tbody').html('');
    $.each(specArrTable,function(i,item){
      var list_tbody='';
      var arr=item.split(',');
      var arrid=arr.join('-');
      console.log("item:"+item)
      console.log("arrid"+arrid)
      for (var i = 0; i < arr.length; i++) {
        list_tbody +='<td>'+arr[i]+'</td>';
      };
      $('.pro-more-table tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="min-img"><img src="" ondragstart="return false" alt="" title=""></td><td class="price"><input type="number" class="control-input"></td><td class="stock"><input type="number" class="control-input"></td><td class="code"><input type="number" class="control-input"></td><td class="barcode"><input type="number" class="control-input"></td></tr>');
    });
  }else{
    $('.pro-more-table').hide();
  }
  
  //合并新建的行
  for (var i = 0; i < spec_sort.length; i++) {
    $(".pro-more-table tbody").rowspan(i);
  };

  //记录表内容-设置
  if(!specExArrTable.length=='0'){
    $.each(specExArrTable,function(idx,item){
      var Otr=$('.pro-more-table tbody').children('#'+item['id']);
      Otr.find('.price').children().val(item['price']);
      Otr.find('.stock').children().val(item['stock']);
      Otr.find('.code').children().val(item['code']);
      Otr.find('.barcode').children().val(item['barcode']);
    })
  }

  //如已有规格-则锁定价格-库存修改
  if($('.shangpin-price').length>0){
    priceAndInventory(specArr);
  }

  //如已有规格-则生成按重量计算的运费模板
  if($('.pro_weight_group').length>0){
    console.log($('.radio_weight input:checked').attr('data-styleid'))
    console.log(specArrTable)
    $('.table_weight').html('');
    var weightTableDiv = $('<div></div>');
    weightTableDiv.addClass('main-table table-responsive table-condensed');
    $('.table_weight').append(weightTableDiv);
    var weightTable = $('<table></table>');
    weightTable.addClass('table table-bordered');
    weightTableDiv.append(weightTable);
    var list="";
    for (var i = 0; i < spec_sort.length; i++) {
      list +='<th class="spec">'+spec_sort[i]+'</th>';
    };
    list += '<th>重量</th>'
    var weightTableHead = $('<thead><tr>'+list+'</tr></thead>');
    weightTable.append(weightTableHead);
    var weightTableBody = $('<tbody></tbody>');
    weightTable.append(weightTableBody);

    $.each(specArrTable,function(i,item){
      var list_tbody='';
      var arr=item.split(',');
      var arrid=arr.join('-');
      console.log("item:"+item)
      console.log("arrid"+arrid)
      for (var i = 0; i < arr.length; i++) {
        list_tbody +='<td>'+arr[i]+'</td>';
      };
      $('.table_weight tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="weight"><div class="input-group min-input"><input class="control-input" type="number" autocomplete="off" value="" onkeyup="decimalPoint(this)" style="width:100px;height:29px;margin:0;"><span class="input-group-addon" style="line-height:15px;">Kg</span></div></td></tr>');
    });

      //合并新建的行
    for (var i = 0; i < spec_sort.length; i++) {
      $('.table_weight tbody').rowspan(i);
    };

  }


}

/*检测是否--价格-库存-封存*/
function priceAndInventory(json){
  if(json!=''){
    $('.shangpin-price').attr('readonly',true).parent().addClass('not_editable');
    $('.shangpin-inventory').attr('readonly',true).parent().addClass('not_editable');
    $('.shangpin-code').attr('readonly',true).parent().addClass('not_editable');
    /*最小价格 */
    var obj=[];
    $(".pro-more-table tbody .price input").each(function (){
      obj.push($(this).val());
    });
    $('.shangpin-price').val(Math.min.apply(null,obj));
    
    $(".pro-more-table tbody .price input").keyup(function(){
      var obj=[];
      $(".pro-more-table tbody .price input").each(function (){
        obj.push($(this).val());
      });
      $('.shangpin-price').val(Math.min.apply(null,obj));
    });
    /*库存汇总 */
    var obj=0;
    $(".pro-more-table tbody .stock input").each(function (){
      if($(this).val()!=''){
        obj += parseInt($(this).val());
      }
    });
    $('.shangpin-inventory').val(obj);

    $(".pro-more-table tbody .stock input").keyup(function(){
      var obj=0;
      $(".pro-more-table tbody .stock input").each(function (){
        // obj.push($(this).val());
        if($(this).val()!=''){
          obj += parseInt($(this).val());
        }
      });
      $('.shangpin-inventory').val(obj);
    });
  }else{
    $('.shangpin-price').attr('readonly',false).parent().removeClass('not_editable');
    $('.shangpin-inventory').attr('readonly',false).parent().removeClass('not_editable');
    $('.shangpin-code').attr('readonly',false).parent().removeClass('not_editable');
  }
}



//经营地图-删除
function deleteimg(ev){
  $(ev).parents('ul').siblings('.pro-img-add').show();
  $(ev).parent().remove();
}

//经营地图-删除
function deleteit(ev){
  if(!$(ev).hasClass('disabled')){
    $(ev).parents('tr').remove();
  }
}

//时间段设置-读取模板
function settemplate(ev){
  var $BtUl=$(ev).parents('.bookingtime-con').find('.bookingtime-main').find('.tab-pane.active').find('.bookingtime-ul');
  var name=$(ev).data('templatejosn');
  console.log(templateJosn[name])
  $BtUl.html('');
  $.each(templateJosn[name],function(i,item){
    $BtUl.append('<li class="bt_li'+i+'"><div class="input-group input-large input-daterange"><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-str"value="'+item['strtime']+'"></div><div class="input-group"><span class="input-group-addon">至</span></div><div class="input-group"><input type="text"class="form-control control-input timepicker timepicker-end"value="'+item['endtime']+'"></div><div class="bt-set-box"><input class="control-input tostore"type="text"placeholder="到店预约人数"autocomplete="off"value="'+item['tostore']+'"></div><div class="bt-set-box"><input class="control-input todoor"type="text"placeholder="上门预约人数"autocomplete="off"value="'+item['todoor']+'"></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn"onclick="bookingtime_add(this)"><i class="glyphicon glyphicon-plus"></i></a></div><div class="bt-set-box"><a href="javascript:void(0);"class="bttn bttn-remove"onclick="bookingtime_remove(this)"><i class="glyphicon glyphicon-remove"></i></a></div></div></li>');
    bt_addtime('',i);
  });
}

//时间段设置-删除模板
function deletetemplate(ev){
  var name=$(ev).siblings().data('templatejosn');
  console.log(name)
  delete templateJosn[name];
  $(ev).parent().remove();
  console.log(templateJosn)
}


//删除魔方
function deleteTr(ev){
  $(ev).parents("tr").remove();
  changeMagicNum();
}
//魔方对应样式变改
function changeMagicNum(){
  var magicLength = $(".magic-con #sortable").children().length;
  switch (magicLength) {
    case 1:
    $(".magic-radio").html("");
    $(".magic-radio").append("<label class='selected'><input class='selct-checkbox'type='radio'name='member-sex'value='true'checked><div class='imgbox'><img src='images/magic1.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
      break;
    case 2:
    $(".magic-radio").html("");
    $(".magic-radio").append("<label class='selected'><input class='selct-checkbox'type='radio'name='member-sex'value='true'checked><div class='imgbox'><img src='images/magic2.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
    $(".magic-radio").append("<label class=''><input class='selct-checkbox'type='radio'name='member-sex'value='true'><div class='imgbox'><img src='images/magic2-1.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
      break;
    case 3:
    $(".magic-radio").html("");
    $(".magic-radio").append("<label class='selected'><input class='selct-checkbox'type='radio'name='member-sex'value='true'checked><div class='imgbox'><img src='images/magic3.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
    $(".magic-radio").append("<label class=''><input class='selct-checkbox'type='radio'name='member-sex'value='true'><div class='imgbox'><img src='images/magic3-1.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
      break;
    case 4:
    $(".magic-radio").html("");
    $(".magic-radio").append("<label class='selected'><input class='selct-checkbox'type='radio'name='member-sex'value='true'checked><div class='imgbox'><img src='images/magic4.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
    $(".magic-radio").append("<label class=''><input class='selct-checkbox'type='radio'name='member-sex'value='true'><div class='imgbox'><img src='images/magic4-2.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
    $(".magic-radio").append("<label class=''><input class='selct-checkbox'type='radio'name='member-sex'value='true'><div class='imgbox'><img src='images/magic4-1.jpg'ondragstart='return false'alt=''title=''></div><div class='border-left'></div><div class='border-bottom'></div><div class='border-top'></div><div class='border-right'></div></label>");
      break;
  }
  $(".magic-radio .selct-checkbox").click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
  });
  $('.magic-radio>label').each(function(){
    $(this).hover(function(){
      $(this).find('.border-left,.border-right').stop().animate({height:$(this).height()+'px'},400);
      $(this).find('.border-top,.border-bottom').stop().animate({width:$(this).width()+'px'},400);
    },function(){
      $(this).find('.border-left,.border-right').stop().animate({height:'0'},400);
      $(this).find('.border-top,.border-bottom').stop().animate({width:'0'},400);
    });
  });
}

/*推广海报图 -S---------------------------------------*/
function sharePosters(ev){

  $('body').append('<div class="modal fade bs-example-modal-lg share_posters-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择链接</h4></div><div class="modal-body clearit"data-parent><div class="layout-show"><div class="iphone"><div class="iphone-head"><h1></h1></div><div class="iphone-screen"><ul class="iphone-screen-box"data-target><img class="iphone-bg"src="images/poster.png"ondragstart="return false"alt=""title=""><div class="imgbox"><img src="images/poster-1.png"ondragstart="return false"alt=""title=""></div></ul></div></div></div><div class="control_part"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">海报背景图</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input"type="text"autocomplete="off"placeholder="推荐上传大小750×1200"></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">二维码宽度</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="slider code_width"data-edit="width"data-maxvalue="300"><div class="ui-slider-handle custom-handle"></div></div></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">二维码-距左宽度</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><!--<input class="control-input code_left"type="number"autocomplete="off"data-maxvalue="300"onkeyup="posterChange(this,&quot;left&quot;)">--><div class="slider code_left"data-edit="left"data-maxvalue="300"><div class="ui-slider-handle custom-handle"></div></div></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">二维码-距上高度</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="slider code_height"data-edit="top"data-maxvalue="482"><div class="ui-slider-handle custom-handle"></div></div></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
  

  //点击确认
  $(".modal .btn-confirm").click(function(){

    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

  var width = parseFloat(saveJson[0].width);
  var left = parseFloat(saveJson[0].left);
  var top = parseFloat(saveJson[0].top);
  $(".modal").find('[data-target]').children('.imgbox').css('width',width*300/750);
  $(".modal").find('[data-target]').children('.imgbox').css('top',top*300/750);
  $(".modal").find('[data-target]').children('.imgbox').css('left',left*482/1206);
  var codeWidth = width;
  $( ".code_width.slider" ).slider({
    value: width,
    max: 750,
    create: function() {
      $(this).children().text(width);
    },
    slide: function( event, ui ) {
      var target = $(this).data('edit');
      var thisVal = ui.value *300/750;
      $(this).children().text( ui.value );
      $(".modal").find('[data-target]').children('.imgbox').css(target,thisVal);
      codeWidth = ui.value;
      LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
      $( ".code_left.slider" ).slider({
        max: 750-codeWidth,
        create: function() {
          $(this).children().text( $( this ).slider( "value" ) );
        },
        slide: function( event, ui ) {
          var target = $(this).data('edit');
          var thisVal = ui.value *300/750;
          $(this).children().text( ui.value );
          $(".modal").find('[data-target]').children('.imgbox').css(target,thisVal);
          LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
        }
      });
      $( ".code_height.slider" ).slider({
        max: 1206-codeWidth,
        create: function() {
          $(this).children().text( $( this ).slider( "value" ) );
        },
        slide: function( event, ui ) {
          var target = $(this).data('edit');
          var thisVal = ui.value *482/1206;
          $(this).children().text( ui.value );
          $(".modal").find('[data-target]').children('.imgbox').css(target,thisVal);
          LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
        }
      });
    }
  });
  $( ".code_left.slider" ).slider({
    value: left,
    max: 750-codeWidth,
    create: function() {
      $(this).children().text(left);
    },
    slide: function( event, ui ) {
      var target = $(this).data('edit');
      var thisVal = ui.value *300/750;
      $(this).children().text( ui.value );
      $(".modal").find('[data-target]').children('.imgbox').css(target,thisVal);
      LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
    }
  });
  $( ".code_height.slider" ).slider({
    value: top,
    max: 1206-codeWidth,
    create: function() {
      $(this).children().text(top);
    },
    slide: function( event, ui ) {
      var target = $(this).data('edit');
      var thisVal = ui.value *482/1206;
      $(this).children().text( ui.value );
      $(".modal").find('[data-target]').children('.imgbox').css(target,thisVal);
      LMData.prototype.saveJson(saveJson,'posters',target,ui.value);
    }
  });

}

/*推广海报图 -E---------------------------------------*/

/*会员价 -S--------*/
function vipPrice(ev){
  
  $('body').append('<div class="modal fade bs-example-modal-lg vip-price"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">自定义会员价</h4></div><div class="modal-body clearit"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">商品名称</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><span class="pro_name name">商品名称</span></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">优惠方式</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><span class="name">指定价格</span></div></div><div class="pro-more-table  col-xs-12 row"><div class="main-table table-responsive table-condensed"><table class="table table-bordered"><thead><tr><th class="th_img">规格图片</th><th class="price">价格</th></tr></thead><tbody></tbody><tfoot><tr><td class="min-img-all"></td><td class="price"></td></tr></tfoot></table></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  $('.pro-more-table').show();

  $('.vip-price .pro_name').text($(ev).parents('tr').find('td.title').text());

  console.log(vipLevel)
  if(vipLevel==''){
    var vipLink = $(ev).attr('data-vipLink');
    $('.pro-more-table').hide();
    $('.pro-more-table').before('<div class="form-group col-xs-12 row">'+
          '<label class="control-label col-xs-6 col-sm-4"></label>'+
          '<div class="col-xs-6 col-sm-8 row">'+
            '<div class=" alert alert-info pro-more-alert" role="alert">点击<a href="'+vipLink+'" target="_blank" style="color:red">添加会员等级</a></div>'+
          '</div>');

  }

  var specArr=[],spec_sort=[],specExArr=[];

  spec_sort = specMsg;
  //打印表头表尾
  /*规格值 */
  var list="";
  $.each(spec_sort,function(idx,items){
    list+='<th class="spec">'+items.name+'</th>';
  });
  $('.pro-more-table thead tr .spec').remove();
  $('.pro-more-table thead tr .th_img').before(list);
  /*会员价 */
  list = '';
  $.each(vipLevel,function(idx,items){
    list+='<th class="level-price" data-id="'+items.id+'">'+items.name+'</th>';
  });
  $('.pro-more-table thead tr .price').after(list);
  var footlist=spec_sort.length?'<td class="foot_td" colspan="'+spec_sort.length+'">批量设置</td>':'';
  $('.pro-more-table tfoot tr .foot_td').remove();
  $('.pro-more-table tfoot tr .min-img-all').before(footlist);
  /*底部会员价-批量按钮*/
  list = '';
  $.each(vipLevel,function(idx,items){
    list+='<td>'+
        '<div class="input-group table-input">'+
            '<input type="number" class="control-input">'+
            '<a index="1" href="javascript:" class="btn input-group-addon add-attr-btn" data-editid="price-'+items.id+'" onclick="batchSet(this)">设置</a>'+
        '</div>'+
    '</td>';
  });
  $('.pro-more-table tfoot tr .price').after(list);

  specExArr=specExArrTable;
  //打印表内容
  $('.pro-more-table tbody').html('');
  $.each(specExArr,function(i,item){
    var list_tbody='',vip_list='';
    var arr=item.id.split('-');
    var arrid=item.id;
    var img = item.img;
    var imghtml='<div class="imgbox"><img class="lay_imgsrc" src="'+img+'" ondragstart="return false" alt="" title="" draggable="false"></div>';
    console.log("arr:"+arr)
    console.log("item:"+item)
    console.log("arrid"+arrid)
    for (var i = 0; i < arr.length; i++) {
      list_tbody +='<td>'+arr[i]+'</td>';
    };
    $.each(vipLevel,function(idx,items){
      var text = item['level_'+items.id];
      vip_list+='<td class="level-price price-'+items.id+'" data-price="price-'+items.id+'"><div class="input-group table-input">'+
                                '<span class="input-group-addon add-attr-btn">￥</span>'+
                                '<input type="number" class="control-input" value="'+text+'">'+
                            '</div></td>';
    });
    $('.pro-more-table tbody').append('<tr id="'+arrid+'" class="spec_tr">'+list_tbody+'<td class="min-img">'+imghtml+'</td><td class="price">'+item.price+'</td>'+vip_list+'</tr>');
    
  });
  
  //合并新建的行
  for (var i = 0; i < spec_sort.length; i++) {
    $(".pro-more-table tbody").rowspan(i);
  };

  //点击确认
  $(".modal .btn-primary").click(function(){
    //记录表内容
    $.each(specExArrTable,function(i,item){
      var vipName='';
      var obj={};
      $.each(vipLevel,function(idx,items){
        obj['level_'+items.id]=$(".pro-more-table tbody").children('#'+item.id).find('td.price-'+items.id).find('input').val();
      });
      $.extend(item,obj);
    });
    console.log(specExArrTable)
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
/*会员价 -E--------*/

/*添加链接 -S--------*/
var linkTraget;
function LinkToChoose(ev){
    var url= getUrl();
  linkTraget = $(ev).parents('.linkchoose').children('.linkchoose_input');

  $('body').append('<div class="modal fade bs-example-modal-lg link-lib"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择链接</h4></div><div class="modal-body clearit"><ul class="nav nav-tabs link-lib-control"role="tablist"><li role="presentation"class="active"><a href="#page_table"aria-controls="page_table"role="tab"data-toggle="tab">页面</a></li><li role="presentation"><a href="#details"aria-controls="details"role="tab"data-toggle="tab">详情</a></li><li role="presentation"><a href="#function"aria-controls="function"role="tab"data-toggle="tab">功能</a></li></ul><div class="tab-content"><div role="tabpanel"class="tab-pane active page_section"id="page_table"></div><div role="tabpanel"class="tab-pane"id="details"><div class="details_section clearit"><div class="details-part col-xs-12 col-sm-7"><ul class=""><li class="linktochoose_li"data-type="coupons"><div class="imgbox"><i class="coupons"></i></div><span class="title">优惠券详情</span></li><li class="linktochoose_li"data-type="products"><div class="imgbox"><i class="product"></i></div><span class="title">商品详情</span></li><li class="linktochoose_li"data-type="articles"><div class="imgbox"><i class="articles"></i></div><span class="title">文章详情</span></li></ul></div><div class="details-show col-xs-12 col-sm-5"><span class="title">示例:</span><div class="imgbox"><img class="part-step"src="'+url+'images/coupon-receive-list.png"ondragstart="return false"alt=""title=""><img class="part-step"src="'+url+'images/coupon-receive-list2.png"ondragstart="return false"alt=""title=""><img class="part-step"src="'+url+'images/coupon-receive-list.png"ondragstart="return false"alt=""title=""><img class="part-step"src="'+url+'images/coupon-receive-list2.png"ondragstart="return false"alt=""title=""></div></div></div></div><div role="tabpanel"class="tab-pane"id="function"><div class="details_section clearit"><div class="details-part col-xs-12 col-sm-7"><ul class=""><li class="linktochoose_li getmessage"data-type="phone"><div class="imgbox"><i class="phone"></i></div><span class="title">拨打电话</span></li><li class="linktochoose_li getmessage"data-type="appid"><div class="imgbox"><i class="appid"></i></div><span class="title">跳转小程序</span></li><li class="linktochoose_li getmessage"data-type="coordinates"><div class="imgbox"><i class="coordinates"></i></div><span class="title">地图</span></li></ul></div><div class="details-show col-xs-12 col-sm-5"><div class="part-step"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">电话号码</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input"type="text"autocomplete="off"></div></div></div><div class="part-step"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">AppID</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input"type="text"autocomplete="off"></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">页面路径(选填)</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input"type="text"autocomplete="off"></div></div></div><div class="part-step"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">选择坐标</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input type="text"class="control-input map_baidu"readonly placeholder="点击获取坐标"></div></div></div></div></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-next"onclick="choosePart(this)"data-toggle="modal"data-target=".service-select-modal">下一步</button><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  var type = $(linkTraget).attr('data-type')||'';

  new MapGrid('.map_baidu',{
    type : gouldMap,
    callback : function(lng,lat){
      $(".modal,.modal-backdrop").show();
    }
  });

  $('.map_baidu').click(function(){
    $(".modal,.modal-backdrop").hide();
  })

  /*生成页面的选项 */
  var html = '',title='';
  $.each(linkToChoose,function(idx,items){
    title = '<span class="title"><i class="iconfont icon-lianjie"></i>'+idx+'</span>';
    var ahtml='';
    $.each(items,function(i,item){
      ahtml += '<li class="linktochoose_li" data-link="'+item.link+'"><span class="title">'+item.name+'</span></li>';
    })
    html += '<div class="page_section-part">'+title+'<ul>'+ahtml+'</ul></div>';
  })
  $('.link-lib #page_table').html(html);


  $('.link-lib .link-lib-control li').click(function(){
    var index = $(this).index();
    /*下一步按钮-确定按钮-隐藏与显示 */
    if(index==1){
      $('.btn-next').show().addClass('disabled');
      $('.btn-confirm').hide();
    }else{
      $('.btn-next').hide();
      $('.btn-confirm').show();
    }
  });

  $('.link-lib .linktochoose_li').click(function(){
    var index = $(this).index();
    $('.tab-content').find('.linktochoose_li').removeClass('active');
    $(this).addClass('active');
    if($(this).parents('.details-part').length>0){
      $(this).parents('.details-part').siblings('.details-show').find('.part-step').eq(index).addClass('active').show().siblings().removeClass('active').hide();
      $(this).parents('.tab-pane').siblings().find('.part-step').removeClass('active').hide();
    }else{
      $('.tab-content').find('.part-step').removeClass('active').hide();
    }
    var type = $(this).attr('data-type')||'';
      getContentByType(type);
    switch(type){
      /*详情 */
      case 'coupons':
      case 'products':
      case 'articles':{
        $('.btn-next').removeClass('disabled').attr('data-type',type);

        break;
      }
    }
  });

  if(type!=''){
    switch(type){
      /*详情 */
      case 'coupons':
      case 'products':
      case 'articles':{
        $('.link-lib .link-lib-control').children().eq(1).children('a').click();
        $('.tab-pane.active .linktochoose_li').each(function(){
          if($(this).attr('data-type')==type){
            console.log(type)
            $(this).click();
            return false;
          }
        });
        // $('.details-part [data-type="'+type+'"]').click();
        break;
      }
      /*功能 */
      case 'phone':
      case 'appid':
      case 'coordinates':{
        $('.link-lib .link-lib-control').children().eq(2).children('a').click();
        $('.tab-pane.active .linktochoose_li').each(function(){
          if($(this).attr('data-type')==type){
            $(this).click();
            var obj = $(linkTraget).attr('data-link');
            if(type=='appid'){
              obj = obj.split(',');
              $('.part-step.active').find('.control-input').each(function(i){
                $(this).val(obj[i]);
              });
            }else{
              $('.part-step.active').find('.control-input').val(obj);
            }
            return false;
          }
        });
        break;
      }
    }
  }else{
    /*页面 */
    $('.link-lib .link-lib-control').children().eq(0).children('a').click();
    $('.tab-pane.active .linktochoose_li').each(function(){
      if($(this).attr('data-link')==$(linkTraget).attr('data-link')){
        $(this).click();
        return false;
      }
    });
  }

  //点击确认
  $(".modal .btn-confirm").click(function(){

    if($('.linktochoose_li.active').hasClass('getmessage')){
      /*功能 */
      var msg='';
      type = $('.linktochoose_li.active').attr('data-type');
      $('.part-step.active').find('.control-input').each(function(i){
        if(i==0){
          msg = $(this).val();
        }else{
          msg = msg +","+ $(this).val();
        }
      });
      var listname = $('.link-lib-control li.active').children().text();
      var name = $('.linktochoose_li.active').children('.title').text();
      name = $.trim(listname)+":"+$.trim(name)+"("+msg+")";
      $(linkTraget).val(name);
      $(linkTraget).attr('data-type',type).attr('data-link',msg);
    }else{
      /*页面 */
      type = '';
      var link = $('.linktochoose_li.active').data('link');
      var listname = $('.link-lib-control li.active').children().text();
      var name = $('.linktochoose_li.active').children('.title').text();
      name = $.trim(listname)+":"+$.trim(name);
      $(linkTraget).val(name);
      $(linkTraget).attr('data-type',type).attr('data-link',link);
    }

    /*数据保存 */
    if($(linkTraget).parents('.edit-box').length>0){

      var dataId = $(linkTraget).parents('.edit-box').attr('data-id');
      var dataLm = $(linkTraget).parents('.edit-box').attr('data-laymodal')||$(ev).attr('data-laymodal');
      switch(dataLm){
        case 'lunbotu':
        case 'mofang':
        case 'cenNav':{
          var evIndex = $(linkTraget).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          imgGroup[evIndex].linkName = name;
          imgGroup[evIndex].linkType = type;
          imgGroup[evIndex].link = link;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'laytitle':{
          LMData.prototype.saveJson(layoutModalSelect,dataId,'linkMinName',name);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'linkType',type);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'link',link);
          break;
        }
      }

    }
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}
/*下一步modal-详情*/
function choosePart(ev){
  if($(ev).hasClass('disabled')){
    return false;
  }
  $('.link-lib').fadeOut();

  var type = $(ev).attr('data-type');
  var titleModal = '选择'+$(ev).parents('.modal').find('.linktochoose_li.active').children('.title').text();
  one_proSelection(ev);
  $('.service-select-modal .modal-title').text(titleModal);
  $('.service-select-modal .service-footer').hide();
  $('.service-select-modal .service-selectAll-add').hide();
  $('.service-select-modal .service-selectAll-remove').hide();
  $('.service-select-modal .selectAll').parent().hide();


  $(".service-select-modal .btn-primary").click(function(){
    var selectID = $('.service-state.action').parents('tr').data('id');
    var itemName;
    $.each(productList,function(i,items){
      $.each(items,function(idx,item){
        if(item.id==selectID){
          itemName = item.name;
          productSel=[];
          productSel.push(item);
          return false;
        }
      });
    });

    var link = $('.linktochoose_li.active').data('link');
    var listname = $('.link-lib-control li.active').children().text();
    var name = $('.linktochoose_li.active').children('.title').text();
    name = $.trim(listname)+":"+$.trim(name)+"("+itemName+")";
    $(linkTraget).val(name);
    $(linkTraget).attr('data-type',type).attr('data-link',link).attr('data-linkid',selectID);

    /*数据保存 */
    if($(linkTraget).parents('.edit-box').length>0){

      var dataId = $(linkTraget).parents('.edit-box').attr('data-id');
      var dataLm = $(linkTraget).parents('.edit-box').attr('data-laymodal')||$(ev).attr('data-laymodal');
      switch(dataLm){
        case 'lunbotu':
        case 'mofang':
        case 'cenNav':{
          var evIndex = $(linkTraget).parents('.lay_img-box').index();
          var imgGroup = LMData.prototype.findJson(layoutModalSelect,dataId,'imgGroup');
          imgGroup[evIndex].linkId = selectID;
          imgGroup[evIndex].linkName = name;
          imgGroup[evIndex].linkType = type;
          imgGroup[evIndex].link = link;
          
          LMData.prototype.saveJson(layoutModalSelect,dataId,'imgGroup',imgGroup);
          break;
        }
        case 'laytitle':{
          LMData.prototype.saveJson(layoutModalSelect,dataId,'linkMinName',name);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'linkType',type);
          LMData.prototype.saveJson(layoutModalSelect,dataId,'link',link);
          break;
        }
      }

    }
    

    // proJsonSave(ev);
    $(".modal").modal("hide");
  });

  
  $('.modal').on('hidden.bs.modal', function () {
    // proJsonSave(ev);
    $(this).remove();
    $('.link-lib').show();
  });
  
  // //点击确认
  // $(".service-select-modal .btn-primary").click(function(){
  //   proJsonSave(ev);
  //   $(".modal").modal("hide");
  // });
  // $(".modal .btn-primary").click(function(){
  //   $(this).parents(".modal").modal("hide");
  // });
  // $('.modal').on('hidden.bs.modal', function () {
  //   $(this).remove();
  // });

}

//产品库----Start----------------------------------------------------------------
//翻页回调函数
function one_pageNavCallBack_pro(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(one_pageNavCallBack_pro);
  one_proPageShow(pageJson,clickPage,pageDisplay);
}
function one_proSelection(ev){
  console.log(pageDisplay)
  $('body').append('<div class="modal fade bs-example-modal-lg service-select-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择服务</h4></div><div class="modal-body main-con"><ul class="nav-contral clearit"role="tablist"><li role="presentation"class="nav-tabs-li active"><select name=""id="classify-filter"class="control-input"><option data-classifyid="all" selected="selected">全部</option></select></li><li><input type="text"class="right-input"placeholder="请输入关键字"></li><li><input type="submit"class="right-input btn"value="搜索"></li></ul><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th style="width: 10%;text-align: left;"><label><input class="selectAll"type="checkbox"name="products"></label></th><th style="width: 10%;">分类</th><th style="width: 50%;"colspan="2">产品名称</th><th style="width: 10%;">价格</th><th style="width: 20%;">操作</th></tr></thead><tbody></tbody><tfoot><tr><td class="id"><label><input class="selectAll"type="checkbox"name="products"></label></td><td colspan="9"style="text-align: left;"class="tfoot-control"><a href="javascript:;"class="bttn service-selectAll-add"><i class="glyphicon glyphicon-ok"></i>批量添加</a><a href="javascript:;"class="bttn service-selectAll-remove"><i class="glyphicon glyphicon-remove"></i>批量移除</a><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div><div class="service-footer "><div class="alert alert-info clearit"role="alert"><h5>已添加服务：</h5><ul class="service-select"></ul></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  
  var obj = iconAll(productList);
  one_proPageShow(obj,1,pageDisplay);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplay);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(one_pageNavCallBack_pro);
  obj=[];
  /*分类下拉生成-select */
  selectOption('.modal #classify-filter');

  one_proSelAction();


}

/*下拉切换，获取数组 */
function one_proSelAction(){
  $('.modal #classify-filter').on("change",function(){
    var parLib = $(this).children('option:selected').data('classifyid');
    // var showLib = $(this).val();
    // console.log(showLib)
    var obj=[],state = true;
    $.each(productListCE,function(i,items){
      if(items.cla_id==parLib){
        state = false;
        return false;
      }
    });
    if(state){
      //二级分类
      $.each(productList,function(i,items){
        // if(i==parLib){
          $.each(items,function(idx,item){
            if(item.cla_id==parLib){
              obj.push(item);
            }
          });
        // }
      });
    }else{
      //一级分类
      $.each(productList,function(i,items){
        if(i==parLib){
          obj=items;
        }
      });
    }
    if(parLib=='all'){
      obj = iconAll(productList);
    }
    one_proPageShow(obj,1,pageDisplay);
    var pageNavObj = null;//用于储存分页对象
    pageCou = Math.ceil(obj.length/pageDisplay);
    pageJson = obj;
    pageNavObj = new PageNavCreate("PageNavId",{
          pageCount:pageCou, 
          currentPage:1, 
          perPageNum:5, 
    });
    pageNavObj.afterClick(pageNavCallBack_pro);
    obj=[];
  });
}
//每页输出
function one_proPageShow(pageJson,clickPage,pageDisplay){
  $('.main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');
  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){
      var state = false;
      $.each(productSel,function(idx,item){
        if(items.id==item.id){
          state = true;
          return false;
        }
      });
      if(state){
        //已添加
        $('.main-table tbody').append('<tr data-id="'+items.id+'" data-classifyid="'+items.cla_id+'"><td class="id"><label><input class="selct-checkbox"type="checkbox"name="products">'+items.id+'</label></td><td class="classify">'+items.classify+'</td><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td>'+items.price+'</td><td><button type="button"class="service-state clerk-btn action"><span class="label label-danger">移除</span></button></td></tr>');
      }else{
        //未添加
        $('.main-table tbody').append('<tr data-id="'+items.id+'" data-classifyid="'+items.cla_id+'"><td class="id"><label><input class="selct-checkbox"type="checkbox"name="products">'+items.id+'</label></td><td class="classify">'+items.classify+'</td><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td>'+items.price+'</td><td><button type="button"class="service-state clerk-btn"><span class="label label-success">添加</span></button></td></tr>');
      }
    }
  });

  
  //添加已经选择的服务1
  $('.service-state').click(function(){
    var selectNum = $(this).parents('tr').data('id');

    $(this).parents('tbody').find('.service-state').removeClass('action').children().removeClass('label-danger').addClass('label-success').text('添加');
    $(this).addClass('action').children().addClass('label-danger').removeClass('label-success').text('移除');
    
  });

}

/*添加链接 -E--------*/

/*订单-发货-接单 -S---------------------------------------*/
function order_delivery(ev){

  var orderModal = $(ev).parents('.order-item').attr('data-styleid');
  var orderState = $(ev).attr('data-state')||'';
  var theadContent = '';
  var tbodyContent = '';
  var radioContent = '';
  var msg = '';
  var titleMsg = '';
  var cfMsg = '';
  var tipsMsg = '';
  // var sending = 0;
  // var sended = 0;
    var thisId = $(ev).parents('tr').attr('data-id');
  getOrderInfo(thisId,'delivery');
  switch(orderModal){
    case 'physical_commodity':{


      var option = '';
      titleMsg = '订单发货'
      cfMsg = '发货';
      tipsMsg = '*请仔细填写物流公司及快递单号。';
      $.each(logisticsCompany,function(i,item){
        option+='<option>'+item+'</option>';
      })

      switch(orderState){
        case 'modifyLogistics':{
          cfMsg = '修改';
          titleMsg = '修改物流';

          break;
        }
      }

      msg='配送方式：'+specExArrTable.default.distribution+'<br>'+specExArrTable.default.consignee+'&nbsp;&nbsp;'+specExArrTable.default.phone+'<br>'+specExArrTable.default.address;

      // theadContent = '<tr><th class="order-tab-10 selct-checkbox"><label><input class="selectAll" type="checkbox" name="products"></label></th><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr>';
      theadContent = '<tr><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr>';

      radioContent = '<div class="col-xs-6 col-sm-8 row order_delivery-radio"><div class="radio-box"><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="1">选择物流</label><label class="radio-checkbox-label selected"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="0"checked>无需物流</label></div><div class="order_delivery-show clearit"data-stylediy=""><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">物流公司</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row "><select class="order_delivery-chosen control-input"data-placeholder="请选择物流公司"><option></option></select></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">运输单号</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input tracking_number"type="text"autocomplete="off"required></div></div></div></div></div>';

      $.each(specExArrTable.rules,function(i,item){
        var hasSended ='';
        var pro_msg ='';
        if(item.state=='待发货'){
          // sending++;
          pro_msg = '-';
        }
        if(item.state=='已发货'){
          // sended++;
          hasSended = 'disabled';
          pro_msg = item.logistics+'<br>'+item.waybill;
        }
        tbodyContent += 
          '<tr id="'+item.id+'">'+
            // '<td>'+
            //   '<label class="selct-checkbox-label '+hasSended+'"><input class="selct-checkbox" type="checkbox" name="" '+hasSended+'></label>'+
            // '</td>'+
            '<td class="sanji-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="'+item.name+'">'+
                  '<div class="min-img"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+item.name+'</span></div>'+
                    '<div class="guige">规格：<span>'+item.specifications+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>'+item.number+'</td>'+'<td>'+item.state+'</td>'+'<td>'+pro_msg+'</td>'+
          '</tr>';
      });

      break;
    }
    case 'pickup_order':{

      var option = '';
      titleMsg = '订单发货'
      cfMsg = '发货';
      tipsMsg = '*请仔细填写物流公司及快递单号。';
      $.each(logisticsCompany,function(i,item){
        option+='<option>'+item+'</option>';
      })

      switch(orderState){
        case 'modifyLogistics':{
          cfMsg = '修改';
          titleMsg = '修改物流';

          break;
        }
      }

      msg='配送方式：'+specExArrTable.default.distribution+'<br>'+'提货时间：'+specExArrTable.default.deliveryTime+'<br>'+specExArrTable.default.consignee+'&nbsp;&nbsp;'+specExArrTable.default.phone+'<br>'+specExArrTable.default.address;

      // theadContent = '<tr><th class="order-tab-10 selct-checkbox"><label><input class="selectAll" type="checkbox" name="products"></label></th><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr>';
      theadContent = '<tr><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr>';

      radioContent = '<div class="col-xs-6 col-sm-8 row order_delivery-radio"><div class="radio-box"><label class="radio-checkbox-label selected"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="0"checked>无需物流</label><label class="radio-checkbox-label order_delivery-citylabel"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="2">商家自行配送</label></div><div class="order_delivery-show clearit"data-stylediy=""><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">物流公司</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row "><select class="order_delivery-chosen control-input"data-placeholder="请选择物流公司"><option></option></select></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">运输单号</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input tracking_number"type="text"autocomplete="off"required></div></div></div></div></div>';

      $.each(specExArrTable.rules,function(i,item){
        var hasSended ='';
        var pro_msg ='';
        if(item.state=='待发货'){
          pro_msg = '-';
        }
        if(item.state=='已发货'){
          hasSended = 'disabled';
          pro_msg = item.logistics+'<br>'+item.waybill;
        }
        tbodyContent += 
          '<tr id="'+item.id+'">'+
            // '<td>'+
            //   '<label class="selct-checkbox-label '+hasSended+'"><input class="selct-checkbox" type="checkbox" name="" '+hasSended+'></label>'+
            // '</td>'+
            '<td class="sanji-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="'+item.name+'">'+
                  '<div class="min-img"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+item.name+'</span></div>'+
                    '<div class="guige">规格：<span>'+item.specifications+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>'+item.number+'</td>'+'<td>'+item.state+'</td>'+'<td>'+pro_msg+'</td>'+
          '</tr>';
      });

      break;
    }
    case 'city_distribution':{

      switch(orderState){
        case 'takeOrders':{
          cfMsg = '接单';
          titleMsg = '商品接单';
          break;
        }
        case 'refuseOrders':{
          cfMsg = '拒绝接单';
          titleMsg = '确定拒绝接单？';
          tipsMsg = '确认拒单订单关闭，钱款原路退回给买家。您可在订单详情中查看退款信息。';
          break;
        }
      }
      msg='配送方式：'+specExArrTable.default.distribution+'<br>'+'送达时间：'+specExArrTable.default.deliveryTime+'<br>'+specExArrTable.default.consignee+'&nbsp;&nbsp;'+specExArrTable.default.phone+'<br>'+specExArrTable.default.address;

      theadContent = '<tr><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr>';

      radioContent = '<div class="col-xs-6 col-sm-8 row order_delivery-radio"><div class="radio-box"><label class="radio-checkbox-label order_delivery-citylabel"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="2">商家自行配送</label></div></div>';

      $.each(specExArrTable.rules,function(i,item){
        tbodyContent += 
          '<tr id="'+item.id+'">'+
            '<td class="sanji-pro">'+
              '<ul>'+
                '<li data-toggle="tooltip" data-placement="top" title="'+item.name+'">'+
                  '<div class="min-img"><img src="'+item.img+'" ondragstart="return false" alt="" title=""></div>'+
                  '<div class="min-title">'+
                    '<div class="name"><span>'+item.name+'</span></div>'+
                    '<div class="guige">规格：<span>'+item.specifications+'</span></div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</td>'+
            '<td>'+item.number+'</td>'+'<td>'+item.state+'</td>'+'<td>-</td>'+
          '</tr>';
      });
      break;
    }
  }

  // $('body').append('<div class="modal fade bs-example-modal-md order_delivery-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">订单发货</h4></div><div class="modal-body clearit"data-parent><div class="control_part"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title"style="font-weight:bold">选择商品</span></label><div class="col-xs-6 col-sm-8 row send_num">待发货<span class="sending">'+sending+'</span>&nbsp;&nbsp;已发货<span class="sended">'+sended+'</span></div></div><div class="form-group col-xs-12"><div class="main-table table-responsive row"><table class="table table-hover table-condensed"><thead><tr><th class="order-tab-10"><label><input class="selectAll"type="checkbox"name="products"></label></th><th class="order-tab-30">商品</th><th class="order-tab-10">数量</th><th class="order-tab-20">状态</th><th class="order-tab-30">运单号</th></tr></thead><tbody>'+tbodyContent+'</tbody></table></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">配送信息</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row order_delivery-msg">'+msg+'</div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">发货方式</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row order_delivery-radio"><div class="radio-box"><label class="radio-checkbox-label selected"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="1"checked="checked">选择物流</label><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="order_delivery_radio"value="0">无需物流</label></div><div class="order_delivery-show clearit"data-stylediy="1"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">物流公司</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row "><select class="order_delivery-chosen control-input"data-placeholder="请选择物流公司"><option></option></select></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">运输单号</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><input class="control-input tracking_number"type="text"autocomplete="off"required></div></div></div><span class="control-tips">*请仔细填写物流公司及快递单号，发货后24小时内仅支持做一次更正，逾期不可修改</span></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">发货</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
  $('body').append('<div class="modal fade bs-example-modal-md order_delivery-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">'+titleMsg+'</h4></div><div class="modal-body clearit"data-parent><div class="control_part"><div class="form-group col-xs-12"><div class="main-table table-responsive row"><table class="table table-hover table-condensed"><thead>'+theadContent+'</thead><tbody>'+tbodyContent+'</tbody></table></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">配送信息</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row order_delivery-msg">'+msg+'</div></div><div class="form-group col-xs-12 row order_delivery-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">发货方式</span><span class="text-danger2">:</span></label>'+radioContent+'<div class="clearit"></div><span class="control-tips" style="text-align:center">'+tipsMsg+'</span></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">'+cfMsg+'</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
  
  $('[data-toggle="tooltip"]').tooltip();
  $('.order_delivery-modal').attr('data-styleid',orderModal);
  $('.order_delivery-modal').attr('data-orderstate',orderState);

  $('.order_delivery-chosen').append(option);
  
  $('.order_delivery-modal .order_delivery-way .order_delivery-radio .radio-box').find('input').each(function(){
    if($(this).val()==specExArrTable.default.deliveryRadio){
      $(this).parents('.radio-box').find('input').removeAttr('checked');
      $(this).prop('checked',true).parent('label').addClass('selected').siblings().removeClass('selected');
      if($(this).val()==1){
        $('.order_delivery-modal .order_delivery-show').attr('data-stylediy',1);
        $('.order_delivery-modal .order_delivery-show .order_delivery-chosen').children().each(function(){
          if($(this).text()==specExArrTable.default.logistics){
            $(this).attr('selected',true);
            return false;
          }
        });
        $('.order_delivery-modal .order_delivery-show .tracking_number').val(specExArrTable.default.waybill);
      }
    }
  });


  //下拉
  $('.order_delivery-chosen').chosen({
    allow_single_deselect: true,
    disable_search:false
  });

  //复选框声明
  $(".main-table .selectAll").click(function(){
    if($(this).parent().hasClass("selected")){
      $(".main-table .selct-checkbox:not([disabled]").prop('checked',false).parent().removeClass("selected").parents('tr').removeClass("selected");
      $(".main-table .selectAll").prop('checked',false).parent().removeClass("selected").removeClass("notall");
    }else{
      $(".main-table .selct-checkbox:not([disabled])").prop('checked',true).parent().addClass("selected").parents('tr').addClass("selected");
      $(".main-table .selectAll").prop('checked',true).parent().addClass("selected");
    }
  });
  $(".main-table .selct-checkbox").click(function(){
    if($(this).parent().hasClass("selected")){
      $(this).parent().removeClass("selected").parents('tr').removeClass("selected");
    }else{
      $(this).parent().addClass("selected").parents('tr').addClass("selected");
    }
    checkboxCheck();
  });

  //单选声明
  $('.order_delivery-radio .selct-checkbox').click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    $(this).parents('.radio-box').siblings('.order_delivery-show').attr('data-stylediy',$(this).val());
  });


  //点击确认
  $(".modal .btn-confirm").click(function(){
    // var state = true;
    // $(".modal .main-table tbody>tr").each(function(){
    //   if($(this).hasClass('selected')){
    //     state = false;
    //   }
    // });
    // if(state){
    //   $.Toast("提示", "请选择发货商品", "notice", {});
    //   return false;
    // }

    if($(".order_delivery-show[data-stylediy=1] .order_delivery-chosen").val()==''){
      $.Toast("提示", "请选择一个物流公司", "notice", {});
      return false;
    }
    if($(".order_delivery-show[data-stylediy=1] .tracking_number").val()==''){
      $.Toast("提示", "运输单号不能为空", "notice", {});
      return false;
    }

    var logistics = '';
    var waybill = '';
    var selDelivery = $('.order_delivery-radio .selct-checkbox:checked').val();
    switch(selDelivery){
      case '0':{
        logistics = '无需物流';
        break;
      }
      case '1':{
        logistics = $('.modal .order_delivery-chosen').val();
        waybill = $('.modal .tracking_number').val();
        break;
      }
      case '2':{
        logistics = '商家自行配送';
        break;
      }
    }
      specExArrTable.default.deliveryRadio = $('.order_delivery-modal .order_delivery-way .order_delivery-radio .radio-box').find('input:checked').val();

    if(specExArrTable.default.delivery){                               
      //单品
      $('.modal .main-table tbody>tr.selected').each(function(){
        var thisId = $(this).attr('id');
        $.each(specExArrTable.rules,function(i,item){
          if(thisId==item.id){
            item.state = '已发货';
            item.logistics = logistics;
            item.waybill = waybill;
          }
        });
      });
    }else{
      //整单
      specExArrTable.default.logistics = logistics;
      if(waybill!=''){
        specExArrTable.default.waybill = waybill;
      }
      $('.modal .main-table tbody>tr').each(function(){
        var thisId = $(this).attr('id');
        $.each(specExArrTable.rules,function(i,item){
          if(thisId==item.id){
            item.state = '已发货';
            item.logistics = logistics;
            item.waybill = waybill;
          }
        });
      });
    }
      saveOrderInfo(thisId,specExArrTable,'delivery');
    console.log(specExArrTable)
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}

/*订单-发货 -E---------------------------------------*/

/*订单-修改价格 -S---------------------------------------*/
//搜索框-清除输入内容
function clearModifyPrice(ev){
  $(ev).siblings('input').val('');
  modifyPrice($(ev).siblings('input'));
  $(ev).siblings('input').focus();
  $(ev).hide();
}
/*计算订单总价 */
function sumPrice(json){
  var sum =0;
  var coupons =0;
  if(json.default.couponType){
    //单商品-优惠券
    $.each(json.rules,function(i,item){
      var coupons_item = item.coupons!=''?parseFloat(item.coupons).toFixed(2):0;
      coupons += Number(coupons_item);
    });
  }else{
    //整单-优惠券
    coupons = Number(json.default.coupons);
  }

  if(json.default.priceDimension){
    //单商品
    $.each(json.rules,function(i,item){
      var price = parseFloat(item.price).toFixed(2);
      var number = parseFloat(item.number).toFixed(2);
      var modifyPrice = item.modifyPrice!=''?parseFloat(item.modifyPrice).toFixed(2):0;
      sum += Number(price)*Number(number) + Number(modifyPrice);
    });
    sum = parseFloat(sum - coupons + Number(json.default.freight)).toFixed(2);
  }else{
    
    $.each(json.rules,function(i,item){
      var price = parseFloat(item.price).toFixed(2);
      var number = parseFloat(item.number).toFixed(2);
      sum += Number(price)*Number(number);
    });
    sum = parseFloat(sum - coupons + Number(json.default.freight) + Number(json.default.modifyPrice)).toFixed(2);
  }

  return sum;
}
/*输入监听-计算价格*/
function modifyPrice(ev){
  var ss =  /^([\+ \-]?(([1-9]\d*)|(0)))([.]\d{0,2})?$/;
  
  if (!ss.test($(ev).val())) {
    if($(ev).val()!=='+'&&$(ev).val()!=='-'&&$(ev).val()!==''){
      $(ev).val('');
      $.Toast("提示", "请输入正确的格式", "notice", {});
      $(ev).siblings('.search-input-remove').hide();
      // return false;
    }
  }
  if($(ev).val()!=='+'&&$(ev).val()!=='-'){
    var priceModal = $(ev).attr('data-pricemodal');
    var sum_Price = sumPrice(specExArrTable);
    switch(priceModal){
      case "single":{
        //单商品
        priceTarget = $(ev).parents('tr').attr('id');
        $.each(specExArrTable.rules,function(i,item){
          if(priceTarget==item.id){
            var coupons = '';
            if(specExArrTable.default.couponType){
              coupons = item.coupons;
            }
            if($(ev).val()<-(item.price*item.number-coupons)){
              $.Toast("提示", "单品减价不能超过单品总额", "notice", {});
              item.modifyPrice = -(item.price*item.number-coupons);
              $(ev).val(parseFloat(item.modifyPrice).toFixed(2))
            }else{
              item.modifyPrice = $(ev).val();
            }
            return false;
          }
        });

        break;
      }
      case "all":{
        //整单
        specExArrTable.default.modifyPrice = $(ev).val();
        var mSum = 0;
        var coupons = 0;
        if(specExArrTable.default.couponType){
          //单商品-优惠券
          $.each(specExArrTable.rules,function(i,item){
            var coupons_item = item.coupons!=''?parseFloat(item.coupons).toFixed(2):0;
            coupons += Number(coupons_item);
          });
        }else{
          //整单-优惠券
          coupons = Number(specExArrTable.default.coupons);
        }
        $.each(specExArrTable.rules,function(i,item){
          mSum += item.price*item.number;
        });
        mSum = mSum - coupons;

        if($(ev).val()<-(mSum)){
          $.Toast("提示", "订单减价不能超过订单总额", "notice", {});
          specExArrTable.default.modifyPrice = -(mSum);
          $(ev).val(parseFloat(specExArrTable.default.modifyPrice).toFixed(2))
        }else{
          specExArrTable.default.modifyPrice = $(ev).val();
        }
        break;
      }
      case "freight":{
        //运费
        if($(ev).val()<0){
          specExArrTable.default.freight = $(ev).val();
          $.Toast("提示", "订单运费不能为负数", "notice", {});
          specExArrTable.default.freight = 0;
          $(ev).val(specExArrTable.default.freight)
        }else{
          specExArrTable.default.freight = $(ev).val();
        }
        break;
      }
    }
    
    var sum_Price = sumPrice(specExArrTable);
    if(sum_Price<0){
      $.Toast("提示", "订单总额不能为负数", "notice", {});
      $('.modal .main-table .actually_paid').text(parseFloat(0).toFixed(2));
    }else{
      $('.modal .main-table .actually_paid').text(sum_Price);
    }
  }

  if($(ev).val()!=''){
    $(ev).siblings('.search-input-remove').show();
  }else{
    $(ev).siblings('.search-input-remove').hide();
  }

}
function order_modifyPrice(ev){
  var thisId = $(ev).parents('tr').attr('data-id');
  getOrderInfo(thisId,'price');
  var tbodyContent = '';
  var priceDimension = specExArrTable.default.priceDimension;
  var couponType = specExArrTable.default.couponType;
  var freight =specExArrTable.default.freight!=''?parseFloat(specExArrTable.default.freight).toFixed(2):0;
  var sum_Price = sumPrice(specExArrTable);

  msg=specExArrTable.default.address;

  if(priceDimension){
    //改价维度-单商品
    $.each(specExArrTable.rules,function(i,item){
      var couponHtml ='';
      var firstHtml ='';
      var modifyPrice = item.modifyPrice!=''?parseFloat(item.modifyPrice).toFixed(2):0;
      // var coupons =item.coupons!=''?parseFloat(item.coupons).toFixed(2):0;
      if(i==0){
        if(couponType==0){
          var coupons =specExArrTable.default.coupons!=''?parseFloat(specExArrTable.default.coupons).toFixed(2):0;
          couponHtml = '<td rowspan="'+specExArrTable.rules.length+'" class="pro_coupons">'+coupons+'</td>';
        }

        firstHtml =
        '<td rowspan="'+specExArrTable.rules.length+'">'+
          '<input class="control-input freight_price" type="text" data-pricemodal="freight" autocomplete="off" onkeyup="modifyPrice(this)" value="'+freight+'">'+
          '<a href="javascript:;" class="search-input-remove" onclick="clearModifyPrice(this)"><i class="glyphicon glyphicon-remove"></i></a>'+
        '</td>'+
        '<td rowspan="'+specExArrTable.rules.length+'" class="actually_paid">'+sum_Price+'</td>';
      }
      if(couponType==1){
        //改价维度-单商品
        $.each(specExArrTable.rules,function(idx,items){
          if(i==idx){
            var coupons =items.coupons!=''?parseFloat(items.coupons).toFixed(2):0;
            couponHtml = '<td class="pro_coupons">'+coupons+'</td>';
            return false;
          }
        });
      }
  
      tbodyContent += 
        '<tr id="'+item.id+'">'+
          '<td class="sanji-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="'+item.name+'">'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+item.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td>'+item.price+'</td>'+
          '<td>'+item.number+'</td>'+
          '<td>'+item.number*item.price+'</td>'+couponHtml+
          // '<td class="pro_coupons">'+coupons+'</td>'+
          '<td>'+
            '<input class="control-input inc_or_dec_price" data-pricemodal="single" type="text" autocomplete="off" onkeyup="modifyPrice(this)" value="'+modifyPrice+'">'+
            '<a href="javascript:;" class="search-input-remove" onclick="clearModifyPrice(this)"><i class="glyphicon glyphicon-remove"></i></a>'+
          '</td>'+firstHtml+
        '</tr>';
    });
  }else {
    //改价维度-整单
    var modifyPrice = specExArrTable.default.modifyPrice!=''?parseFloat(specExArrTable.default.modifyPrice).toFixed(2):0;
    $.each(specExArrTable.rules,function(i,item){
      var firstHtml ='';
      var couponHtml ='';
      if(i==0){
        
        if(!couponType){
          var coupons =specExArrTable.default.coupons!=''?parseFloat(specExArrTable.default.coupons).toFixed(2):0;
          couponHtml = '<td rowspan="'+specExArrTable.rules.length+'" class="pro_coupons">'+coupons+'</td>';
        }
        firstHtml =
        // '<td rowspan="'+specExArrTable.rules.length+'">'+parseFloat(specExArrTable.default.coupons).toFixed(2)+'</td>'+
        '<td rowspan="'+specExArrTable.rules.length+'">'+
          '<input class="control-input inc_or_dec_price" data-pricemodal="all" type="text" autocomplete="off" onkeyup="modifyPrice(this)" value="'+modifyPrice+'">'+
          '<a href="javascript:;" class="search-input-remove" onclick="clearModifyPrice(this)"><i class="glyphicon glyphicon-remove"></i></a>'+
        '</td>'+
        '<td rowspan="'+specExArrTable.rules.length+'">'+
          '<input class="control-input freight_price" data-pricemodal="freight" type="text" autocomplete="off" onkeyup="modifyPrice(this)" value="'+freight+'">'+
          '<a href="javascript:;" class="search-input-remove" onclick="clearModifyPrice(this)"><i class="glyphicon glyphicon-remove"></i></a>'+
        '</td>'+
        '<td rowspan="'+specExArrTable.rules.length+'" class="actually_paid">'+sum_Price+'</td>';
      }

      if(couponType){
        //改价维度-单商品
        $.each(specExArrTable.rules,function(idx,items){
          if(i==idx){
            var coupons =items.coupons!=''?parseFloat(items.coupons).toFixed(2):0;
            couponHtml = '<td class="pro_coupons">'+coupons+'</td>';
            return false;
          }
        });
      }
  
      tbodyContent += 
        '<tr id="'+item.id+'">'+
          '<td class="sanji-pro">'+
            '<ul>'+
              '<li data-toggle="tooltip" data-placement="top" title="'+item.name+'">'+
                '<div class="min-title">'+
                  '<div class="name"><span>'+item.name+'</span></div>'+
                '</div>'+
              '</li>'+
            '</ul>'+
          '</td>'+
          '<td>'+item.price+'</td>'+
          '<td>'+item.number+'</td>'+
          '<td>'+item.number*item.price+'</td>'+couponHtml+firstHtml+
        '</tr>';
    });
  }



  $('body').append('<div class="modal fade bs-example-modal-lg order_modifyPrice-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-lg"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">订单原价(含运费)：<span>1.00</span>元</h4></div><div class="modal-body clearit"data-parent><div class="control_part"><div class="form-group col-xs-12"style="margin-bottom:0;"><div class="main-table table-responsive row"><table class="table table-condensed"><!--table-hover--><thead><tr><th class="order-tab-20">商品</th><th class="order-tab-10">单价（元）</th><th class="order-tab-10">数量</th><th class="order-tab-10">小计（元）</th><th class="order-tab-10">店铺优惠</th><th class="order-tab-15">涨价或减价</th><th class="order-tab-15">运费（元）</th><th class="order-tab-10">实付金额</th></tr></thead><tbody>'+tbodyContent+'</tbody></table></div></div><div class="form-group col-xs-12 row"style="margin-bottom:0;"><span class="control-tips tips_address">'+msg+'</span><span class="control-tips">实付金额=小计+店铺优惠+小计涨减价+运费</span></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');
  
  $('[data-toggle="tooltip"]').tooltip();
  $('.modal .modal-title span').text(sum_Price);


  //点击确认
  $(".modal .btn-confirm").click(function(){

    saveOrderInfo(thisId,specExArrTable,'price');

    console.log(specExArrTable)
    // $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
/*订单-修改价格 -E---------------------------------------*/
/*订单-退款维权 -S---------------------------------------*/
function refundRights(ev){

  var promote = specExArrTable.default.promote;
  var commission = specExArrTable.default.commission;
  var styleType = specExArrTable.default.style_type!=''?styleType:'percent';
  var levelFirst = specExArrTable.default.level_first;
  var levelSecond = specExArrTable.default.level_second;
  var levelThird = specExArrTable.default.level_third;

  var refundHtml ='',confirmMsg = '';
  var stateMsg= specExArrTable.default.refund_state;
  var stateMoney = parseFloat(specExArrTable.default.refund_money).toFixed(2);
  var refundState= $(ev).attr('data-refundstate');
  var alertMsg = '该笔订单通过“微信安全支付－代销”付款，需您同意退款申请，买家才能退货给您；买家退货后您需再次确认收货后，退款将自动原路退回至买家付款账户；';

  switch(refundState){
    //仅退款
    case 'onlyRefund':{
      // refundHtml = '';
      confirmMsg = '同意'
      break;
    }
    //退货退款
    case 'refunds':{
      var addressHtml='';
      $.each(specExArrTable.rules,function(i,item){
        var isDefault='';
        if(item.default==1){
          isDefault='<span class="address-list-default">默认地址</span>';
        }
        addressHtml += 
          '<label class="radio-checkbox-label">'+
            '<input class="selct-checkbox" type="radio" name="return_address" value="'+item.id+'">'+
            '<div class="address-list-limit">'+
              '<span>【'+item.name+' 收】</span>'+
              '<span>'+item.address+'</span>'+
              '<span>'+item.mail+'</span>'+
            '</div>'+
            '<span>'+item.iphone+'</span>'+isDefault+
          '</label>'
      });
      
      refundHtml = 
        '<div class="form-group col-xs-12 row refundRights-address">'+
            '<label class="control-label col-xs-6 col-sm-4">'+
              '<span class="text-title">退货地址</span>'+
              '<span class="text-danger2">:</span>'+
            '</label>'+
            '<div class="col-xs-12">'+
              '<div class="radio-box">'+addressHtml+
              '</div>'+
              '<a class="address-control-a" href="'+specExArrTable.default.http+'" target="_blank">'+
                '管理地址'+
              '</a>'+
            '</div>'+
          '</div>';
      confirmMsg = '同意退货，发送退货地址';
      break;
    }
    //拒绝退款
    case 'refusedRefund':{
      refundHtml = 
        '<div class="form-group col-xs-12 row sanji_pro-way">'+
            '<label class="control-label col-xs-6 col-sm-4">'+
              '<span class="text-title">退款金额</span>'+
              '<span class="text-danger2">:</span>'+
            '</label>'+
            '<div class="col-xs-6 col-sm-8 row">'+
              '<div class="message_box"><textarea class="control-input control-textarea" cols="30" placeholder="请填写您拒绝的理由"></textarea></div>'+
            '</div>'+
          '</div>';
      confirmMsg = '拒绝'
      break;
    }
    //确认收货并退款
    case 'confirmRefund':{
      var addressHtml='';
      $.each(specExArrTable.rules,function(i,item){
        if(specExArrTable.default.address_sel==item.id){
          addressHtml = 
            '<div class="address-list-limit">'+
              '<span>【'+item.name+' 收】</span>'+
              '<span>'+item.address+'</span>'+
              '<span>'+item.mail+'</span>'+
            '</div>'+
            '<span>'+item.iphone+'</span>';
          return false;
        }
      });
      refundHtml = 
        '<div class="form-group col-xs-12 row sanji_pro-way">'+
					'<label class="control-label col-xs-6 col-sm-4">'+
						'<span class="text-title">退款金额</span>'+
						'<span class="text-danger2">:</span>'+
					'</label>'+
					'<div class="col-xs-6 col-sm-8 row">'+
						'<div class="message_box">'+addressHtml+'</div>'+
					'</div>'+
				'</div>';
      confirmMsg = '确认收货并退款'
      break;
    }
    //拒绝确认收货
    case 'refuseReceiving':{
      var addressHtml='';
      $.each(specExArrTable.rules,function(i,item){
        if(specExArrTable.default.address_sel==item.id){
          addressHtml = 
            '<div class="address-list-limit">'+
              '<span>【'+item.name+' 收】</span>'+
              '<span>'+item.address+'</span>'+
              '<span>'+item.mail+'</span>'+
            '</div>'+
            '<span>'+item.iphone+'</span>';
          return false;
        }
      });
      refundHtml = 
        '<div class="form-group col-xs-12 row sanji_pro-way">'+
					'<label class="control-label col-xs-6 col-sm-4">'+
						'<span class="text-title">退款金额</span>'+
						'<span class="text-danger2">:</span>'+
					'</label>'+
					'<div class="col-xs-6 col-sm-8 row">'+
						'<div class="message_box">'+addressHtml+'</div>'+
					'</div>'+
				'</div>';
      confirmMsg = '未收货，拒绝退款'
      break;
    }
  }


  $('body').append('<div class="modal fade bs-example-modal-md refundRights-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">维权处理</h4></div><div class="modal-body clearit"data-parent><div class="alert alert-warning" role="alert">'+alertMsg+'</div><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">处理方式</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="message_box">'+stateMsg+'</div></div></div><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">退款金额</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="message_box">'+stateMoney+'</div></div></div>'+refundHtml+'</div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">'+confirmMsg+'</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  $('.modal .sanji_pro-way input[value='+promote+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-part').attr('data-stylediy',promote);
  $('.modal .sanji_pro-commission input[value='+commission+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-part2').attr('data-stylediy',commission);
  $('.modal .sanji_pro-style input[value='+styleType+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-level').attr('data-style',styleType);


  

  //单选声明
  $('.refundRights-modal .selct-checkbox').click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    // $(this).parents('.sanji_pro-way').siblings('.sanji_pro-part').attr('data-stylediy',$(this).val());
    // $(this).parents('.sanji_pro-commission').siblings('.sanji_pro-part2').attr('data-stylediy',$(this).val());
    // $(this).parents('.sanji_pro-style').siblings('.sanji_pro-level').attr('data-style',$(this).val());
  });

  //点击确认
  $(".modal .btn-confirm").click(function(){
    // specExArrTable.default.promote = $('.modal .sanji_pro-way .selected input').val();
    // specExArrTable.default.commission = $('.modal .sanji_pro-commission .selected input').val();
    // specExArrTable.default.style_type = $('.modal .sanji_pro-style .selected input').val();
    // specExArrTable.default.level_first = $('.sanji_pro-level[data-level=first]').find('input').val();
    // specExArrTable.default.level_second = $('.sanji_pro-level[data-level=second]').find('input').val();
    // specExArrTable.default.level_third = $('.sanji_pro-level[data-level=third]').find('input').val();

    console.log(specExArrTable)
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}
/*订单-退款维权 -E---------------------------------------*/
/*三级分销-商品佣金设置 -S---------------------------------------*/
function sanjiProSet(ev){

  var promote = specExArrTable.default.promote;
  var commission = specExArrTable.default.commission;
  var styleType = specExArrTable.default.style_type!=''?styleType:'percent';
  var levelFirst = specExArrTable.default.level_first;
  var levelSecond = specExArrTable.default.level_second;
  var levelThird = specExArrTable.default.level_third;


  $('body').append('<div class="modal fade bs-example-modal-md sanji_pro-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">修改商品佣金</h4></div><div class="modal-body clearit"data-parent><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">推广</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="radio-box"><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="sanji_pro-way"value="1">参与</label><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="sanji_pro-way"value="0">不参与</label></div></div></div><div class="sanji_pro-part"data-stylediy=""><div class="form-group col-xs-12 row sanji_pro-commission"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">佣金</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="radio-box"><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="commission"value="0">默认佣金比例</label><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="commission"value="1">自定义佣金比例</label></div></div></div><div class="sanji_pro-part2"data-stylediy=""><div class="form-group col-xs-12 row sanji_pro-style"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">类型</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="radio-box"><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="style"value="percent">百分比</label><label class="radio-checkbox-label"><input class="selct-checkbox"type="radio"name="style"value="money">固定额度</label></div></div></div><div class="form-group col-xs-12 row sanji_pro-level"data-level="first"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">一级佣金</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="input-group-addon addon2">￥</div><input class="control-input"type="number"autocomplete="off"><div class="input-group-addon addon1">%</div></div></div></div><div class="form-group col-xs-12 row sanji_pro-level"data-level="second"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">二级佣金</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="input-group-addon addon2">￥</div><input class="control-input"type="number"autocomplete="off"><div class="input-group-addon addon1">%</div></div></div></div><div class="form-group col-xs-12 row sanji_pro-level"data-level="third"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">三级佣金</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-group"><div class="input-group-addon addon2">￥</div><input class="control-input"type="number"autocomplete="off"><div class="input-group-addon addon1">%</div></div></div></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  $('.modal .sanji_pro-way input[value='+promote+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-part').attr('data-stylediy',promote);
  $('.modal .sanji_pro-commission input[value='+commission+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-part2').attr('data-stylediy',commission);
  $('.modal .sanji_pro-style input[value='+styleType+']').attr('checked',true).parent().addClass('selected');
  $('.sanji_pro-level').attr('data-style',styleType);
  if(levelFirst!=''){
    $('.sanji_pro-level[data-level=first]').find('input').val(levelFirst);
  }
  if(levelSecond!=''){
    $('.sanji_pro-level[data-level=second]').find('input').val(levelSecond);
  }
  if(levelThird!=''){
    $('.sanji_pro-level[data-level=third]').find('input').val(levelThird);
  }


  

  //单选声明
  $('.sanji_pro-modal .selct-checkbox').click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    $(this).parents('.sanji_pro-way').siblings('.sanji_pro-part').attr('data-stylediy',$(this).val());
    $(this).parents('.sanji_pro-commission').siblings('.sanji_pro-part2').attr('data-stylediy',$(this).val());
    $(this).parents('.sanji_pro-style').siblings('.sanji_pro-level').attr('data-style',$(this).val());
  });

  //点击确认
  $(".modal .btn-confirm").click(function(){
    specExArrTable.default.promote = $('.modal .sanji_pro-way .selected input').val();
    specExArrTable.default.commission = $('.modal .sanji_pro-commission .selected input').val();
    specExArrTable.default.style_type = $('.modal .sanji_pro-style .selected input').val();
    specExArrTable.default.level_first = $('.sanji_pro-level[data-level=first]').find('input').val();
    specExArrTable.default.level_second = $('.sanji_pro-level[data-level=second]').find('input').val();
    specExArrTable.default.level_third = $('.sanji_pro-level[data-level=third]').find('input').val();

    console.log(specExArrTable)
    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}
/*三级分销-商品佣金设置 -E---------------------------------------*/

//选择微信号----Start----------------------------------------------------------------
//翻页回调函数
function pageNavCallBack_wx(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_wx);
  wxPageShow(pageJson,clickPage,pageDisplayWx);
}
function wxSelection(ev){
  $('body').append('<div class="modal fade bs-example-modal-md service-select-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">选择微信号</h4></div><div class="modal-body main-con"><ul class="nav-contral clearit"role="tablist"><li><input type="text"class="right-input search-input"placeholder="请输入微信号"><a href="javascript:;"class="search-input-remove"onclick="clearSearch(this)"><i class="glyphicon glyphicon-remove"></i></a></li><li><input type="submit"class="right-input search-input-btn btn"value="搜索"></li></ul><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th>ID</th><th colspan="2">微信号</th><th>操作</th></tr></thead><tbody></tbody><tfoot><tr><td colspan="9"style="text-align: left;"class="tfoot-control"><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div></div><div class="modal-footer"><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  
  var obj = productList;
  wxPageShow(obj,1,pageDisplayWx);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplayWx);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_wx);
  obj=[];

  $('.modal').on('hidden.bs.modal', function () {
    // proJsonSave(ev);
    $(this).remove();
  });

  //输入框
  $('.modal .search-input').on('keyup', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).val());
    if(value!=''){
      $('.search-input-remove').show();
    }else{
      $('.search-input-remove').hide();
    }
  });

  //搜索
  var resultJson = [];
  $('.modal .search-input-btn').on('click', function () {
    // proJsonSave(ev);
    var value=$.trim($(this).parent().siblings().children('input').val());
    $.each(productList,function(i,item){
      if(item.name.indexOf(value) != -1){
        resultJson.push(item);
      }
    });
    if(resultJson == ''){
      $('.modal .main-table tbody').html('<tr class="data-empty"><td colspan="4"></td></tr>');
    }else{
      wxPageShow(resultJson,1,pageDisplayWx);
      var pageNavObj = null;//用于储存分页对象
      pageCou = Math.ceil(resultJson.length/pageDisplayWx);
      pageJson = resultJson;
      pageNavObj = new PageNavCreate("PageNavId",{
            pageCount:pageCou, 
            currentPage:1, 
            perPageNum:5, 
      });
      pageNavObj.afterClick(pageNavCallBack_wx);
      resultJson=[];
    }

  });


}

//每页输出
function wxPageShow(pageJson,clickPage,pageDisplay){
  $('.main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');
  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){
        //未添加
        $('.main-table tbody').append('<tr data-id="'+items.id+'" data-classfiyid="'+items.cla_id+'"><td>'+items.id+'</td><td class="min-img"><div><img src="'+items.img+'"ondragstart="return false"alt=""title=""></div></td><td class="title">'+items.name+'</td><td><button type="button"class="service-state clerk-btn"><span class="label label-success">添加</span></button></td></tr>');
      // }
      //清除全选状态
      $(".main-table .selectAll").attr('checked',false);
      $(".main-table .selectAll").parent().removeClass("selected");
    }
  });
  
  //添加已经选择的服务1
  $('.service-state').click(function(){
    var selectNum = $(this).parents('tr').data('id');

    wxState(this);

    proJsonSave('.service-section',productSel);
    $(this).parents(".modal").modal("hide");
  });

}

  //店员管理-新增店员-状态-弹窗
  function wxState(ev){
    var selectID = $(ev).parents('tr').data('id');
    // var obj = [];
    // obj = iconAll(productList);
    //添加
    $.each(productList,function(i,items){
      if(items.id==selectID){
        productSel=[];
        productSel.push(items);
        return false;
      }
    });
  }

  //搜索框-清除输入内容
  function clearSearch(ev){
    $(ev).siblings().val('');
    var obj = productList;
    wxPageShow(obj,1,pageDisplayWx);
    var pageNavObj = null;//用于储存分页对象
    pageCou = Math.ceil(obj.length/pageDisplayWx);
    pageJson = obj;
    pageNavObj = new PageNavCreate("PageNavId",{
          pageCount:pageCou, 
          currentPage:1, 
          perPageNum:5, 
    });
    pageNavObj.afterClick(pageNavCallBack_wx);
    obj=[];
    $(ev).hide();
  }

  
//选择微信号----end----------------------------------------------------------------

/*营销-积分设置 -S---------------------------------------*/
function integralGeneral(ev){


  $('body').append('<div class="modal fade bs-example-modal-md integral-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">店铺积分通用规则</h4></div><div class="modal-body clearit"data-parent><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">通用有效期</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="radio-box"><label class="radio-checkbox-label selected"><input class="selct-checkbox"type="radio"name="sanji_pro-way"value="1"checked>永久有效</label></div></div></div><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">积分抵扣</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-daterange input-group"id="datepicker"><input type="number"class="control-input"style="margin:0"onkeyup="positiveInteger(this)"><span class="input-group-addon">积分抵扣一元</span></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');

  // $(".modal .selct-checkbox-label .selct-checkbox").click(function(){
  //   if($(this).parent().hasClass("selected")){
  //     $(this).parent().removeClass("selected");
  //   }else{
  //     $(this).parent().addClass("selected");
  //   }
  // });
  $('#datepicker .control-input').val($(ev).attr('data-integral'));

  //单选声明
  $('.modal .radio-checkbox-label .selct-checkbox').click(function(){
    $(this).parent().addClass("selected").siblings().removeClass("selected");
  });


  //点击确认
  $(".modal .btn-confirm").click(function(){
    if($('#datepicker .control-input').val()==''){
      
      $.Toast("提示", "积分抵扣不能为空", "notice", {});
      return false;
    }else{
      var deduction= $('.integral-modal .deduction').val()
      general(id,deduction);
      $('.integral_num').text($('#datepicker .control-input').val()+'积分抵扣一元');
    }

    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}
function integralNew(ev,id,money,integral){


  $('body').append('<div class="modal fade bs-example-modal-md integral-modal"tabindex="-1"role="dialog"aria-labelledby="mySmallModalLabel"data-parent="proBox"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">新建积分规则</h4></div><div class="modal-body clearit"data-parent><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">奖励条件</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="input-daterange input-group"id="datepicker"><span class="input-group-addon">每购买金额达</span><input type="text"class="control-input integral_money"style="margin:0" value="'+money+'" name="money"><span class="input-group-addon">元</span></div><span class="control-tips">全部商品参加；发生部分退款时,按照实际支付金额扣除应退积分。</span></div></div><div class="form-group col-xs-12 row sanji_pro-way"><label class="control-label col-xs-6 col-sm-4"><span class="text-title">奖励分值</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row"><div class="min-input"><input type="number"class="control-input integral_num"placeholder="请输入整数"onkeyup="positiveInteger(this)" value="'+integral+'" name="integral"></div></div></div></div><div class="modal-footer"data-target="proBox"data-prostyle="oneProSel"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">取消</button></div></div></div></div>');



  //点击确认
  $(".modal .btn-confirm").click(function(){

    var money = $('.integral-modal .integral_money').val();
    var integral = $('.integral-modal .integral_num').val();
    if (id != ''){
        edit(id,money,integral);
    } else {
        add(money,integral);
    }

    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });

}
/*营销-积分设置 -E---------------------------------------*/
/*营销-社区拼团-团长等级 -S---------------------------------------*/
function communityLevel(ev){

  $('body').append('<div class="modal fade bs-example-modal-md community-level-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">新增等级</h4></div><div class="modal-body main-con clearit"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">等级名称</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><input class="control-input name"type="text"autocomplete="off"></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">升级条件</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><div class="input-group input-text-color"><span class="input-group-addon">销售额累计达到</span><input class="control-input money"type="number"autocomplete="off"onkeyup="decimalPoint(this)"><span class="input-group-addon">元可以自动升级</span></div></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');

  //点击确认
  $(".modal .btn-confirm").click(function(){

    if($(this).hasClass('disabled')){
      return false;
    }else{
      var name = $.trim($('.community-level-modal .name').val());
      var money = $.trim($('.community-level-modal .money').val());
      if(money==''&&name==''){
        $.Toast("提示", "数据不能为空", "notice", {});
        return false;
      }else{



      }
    }

    $(this).parents(".modal").modal("hide");
  });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
/*营销-社区拼团-团长等级-E---------------------------------------*/
/*营销-社区拼团-团长结算 -S---------------------------------------*/
function settlement(ev){
  $('body').append('<div class="modal fade bs-example-modal-md settlement-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">新增等级</h4></div><div class="modal-body main-con clearit"><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">等级名称</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><input class="control-input name"type="text"autocomplete="off"></div></div><div class="form-group col-xs-12 row"><label class="control-label col-xs-6 col-sm-4"><span class="text-danger">*</span><span class="text-title">升级条件</span><span class="text-danger2">:</span></label><div class="col-xs-6 col-sm-8 row input_box"><div class="input-group input-text-color"><span class="input-group-addon">销售额累计达到</span><input class="control-input money"type="number"autocomplete="off"onkeyup="decimalPoint(this)"><span class="input-group-addon">元可以自动升级</span></div></div></div></div><div class="modal-footer"><button type="button"class="btn btn-primary btn-confirm">确定</button><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  var $headTr = $('<tr></tr>');
  var styleId = $(ev).attr('data-styleid');
  var community = $(ev).parent('td').siblings('.community').text();
  var colonel = $(ev).parent('td').siblings('.colonel').text();
  var headTrHyml = '';

  $('.modal #myModalLabel').html($(ev).text()+"<span style='margin-left:20px;'>社区店名称："+community+"</span>"+"<span style='margin-left:20px;'>团长名称："+colonel+"</span>");

  switch(styleId){
    case 'balance':{
      headTrHyml = 
      '<th style="width: 10%;">序号</th>'+
      '<th style="width: 20%;">关联单号</th>'+
      '<th style="width: 10%;">收支类型</th>'+
      '<th style="width: 10%;">金额</th>'+
      '<th style="width: 10%;">变动后余额</th>'+
      '<th style="width: 20%;">操作时间</th>'+
      '<th style="width: 20%;">备注</th>';

      $headTr.html(headTrHyml);
      $('.settlement-modal .modal-body thead').append($headTr);

      if(productSel==''){

      }else{
        $.each(productSel,function(i,item){

        })

      }

      break;
    }
    case 'commission':{
      $headTrHyml = 
      '<th style="width: 20%;">关联单号</th>'+
      '<th style="width: 10%;">类型</th>'+
      '<th style="width: 10%;">金额金额</th>'+
      '<th style="width: 20%;">团长名称</th>'+
      '<th style="width: 20%;">操作时间</th>'+
      '<th style="width: 20%;">备注</th>';
      break;
    }
  }



  // //点击确认
  // $(".modal .btn-confirm").click(function(){

  //   if($(this).hasClass('disabled')){
  //     return false;
  //   }else{
  //     var name = $.trim($('.community-level-modal .name').val());
  //     var money = $.trim($('.community-level-modal .money').val());
  //     if(money==''&&name==''){
  //       $.Toast("提示", "数据不能为空", "notice", {});
  //       return false;
  //     }else{



  //     }
  //   }

  //   $(this).parents(".modal").modal("hide");
  // });
  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
/*营销-社区拼团-团长结算--E---------------------------------------*/
/*营销-限时活动-其他活动-精品团购--S---------------------------------------*/
// var proSelObj=[];
function pageNavCallBack_act(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_act);
  actPageShow('.other-activity-modal',pageJson,clickPage,pageDisplay);
}
function otherActivityCheck(ev){
  var modalTitle = $(ev).attr('data-title');
  $('body').append('<div class="modal fade bs-example-modal-md other-activity-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">'+modalTitle+'</h4></div><div class="modal-body main-con"><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th style="width: 10%;">ID</th><th style="width: 20%;">活动名称</th><th style="width: 50%;">活动时间</th><th style="width: 20%;">详情</th></tr></thead><tbody></tbody><tfoot><tr><td colspan="4"style="text-align: left;"class="tfoot-control"><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div></div><div class="modal-footer"><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  
  var dataId = $(ev).parents('tr').attr('data-id');
  console.log(dataId)

  $.each(productSel,function(idx,items){
    if(items.id == dataId){
      obj = items.activity;
      return false;
    }
  });

  actPageShow('.other-activity-modal',obj,1,pageDisplay);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplay);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_act);

  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
function actPageShow(parent,pageJson,clickPage,pageDisplay){
  $(parent+' .main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');

  
  var endTime = $('#new_end_time').val();
  var startTime = $('#new_start_time').val();
  var obj = [];
  console.log(pageJson)
  var actLength = pageJson.length;

  // var lastState = false;
  // if(actLength==1){
  //   if(endTime<pageJson[0].startTime||startTime>pageJson[0].endTime){
  //   }else{
  //     obj.push(pageJson[0].id);
  //     $.Toast("提示", "商品: "+pageJson[0].id+" ,在其他活动优惠中，请重新选择", "notice", {});
  //   }
  // }else{
  //   $.each(pageJson,function(i,items){
  //     switch(true){
  //       case i==0:{
  //         if(endTime<items.startTime){
  //           return false;
  //         }else if(startTime>items.endTime){
  //           lastState = true;
  //         }
  //         break;
  //       }
  //       case i!=0&&i!=(actLength-1):{
  //         console.log(endTime<items.startTime&&lastState)
  //         console.log(startTime>items.endTime)
  //         console.log(lastState)
  //         if(endTime<items.startTime&&lastState){
  //           return false;
  //         }else{
  //           lastState = false;
  //         }
  //         if(startTime>items.endTime){
  //           lastState = true;
  //         }
  //         break;
  //       }
  //       case i==(actLength-1):{
  //         console.log(endTime<items.startTime&&lastState)
  //         console.log(startTime>items.endTime)
  //         console.log(lastState)
  //         if(endTime<items.startTime&&lastState){
  //           return false;
  //         }else if(startTime>items.endTime){
  //           return false;
  //         }else{
  //           obj.push(items.id);
  //           $.Toast("提示", "商品: "+items.id+" ,在其他活动优惠中，请重新选择", "notice", {});
  //           // return false;
  //         }
  //         break;
  //       }
  //     }
  //   });
  // }
  // console.log(obj)

  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){

      


      var $tr = $('<tr></tr>');
      var trHtml = 
        '<td>'+items.id+'</td>'+
        '<td>'+items.name+'</td>'+
        '<td>'+items.startTime+' ~ '+items.endTime+'</td>'+
        '<td><a href="'+items.link+'" target="_blank">查看</a></td>';

      $tr.append(trHtml);
      $(parent + ' .modal-body tbody').append($tr);
    }
  });
}
/*营销-限时活动-其他活动--E---------------------------------------*/
/*营销-限时活动-其他活动-精品团购--S---------------------------------------*/
// var proSelObj=[];
function pageNavCallBack_act(clickPage){
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount: pageCou, 
        currentPage:clickPage, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_act);
  actPageShow('.other-activity-modal',pageJson,clickPage,pageDisplay);
}
function otherActivityCheck(ev){
  var modalTitle = $(ev).attr('data-title');
  $('body').append('<div class="modal fade bs-example-modal-md other-activity-modal"tabindex="-1"role="dialog"aria-labelledby="myLargeModalLabel"><div class="modal-dialog modal-md"role="document"><div class="modal-content"><div class="modal-header"><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"id="myModalLabel">'+modalTitle+'</h4></div><div class="modal-body main-con"><div class="main-table table-responsive"><table class="table table-hover table-condensed"id="testtable1"><thead><tr><th style="width: 10%;">ID</th><th style="width: 20%;">活动名称</th><th style="width: 50%;">活动时间</th><th style="width: 20%;">详情</th></tr></thead><tbody></tbody><tfoot><tr><td colspan="4"style="text-align: left;"class="tfoot-control"><nav aria-label="Page navigation"class="page-nav-outer"id="PageNavId"style="float: right;"></nav></td></tr></tfoot></table></div></div><div class="modal-footer"><button type="button"class="btn btn-default"data-dismiss="modal">关闭</button></div></div></div></div>');
  
  var dataId = $(ev).parents('tr').attr('data-id');
  console.log(dataId)

  $.each(productSel,function(idx,items){
    if(items.id == dataId){
      obj = items.activity;
      return false;
    }
  });

  actPageShow('.other-activity-modal',obj,1,pageDisplay);
  var pageNavObj = null;//用于储存分页对象
  pageCou = Math.ceil(obj.length/pageDisplay);
  pageJson = obj;
  pageNavObj = new PageNavCreate("PageNavId",{
        pageCount:pageCou, 
        currentPage:1, 
        perPageNum:5, 
  });
  pageNavObj.afterClick(pageNavCallBack_act);

  $('.modal').on('hidden.bs.modal', function () {
    $(this).remove();
  });
}
function actPageShow(parent,pageJson,clickPage,pageDisplay){
  $(parent+' .main-table tbody').html('');
  // $(".modal .btn-primary").addClass('disabled');

  
  var endTime = $('#new_end_time').val();
  var startTime = $('#new_start_time').val();
  var obj = [];
  console.log(pageJson)
  var actLength = pageJson.length;

  // var lastState = false;
  // if(actLength==1){
  //   if(endTime<pageJson[0].startTime||startTime>pageJson[0].endTime){
  //   }else{
  //     obj.push(pageJson[0].id);
  //     $.Toast("提示", "商品: "+pageJson[0].id+" ,在其他活动优惠中，请重新选择", "notice", {});
  //   }
  // }else{
  //   $.each(pageJson,function(i,items){
  //     switch(true){
  //       case i==0:{
  //         if(endTime<items.startTime){
  //           return false;
  //         }else if(startTime>items.endTime){
  //           lastState = true;
  //         }
  //         break;
  //       }
  //       case i!=0&&i!=(actLength-1):{
  //         console.log(endTime<items.startTime&&lastState)
  //         console.log(startTime>items.endTime)
  //         console.log(lastState)
  //         if(endTime<items.startTime&&lastState){
  //           return false;
  //         }else{
  //           lastState = false;
  //         }
  //         if(startTime>items.endTime){
  //           lastState = true;
  //         }
  //         break;
  //       }
  //       case i==(actLength-1):{
  //         console.log(endTime<items.startTime&&lastState)
  //         console.log(startTime>items.endTime)
  //         console.log(lastState)
  //         if(endTime<items.startTime&&lastState){
  //           return false;
  //         }else if(startTime>items.endTime){
  //           return false;
  //         }else{
  //           obj.push(items.id);
  //           $.Toast("提示", "商品: "+items.id+" ,在其他活动优惠中，请重新选择", "notice", {});
  //           // return false;
  //         }
  //         break;
  //       }
  //     }
  //   });
  // }
  // console.log(obj)

  $.each(pageJson,function(i,items){
    if(((clickPage-1)*pageDisplay)<=i&&(clickPage*pageDisplay)-1>=i){

      


      var $tr = $('<tr></tr>');
      var trHtml = 
        '<td>'+items.id+'</td>'+
        '<td>'+items.name+'</td>'+
        '<td>'+items.startTime+' ~ '+items.endTime+'</td>'+
        '<td><a href="'+items.link+'" target="_blank">查看</a></td>';

      $tr.append(trHtml);
      $(parent + ' .modal-body tbody').append($tr);
    }
  });
}
/*营销-限时活动-其他活动--E---------------------------------------*/

