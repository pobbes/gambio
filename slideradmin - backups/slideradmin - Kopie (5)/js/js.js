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
    
    $(function() {
        $( document ).tooltip({
            relative:true,
            position: {
                my: "center bottom-20",
                at: "center top",
                using: function( position, feedback ) {
                    $( this ).css( position );
                    $( "<div>" )
                    .addClass( "arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
                }
            }
        });
    });
    
    $(function() {
        $( "#accordion" ).accordion({
            collapsible: true,
            active: false
        });
    });

    $('#accordion').click(function() {
        $(this).css('outline','none');
        if($(this).parent().hasClass('current')) {
            $(this).siblings('ul').slideUp('slow',function() {
                $(this).parent().removeClass('current');
                $.scrollTo('#accordion',1000);
            });
        } else {
            $('ul#accordion li.current ul').slideUp('slow',function () {
                $(this).parent().removeClass('current');
            });
            $(this).siblings('ul').slideToggle('slow',function () {
                $(this).parent().toggleClass('current');
            });
            $.scrollTo('#accordion',1000);
        }
        return false;
    });
});	