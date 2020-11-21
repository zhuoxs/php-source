$(function() {
	function a() {
		d = Business.categoryCombo($("#catorage"), {
			editable: !1,
			extraListHtml: "",
			addOptions: {
				value: -1,
				text: "选择供应商类别"
			},
			defaultSelected: 0,
			trigger: !0,
			width: 120
		}, "supplytype")
	}
	function b() {
		var a = Public.setGrid(),
			b = parent.SYSTEM.rights,
			c = !(parent.SYSTEM.isAdmin || b.AMOUNT_INAMOUNT),
			d = [{
				name: "operate",
				label: "操作",
				width: 60,
				fixed: !0,
				formatter: Public.operFmatter,
				title: !1
			}, {
				name: "customerType",
				label: "供应商类别",
				index: "customerType",
				width: 100,
				title: !1
			}, {
				name: "number",
				label: "供应商编号",
				index: "number",
				width: 100,
				title: !1
			}, {
				name: "name",
				label: "供应商名称",
				index: "name",
				width: 220,
				classes: "ui-ellipsis"
			}, {
				name: "contacter",
				label: "首要联系人",
				index: "contacter",
				width: 100,
				align: "center"
			}, {
				name: "mobile",
				label: "手机",
				index: "mobile",
				width: 100,
				align: "center",
				title: !1
			}, {
				name: "telephone",
				label: "座机",
				index: "telephone",
				width: 100,
				title: !1
			}, {
				name: "linkIm",
				label: "QQ/MSN",
				index: "linkIm",
				width: 100,
				title: !1
			}, {
				name: "difMoney",
				label: "期初往来余额",
				index: "difMoney",
				width: 100,
				align: "right",
				title: !1,
				formatter: "currency",
				hidden: c
			}, {
				name: "delete",
				label: "状态",
				index: "delete",
				width: 80,
				align: "center",
				formatter: g.statusFmatter
			}];
		h.gridReg("grid", d), d = h.conf.grids.grid.colModel, $("#grid").jqGrid({
			url: "../basedata/contact?type=10&action=list&isDelete=2",
			datatype: "json",
			autowidth: !0,
			height: a.h,
			altRows: !0,
			gridview: !0,
			onselectrow: !1,
			multiselect: !0,
			colModel: d,
			pager: "#page",
			viewrecords: !0,
			cmTemplate: {
				sortable: !1
			},
			rowNum: 100,
			rowList: [100, 200, 500],
			shrinkToFit: !1,
			forceFit: !0,
			jsonReader: {
				root: "data.rows",
				records: "data.records",
				total: "data.total",
				repeatitems: !1,
				id: "id"
			},
			loadComplete: function(a) {
				if (a && 200 == a.status) {
					var b = {};
					a = a.data;
					for (var c = 0; c < a.rows.length; c++) {
						var d = a.rows[c];
						b[d.id] = d
					}
					$("#grid").data("gridData", b)
				} else {
					var f = 250 === a.status ? e ? "没有满足条件的结果哦！" : "没有客户数据哦！" : a.msg;
					parent.Public.tips({
						type: 2,
						content: f
					})
				}
			},
			loadError: function(a, b, c) {
				parent.Public.tips({
					type: 1,
					content: "操作失败了哦，请检查您的网络链接！"
				})
			},
			resizeStop: function(a, b) {
				h.setGridWidthByIndex(a, b, "grid")
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
				h.config()
			},
			position: "last"
		})
	}
	function c() {
		$_matchCon = $("#matchCon"), $_matchCon.placeholder(), $("#search").on("click", function(a) {
			a.preventDefault();
			var b = $_matchCon.val() === $_matchCon[0].defaultValue ? "" : $.trim($_matchCon.val()),
				c = d ? d.getValue() : -1;
			$("#grid").jqGrid("setGridParam", {
				page: 1,
				postData: {
					skey: b,
					categoryId: c
				}
			}).trigger("reloadGrid")
		}), $("#btn-add").on("click", function(a) {
			a.preventDefault(), Business.verifyRight("PUR_ADD") && f.operate("add")
		}), $("#btn-print").on("click", function(a) {
			a.preventDefault()
		}), $("#btn-import").on("click", function(a) {
			a.preventDefault(), Business.verifyRight("BaseData_IMPORT") && parent.$.dialog({
				width: 560,
				height: 300,
				title: "批量导入",
				content: "url:../import",
				lock: !0 ,
				close: function (event, ui) {  
	               
	            },
				data:{
					callback: function() {
						$("#search").click();
					}	
				}
			})
		}), $("#btn-export").on("click", function(a) {
			if (Business.verifyRight("PUR_EXPORT")) {
				var b = $_matchCon.val() === $_matchCon[0].defaultValue ? "" : $.trim($_matchCon.val());
				$(this).attr("href", "../basedata/supplier/exporter?action=exporter&isDelete=2&skey=" + b)
			}
		}), $("#grid").on("click", ".operating .ui-icon-pencil", function(a) {
			if (a.preventDefault(), Business.verifyRight("PUR_UPDATE")) {
				var b = $(this).parent().data("id");
				f.operate("edit", b)
			}
		}), $("#grid").on("click", ".operating .ui-icon-trash", function(a) {
			if (a.preventDefault(), Business.verifyRight("PUR_DELETE")) {
				var b = $(this).parent().data("id");
				f.del(b + "")
			}
		}), $("#btn-batchDel").click(function(a) {
			if (a.preventDefault(), Business.verifyRight("PUR_DELETE")) {
				var b = $("#grid").jqGrid("getGridParam", "selarrrow");
				b.length ? f.del(b.join()) : parent.Public.tips({
					type: 2,
					content: "请选择需要删除的项"
				})
			}
		}), $("#btn-disable").click(function(a) {
			a.preventDefault();
			var b = $("#grid").jqGrid("getGridParam", "selarrrow").concat();
			return b && 0 != b.length ? void f.setStatuses(b, !0) : void parent.Public.tips({
				type: 1,
				content: " 请先选择要禁用的供应商！"
			})
		}), $("#btn-enable").click(function(a) {
			a.preventDefault();
			var b = $("#grid").jqGrid("getGridParam", "selarrrow").concat();
			return b && 0 != b.length ? void f.setStatuses(b, !1) : void parent.Public.tips({
				type: 1,
				content: " 请先选择要启用的供应商！"
			})
		}), $("#grid").on("click", ".set-status", function(a) {
			if (a.stopPropagation(), a.preventDefault(), Business.verifyRight("INVLOCTION_UPDATE")) {
				var b = $(this).data("id"),
					c = !$(this).data("delete");
				f.setStatus(b, c)
			}
		}), $(window).resize(function() {
			Public.resizeGrid()
		})
	}
	var d, e = !1,
		f = {
			operate: function(a, b) {
				if ("add" == a) var c = "新增供应商",
					d = {
						oper: a,
						callback: this.callback
					};
				else var c = "修改供应商",
					d = {
						oper: a,
						rowId: b,
						callback: this.callback
					};
				$.dialog({
					title: c,
					content: "url:vendor_manage",
					data: d,
					width: 640,
					height: 442,
					max: !1,
					min: !1,
					cache: !1,
					lock: !0
				})
			},
			del: function(a) {
				$.dialog.confirm("删除的供应商将不能恢复，请确认是否删除？", function() {
					Public.ajaxPost("../basedata/contact/delete?type=10&action=delete", {
						id: a
					}, function(b) {
						if (b && 200 == b.status) {
							var c = b.data.id || [];
							a.split(",").length === c.length ? parent.Public.tips({
								content: "成功删除" + c.length + "个供应商！"
							}) : parent.Public.tips({
								type: 2,
								content: b.data.msg,
								autoClose: !1
							});
							for (var d = 0, e = c.length; e > d; d++) $("#grid").jqGrid("setSelection", c[d]), $("#grid").jqGrid("delRowData", c[d])
						} else parent.Public.tips({
							type: 1,
							content: "删除供应商失败！" + b.msg
						})
					})
				})
			},
			setStatus: function(a, b) {
				a && Public.ajaxPost("../basedata/contact/disable?action=disable", {
					contactIds: a,
					disable: Number(b)
				}, function(c) {
					c && 200 == c.status ? (parent.Public.tips({
						content: "供应商状态修改成功！"
					}), $("#grid").jqGrid("setCell", a, "delete", b)) : parent.Public.tips({
						type: 1,
						content: "供应商状态修改失败！" + c.msg
					})
				})
			},
			setStatuses: function(a, b) {
				if (a && 0 != a.length) {
					var c = $("#grid").jqGrid("getGridParam", "selarrrow"),
						d = c.join();
					Public.ajaxPost("../basedata/contact.do?action=disable", {
						contactIds: d,
						disable: Number(b)
					}, function(c) {
						if (c && 200 == c.status) {
							parent.Public.tips({
								content: "供应商状态修改成功！"
							});
							for (var d = 0; d < a.length; d++) {
								var e = a[d];
								$("#grid").jqGrid("setCell", e, "delete", b)
							}
						} else parent.Public.tips({
							type: 1,
							content: "供应商状态修改失败！" + c.msg
						})
					})
				}
			},
			callback: function(a, b, c) {
				var d = $("#grid").data("gridData");
				d || (d = {}, $("#grid").data("gridData", d)), a.difMoney = a.amount - a.periodMoney, d[a.id] = a, "edit" == b ? ($("#grid").jqGrid("setRowData", a.id, a), c && c.api.close()) : ($("#grid").jqGrid("addRowData", a.id, a, "first"), c && c.resetForm(a))
			}
		},
		g = {
			statusFmatter: function(a, b, c) {
				var d = 1 == a ? "已禁用" : "已启用",
					e = 1 == a ? "ui-label-default" : "ui-label-success";
				return '<span class="set-status ui-label ' + e + '" data-delete="' + a + '" data-id="' + c.id + '">' + d + "</span>"
			}
		},
		h = Public.mod_PageConfig.init("vendorList");
	a(), b(), c()
});