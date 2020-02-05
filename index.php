<!-- 
	This is scraping for information in Tadawul website to compare all mutual funds together easly,
	I'm using simple_html_dom.php to do the scraping, and datatable to add advance interaction to the table.

	When running this code it'll take several minutes to complete, or more depending on your internet connection 
	and Tadawul website server
-->
<!DOCTYPE html>
<html>
<head>
	<title>Web Scraping: Mutual funds from Tadawul with PHP</title>

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- importing datatable will add advance interaction to the table -->
	<script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

	<!-- special css styling -->
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

<div class="container">
	<?php
	
	include('simple_html_dom.php');

	//URL that contains funds table in Tadawul website
	$tadawul = "https://www.tadawul.com.sa/wps/portal/tadawul/markets/funds/funds.mutualFunds/fund-details/!ut/p/z1/pZJBT8IwGIZ_Cweu7cfGxvBWUWGKIkFh9GI6VgpktEvXMfHX26EeTGCQ0EvT5HnefPneYoojTCXbrQUzayVZat9z6n94xAdnEMAo6HXvYew_3ZHBreeC4-FZLRAAptf4cKHvOL2g1W3DsB--dICMyWD6MH1zoe9e50P7Mh9OHHJ2_kdMRarin1WvjMlumtAEwxJWFinimdKGpWhbmMJey0ImTRtpWBzKhH_iqHVMq5Ccp3xheNJjhgul989MMsF1mFgHzlqjrOr_N57I2A0EppovueYaFdoOW9n5QS_LEgmlRMrRQm1tyhFlpXKDo_-kXR2t3U71eWoB-APq6q8Fqn4PQE2Bc9tw5-QMrz6eVBkbtmOfqKor5QaxHM9beMIlzrbv9kRfQz4LjBfvXViHGy_blaTR-AZ66hZx/p0/IZ7_5A602H80O8C9E0Q6KDAHB530P6=CZ6_5A602H80O8C9E0Q6KDAHB53025=LA0=/";

	//first request to get table header and all companies IDs
	$firstRequest = file_get_html($tadawul);

   	echo "<table id='table'>";
   	echo "<thead>";
   	echo "<tr>";          /* getting the table header label for each column */
	echo     "<th>#</th>   
			  <th> ".$firstRequest->find('#table12 th')[0]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[1]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[2]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[3]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[4]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[5]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[6]->plaintext." </th> 
			  <th> ".$firstRequest->find('#table12 th')[7]->plaintext." </th>";
   	echo "</tr>";
   	echo "</thead>";
	echo "<tbody>";
	$i = 1; //initial index value for indexing each row

	//loop through each ID in <optoin> tag inside <select> tag from $firstRequest, which it's the number of companies
	foreach($firstRequest->find('select option') as $option){

   		//second request to get all mutual funds for each company, by attaching the ID in GET request 
   		$secondRequest = file_get_html($tadawul."?managerCategorySelectionId=".$option->value);
		
		//loop through each each row
		foreach ($secondRequest->find('#table12 tbody tr') as $keys) {
			echo "<tr>";
			echo "<td>".($i++)."</td>"; //print a cell contains index value, then increment it
			//loop through each cell, which it will contains "<td> ... </td>"
		 	foreach($keys->find('td') as $key){
        		echo $key;
	       }
	       echo "</tr>";
		}
   	}
	echo "</tbody>";
	echo "</table>";
	?>
</div>
	
<script>
	$(document).ready( function (){
		$('#table').DataTable(); //tell datatable to do its magic
	});
</script>

</body>
</html>