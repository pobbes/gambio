
$(document).ready(function() {
    
    $(function(){
        $("#accordion").accordion({
            active: false,
            heightStyle: "content",
            autoHeight: false,
            collapsible: true
        });
    });
    
	$('ul#accordion a.heading').click(function() {
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
