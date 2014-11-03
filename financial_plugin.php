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
            if (!fp) {   
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
                $this->divrate         = $data[15]; // y - Dividend Yield
            }   
        }   
    }   

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
	
	if ($quote->last == "0.00") {
            echo "<a href=\"http://finance.yahoo.com/q?s=$quote->symbol\" title=\"Yahoo! Finance: " .$symbol.    
        "\">$quote->symbol</a>\n"; // can use $quote->symbol or $symbol   
            echo "\n";   
            echo "<br>Last Trade: \$" .$quote->last. "\n"; // price.   
            echo '<br>Change: <span style="';   
            /* Make the + or - change elicit differing coloration. */  
            $str   = $quote->change;   
            $first = $str{0};   
            if ($first == '+') {       // If we gained print the # in GREEN.   
                echo 'color:#009900;';   
            } elseif ($first == '-') { // If we lost RED.   
                echo 'color:#990000;';   
            } else {                   // NO color.   
                echo 'font-weight:normal;';   
            } // endelseif   
            echo "\">" .$quote->change. "</span><br>\n";   

            echo "<br>Mkt Cap: \$" .$quote->capitalization. "\n"; // capitalization.   
            echo "<br>\n"; 
            echo $Descrip."<br>\n";
	}
	
	$last = $quote->last;
	$change = $quote->change;
	$Mkt_Capitalization = $quote->capitalization;

        //echo $id."<br>";
        //echo $acct."<br>";
        //echo $shares."<br>";
        //echo $sym."<br>";
        //echo $last."<br>";
        //echo $change."<br>";
        //echo $mktcap."<br>";
        //$ssql = "UPDATE ticker SET id='$id', acct='$acct', shares='$shares', symbol='$sym', last='$last', //change='$change', mktcap='$mktcap' WHERE id='$id'";
        //$ssql = "REPLACE INTO `master` SET `id`='$id', `acct`='$acct', `shares` = '$shares', `symbol` = //'$sym', `last` = '$last', `change`='$change', `mktcap`='$mktcap'";

        $ssql = "UPDATE `master` SET 
        `Mkt_Capitalization` = '$Mkt_Capitalization',  
        `Updated` = '$Updated', 
        `Updated_By` = '$Updated_By', 
        `last` = '$last', 
        `change` = '$change' WHERE `CompanyID` = '$CompanyID';";


		$sql_result = mysql_query($ssql,$db)
			or die("Couldn't execute query.");
		// echo $sql_result;
		if (!$sql_result) {
		echo "<center><h2>Sorry, we are experiencing problems. <br>Please return later!</h2></center>";
		}

		//echo $id." ".$acct." ".$shares." ".$sym." ".$last." ".$change." ".$mktcap;
        }

	while ($myrow = mysql_fetch_array($result));
	echo "\n";
	} else {
	echo "We are experiencing some technical problems.  Please come back later.";
	}

    echo "</ul>\n";   

    mysql_close($sql_result);
    ?>  
