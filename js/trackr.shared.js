
var trackr = {
	timeify: function(h, m) {
		if (m == undefined || m == 0) m = '00';
		else if (m <= 15) m = 15;
		else if (m <= 30) m = 30;
		else if (m <= 45) m = 45;
		else { h += 1; m = 00; }
		
		return parseInt(h) + ':' + m;
	},
	
	humanizeDate: function(date) {
		date = date.split('-');
		var y = date[0],
			m = date[1],
			d = date[2];
		
		return $.fn.calendarLite.defaults.months[m-1].substr(0,3) + ' ' + d.replace(/^0/, '') + (new Date().getFullYear() != y ? ', '+y : '');
	},
	
	formatDuration: function(duration) {
		if (duration.trim() == '') {
			return 0;
		// find .5 or 1.25
		} else if (/^[0-9]*[.,][0-9]*$/.test(duration)) {
			var hours = Math.floor(duration);
			var minutes = 60 * (duration - hours);
			return trackr.timeify(hours, minutes);
		// find 1:30
		} else if (/^[0-9]*[:][0-9]*$/.test(duration)) {
			var arr = duration.split(':');
			return trackr.timeify(arr[0], arr[1]);
		// find 2
		} else if (/^[0-9]*$/.test(duration)) {
			return trackr.timeify(duration);
		}
		return 0;
	},
	
	drawPieChart: function(holder, remaining, logged) {
		var percent = logged / (remaining + logged);
		var data = [{v:remaining, c:'#eee'}, {v:logged, c:'#09c'}];

		if (percent < .25) data[1].c = '#09c';
		else if (percent < .5) data[1].c = '#094';
		else if (percent < .75) data[1].c = '#f90';
		else data[1].c = '#c33';
		
		Raphael(holder, 28, 28).pieChart(28, 28, data);
	}
}
