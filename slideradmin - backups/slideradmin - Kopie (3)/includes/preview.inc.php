    <div id="list">

        <div id="response"> </div>
    
        <ul>
            <?php 
    
            $AllImages = getAllImages();
    
            while($img_row = mysql_fetch_array($AllImages, MYSQL_ASSOC))
            {
    
                $img_id = stripslashes($img_row['id']);
                $img_title = stripslashes($img_row['title']);                             
                $img_path = stripslashes($img_row['path']);
                $img_position = stripslashes($img_row['position']);
                    
            ?>
                                    
            <li id="arrayorder_<?php echo $img_id ?>" class="preview_list">
                    
                <span class="preview_position"><?php echo $img_position ?></span>
                    
                <img src="<?php echo $img_path ?>" width="100" alt="<?php echo $img_title ?>" class="preview_image" />
                
                <span class="preview_title">Name: <?php echo $img_title ?></span>
                    
                <i class="icon-edit"></i>
                    
                <div class="clear"></div>
            </li>
                         
            <?php } ?> 
        </ul> 
        
    </div>