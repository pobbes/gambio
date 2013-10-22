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
                
                // goto index.php 3sec delay
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);
			}); 	
            
		}});
        
	});        
    
});	