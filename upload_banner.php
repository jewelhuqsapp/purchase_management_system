<?php
include "login.check.php";
include "../db/db_config.php";
include "tpl/header.php";
$orderlist = R::getAll("SELECT *from banner limit 50");
include "tpl/upload_banner.php";

$action = REQUEST("action");
if($action  =="delete")
{
$filename=REQUEST("filename");
unlink($_SERVER['DOCUMENT_ROOT']."/asset/slider/$filename");
R::exec("delete from banner where file_url='$filename'");
print("<h1>Succesfully Deleted.</h1>");
}
else if ($action == "UploadFile")
{
                $rand          = rand(99999,777878787).".jpg";
                $target_dir    = $_SERVER['DOCUMENT_ROOT']."/asset/slider/";
                $target_file   = $target_dir . $rand;
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

                if ($uploadOk == 0)
                {
                                echo "Sorry, your file was not uploaded.";
                                // if everything is ok, try to upload file
                }
                else
                {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
                                {
$rb=R::dispense("banner");
$rb->file_url="$rand";
R::store($rb);
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
print("<hr/>");
?>?>