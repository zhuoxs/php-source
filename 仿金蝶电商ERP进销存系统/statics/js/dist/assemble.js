var curRow, curCol, curArrears, loading, urlParam = Public.urlParam(),
	SYSTEM = parent.SYSTEM,
	hiddenAmount = !1,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	hasLoaded = !1,
	originalData, isTemp, defaultPage = Public.getDefaultPage(),
	THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("assemble"), SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_COSTAMOUNT || (hiddenAmount = !0), this.loadGrid(a), this.initDom(a), this.initCombo(), this.addEvent()
		},
		initDom: function(a) {
			if (this.btype = "", this.$_customer = $("#customer"), this.$_date = $("#date").val(SYSTEM.endDate), this.$_number = $("#number"), this.$_amount = $("#amount"), this.$_note = $("#note"), this.$_toolTop = $("#toolTop"), this.$_toolBottom = $("#toolBottom"), this.$_userName = $("#userName"), this.$_modifyTime = $("#modifyTime"), this.$_createTime = $("#createTime"), this.customerArrears = 0, "add" === a.status);
			else {
				["id", a.transType]
			}
			this.$_note.placeholder(), this.$_date.datepicker(), this.$_amount.val(a.amount), a.id > 0 ? (this.$_number.text(a.billNo), this.$_date.val(a.date), a.description && this.$_note.val(a.description), $("#grid").jqGrid("footerData", "set", {
				qty: a.totalQty,
				amount: a.totalAmount
			}), "edit" === a.status ? this.$_toolBottom.html('<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a target="_blank" id="print" class="ui-btn mrb">打印</a><a id="edit" class="ui-btn">保存</a>') : this.$_toolBottom.html('<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a target="_blank" id="print" class="ui-btn mrb">打印</a><a class="ui-btn-prev mrb" id="prev" title="上一张"><b></b></a><a class="ui-btn-next" id="next" title="下一张"><b></b></a>'), this.salesListIds = parent.salesListIds || [], this.idPostion = $.inArray(String(a.id), this.salesListIds), this.idLength = this.salesListIds.length, 0 === this.idPostion && $("#prev").addClass("ui-btn-prev-dis"), this.idPostion === this.idLength - 1 && $("#next").addClass("ui-btn-next-dis"), this.$_userName.html(a.userName), this.$_modifyTime.html(a.modifyTime), this.$_createTime.html(a.createTime)) : (this.$_toolBottom.html('<a id="savaAndAdd" class="ui-btn ui-btn-sp mrb">保存并新增</a><a id="save" class="ui-btn">保存</a>'), this.$_userName.html(SYSTEM.realName || ""), this.$_modifyTime.parent().hide(), this.$_createTime.parent().hide())
		},
		loadGrid: function(a) {
			function b(a, b) {
				var c = $(".goodsAuto_0")[0];
				return c
			}
			function c(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".goodsAuto_0").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("goodsInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function d() {
				$("#initCombo").append($(".goodsAuto_0").val("").unbind("focus.once"))
			}
			function e(a, b) {
				var c = $(".skuAuto_0")[0];
				return c
			}
			function f(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".skuAuto_0").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("skuInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function g() {
				$("#initCombo").append($(".skuAuto_0").val(""))
			}
			function h(a, b) {
				var c = $(".storageAuto_0")[0];
				return c
			}
			function i(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".storageAuto_0").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("storageInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function j() {
				$("#initCombo").append($(".storageAuto_0").val(""))
			}
			function k(a, b) {
				var c = $(".unitAuto_0")[0];
				return c
			}
			function l(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".unitAuto_0").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr"),
						e = d.data("unitInfo") || {};
					return THISPAGE.unitCombo.selectByIndex(e.unitId || e.id), e.name || ""
				}
				"set" === b && $("input", a).val(c)
			}
			function m() {
				$("#initCombo").append($(".unitAuto_0").val(""))
			}
			function n(a, b) {
				var c = $(".dateAuto_0")[0];
				return c
			}
			function o(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function p() {
				$("#initCombo").append($(".dateAuto_0"))
			}
			function q(a, b) {
				var c = $(".batchAuto_0")[0];
				return c
			}
			function r(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function s() {
				$("#initCombo").append($(".batchAuto_0").val(""))
			}
			function t(a, b, c) {
				return a ? (N(b.rowId), a) : c.invNumber ? c.invSpec ? c.invNumber + " " + c.invName + "_" + c.invSpec : c.invNumber + " " + c.invName : "&#160;"
			}
			function u(a, b, c) {
				return a ? (N("fix1", $("#fixedGrid")), a) : c.invNumber ? c.invSpec ? c.invNumber + " " + c.invName + "_" + c.invSpec : c.invNumber + " " + c.invName : "&#160;"
			}
			function v(a, b) {
				var c = $(".goodsAuto")[0];
				return c
			}
			function w(a, b, c) {
				if ("get" === b) {
					if ("" !== O.goodsCombo.getValue()) return O.goodsCombo.getText();
					var d = $(a).parents("tr");
					return d.removeData("goodsInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function x() {
				$("#initCombo").append($(".goodsAuto").val("").unbind("focus.once"))
			}
			function y(a, b) {
				var c = $(".skuAuto")[0];
				return c
			}
			function z(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".skuAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("skuInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function A() {
				$("#initCombo").append($(".skuAuto").val(""))
			}
			function B(a, b) {
				var c = $(".storageAuto")[0];
				return c
			}
			function C(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".storageAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr");
					return d.removeData("storageInfo"), ""
				}
				"set" === b && $("input", a).val(c)
			}
			function D() {
				$("#initCombo").append($(".storageAuto").val(""))
			}
			function E(a, b) {
				var c = $(".unitAuto")[0];
				return c
			}
			function F(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".unitAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr"),
						e = d.data("unitInfo") || {};
					return THISPAGE.unitCombo.selectByIndex(e.unitId || e.id), e.name || ""
				}
				"set" === b && $("input", a).val(c)
			}
			function G() {
				$("#initCombo").append($(".unitAuto").val(""))
			}
			function H(a, b) {
				var c = $(".dateAuto")[0];
				return c
			}
			function I(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function J() {
				$("#initCombo").append($(".dateAuto"))
			}
			function K(a, b) {
				var c = $(".batchAuto")[0];
				return c
			}
			function L(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function M() {
				$("#initCombo").append($(".batchAuto").val(""))
			}
			function N(a, b) {
				b = b || $("#grid");
				var c = $("#" + a).data("goodsInfo");
				if (c) {
					c.batch || b.jqGrid("setCell", a, "batch", "&#160;"), c.safeDays || (b.jqGrid("setCell", a, "prodDate", "&#160;"), b.jqGrid("setCell", a, "safeDays", "&#160;"), b.jqGrid("setCell", a, "validDate", "&#160;")), 1 == c.isWarranty && b.jqGrid("showCol", "batch"), c.safeDays > 0 && (b.jqGrid("showCol", "prodDate"), b.jqGrid("showCol", "safeDays"), b.jqGrid("showCol", "validDate"));
					var d = {
						skuName: c.skuName || "",
						mainUnit: c.mainUnit || c.unitName,
						unitId: c.unitId,
						qty: c.qty || 1,
						price: c.price || 0,
						discountRate: c.discountRate || 0,
						deduction: c.deduction || 0,
						amount: c.amount || 0,
						locationName: c.locationName,
						locationId: c.locationId,
						serNumList: c.serNumList,
						safeDays: c.safeDays
					};
					SYSTEM.ISSERNUM && 1 == c.isSerNum && (d.qty = d.serNumList ? d.serNumList.length : 0), d.amount = d.amount ? d.amount : d.price * d.qty;
					var e = (Number(d.amount), b.jqGrid("setRowData", a, d));
					e && THISPAGE.calTotal()
				}
			}
			var O = this,
				P = (new Date).format();
			if (a.id) {
				var Q = 6 - a.entries.length;
				if (Q > 0) for (var R = 0; Q > R; R++) a.entries.push({})
			}
			O.newId = 6;
			var S = "fix",
				T = "fixedGrid",
				U = [{
					name: "goods",
					label: "商品",
					width: 370,
					title: !0,
					classes: "goods",
					formatter: u,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: b,
						custom_value: c,
						handle: d,
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
						custom_element: e,
						custom_value: f,
						handle: g,
						trigger: "ui-icon-ellipsis"
					}
				}, {
					name: "mainUnit",
					label: "单位",
					width: 80,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: k,
						custom_value: l,
						handle: m,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "unitId",
					label: "单位Id",
					hidden: !0
				}, {
					name: "locationName",
					label: "仓库",
					width: 100,
					title: !0,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: h,
						custom_value: i,
						handle: j,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "batch",
					label: "批次",
					width: 90,
					classes: "ui-ellipsis batch isSingle",
					hidden: !0,
					title: !1,
					editable: !0,
					align: "left",
					edittype: "custom",
					edittype: "custom",
					editoptions: {
						custom_element: q,
						custom_value: r,
						handle: s,
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
						custom_element: n,
						custom_value: o,
						handle: p
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
					name: "price",
					label: "入库单位成本",
					hidden: hiddenAmount,
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency",
					formatoptions: {
						showZero: !0,
						decimalPlaces: pricePlaces
					}
				}, {
					name: "amount",
					label: "入库成本",
					hidden: hiddenAmount,
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency",
					formatoptions: {
						showZero: !0,
						decimalPlaces: amountPlaces
					}
				}];
			O.mod_PageConfig.gridReg(T, U, "组合件"), U = O.mod_PageConfig.conf.grids[T].colModel, $("#fixedGrid").jqGrid({
				data: [a.entries.shift()],
				datatype: "clientSide",
				autowidth: !0,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: U,
				cmTemplate: {
					sortable: !1,
					title: !1
				},
				idPrefix: S,
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
					if (urlParam.id > 0 || isTemp) {
						var b = a.rows,
							c = b.length;
						O.newId = c + 1;
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
								g.isSerNum = a.isSerNum, g.isWarranty = f.isWarranty = a.isWarranty, g.safeDays = f.safeDays = a.safeDays, g.invSkus = a.invSkus, g.id = f.invId, $("#" + S + e).data("goodsInfo", g).data("storageInfo", {
									id: f.locationId,
									name: f.locationName
								}).data("unitInfo", {
									unitId: f.unitId,
									name: f.mainUnit
								}).data("skuInfo", {
									name: f.skuName,
									id: f.skuId
								})
							}), 1 == f.isWarranty && $("#fixedGrid").jqGrid("showCol", "batch"), f.safeDays > 0 && ($("#fixedGrid").jqGrid("showCol", "prodDate"), $("#fixedGrid").jqGrid("showCol", "safeDays"), $("#fixedGrid").jqGrid("showCol", "validDate"))
						}
					}
				},
				gridComplete: function() {
					setTimeout(function() {
						Public.autoGrid($("#fixedGrid"))
					}, 10)
				},
				beforeEditCell: function(a, b, c, d, e) {
					"qty" === b && (lastTemlQty = Number(c))
				},
				afterEditCell: function(a, b, c, d, e) {
					function f() {
						var b = $("#" + a).data("goodsInfo");
						if (b) {
							var c = $("#fixedGrid").jqGrid("getRowData", a);
							b = $.extend(!0, {}, b), b.mainUnit = c.mainUnit, b.unitId = c.unitId, b.qty = c.qty, b.price = c.price, b.discountRate = c.discountRate, b.deduction = c.deduction, b.amount = c.amount, b.taxRate = c.taxRate, b.tax = c.tax, b.taxAmount = c.taxAmount, b.locationName = c.locationName, $("#" + a).data("goodsInfo", b)
						}
					}
					if (THISPAGE.curID = a, "goods" === b && (f(), $("#" + d + "_goods", "#fixedGrid").val(c), THISPAGE.goodsCombo_0.selectByText(c)), "skuName" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g || !g.invSkus || !g.invSkus.length) return $("#fixedGrid").jqGrid("restoreCell", d, e), curCol = e + 1, $("#fixedGrid").jqGrid("nextCell", d, e + 1), void THISPAGE.skuCombo_0.loadData([]);
						"string" == typeof g.invSkus && (g.invSkus = $.parseJSON(g.invSkus)), $("#" + d + "_skuName", "#fixedGrid").val(c), THISPAGE.skuCombo_0.loadData(g.invSkus || [], 1, !1), THISPAGE.skuCombo_0.selectByText(c)
					}
					if ("qty" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && ($("#fixedGrid").jqGrid("restoreCell", d, e), Business.serNumManage({
							row: $("#" + a),
							isCreate: !0
						}))
					}
					if ("locationName" === b && ($("#" + d + "_locationName", "#fixedGrid").val(c), THISPAGE.storageCombo_0.selectByText(c)), "batch" === b) {
						var g = $("#" + a).data("goodsInfo");
						if (!g) return $("#fixedGrid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#fixedGrid").jqGrid("nextCell", d, e + 1);
						$("#" + d + "_batch", "#fixedGrid").val(c), THISPAGE.batchCombo_0.selectByText(c)
					}
					if ("prodDate" === b) {
						var g = $("#" + a).data("goodsInfo");
						if (!g) return $("#fixedGrid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#fixedGrid").jqGrid("nextCell", d, e + 1);
						if (!g.safeDays) return $("#fixedGrid").jqGrid("restoreCell", d, e), curCol = e + 1, void $("#fixedGrid").jqGrid("nextCell", d, e + 1);
						c ? THISPAGE.cellPikaday_0.setDate(c) : THISPAGE.cellPikaday_0.setDate(THISPAGE.cellPikaday_0.getDate() || new Date)
					}
					if ("mainUnit" === b) {

						$("#" + d + "_mainUnit", "#fixedGrid").val(c);
						var h = $("#" + a).data("unitInfo") || {};
						if (!h.unitId || "0" === h.unitId) return void $("#fixedGrid").jqGrid("saveCell", d, e);
						THISPAGE.unitCombo_0.enable(), THISPAGE.unitCombo_0.loadData(function() {
							for (var a = {}, b = 0; b < SYSTEM.unitInfo.length; b++) {
								var c = SYSTEM.unitInfo[b],
									d = h.unitId;
								h.unitId == c.id && (h = c), h.unitId = d;
								var e = c.unitTypeId || b;
								a[e] || (a[e] = []), a[e].push(c)
							}
							return h.unitTypeId ? a[h.unitTypeId] : [h]
						}), THISPAGE.unitCombo_0.selectByText(c)
					}
				},
				formatCell: function(a, b, c, d, e) {},
				beforeSubmitCell: function(a, b, c, d, e) {},
				beforeSaveCell: function(a, b, c, d, e) {
					if ("goods" === b) {
						var f = $("#" + a).data("goodsInfo");
						if (!f) {
							O.skey = c;
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
									skey: O.skey,
									callback: function(a, b, c) {
										"" === b && ($("#grid").jqGrid("addRowData", a, {}, "last"), O.newId = a + 1), setTimeout(function() {
											$("#grid").jqGrid("editCell", c, 2, !0)
										}, 10), O.calTotal()
									}
								},
								init: function() {
									O.skey = ""
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
						if (isTemp) {
							$("#grid").find('[aria-describedby="grid_qty"]').each(function(a) {
								var b = $(this),
									d = Number(b.text());
								0 !== d && b.text((d * Number(c) / lastTemlQty).toFixed(qtyPlaces))
							});
							var f = parseFloat(c),
								g = parseFloat($("#fixedGrid").jqGrid("getCell", a, e + 1));
							if ($.isNumeric(g)) {
								$("#fixedGrid").jqGrid("setRowData", a, {
									amount: f * g
								})
							}
							THISPAGE.calTotal()
						}
						break;
					case "batch":
						var h = $("#fixedGrid").jqGrid("getRowData", a),
							i = $("#" + a).data("goodsInfo") || {};
						if (i.safeDays) {
							var j = {};
							if ($.trim(h.prodDate) || (j.prodDate = P), $.trim(h.safeDays) || (j.safeDays = i.safeDays), !$.trim(h.validDate)) {
								var k = h.prodDate || j.prodDate,
									l = k.split("-");
								if (k = new Date(l[0], l[1] - 1, l[2]), "Invalid Date" === k.toString()) return defaultPage.Public.tips({
									type: 2,
									content: "日期格式错误！"
								}), void setTimeout(function() {
									$("#fixedGrid").jqGrid("editCellByColName", a, "prodDate")
								}, 10);
								k && (k.addDays(Number(h.safeDays || j.safeDays)), j.validDate = k.format())

							}
							$.isEmptyObject(j) || $("#fixedGrid").jqGrid("setRowData", a, j)
						}
						break;
					case "prodDate":
						var h = $("#fixedGrid").jqGrid("getRowData", a),
							i = $("#" + a).data("goodsInfo") || {},
							j = {};
						$.trim(h.safeDays) || (j.safeDays = i.safeDays), $.trim(c) || (j.prodDate = P);
						var k = c || j.prodDate,
							l = k.split("-");
						if (k = new Date(l[0], l[1] - 1, l[2]), "Invalid Date" === k.toString()) return defaultPage.Public.tips({
							type: 2,
							content: "日期格式错误！"
						}), void setTimeout(function() {
							$("#fixedGrid").jqGrid("editCellByColName", a, "prodDate")
						}, 10);
						k && (k.addDays(Number(h.safeDays || j.safeDays)), j.validDate = k.format()), $("#fixedGrid").jqGrid("setRowData", a, j)
					}
				},
				loadonce: !0,
				resizeStop: function(a, b) {
					O.mod_PageConfig.setGridWidthByIndex(a, b, T)
				},
				loadError: function(a, b, c) {
					Public.tips({
						type: 1,
						content: "Type: " + b + "; Response: " + a.status + " " + a.statusText
					})
				}
			}), $("#fixedGrid").jqGrid("setGridParam", {
				cellEdit: !0
			});
			var V = "grid",
				W = [{
					name: "operating",
					label: " ",
					width: 40,
					fixed: !0,
					formatter: Public.billsOper,
					align: "center"
				}, {
					name: "goods",
					label: "商品",
					width: 330,
					title: !0,
					classes: "goods",
					formatter: t,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: v,
						custom_value: w,
						handle: x,
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
						custom_element: y,
						custom_value: z,
						handle: A,
						trigger: "ui-icon-ellipsis"
					}
				}, {
					name: "mainUnit",
					label: "单位",
					width: 80,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: E,
						custom_value: F,
						handle: G,
						trigger: "ui-icon-triangle-1-s"
					}
				}, {
					name: "unitId",
					label: "单位Id",
					hidden: !0
				}, {
					name: "locationName",
					label: "仓库",
					nameExt: '<small id="batchStorage">(批量)</small>',
					width: 100,
					title: !0,
					editable: !0,
					edittype: "custom",
					editoptions: {
						custom_element: B,
						custom_value: C,
						handle: D,
						trigger: "ui-icon-triangle-1-s"
					}
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
						custom_element: K,
						custom_value: L,
						handle: M,
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
						custom_element: H,
						custom_value: I,
						handle: J
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
					name: "price",
					label: "出库单位成本",
					hidden: hiddenAmount,
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency",
					formatoptions: {
						showZero: !0,
						decimalPlaces: pricePlaces
					}
				}, {
					name: "amount",
					label: "出库成本",
					hidden: hiddenAmount,
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency",
					formatoptions: {
						showZero: !0,
						decimalPlaces: amountPlaces
					}
				}, {
					name: "description",
					label: "备注",
					width: 100,
					title: !0,
					editable: !0
				}];
			O.mod_PageConfig.gridReg(V, W, "子件"), W = O.mod_PageConfig.conf.grids[V].colModel, $("#grid").jqGrid({
				data: a.entries,
				datatype: "clientSide",
				width: 1e3,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: W,
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
					if (urlParam.id > 0 || isTemp) {
						var b = a.rows,
							c = b.length;
						O.newId = c + 1;
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
									id: f.locationId,
									name: f.locationName
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
				beforeEditCell: function(a, b, c, d, e) {},
				afterEditCell: function(a, b, c, d, e) {
					function f() {
						var b = $("#" + a).data("goodsInfo");
						if (b) {
							var c = $("#grid").jqGrid("getRowData", a);
							b = $.extend(!0, {}, b), b.skuName = c.skuName, b.mainUnit = c.mainUnit, b.unitId = c.unitId, b.qty = c.qty, b.price = c.price, b.discountRate = c.discountRate, b.deduction = c.deduction, b.amount = c.amount, b.taxRate = c.taxRate, b.tax = c.tax, b.taxAmount = c.taxAmount, b.locationName = c.locationName, $("#" + a).data("goodsInfo", b)
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
							enableSku: !0
						})
					}
					if ("qty" === b) {
						f();
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && Business.serNumManage({
							row: $("#" + a),
							enableStorage: 0 == c,
							enableSku: 0 == c
						})
					}
					if ("locationName" === b) {
						$("#" + d + "_locationName", "#grid").val(c), THISPAGE.storageCombo.selectByText(c);
						var g = $("#" + a).data("goodsInfo");
						if (!g) return;
						SYSTEM.ISSERNUM && 1 == g.isSerNum && Business.serNumManage({
							row: $("#" + a),
							enableStorage: !0,
							enableSku: !0
						})
					}
					if ("batch" === b) {
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
						if (!h.unitId || "0" === h.unitId) return void $("#grid").jqGrid("saveCell", d, e);
						THISPAGE.unitCombo.enable(), THISPAGE.unitCombo.loadData(function() {
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
							O.skey = c;
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
									skey: O.skey,
									callback: function(a, b, c) {
										"" === b && ($("#grid").jqGrid("addRowData", a, {}, "last"), O.newId = a + 1), setTimeout(function() {
											$("#grid").jqGrid("editCell", c, 2, !0)
										}, 10), O.calTotal()
									}
								},
								init: function() {
									O.skey = ""
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
					switch ("qty" == b && THISPAGE.calTotal(), b) {
					case "goods":
						break;
					case "qty":
						break;
					case "batch":
						var f = $("#grid").jqGrid("getRowData", a),
							g = $("#" + a).data("goodsInfo") || {};
						if (g.safeDays) {
							var h = {};
							if ($.trim(f.prodDate) || (h.prodDate = P), $.trim(f.safeDays) || (h.safeDays = g.safeDays), !$.trim(f.validDate)) {
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
						$.trim(f.safeDays) || (h.safeDays = g.safeDays), $.trim(c) || (h.prodDate = P);
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
					O.mod_PageConfig.setGridWidthByIndex(a, b, V)
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
				isTemp ? d.$_date.val(SYSTEM.endDate) : d.$_date.val(a.date), d.$_number.text(a.billNo), d.$_amount.val(a.amount), d.$_note.html(a.note), d.$_userName.html(a.userName), d.$_modifyTime.html(a.modifyTime), d.$_createTime.html(a.createTime)
			}
			for (var c = 1; c < a.entries.length; c++) a.entries[c].id -= 1;
			$("#grid").clearGridData(!0), $("#fixedGrid").clearGridData();
			var d = this,
				e = 6 - a.entries.length;
			if (e > 0) for (var c = 0; e > c; c++) a.entries.push({});
			"edit" === a.status || isTemp ? ($("#fixedGrid").jqGrid("setGridParam", {
				data: [a.entries.shift()],
				cellEdit: !0,
				datatype: "clientSide"
			}).trigger("reloadGrid"), $("#grid").jqGrid("setGridParam", {
				data: a.entries,
				userData: {
					qty: a.totalQty,
					amount: a.totalAmount
				},
				cellEdit: !0,
				datatype: "clientSide"
			}).trigger("reloadGrid"), b(), this.editable || (this.$_date.removeAttr("disabled"), this.editable = !0)) : ($("#grid").jqGrid("setGridParam", {
				url: "",
				datatype: "json",
				cellEdit: !1
			}).trigger("reloadGrid"), b(), this.editable && (this.$_data.attr(disabled, "disabled"), this.editable = !1))
		},
		initCombo: function() {
			this.goodsCombo_0 = Business.billGoodsCombo($(".goodsAuto_0"), {
				userData: {
					isCreate: !0
				}
			}), this.goodsCombo = Business.billGoodsCombo($(".goodsAuto")), this.skuCombo_0 = Business.billskuCombo($(".skuAuto_0"), {
				data: []
			}), this.skuCombo = Business.billskuCombo($(".skuAuto"), {
				data: []
			}), this.storageCombo_0 = Business.billStorageCombo($(".storageAuto_0")), this.storageCombo = Business.billStorageCombo($(".storageAuto")), this.unitCombo_0 = Business.unitCombo($(".unitAuto_0"), {
				defaultSelected: -1,
				forceSelection: !1
			}), this.unitCombo = Business.unitCombo($(".unitAuto"), {
				defaultSelected: -1,
				forceSelection: !1
			}), this.cellPikaday_0 = new Pikaday({
				field: $(".dateAuto_0")[0],
				editable: !1
			}), this.batchCombo_0 = Business.batchCombo($(".batchAuto_0")), this.cellPikaday = new Pikaday({
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
			}), THISPAGE.$_amount.on("keypress", function(a) {
				Public.numerical(a)
			}).on("click", function() {
				this.select()
			}).on("blur", function() {
				var a = $("#fixedGrid").jqGrid("getRowData", "fix1"),
					b = Number($(this).val()) + Number($("#grid").jqGrid("footerData", "get").amount.replace(/,/g, "")),
					c = b / Number(a.qty);
				$("#fixedGrid").jqGrid("setRowData", "fix1", {
					price: c,
					amount: b
				})
			}), $(".grid-wrap").on("click", ".ui-icon-triangle-1-s", function(a) {
				var b = $(this).siblings(),
					c = b.getCombo();
				setTimeout(function() {
					c.active = !0, c.doQuery()
				}, 10)
			}), Business.billsEvent(a, "assemble"), $("#fixedGrid").on("click", ".goods .ui-icon-ellipsis", function(b) {
				$(this).prev("input");
				$.dialog({
					width: 775,
					height: 510,
					title: "选择商品",
					content: "url:../settings/goods_batch",
					data: {
						skuMult: SYSTEM.enableAssistingProp,
						curID: a.curID,
						newId: a.newId,
						callback: function(a, b, c) {}
					},
					lock: !0,
					button: [{
						name: "确定",
						defClass: "ui_state_highlight",
						callback: function() {
							return this.content.callbackSp("assemble"), this.close(), !1
						}
					}, {
						name: "关闭",
						callback: function() {
							return !0
						}
					}]
				})
			}), $("#grid").on("click", ".goods .ui-icon-ellipsis", function(b) {
				$(this).prev("input");
				$.dialog({
					width: 775,
					height: 510,
					title: "选择商品",
					content: "url:../settings/goods_batch",
					data: {
						skuMult: SYSTEM.enableAssistingProp,
						curID: a.curID,
						newId: a.newId,
						callback: function(b, c, d) {
							"" === c && ($("#grid").jqGrid("addRowData", b, {}, "last"), a.newId = b + 1), setTimeout(function() {
								$("#grid").jqGrid("editCell", d, 2, !0)
							}, 10), a.calTotal()
						}
					},
					lock: !0,
					button: [{
						name: "选中",
						defClass: "ui_state_highlight fl",
						callback: function() {
							return this.content.callback("assemble"), !1
						}
					}, {
						name: "选中并关闭",
						defClass: "ui_state_highlight",
						callback: function() {
							return this.content.callback("assemble"), this.close(), !1
						}
					}, {
						name: "关闭",
						callback: function() {
							return !0
						}
					}]
				})
			}), $("#grid").on("click", ".skuInfo .ui-icon-ellipsis", function(a) {
				if (SYSTEM.enableAssistingProp) {
					var b = $("#" + THISPAGE.curID).data("goodsInfo");
					b && (b.skuId || b.skuClassId) && Business.billSkuManage($("#" + THISPAGE.curID), b)
				}
			}), $("#fixedGrid").on("click", ".skuInfo .ui-icon-ellipsis", function(a) {
				if (SYSTEM.enableAssistingProp) {
					var b = $("#" + THISPAGE.curID).data("goodsInfo");
					b && (b.skuId || b.skuClassId) && Business.billSkuManage($("#" + THISPAGE.curID), b)
				}
			}), $(document).bind("click.cancel", function(a) {
				null !== curRow && null !== curCol && (!$(a.target).closest("#fixedGrid").length > 0 && 0 == $(a.target).closest(".pika-single").length && $("#fixedGrid").jqGrid("saveCell", curRow, curCol), !$(a.target).closest("#grid").length > 0 && 0 == $(a.target).closest(".pika-single").length && $("#grid").jqGrid("saveCell", curRow, curCol))
			}), $(".wrapper").on("click", "#save", function(b) {
				b.preventDefault();
				var c = $(this);
				if (c.hasClass("ui-btn-dis")) return void parent.Public.tips({
					type: 2,
					content: "正在保存，请稍后..."
				});
				THISPAGE.$_amount.trigger("blur");
				var d = THISPAGE.getPostData();
				d && ("edit" === originalData.stata && (d.id = originalData.id, d.stata = "edit"), c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invOi/addZz?action=addZz&type=zz", {
					postData: JSON.stringify(d)
				}, function(b) {
					c.removeClass("ui-btn-dis"), 200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), a.$_createTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, urlParam.id = b.data.id, THISPAGE.reloadData(b.data), a.$_toolBottom.html('<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a id="edit" class="ui-btn mrb">保存</a><a href="/scm/invOi.do?action=toOoPdf&id=' + originalData.id + '" target="_blank" id="print" class="ui-btn">打印</a>'), parent.Public.tips({
						content: "保存成功！"
					})) : parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#edit", function(b) {
				if (b.preventDefault(), Business.verifyRight("ZZD_UPDATE")) {
					var c = THISPAGE.getPostData();
					c && Public.ajaxPost("../scm/invOi/updateZz?action=updateZz&type=zz", {
						postData: JSON.stringify(c)
					}, function(b) {
						200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, urlParam.id = b.data.id, THISPAGE.reloadData(b.data), parent.Public.tips({
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
				d && (c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invOi/addNewZz?action=addNewZz&type=zz", {
					postData: JSON.stringify(d)
				}, function(b) {
					if (c.removeClass("ui-btn-dis"), 200 === b.status) {
						a.$_number.text(b.data.billNo), $("#fixedGrid").clearGridData(), $("#grid").clearGridData(!0), $("#fixedGrid").jqGrid("addRowData", 1, {});
						for (var d = 1; 5 >= d; d++) $("#grid").jqGrid("addRowData", d, {});
						a.newId = 6, a.$_note.val(""), parent.Public.tips({
							content: "保存成功！"
						})
					} else parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#add", function(a) {
				a.preventDefault(), Business.verifyRight("ZZD_ADD") && parent.tab.overrideSelectedTabItem({
					tabid: "storage-otherOutbound",
					text: "组装单",
					url: "../scm/invOi?action=initOi&type=zz"
				})
			}), $(".wrapper").on("click", "#print", function(a) {
				a.preventDefault(), Business.verifyRight("ZZD_PRINT") && Public.print({
					title: "组装单列表",
					$grid: $("#grid"),
					pdf: "../scm/invOi/toZzdPdf?action=toZzdPdf",
					billType: 10419,
					filterConditions: {
						id: originalData.id
					}
				})
			}), $("#prev").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-prev-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有上一张了！"
				}), !1) : (a.idPostion = a.idPostion - 1, 0 === a.idPostion && $(this).addClass("ui-btn-prev-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invOi/updateOut?action=updateOut&type=zz", {
					id: a.salesListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#next").removeClass("ui-btn-next-dis"), loading && loading.close()
				}), void 0)
			}), $("#next").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-next-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有下一张了！"
				}), !1) : (a.idPostion = a.idPostion + 1, a.idLength === a.idPostion + 1 && $(this).addClass("ui-btn-next-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invOi/updateOut?action=updateOut&type=zz", {
					id: a.salesListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#prev").removeClass("ui-btn-prev-dis"), loading && loading.close()
				}), void 0)
			}), $(".wrapper").on("click", "#saveTemp", function(a) {
				a.preventDefault(), THISPAGE.$_amount.trigger("blur");
				var b = THISPAGE.getPostData();
				if (b.id = -1, b) {
					var c = Number(b.entries[0].qty);
					if (1 !== c) {
						for (var d = 1; d < b.entries.length; d++) b.entries[d].qty = Number(b.entries[d].qty) / c + "";
						b.totalQty = Number(b.totalQty) / c + "", b.entries[0].qty = 1
					}
					$.dialog({
						lock: !0,
						width: 280,
						height: 120,
						title: "模板名称",
						content: '<div class="re-initialize"><label for="tempName">模板名称:</label> <input type="text" id="templateName" name="templateName" class="ui-input" value=""></div>',
						okVal: "确定",
						ok: function() {
							var a = this;
							return b.templateName = $.trim($("#templateName").val()), Public.ajaxPost("../scm/invTemplate/add?action=add&type=zz", {
								postData: JSON.stringify(b)
							}, function(b) {
								200 === b.status ? (parent.Public.tips({
									content: "模板保存成功！"
								}), a.close()) : parent.Public.tips({
									type: 1,
									content: b.msg
								})
							}), !1
						},
						cancelVal: "取消",
						cancel: !0
					})
				}
			}), $("#chooseTemp").on("click", function() {
				$.dialog({
					width: 780,
					height: 510,
					title: "选择模板",
					content: "url:../storage/select_temp",
					data: {
						url: "../scm/invTemplate?action=list&type=zz",
						callback: function(a, b) {
							a ? Public.ajaxGet("../scm/invTemplate/update?action=update&type=zz", {
								id: a
							}, function(a) {
								200 === a.status ? (originalData = a.data, a.data.id = -1, isTemp = !0, THISPAGE.reloadData(originalData), b.close()) : parent.Public.tips({
									type: 1,
									content: a.msg
								})
							}) : parent.Public.tips({
								type: 1,
								content: "请先选择一个模板！"
							})
						}
					},
					lock: !0
				})
			}), $("#grid,#fixedGrid").on("click", 'tr[role="row"]', function(a) {
				if ($("#mark").hasClass("has-audit")) {
					var b = $(this),
						c = (b.prop("id"), b.data("goodsInfo"));
					if (!c) return;
					if (SYSTEM.ISSERNUM && 1 == c.isSerNum) {
						var d = c.serNumList;
						Business.serNumManage({
							row: b,
							data: c,
							serNumUsedList: d,
							view: !0
						})
					}
				}
			}), $("#config").show().click(function(b) {
				a.mod_PageConfig.config()
			}), $(window).resize(function(a) {
				Public.autoGrid($("#grid")), Public.autoGrid($("#fixedGrid"))
			})
		},
		resetData: function() {
			var a = this;
			$("#grid").clearGridData(!0), $("#fixedGrid").clearGridData();
			for (var b = 1; 8 >= b; b++) $("#grid").jqGrid("addRowData", b, {}), $("#grid").jqGrid("footerData", "set", {
				qty: 0,
				amount: 0
			});
			a.$_note.val(""), a.$_discountRate.val(originalData.disRate), a.$_deduction.val(originalData.disAmount), a.$_discount.val(originalData.amount), a.$_payment.val(originalData.rpAmount), a.$_arrears.val(originalData.arrears)
		},
		calTotal: function() {
			for (var a = $("#grid").jqGrid("getDataIDs"), b = 0, c = 0, d = 0, e = a.length; e > d; d++) {
				var f = a[d],
					g = $("#grid").jqGrid("getRowData", f);
				g.qty && (b += parseFloat(g.qty)), g.amount && (c += parseFloat(g.amount))
			}
			$("#grid").jqGrid("footerData", "set", {
				qty: b,
				amount: c
			})
		},
		_getEntriesData: function(a) {
			a = a || {};
			var b = [],
				c = $("#fixedGrid").jqGrid("getRowData", "fix1"),
				d = $("#fix1").data("goodsInfo"),
				e = $("#fix1").data("skuInfo") || {};
			if (d.invSkus && d.invSkus.length > 0 && !e.id) return parent.Public.tips({
				type: 2,
				content: "请选择相应的属性！"
			}), $("#fixedGrid").jqGrid("editCellByColName", "fix1", "skuName"), !1;
			var f = $("#fix1").data("storageInfo");
			if (!f || !f.id) return parent.Public.tips({
				type: 2,
				content: "请选择相应的仓库！"
			}), $("#fixedGrid").jqGrid("editCellByColName", "fix1", "locationName"), !1;
			var g = $("#fix1").data("unitInfo") || {};
			if ("" === c.goods) return parent.Public.tips({
				type: 2,
				content: "组件信息不能为空！"
			}), !1;
			if (SYSTEM.ISSERNUM) {
				var h = d.serNumList;
				if (h && h.length == Number(c.qty));
				else {
					var i = !1,
						j = "点击";
					if (d.isSerNum && (i = !0, a.checkSerNum && (i = !0)), i) return parent.Public.tips({
						type: 2,
						content: "请" + j + "数量设置【" + d.name + "】的序列号"
					}), $("#fixedGrid").jqGrid("editCellByColName", "fix1", "qty"), !1
				}
			}
			var k = {
				invId: d.id,
				invNumber: d.number,
				invName: d.name,
				invSpec: d.spec || "",
				unitId: g.unitId || g.id || -1,
				mainUnit: g.name || "",
				skuId: e.id || -1,
				skuName: e.name || "",
				qty: c.qty,
				price: c.price,
				amount: c.amount,
				locationId: f.id,
				locationName: f.name,
				serNumList: h
			};
			SYSTEM.ISWARRANTY && $.extend(!0, k, {
				batch: c.batch || "",
				prodDate: c.prodDate || "",
				safeDays: c.safeDays || "",
				validDate: c.validDate || ""
			}), b.push(k);
			for (var l = $("#grid").jqGrid("getDataIDs"), m = 0, n = l.length; n > m; m++) {
				var o, p = l[m],
					q = $("#grid").jqGrid("getRowData", p);
				if ("" !== q.goods) {
					var r = $("#" + p).data("goodsInfo"),
						s = $("#" + p).data("skuInfo") || {};
					if (r.invSkus && r.invSkus.length > 0 && !s.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的属性！"
					}), $("#grid").jqGrid("editCellByColName", p, "skuName"), !1;
					var t = $("#" + p).data("storageInfo");
					if (!t || !t.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的仓库！"
					}), $("#grid").jqGrid("editCellByColName", p, "locationName"), !1;
					var u = $("#" + p).data("unitInfo") || {},
						h = r.serNumList;
					if (h && h.length == Number(q.qty));
					else {
						var i = !1,
							j = "点击";
						if (1 == r.isSerNum && (i = !0, a.checkSerNum && (i = !0)), i) return parent.Public.tips({
							type: 2,
							content: "请" + j + "数量设置【" + r.name + "】的序列号"
						}), $("#grid").jqGrid("editCellByColName", p, "qty"), !1
					}
					o = {
						invId: r.id,
						invNumber: r.number,
						invName: r.name,
						invSpec: r.spec || "",
						skuId: s.id || -1,
						skuName: s.name || "",
						unitId: u.unitId || -1,
						mainUnit: u.name || "",
						qty: q.qty,
						price: q.price,
						amount: q.amount,
						locationId: t.id,
						locationName: t.name,
						description: q.description,
						serNumList: h
					}, SYSTEM.ISWARRANTY && $.extend(!0, o, {
						batch: q.batch || "",
						prodDate: q.prodDate || "",
						safeDays: q.safeDays || "",
						validDate: q.validDate || ""
					}), b.push(o)
				}
			}
			return b
		},
		getPostData: function(a) {
			var b = this;
			null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), $("#fixedGrid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null);
			var c = this._getEntriesData(a);
			if (!c) return !1;
			if (c.length > 1) {
				var d = $.trim(b.$_note.val());
				b.calTotal();
				var e = {
					id: originalData.id,
					date: $.trim(b.$_date.val()),
					billNo: $.trim(b.$_number.text()),
					entries: c,
					totalQty: $("#grid").jqGrid("footerData", "get").qty.replace(/,/g, ""),
					totalAmount: $("#grid").jqGrid("footerData", "get").amount.replace(/,/g, ""),
					amount: $.trim(b.$_amount.val()) || 0,
					description: d === b.$_note[0].defaultValue ? "" : d
				};
				return e
			}
			return parent.Public.tips({
				type: 2,
				content: "子件信息不能为空！"
			}), $("#grid").jqGrid("editCell", 1, 2, !0), !1
		}
	};
$(function() {
	urlParam.id ? hasLoaded || Public.ajaxGet("../scm/invOi/updateZzd?action=updateZzd&type=zz", {
		id: urlParam.id
	}, function(a) {
		if (200 === a.status) {
			originalData = a.data;
			for (var b = 1; b < originalData.entries.length; b++) originalData.entries[b].id -= 1;
			THISPAGE.init(originalData), hasLoaded = !0
		} else parent.Public.tips({
			type: 1,
			content: a.msg
		})
	}) : (originalData = {
		id: -1,
		status: "add",
		customer: 0,
		transType: 0,
		header: [],
		entries: [{
			id: "1"
		}, {
			id: "1"
		}, {
			id: "2"
		}, {
			id: "3"
		}, {
			id: "4"
		}, {
			id: "5"
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