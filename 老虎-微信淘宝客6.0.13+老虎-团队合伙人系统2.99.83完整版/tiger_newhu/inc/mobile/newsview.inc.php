<?php
			global $_W,$_GPC;
		$id=$_GPC['id'];
		  $view = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_news") . " WHERE id = :id" , array(':id' => $id));
		 
		include $this -> template('newsview');