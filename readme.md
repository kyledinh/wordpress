# KD3 Dataviz Plugin

This is a simplified WordPress plugin to add predefined D3 charts via a shortcode. I've open-sourced this version, please feel free to modify and use. 

The chart is configurable with the javascript file for d3js functions, the css for styling and the json file for the data source. All these files are editable and found in the charts/KD3DatavizUSMap/ directory.

* kd3-dataviz/charts/KD3DatavizUSMap/kd3dataviz-usmap.css
* kd3-dataviz/charts/KD3DatavizUSMap/kd3dataviz-usmap.js
* kd3-dataviz/charts/KD3DatavizUSMap/kd3dataviz-usmap.json

## Available Shortcodes

Add both shortcodes with size attributes if you don't want the default sizes. One shortcode is for the roll-over US map that will update the donut chart.

* USMap with a Donut Chart 
	* [kd3dataviz-usmap width="900" height="600" class="myclass"]
	* [kd3dataviz-usmap-donut]


## USMap with Donut


* Sample json
```
 "AZ": {
      "fillKey": "South",
      "valPercent": 23
  },
```

## Notes on the D3JS function file

* It uses Datamap to drap the USMap
* `popupTemplate()` is the trigger event handler with a state is rolled over. This has been customized to with the `updateChart` method. We use this function to update the child chart `popup` or `donut`.
* From Datamap we have the `geography` and `data` objects.
* http://datamaps.github.io/
* https://github.com/markmarkoh/datamaps



