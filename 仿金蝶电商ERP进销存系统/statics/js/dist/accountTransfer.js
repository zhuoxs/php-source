var curRow, curCol, curArrears, loading, urlParam = Public.urlParam(),
	SYSTEM = parent.SYSTEM,
	hiddenAmount = !1,
	requiredMoney = SYSTEM.requiredMoney,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	hasLoaded = !1,
	originalData, THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("accountTransfer"), SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_COSTAMOUNT || (hiddenAmount = !0), this.loadGrid(a), this.initDom(a), this.initCombo(), this.addEvent(), THISPAGE.calTotal()
		},
		initDom: function(a) {
			this.$_date = $("#date").val(SYSTEM.endDate), this.$_number = $("#number"), this.$_note = $("#note"), this.$_toolTop = $("#toolTop"), this.$_toolBottom = $("#toolBottom"), this.$_userName = $("#userName"), this.$_modifyTime = $("#modifyTime"), this.$_createTime = $("#createTime"), this.$_note.placeholder(), this.$_date.datepicker({
				onSelect: function(a) {
					if (!(originalData.id > 0)) {
						var b = a.format("yyyy-MM-dd");
						THISPAGE.$_number.text(""), Public.ajaxPost("../basedata/systemProfile/generateDocNo?action=generateDocNo", {
							billType: "ZJZZ",
							billDate: b
						}, function(a) {
							200 === a.status ? THISPAGE.$_number.text(a.data.billNo) : parent.Public.tips({
								type: 1,
								content: a.msg
							})
						})
					}
				}
			}), a.id > 0 ? (this.$_number.text(a.billNo), this.$_date.val(a.billDate), a.description && this.$_note.val(a.description), $("#grid").jqGrid("footerData", "set", {
				qty: a.totalQty,
				amount: a.totalAmount
			}), this.$_toolBottom.html('<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a id="edit" class="ui-btn mrb">保存</a>'), this.accountTransferListIds = parent.accountTransferListIds || [], this.idPostion = $.inArray(String(a.id), this.accountTransferListIds), this.idLength = this.accountTransferListIds.length, 0 === this.idPostion && $("#prev").addClass("ui-btn-prev-dis"), this.idPostion === this.idLength - 1 && $("#next").addClass("ui-btn-next-dis"), this.$_userName.html(a.userName), this.$_modifyTime.html(a.modifyTime), this.$_createTime.html(a.createTime)) : (this.$_toolBottom.html('<a id="savaAndAdd" class="ui-btn ui-btn-sp mrb">保存并新增</a><a id="save" class="ui-btn">保存</a>'), this.$_userName.html(SYSTEM.realName || ""), this.$_modifyTime.parent().hide(), this.$_createTime.parent().hide())
		},
		loadGrid: function(a) {
			function b(a, b, c) {
				return a ? a : "&#160;"
			}
			function c(a, b) {
				var c = $(".accountAuto_0")[0];
				return c
			}
			function d(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".accountAuto_0").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("accountInfo_0"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function e() {
				$("#initCombo").append($(".accountAuto_0").val("").unbind("focus.once"))
			}
			function f(a, b, c) {
				return a ? a : "&#160;"
			}
			function g(a, b) {
				var c = $(".accountAuto")[0];
				return c
			}
			function h(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".accountAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("accountInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function i() {
				$("#initCombo").append($(".accountAuto").val("").unbind("focus.once"))
			}
			function j(a, b, c) {
				return a ? a : "&#160;"
			}
			function k(a, b) {
				var c = $(".payTypeAuto")[0];
				return c
			}
			function l(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".payTypeAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("payTypeInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function m() {
				$("#initCombo").append($(".payTypeAuto").val("").unbind("focus.once"))
			}
			var n = this;
			if (a.id) {
				var o = 8 - a.entries.length;
				if (o > 0) for (var p = 0; o > p; p++) a.entries.push({})
			}
			n.newId = 9;
			var q = [{
				name: "operating",
				label: " ",
				width: 40,
				fixed: !0,
				formatter: Public.billsOper,
				align: "center"
			}, {
				name: "paySettacctName",
				label: "转出账户",
				width: 200,
				title: !0,
				classes: "ui-ellipsis",
				formatter: b,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: c,
					custom_value: d,
					handle: e,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "recSettacctName",
				label: "转入账户",
				width: 200,
				title: !0,
				classes: "ui-ellipsis",
				formatter: f,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: g,
					custom_value: h,
					handle: i,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "amount",
				label: "金额",
				width: 80,
				align: "right",
				formatter: "number",
				formatoptions: {
					decimalPlaces: amountPlaces
				},
				editable: !0
			}, {
				name: "wayName",
				label: "结算方式",
				width: 200,
				title: !0,
				classes: "ui-ellipsis",
				formatter: j,
				editable: !0,
				edittype: "custom",
				editoptions: {
					custom_element: k,
					custom_value: l,
					handle: m,
					trigger: "ui-icon-triangle-1-s"
				}
			}, {
				name: "refNo",
				label: "结算号",
				width: 150,
				title: !0,
				editable: !0
			}, {
				name: "desc",
				label: "备注",
				width: 150,
				title: !0,
				editable: !0
			}];
			n.mod_PageConfig.gridReg("grid", q), q = n.mod_PageConfig.conf.grids.grid.colModel, $("#grid").jqGrid({
				data: a.entries,
				datatype: "clientSide",
				autowidth: !0,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: q,
				cmTemplate: {
					sortable: !1,
					title: !1
				},
				shrinkToFit: !1,
				forceFit: !0,
				rowNum: 1e3,
				cellEdit: !1,
				cellsubmit: "clientArray",
				localReader: {
					root: "rows",
					records: "records",
					repeatitems: !1,
					id: "id"
				},
				jsonReader: {
					root: "data.entries",
					records: "records",
					repeatitems: !1,
					id: "id"
				},
				loadComplete: function(a) {
					if (urlParam.id > 0) {
						var b = a.rows,
							c = b.length;
						n.newId = c + 1;
						for (var d = 0; c > d; d++) {
							var e = d + 1,
								f = b[d];
							if ($.isEmptyObject(b[d])) break;
							$("#" + e).data("accountInfo_0", {
								id: f.paySettacctId,
								name: f.paySettacctName
							}).data("accountInfo", {
								id: f.recSettacctId,
								name: f.recSettacctName
							}).data("payTypeInfo", {
								id: f.wayId,
								name: f.wayName
							})
						}
					}
				},
				gridComplete: function() {},
				afterEditCell: function(a, b, c, d, e) {
					"paySettacctName" === b && ($("#" + d + "_paySettacctName", "#grid").val(c), THISPAGE.accountCombo_0.selectByText(c), THISPAGE.curID = a), "recSettacctName" === b && ($("#" + d + "_recSettacctName", "#grid").val(c), THISPAGE.accountCombo.selectByText(c), THISPAGE.curID = a), "wayName" === b && ($("#" + d + "_wayName", "#grid").val(c), THISPAGE.paymentCombo.selectByText(c), THISPAGE.curID = a)
				},
				formatCell: function(a, b, c, d, e) {},
				beforeSubmitCell: function(a, b, c, d, e) {},
				afterSaveCell: function(a, b, c, d, e) {
					"amount" === b && n.calTotal()
				},
				resizeStop: function(a, b) {
					n.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
				},
				loadonce: !0,
				footerrow: !0,
				userData: {
					categoryName: "合计：",
					amount: a.totalAmount
				},
				userDataOnFooter: !0,
				loadError: function(a, b, c) {
					Public.tips({
						type: 1,
						content: "Type: " + b + "; Response: " + a.status + " " + a.statusText
					})
				}
			}), $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			})
		},
		reloadData: function(a) {
			$("#grid").clearGridData();
			var b = 8 - a.entries.length;
			if (b > 0) for (var c = 0; b > c; c++) a.entries.push({})
		},
		initCombo: function() {
			requiredMoney && (SYSTEM.isAdmin !== !1 || SYSTEM.rights.SettAcct_QUERY ? (this.accountCombo_0 = Business.accountCombo($(".accountAuto_0"), {
				trigger: !1,
				callback: {
					onChange: function(a) {
						var b = this.input.parents("tr"),
							c = b.data("accountInfo_0") || {};
						a ? a.id != c.id && b.data("accountInfo_0", a) : b.data("accountInfo_0", null)
					}
				}
			}), this.accountCombo = Business.accountCombo($(".accountAuto"), {
				trigger: !1,
				callback: {
					onChange: function(a) {
						var b = this.input.parents("tr"),
							c = b.data("accountInfo") || {};
						a ? a.id != c.id && b.data("accountInfo", a) : b.data("accountInfo", null)
					}
				}
			})) : (this.accountCombo_0 = Business.accountCombo($(".accountAuto_0"), {
				data: [],
				addOptions: {
					text: "(没有账户管理权限)",
					value: 0
				},
				trigger: !1
			}), this.accountCombo = Business.accountCombo($(".accountAuto"), {
				data: [],
				addOptions: {
					text: "(没有账户管理权限)",
					value: 0
				},
				trigger: !1
			}))), this.paymentCombo = Business.paymentCombo($(".payTypeAuto"), {
				trigger: !1,
				width: "",
				callback: {
					onChange: function(a) {
						var b = this.input.parents("tr"),
							c = b.data("payTypeInfo") || {};
						a ? a.id != c.id && b.data("payTypeInfo", a) : b.data("payTypeInfo", null)
					}
				}
			})
		},
		addEvent: function() {
			var a = this;
			this.$_date.bind("keydown", function(a) {
				13 === a.which && $("#grid").jqGrid("editCell", 1, 2, !0)
			}).bind("focus", function(b) {
				a.dateValue = $(this).val()
			}).bind("blur", function(b) {
				var c = /((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/;
				c.test($(this).val()) || (parent.Public.tips({
					type: 2,
					content: "日期格式有误！如：2012-08-08。"
				}), $(this).val(a.dateValue))
			}), $(".grid-wrap").on("click", ".ui-icon-triangle-1-s", function(b) {
				var c, d = $(this).siblings();
				d.hasClass("accountAuto_0") && (c = a.accountCombo_0), d.hasClass("accountAuto") && (c = a.accountCombo), d.hasClass("payTypeAuto") && (c = a.paymentCombo), setTimeout(function() {
					c.active = !0, c.doQuery()
				}, 10)
			}), Business.billsEvent(a, "accountTransfer"), $(".wrapper").on("click", "#save", function(b) {
				b.preventDefault();
				var c = THISPAGE.getPostData();
				c && ("edit" === originalData.stata && (c.id = originalData.id, c.stata = "edit"), Public.ajaxPost("../scm/fundTf/add?action=add", {
					postData: JSON.stringify(c)
				}, function(b) {
					200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), a.$_createTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, urlParam.id = b.data.id, a.$_toolBottom.html('<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a id="edit" class="ui-btn mrb">保存</a>'), parent.Public.tips({
						content: "保存成功！"
					})) : parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#edit", function(b) {
				if (b.preventDefault(), Business.verifyRight("ZJZZ_UPDATE")) {
					var c = THISPAGE.getPostData();
					c && Public.ajaxPost("../scm/fundTf/updateFundTf?action=updateFundTf", {
						postData: JSON.stringify(c)
					}, function(b) {
						200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, urlParam.id = b.data.id, parent.Public.tips({
							content: "修改成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#savaAndAdd", function(b) {
				b.preventDefault();
				var c = THISPAGE.getPostData();
				c && Public.ajaxPost("../scm/fundTf/addNew?action=addNew", {
					postData: JSON.stringify(c)
				}, function(b) {
					if (200 === b.status) {
						a.$_number.text(b.data.billNo), $("#grid").clearGridData(), $("#grid").clearGridData(!0);
						for (var c = 1; 8 >= c; c++) $("#grid").jqGrid("addRowData", c, {});
						a.newId = 9, a.$_note.val(""), parent.Public.tips({
							content: "保存成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: b.msg
					})
				})
			}), $(".wrapper").on("click", "#add", function(a) {
				a.preventDefault(), Business.verifyRight("ZJZZ_ADD") && parent.tab.overrideSelectedTabItem({
					tabid: "money-accountTransfer",
					text: "资金转账单",
					url: "../scm/fundTf/initFundTf?action=initFundTf"
				})
			}), $(".wrapper").on("click", "#print", function(a) {
				return Business.verifyRight("ZJZZ_PRINT") ? void a.preventDefault() : void a.preventDefault()
			}), $("#config").show().click(function(b) {
				a.mod_PageConfig.config()
			}), $(window).resize(function(a) {
				Public.autoGrid($("#grid"))
			})
		},
		resetData: function() {
			var a = this;
			$("#grid").clearGridData();
			for (var b = 1; 8 >= b; b++) $("#grid").jqGrid("addRowData", b, {}), $("#grid").jqGrid("footerData", "set", {
				qty: 0,
				amount: 0
			});
			a.$_note.val("")
		},
		calTotal: function() {
			for (var a = $("#grid").jqGrid("getDataIDs"), b = 0, c = 0, d = a.length; d > c; c++) {
				var e = a[c],
					f = $("#grid").jqGrid("getRowData", e);
				f.amount && (b += parseFloat(f.amount))
			}
			$("#grid").jqGrid("footerData", "set", {
				amount: b
			})
		},
		_getEntriesData: function() {
			for (var a = [], b = $("#grid").jqGrid("getDataIDs"), c = 0, d = b.length; d > c; c++) {
				var e, f = b[c],
					g = $("#grid").jqGrid("getRowData", f);
				if ("" !== g.paySettacctName && "" !== g.recSettacctName && "" !== g.amount) {
					var h = $("#" + f).data("accountInfo_0"),
						i = $("#" + f).data("accountInfo");
					if (g.amount <= 0) return parent.Public.tips({
						type: 2,
						content: "金额必须大于0！"
					}), !1;
					if (h.id === i.id) return parent.Public.tips({
						type: 2,
						content: "转入转出账户不能相同！"
					}), !1;
					var j = $("#" + f).data("payTypeInfo");
					e = {
						paySettacctId: h.id,
						recSettacctId: i.id,
						wayId: j ? j.id || 0 : 0,
						amount: g.amount,
						refNo: g.refNo,
						desc: g.desc || ""
					}, a.push(e)
				}
			}
			return a
		},
		getPostData: function() {
			var a = this;
			null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null);
			var b = this._getEntriesData();
			if (b) {
				var c = $.trim(a.$_note.val());
				if (b.length > 0) {
					a.calTotal();
					var d = {
						id: originalData.id,
						date: $.trim(a.$_date.val()),
						billNo: $.trim(a.$_number.text()),
						entries: b,
						description: "暂无备注信息" === c ? "" : c,
						totalAmount: $("#grid").jqGrid("footerData", "get").amount.replace(/,/g, "")
					};
					return d
				}
				return parent.Public.tips({
					type: 2,
					content: "至少保存一条有效分录数据！"
				}), $("#grid").jqGrid("editCell", 1, 2, !0), !1
			}
		}
	};
$(function() {
	urlParam.id ? hasLoaded || Public.ajaxGet("../scm/fundTf/update?action=update", {
		id: urlParam.id
	}, function(a) {
		200 === a.status ? (originalData = a.data, originalData.id = originalData.billId, originalData.date = originalData.createDate, THISPAGE.init(originalData), hasLoaded = !0) : parent.Public.tips({
			type: 1,
			content: a.msg
		})
	}) : (originalData = {
		id: -1,
		status: "add",
		customer: 0,
		entries: [{
			id: "1"
		}, {
			id: "2"
		}, {
			id: "3"
		}, {
			id: "4"
		}, {
			id: "5"
		}, {
			id: "6"
		}, {
			id: "7"
		}, {
			id: "8"
		}],
		totalQty: 0,
		totalAmount: 0,
		disRate: 0,
		disAmount: 0,
		amount: "0.00",
		rpAmount: "0.00",
		arrears: "0.00"
	}, THISPAGE.init(originalData))
});