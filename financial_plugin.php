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
                $this->divyield        = $data[15]; // y - Dividend Yield
            }   
        }   
    }   
        /* Retrieve url of page for refreshing quote every 15 mins */
        function page_url() 
        {
            $page_url = 'http';
            if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $page_url .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
             $page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
             $page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            return $page_url;
        }
        
        /* Make the + or - change elicit differing coloration. */
        function get_change_color ($str)   
        {    
            $sign = $str{0};   
            if ($sign == '+') { $color = 'color:#009900;';   /* stock gained print # GREEN. */
            } elseif ($sign == '-') { $color =  'color:#ff0000;';   /* stock lost print RED. */
            } else {  $color = 'font-weight:normal;'; } 
            return $color;
        }
        
        /* Allow access to different charts with parameters */
        function financial_chart($symbol,$time_range,$chart_size) 
        {
            $yahoo_chart = "http://ichart.finance.yahoo.com/instrument/1.0/".$symbol."/chart;range=".$time_range."/image;size=".$chart_size."";
            return $yahoo_chart; 
        }     
        /* register the shortcode with wordpress */
        add_shortcode("financial_plugin", "financial_plugin_handler");
        
        /* retrieve perameters from shortcode */
        function financial_plugin_handler($symb) 
        {
            extract(shortcode_atts(array(
            'symb' => 'symb'
            ), $symb));     
            //run function that actually does the work of the plugin
            $fin_output = financialplugin_function($symb);
            //send back text to replace shortcode in post
            return $fin_output;
        }
        
        /* prepare shortcode output */
        function financialplugin_function($symb) 
        {
            // Declare class.   
            $quote = new yahoo; // new stock.
            $symbol = $symb;
            $quote->get_stock_quote($symbol); // Pass the Company's symbol.
        
            if ($quote->last != "0.00") {

                
            /*
            * chart reference codes 
            * https://code.google.com/p/yahoo-finance-managed/wiki/miscapiImageDownload
            * http://stackoverflow.com/questions/9807353/getting-stock-graphs-from-yahoo-finance
            */
            //$yahoo_chart = "http://ichart.finance.yahoo.com/c/bb/e/".$symbol;
            $yahoo_chart = "http://ichart.finance.yahoo.com/instrument/1.0/".$symbol."/chart;range=5d/image;size=239x110";
            
            $output .= "<div style=\"height:250px;float:left;margin-right:20px;\">";    

                $output .= "<div style=\"width:100%;text-align:center;margin-bottom:10px;\">"; //.$quote->symbol;
                $output .= "<span style=\"font-size:23px;line-height:30px;\"><strong>\$" .$quote->last. "</strong>&nbsp;&nbsp;"; // price.   
                $output .= "<span style=\"".get_change_color($quote->change). "\">(".$quote->change.")</span>\n"; // Company symbol 
                $output .= "</div>";
                /// CHART 
                $output .= "<a href=\"http://finance.yahoo.com/q?s=$quote->symbol\" title=\"Yahoo! Finance: " .$symbol.    
                "\"><img src=\"$yahoo_chart\"></a><br />";

                $output .= "<div style=\"width:100%;text-align:center;font-size:10px;\">(" .$quote->date. " at " .$quote->time. ")<br />";
                $output .= "<a href=\"http://finance.yahoo.com/q?s=".$symbol."\" target=\"_blank\">Yahoo Finance</a>"
                        . "| <a href=\"http://www.google.com/finance?q=".$symbol."\" target=\"_blank\">"
                        . "Google Finance</a></div>";   
            
            $output .= "</div>";
            
            $output .= "<div>"; 
                $output .= "52 Wk High: " .$quote->wkhigh. "<br>\n";
                $output .= "52 Wk Low: " .$quote->wklow. "<br>\n";    
                $output .= "EPS: " .$quote->eps. "<br>\n";
                $output .= "PE (ttm): " .$quote->pe. "<br>\n"; 
                $output .= "Div Rate: " .$quote->divrate. "<br>\n";
                $output .= "Yield: " .$quote->divyield. "<br>\n";  
                $output .= "Mkt Cap: \$" .$quote->capitalization. "<br>\n";    
                $output .= "Vol: " .$quote->volume. "<br>\n";   
                //$output .= "High: " .$quote->high. " Low: " .$quote->low. "<br>\n";
                //$output .= "Open: " .$quote->open. "<br>\n";          
                $output .= "<br>\n";   
            $output .= "<br>\n</div>"; 
            $output .= "<META http-equiv=\"refresh\" content=\"900;URL=".page_url()."\">"; 

            
            

            } else {
                /* cannot find quote information */
                echo "Quote not available.";
            }
            
        /* return text to calling function */        
        return $output;
        include ("tabs.php");
        
        }        
    ?>  

