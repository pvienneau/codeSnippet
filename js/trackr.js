$(document).ready(function () {

	$('#entry-duration, #entry-editor input.hours').blur(function() {
		var duration = trackr.formatDuration(this.value.trim());
		
		this.value = duration == 0 ? this.title: duration;
	});
	
	$('#entry-project, #timer-project, #report-project, #entry-editor input.project').autoComplete({ajax: '?u=project/matching'});
	
	// quick entry form submit validate
	$('#form-quick-entry').submit(function(e) {
		if ($('#entry-duration').val() == 'HOURS') {
			e.preventDefault();
			$('#entry-duration').val('').focus();
		}
		
		if ($('#entry-project').val() == 'CLIENT OR PROJECT') {
			e.preventDefault();
			$('#entry-project').val('').focus();
		}
		
		if ($('#entry-description').val() == 'TAGS OR DESCRIPTION')
			$('#entry-description').val('not defined yet!');
	});
	
	$.getJSON('?u=tag/all', function(data) {
		$("#entry-description, #report-tags, #entry-editor input.description").asuggest(data, {
			'minChunkSize': 0,
			'delimiters': ',',
			'autoComplete': true,
			'cycleOnTab': true
		}); 
	});
	
	// report form submit validate
	$('#form-report').submit(function(e) {
		if ($('#report-tags').val() == 'TAGS')
			$('#report-tags').val('');
		
		if ($('#report-project').val() == 'CLIENT OR PROJECT')
			$('#report-project').val('');
	});
	
	// generating the pie for project
	$('span.pie').each(function() {
		var data = $(this).text().split('/');
		$(this).text('');
		trackr.drawPieChart($(this).attr('id'), parseFloat(data[0]), parseFloat(data[1]));
	});
	
	// do the default input value 
	$('input[title]').each(function(){
		$(this).DefaultValue($(this).attr('title'));
	});
	
	// prevent a click not wanted on a delete link ;)
	$('td.actions a.delete').click(function(e) {
		if (!confirm('Are you sure you want to delete it?'))
			e.preventDefault();
	});
	
	$('td.actions a.edit').click(function(e) {
		e.preventDefault();

		var tr = $(this).closest('tr');
		//var pos = tr.position();
				
		$.getJSON($(this).attr('href').replace('/edit/', '/get/'),
			function(data) {
				var editor = $('#entry-editor');
				var desc = '';
				
				for (var i in data.tags)
					desc += data.tags[i].name + ', ';
				
				editor.attr('action', 'time/edit/'+data.id);
				
				editor.find('.cal .label').text(trackr.humanizeDate(data.created_on));
				editor.find('input[name="entry[created_on]"]').val(data.created_on);
				
				editor.find('select').val(data.user_id);
				editor.find('.hours').val(trackr.formatDuration(data.duration));
				editor.find('.project').val(data.project);
				editor.find('.description').val(desc + data.description);
				
				tr.siblings('tr').removeClass('hide');
				tr.addClass('hide');
				
				if ($('tr.for-editor').empty()) {
					var trEditor = tr.before('<tr class="for-editor"><td colspan="'+tr.children('td').length+'"></td></tr>');
					editor.appendTo($('tr.for-editor td')).removeClass('hide');
				} else {
					var trEditor = $('tr.for-editor');
					trEditor.insertBefore(tr);
				}
				
				//editor.width(tr.width()-20).css({position:'absolute', top:pos.top+tr.height(), left:pos.left}).removeClass('hide');
				
			}
		);
	});
});
