//script
document.writeln("<div class=\'shu\'>");
document.writeln("	<img src=\'dgimages/baipishu.png\' width=\'240\' alt=\'\'>");
document.writeln("	<span class=\'close\'><i class=\'iconfont icon-guanbi1\'></i></span>");
document.writeln("</div>");
document.writeln("<style>");
document.writeln("	.shu{ position:fixed; right:120px; bottom:-450px; z-index: 99; box-shadow: 1px 5px 40px 5px rgba(253, 208, 0,.6)}");
document.writeln("	.shu img{ display: block;}");
document.writeln("</style>");
document.writeln("<script>");
document.writeln("	$(function(){");
document.writeln("		$(\'.shu\').delay(\'300\').animate({bottom:\'0\'},600)");
document.writeln("		$(\'.shu .close\').click(function(){");
document.writeln("			$(this).parent(\'.shu\').animate({bottom:\'-450px\'},600);");
document.writeln("		})");
document.writeln("	})");
document.writeln("</script>");