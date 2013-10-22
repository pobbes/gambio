    
    <div class="upload-container shadow">

        <?php

        include('includes/preview.inc.php');

        include('includes/choose_slides.inc.php');
            
        ?>  
        
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                
                <legend>Dateiupload</legend>
                
                <label><span class="lable">Datei:</span>
                <input type="file" name="file" id="file" /></label>
                
                <br />
                
                <label><span class="lable">Name:</span>
                <input type="text" name="title" id="title" /></label>
                
                <br />
                
                <label><span class="lable">Position:</span>
                <input type="text" name="position" id="position" /></label>
                
                <br />
                
                <p>
                    <strong>Erlaubte Dateitypen:</strong>
                    <?php foreach($allowed_files AS $name){ echo "$name  "; } /* erlaubt Dateitypen auflisten */ ?> 
                    <br />
                    
                    <strong>Maximale Dateigroesse:</strong>
                    <?php echo upload_size("$maxsize", 2); /* Maximale Dateigroesse ausgeben */?>
                </p>
                
                <input type="submit" value="Datei Hochladen" name="submit" class="btn btn-blue" />
                            
            </fieldset>
        </form>
        
        <?php logout(); ?>
        
    </div>