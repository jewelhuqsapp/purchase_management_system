<?php
set_time_limit(0);
include "login.check.php";
include "../db/db_config.php";
$action = REQUEST("action");
$title  = "Upload Product";
include "tpl/header.php";




/***Match dublicates**/

R::debug(true);

if ($action == "InsertCustomer")
{
       
     R::exec("Truncate table userinfo");                                                           
        echo "<br> Old data deleted...<br>";                                                   
                $data = file("uploads/customer.csv");
  echo "<br> Reading new data & Inserting.... <br>";                                                   
                $row  = 1;
                if (($handle = fopen("uploads/customer.csv", "r")) !== FALSE)
                {
                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                                {
                                                $num = count($data);
                                                $row++;
                                                if ($row == 2)
                                                {
                                                                for ($i = 0; $i <= $num; $i++)
                                                                {
                                                                                
                                                       
                         if ($data[$i] == "Company")
                                                                                {
                                                                                                $_SESSION['company_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Street")
                                                                                {
                                                                                                $_SESSION['street_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Street2")
                                                                                {
                                                                                                $_SESSION['street2_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "City")
                                                                                {
                                                                                                $_SESSION['city_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "State")
                                                                                {
                                                                                                $_SESSION['state_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "ZIP")
                                                                                {
                                                                                                $_SESSION['zip_val'] = $i;
                                                                                }
                                                                                if ($data[$i] == "Custom Field 1")
                                                                                {
                                                                                                $_SESSION['tobaco_licence_val'] = $i;
                                                                                }

                                                                               if ($data[$i] == "Custom Field 2")
                                                                                {
                                                                                                $_SESSION['tobaco_expire_val'] = $i;
                                                                                }

if ($data[$i] == "Custom Field 3")
                                                                                {
                                                                                                $_SESSION['resell_val'] = $i;
                                                                                }

if ($data[$i] == "Phone 1")
                                                                                {
                                                                                                $_SESSION['phone_val'] = $i;
                                                                                }

                                                                }
                                                }
                                                
                                                
                                                else
                                                {
                      
 
                                                                
                                                                
                                                                $company             = isset($data[$_SESSION['company_val']])?$data[$_SESSION['company_val']]:"";
                                                                $street              = isset($data[$_SESSION['street_val']])?$data[$_SESSION['street_val']]:"";
                                                                $street2             = isset($data[$_SESSION['street2_val']])?$data[$_SESSION['street2_val']]:"";
                                                                $city                = isset($data[$_SESSION['city_val']])?$data[$_SESSION['city_val']]:"";
                                                                $state               = isset($data[$_SESSION['state_val']])?$data[$_SESSION['state_val']]:"";
                                                                $zip                 = isset($data[$_SESSION['zip_val']])?$data[$_SESSION['zip_val']]:"";
                                                                $tobaco_licence_val  = isset($data[$_SESSION['tobaco_licence_val']])?$data[$_SESSION['tobaco_licence_val']]:"";
                                                                $tobaco_expire_date  = isset($data[$_SESSION['tobaco_expire_val']])?$data[$_SESSION['tobaco_expire_val']]:"";
                                                                $resell_val          = isset($data[$_SESSION['resell_val']])?$data[$_SESSION['resell_val']]:"";
                                                                $phone_val           = isset($data[$_SESSION['phone_val']])?$data[$_SESSION['phone_val']]:"";

                                                               $phone_val            = preg_replace('/[^0-9.]+/', '', $phone_val);
                                                               if($phone_val == "" ){$phone_val = "#".rand(444444,88877777); }
                                                                
                                                                $data                     = R::dispense("userinfo");
                                                                $data->store_name         = trim($company);
                                                                $data->store_address      = trim($street.$street2);
                                                                $data->store_city         = trim($city);
                                                                $data->store_state        = trim($state);
                                                                $data->store_zip          = trim($zip);
                                                                $data->tobaco_permit      = $tobaco_licence_val;
                                                                $data->tobaco_expire_date = $tobaco_expire_date;
                                                                $data->resell_no          = $resell_val;
                                                                $data->store_phone        = $phone_val;
                                                                $data->username           = $phone_val;
                                                                $data->password           = md5($phone_val);

                                                                $id                  = R::store($data);
                                                                
                                                                
                                                }
                                                
                                }
                                
                               
                }

 ?>
  <div class="alert alert-success">
    <strong>Success!</strong> Succesfully Customer Updated....
  </div>

<?php                             



/***Match dublicates**/
$result=R::getAll("SELECT id,username FROM userinfo WHERE username IN ( SELECT username FROM userinfo GROUP BY username HAVING ( COUNT(username) > 1 ) ) ORDER BY `userinfo`.`username` DESC");

 $count =count($result);
for($i=0;$i<$count;$i++)
{
  if($result[$i]['username'] == $result[$i+1]['username'] )
    {
    R::exec("UPDATE userinfo SET username = '".$result[$i]['username']."1' WHERE id ='".$result[$i+1]['id']."'");
    }
  
}    


$result=R::getAll("SELECT id,username FROM userinfo WHERE username IN ( SELECT username FROM userinfo GROUP BY username HAVING ( COUNT(username) > 1 ) ) ORDER BY `userinfo`.`username` DESC");

 $count =count($result);
for($i=0;$i<$count;$i++)
{
  if($result[$i]['username'] == $result[$i+1]['username'] )
    {
    R::exec("UPDATE userinfo SET username = '".$result[$i]['username']."2' WHERE id ='".$result[$i+1]['id']."'");
    }
  
}    

    
    ?>
  <div class="alert alert-success">
    <strong>Success!</strong> Succesfully Data Validated tooo.
  </div>

<?php                             

    


}
else if ($action == "UploadFile")
{
                
                $target_dir    = "uploads/";
                $target_file   = $target_dir . "customer.csv";
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
print("<hr/>");
include "tpl/upload_customer.php";
?>