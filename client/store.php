<?php
include "login.check.php";
include "../db/db_config.php";
$action    = REQUEST('action');
$order_id  = REQUEST('order_id');
$title     = "PO List";

	include "tpl/header.php";
	$vendors = R::getAll("SELECT *from store");
	include "tpl/store.php";
	include "tpl/footer.php";


