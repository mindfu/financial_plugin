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

        $sql = "SELECT * FROM `master2` WHERE `Research_Sector` = 'Medical Devices & Tech' AND Symbol != '' AND Symbol != 'private'";
        $result = mysql_query($sql, $db);
        if ($myrow = mysql_fetch_array($result)) {
        do {

$CompanyID = $myrow["CompanyID"];
$SubDiv_ID = $myrow["SubDiv_ID"];
$Company = $myrow["Company"]; 
$Address = $myrow["Address"];
$City = $myrow["City"];
$State = $myrow["State"]; 
$Country = $myrow["Country"];
$Zip = $myrow["Zip"]; 
$Phone = $myrow["Phone"];
$Fax = $myrow["Fax"]; 
$Email = $myrow["Email"]; 
$www = $myrow["www"];
$Symbol = $myrow["Symbol"]; 
$Exchange = $myrow["Exchange"]; 
$Mkt_Capitalization = $myrow["Mkt_Capitalization"];
$Employees = $myrow["Employees"]; 
$Descrip = $myrow["Descrip"];
$Summary_Descrip = $myrow["Summary_Descrip"];
$Keywords = $myrow["Keywords"];
$Management = $myrow["Management"]; 
$Organization = $myrow["Organization"];
$Profile_Type = $myrow["Profile_Type"];
$Research_Sector = $myrow["Research_Sector"];
$Cat_Levell = $myrow["Cat_Levell"];
$Cat_Levelll = $myrow["Cat_Levelll"];
$Cat_Levellll = $myrow["Cat_Levellll"];
$Gen_Cat = $myrow["Gen_Cat"];
$Spec_CatA = $myrow["Spec_CatA"];
$Spec_CatB = $myrow["Spec_CatB"];
$Spec_CatC = $myrow["Spec_CatC"];
$Investment_Portal = $myrow["Investment_Portal"];
$MicroCap_Portal = $myrow["MicroCap_Portal"];
$MA_Ad = $myrow["MA_Ad"];
$logo = $myrow["logo"];
$Member_Start_Date = $myrow["Member_Start_Date"];
$Member_Level = $myrow["Member_Level"]; 
$Member_Priority = $myrow["Member_Priority"]; 
$Priority = $myrow["Priority"]; 
$issue = $myrow["issue"];
$login = $myrow["login"];
$pass = $myrow["pass"];
$passwd_assigned = $myrow["passwd_assigned"];
$Approved = $myrow["Approved"];
$Created = $myrow["Created"];
$Created_By = $myrow["Created_By"];
$Updated = $myrow["Updated"];
$Updated_By = $myrow["Updated_By"];
$Research_SubCat = $myrow["Research_SubCat"];
$last = $myrow["last"];
$change = $myrow["change"];

  
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

$ssql = "UPDATE `master` SET `CompanyID` = '$CompanyID', 
`SubDiv_ID` = '$SubDiv_ID',
`Company` = '$Company', 
`Address` = '$Address', 
`City` = '$City', 
`State` = '$State', 
`Country` = '$Country', 
`Zip` = '$Zip', 
`Phone` = '$Phone', 
`Fax` = '$Fax', 
`Email` = '$Email', 
`www` = '$www', 
`Symbol` = '$Symbol', 
`Exchange` = '$Exchange', 
`Mkt_Capitalization` = '$Mkt_Capitalization', 
`Employees` = '$Employees', 
`Descrip` = '$Descrip', 
`Summary_Descrip` = '$Summary_Descrip', 
`Keywords` = '$Keywords', 
`Management` = '$Management', 
`Organization` = '$Organization', 
`Profile_Type` = '$Profile_Type', 
`Research_Sector` = '$Research_Sector', 
`Cat_Level1` = '$Cat_Levell',
`Cat_Levelll` = '$Cat_Levelll',
`Cat_Levellll` = '$Cat_Levellll',
`Gen_Cat` = '$Gen_Cat', 
`Spec_CatA` = '$Spec_CatA', 
`Spec_CatB` = '$Spec_CatB', 
`Spec_CatC` = '$Spec_CatC', 
`Investment_Portal` = '$Investment_Portal', 
`MicroCap_Portal` = '$MicroCap_Portal', 
`MA_Ad` = '$MA_Ad', 
`logo` = '$logo', 
`Member_Start_Date` = '$Member_Start_Date', 
`Member_Level` = '$Member_Level', 
`Member_Priority` = '$Member_Priority', 
`Priority` = '$Priority', 
`issue` = '$issue', 
`login` = '$login', 
`pass` = '$pass', 
`passwd_assigned` = '$passwd_assigned', 
`Approved` = '$Approved', 
`Created` = '$Created', 
`Created_By` = '$Created_By', 
`Updated` = '$Updated', 
`Updated_By` = '$Updated_By', 
`Research_SubCat` = '$Research_SubCat', 
`last` = '$last', 
`change` = '$change'";


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
<body></body>
</html>