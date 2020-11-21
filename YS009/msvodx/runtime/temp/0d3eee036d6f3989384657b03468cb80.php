<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:30:"./tpl/peixun/poster/index.html";i:1519635190;}*/ ?>

<?php if(empty($advertisement_info)): ?>
document.write("<img src='/tpl/peixun/static/images/img/1.jpg'>");
<?php endif; if($advertisement_info['type'] == 2): ?>
document.write("<div class='advert' style=' height:<?php echo $position['height']; ?>px;'>"
    +"<a href='<?php echo $advertisement_info['url']; ?>' <?php echo $advertisement_info['target']; ?> >"
+"<img style='width: 100%; height:<?php echo $position['height']; ?>px;' src='<?php echo $advertisement_info['content']; ?>'>"
+"</a></div>");
<?php endif; if($advertisement_info['type'] == 1): ?>
document.write("<?php echo $advertisement_info['content']; ?>");
<?php endif; ?>
