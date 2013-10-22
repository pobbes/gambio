$(document).ready(function(){ 	
    function slideout(){
        setTimeout(function(){
            $("#response").slideUp("fast", function () {
                  
            });
    
        }, 2000);}
	
    $("#response").hide();
    
	$(function() {
		$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("updateListorder.inc.php", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
                
                // Page reload 3sec delay
                setInterval("location.reload()", 3000);
			}); 	
            
		}});
        
	});        
    
});	