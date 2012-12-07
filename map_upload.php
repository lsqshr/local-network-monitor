<?php
$title = 'Upload Map :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
$page_title='Upload Map File';
?>

<div class="info">
  <article class="hero clearfix">
    <?php require_once("includes/sidebar.php");/*get side bar*/?>
    <div class="col_66">
        <form action="" method="post" class="form" enctype="multipart/form-data">
		
            <h2><?php echo $page_title ?></h2>
            <p>Edit the map name and upload the map jpg file, then click Save.</p>
            <p class="col_100">
            <label for="name">Map Name:</label><br/>
                <input type="text" name="name" id="name"  
        <?php 
					if($page_title=='Edit Map'){
						echo "value=\"$name\"";
					}
					else{
					}
				?>                 
             />
            </p>
            <!--upload the jpg file-->
            <p>
              <input type="file" name="map_file" id="map_file"/>
            </p>            
            <p>
            <button type="submit" class="button" name="save_map" id="save_map" value="save_map">Save</button>
            </p>
        </form>
    </div>
  </article>
</div>



<?php

require_once('includes/footer.php');

?>
