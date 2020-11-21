  //'./index.php?c=site&a=entry&do=getqntoken&m=silence_vote'
  $.ajax({url: gettkurl, success: function(res){
    res = eval('('+res+')');
    var token = res.uptoken;
    var domain = res.domain;
    console.log(token);
    console.log(domain);
    var config = {
      useCdnDomain: true,
      disableStatisticsReport: false,
      retryCount: 6,
//      region: qiniu.region.z2
      region: null
    };
    var putExtra = {
      fname: "",
      params: {},
      mimeType: null
    };
    $(".nav-box")
      .find("a")
      .each(function(index) {
        $(this).on("click", function(e) {
          switch (e.target.name) {
            case "h5":
              uploadWithSDK(token, putExtra, config, domain);
              break;
            case "expand":
              uploadWithOthers(token, putExtra, config, domain);
              break;
            case "directForm":
              uploadWithForm(token, putExtra, config);
              break;
            default:
              "";
          }
        });
      });
    imageControl(domain);
    uploadWithSDK(token, putExtra, config, domain);
  }})
