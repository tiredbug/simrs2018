<?php
if (!function_exists("array_column")) {
	function array_column($array,$column_name) {
		return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
	}
}

// Functions for ChartJS library
function epi_chartjs($category_field, $period_field, $value_field, $input_array, $type, $id, $pxheight = 400, $chart_title = "Line Chart", $opacity = 1) {
	if (is_array($input_array)) { 
		$datasets = $input_array; 
	} else { 
		return false; 
	}
	if ($type == "Line" || $type == "Area") {
		$jstype = "Line";
	} else if ($type == "Bar" || $type =="HorizontalBar") {
		$jstype = "Bar";
	}
	$count = count($datasets);
	$line_array['labels'] = explode(',', $datasets[0]['gc_labels']);
	foreach ($datasets as $key=>$dataset) {
		$line_array['datasets'][$key]['label'] = $dataset[$category_field];
		$line_array['datasets'][$key] = return_color_array(($key + 1), $count, $line_array['datasets'][$key], $opacity);
		$line_array['datasets'][$key]['data'] = explode(',',$dataset['gc_values']);
	}
	$html = '
	<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">'.$chart_title.'</h3>
		<div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
	<div class="chart">
		<canvas id="chart_'.$id.'" style="height:'.intval($pxheight).'px"></canvas>
	</div>
	</div>
	<!-- /.box-body -->
	</div>';
	$html.= '
	<script language="javascript">
	    var chartCanvas = $("#chart_'.$id.'").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var chart_'.$id.' = new Chart(chartCanvas);';
	$json_array = json_encode($line_array);
	$html.= '
	var dynamicData = '.$json_array.';
	';
	$html.= 'var chartOptions = {
		defaultFontFamily: "\'Source Sans Pro\', sans-serif",
		showScale: true,
		scaleShowGridLines: false,
		scaleGridLineColor: "rgba(0,0,0,.05)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: true,
		bezierCurve: true,
		bezierCurveTension: 0.3,
		pointDot: true,
		pointDotRadius: 4,
		pointDotStrokeWidth: 1,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 2,
		datasetFill: '.($type == "Line" ? "false" : "true").',
		legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
		maintainAspectRatio: true,
		responsive: true
		};
		//Create the line chart
		chart_'.$id.'.'.$jstype.'(dynamicData, chartOptions);
		</script>
		';
	return $html;
}

function epi_chartjs_two($category_field, $period_field, $value_field, $input_array, $type, $id, $pxheight = 400, $chart_title = "Line Chart", $opacity = 1) {
	if (is_array($input_array)) { 
		$datasets = $input_array; 
	} else { 
		return false; 
	}
	if (strtolower($type) == "line" || strtolower($type) == "area") {
		$jstype = "line";
		$fill = (strtolower($type) == "line") ? false : true;
	} else if (strtolower($type) == "bar") {
		$jstype = "bar";
		$fill = true;
	} else if (strtolower($type) =="horizontalbar") {
		$jstype = 'horizontalBar';
		$fill = true;
		}
	$count = count($datasets);
	$line_array['labels'] = explode(',', $datasets[0]['gc_labels']);
	foreach ($datasets as $key=>$dataset) {
		$line_array['datasets'][$key]['label'] = $dataset[$category_field];
		$line_array['datasets'][$key] = return_color_array_two(($key + 1), $count, $line_array['datasets'][$key], $opacity);
		$line_array['datasets'][$key]['data'] = explode(',',$dataset['gc_values']);
		$line_array['datasets'][$key]['fill'] = $fill;
	}
	$html = '
	<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">'.$chart_title.'</h3>
		<div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
	<div class="chart">
		<canvas id="chart_'.$id.'" style="height:'.intval($pxheight).'px;" height="'.intval($pxheight).'"></canvas>
	</div>
	</div>
	<!-- /.box-body -->
	</div>';
	$json_array = json_encode($line_array);
	$html.= '
	<script language="javascript">
	var ctx = $("#chart_'.$id.'");
    var chart_'.$id.' = new Chart(ctx, {
		type: "'.$jstype.'",
		data: '.$json_array.',
	});
	</script>';
	return $html;
}
/*

new Chart(document.getElementById("chartjs-0"),
{
	"type":"line",
	"data":{
		"labels":["January","February","March","April","May","June","July"],
		"datasets":[{
			"label":"My First Dataset",
			"data":[65,59,80,81,56,55,40],
			"fill":false,
			"borderColor":"rgb(75, 192, 192)",
			"lineTension":0.1}]},
	"options":{}});*/

//	Creates a standard area graph with values from [0] and labels from [1]
function epi_simplearea($title, $input_array) {
	if (is_array($input_array)) { 
		$datasets = $input_array; 
	} else { 
		return false; 
	}
	$jstype = "line";
	$count = count($datasets); // count of x/y values 
	for($i=0;$i<$count;$i++) {
		$yvalues[] = $datasets[$i][0];
		$xlabels[] = $datasets[$i][1];
		
		}
	$line_array = array(
		'labels'=>$xlabels,
		'datasets'=>array(
			array(
				'label'=>$title,
				'data'=>$yvalues,
				'fill'=>true
				))
		);
	$line_array['datasets'][0] = return_color_array_two(1, 1, $line_array['datasets'][0], 0.5);
	//
	$html = '
	<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">'.$title.'</h3>
		<div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
	<div class="chart">
		<canvas id="chart_'.$title.'"></canvas>
	</div>
	</div>
	<!-- /.box-body -->
	</div>';
	$data = json_encode($line_array);
	$html.= '
	<script language="javascript">
	var ctx = $("#chart_'.$title.'");
    var chart_'.$title.' = new Chart(ctx, {
		type: "'.$jstype.'",
		data: '.$data.'
	});
	</script>';
	return $html;
}

function epi_simplebar($title, $input_array) {
	if (is_array($input_array)) { 
		$datasets = $input_array; 
	} else { 
		return false; 
	}
	$jstype = "bar";
	$count = count($datasets); // count of x/y values 
	$colors = array();
	for($i=0;$i<$count;$i++) {
		$yvalues[] = $datasets[$i][0];
		$xlabels[] = $datasets[$i][1];
		$colors = return_color_array_two($i+1,$count,$colors,0.75);
		$bgcolors[] = $colors['backgroundColor'];
		$bdcolors[] = $colors['borderColor'];
		}
	$line_array = array(
		'labels'=>$xlabels,
		'datasets'=>array(
			array(
				'label'=>$title,
				'data'=>$yvalues,
				'fill'=>true,
				'backgroundColor'=>$bgcolors,
				'borderColor'=>$bdcolors
				))
		);
	//
	$html = '
	<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">'.$title.'</h3>
		<div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
	<div class="chart">
		<canvas id="chart_'.$title.'"></canvas>
	</div>
	</div>
	<!-- /.box-body -->
	</div>';
	$data = json_encode($line_array);
	$html.= '
	<script language="javascript">
	var ctx = $("#chart_'.$title.'");
    var chart_'.$title.' = new Chart(ctx, {
		type: "'.$jstype.'",
		data: '.$data.',
		options: {"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}
	});
	</script>';
	return $html;
}

function epi_piechartjs($id, $doughnutChartArray, $height = 250, $title = "Doughnut Chart", $type = 'Doughnut'){
	if (!is_array($doughnutChartArray)) {
		return "Doughtnut/Pie chart requires a key->value array.";
		exit();
	}
	$slices = count($doughnutChartArray);
	foreach ($doughnutChartArray as $key=>$value) {
		$color_array = return_color_array($key + 1, $slices, $value, 1);
		$doughnutChartArray[$key]['color'] = $color_array['fillColor'];			
		$doughnutChartArray[$key]['highlight'] = $color_array['strokeColor'];			
	}
	$chart_data = json_encode($doughnutChartArray);
	$html='
	<div class="box box-primary">
	<div class="box-header with-border">
	<h3 class="box-title">'.$title.'</h3>
	<div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	</div>
	</div>
	<div class="box-body">
	<canvas id="pieChart_'.$id.'" style="height:'.intval($height).'px;" height="'.intval($height).'"></canvas>
	</div>
	</div>
	<script language="javascript">
	var pieChartCanvas = $("#pieChart_'.$id.'").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = '. $chart_data . ';
    var pieOptions = {
      segmentShowStroke: true,
      segmentStrokeColor: "#fff",
      segmentStrokeWidth: 2,
      percentageInnerCutout: '.($type == 'Pie' ? 0 : 50).', // This is 0 for Pie charts
      animationSteps: 100,
      animationEasing: "easeOutBounce",
      animateRotate: true,
      animateScale: false,
      responsive: true,
      maintainAspectRatio: true,
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    pieChart.'.$type.'(PieData, pieOptions);
	</script>';
	return $html;
}

function epi_piechartjs_two($id, $doughnutChartArray, $height = 250, $title = "Doughnut Chart", $type = 'Doughnut', $legend = true){
	if (!is_array($doughnutChartArray)) {
		return "Doughtnut/Pie chart requires a key->value array.";
		exit();
	}
	if ($type == "Doughnut") $jstype = 'doughnut'; else $jstype = 'pie';
	$slices = count($doughnutChartArray);
	// ridiculous v2.5 format
	$chart_data = array();
	$labels = array();
	$datasets = array();
	$datasets['data'] = array();
	$datasets['backgroundColor'] = array();
	$datasets['hoverBackgroundColor'] = array();
	
	foreach ($doughnutChartArray as $key=>$value) {
		$labels[] = $value['label'];
		$datasets['data'][] = $value['value'];
		// Old Way
		$color_array = return_color_array_two($key + 1, $slices, $value, 1);
		$datasets['backgroundColor'][] = $color_array['backgroundColor'];			
		$datasets['hoverBackgroundColor'][] = $color_array['pointHighlightFill'];
/*
		//New way as percentage
		$thirdcolorint = round(255/($slices/($key+1)),0)+127;
		if ($thirdcolorint > 255) $thirdcolorint = $thirdcolorint - 255;
		$thirdcolorhex = dechex($thirdcolorint);
		$datasets['backgroundColor'][] = percent2Color(round(100/($slices/($key+1)),0),208,100,0,$thirdcolorhex);
		$datasets['hoverBackgroundColor'][] = percent2Color(round(100/($slices/($key+1)),0),224,100,0,$thirdcolorhex);
*/
	}
	$chart_data['labels'] = $labels;
	$chart_data['datasets'] = array($datasets);
	$json_data = json_encode($chart_data);
	$html='
	<div class="box box-primary">
	<div class="box-header with-border">
	<h3 class="box-title">'.$title.'</h3>
	<div class="box-tools pull-right">
	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	</div>
	</div>
	<div class="box-body">
	<canvas id="piechart_'.$id.'" style="height:'.$height.'px;"></canvas>
	</div>
	</div>
	<script language="javascript">
	var ctx = $("#piechart_'.$id.'");
	var data = '.$json_data.';
    var piechart_'.$id.' = new Chart(ctx, {
		type: "'.$jstype.'",
		data: data,
    	options: {
			legend: {
				display: '.$legend.'
			}
		}		
	});
	</script>';
	return $html;
}

function return_color_array($index, $count, $arr, $master_opacity) {
	$stroke_opacity = 1;
	switch($index) {
		case 1: 
			$arr['fillColor'] = "rgba(89, 154, 211, $master_opacity)"; // color A
			$arr['strokeColor'] = "rgba(24, 89, 169, $stroke_opacity)"; // color B
			$arr['pointColor'] = "rgba(184, 210, 235, $master_opacity)"; // color C
			$arr['pointStrokeColor'] = "rgba(24, 89, 169, $stroke_opacity)";  // color B
			$arr['pointHighlightFill'] = "rgba(89, 154, 211, $master_opacity)"; // color A
			$arr['pointHighlightStroke'] =  "rgba(184, 210, 235, $stroke_opacity)"; // color C
			break;
		case 2: 
			$arr['fillColor'] = "rgba(121, 195, 106, $master_opacity)";
			$arr['strokeColor'] = "rgba(0, 140, 71, $stroke_opacity)";
			$arr['pointColor'] = "rgba(216, 228, 170, $master_opacity)";
			$arr['pointStrokeColor'] =  "rgba(0, 140, 71, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(121, 195, 106, $master_opacity)"; 
			$arr['pointHighlightStroke'] = "rgba(216, 228, 170, $stroke_opacity)"; 
			break;
		case 3: 
			$arr['fillColor'] = "rgba(249, 166, 90, $master_opacity)";
			$arr['strokeColor'] = "rgba(243, 125, 34, $stroke_opacity)";
			$arr['pointColor'] = "rgba(242, 209, 176, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(243, 125, 34, $stroke_opacity)"; 
			$arr['pointHighlightFill'] = "rgba(249, 166, 90, $master_opacity)"; 
			$arr['pointHighlightStroke'] = "rgba(242, 209, 176, $stroke_opacity)"; 
			break;
		case 4: 
			$arr['fillColor'] = "rgba(241, 89, 95, $master_opacity)";
			$arr['strokeColor'] = "rgba(237, 45, 46, $stroke_opacity)";
			$arr['pointColor'] = "rgba(242, 174, 172, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(237, 45, 46, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(241, 89, 95, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(242, 174, 172, $stroke_opacity)"; 
			break;
		case 5: 
			$arr['fillColor'] = "rgba(158, 102, 171, $master_opacity)";
			$arr['strokeColor'] = "rgba(102, 44, 145, $stroke_opacity)";
			$arr['pointColor'] = "rgba(212, 178, 211, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(102, 44, 145, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(158, 102, 171, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(212, 178, 211, $stroke_opacity)"; 
			break;
		case 6: 
			$arr['fillColor'] = "rgba(114, 114, 114, $master_opacity)";
			$arr['strokeColor'] = "rgba(1, 1, 1, $stroke_opacity)";
			$arr['pointColor'] = "rgba(204, 204, 204, $master_opacity)";
			$arr['pointStrokeColor'] =  "rgba(1, 1, 1, $stroke_opacity)"; 
			$arr['pointHighlightFill'] = "rgba(114, 114, 114, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(204, 204, 204, $stroke_opacity)";
			break;
		case 7: 
			$arr['fillColor'] = "rgba(205, 112, 88, $master_opacity)";
			$arr['strokeColor'] = "rgba(161, 29, 32, $stroke_opacity)";
			$arr['pointColor'] = "rgba(221, 184, 169, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(161, 29, 32, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(205, 112, 88, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(221, 184, 169, $stroke_opacity)";
			break;
		case 8: 
			$arr['fillColor'] = "rgba(215, 127, 179, $master_opacity)";
			$arr['strokeColor'] = "rgba(179, 56, 147, $stroke_opacity)";
			$arr['pointColor'] = "rgba(235, 191, 217, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(179, 56, 147, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(215, 127, 179, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(235, 191, 217, $stroke_opacity)";
			break;
		default: 
			$arr['fillColor'] = "rgba(123, 135 147, $master_opacity)";
			$arr['strokeColor'] = "rgba(12, 23, 45, $stroke_opacity);";
			$arr['pointColor'] = "rgba(147, 135, 123, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(12, 23, 45, $stroke_opacity);";
			$arr['pointHighlightFill'] = "rgba(123, 135 147, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(147, 135, 123, $stroke_opacity)";
			break;
		}
	return $arr;
}

function return_color_array_two($index, $count, $arr, $master_opacity) {
	$stroke_opacity = 1;
	if ($count > 8) {
		$index_mod = ($index % 9) + 1;
		if ($index > 9) $master_opacity*= 0.66;
		if ($index > 18) $master_opacity*= 0.66;
		if ($index > 27) $master_opacity*= 0.66;
	} else {
		$index_mod = $index;
	}
	switch($index_mod) {
		case 1: 
			$arr['backgroundColor'] = "rgba(89, 154, 211, $master_opacity)"; // color A
			$arr['borderColor'] = "rgba(24, 89, 169, $stroke_opacity)"; // color B
			$arr['pointColor'] = "rgba(184, 210, 235, $master_opacity)"; // color C
			$arr['pointStrokeColor'] = "rgba(24, 89, 169, $stroke_opacity)";  // color B
			$arr['pointHighlightFill'] = "rgba(89, 154, 211, $master_opacity)"; // color A
			$arr['pointHighlightStroke'] =  "rgba(184, 210, 235, $stroke_opacity)"; // color C
			break;
		case 2: 
			$arr['backgroundColor'] = "rgba(121, 195, 106, $master_opacity)";
			$arr['borderColor'] = "rgba(0, 140, 71, $stroke_opacity)";
			$arr['pointColor'] = "rgba(216, 228, 170, $master_opacity)";
			$arr['pointStrokeColor'] =  "rgba(0, 140, 71, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(121, 195, 106, $master_opacity)"; 
			$arr['pointHighlightStroke'] = "rgba(216, 228, 170, $stroke_opacity)"; 
			break;
		case 3: 
			$arr['backgroundColor'] = "rgba(249, 166, 90, $master_opacity)";
			$arr['borderColor'] = "rgba(243, 125, 34, $stroke_opacity)";
			$arr['pointColor'] = "rgba(242, 209, 176, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(243, 125, 34, $stroke_opacity)"; 
			$arr['pointHighlightFill'] = "rgba(249, 166, 90, $master_opacity)"; 
			$arr['pointHighlightStroke'] = "rgba(242, 209, 176, $stroke_opacity)"; 
			break;
		case 4: 
			$arr['backgroundColor'] = "rgba(241, 89, 95, $master_opacity)";
			$arr['borderColor'] = "rgba(237, 45, 46, $stroke_opacity)";
			$arr['pointColor'] = "rgba(242, 174, 172, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(237, 45, 46, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(241, 89, 95, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(242, 174, 172, $stroke_opacity)"; 
			break;
		case 5: 
			$arr['backgroundColor'] = "rgba(158, 102, 171, $master_opacity)";
			$arr['borderColor'] = "rgba(102, 44, 145, $stroke_opacity)";
			$arr['pointColor'] = "rgba(212, 178, 211, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(102, 44, 145, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(158, 102, 171, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(212, 178, 211, $stroke_opacity)"; 
			break;
		case 6: 
			$arr['backgroundColor'] = "rgba(123, 135, 147, $master_opacity)";
			$arr['borderColor'] = "rgba(12, 23, 45, $stroke_opacity)";
			$arr['pointColor'] = "rgba(147, 135, 123, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(12, 23, 45, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(123, 135, 147, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(147, 135, 123, $stroke_opacity)";
			break;
		case 7: 
			$arr['backgroundColor'] = "rgba(205, 112, 88, $master_opacity)";
			$arr['borderColor'] = "rgba(161, 29, 32, $stroke_opacity)";
			$arr['pointColor'] = "rgba(221, 184, 169, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(161, 29, 32, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(205, 112, 88, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(221, 184, 169, $stroke_opacity)";
			break;
		case 8: 
			$arr['backgroundColor'] = "rgba(215, 127, 179, $master_opacity)";
			$arr['borderColor'] = "rgba(179, 56, 147, $stroke_opacity)";
			$arr['pointColor'] = "rgba(235, 191, 217, $master_opacity)";
			$arr['pointStrokeColor'] = "rgba(179, 56, 147, $stroke_opacity)";
			$arr['pointHighlightFill'] = "rgba(215, 127, 179, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(235, 191, 217, $stroke_opacity)";
			break;
		case 9: 
			$arr['backgroundColor'] = "rgba(114, 114, 114, $master_opacity)";
			$arr['borderColor'] = "rgba(1, 1, 1, $stroke_opacity)";
			$arr['pointColor'] = "rgba(204, 204, 204, $master_opacity)";
			$arr['pointStrokeColor'] =  "rgba(1, 1, 1, $stroke_opacity)"; 
			$arr['pointHighlightFill'] = "rgba(114, 114, 114, $master_opacity)";
			$arr['pointHighlightStroke'] = "rgba(204, 204, 204, $stroke_opacity)";
			break;
		}
	return $arr;
}

function percent2Color($value, $brightness = 255, $max = 100, $min = 0, $thirdColorHex = '00') {
	// Calculate first and second color (Inverse relationship)
	$first = (1-($value/$max))*$brightness;
	$second = ($value/$max)*$brightness;

	// Find the influence of the middle color (yellow if 1st and 2nd are red and green)
	$diff = abs($first-$second);
	$influence = ($brightness-$diff)/2;   
	$first = intval($first + $influence);
	$second = intval($second + $influence);

	// Convert to HEX, format and return
	$firstHex = str_pad(dechex($first),2,0,STR_PAD_LEFT);
	$secondHex = str_pad(dechex($second),2,0,STR_PAD_LEFT);
	$thirdColorHex = str_pad(dechex($thirdColorHex),2,0,STR_PAD_LEFT);
	
	if (($value % 3) == 0) { // three
		return '#' . $firstHex . $secondHex . $thirdColorHex;
	} else if (($value % 3) == 1) { // two
		return '#' . $thirdColorHex . $firstHex . $secondHex;
	}  else if (($value % 3) == 2) { // one
		return '#' . $secondHex . $thirdColorHex . $firstHex;
	}

// alternatives:
// return $thirdColorHex . $firstHex . $secondHex;
// return $firstHex . $thirdColorHex . $secondHex;
}
?>
