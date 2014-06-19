Raphael.fn.drawGrid = function (x, y, w, h, wv, hv, color) {
    color = color || "#000";
    var path = ["M", x, y, "L", x + w, y, x + w, y + h, x, y + h, x, y],
        rowHeight = h / hv,
        columnWidth = w / wv;
    for (var i = 1; i < hv; i++) {
        path = path.concat(["M", x, y + i * rowHeight, "L", x + w, y + i * rowHeight]);
    }
    for (var i = 1; i < wv; i++) {
        path = path.concat(["M", x + i * columnWidth, y, "L", x + i * columnWidth, y + h]);
    }
    return this.path(path.join(",")).attr({stroke: color});
};

$(document).ready(function () {

	if ($("#data-analytics").attr('id')) {
		// Grab the data
		var labels = [],
			data = [];
		$("#data-analytics th").each(function () {
			labels.push($(this).html());
		});
		$("#data-analytics td").each(function () {
			data.push($(this).html());
		});
	
		// Draw
		var width = 450,
			height = 150,
			leftgutter = 1,//30,
			bottomgutter = 15,
			topgutter = 20,
			colorhue = .6 || Math.random(),
			color = "#3BC5DF",//"hsb(" + [colorhue, 1, .75] + ")",
			r = Raphael("holder", width, height),
			txt = {font: '9px Fontin-Sans, Arial', fill: "#999"},
			txt1 = {font: '12px Fontin-Sans, Arial', fill: "#555"},
			txt2 = {font: '12px Fontin-Sans, Arial', fill: "#000"},
			X = (width - leftgutter) / labels.length,
			max = Math.max.apply(Math, data),
			Y = (height - bottomgutter - topgutter) / max;
		r.drawGrid(leftgutter + X * .4, topgutter, width - leftgutter - X, height - topgutter - bottomgutter, 5, 5, "#ddd");
		var path = r.path().attr({stroke: color, "stroke-width": 2, "stroke-linejoin": "round"}),
			bgp = r.path().attr({stroke: "none", opacity: .3, fill: color}).moveTo(leftgutter + X * .5, height - bottomgutter),
			//frame = r.rect(10, 10, 100, 40, 5).attr({fill: "#eee", stroke: "#ddd", "stroke-width": 2}).hide(),
			label = [],
			is_label_visible = false,
			leave_timer,
			blanket = r.set();
		label[0] = r.text(30, 10, "hours").attr(txt1).hide();
		//label[1] = r.text(60, 40, "22 September 2008").attr(txt1).attr({fill: color}).hide();

		for (var i = 0, ii = labels.length; i < ii; i++) {
			var y = Math.round(height - bottomgutter - Y * data[i]),
				x = Math.round(leftgutter + X * (i + .5)),
				t = r.text(x, height - 6, labels[i]).attr(txt).toBack();
			bgp[i == 0 ? "lineTo" : "cplineTo"](x, y, 10);
			path[i == 0 ? "moveTo" : "cplineTo"](x, y, 10);
			var dot = r.circle(x, y, 0).attr({fill: color, stroke: color});
			blanket.push(r.rect(leftgutter + X * i, 0, X, height - bottomgutter).attr({stroke: "none", fill: "#fff", opacity: 0}));
			var rect = blanket[blanket.length - 1];
			(function (x, y, data, lbl, dot, t) {
				var timer, i = 0;
				$(rect.node).hover(function () {
					clearTimeout(leave_timer);
					var newcoord = {x: +x + 7.5, y: y - 19};
					if (newcoord.x + 100 > width) {
						newcoord.x -= 114;
					}
					//frame.show().animate({x: newcoord.x, y: newcoord.y}, 200 * is_label_visible);
					label[0].attr({text: data + " hour" + ((data % 10 == 1) ? "" : "s")}).show();//.animateWith(frame, {x: +newcoord.x + 50, y: +newcoord.y + 12}, 200 * is_label_visible);
					//label[1].attr({text: lbl + " September 2008"}).show().animateWith(frame, {x: +newcoord.x + 50, y: +newcoord.y + 27}, 200 * is_label_visible);
					dot.attr("r", 3);
					is_label_visible = true;
					t.attr(txt1);
				}, function () {
					dot.attr("r", 0);
					t.attr(txt);
					leave_timer = setTimeout(function () {
						//frame.hide();
						label[0].hide();
						//label[1].hide();
						is_label_visible = false;
						// r.safari();
					}, 1);
				});
			})(x, y, data[i], labels[i], dot, t);
		}
		bgp.lineTo(x, height - bottomgutter).andClose();
		//frame.toFront();
		label[0].toFront();
		//label[1].toFront();
		blanket.toFront();
	}
});