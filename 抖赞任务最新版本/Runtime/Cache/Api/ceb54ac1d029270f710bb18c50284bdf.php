<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>在线支付</title>
</head>
<body>

<form style='display:none;' id='formpay' name='formpay' method='post' action='<?php echo ($post_url); ?>'>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input name='<?php echo ($key); ?>' id='<?php echo ($key); ?>' type='text' value='<?php echo ($vo); ?>' /><?php endforeach; endif; else: echo "" ;endif; ?>
    <input type='submit' id='submitdemo1'>
</form>

<!-- Jquery files -->
<script type="text/javascript" src="/tpl/Public/js/jquery.min.js"></script>
<script type="application/javascript">
    $('#formpay').submit();
</script>


</body>
</html>