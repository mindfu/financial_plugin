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
* 52wk high: k
* 52wk low: j
* EPS: e7 (current yr est)
* PE (ttm): r
* Div Rate: d
* Yield: y
* Market Cap: j1
* Volume: v
* http://www.canbike.org/information-technology/yahoo-finance-url-download-to-a-csv-file.html
 * s l1 d1 t1 c1 o h g v j1 k j e7 r d y v
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
            if (!fp) {   
                echo 'Error : cannot recieve stock quote data.';   
            } else {   
                $data = @fgetcsv($fp, 4096, ', ');    
                fclose($fp);   
                $this->symbol          = $data[0]; // Stock symbol.   
                $this->last            = $data[1]; // Last Trade (current price).   
                $this->date            = $data[2];   
                $this->time            = $data[3];   
                $this->change          = $data[4]; // + or - amount change.   
                $this->open            = $data[5];   
                $this->high            = $data[6];   
                $this->low             = $data[7];   
                $this->volume          = $data[8];   
                $this->capitalization  = $data[9];   
                $this->wkhigh          = $data[10];   
                $this->wklow           = $data[11];   
                $this->eps             = $data[12];   
                $this->pe              = $data[13];   
                $this->divrate         = $data[14];   
                $this->volume          = $data[15];   
            }   
        }   
    }   

