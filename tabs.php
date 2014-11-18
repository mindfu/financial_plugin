
    <!--link rel="stylesheet" type="text/css" href="css/default.css" /-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="css/animate.min.css"></script>
    <!--link href='css/animate.min.css' rel='stylesheet' type='text/css'-->
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabs.css" />
    <script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
<?php

    /* Allow access to different charts with parameters */
    function financial_chart($symbol,$time_range,$chart_size) 
    {
        $yahoo_chart = "http://ichart.finance.yahoo.com/instrument/1.0/".$symbol."/chart;range=".$time_range."/image;size=".$chart_size."";
        return $yahoo_chart; 
    }   
    
?>
    <div class="container"><!-- Start Tabs Container -->	
        <div class="main">
            <ul class="tabs">
                <li>
                  <input type="radio" checked name="tabs" id="tab1">
                  <label for="tab1">1d</label>
                  <div id="tab-content1" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","1d","239x110")."\"></a><br />"; ?></div>
                </li>
                <li>
                  <input type="radio" name="tabs" id="tab2">
                  <label for="tab2">5d</label>
                  <div id="tab-content2" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","5d","239x110")."\"></a><br />"; ?></div>
                </li>
                <li>
                  <input type="radio" name="tabs" id="tab3">
                  <label for="tab3">1m</label>
                  <div id="tab-content3" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","1m","239x110")."\"></a><br />"; ?></div>
                </li>
                <li>
                  <input type="radio" name="tabs" id="tab4">
                  <label for="tab4">3m</label>
                  <div id="tab-content4" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","3m","239x110")."\"></a><br />"; ?></div>
                </li>
                <li>
                  <input type="radio" name="tabs" id="tab5">
                  <label for="tab5">1y</label>
                  <div id="tab-content5" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","1y","239x110")."\"></a><br />"; ?></div>
                </li>
                <li>
                  <input type="radio" name="tabs" id="tab6">
                  <label for="tab6">5y</label>
                  <div id="tab-content6" class="tab-content animated fadeIn">
                  <?php echo "<img src=\"".financial_chart("aapl","5y","239x110")."\"></a><br />"; ?></div>
                </li>
            </ul>
        </div>
    </div><!-- End Tabs Container -->
