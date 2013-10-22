    <div id="list">

        <div id="response"> </div>    
        
        <?php 

        $images = countImages();

        if($images == '0') {
            echo "<h2>Noch keine Bilder zum Anzeigen :(</h2>";
            echo "<h3>Bitte Bilder hochladen</h3>";
        }
        else {
            echo "<h2>Verf&uuml;gbare Bilder</h2>";
        }
    
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
            
            $id = $_GET["delete"];
            
            deleteImage($id);
        } 
           
        // if pressed submitSlides => save it to mysql
        if(isset($_POST['submitSlides'])){
                                    
            $amountOfSlides = $_POST["amountOfSlides"];
                    
            setSlides($amountOfSlides);
        }
        ?>
                
        <ul>
                
            <?php

            while($img_row = mysql_fetch_array($AllImages, MYSQL_ASSOC))
            {
                
                $img_id = stripslashes($img_row['id']);
                $img_title = stripslashes($img_row['title']);                             
                $img_path = stripslashes($img_row['path']);
                $img_position = stripslashes($img_row['position']);
                $img_is_active = stripslashes($img_row['is_active']);
                $img_link_to_offer = stripslashes($img_row['link_to_offer']);
                    
            ?>
                                    
            <li id="arrayorder_<?php echo $img_id ?>" class="preview_list">
                    
                <span class="preview_position"><?php echo $img_position ?></span>
                    
                <img src="<?php echo $img_path ?>" width="102" alt="<?php echo $img_title ?>" class="preview_image" />
                
                <span class="preview_title">Name: <?php echo $img_title ?></span>
                                
                <?php if(!empty($img_link_to_offer)) { ?>
                <span class="preview_link_to_offer">Url: <a class="preview_list_link_to_offer" href="<?php echo $img_link_to_offer ?>">zum Angebot</a></span>
                <?php } ?>   
                                    
                <div class="preview_form right">
                    
                    <form action="" method="get" enctype="form-data" class="right"> 

                        <?php if($img_is_active == '1') { ?> 
                        <div class="preview_input left">
                            <button id="deactivate_image" class="icon-check icon-large" type="submit" value="<?php echo $img_id ?>" name="deactivate" title="Bild deaktivieren"></button>
                        </div>
                                    
                        <?php }else { ?>
                        <div class="preview_input left">
                            <button id="activate_image" class="icon-check-empty icon-large" type="submit" value="<?php echo $img_id ?>" name="activate" title="Bild aktivieren"></button>
                        </div>
                                    
                        <?php } ?>     
                        <div class="preview_input right">
                            <button id="delete_image" class="icon-trash icon-large" type="submit" value="<?php echo $img_id ?>" name="delete" title="Bild l&ouml;schen"></button>
                        </div>   
                            
                    </form>    
                </div>
                                    
                <div class="clear"></div>
            
            </li>
                         
            <?php } ?> 
        </ul> 
        
    </div>