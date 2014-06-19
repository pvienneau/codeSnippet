$(document).ready(function () {
	
	var currentTime = 0;
	var currentProject = $('#projects li.current');
	var status = 'stop';
	var timerInterval;
	
	function startTimer()
	{
		currentTime = currentProject.find('b').text();
		currentTime = (currentTime == '') ? 0: parseFloat(currentTime.replace('h', '')) * 3600;
		
		timerInterval = setInterval(updateTime, 1000);
	}
	
	function stopTimer() {
		clearInterval(timerInterval);
	}
	
	function updateTime() {
		currentTime++; // number of secondes
		
		var hours = Math.floor(currentTime/3600);
		var minutes = Math.floor(currentTime/60)-(hours*60);
		var seconds = currentTime-(hours*3600)-(minutes*60);
		var out = '';
		
		if (hours >= 1)
			out += hours + 'h';// + (hours > 1 ? 's':'');
		if (minutes >= 1)
			out += ' ' + minutes + (hours == 0 ? 'min':'m');
		if (seconds >= 1)
			out += ' ' + seconds +  (minutes == 0 ? 'sec':'s');
		
		$('#time').text(out);
	}
	
	$('#projects img.play').click(function()
	{
		var li = $(this).parent();
		var project = li.attr('id').replace('project-', '');
		
		currentProject.removeClass('current');
		
		if (status == 'play') {
			currentProject.find('img.play').show();
			currentProject.find('img.pause').hide();
			
			currentProject.removeClass('current');
			
			$.get('time/timer_pause/'+currentProject.attr('id').replace('project-', ''));
			
			stopTimer();
		}
		
		li.find('img.pause, img.check').show();
		$(this).hide();
		
		// move position
		//li.parent().prepend( li.remove() );
		li.addClass('current');
		
		currentProject = li;
		status = 'play';
		
		startTimer();
		
		$.get('time/timer_play/'+project);
		
		$('#log-box').slideUp();
	});
	
	$('#projects img.pause').click(function()
	{
		var li = $(this).hide().parent();
		var project = li.attr('id').replace('project-', '');
		
		li.find('img.play').show();
		
		stopTimer();
		status = 'stop';
		
		$.get('time/timer_pause/'+project, function(data) { li.find('b').text(data); });
		
		$('#log-box').slideUp();
	});
	
	$('#projects img.check').click(function()
	{
		var li = $(this).parent();
		var project = li.attr('id').replace('project-', '');
		
		if (status != 'stop') {
			currentProject.find('.play').show();
			currentProject.find('.pause').hide();
			
			currentProject.removeClass('current');
			
			$.get('time/timer_pause/'+currentProject.attr('id').replace('project-', ''));
			
			stopTimer();
		}
		
		li.find('.pause').hide();
		li.find('.play').show();
		
		$('#log-box h3').text(li.find('span').text());
		$('#timer-project').val(project);
		$('#timer-duration').val(trackr.formatDuration(li.find('b').text().replace('h','')));
		$('#log-box a.discard').attr('href', 'time/timer_discard/' + project);
		
		$('#log-box').slideDown();
	});
	
	$('#log-box a.cancel').click(function()
	{
		$('#log-box').slideUp();
	});
	
	// check if there is a current open timer
	if (currentProject.length)
		startTimer();
});