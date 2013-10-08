<?php
class HighCharts {

  // New or cached update flag.
  private $genNew;  

  // The JavaScript JSON of the chart.
  private $jsObject;

  // The PHP Array version of the chart.
  private $phpArray;

  // Hold the name of the of the desired chart variable.
  private $variableName;

  private $chartArr = array();
  private $titleArr = array();
  private $xAxisArr = array();
  private $yAxisArr = array();
  private $serieArr = array();
  private $plotOpts = array();
  private $toolTips = array();

  public function __construct($chartVar) {
    $this->updateFlag();
    $this->variableName = $chartVar;
  }

  public function setChart($key, $value) {
    $this->updateFlag();
    $this->chartArr[$key] = $value;
  }

  public function setTitle($key, $value) {
    $this->updateFlag();
    $this->titleArr[$key] = $value;
  }

  public function setyAxis($key, $value) {
    $this->setAnyAxis($this->yAxisArr, $key, $value);
  }

  public function setxAxis($key, $value) {
    $this->setAnyAxis($this->xAxisArr, $key, $value);
  }

  public function addSerie($name, $options) {
    $this->updateFlag();
    $newSerie = array('name' => $name);
    $newSerie = array_merge($newSerie, $options);
    $this->serieArr[] = $newSerie;
  }

  public function setToolTip($key, $value) {
    $this->updateFlag();
    $this->toolTips[$key] = $value;
  }
  public function setPlotOptions($key, $value) {
    $this->updateFlag();
    $this->plotOpts[$key] = $value;
  }

  public function getRawArray() {
    $hasNewData = isset($this->phpArray) && !$this->genNew;
    return $hasNewData ? $this->phpArray : $this->genPhpArray();
  }
  
  private function setAnyAxis(&$axis, $key, $value) {
    $this->updateFlag();
    switch ($key) {

      case 'title':
      case 'labels':
        $axis = array_merge($axis, array($key => $value));
        break;

      case 'plotLines':
      case 'plotBands':
      case 'addPlotBands'; // Just an alias. Axis can have
      case 'addPlotLines'; // multiple bands and/or lines.

        if(strlen($key) > 9) { // addPlot... to -> plot...
          $key = lcfirst( substr($key, 3, strlen($key)) );
        }
        $plot = isset($axis[$key]) ? $axis[$key] : array();
        array_push($plot, $value); // Add new $value to it.
        $axis = array_merge($axis,  array($key => $plot));
        break;

      default:
        $axis[$key] = $value;
        break;
    }
  }
  
  private function updateFlag() {
    $this->genNew = true;
  }

  private function genPhpArray() {
    $this->phpArray = array(
      'chart'  => $this->chartArr,
      'title'  => $this->titleArr,
      'xAxis'  => $this->xAxisArr,
      'yAxis'  => $this->yAxisArr,
      'series' => $this->serieArr,
      'toolTip' => $this->toolTips,
      'plotOptions' => $this->plotOpts
    );
    return $this->phpArray;
  }
  
  private function wrapWithConstructor($jsObject) {
    $jsHighChart = ' new Highcharts.Chart(' . $jsObject . ');';
    $jsChart  = 'var ' . $this->variableName . ' = ' . $jsHighChart;
    return $jsChart;
  }
  
  private function escapePhpQuotes($sourceArr) {
    // HighChart will only accept JS Objects with unquoted keys.
    $rePatern = '/"(\w+)"\s*:/';
    $jsObject = preg_replace($rePatern, '$1:', json_encode($sourceArr));
    
    // Removes quotes around JS functions found in the json array.
    // ...And unescape the the inner inner ones found on strings.
    $rePatern = '/"(function[\s\S]+?})"/';
    while(preg_match($rePatern, $jsObject, $m, PREG_OFFSET_CAPTURE) > 0) {
      $start = $m[0][1];
      $len = strlen($m[0][0]);
      $escapedJsFunc = stripslashes($m[1][0]);
      $jsObject = substr_replace($jsObject, $escapedJsFunc, $start, $len);
    }   
    return $jsObject;
  }

  public function getJsChart($addConstructor = true) {
    $sourceArr = $this->getRawArray();
    // Remove null values since HighChart reject them.
    $sourceArr = array_filter($sourceArr);
    $jsObject = $this->escapePhpQuotes($sourceArr);
    
    return $addConstructor ? $this->wrapWithConstructor($jsObject) : $jsObject;
  }
}