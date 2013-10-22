<?php
/* --------------------------------------------------------------
   function.show_slides.php 2013-06-18
   Benedikt Benz
   Copyright (c) 2013
   --------------------------------------------------------------
*/
?><?php
function smarty_function_show_slides()
{
	$final_slides = mysql_query("SELECT id, title, path, link_to_offer FROM sliderimages WHERE is_active = '1' ORDER BY position ASC ");
	
    // number of slides where is_active=1
	$num_rows = mysql_num_rows($final_slides);
    
    // get how much slides should be shown in slider
    $slides_to_show = mysql_query("SELECT slides FROM slideradmin WHERE is_active = '1' ");
    
    // initialize counter
    $counter = "0";
    
    $row = mysql_fetch_array($slides_to_show);
	
	$rows = array();
	
	if($num_rows > "0") {
	
		while($final_slides_row = mysql_fetch_assoc($final_slides, MYSQL_ASSOC))
		{
            // stop when number of slides to show is reached
            if ($counter == $row["slides"]) {
                break;
            }    
			
			$rows[] = $final_slides_row;			
            
            $counter++;            			
		}
		
		foreach($rows as $row) 
		{
			$final_slides_id    =   stripslashes($row['id']);
			$final_slides_title =   stripslashes($row['title']);                             
			$final_slides_path  =   stripslashes($row['path']);		
			
			echo "<img src=\"slideradmin/$final_slides_path\" alt=\"$final_slides_title\" width=\"530\" height=\"240\" data-text-id=\"#$final_slides_id\" /> \n";
			
		}
		
		foreach($rows as $row) 
		{
			$final_slides_id    		 =   stripslashes($row['id']);
			$final_slides_title 		 =   stripslashes($row['title']);                             
			$final_slides_link_to_offer  =   stripslashes($row['link_to_offer']);		

			if(!empty($final_slides_link_to_offer))
			{
			?>
			
			<div id="<?php echo $final_slides_id; ?>" class="bannerRotator_texts">    
		
				<div class="bannerRotator_text_line banner_button" data-initial-left="350" data-initial-top="180" data-final-left="350" data-final-top="180" data-duration="0.5" data-fade-start="0" data-delay="0">
					<a href="http://<?php echo $final_slides_link_to_offer; ?>" target="_blank">zum Angebot</a>
				</div>         
			
			</div>  
				
			<?php
			}
		}
		

		
	}
	else {
		?>
		<br />
		<span>Keine Bilder zum Anzeigen verfügbar !</span>

	<?php
	}
}
?>