function copyit(){
			require(['jquery.zclip'], function(){
				$('.copyurl').zclip({
					path: './resource/components/zclip/ZeroClipboard.swf',
					copy: function(){                       
						return $(this).attr('data-url');
					},
					afterCopy: function(){
						$('.copyurl').off();
						alert('复制成功');
					}
				});
			});				
		}