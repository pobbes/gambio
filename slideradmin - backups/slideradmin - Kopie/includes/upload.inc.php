    
    <div class="upload-container shadow">

        <?php include ('includes/preview.inc.php');

        $slides = getSlides();

        ?>
    
        <ul>
        
        <?php 
    
            $slides = getSlides();
    
            while($slides_row = mysql_fetch_array($slides, MYSQL_ASSOC))
            {
    
                $slides_id = stripslashes($slides_row['id']);
                $slides_slides = stripslashes($slides_row['slides']);
                $slides_active = stripslashes($slides_row['is_active']);

                    
            ?>
                                    
            <li>     
                    
                <span>ID: <?php echo $slides_id ?></span> 
                <span>Slides: <?php echo $slides_slides ?></span> 
                <span>Active: <?php echo $slides_active ?></span> 
                    
            </li>
                         
            <?php } ?> 
        
        </ul>
        
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                
                <legend>Dateiupload</legend>
                
                <label>Datei: 
                <input type="file" name="file" id="file" /></label>
                
                <label>Name: 
                <input type="text" name="title" id="title" /></label>
                
                <label>Position: 
                <input type="text" name="position" id="position" /></label>
                
                <label>is_active: 
                <input type="text" name="is_active" id="is_active" /></label>
                
                <p>
                    <strong>Erlaubte Dateitypen:</strong>
                    <?php foreach($allowed_files AS $name){ echo "$name  "; } /* erlaubt Dateitypen auflisten */ ?> 
                    <br />
                    
                    <strong>Maximale Dateigroesse:</strong>
                    <?php echo upload_size("$maxsize", 2); /* Maximale Dateigroesse ausgeben */?>
                </p>
                
                <input type="submit" value="Datei Hochladen" name="submit" class="btn btn-primary" />
                            
            </fieldset>
        </form>
        
        <?php logout(); ?>
        
    </div>