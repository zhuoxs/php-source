var curRow, curCol, curArrears, loading, urlParam = Public.urlParam(),
	SYSTEM = parent.SYSTEM,
	hiddenAmount = !1,
	billRequiredCheck = 0,
	//billRequiredCheck = system.billRequiredCheck,
	disEditable = urlParam.disEditable,
	qtyPlaces = Number(parent.SYSTEM.qtyPlaces),
	pricePlaces = Number(parent.SYSTEM.pricePlaces),
	amountPlaces = Number(parent.SYSTEM.amountPlaces),
	hasLoaded = !1,
	originalData, defaultPage = Public.getDefaultPage(),
	THISPAGE = {
		init: function(a) {
			this.mod_PageConfig = Public.mod_PageConfig.init("otherOutbound"), SYSTEM.isAdmin !== !1 || SYSTEM.rights.AMOUNT_COSTAMOUNT || (hiddenAmount = !0), this.loadGrid(a), this.initDom(a), this.initCombo(), this.addEvent()
		},
		initDom: function(a) {
			this.$_customer = $("#customer"), this.$_date = $("#date").val(SYSTEM.endDate), this.$_number = $("#number"), this.$_transType = $("#transType"), this.$_note = $("#note"), this.$_toolTop = $("#toolTop"), this.$_toolBottom = $("#toolBottom"), this.$_userName = $("#userName"), this.$_modifyTime = $("#modifyTime"), this.$_createTime = $("#createTime"), this.customerArrears = 0;
			var b = ["id", a.transType || 150806];
			this.customerCombo = Business.billCustomerCombo($("#customer"), {
				defaultSelected: 0,
				emptyOptions: !0
			}), this.$_note.placeholder(), this.transTypeCombo = this.$_transType.combo({
				data: "../scm/invOi/queryTransType?action=queryTransType&type=out",
				ajaxOptions: {
					formatData: function(a) {
						return a.data.items
					}
				},
				width: 80,
				height: 300,
				text: "name",
				value: "id",
				defaultSelected: b,
				cache: !1,
				defaultFlag: !1
			}).getCombo(), this.$_date.datepicker({
				onSelect: function(a) {
					if (!(originalData.id > 0)) {
						var b = a.format("yyyy-MM-dd");
						THISPAGE.$_number.text(""), Public.ajaxPost("../basedata/systemProfile/generateDocNo?action=generateDocNo", {
							billType: "OO",
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
			var c = "",
				d = "",
				e = "";
			if (billRequiredCheck && (c = '<a class="ui-btn" id="audit">审核</a>', d = '<a class="ui-btn" id="reAudit">反审核</a>'), this.btn_audit = c, this.btn_reaudit = d, this.btn_tempSave = e, this.btn_add = '<a id="savaAndAdd" class="ui-btn ui-btn-sp mrb">保存并新增</a><a id="save" class="ui-btn">保存</a>' + e, this.btn_edit = '<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a href="../scm/invOi/toOoPdf?action=toOoPdf&billType=OO" target="_blank" id="print" class="ui-btn mrb">打印</a><a id="edit" class="ui-btn">保存</a>', this.btn_view = '<a id="add" class="ui-btn ui-btn-sp mrb">新增</a><a href="../scm/invOi/toOoPdf?action=toOoPdf&billType=OO" target="_blank" id="print" class="ui-btn mrb">打印</a>', this.btn_p_n = '<a class="ui-btn-prev mrb" id="prev" title="上一张"><b></b></a><a class="ui-btn-next" id="next" title="下一张"><b></b></a>', a.id > 0) {
				if (this.$_customer.data("contactInfo", {
					id: a.buId,
					name: a.contactName
				}), this.customerCombo.input.val(a.contactName), this.$_number.text(a.billNo), this.$_date.val(a.date), a.description && this.$_note.val(a.description), $("#grid").jqGrid("footerData", "set", {
					qty: a.totalQty,
					amount: a.totalAmount
				}), "edit" === a.status) {
					var f = this.btn_edit + this.btn_audit;
					a.temp || (f += e), this.$_toolBottom.html(f), !a.temp
				} else a.checked ? ($("#mark").addClass("has-audit"), this.$_toolBottom.html(this.btn_view + this.btn_reaudit + this.btn_p_n)) : this.$_toolBottom.html(this.btn_view + this.btn_p_n);
				this.salesListIds = parent.salesListIds || [], this.idPostion = $.inArray(String(a.id), this.salesListIds), this.idLength = this.salesListIds.length, 0 === this.idPostion && $("#prev").addClass("ui-btn-prev-dis"), this.idPostion === this.idLength - 1 && $("#next").addClass("ui-btn-next-dis"), this.$_userName.html(a.userName), this.$_modifyTime.html(a.modifyTime), this.$_createTime.html(a.createTime)
			} else billRequiredCheck ? this.$_toolBottom.html(this.btn_add + this.btn_audit) : this.$_toolBottom.html(this.btn_add), this.$_userName.html(SYSTEM.realName || ""), this.$_modifyTime.parent().hide(), this.$_createTime.parent().hide()
		},
		disableEdit: function() {
			this.customerCombo.disable(), this.$_date.attr("disabled", "disabled").addClass("ui-input-dis"), this.$_note.attr("disabled", "disabled").addClass("ui-input-dis"), $("#grid").jqGrid("setGridParam", {
				cellEdit: !1
			}), this.editable = !1
		},
		enableEdit: function() {
			disEditable || (this.customerCombo.enable(), this.$_date.removeAttr("disabled").removeClass("ui-input-dis"), this.$_note.removeAttr("disabled").removeClass("ui-input-dis"), $("#grid").jqGrid("setGridParam", {
				cellEdit: !0
			}), this.editable = !0)
		},
		loadGrid: function(a) {
			function b(a, b, c) {
				return u(b.rowId), a ? a : c.invNumber ? c.invSpec ? c.invNumber + " " + c.invName + "_" + c.invSpec : c.invNumber + " " + c.invName : "&#160;"
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
				var c = $(".unitAuto")[0];
				return c
			}
			function m(a, b, c) {
				if ("get" === b) {
					if ("" !== $(".unitAuto").getCombo().getValue()) return $(a).val();
					var d = $(a).parents("tr"),
						e = d.data("unitInfo") || {};
					return THISPAGE.unitCombo.selectByIndex(e.unitId || e.id), e.name || ""
				}
				"set" === b && $("input", a).val(c)
			}
			function n() {
				$("#initCombo").append($(".unitAuto").val(""))
			}
			function o(a, b) {
				var c = $(".dateAuto")[0];
				return c
			}
			function p(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function q() {
				$("#initCombo").append($(".dateAuto"))
			}
			function r(a, b) {
				var c = $(".batchAuto")[0];
				return c
			}
			function s(a, b, c) {
				return "get" === b ? a.val() : void("set" === b && $("input", a).val(c))
			}
			function t() {
				$("#initCombo").append($(".batchAuto").val(""))
			}
			function u(a) {
				var b = $("#" + a).data("goodsInfo");
				if (b) {
					b.batch || $("#grid").jqGrid("setCell", a, "batch", "&#160;"), b.safeDays || ($("#grid").jqGrid("setCell", a, "prodDate", "&#160;"), $("#grid").jqGrid("setCell", a, "safeDays", "&#160;"), $("#grid").jqGrid("setCell", a, "validDate", "&#160;")), 1 == b.isWarranty && $("#grid").jqGrid("showCol", "batch"), b.safeDays > 0 && ($("#grid").jqGrid("showCol", "prodDate"), $("#grid").jqGrid("showCol", "safeDays"), $("#grid").jqGrid("showCol", "validDate"));
					var c = {
						skuName: b.skuName || "",
						mainUnit: b.mainUnit || b.unitName,
						unitId: b.unitId,
						qty: b.qty || 1,
						price: b.price || 0,
						amount: b.amount,
						locationName: b.locationName,
						locationId: b.locationId,
						serNumList: b.serNumList,
						safeDays: b.safeDays
					};
					SYSTEM.ISSERNUM && b.isSerNum && (c.qty = c.serNumList ? c.serNumList.length : 0), c.amount = c.amount ? c.amount : c.price * c.qty;
					var d = (Number(c.amount), $("#grid").jqGrid("setRowData", a, c));
					d && THISPAGE.calTotal()
				}
			}
			var v = this,
				w = (new Date).format();
			if (a.id) {
				for (var x = 0; x < a.entries.length; x++) a.entries[x].id = x + 1;
				var y = 8 - a.entries.length;
				if (y > 0) for (var x = 0; y > x; x++) a.entries.push({})
			}
			v.newId = 9;
			var z = "grid",
				A = [{
					name: "operating",
					label: " ",
					width: 40,
					fixed: !0,
					formatter: Public.billsOper,
					align: "center"
				}, {
					name: "goods",
					label: "商品",
					width: 320,
					title: !0,
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
						custom_element: l,
						custom_value: m,
						handle: n,
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
						custom_element: i,
						custom_value: j,
						handle: k,
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
						custom_element: r,
						custom_value: s,
						handle: t,
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
						custom_element: o,
						custom_value: p,
						handle: q
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
					width: 150,
					title: !0,
					editable: !0
				}];
			v.mod_PageConfig.gridReg(z, A), A = v.mod_PageConfig.conf.grids[z].colModel, $("#grid").jqGrid({
				data: a.entries,
				datatype: "clientSide",
				autowidth: !0,
				height: "100%",
				rownumbers: !0,
				gridview: !0,
				onselectrow: !1,
				colModel: A,
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
					if (urlParam.id > 0 || urlParam.cacheId) {
						var b = a.rows,
							c = b.length;
						v.newId = c + 1;
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
						if ("string" == typeof g.invSkus && (g.invSkus = $.parseJSON(g.invSkus)), $("#" + d + "_skuName", "#grid").val(c), THISPAGE.skuCombo.loadData(g.invSkus || [], 1, !1), THISPAGE.skuCombo.selectByText(c), !g) return;
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
						$("#" + a).data("storageInfo") || {};
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
							v.skey = c;
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
									skey: v.skey,
									callback: function(a, b, c) {
										"" === b && ($("#grid").jqGrid("addRowData", a, {}, "last"), v.newId = a + 1), setTimeout(function() {
											$("#grid").jqGrid("editCell", c, 2, !0)
										}, 10), v.calTotal()
									}
								},
								init: function() {
									v.skey = ""
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
							if ($.trim(f.prodDate) || (h.prodDate = w), $.trim(f.safeDays) || (h.safeDays = g.safeDays), !$.trim(f.validDate)) {
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
						$.trim(f.safeDays) || (h.safeDays = g.safeDays || 30), $.trim(c) || (h.prodDate = w);
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
					v.mod_PageConfig.setGridWidthByIndex(a, b, "grid")
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
				c.$_customer.data("contactInfo", {
					id: a.buId,
					name: a.contactName
				}), c.customerCombo.input.val(a.contactName), c.$_date.val(a.date), c.$_number.text(a.billNo), c.$_note.val(a.description), c.$_userName.html(a.userName), c.$_modifyTime.html(a.modifyTime), c.$_createTime.html(a.createTime)
			}
			$("#grid").clearGridData();
			var c = this,
				d = 8 - a.entries.length;
			if (d > 0) for (var e = 0; d > e; e++) a.entries.push({});
			$("#grid").jqGrid("setGridParam", {
				data: a.entries,
				userData: {
					qty: a.totalQty,
					amount: a.totalAmount
				},
				cellEdit: !0,
				datatype: "clientSide"
			}).trigger("reloadGrid"), b(), "edit" === a.status ? this.editable || (this.customerCombo.enable(), this.$_date.removeAttr("disabled"), this.editable = !0, this.$_toolBottom.html(c.btn_edit + c.btn_audit), $("#mark").removeClass("has-audit")) : this.editable && (this.customerCombo.disable(), this.$_date.attr("disabled", "disabled"), this.editable = !1, $("#groupBtn").html(c.btn_view + c.btn_reaudit), $("#mark").addClass("has-audit"))
		},
		initCombo: function() {
			this.goodsCombo = Business.billGoodsCombo($(".goodsAuto")), this.skuCombo = Business.billskuCombo($(".skuAuto"), {
				data: []
			}), this.storageCombo = Business.billStorageCombo($(".storageAuto")), this.unitCombo = Business.unitCombo($(".unitAuto"), {
				defaultSelected: -1,
				forceSelection: !1
			}), this.cellPikaday = new Pikaday({
				field: $(".dateAuto")[0],
				editable: !1
			}), this.batchCombo = Business.batchCombo($(".batchAuto"))
		},
		addEvent: function() {
			var a = this;
			this.customerCombo.input.enterKey(), this.$_date.bind("keydown", function(a) {
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
			}), Business.billsEvent(a, "otherOutbound"), $(".wrapper").on("click", "#save", function(b) {
				b.preventDefault();
				var c = $(this);
				if (c.hasClass("ui-btn-dis")) return void parent.Public.tips({
					type: 2,
					content: "正在保存，请稍后..."
				});
				var d = THISPAGE.getPostData();
				d && ("edit" === originalData.stata && (d.id = originalData.id, d.stata = "edit"), c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invOi/addOo?action=addOo&type=out", {
					postData: JSON.stringify(d)
				}, function(b) {
					c.removeClass("ui-btn-dis"), 200 === b.status ? (a.$_modifyTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), a.$_createTime.html((new Date).format("yyyy-MM-dd hh:mm:ss")).parent().show(), originalData.id = b.data.id, urlParam.id = b.data.id, THISPAGE.reloadData(b.data), billRequiredCheck ? a.$_toolBottom.html(a.btn_edit + a.btn_audit) : a.$_toolBottom.html(a.btn_edit), parent.Public.tips({
						content: "保存成功！"
					}), originalData.callback && originalData.callback("out")) : parent.Public.tips({
						type: 1,
						content: b.msg
					})
				}))
			}), $(".wrapper").on("click", "#edit", function(b) {
				if (b.preventDefault(), Business.verifyRight("OO_UPDATE")) {
					var c = THISPAGE.getPostData();
					c && Public.ajaxPost("../scm/invOi/updateOo?action=updateOo&type=out", {
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
			}), $(".wrapper").on("click", "#audit", function(b) {
				if (b.preventDefault(), Business.verifyRight("OO_CHECK")) {
					var c = THISPAGE.getPostData();
					c && Public.ajaxPost("../scm/invOi/checkInvOo?action=checkInvOo", {
						postData: JSON.stringify(c)
					}, function(b) {
						200 === b.status ? (originalData.id = b.data.id, urlParam.id = b.data.id, THISPAGE.reloadData(b.data), $("#mark").addClass("has-audit"), $("#edit").hide(), a.disableEdit(), a.$_toolBottom.html(a.btn_view + a.btn_reaudit), parent.Public.tips({
							content: "审核成功！"
						}), originalData.callback && originalData.callback("out")) : parent.Public.tips({
							type: 1,
							content: b.msg
						})
					})
				}
			}), $(".wrapper").on("click", "#reAudit", function(b) {
				if (b.preventDefault(), Business.verifyRight("OO_UNCHECK")) {
					var c = $(this);
					c.ajaxPost("../scm/invOi/rsBatchCheckInvOo?action=rsBatchCheckInvOo", {
						id: originalData.id
					}, function(b) {
						200 === b.status ? ($("#mark").removeClass(), $("#edit").show(), a.enableEdit(), a.$_toolBottom.html(a.btn_edit + a.btn_audit), parent.Public.tips({
							content: "反审核成功！"
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
				d && (c.addClass("ui-btn-dis"), Public.ajaxPost("../scm/invOi/addNewOo?action=addNewOo&type=out", {
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
				a.preventDefault(), Business.verifyRight("OO_ADD") && parent.tab.overrideSelectedTabItem({
					tabid: "storage-otherOutbound",
					text: "其他出库",
					url: "../scm/invOi?action=initOi&type=out"
				})
			}), $(".wrapper").on("click", "#print", function(a) {
				return Business.verifyRight("OO_PRINT") ? void(this.href += "&id=" + originalData.id) : void a.preventDefault()
			}), $("#prev").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-prev-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有上一张了！"
				}), !1) : (a.idPostion = a.idPostion - 1, 0 === a.idPostion && $(this).addClass("ui-btn-prev-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invOi/updateOut?action=updateOut&type=out", {
					id: a.salesListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#next").removeClass("ui-btn-next-dis"), loading && loading.close()
				}), void 0)
			}), $("#next").click(function(b) {
				return b.preventDefault(), $(this).hasClass("ui-btn-next-dis") ? (parent.Public.tips({
					type: 2,
					content: "已经没有下一张了！"
				}), !1) : (a.idPostion = a.idPostion + 1, a.idLength === a.idPostion + 1 && $(this).addClass("ui-btn-next-dis"), loading = $.dialog.tips("数据加载中...", 1e3, "loading.gif", !0), Public.ajaxGet("../scm/invOi/updateOut?action=updateOut&type=out", {
					id: a.salesListIds[a.idPostion]
				}, function(a) {
					THISPAGE.reloadData(a.data), $("#prev").removeClass("ui-btn-prev-dis"), loading && loading.close()
				}), void 0)
			}), $("#grid").on("click", 'tr[role="row"]', function(a) {
				if ($("#mark").hasClass("has-audit")) {
					var b = $(this),
						c = (b.prop("id"), b.data("goodsInfo"));
					if (!c) return;
					SYSTEM.ISSERNUM && 1 == c.isSerNum && Business.serNumManage({
						row: b,
						view: !0
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
			for (var b = [], c = $("#grid").jqGrid("getDataIDs"), d = 0, e = c.length; e > d; d++) {
				var f, g = c[d],
					h = $("#grid").jqGrid("getRowData", g);
				if ("" !== h.goods) {
					var i = $("#" + g).data("goodsInfo"),
						j = $("#" + g).data("skuInfo") || {};
					if (i.invSkus && i.invSkus.length > 0 && !j.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的属性！"
					}), $("#grid").jqGrid("editCellByColName", g, "skuName"), !1;
					var k = $("#" + g).data("storageInfo");
					if (!k || !k.id) return parent.Public.tips({
						type: 2,
						content: "请选择相应的仓库！"
					}), $("#grid").jqGrid("editCellByColName", g, "locationName"), !1;
					var l = $("#" + g).data("unitInfo") || {};
					if (SYSTEM.ISSERNUM) {
						var m = i.serNumList;
						if (m && m.length == Number(h.qty));
						else {
							var n = !1,
								o = "点击";
							if (1 == i.isSerNum && (n = !0, a.checkSerNum && (n = !0)), n) return parent.Public.tips({
								type: 2,
								content: "请" + o + "数量设置【" + i.name + "】的序列号"
							}), $("#grid").jqGrid("editCellByColName", g, "qty"), !1
						}
					}
					f = {
						invId: i.id,
						invNumber: i.number,
						invName: i.name,
						invSpec: i.spec || "",
						skuId: j.id || -1,
						skuName: j.name || "",
						unitId: l.unitId || -1,
						mainUnit: l.name || "",
						qty: h.qty,
						price: h.price,
						amount: h.amount,
						description: h.description,
						locationId: k.id,
						locationName: k.name,
						serNumList: m
					}, SYSTEM.ISWARRANTY && $.extend(!0, f, {
						batch: h.batch || "",
						prodDate: h.prodDate || "",
						safeDays: h.safeDays || "",
						validDate: h.validDate || ""
					}), b.push(f)
				}
			}
			return b
		},
		getPostData: function(a) {
			var b = this,
				c = this;
			null !== curRow && null !== curCol && ($("#grid").jqGrid("saveCell", curRow, curCol), curRow = null, curCol = null);
			var d = c.$_customer.find("input");
			if ("" === d.val() || "(空)" === d.val()) {
				var e = {};
				e.id = 0, e.name = "(空)", c.$_customer.removeData("contactInfo")
			} else {
				var e = c.$_customer.data("contactInfo");
				if (null === e) return setTimeout(function() {
					d.focus().select()
				}, 15), parent.Public.tips({
					type: 2,
					content: "当前客户不存在！"
				}), !1
			}
			var f = this._getEntriesData(a);
			if (!f) return !1;
			if (f.length > 0) {
				var g = $.trim(b.$_note.val());
				b.calTotal();
				var h = {
					id: originalData.id,
					buId: e.id,
					contactName: e.name,
					date: $.trim(b.$_date.val()),
					billNo: $.trim(b.$_number.text()),
					transTypeId: b.transTypeCombo.getValue(),
					transTypeName: b.transTypeCombo.getText(),
					entries: f,
					totalQty: $("#grid").jqGrid("footerData", "get").qty.replace(/,/g, ""),
					totalAmount: $("#grid").jqGrid("footerData", "get").amount.replace(/,/g, ""),
					description: g === b.$_note[0].defaultValue ? "" : g
				};
				return h
			}
			return parent.Public.tips({
				type: 2,
				content: "商品信息不能为空！"
			}), $("#grid").jqGrid("editCell", 1, 2, !0), !1
		}
	};
$(function() {
	if (urlParam.id) hasLoaded || Public.ajaxGet("../scm/invOi/updateOut?action=updateOut&type=out", {
		id: urlParam.id
	}, function(a) {
		200 === a.status ? (originalData = a.data, THISPAGE.init(a.data), hasLoaded = !0) : parent.Public.tips({
			type: 1,
			content: a.msg
		})
	});
	else {
		if (originalData = {
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
		}, urlParam.cacheId) {
			var a = parent.Cache[urlParam.cacheId];
			originalData.transType = a.data.outboundData.transType, originalData.entries = a.data.outboundData.entries, originalData.callback = a.callback
		}
		THISPAGE.init(originalData)
	}
});


 