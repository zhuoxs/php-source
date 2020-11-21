$(function(){
	var usernameInput = $("#userName");

	var usernameSaveCheckBox = $("#usernameSave");
	usernameSaveCheckBox.change(function () {
		var checkboxTrigger = $("#checkboxTrigger");
		if ($(this).prop("checked")) {
			checkboxTrigger.addClass("checkbox-icon-checked");
		} else {
			checkboxTrigger.removeClass("checkbox-icon-checked");
			//$.removeCookie("usernameSave");
		}
	});

	var usernameCookie = $.cookie("usernameSave");
	//根据cookie初始化用户名
	if(usernameCookie && (usernameCookie!=="0")){
		usernameSaveCheckBox.prop("checked",true).change();
		usernameInput.val(usernameCookie);
	} else {
		usernameSaveCheckBox.prop("checked",false).change();
	}

	//创建随机数
	var createStartIndex = function() {
		var indexCeiling = $(".pattern-area").children().length;
		return Math.floor(Math.random()*indexCeiling);
	};

	var fadeInDuration = 800;
	var bgContainer = $(".bg-back");
	var $bgSwitchItem = bgContainer.children();
	patternSwitch($(".pattern-area"),{
			indexContainer: $(".bg-change"),
			switchItemCurrentClass: "switch--current",
			indexPointerCurrentClass:"bg-change--current",
			indexUlClass: "",
			indexPointClass: "",
			switchInterval: 7000,
			fadeInDuration: fadeInDuration,
			startIndex: createStartIndex(),
			beforeSwitchHandle: function(index){

				$bgSwitchItem.fadeOut(fadeInDuration);

				if(index == 0) {
					fadeInDuration = 200;
				}else {
					fadeInDuration*=0.6;
				}
				$bgSwitchItem.eq(index).fadeIn(fadeInDuration);

			},
			initSwitchHandle: function(index){
				$bgSwitchItem.hide();
				$bgSwitchItem.eq(index).show();
			}
		}
	);
	//username输入栏失焦时判断验证次数
	usernameInput.blur(function(){
		var userNameVal = usernameInput.val();
		$.getJSON("/login/checkUserName.html?username="+userNameVal+"&jsoncallback=?",function(data){
			if(data.captcha){
				$(".captcha-deck").show();
			}
		});
	});
	//验证账号是否需要验证码
	if(usernameInput.val()){
		usernameInput.blur();
	}

	//提交表单
	var $loginForm = $("#loginForm");
	var $_loginSubmit = $("#loginSubmit");
	$_loginSubmit.on('click', function(e) {
		e.preventDefault();
		//用户名cookie保存
		if(usernameSaveCheckBox.prop("checked")){
			if(usernameInput.val()){
				$.cookie("usernameSave", usernameInput.val(),  { expires: 30, path: '/' });
			}
		} else {
			$.removeCookie("usernameSave", { path: '/' });
		}
		$.ajax({
			type: "post",
			url: "/login/login.html",
			data: $loginForm.serialize(),
			success: function (dataString) {
				var responseData = eval("(" + dataString + ")");
				if (!responseData.result) {
					NY.warn(responseData.text);
					if(responseData.captchaRefresh){
						$(".show-captcha").click();
					}
					if(responseData.captchaRequire){
						$(".captcha-deck").show();
					}
					$.removeCookie("usernameSave", { path: '/' });
				} else {
					NY.success(responseData.text);
				}
				if(responseData.url){
					var jumpDelay = responseData.time*1000 || 2000;
					setTimeout(function(){
						window.location.href = responseData.url;
					}, jumpDelay);
				}
			},
			error: function() {
				NY.showBusy();
			}
		});
		return false;
	});
	//输入框focus样式
	$loginForm.on("focus",".input-focus-handle",function(){
		$(this).parent().addClass("input-outer--focus");
	}).on("blur",".input-focus-handle",function(){
		$(this).parent().removeClass("input-outer--focus");
	});

	//回车提交
	$('body').keydown(function(e) {
		if(e.keyCode == 13) {
			$_loginSubmit.trigger("click");
		}
	});

	// 用户名的邮箱列表自动完成
	var suggestDomainList = [
		"@qq.com",
		"@163.com",
		"@126.com",
		"@sina.com",
		"@sina.cn",
		"@gmail.com",
		"@hotmail.com",
		"@yeah.net",
		"@sohu.com",
		"@21cn.com",
		"@sogou.com",
		"@51uc.com",
		"@outlook.com",
		"@live.com"
	];
	usernameInput.autocomplete({
		appendTo: "#emailAutoComplete",
		source: function(request, response){
			var term = request.term;

			// 只有当用户输入非数字（即不使用手机和会员ID），才提醒邮箱后缀列表
			if ($.isNumeric(term)) {
				response([]);
				return;
			}

			var termSplit = term.split("@");
			var username = termSplit[0];
			var domainName = termSplit[1] || "";


			var dataList = $.map(suggestDomainList, function (suggestDomain) {
				if (suggestDomain.indexOf(domainName) != -1) {
					return {
						term: term,
						inputUsername: username,
						inputDomainName: domainName,
						// value 为了在input中显示
						value: username + suggestDomain,
						// cut '@'
						suggestDomain: suggestDomain.slice(1)
					};
				}
				else {
					return;
				}
			});


			response(dataList.slice(0, 10));
		}
	});

	var TEXT_HIGHLIGHT_CLASSNAME = "ui-autocomplete-text-highlight";
	usernameInput.autocomplete("instance")._renderItem = function(ul, item) {
		var $_li = $("<li>");
		var userInputValue = item.term;
		var inputDomainName = item.inputDomainName;
		var suggestDomain = item.suggestDomain;

		// append highlight username
		var $_inputUsernameSpan = $("<span>").addClass(TEXT_HIGHLIGHT_CLASSNAME).html(item.inputUsername);
		$_li.append($_inputUsernameSpan);

		var $_atSpan = $("<span>").html("@");
		// 当用户输入'@'时，将@也高亮
		if (userInputValue.indexOf("@") != -1) {
			$_atSpan.addClass(TEXT_HIGHLIGHT_CLASSNAME);
		}
		$_li.append($_atSpan);

		// 为 suggestDomain 部分 进行高亮设置
		$.each(suggestDomain.split(""), function (i, charValue) {
			var $_charSpan = $("<span>").html(charValue);

			if (inputDomainName.indexOf(charValue) != -1) {
				$_charSpan.addClass(TEXT_HIGHLIGHT_CLASSNAME);
			}

			$_li.append($_charSpan);
		});
		$_li.appendTo(ul);

		return $_li;
	};
});