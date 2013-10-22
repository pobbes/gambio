        
        <?php

        include('includes/preview.inc.php');    
            //Bild Hinzuf&uuml;gen
        ?>  
        
        <div id="accordion">
            <div title="Bild Hinzuf&uuml;gen">+</div>
            <div>
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                        
                        <legend>Upload</legend>
                        
                        <label><span class="lable">Bild:</span>
                        <input type="file" name="file" id="file" title="Bild zum Hochladen ausw&auml;hlen" /></label>
                        
                        <br />
                        
                        <label><span class="lable">Name:</span>
                        <input type="text" name="title" id="title" title="Bildnamen eingeben" /></label>
                        
                        <br />
                        
                        <label><span class="lable">Url:</span>
                        <input type="text" name="link_to_offer" id="link_to_offer" title="Url zum Angebot hinzuf&uuml;gen (Optional)" /></label>
                        
                        <br />
                        
                        <p>
                            <span class="important">
                                <strong>Erforderliche Aufl&ouml;sung:</strong>
                                530 x 240 Pixel
                                <br />
                            </span>
                            
                            <strong>Erlaubte Dateitypen:</strong>
                            <?php foreach($allowed_files AS $name){ echo "$name  "; } /* erlaubt Dateitypen auflisten */ ?> 
                            <br />
                            
                            <strong>Maximale Dateigr&ouml;sse:</strong>
                            <?php echo upload_size("$maxsize", 2); /* Maximale Dateigroesse ausgeben */?>
                        </p>
                        
                        <input type="submit" value="Bild Hochladen" name="submit" class="btn btn-blue normal" />
                                    
                    </fieldset>
                </form>
            </div>            

            <?php
            include('includes/choose_slides.inc.php');   
            ?>
            
        </div>        

        <?php logout(); ?>
        
    </div>