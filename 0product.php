<?php
include "login.check.php";
include "db/db_config.php";
include "tpl/header.php";

?>
<p align=center>
<a href="?action=create" class="btn btn-info" role="button">Add Product</a>
</p>
<?php
echo "<iframe src='products.php' style='position:fixed; left:10px;  right:10px; width:100%; height:500px; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;'></iframe> ";
?>
