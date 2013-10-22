        <?php    
        // if pressed submitSlides => save it to mysql
        if(isset($_POST['submitSlides'])){
                                    
            $amountOfSlides = $_POST["amountOfSlides"];
                    
            setSlides($amountOfSlides);
        }
        ?>

        <p>Wieviele Bilder sollen im Slider auf sh-webshop angezeigt werden?</p>
        
        <form action="" method="post" enctype="multipart/form-data">
            <select name="amountOfSlides" id="amountOfSlides">
                
                <?php 
        
                $slides = getSlides();
        
                // display the list of possible numbers of slides
                while($slides_row = mysql_fetch_array($slides, MYSQL_ASSOC))
                {    
                    $slides_id      =   stripslashes($slides_row['id']);
                    $slides_slides  =   stripslashes($slides_row['slides']);
                    $slides_active  =   stripslashes($slides_row['is_active']);                    
                ?>                                  
                
                <option value="<?php echo $slides_id ?>" <?php if($slides_active == "1") { echo "selected"; } ?>>
                    <span>Slides: <?php echo $slides_slides ?></span> 
                </option>                    
                             
                <?php } ?> 
            </select>
            
            <input type="submit" name="submitSlides" id="submitSlides" value="Best&auml;tigen"class="btn btn-green small">  
             
        </form>