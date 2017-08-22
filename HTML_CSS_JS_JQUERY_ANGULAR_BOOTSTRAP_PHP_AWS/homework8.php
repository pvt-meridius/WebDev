<?php

	header("Access-Control-Allow-Origin: *");

if($_GET["action"] == "leg") {
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/legislators?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=all";
    $requestLegislator = "http://104.198.0.197:8080/legislators?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=all";

	$contents = file_get_contents($requestLegislator);
	echo $contents;

   
}

if($_GET["action"] == "bill") {
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/bills?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=50";
    
    $requestLegislator = "http://104.198.0.197:8080/bills?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=50";

	$contents = file_get_contents($requestLegislator);
	echo $contents;

}

if($_GET["action"] == "commit") {
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/committees?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=all";
    	$requestLegislator = "http://104.198.0.197:8080/committees?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=all";

	$contents = file_get_contents($requestLegislator);
	echo $contents;

}



if($_GET["action"] == "commitLeg") {
    $bioGuide = $_GET['searchVal'];
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/committees?member_ids=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=5";
    $requestLegislator = "http://104.198.0.197:8080/committees?member_ids=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=5";

	$contents = file_get_contents($requestLegislator);
	echo $contents;
}


if($_GET["action"] == "detailLeg") {
    $bioGuide = $_GET['searchVal'];
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/committees?member_ids=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=5";
    $requestLegislator = "http://104.198.0.197:8080/legislators?bioguide_id=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=all";

	$contents = file_get_contents($requestLegislator);
	echo $contents;
}

if($_GET["action"] == "billLeg") {
    $bioGuide = $_GET['searchValBill'];
//	$requestLegislator = "http://congress.api.sunlightfoundation.com/bills?sponsor_id=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=5";
    $requestLegislator = "http://104.198.0.197:8080/bills?sponsor_id=".$bioGuide."&apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=5";

	$contents = file_get_contents($requestLegislator);
	echo $contents;
}


// else if($_GET["action"] == "bill") {
 
// 	$requestBill = "https://congress.api.sunlightfoundation.com/bills?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=50";
// 	$contentsBill = file_get_contents($requestBill);
// 	echo $contentsBill;

// }


// else if {
// 	$requestBills = "https://congress.api.sunlightfoundation.com/bills?apikey=e6d195c674c749f1b05f1a7e346962ed&per_page=50";
// 	$contents = file_get_contents($requestBills);
// }

// else if{
// 	$requestCommittees = "https://congress.api.sunlightfoundation.com/committees?apikey=YOUR_API_KEY_HERE&per_page=all";
// 	$contents = file_get_contents($requestCommittees);
// }

?>