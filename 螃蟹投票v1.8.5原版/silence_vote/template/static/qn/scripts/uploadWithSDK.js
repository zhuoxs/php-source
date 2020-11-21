function randomPassword(size)
{
  var seed = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z',
  'a','b','c','d','e','f','g','h','i','j','k','m','n','p','Q','r','s','t','u','v','w','x','y','z',
  '2','3','4','5','6','7','8','9'
  );//数组
  seedlength = seed.length;//数组长度
  var createPassword = '';
  for (i=0;i<size;i++) {
    j = Math.floor(Math.random()*seedlength);
    createPassword += seed[j];
  }
  return createPassword;
}

function uploadWithSDK(token, putExtra, config, domain) {
  // 切换tab后进行一些css操作
  controlTabDisplay("sdk");
  $("#select2").unbind("change").bind("change",function(){
    var file = this.files[0];
    // eslint-disable-next-line
    var finishedAttr = [];
    // eslint-disable-next-line
    var compareChunks = [];
    var observable;
    if (file) {
      var keyname = file.name;
      var arr = keyname.split('.');
      var kn = arr[0]+randomPassword(4);
      var key = kn+'.'+arr[arr.length-1]; 
      // 添加上传dom面板
      var board = addUploadBoard(file, config, key, "");
      if (!board) {
        return;
      }
      putExtra.params["x:name"] = key.split(".")[0];
      board.start = true;
      var dom_total = $(board)
        .find("#totalBar")
        .children("#totalBarColor");

      // 设置next,error,complete对应的操作，分别处理相应的进度信息，错误信息，以及完成后的操作
      var error = function(err) {
        board.start = true;
        $(board).find(".control-upload").text("继续上传");
        console.log(err);
        alert("上传出错")
      };

      var complete = function(res) {
          //完成后隐藏选择文件
//        $('#box2').css('display','none');
        $(board)
          .find("#totalBar")
          .addClass("hide");
        $(board)
          .find(".control-container")
          .html(
//            "<p><strong>Hash：</strong>" +
//              res.hash +
//              "</p>" +
//              "<p><strong>Bucket：</strong>" +
//              res.bucket +
//              "</p>" +
//              "<p><strong>Key:</strong>"+
//              res.key+
//              "</p>"+
//              "<input type='hidden' name='video[]' value='"+res.key+"' />"
            "<p><strong>视频上传成功！</strong>"+
            "<input type='hidden' name='videoarr[]' value='"+res.key+"' />"+
            "<input class='qiint' name='videodesc[]'  type='text' placeholder='请输入视频描述'>"
          );
        if (res.key && res.key.match(/\.(jpg|jpeg|png|gif)$/)) {
          imageDeal(board, res.key, domain);
        }
      
      };

      var next = function(response) {
        var chunks = response.chunks||[];
        var total = response.total;
        // 这里对每个chunk更新进度，并记录已经更新好的避免重复更新，同时对未开始更新的跳过
        for (var i = 0; i < chunks.length; i++) {
          if (chunks[i].percent === 0 || finishedAttr[i]){
            continue;
          }
          if (compareChunks[i].percent === chunks[i].percent){
            continue;
          }
          if (chunks[i].percent === 100){
            finishedAttr[i] = true;
          }
          $(board)
            .find(".fragment-group li")
            .eq(i)
            .find("#childBarColor")
            .css(
              "width",
              chunks[i].percent + "%"
            );
        }
        $(board)
          .find(".speed")
          .text("进度：" + total.percent + "% ").css('display','none');
        dom_total.css(
          "width",
          total.percent + "%"
        );
        compareChunks = chunks;
      };

      var subObject = { 
        next: next,
        error: error,
        complete: complete
      };
      var subscription;
      // 调用sdk上传接口获得相应的observable，控制上传和暂停
      observable = qiniu.upload(file, key, token, putExtra, config);

      $(board)
        .find(".control-upload")
        .on("click", function() {
          if(board.start){
            $(this).text("暂停上传");
            board.start = false;
            subscription = observable.subscribe(subObject);
          }else{
            board.start = true;
            $(this).text("继续上传");
            subscription.unsubscribe();
          }
        });
    }
  })
}

