<?php
      require_once("includes/thumb.php");
      //save the uploaded file
      if(isset($_POST["save_map"])){
        $allowedExts = array("jpg","jpeg","gif","png");
        $extension = end(explode(".",$_FILES["map_file"]["name"]));
        if ((($_FILES["map_file"]["type"] == "image/gif")
        || ($_FILES["map_file"]["type"] == "image/jpeg")
        || ($_FILES["map_file"]["type"] == "image/png")
        || ($_FILES["map_file"]["type"] == "image/pjpeg")
        )&& in_array($extension, $allowedExts)){
            if($FILES["fils"]["error"]>0){
              echo "Return Code: ". $_FILES["map_file"]["error"]."<br />";
            }
            else{
              echo "Upload: ".$_FILES["map_file"]["name"] . "<br />";
              echo "Type:" . $_FILES["map_file"]["type"] . "<br />";
              echo "Size:" . ($_FILES["map_file"]["size"]/1024). "Kb<br />";
              echo "Temp file:" . $_FILES["map_file"]["name"] . "<br />";

              if(file_exists("uploads/" . $_FILES["map_file"]["name"])){
                echo $_FILES["map_file"]["name"] . " already exists. ";
              }
              else{
                $src = "uploads/" . $_FILES["map_file"]["name"];
                if(move_uploaded_file($_FILES["map_file"]["tmp_name"],$src)){
                  echo "Stored in: " . "/home/siqi/public_html/lnm/uploads/". $_FILES["map_file"]["name"]."<br />";
                  //After the file is successfully stored,create a thumbnail to replace the original file
                  make_thumb($src, $src,885);
                  //add this map to the database
                  //get the image
                  $img= imagecreatefromjpeg($src);
                  $width = imagesx($img);
                  $height = imagesy($img);
                  //get map name 
                  if(isset($_POST["name"]) && !empty($_POST["name"])) {
                    $name=$_POST["name"];  
                    $query = "INSERT INTO lnm.map(name,width,height,path) values('$name',$width,$height,'$src');";
                    pg_query($query)
                      or die('Query failed: ' . pg_last_error());
                  }
                  else{
                    echo "fail to add this map, because the map name is not given.";
                  }
                }
                else{
                  echo "failed to store";
                  echo $_FILES["map_file"]["error"];
                }
              }
            }
          }
        else{
          echo "Invalid File";  
        }
      } 

			if(isset($_GET["edit"])){ //If user wants to edit a device
				$page_title='Edit Map';
			}
			else{
				$page_title='Upload Map File';
			}
?>
