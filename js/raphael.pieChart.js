Raphael.fn.pieChart = function (w, h, data) {
    var paper = this,
        rad = Math.PI / 180,
        chart = this.set(),
        cx = w/2,
        cy = h/2,
        r = Math.min(cx, cy) - 2;

    function sector(cx, cy, r, startAngle, endAngle, params) {
        var x1 = cx + r * Math.cos(-startAngle * rad),
            x2 = cx + r * Math.cos(-endAngle * rad),
            y1 = cy + r * Math.sin(-startAngle * rad),
            y2 = cy + r * Math.sin(-endAngle * rad);
        return paper.path(params, ["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]);
    }

    var angle = 90,
        total = 0,
        start = 0,
        process = function (j) {
            var value = data[j].v,
                color = data[j].c || "hsb(" + start + ", 1, 1)",
                angleplus = value / total == 1 ? 359.9: 360 * value / total,
                popangle = angle + (angleplus / 2),
                ms = 500,
                delta = 30,
                p = sector(cx, cy, r, angle, angle + angleplus, {fill: color, "stroke-width": 0});
            angle += angleplus;
            chart.push(p);
            start += .1;
        };
    for (var i = 0, ii = data.length; i < ii; i++) {
        total += data[i].v;
    }
    for (var i = 0; i < ii; i++) {
        process(i);
    }
    return chart;
};
