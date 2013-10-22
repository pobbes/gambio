    <div id="list">

        <div id="response"> </div>
    
        <ul>
            <?php 
    
            $AllImages = getAllImages();

            if(isset($_GET["deactivate"])) {
                
                $id = $_GET["deactivate"];
                
                deactivateImage($id);
            }

            if(isset($_GET["activate"])) {
                
                $id = $_GET["activate"];
                
                activateImage($id);
            }

            if(isset($_GET["delete"])) {
                
                $id = $_GET["activate"];
                
                deleteImage($id);
            }   

            while($img_row = mysql_fetch_array($AllImages, MYSQL_ASSOC))
            {
    
                $img_id = stripslashes($img_row['id']);
                $img_title = stripslashes($img_row['title']);                             
                $img_path = stripslashes($img_row['path']);
                $img_position = stripslashes($img_row['position']);
                    
            ?>
                                    
            <li id="arrayorder_<?php echo $img_id ?>" class="preview_list">
                    
                <span class="preview_position"><?php echo $img_position ?></span>
                    
                <img src="<?php echo $img_path ?>" width="102" alt="<?php echo $img_title ?>" class="preview_image" />
                
                <span class="preview_title">Name: <?php echo $img_title ?></span>
                                    
                <form action="" method="get" enctype="form-data" class="right">
                    <button id="deactivate_image" class="icon-check-empty icon-large" type="submit" value="<?php echo $img_id ?>" name="deactivate" >
                    </button>
                    
                    <button id="activate_image"   class="icon-check icon-large"       type="submit" value="<?php echo $img_id ?>" name="activate"   >
                    </button>
                    
                    <button id="delete_image"     class="icon-trash icon-large"       type="submit" value="<?php echo $img_id ?>" name="delete"     >
                    </button>
                </form>
                                    
                <div class="clear"></div>
            
            </li>
                         
            <?php } ?> 
        </ul> 
        
    </div>