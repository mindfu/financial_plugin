<?php

$j = 1;


	include ("ccc.php");
//$ids = $HTTP_GET_VARS["id"];
// 				}
//		}


/* Class. */  
 Class yahoo   
{   
     /* Function. */  
    function get_stock_quote($symbol)   
    {   
        // Yahoo! Finance URL to fetch the CSV data.   
        $url = sprintf("http://finance.yahoo.com/d/quotes.csv?s=$symbol&f=sl1d1t1c1ohgvj1&e=.csv", $symbol);   
           $fp  = fopen($url, 'r');   
         if (!fp) {   
             echo 'Error : cannot recieve stock quote data.';   
         } else {   
             $data = @fgetcsv($fp, 4096, ', ');    
             fclose($fp);   
             $this->symbol = $data[0]; // Stock symbol.   
             $this->last   = $data[1]; // Last Trade (current price).   
             $this->date   = $data[2];   
             $this->time   = $data[3];   
             $this->change = $data[4]; // + or - amount change.   
             $this->open   = $data[5];   
             $this->high   = $data[6];   
             $this->low    = $data[7];   
             $this->volume = $data[8];   
             $this->capitalization  = $data[9];   
         }   
     }   
  }   


  // user id
  //$acctnum = '110663690';

  //connect to db and get array of symbols

        $sql = "SELECT * FROM `master` WHERE `Research_Sector` = 'Medical Devices & Tech' AND Symbol != '' AND Symbol != 'private' AND Exchange = '.PK' ";
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
$Symbol="$Symbol$Exchange";  
// Stock symbols.   
$symbols = array($Symbol);   
$i = 0;   
// Declare class.   
$quote = new yahoo; // new stock.   
// Loop thru array of symbols.   
// echo "<ul>\n";   

// foreach ($symbols as $Symbol) {   
$quote->get_stock_quote($symbols[$i++]); // Pass the Company's symbol.    
echo "<a href=\"http://finance.yahoo.com/q?s=" .$symbol. "\" title=\"Yahoo! Finance: " .$symbol.    
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
// } // endforeach   

//if (($quote->last) == 'N/A')
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
<html>
<head>
<!-- meta HTTP-EQUIV="REFRESH" content="10; url=http://calendar.yahoo.com/eai04" -->
</head>
<body><?php
$db = @mysql_connect("localhost", "onemedpl_hcid", "219eastred")
		or die("Temporarily unable to connect with the database."); 
mysql_select_db("onemedpl_HCIDS",$db); 
?></body>
</html>