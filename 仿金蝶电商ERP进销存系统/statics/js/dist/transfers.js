var curRow, curCol, curArrears, loading, urlParam = Public.urlParam(),
	SYSTEM = parent.SYSTEM,
	billRequiredCheck = SYSTEM.billRequiredCheck,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	defaultPage = Public.getDefaultPage(),
	disEditable = urlParam.disEditable,
	THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("transfers"), this.loadGrid(a), this.initDom(a), this.initCombo(), this.addEvent(), a.id > 0 && a.checked ? this.disableEdit() : (this.editable = !0, $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			}))
		},
		initDom: function(a) {
			this.$_date = $("#date").val(SYSTEM.endDate), this.$_number = $("#number"), this.$_note = $("#note"), this.$_toolTop = $("#toolTop"), this.$_toolBottom = $("#toolBottom"), this.$_userName = $("#userName"), this.$_modifyTime = $("#modifyTime"), this.$_createTime = $("#createTime"), this.$_checkName = $("#checkName"), this.$_note.placeholder(), this.$_date.datepicker({
				onSelect: function(a) {
					if (!(originalData.id > 0)) {
						var b = a.format("yyyy-MM-dd");
						THISPAGE.$_number.text(""), Public.ajaxPost("../basedata/systemProfile/generateDocNo?action=generateDocNo", {
							billType: "TRANSFER",
							billDate: b
						}, function(a) {
							200 === a.status ? THISPAGE.$_number.text(a.data.billNo) : parent.Public.tips({
								type: 1,
								content: a.msg
							})
						})
					}
				}
			});
			var b = '<a id="savaAndAdd" class="ui-btn ui-btn-sp mrb">保存并新增</a><a id="save" class="ui-btn">保存</a>',
				c = '<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a href="../scm/invTf/toPdf?action=toPdf" target="_blank" id="print" class="ui-btn mrb">打印</a><a id="edit" class="ui-btn mrb">保存</a>',
				d = '<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a href="../scm/invTf/toPdf?action=toPdf" target="_blank" id="print" class="ui-btn mrb">打印</a><b></b></a>',
				e = "",
				f = "",
				g = "";
			billRequiredCheck ? (e = '<a class="ui-btn" id="audit">审核</a>', f = '<a class="ui-btn" id="reAudit">反审核</a>') : this.$_checkName.parent().hide();
			var h = '<a class="ui-btn-prev" id="prev" title="上一张"><b></b></a><a class="ui-btn-next" id="next" title="下一张"><b></b></a>';
			if (b += g, this.btn_edit = c, this.btn_audit = e, this.btn_view = d, this.btn_reaudit = f, this.btn_tempSave = g, a.id > 0) {
				if (this.$_number.text(a.billNo), this.$_date.val(a.date), a.description && this.$_note.val(a.description), $("#grid").jqGrid("footerData", "set", {
					qty: a.totalQty,
					amount: a.totalAmount
				}), "list" !== urlParam.flag && (h = ""), "edit" === a.status) {
					var i = "<span id=groupBtn>" + c + e + "</span>" + h;
					a.temp || (i += g), this.$_toolBottom.html(i), !a.temp
				} else a.checked ? ($("#mark").addClass("has-audit"), this.$_toolBottom.html('<span id="groupBtn">' + d + f + "</span>" + h)) : this.$_toolBottom.html('<span id="groupBtn">' + d + "</span>" + h);
				this.transfersListIds = parent.transfersListIds || [], this.idPostion = $.inArray(String(a.id), this.transfersListIds), this.idLength = this.transfersListIds.length, 0 === this.idPostion && $("#prev").addClass("ui-btn-prev-dis"), this.idPostion === this.idLength - 1 && $("#next").addClass("ui-btn-next-dis"), this.$_userName.html(a.userName), this.$_modifyTime.html(a.modifyTime), this.$_createTime.html(a.createTime), this.$_checkName.html(a.checkName)
			} else billRequiredCheck ? this.$_toolBottom.html("<span id=groupBtn>" + b + e + "</span>") : this.$_toolBottom.html('<span id="groupBtn">' + b + "</span>"), this.$_userName.html(SYSTEM.realName || ""), this.$_modifyTime.parent().hide(), this.$_createTime.parent().hide(), this.$_checkName.parent().hide();
			disEditable && (THISPAGE.disableEdit(), this.$_toolBottom.hide())
		},
		loadGrid: function(a) {
			function b(a, b, c) {
				return a ? (x(b.rowId), a) : c.invNumber ? c.invSpec ? c.invNumber + " " + c.invName + "_" + c.invSpec : c.invNumber + " " + c.invName : "&#160;"
			}

			function c(a, b) {
				var c = $(".goodsAuto")[0];
				return c
			}
			function d(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".goodsAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("goodsInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function e() {
				$("#initCombo").append($(".goodsAuto").val("").unbind("focus.once"))
			}
			function f(a, b) {
				var c = $(".skuAuto")[0];
				return c
			}
			function g(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".skuAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("skuInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function h() {
				$("#initCombo").append($(".skuAuto").val(""))
			}
			function i(a, b) {
				var c = $(".storageAuto")[0];
				return c
			}
			function j(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".storageAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("storageInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function k() {
				$("#initCombo").append($(".storageAuto").val(""))
			}
			function l(a, b) {
				var c = $(".inStorage")[0];
				return c
			}
			function m(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".inStorage").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("inStorage"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function n() {
				$("#initCombo").append($(".inStorage").val(""))
			}
			function o(a, b) {
				var c = $(".unitAuto")[0];
				return c
			}
			function p(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".unitAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr"),
						e = d.data("unitInfo") || {};
					return THISPAGE.unitCombo.selectByIndex(e.unitId || e.id), e.name || ""
				}
				"set" === b && $("input", a).val(c)
			}
			function q() {
				$("#initCombo").append($(".unitAuto").val(""))
			}
			function r(a, b) {
				var c = $(".dateAuto")[0];
				return c
			}
			function s(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function t() {
				$("#initCombo").append($(".dateAuto"))
			}
			function u(a, b) {
				var c = $(".batchAuto")[0];
				return c
			}
			function v(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function w() {
				$("#initCombo").append($(".batchAuto").val(""))
			}
			function x(a) {
				var b = $("#" + a).data("goodsInfo");
				if (b) {
					b.batch || $("#grid").jqGrid("setCell", a, "batch", "&#160;"), b.safeDays || ($("#grid").jqGrid("setCell", a, "prodDate", "&#160;"), $("#grid").jqGrid("setCell", a, "safeDays", "&#160;"), $("#grid").jqGrid("setCell", a, "validDate", "&#160;")), 1 == b.isWarranty && $("#grid").jqGrid("showCol", "batch"), b.safeDays > 0 && ($("#grid").jqGrid("showCol", "prodDate"), $("#grid").jqGrid("showCol", "safeDays"), $("#grid").jqGrid("showCol", "validDate"));
					var c = (Number(b.purPrice), {
						skuName: b.skuName || "",
						mainUnit: b.mainUnit || b.unitName,
						unitId: b.unitId,
						qty: b.qty || 1,
						price: b.price || b.salePrice,
						discountRate: b.discountRate || 0,
						deduction: b.deduction || 0,
						amount: b.amount || b.salePrice,
						inLocationName: b.inLocationName,
						inLocationId: b.inLocationId,
						outLocationName: b.locationName || b.outLocationName,
						outLocationId: b.locationId || b.outLocationId,
						serNumList: b.serNumList,
						safeDays: b.safeDays
					});
					SYSTEM.ISSERNUM && 1 == b.isSerNum && (c.qty = c.serNumList ? c.serNumList.length : 0);
					var d = $("#grid").jqGrid("setRowData", a, c);
					d && THISPAGE.calTotal()
				}
			}
			var y = this,
				z = (new Date).format();
			if (a.id) {
				for (var A = 0; A < a.entries.length; A++) a.entries[A].id = A + 1;
				var B = 8 - a.entries.length;
				if (B > 0) for (var A = 0; B > A; A++) a.entries.push({})
			}
			y.newId = 9;
			var C = "grid",
				D = [{
					name: "operating",
					label: " ",
					width: 40,
					fixed: !0,
					formatter: Public.billsOper,
					align: "center"
				}, {
					name: "goods",
					label: "商品",
					width: 318,
					title: !1,
					classes: "goods",
					formatter: b,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: c,
						custom_value: d,
						handle: e,
						trigger: "ui-icon-ellipsis"
					}
				}, {
					name: "skuId",
					label: "属性ID",
					hidden: !0
				}, {
					name: "skuName",
					label: "属性",
					width: 100,
					classes: "ui-ellipsis skuInfo",
					hidden: !SYSTEM.enableAssistingProp,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: f,
						custom_value: g,
						handle: h,
						trigger: "ui-icon-ellipsis"
					}
				}, {
					name: "mainUnit",
					label: "单位",
					width: 80,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: o,
						custom_value: p,
						handle: q,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "unitId",
					label: "单位Id",
					hidden: !0
				}, {
					name: "batch",
					label: "批次",
					width: 90,
					classes: "ui-ellipsis batch",
					hidden: !0,
					title: !1,
					editable: !0,
					align: "left",
					edittype: "custom",
					edittype: "custom",
					editoptions: {
						custom_element: u,
						custom_value: v,
						handle: w,
						trigger: "ui-icon-ellipsis"
					}
				}, {
					name: "prodDate",
					label: "生产日期",
					width: 90,
					hidden: !0,
					title: !1,
					editable: !0,
					edittype: "custom",
					edittype: "custom",
					editoptions: {
						custom_element: r,
						custom_value: s,
						handle: t
					}
				}, {
					name: "safeDays",
					label: "保质期(天)",
					width: 90,
					hidden: !0,
					title: !1,
					align: "left"
				}, {
					name: "validDate",
					label: "有效期至",
					width: 90,
					hidden: !0,
					title: !1,
					align: "left"
				}, {
					name: "qty",
					label: "数量",
					width: 80,
					align: "right",
					formatter: "number",
					formatoptions: {
						decimalPlaces: qtyPlaces
					},
					editable: !0
				}, {
					name: "outLocationName",
					label: "调出仓库",
					nameExt: '<small id="batch-storageA">(批量)</small>',
					sortable: !1,
					width: 100,
					title: !0,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: i,
						custom_value: j,
						handle: k,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "inLocationName",
					label: "调入仓库",
					nameExt: '<small id="batch-storageB">(批量)</small>',
					width: 100,
					title: !0,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: l,
						custom_value: m,
						handle: n,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "description",
					label: "备注",
					width: 150,
					title: !0,
					editable: !0
				}];
			y.mod_PageConfig.gridReg(C, D), D = y.mod_PageConfig.conf.grids[C].colModel, $("#grid").jqGrid({
				data: a.entries,
				datatype: "clientSide",
				autowidth: !0,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: D,
				cmTemplate: {
					sortable: !1
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
						y.newId = c + 1;
						for (var d = 0; c > d; d++) {
							var e = d + 1,
								f = b[d];

							if ($.isEmptyObject(b[d])) break;
							var g = $.extend(!0, {
								id: f.invId,
								number: f.invNumber,
								name: f.invName,
								spec: f.invSpec,
								unitId: f.unitId,
								unitName: f.mainUnit,
								isSerNum: f.isSerNum,
								serNumList: f.serNumList || f.invSerNumList
							}, f);
							Business.cacheManage.getGoodsInfoByNumber(g.number, function(a) {
								g.isSerNum = a.isSerNum, g.isWarranty = f.isWarranty = a.isWarranty, g.safeDays = f.safeDays = a.safeDays, g.invSkus = a.invSkus, g.id = f.invId, $("#" + e).data("goodsInfo", g).data("storageInfo", {
									id: f.outLocationId,
									name: f.outLocationName
								}).data("inStorage", {
									id: f.inLocationId,
									name: f.inLocationName
								}).data("unitInfo", {
									unitId: f.unitId,
									name: f.mainUnit
								}).data("skuInfo", {
									name: f.skuName,
									id: f.skuId
								})
							}), 1 == f.isWarranty && $("#grid").jqGrid("showCol", "batch"), f.safeDays > 0 && ($("#grid").jqGrid("showCol", "prodDate"), $("#grid").jqGrid("showCol", "safeDays"), $("#grid").jqGrid("showCol", "validDate"))
						}
					}
				},
				gridComplete: function() {
					setTimeout(function() {
						Public.autoGrid($("#grid"))
					}, 10)
				},
				afterEditCell: function(a, b, c, d, e) {
					function f() {
						var b = $("#" + a).data("goodsInfo");
						if (b) {
							var c = $("#grid").jqGrid("getRowData", a);
							b = $.extend(!0, {}, b), b.skuName = c.skuName, b.mainUnit = c.mainUnit, b.unitId = c.unitId, b.qty = c.qty, b.price = c.price, b.discountRate = c.discountRate, b.deduction = c.deduction, b.amount_old = c.amount, b.taxRate = c.taxRate, b.tax = c.tax, b.taxAmount = c.taxAmount, b.inLocationId = c.inLocationId, b.inLocationName = c.inLocationName, b.outLocationId = c.outLocationId, b.outLocationName = c.outLocationName, $("#" + a).data("goodsInfo", b)
						}
					}
					if (THISPAGE.curID = a, "goods" === b && (f(), $("#" + d + "_goods", "#grid").val(c), THISPAGE.goodsCombo.selectByText(c)), "skuName" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g || !g.invSkus || !g.invSkus.length) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, $("#grid").jqGrid("nextCell", d, e + 1), void THISPAGE.skuCombo.loadData([]);
						"string" == typeof g.invSkus && (g.invSkus = $.parseJSON(g.invSkus)), $("#" + d + "_skuName", "#grid").val(c), THISPAGE.skuCombo.loadData(g.invSkus || [], 1, !1), THISPAGE.skuCombo.selectByText(c);
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && Business.serNumManage({
							row: $("#" + a),
							enableStorage: !0,
							enableSku: !0,
							beforeSet: function(a) {
								a.outLocationName = a.locationName, a.outLocationId = a.locationId
							}
						})
					}
					if ("qty" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && Business.serNumManage({
							row: $("#" + a),
							beforeSet: function(a) {
								a.outLocationName = a.locationName, a.outLocationId = a.locationId
							}
						})
					}
					if ("outLocationName" === b) {
						$("#" + d + "_outLocationName", "#grid").val(c), THISPAGE.outStorageCombo.selectByText(c);
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && Business.serNumManage({
							row: $("#" + a),
							enableStorage: !0,
							enableSku: !0,
							beforeSet: function(a) {
								a.outLocationName = a.locationName, a.outLocationId = a.locationId
							}
						})
					}
					if ("inLocationName" === b && ($("#" + d + "_inLocationName", "#grid").val(c), THISPAGE.inStorageCombo.selectByText(c)), "batch" === b) {
						var g = $("#" + a).data("goodsInfo");
						if (!g) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#grid").jqGrid("nextCell", d, e + 1);
						$("#" + d + "_batch", "#grid").val(c), THISPAGE.batchCombo.selectByText(c)
					}
					if ("prodDate" === b) {
						var g = $("#" + a).data("goodsInfo");
						if (!g) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#grid").jqGrid("nextCell", d, e + 1);
						if (!g.safeDays) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#grid").jqGrid("nextCell", d, e + 1);
						c ? THISPAGE.cellPikaday.setDate(c) : THISPAGE.cellPikaday.setDate(THISPAGE.cellPikaday.getDate() || new Date)
					}
					if ("mainUnit" === b) {
						$("#" + d + "_mainUnit", "#grid").val(c);
						var h = $("#" + a).data("unitInfo") || {};
						if (!h.unitId || "0" === h.unitId) return $("#grid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#grid").jqGrid("nextCell", d, e + 1);
						THISPAGE.unitCombo.loadData(function() {
							for (var a = {}, b = 0; b < SYSTEM.unitInfo.length; b++) {
								var c = SYSTEM.unitInfo[b],
									d = h.unitId;
								h.unitId == c.id && (h = c), h.unitId = d;
								var e = c.unitTypeId || b;
								a[e] || (a[e] = []), a[e].push(c)
							}
							return h.unitTypeId ? a[h.unitTypeId] : [h]
						}), THISPAGE.unitCombo.selectByText(c)
					}
				},
				formatCell: function(a, b, c, d, e) {},
				beforeSubmitCell: function(a, b, c, d, e) {},
				beforeSaveCell: function(a, b, c, d, e) {
					if ("goods" === b) {
						var f = $("#" + a).data("goodsInfo");
						if (!f) {
							y.skey = c;
							var g, h = function(b) {
									$("#" + a).data("goodsInfo", b).data("storageInfo", {
										id: b.locationId,
										name: b.locationName
									}).data("unitInfo", {
										unitId: b.unitId,
										name: b.unitName
									}), g = Business.formatGoodsName(b)
								};
							return THISPAGE.$_barCodeInsert && THISPAGE.$_barCodeInsert.hasClass("active") ? Business.cacheManage.getGoodsInfoByBarCode(c, h, !0) : Business.cacheManage.getGoodsInfoByNumber(c, h, !0), g ? g : ($.dialog({
								width: 775,
								height: 510,
								title: "选择商品",
								content: "url:../settings/goods_batch",
								data: {
									skuMult: SYSTEM.enableAssistingProp,
									skey: y.skey,
									callback: function(a, b, c) {
										"" === b && ($("#grid").jqGrid("addRowData", a, {}, "last"), y.newId = a + 1), setTimeout(function() {
											$("#grid").jqGrid("editCell", c, 2, !0)
										}, 10), y.calTotal()
									}
								},
								init: function() {
									y.skey = ""
								},
								lock: !0,
								button: [{
									name: "选中",
									defClass: "ui_state_highlight fl",
									focus: !0,
									callback: function() {
										return this.content.callback && this.content.callback(), !1
									}
								}, {
									name: "选中并关闭",
									defClass: "ui_state_highlight",
									callback: function() {
										return this.content.callback(), this.close(), !1
									}
								}, {
									name: "关闭",
									callback: function() {
										return !0
									}
								}]
							}), setTimeout(function() {
								$("#grid").jqGrid("editCell", curRow, 2, !0), $("#grid").jqGrid("setCell", curRow, 2, "")
							}, 10), "&#160;")
						}
					}
					return c
				},
				afterSaveCell: function(a, b, c, d, e) {
					switch (b) {
					case "goods":
						break;
					case "qty":
						THISPAGE.calTotal();
						break;
					case "batch":
						var f = $("#grid").jqGrid("getRowData", a),
							g = $("#" + a).data("goodsInfo") || {};
						if (g.safeDays) {
							var h = {};
							if ($.trim(f.prodDate) || (h.prodDate = z), $.trim(f.safeDays) || (h.safeDays = g.safeDays), !$.trim(f.validDate)) {
								var i = f.prodDate || h.prodDate,
									j = i.split("-");
								if (i = new Date(j[0], j[1] - 1, j[2]), "Invalid Date" === i.toString()) return defaultPage.Public.tips({
									type: 2,
									content: "日期格式错误！"
								}), void setTimeout(function() {
									$("#grid").jqGrid("editCellByColName", a, "prodDate")
								}, 10);
								i && (i.addDays(Number(f.safeDays || h.safeDays)), h.validDate = i.format())
							}
							$.isEmptyObject(h) || $("#grid").jqGrid("setRowData", a, h)
						}
						break;
					case "prodDate":
						var f = $("#grid").jqGrid("getRowData", a),
							g = $("#" + a).data("goodsInfo") || {},
							h = {};
						$.trim(f.safeDays) || (h.safeDays = g.safeDays), $.trim(c) || (h.prodDate = z);
						var i = c || h.prodDate,
							j = i.split("-");
						if (i = new Date(j[0], j[1] - 1, j[2]), "Invalid Date" === i.toString()) return defaultPage.Public.tips({
							type: 2,
							content: "日期格式错误！"
						}), void setTimeout(function() {
							$("#grid").jqGrid("editCellByColName", a, "prodDate")
						}, 10);
						i && (i.addDays(Number(f.safeDays || h.safeDays)), h.validDate = i.format()), $("#grid").jqGrid("setRowData", a, h)
					}
				},
				loadonce: !0,
				resizeStop: function(a, b) {
					y.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
				},
				footerrow: !0,
				userData: {
					goods: "合计：",
					qty: a.totalQty,
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
			function b() {
				c.$_date.val(a.date), c.$_number.text(a.billNo), c.$_note.val(a.note), c.$_userName.html(a.userName), a.note && c.$_note.val(a.note), c.$_userName.html(a.userName), c.$_modifyTime.html(a.modifyTime), c.$_createTime.html(a.createTime), c.$_checkName.html(a.checkName)
			}
			$("#grid").clearGridData();
			var c = this;
			originalData = a;
			for (var d = 0; d < a.entries.length; d++) a.entries[d].id = d + 1;
			var e = 8 - a.entries.length;
			if (e > 0) for (var d = 0; e > d; d++) a.entries.push({});
			$("#grid").jqGrid("setGridParam", {
				data: a.entries,
				userData: {
					billNo: "合计：",
					billPrice: a.billPrice,
					hasCheck: a.billHasCheck,
					notCheck: a.billNotCheck,
					nowCheck: a.billNowCheck
				},
				cellEdit: !0,
				datatype: "clientSide"
			}).trigger("reloadGrid"), b(), "edit" === a.status ? this.editable || (c.enableEdit(), $("#groupBtn").html(c.btn_edit + c.btn_audit), $("#mark").removeClass("has-audit")) : this.editable && (c.disableEdit(), $("#groupBtn").html(c.btn_view + c.btn_reaudit), $("#mark").addClass("has-audit"))
		},
		initCombo: function() {
			this.goodsCombo = Business.billGoodsCombo($(".goodsAuto"), {
				userData: {
					beforeSet: function(a) {
						a.outLocationName = a.locationName, a.outLocationId = a.locationId
					}
				}
			}), this.skuCombo = Business.billskuCombo($(".skuAuto"), {
				data: []
			}), this.outStorageCombo = $(".storageAuto").combo({
				data: function() {
					if (defaultPage.SYSTEM.storageInfo) {
						for (var a = [], b = defaultPage.SYSTEM.storageInfo.length - 1; b >= 0; b--) {
							var c = defaultPage.SYSTEM.storageInfo[b];
							c["delete"] || a.push(c)
						}
						return a
					}
					return "../basedata/invlocation?action=list&isDelete=2"
				},
				text: "name",
				value: "id",
				defaultSelected: 0,
				cache: !1,
				trigger: !1,
				defaultFlag: !1,
				editable: !0,
				callback: {
					onChange: function(a) {
						var b = this.input.parents("tr"),
							c = b.data("storageInfo");
						c || (c = {}), a && (c.id = a.id, c.name = a.name), b.data("storageInfo", c)
					}
				}
			}).getCombo(), this.inStorageCombo = $(".inStorage").combo({
				data: function() {
					if (defaultPage.SYSTEM.storageInfo) {
						for (var a = [], b = defaultPage.SYSTEM.storageInfo.length - 1; b >= 0; b--) {
							var c = defaultPage.SYSTEM.storageInfo[b];
							c["delete"] || a.push(c)
						}
						return a
					}
					return "../basedata/invlocation?action=list&isDelete=2"
				},
				text: "name",
				value: "id",
				defaultSelected: 0,
				cache: !1,
				editable: !0,
				trigger: !1,
				defaultFlag: !1,
				callback: {
					onChange: function(a) {
						var b = this.input.parents("tr"),
							c = b.data("inStorage");
						c || (c = {}), a && (c.id = a.id, c.name = a.name), b.data("inStorage", c)
					}
				}
			}).getCombo(), $("#batchStorage").combo({
				data: function() {
					return parent.SYSTEM.storageInfo
				},
				text: "name",
				value: "id",
				defaultSelected: 0,
				cache: !1,
				editable: !1,
				trigger: !0,
				defaultFlag: !1,
				callback: {
					onChange: function(a) {}
				}
			}), this.unitCombo = Business.unitCombo($(".unitAuto"), {
				defaultSelected: -1,
				forceSelection: !1
			}), this.cellPikaday = new Pikaday({
				field: $(".dateAuto")[0],
				editable: !1
			}), this.batchCombo = Business.batchCombo($(".batchAuto"))
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
			}), $(".grid-wrap").on("click", ".ui-icon-triangle-1-s", function(a) {
				var b = $(this).siblings(),
					c = b.getCombo();
				setTimeout(function() {
					c.active = !0, c.doQuery()
				}, 10)
			}), $("#batch-storageA").powerFloat({
				eventType: "click",
				hoverHold: !1,
				reverseSharp: !0,
				target: function() {
					return null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null), $(".wrapper").data("batch", "storageA"), $("#storageBox")
				}
			}), $("#batch-storageB").powerFloat({
				eventType: "click",
				hoverHold: !1,
				reverseSharp: !0,
				target: function() {
					return null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null), $(".wrapper").data("batch", "storageB"), $("#storageBox")
				}
			}), $(".wrapper").on("click", "#storageBox li", function(a) {
				var b = $(this).data("id"),
					c = $(this).data("name"),
					d = $("#grid").jqGrid("getDataIDs");
				if ("storageA" === $(".wrapper").data("batch")) var e = "outLocationName",
					f = "storageInfo";
				else var e = "inLocationName",
					f = "inStorage";
				for (var g = 0, h = d.length; h > g; g++) {
					var i = d[g],
						j = $("#grid").jqGrid("getRowData", i),
						k = $("#" + i);
					if ("" !== j.goods && void 0 !== k.data("goodsInfo")) {
						var l = {};
						l[e] = c, $("#grid").jqGrid("setRowData", i, l), $("#" + i).data(f, {
							id: b,
							name: c
						})
					}
				}
				$.powerFloat.hide()
			}), Business.billsEvent(a, "transfers"), $(".wrapper").on("click", "#save", function(b) {
				b.preventDefault();
				var c = $(this);
				if (c.hasClass("ui-btn-dis")) return void parent.Public.tips({
					type: 2,
					content: "正在保存，请稍后..."
				});
				var d = THISPAGE.getPostData();
				d && ("edit" === originalData.stata && (d.id = originalData.id, d.stata = "edit"), c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invTf/add?action=add", {
					postData: JSON.stringify(d)
				}, function(b) {
					c.removeClass("ui-btn-dis"), 200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), a.$_createTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, billRequiredCheck ? a.$_toolBottom.html('<span id="groupBtn">' + a.btn_edit + a.btn_audit + "</span>") : a.$_toolBottom.html('<span id="groupBtn">' + a.btn_edit + "</span>"), parent.Public.tips({
						content: "保存成功！"
					})) : parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#edit", function(b) {
				if (b.preventDefault(), Business.verifyRight("TF_UPDATE")) {
					var c = THISPAGE.getPostData();
					c && Public.ajaxPost("../scm/invTf/updateInvTf?action=updateInvTf", {
						postData: JSON.stringify(c)
					}, function(b) {
						200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, parent.Public.tips({
							content: "修改成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#savaAndAdd", function(b) {
				b.preventDefault();
				var c = $(this);
				if (c.hasClass("ui-btn-dis")) return void parent.Public.tips({
					type: 2,
					content: "正在保存，请稍后..."
				});
				var d = THISPAGE.getPostData();
				d && (c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invTf/addNew?action=addNew", {
					postData: JSON.stringify(d)
				}, function(b) {
					if (c.removeClass("ui-btn-dis"), 200 === b.status) {
						a.$_number.text(b.data.billNo), $("#grid").clearGridData(), $("#grid").clearGridData(!0);
						for (var d = 1; 8 >= d; d++) $("#grid").jqGrid("addRowData", d, {});
						a.newId = 9, a.$_note.val(""), parent.Public.tips({
							content: "保存成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#add", function(a) {
				a.preventDefault(), Business.verifyRight("TF_ADD") && parent.tab.overrideSelectedTabItem({
					tabid: "storage-transfers",
					text: "调拨单",
					url: "../scm/invTf?action=initTf"
				})
			}), $(".wrapper").on("click", "#print", function(a) {
				return Business.verifyRight("TF_PRINT") ? void(this.href += "&id=" + originalData.id) : void a.preventDefault()
			}), $("#bottomField").on("click", "#prev", function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-prev-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有上一张了！"
				}), !1) : (a.idPostion = a.idPostion - 1, 0 === a.idPostion && $(this).addClass("ui-btn-prev-dis"), a.idPostion && (loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("/scm/invTf.do?action=update", {
					id: a.transfersListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#next").removeClass("ui-btn-next-dis"), loading && loading.close()
				})), void 0)
			}), $("#bottomField").on("click", "#next", function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-next-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有下一张了！"
				}), !1) : (a.idPostion = a.idPostion + 1, a.idLength === a.idPostion + 1 && $(this).addClass("ui-btn-next-dis"), a.idPostion && (loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("/scm/invTf.do?action=update", {
					id: a.transfersListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#prev").removeClass("ui-btn-prev-dis"), loading && loading.close()
				})), void 0)
			}), $(".wrapper").on("click", "#audit", function(b) {
				if (b.preventDefault(), Business.verifyRight("TF_CHECK")) {
					var c = $(this),
						d = THISPAGE.getPostData({
							checkSerNum: !0
						});
					d && c.ajaxPost("../scm/invTf/checkInvTf?action=checkInvTf", {
						postData: JSON.stringify(d)
					}, function(b) {
						200 === b.status ? (originalData.id = b.data.id, $("#mark").addClass("has-audit"), a.$_checkName.html(SYSTEM.realName).parent().show(), $("#edit").hide(), a.disableEdit(), $("#groupBtn").html(a.btn_view + a.btn_reaudit), parent.Public.tips({
							content: "审核成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#reAudit", function(b) {
				if (b.preventDefault(), Business.verifyRight("TF_UNCHECK")) {
					var c = $(this);
					c.ajaxPost("../scm/invTf/rsBatchCheckInvTf?action=rsBatchCheckInvTf", {
						id: originalData.id
					}, function(b) {
						200 === b.status ? ($("#mark").removeClass(), a.$_checkName.html(""), $("#edit").show(), a.enableEdit(), $("#groupBtn").html(a.btn_edit + a.btn_audit), parent.Public.tips({
							content: "反审核成功！"
						})) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
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
		disableEdit: function() {
			this.$_date.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_note.attr("disabled", "disabled").addClass("ui-input-dis"), $("#grid").jqGrid("setGridParam", {
				cellEdit: !1
			}), this.editable = !1
		},
		enableEdit: function() {
			disEditable || (this.$_date.removeAttr("disabled").removeClass("ui-input-dis"), this.$_note.removeAttr("disabled").removeClass("ui-input-dis"), $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			}), this.editable = !0)
		},
		calTotal: function() {
			for (var a = $("#grid").jqGrid("getDataIDs"), b = 0, c = 0, d = a.length; d > c; c++) {
				var e = a[c],
					f = $("#grid").jqGrid("getRowData", e);
				f.qty && (b += parseFloat(f.qty))
			}
			$("#grid").jqGrid("footerData", "set", {
				qty: b
			})
		},
		_getEntriesData: function() {
			for (var a = [], b = $("#grid").jqGrid("getDataIDs"), c = 0, d = b.length; d > c; c++) {
				var e, f = b[c],
					g = $("#grid").jqGrid("getRowData", f);
				if ("" !== g.goods) {
					var h = $("#" + f).data("goodsInfo"),
						i = $("#" + f).data("storageInfo"),
						j = $("#" + f).data("inStorage"),
						k = $("#" + f).data("unitInfo") || {},
						l = $("#" + f).data("skuInfo") || {};
					if (h.invSkus && h.invSkus.length > 0 && !l.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的属性！"
					}), $("#grid").jqGrid("editCellByColName", f, "skuName"), !1;
					if (!i || !i.id) return parent.Public.tips({
						type: 2,
						content: "请选择调出仓库！"
					}), $("#grid").jqGrid("editCellByColName", f, "outLocationName"), !1;
					if (!j || !j.id) return parent.Public.tips({
						type: 2,
						content: "请选择调入仓库！"
					}), $("#grid").jqGrid("editCellByColName", f, "inLocationName"), !1;
					if (SYSTEM.ISSERNUM) {
						var m = h.serNumList;
						if (m || m && m.length != h.qty);
						else {
							var n = !1,
								o = "点击";
							if (1 == h.isSerNum && (n = !0), n) return parent.Public.tips({
								type: 2,
								content: "请" + o + "数量设置【" + h.name + "】的序列号"
							}), $("#grid").jqGrid("editCellByColName", f, "qty"), !1
						}
					}
					e = {
						invId: h.id,
						invNumber: h.number,
						invName: h.name,
						invSpec: h.spec || "",
						skuId: l.id || -1,
						skuName: l.name || "",
						unitId: k.unitId || -1,
						mainUnit: k.name || "",
						qty: g.qty,
						description: g.description,
						outLocationId: i.id,
						outLocationName: i.name,
						inLocationId: j.id,
						inLocationName: j.name,
						serNumList: m
					}, SYSTEM.ISWARRANTY && $.extend(!0, e, {
						batch: g.batch || "",
						prodDate: g.prodDate || "",
						safeDays: g.safeDays || "",
						validDate: g.validDate || ""
					}), a.push(e)
				}
			}
			return a
		},
		getPostData: function() {
			var a = this;
			null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null);
			var b = this._getEntriesData();
			if (!b) return !1;
			if (b.length > 0) {
				var c = $.trim(a.$_note.val());
				a.calTotal();
				var d = {
					id: originalData.id,
					date: $.trim(a.$_date.val()),
					billNo: $.trim(a.$_number.text()),
					entries: b,
					totalQty: $("#grid").jqGrid("footerData", "get").qty.replace(/,/g, ""),
					description: c === a.$_note[0].defaultValue ? "" : c
				};
				return d
			}
			return parent.Public.tips({
				type: 2,
				content: "商品信息不能为空！"
			}), $("#grid").jqGrid("editCell", 1, 2, !0), !1
		}
	},
	hasLoaded = !1,
	originalData;
$(function() {
	urlParam.id ? hasLoaded || Public.ajaxGet("../scm/invTf/update?action=update", {
		id: urlParam.id
	}, function(a) {
		200 === a.status ? (originalData = a.data, THISPAGE.init(a.data), hasLoaded = !0) : parent.Public.tips({
			type: 1,
			content: msg
		})
	}) : (originalData = {
		id: -1,
		status: "add",
		customer: 0,
		transType: 0,
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


