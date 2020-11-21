var urlParam = Public.urlParam(),
	queryConditions = {
		matchCon: ""
	},
	hiddenAmount = !1,
	SYSTEM = system = parent.SYSTEM,
	THISPAGE = {
		init: function(a) {
			SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_COSTAMOUNT || (hiddenAmount = !0), this.mod_PageConfig = Public.mod_PageConfig.init("accountTransferList"), this.initDom(), this.loadGrid(), this.addEvent()
		},
		initDom: function() {
			this.$_matchCon = $("#matchCon"), this.$_beginDate = $("#beginDate").val(system.beginDate), this.$_endDate = $("#endDate").val(system.endDate), this.$_acctPay = $("#acctPay"), this.$_acctRec = $("#acctRec"), this.$_matchCon.placeholder(), this.$_beginDate.datepicker(), this.$_endDate.datepicker(), SYSTEM.isAdmin !== !1 || SYSTEM.rights.SettAcct_QUERY ? (this.acctPayCombo = Business.accountCombo(this.$_acctPay, {
				addOptions: {
					text: "(全部)",
					value: -1
				},
				width: 110
			}), this.acctRecCombo = Business.accountCombo(this.$_acctRec, {
				addOptions: {
					text: "(全部)",
					value: -1
				},
				width: 110
			})) : (this.$_acctPay.parent().hide(), this.$_acctRec.parent().hide())
		},
		splitFmatter: function(a, b, c) {
			var d;
			if (c.entries && c.entries.length && b.colModel.name && (d = $.map(c.entries, function(a) {
				return "<span>" + a["" + b.colModel.name] + "</span>"
			})), d) var e = d.join('<p class="line" />');
			return e || "&#160;"
		},
		loadGrid: function() {
			function a(a, b, c) {
				var d = '<div class="operating" data-id="' + c.billId + '"><span class="ui-icon ui-icon-pencil" title="修改"></span><span class="ui-icon ui-icon-trash" title="删除"></span></div>';
				return d
			}
			var b = Public.setGrid();
			queryConditions.beginDate = this.$_beginDate.val(), queryConditions.endDate = this.$_endDate.val(), "undefined" != typeof urlParam.id && "" != urlParam.id && (queryConditions.id = urlParam.id);
			var c = !(SYSTEM.isAdmin === !1 && !SYSTEM.rights.SettAcct_QUERY),
				d = [{
					name: "operating",
					label: "操作",
					width: 60,
					fixed: !0,
					formatter: a,
					align: "center"
				}, {
					name: "billDate",
					label: "转账日期",
					width: 100,
					align: "center"
				}, {
					name: "billNo",
					label: "单据编号",
					width: 120,
					align: "center"
				}, {
					name: "paySettacctName",
					label: "转出账户",
					width: 100,
					align: "center",
					classes: "ui-ellipsis",
					hidden: !c,
					formatter: THISPAGE.splitFmatter
				}, {
					name: "recSettacctName",
					label: "转入账户",
					width: 100,
					align: "center",
					classes: "ui-ellipsis",
					hidden: !c,
					formatter: THISPAGE.splitFmatter
				}, {
					name: "amount",
					label: "金额",
					width: 100,
					align: "right",
					classes: "ui-ellipsis",
					hidden: !c,
					formatter: THISPAGE.splitFmatter
				}, {
					name: "amount",
					label: "合计金额",
					hidden: hiddenAmount,
					width: 100,
					align: "right",
					formatter: "currency"
				}, {
					name: "description",
					label: "备注",
					width: 150
				}];
			this.mod_PageConfig.gridReg("grid", d), d = this.mod_PageConfig.conf.grids.grid.colModel, $("#grid").jqGrid({
				url: "../scm/fundTf?action=list",
				postData: queryConditions,
				datatype: "json",
				autowidth: !0,
				height: b.h,
				altRows: !0,
				gridview: !0,
				multiselect: !0,
				multiboxonly: !0,
				colModel: d,
				cmTemplate: {
					sortable: !1,
					title: !1
				},
				page: 1,
				sortname: "number",
				sortorder: "desc",
				pager: "#page",
				rowNum: 100,
				rowList: [100, 200, 500],
				viewrecords: !0,
				shrinkToFit: !1,
				forceFit: !0,
				jsonReader: {
					root: "data.rows",
					records: "data.records",
					repeatitems: !1,
					total: "data.total",
					id: "billId"
				},
				loadError: function(a, b, c) {},
				ondblClickRow: function(a, b, c, d) {
					$("#" + a).find(".ui-icon-pencil").trigger("click")
				},
				resizeStop: function(a, b) {
					THISPAGE.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
				}
			}).navGrid("#page", {
				edit: !1,
				add: !1,
				del: !1,
				search: !1,
				refresh: !1
			}).navButtonAdd("#page", {
				caption: "",
				buttonicon: "ui-icon-config",
				onClickButton: function() {
					THISPAGE.mod_PageConfig.config()
				},
				position: "last"
			})
		},
		reloadData: function(a) {
			$("#grid").jqGrid("setGridParam", {
				url: "../scm/fundTf?action=list",
				datatype: "json",
				postData: a
			}).trigger("reloadGrid")
		},
		addEvent: function() {
			var a = this;
			$(".grid-wrap").on("click", ".ui-icon-pencil", function(a) {
				a.preventDefault();
				var b = $(this).parent().data("id");
				parent.tab.addTabItem({
					tabid: "money-accountTransfer",
					text: "资金转账单",
					url: "../scm/fundTf?action=editFundTf&id=" + b
				});
				$("#grid").jqGrid("getDataIDs");
				parent.accountTransferListIds = $("#grid").jqGrid("getDataIDs")
			}), $(".grid-wrap").on("click", ".ui-icon-trash", function(a) {
				if (a.preventDefault(), Business.verifyRight("ZJZZ_DELETE")) {
					var b = $(this).parent().data("id");
					$.dialog.confirm("您确定要删除该收入记录吗？", function() {
						Public.ajaxGet("../scm/fundTf/delete?action=delete", {
							id: b
						}, function(a) {
							200 === a.status ? ($("#grid").jqGrid("delRowData", b), parent.Public.tips({
								content: "删除成功！"
							})) : parent.Public.tips({
								type: 1,
								content: a.msg
							})
						})
					})
				}
			}), $("#search").click(function() {
				queryConditions.matchCon = "请输入单据号或备注" === a.$_matchCon.val() ? "" : a.$_matchCon.val(), queryConditions.beginDate = a.$_beginDate.val(), queryConditions.endDate = a.$_endDate.val(), a.acctPayCombo && (queryConditions.paySettacctId = a.acctPayCombo.getValue()), a.acctRecCombo && (queryConditions.recSettacctId = a.acctRecCombo.getValue()), THISPAGE.reloadData(queryConditions)
			}), $("#add").click(function(a) {
				a.preventDefault(), Business.verifyRight("ZJZZ_ADD") && parent.tab.addTabItem({
					tabid: "money-accountTransfer",
					text: "资金转账单",
					url: "../scm/fundTf?action=initFundTf"
				})
			}), $("#export").click(function(a) {
				if (!Business.verifyRight("ZJZZ_EXPORT")) return void a.preventDefault();
				var b = $("#grid").jqGrid("getGridParam", "selarrrow"),
					c = b.join(),
					d = c ? "&id=" + c : "";
				for (var e in queryConditions) queryConditions[e] && (d += "&" + e + "=" + queryConditions[e]);
				var f = "../scm/fundTf/export?action=export" + d;
				$(this).attr("href", f)
			}), $(window).resize(function() {
				Public.resizeGrid()
			})
		}
	};
$(function() {
	THISPAGE.init()
});