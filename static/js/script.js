jQuery.noConflict();
(function($) {
 $(function() {
	
	$('a#add-project').click(function(event){
		event.preventDefault();
		$('form#add-form').show();
	});
		
	$('a.show-path').click(function(event){
		event.preventDefault();
		if($(this).text() == 'Show Path') {
			$('#grid').addClass('path');
			$(this).parents('.project').addClass('subject');
			$(this).text('Hide Path');
			$.getJSON('http://'+window.location.host+'/innovation-projects/ip/get_path/'+$(this).data('project-id'),function(data){
				$.each(data, function(index, marker){
					if(index == 0) {
						$('#project-'+marker.id).append('<div class="path"><h3>'+marker.note+'</h3><h4>'+marker.time+'</h4></div>');
					}
					else {
						$('#grid').append('<div class="path" style="left: '+marker.x+'%;top: '+marker.y+'%"><span class="marker"></span><h3>'+marker.note+'</h3><h4>'+marker.time+'</h4></div>');
					}
				});
			});
		}
		else {
			$('#grid').removeClass('path');
			$(this).parents('.project').removeClass('subject');
			$(this).text('Show Path');
			$('.path').detach();
		}
	});
	
if(draggableProjects) {
	$('a#approve-project').click(function(event){
		event.preventDefault();
		$.get($(this).attr('href'));
		$(this).parents('.project').removeClass('status-p').addClass('status-i');
		$(this).remove();
	});


	$('.project form.note button[type="reset"]').click(function(event){
		event.preventDefault();
		$('form.note.shown').hide();
	});

	
	$('.project form.note').submit(function(event){
		event.preventDefault();
		$.post('http://'+window.location.host+'/innovation-projects/ip/add_move_note/', $(this).serialize());
		$(this).hide();
	});
	

	$('.project').draggable({
		handle: 'span.marker',
		stop: function(event, ui) {
			x = ((ui.position.left/$('#grid').width())*100).toFixed(1);
			y = ((ui.position.top/$('#grid').height())*100).toFixed(1);
			$.get('http://'+window.location.host+'/innovation-projects/ip/move_project/'+ui.helper.data('project-id')+'/'+x+'/'+y,function(data){
				var thisNote = $(ui.helper).children('.note');
				$(thisNote).show().addClass('shown');
				$(thisNote).append('<input type="hidden" name="x" value="'+x+'"><input type="hidden" name="y" value="'+y+'">');
			});	
		}
	});
}


});	
})(jQuery);

