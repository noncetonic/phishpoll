<?php
class Charts {

  public function getLineChart() {
    $info = statGraph();
    /* START of Line Chart Example */
    $lineChart = new HighCharts('lineChartDemo');

    $lineChart->setTitle('x', -20);  // Move title label on 'x'.
    $lineChart->setTitle('text', 'Site Traffic By Day');

    // HTML div container to use when drawing the chart.
    $lineChart->setChart('renderTo', 'lineChartDiv');
    $lineChart->setChart('marginBottom', 25);
    $lineChart->setChart('marginRight', 130);
    
    $lineChart->setChart('type', 'line');

    // Text labels to be shown on the X-Axis.
    $xAxisLabels = $info[0];
    $lineChart->setxAxis('categories', $xAxisLabels);

    // X and Y plotLines/plotBands options to be passed inside an associative array.
    // You can even add a depth for their labels values. From the HighCharts.js docs,
    // they could use something like: xAxis:{ plotLine [{ label:{text:'string'} }] }.
    $plotOptions = array('value' => 0, 'width' => 1, 'color' => '#808080');
    $lineChart->setyAxis('plotLines', $plotOptions);

    // A bit exhaustive to use the associative map when dealing with 'title = something'
    // but the axis 'title' could have: margin, rotation, align, enabled, offset, etc...
    // You can refer to http://www.highcharts.com/ref/ for the entire list.
    $lineChart->setyAxis('title', array('text' => 'Hits'));

    $data = array_map( 'intval', $info[1] );
    // The actual data to be graphed.
    $traffic = array('data' =>
         $data
         );

    // Add series to its associated key.
    $lineChart->addSerie('Hits', $traffic);

    // getRawArray() returns a PHP version of the chart array.
    $phpLineChartArr = $lineChart->getRawArray();

    // JavaScrip version ready to be served. $jsLineChart will
    // contain: var barChart = new Highcharts.Chart({ code });
    $jsLineChart = $lineChart->getJsChart();
    /* END of Line Chart Example */

    return $jsLineChart;
  }

  public function getBarChart() {
    
    /* START of Stacked Bar Chart Example */
    $barChart = new HighCharts('stackedChartDemo');

    $barChart->setChart('type', 'column');
    $barChart->setChart('renderTo', 'bartChartDiv');
    $barChart->setPlotOptions('column', array('stacking' => 'normal'));

    $barChart->setTitle('text', 'Total fruit consumtion, grouped by gender');

    $yAxisTitle  = array('align' => 'middle', 'text' => 'Number of fruits');
    $xAxisLabels = array('Salad', 'Soup', 'Apples', 'Toast', 'Pears', 'Limes');

    $barChart->setyAxis('min', 0);
    $barChart->setyAxis('title', $yAxisTitle);
    $barChart->setyAxis('allowDecimals', false);
    $barChart->setxAxis('categories', $xAxisLabels);

    $optionsJane = array('data' => array(3, 4, 4, 2, 5), 'stack' => 'female');
    $barChart->addSerie('Jane', $optionsJane);

    $optionsLili = array('data' => array(7, 5, 6, 2, 1), 'stack' => 'female');
    $barChart->addSerie('Lili', $optionsLili);

    $optionsJohn = array('data' => array(1, 3, 4, 10, 12), 'stack' => 'male');
    $barChart->addSerie('John', $optionsJohn);

    $optionsEric = array('data' => array(5, 2, 14, 17, 2), 'stack' => 'male');
    $barChart->addSerie('Eric', $optionsEric);

    $phpBarChartArr = $barChart->getRawArray();
    $jsBarChart = $barChart->getJsChart();
    /* END of Stacked Bar Chart Example */
    
    return $jsBarChart;
  }
    
  public function getSplineChart(){
    
    /* START of Spline Chart Example */    
    $splineChart = new HighCharts('splineChartDemo');    
    $splineChart->setTitle('text', 'Atmosphere Temperature by Altitude');
    
    $splineChart->setChart('width', 500);
    $splineChart->setChart('type', 'spline');
    $splineChart->setChart('inverted', true);
    $splineChart->setChart('renderTo', 'splineChartDiv');
    $splineChart->setChart('style', array('margin' => '0 auto'));

    $splineChart->setxAxis('reversed', false);
    $splineChart->setxAxis('maxPadding', 0.05);
    $splineChart->setxAxis('showLastLabel',true);
    $splineChart->setxAxis('title', array('enabled' => true, 'text' => 'Altitude'));
    $splineChart->setxAxis('labels', array('formatter' => 'function() {return  this.value +"km";}'));
    
    $splineChart->setyAxis('lineWidth', 2);
    $splineChart->setyAxis('title', array('text' => 'Temperature'));   

    $splineChart->setyAxis('labels', array('formatter' => 'function() {return this.value + "°";}'));
    
    $splineChart->setPlotOptions('spline', array('marker' => array('enable' => false)) );

    $data = array('data' => array(
      array(0, 15),     array(10, -50),
      array(20, -56.5), array(30, -46.5),
      array(40, -22.1), array(50, -2.5),
      array(60, -27.7), array(70, -55.7),
      array(80, -76.5)
    ));
    $splineChart->addSerie('Temperature', $data);
    // $phpSplineArr = $splineChart->getRawArray();
    $jsSplineChart = $splineChart->getJsChart();
    
    /* END of Spline Chart Example */
    return $jsSplineChart;

  }

  public function getDonutChart() {
    
    /* START of Donut Chart Example */
    $donutChart = new HighCharts('donutsChartDemo');    
    $donutChart->setTitle('text', "Browsers market share");
    
    $donutChart->setChart('width', 260);
    $donutChart->setChart('type', 'pie');
    $donutChart->setChart('renderTo', 'donutChartDiv');
    
    $donutChart->setPlotOptions('pie', array('shadow' => false));
    $donutChart->setyAxis('title', array('text' => 'Total percent market share'));       
    
    $jsFunction = "function() { return '<b>' + this.point.name +'</b>: '+ this.y +' %';}";
    $donutChart->setToolTip('formatter', $jsFunction);   

    $msieData = array(
      'y'     => 55.11,
      'color' => '#4572A7',
      'name'  => 'MSIE'
    );

    $browserData = array(
      'data' => array($msieData /* ..firefox, opeara, chrome... */), 
    );
    
    $browserData = array_merge($browserData, array('size' => '60%'));
    $donutChart->addSerie('Browsers', $browserData);
    
    return $donutChart->getJsChart();
  }
}
