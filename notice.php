<?php
include "login.check.php";
include "../db/db_config.php";

$row      = R::getRow("SELECT *From notice where customer_type='all'");
$notice   = $row['description'];

include "tpl/header.php";
include "tpl/notice.php";