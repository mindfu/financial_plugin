<?php

    /**
    * Plugin Name: Financial Plugin
    * Plugin URI: http://mindfu.com/financial_plugin
    * Description: This plugin uses yahoo data to display financial information about companies using shortcodes.
    * Version: 1.0
    * Author: Chris Scrivo
    * Author URI: http://chrisscrivo.com
    * License: GPL12
    */ 

    /* 
    * Financial Plugin (Wordpress Plugin)
    * Copyright (C) 2014 Chris Scrivo
    * Contact me at http://www.mindfu.com/contact
    * 
    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    * 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    * GNU General Public License for more details.
    * 
    * You should have received a copy of the GNU General Public License
    * along with this program. If not, see <http://www.gnu.org/licenses/>.
    */

    /*
    * 52wk high: k
    * 52wk low: j
    * EPS: e7 (current yr est)
    * PE (ttm): r
    * Div Rate: d
    * Yield: y
    * Market Cap: j1
    * Volume: v
    * http://www.canbike.org/information-technology/yahoo-finance-url-download-to-a-csv-file.html
     * s l1 d1 t1 c1 o h g v j1 k j e7 r d y 
    */

    /* Create a class to get the quote */
    Class yahoo   
    {
        /* Get the quote */  
        function get_stock_quote($symbol)   
        {   
            // Yahoo! Finance URL to fetch the CSV data.   
            $url = sprintf("http://finance.yahoo.com/d/quotes.csv?s=$symbol&f=sl1d1t1c1ohgvj1kje7rdyv&e=.csv", $symbol);   
            $fp  = fopen($url, 'r');   
            if (!$fp) {   
                echo 'Error : cannot recieve stock quote data.';   
            } else {   
                $data = @fgetcsv($fp, 4096, ', ');    
                fclose($fp);   
                $this->symbol          = $data[0];  // s - Stock symbol.   
                $this->last            = $data[1];  // l1 - Last Trade (current price).   
                $this->date            = $data[2];  // d1 - Last Trade Date
                $this->time            = $data[3];  // t1 - Last Trade Time
                $this->change          = $data[4];  // c1 - + or - amount change.   
                $this->open            = $data[5];  // o - Open
                $this->high            = $data[6];  // h - Day’s High
                $this->low             = $data[7];  // g - Day’s Low
                $this->volume          = $data[8];  // v - Volume
                $this->capitalization  = $data[9];  // j1 - Market Capitalization
                $this->wkhigh          = $data[10]; // k - 52-week High
                $this->wklow           = $data[11]; // j - 52-week Low
                $this->eps             = $data[12]; // e7 - EPS Estimate Current Year
                $this->pe              = $data[13]; // r - P/E Ratio
                $this->divrate         = $data[14]; // d - Dividend/Share
                $this->divyield         = $data[15]; // y - Dividend Yield
            }   
        }   
    }   
        /*
        $sql = "SELECT * FROM `master` WHERE `Research_Sector` = 'Medical Devices & Tech' AND Symbol != '' AND Symbol != 'private' AND Exchange = '.OB' ";
        $result = mysql_query($sql, $db);
            if ($myrow = mysql_fetch_array($result)) {
            do {
                
		$CompanyID = $myrow["CompanyID"];
		$Company = $myrow["Company"]; 
		$www = $myrow["www"];
		$Symbol = $myrow["Symbol"]; 
		$Exchange = $myrow["Exchange"]; 
		$Mkt_Capitalization = $myrow["Mkt_Capitalization"];
		$Employees = $myrow["Employees"]; 
		$Updated = date("Y-m-d");
		$Updated_By = "ticker";
		$last = $myrow["last"];
		$change = $myrow["change"];
		$Symbol = $Symbol.".OB";  

                // Stock symbols.   
                $symbols = array($Symbol);   
                $i = 0;   
                // Declare class.   
                $quote = new yahoo; // new stock.   
                // Loop thru array of symbols.   
                //print_r($symbols);//echo "<br /><br />";
        
        $quote->get_stock_quote($symbols[$i++]); // Pass the Company's symbol. 
	*/ 
    
        // Stock symbols.   
        $symbols = array("aapl","msft");   
        //$i = 0;     

        // Declare class.   
        $quote = new yahoo; // new stock.
        // $symbol = $quote->symbol;
        // global $symbol;
        $symbol = "msft";
        //$quote->get_stock_quote($symbols[1]); // Pass the Company's symbol. 
        $quote->get_stock_quote($symbol); // Pass the Company's symbol.   
        
	if ($quote->last != "0.00") {
            
            echo "<a href=\"http://finance.yahoo.com/q?s=$quote->symbol\" title=\"Yahoo! Finance: " .$symbol.    
        "\">$quote->symbol</a>\n"; // can use $quote->symbol or $symbol   
            echo "\n";   
            echo "<br>Last Trade: \$" .$quote->last. " (" .$quote->date. " at " .$quote->time. ") \n"; // price.   
            echo '<br>Change: <span style="';   
            /* Make the + or - change elicit differing coloration. */  
            $str   = $quote->change;   
            $first = $str{0};   
            if ($first == '+') { echo 'color:#009900;';   // If we gained print the # in GREEN.
            } elseif ($first == '-') { echo 'color:#990000;';   // If we lost RED.
            } else {  echo 'font-weight:normal;'; }   
            echo "\">" .$quote->change. "</span><br>\n";  
            echo "Open: " .$quote->open. "<br>\n";  
            echo "High: " .$quote->high. " Low: " .$quote->low. "<br>\n";  
            echo "Vol: " .$quote->volume. "<br>\n";  
            echo "52 Week High: " .$quote->wkhigh. " 52 Week Low: " .$quote->wklow. "<br>\n";  
            echo "EPS: " .$quote->eps. " PE: " .$quote->pe. "<br>\n";  
            echo "Dividend: " .$quote->divrate. " Yield: " .$quote->divyield. "<br>\n";  
            echo "<br>Mkt Cap: \$" .$quote->capitalization. "\n"; // capitalization.           
            echo "<br>\n";   
            echo "<br>\n"; 
            
        } else {
            echo "Quote not available.";
        }

        $last = $quote->last;
        $change = $quote->change;
        $Mkt_Capitalization = $quote->capitalization;

            /*
            echo $id."<br>";
            echo $acct."<br>";
            echo $shares."<br>";
            echo $sym."<br>";
            echo $last."<br>";
            echo $change."<br>";
            echo $mktcap."<br>";
            //$ssql = "UPDATE ticker SET id='$id', acct='$acct', shares='$shares', symbol='$sym', last='$last', //change='$change', mktcap='$mktcap' WHERE id='$id'";
            $ssql = "REPLACE INTO `master` SET `id`='$id', `acct`='$acct', `shares` = '$shares', `symbol` = //'$sym', `last` = '$last', `change`='$change', `mktcap`='$mktcap'";

            $ssql = "UPDATE `master` SET 
            `Mkt_Capitalization` = '$Mkt_Capitalization',  
            `Updated` = '$Updated', 
            `Updated_By` = '$Updated_By', 
            `last` = '$last', 
            `change` = '$change' WHERE `CompanyID` = '$CompanyID';";
            */
            /*
            $sql_result = mysql_query($ssql,$db)
                    or die("Couldn't execute query.");
                // echo $sql_result;
            if (!$sql_result) {
            echo "<center><h2>Sorry, we are experiencing problems. <br>Please return later!</h2></center>";
            }
            */
		//echo $id." ".$acct." ".$shares." ".$sym." ".$last." ".$change." ".$mktcap;
        /*}

            while ($myrow = mysql_fetch_array($result));
            echo "\n";
            } else {
            echo "We are experiencing some technical problems.  Please come back later.";
            }
        
        echo "</ul>\n";   
        mysql_close($sql_result);
        */
        
        /*
        ######### EASY VERSION
        //tell wordpress to register the demolistposts shortcode
        add_shortcode("demo-list-posts", "demolistposts_handler");

        function demolistposts_handler() {
            //run function that actually does the work of the plugin
            $demolph_output = demolistposts_function();
            //send back text to replace shortcode in post
            return $demolph_output;
        }

        function demolistposts_function() {
            //process plugin
            $demolp_output = "Hello World!";
            //send back text to calling function
            return $demolp_output;
        }
        
        ########## COMPLEX VERSION
        # http://www.reallyeffective.co.uk/archives/2009/08/06/how-to-code-your-own-wordpress-shortcode-plugin-tutorial-part-2/
        //define plugin defaults
        DEFINE("DEMOLP_CATEGORYLIST", "");
        DEFINE("DEMOLP_HEADINGSTART", "<h4>See Also</h4>");
        DEFINE("DEMOLP_HEADINGEND", "");
        DEFINE("DEMOLP_LISTSTART", "<ul>");
        DEFINE("DEMOLP_LISTEND", "</ul>");
        DEFINE("DEMOLP_ITEMSTART", "<li>");
        DEFINE("DEMOLP_ITEMEND", "</li>");    

        //tell wordpress to register the demolistposts shortcode
        add_shortcode("demo-list-posts", "demolistposts_handler");

        function demolistposts_handler($incomingfrompost) {
            //process incoming attributes assigning defaults if required
            $incomingfrompost=shortcode_atts(array(
              "categorylist" => DEMOLP_CATEGORYLIST,
              "headingstart" => DEMOLP_HEADINGSTART,
              "headingend" => DEMOLP_HEADINGEND,
              "liststart" => DEMOLP_LISTSTART, 
              "listend" => DEMOLP_LISTEND,           
              "itemstart" => DEMOLP_ITEMSTART,
              "itemend" => DEMOLP_ITEMEND            
            ), $incomingfrompost);
            //run function that actually does the work of the plugin
            $demolph_output = demolistposts_function($incomingfrompost);
            //send back text to replace shortcode in post
            return $demolph_output;
        }
        */
        /*
        //use wp_specialchars_decode so html is treated as html and not text
        //use wp_specialchars when outputting text to ensure it is valid html
        function demolistposts_function($incomingfromhandler) {
            //add heading start
            $demolp_output = wp_specialchars_decode($incomingfromhandler["headingstart"]);
            
            //add list start
            $demolp_output .= wp_specialchars_decode($incomingfromhandler["liststart"]);
            for ($demolp_count = 1; $demolp_count <= $incomingfromhandler["categorylist"]; $demolp_count++) {
              $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemstart"]);
              $demolp_output .= $demolp_count;
              $demolp_output .= " of ";
              $demolp_output .= wp_specialchars($incomingfromhandler["categorylist"]);
              $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemend"]);      
            }
            
            //add list end
            $demolp_output .= wp_specialchars_decode($incomingfromhandler["listend"]);  
            
            //add heading end
            $demolp_output .= wp_specialchars_decode($incomingfromhandler["headingend"]);
            
            //send back text to calling function
            return $demolp_output;
        }
        */

        
        /*
         * CHART
         * https://code.google.com/p/yahoo-finance-managed/wiki/miscapiImageDownload
         * http://stackoverflow.com/questions/9807353/getting-stock-graphs-from-yahoo-finance
         * 
         */

        $yahoo_chart = "http://ichart.finance.yahoo.com/c/bb/e/".$symbol; 
        echo "<a href=\"\"><img src=\"$yahoo_chart\"></a><br /><br />";
            //-$yahoo_chart = "http://ichart.finance.yahoo.com/instrument/1.0/".$symbol_lower."/chart;range=1d/image;size=239x110";--
        echo "<div style=\"width:250px;text-align:center;margin-top:0px\">"
        . "<a href=\"http://finance.yahoo.com/q?s=".$symbol."\" target=\"_blank\">Yahoo Finance</a>"
                . "| <a href=\"http://www.google.com/finance?q=".$symbol."\" target=\"_blank\">"
                . "Google Finance</a></div>"; 

        
        
    ?>  

