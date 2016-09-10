<?php
set_time_limit(0);
include "login.check.php";
include "../db/db_config.php";
$action = REQUEST("action");
$title  = "Upload Product";
include "tpl/header.php";

if ($action == "UploadProduct")
{
        
     R::exec("Truncate table product");                                                           
                                                        
                $data = file("uploads/product.csv");
                $row  = 1;
                if (($handle = fopen("uploads/product.csv", "r")) !== FALSE)
                {
                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                                {
                                                $num = count($data);
                                                $row++;
                                                if ($row == 2)
                                                {
                                                                for ($i = 0; $i <= $num; $i++)
                                                                {
                                                                                
                                                                                
                                                                                if ($data[$i] == "Item Number")
                                                                                {
                                                                                                $_SESSION['item_number_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Item Description")
                                                                                {
                                                                                                $_SESSION['product_name_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Attribute")
                                                                                {
                                                                                                $_SESSION['attribute_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Size")
                                                                                {
                                                                                                $_SESSION['size_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "UPC")
                                                                                {
                                                                                                $_SESSION['barcode_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Custom Field 5")
                                                                                {
                                                                                                $_SESSION['upc2_field_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Department Name")
                                                                                {
                                                                                                $_SESSION['catagory_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Regular Price")
                                                                                {
                                                                                                $_SESSION['price_val'] = $i;
                                                                                }


                                                                }
                                                }
                                                
                                                
                                                else
                                                {
                                                                
                                                                
                                                                
                                                                $item_number  = isset($data[$_SESSION['item_number_val']])?$data[$_SESSION['item_number_val']]:"";
                                                                $product_name = isset($data[$_SESSION['product_name_val']])?$data[$_SESSION['product_name_val']]:"";
                                                                $attribute    = isset($data[$_SESSION['attribute_val']])?$data[$_SESSION['attribute_val']]:"";
                                                                $size         = isset($data[$_SESSION['size_val']])?$data[$_SESSION['size_val']]:"";
                                                                $barcode      = isset($data[$_SESSION['barcode_val']])?$data[$_SESSION['barcode_val']]:"";
                                                                $upc2         = isset($data[$_SESSION['upc2_field_val']])?$data[$_SESSION['upc2_field_val']]:"";
                                                                $catagory     = isset($data[$_SESSION['catagory_val']])?$data[$_SESSION['catagory_val']]:"";
                                                                $price_val     = isset($data[$_SESSION['price_val']])?$data[$_SESSION['price_val']]:"";
                                                                
                               R::debug(true);                                 
                                                                $data              = R::dispense("product");
                                                                $data->name        = $product_name;
                                                                $data->item_number = $item_number;
                                                                $data->attribute   = $attribute;
                                                                $data->size        = $size;
                                                                $data->barcode     = $barcode;
                                                                $data->upc2        = $upc2;
                                                                $data->price       = $price_val;   
                                                                $data->catagory    = $catagory;
                                                                $id                = R::store($data);
                                                                
                                                                
                                                }
                                                
                                }
                                
                                echo $num;
                }
}
else if ($action == "UploadFile")
{
                
                $target_dir    = "uploads/";
                $target_file   = $target_dir . "product.csv";
                $uploadOk      = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image
                if (isset($_POST["submit"]))
                {
                                $check = ($_FILES["fileToUpload"]["tmp_name"]);
                                if ($check !== false)
                                {
                                                
                                                $uploadOk = 1;
                                }
                                else
                                {
                                                echo "File is not an image.";
                                                $uploadOk = 0;
                                }
                }
                // Check if file already exists
                if (file_exists($target_file))
                {
                                unlink($target_file);
                                echo "Sorry, file already exists.We are deleting try again";
                                $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000000)
                {
                                echo "Sorry, your file is too large.";
                                $uploadOk = 0;
                }
                // Allow certain file formats
                if ($imageFileType != "csv")
                {
                                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0)
                {
                                echo "Sorry, your file was not uploaded.";
                                // if everything is ok, try to upload file
                }
                else
                {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
                                {
?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> Successfully uploaded.
</div>
      <?php
                                }
                                else
                                {
                                                echo "Sorry, there was an error uploading your file.";
                                }
                                
                                
                }
                
}

include "tpl/upload_product.php";
?>