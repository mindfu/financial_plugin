<?php
    $output .= "    
    <div class=\"container\"><!-- Start Tabs Container -->
        <div class=\"main\">
            <ul class=\"tabs\">";
    
    $output .= "<li>
                  <input type=\"radio\" checked name=\"tabs\" id=\"tab1\">
                  <label for=\"tab1\">1d</label>
                  <div id=\"tab-content1\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","1d","239x110")."\"></a><br /></div>
                </li>";
    $output .= "<li>
                  <input type=\"radio\" name=\"tabs\" id=\"tab2\">
                  <label for=\"tab2\">5d</label>
                  <div id=\"tab-content2\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","5d","239x110")."\"></a><br /></div>
                </li>";

    $output .= "<li>
                  <input type=\"radio\" name=\"tabs\" id=\"tab3\">
                  <label for=\"tab3\">1m</label>
                  <div id=\"tab-content3\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","1m","239x110")."\"></a><br /></div>
                </li>";

    $output .= "<li>
                  <input type=\"radio\" name=\"tabs\" id=\"tab4\">
                  <label for=\"tab4\">3m</label>
                  <div id=\"tab-content4\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","3m","239x110")."\"></a><br /></div>
                </li>";

    $output .= "<li>
                  <input type=\"radio\" name=\"tabs\" id=\"tab5\">
                  <label for=\"tab5\">1y</label>
                  <div id=\"tab-content5\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","1y","239x110")."\"></a><br /></div>
                </li>";

    $output .= "<li>
                  <input type=\"radio\" name=\"tabs\" id=\"tab6\">
                  <label for=\"tab6\">5y</label>
                  <div id=\"tab-content6\" class=\"tab-content animated fadeIn\">   
                  <img src=\"".financial_chart("aapl","5y","239x110")."\"></a><br /></div>
                </li>";

    $output .= "         </ul>
        </div>
    </div><!-- End Tabs Container -->";
    //$output .= "<div style=\"\"><a href=\"http://us.rd.yahoo.com/finance/news/rss/add/*http://finance.yahoo.com/rss/headline?s=".$symbol."><img src=\"./img/rss_icon.png\"></a></div>";
 
    
