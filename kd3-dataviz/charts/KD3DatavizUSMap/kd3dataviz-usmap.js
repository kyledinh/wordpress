setTimeout(function () {
  d3.json("/wp-content/plugins/kd3-dataviz/charts/KD3DatavizUSMap/kd3dataviz-usmap.json", function(error, json) {
    if (error) { 
  	console.warn(error); 
  	return
    }
    var dataset = json;
    d3dataviz_usmap_visualize(dataset);
  });  
}, 1000);

function d3dataviz_usmap_visualize(dataset) {

	var datamap = new Datamap({
  		scope: 'usa',
 	 	  element: document.getElementById('kd3dataviz-usmap'),
	  	geographyConfig: {
   	 	highlightBorderColor: '#ccc', // #009193
   	 	highlightFillColor: '#fff',
   	 	popupTemplate: function(geography, data) {
   	   		//document.getElementById("status").innerHTML = geography.properties.name + " " + data.valPercent + '% ';
   	   		datamap.updateChart({ label: geography.properties.name, pct: [100 - data.valPercent, data.valPercent]});
   	   		return '<div class="hoverinfo">' + geography.properties.name + ', Affected %: ' +  data.valPercent + '% ';
   	},
   		highlightBorderWidth: 2
  	},
  		fills: dataset.fills,
  		data: dataset.states
	});

	datamap.updateChart = function (model) {
		var arcTween = function(a) {
    		var i = d3.interpolate(this._current, a);
    		this._current = i(0);
    		return function(t) {
        		return arc(i(t));
			};
		};

  	data = eval(model); // which model?
  	arcs.data(donut(data.pct)); // recompute angles, rebind data
  	arcs.transition().ease("elastic").duration(dur).attrTween("d", arcTween);
  	sliceLabel.data(donut(data.pct));
  	sliceLabel.transition().ease("elastic").duration(dur)
      	.attr("transform", function(d) {return "translate(" + arc.centroid(d) + ")"; })
      	.style("fill-opacity", function(d) {return d.value==0 ? 1e-6 : 1;});
      
  	pieLabel.text(data.label);
  	percentLabel.text(data.pct[1] + "%");
	};

	//datamap.labels();

	var us = { label: 'United States', pct: [66, 44] },
    	data = us;

	var labels = ['NO', 'YES'];

	var w = 320,                       // width and height, natch
    	h = 320,
    	r = Math.min(w, h) / 2,        // arc radius
    	dur = 750,                     // duration, in milliseconds
    	color = d3.scale.category10(), // color for pie chart segments
    	donut = d3.layout.pie().sort(null),
    	arc = d3.svg.arc().innerRadius(r - 70).outerRadius(r - 20);

	// ---------------------------------------------------------------------
	var svg = d3.select("#kd3dataviz-usmap-donut").append("svg:svg")
    	.attr("width", w).attr("height", h);

	var arc_grp = svg.append("svg:g")
    	.attr("class", "arcGrp")
    	.attr("transform", "translate(" + (w / 2) + "," + (h / 2) + ")");

	var label_group = svg.append("svg:g")
    	.attr("class", "lblGroup")
    	.attr("transform", "translate(" + (w / 2) + "," + (h / 2) + ")");

	// GROUP FOR CENTER TEXT
	var center_group = svg.append("svg:g")
    	.attr("class", "ctrGroup")
    	.attr("transform", "translate(" + (w / 2) + "," + (h / 2) + ")");

	// CENTER LABEL
	var pieLabel = center_group.append("svg:text")
    	.attr("dy", "-.45em").attr("class", "chartLabel")
    	.attr("text-anchor", "middle")
    	.text(data.label);

	var percentLabel = center_group.append("svg:text")
    	.attr("dy", ".65em").attr("class", "chartPercentLabel")
    	.attr("text-anchor", "middle")
    	.text(data.pct[1] + "%");

	// DRAW ARC PATHS
	var arcs = arc_grp.selectAll("path")
    	.data(donut(data.pct));
	arcs.enter().append("svg:path")
    	.attr("stroke", "white")
    	.attr("stroke-width", 0.5)
    	.attr("fill", function(d, i) {return color(i);})
    	.attr("d", arc)
    	.each(function(d) {this._current = d});
	
	// DRAW SLICE LABELS
	var sliceLabel = label_group.selectAll("text")
    	.data(donut(data.pct));
	sliceLabel.enter().append("svg:text")
    	.attr("class", "arcLabel")
    	.attr("transform", function(d) {return "translate(" + arc.centroid(d) + ")"; })
    	.attr("text-anchor", "middle")
    	.text(function(d, i) {return labels[i]; });
}
