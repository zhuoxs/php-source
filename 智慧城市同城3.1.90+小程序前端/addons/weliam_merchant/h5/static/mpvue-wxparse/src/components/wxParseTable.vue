<template>
	<view class="wx-parse-table">
		<rich-text :nodes="nodes"></rich-text>
	</view>
</template>

<script>
	export default {
		name: 'wxParseTable',
		props: {
			node: {
				type: Object,
				default () {
					return {};
				},
			},
		},
		data() {
			return {
				nodes: []
			};
		},
		mounted() {
			this.nodes = this.loadNode([this.node]);
		},
		methods: {
			loadNode(node) {
				let obj = [];
				for (let children of node) {
					// console.log(children)
					if (children.node == 'element') {
						let t = {
							name: children.tag,
							attrs: {
								class: children.classStr,
								// style: children.styleStr,
							},
							children: children.nodes ? this.loadNode(children.nodes) : []
						}
						obj.push(t)
					} else if (children.node == 'text') {
						obj.push({
							type: 'text',
							text: children.text
						})
					}
				}
				return obj
			}
		}
	};
</script>

<style>
	.wx-parse-table .table {
		border-collapse: collapse;
		box-sizing: border-box;
		/* 内边框 */
		border: 1px solid #dadada;
		width: 100%;
	}
	
	.wx-parse-table .tbody {
		border-collapse: collapse;
		box-sizing: border-box;
		/* 内边框 */
		border: 1px solid #dadada;
	}
	
	.wx-parse-table .thead,
	.wx-parse-table .tfoot,
	.wx-parse-table .th {
		border-collapse: collapse;
		box-sizing: border-box;
		background: #ececec;
		font-weight: 40;
	}
	
	.wx-parse-table .tr {
		border-collapse: collapse;
		box-sizing: border-box;
		/* border: 2px solid #F0AD4E; */
		overflow: auto;
	}
	
	.wx-parse-table .th,
	.wx-parse-table .td {
		border-collapse: collapse;
		box-sizing: border-box;
		border: 2upx solid #dadada;
		overflow: auto;
	}
	
	.wx-parse-table .audio,
	.wx-parse-table .uni-audio-default {
		display: block;
	}
	
</style>
