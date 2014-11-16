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
        /* Make the + or - change elicit differing coloration. */
        function get_change_color ($str)   
        {    
            $sign = $str{0};   
            if ($sign == '+') { $color = 'color:#009900;';   // If we gained print the # in GREEN.
            } elseif ($sign == '-') { $color =  'color:#ff0000;';   // If we lost RED.
            } else {  $color = 'font-weight:normal;'; } 
            return $color;
        }
        
        //register the shortcode with wordpress
        add_shortcode("financial_plugin_fun", "financial_plugin_handler");

        function financial_plugin_handler($symb) {
            extract(shortcode_atts(array(
            'symb' => 'symb'
            ), $symb));     
            //run function that actually does the work of the plugin
            $demolph_output = financialplugin_function($symb);
            //send back text to replace shortcode in post
            return $demolph_output;
        }

        function financialplugin_function($symb) {
            // Declare class.   
            $quote = new yahoo; // new stock.
            $symbol = $symb;
            $quote->get_stock_quote($symbol); // Pass the Company's symbol.   

            if ($quote->last != "0.00") {

                $output .= "<a href=\"http://finance.yahoo.com/q?s=$quote->symbol\" title=\"Yahoo! Finance: " .$symbol.    
            "\">$quote->symbol</a>\n"; // can use $quote->symbol or $symbol   
                $output .= "\n";   
                $output .= "<br>Last Trade: \$" .$quote->last. " (" .$quote->date. " at " .$quote->time. ") \n"; // price.   
                $output .= '<br>Change: <span style="';   
                $output .= "" .get_change_color($quote->change). "\">".$quote->change."</span><br>\n";  
                $output .= "Open: " .$quote->open. "<br>\n";  
                $output .= "High: " .$quote->high. " Low: " .$quote->low. "<br>\n";  
                $output .= "Vol: " .$quote->volume. "<br>\n";  
                $output .= "52 Week High: " .$quote->wkhigh. " 52 Week Low: " .$quote->wklow. "<br>\n";  
                $output .= "EPS: " .$quote->eps. " PE: " .$quote->pe. "<br>\n";  
                $output .= "Dividend: " .$quote->divrate. " Yield: " .$quote->divyield. "<br>\n";  
                $output .= "<br>Mkt Cap: \$" .$quote->capitalization. "\n"; // capitalization.           
                $output .= "<br>\n";   
                $output .= "<br>\n"; 

                /*
                * CHART
                * https://code.google.com/p/yahoo-finance-managed/wiki/miscapiImageDownload
                * http://stackoverflow.com/questions/9807353/getting-stock-graphs-from-yahoo-finance
                */
                $yahoo_chart = "http://ichart.finance.yahoo.com/c/bb/e/".$symbol; 
                $output .= "<a href=\"\"><img src=\"$yahoo_chart\"></a><br /><br />";
                    //-$yahoo_chart = "http://ichart.finance.yahoo.com/instrument/1.0/".$symbol_lower."/chart;range=1d/image;size=239x110";--
                $output .= "<div style=\"width:250px;text-align:center;margin-top:0px\">"
                . "<a href=\"http://finance.yahoo.com/q?s=".$symbol."\" target=\"_blank\">Yahoo Finance</a>"
                        . "| <a href=\"http://www.google.com/finance?q=".$symbol."\" target=\"_blank\">"
                        . "Google Finance</a></div>"; 

            } else {
                //echo "Quote not available.";
            }
            //process plugin
            //send back text to calling function
            return $output;
        }        
    ?>  

