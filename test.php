<?php
include "../db/db_config_test.php";
define('ROOTPATH', dirname(__FILE__)."/uploads/optimized_product.csv");


$sql = "LOAD DATA LOCAL INFILE '".ROOTPATH."' INTO TABLE `product`"
. " FIELDS TERMINATED BY ','"
. " LINES TERMINATED BY '\r\n'"
. " IGNORE 1 LINES";

//Try to execute query (not stmt) and catch mysqli error from engine and php error
if (!($stmt = $mysqli->query($sql))) {
    echo "  \nQuery execute failed: ERRNO: (" . $mysqli->errno . ") " . $mysqli->error;
}


 echo $mysqli->error;



/*R::exec("LOAD 

    /*  $data              = R::dispense("product");
                                                                $data->name        = "01";
                                                                $data->item_number = "1";
                                                                $data->attribute   = "A";
                                                                $data->size        = "S";
                                                                $data->barcode     = "B";
                                                                $data->upc2        = "U";
                                                                $data->price       = "10.2";   
                                                                $data->catagory    = "Test";
                                                                R::store($data);
*/
                                                          

?>