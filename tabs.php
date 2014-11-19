
    <!--link rel="stylesheet" type="text/css" href="css/default.css" /-->
    <!--link href='css/animate.min.css' rel='stylesheet' type='text/css'-->
    <!--link rel="stylesheet" type="text/css" href="css/style.css" /-->
    <!--script type="text/javascript" src="css/animate.min.css"></script-->    
    <!--script type="text/javascript" src="js/jquery-1.9.1.js"></script-->    
    <!--script type="text/javascript" src="js/jquery.js"></script-->
    
    <script src="js/modernizr-2.8.3.js"></script>
    <link rel="stylesheet" type="text/css" href="css/tabs.css" />

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
