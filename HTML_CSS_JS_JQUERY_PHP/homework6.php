<?php
$hello = array(
    'AL'=>'alabama',
    'AK'=>'alaska',
    'AZ'=>'arizona',
    'AR'=>'arkansas',
    'CA'=>'california',
    'CO'=>'colorado',
    'CT'=>'connecticut',
    'DE'=>'delaware',
    'DC'=>'district of columbia',
    'FL'=>'florida',
    'GA'=>'georgia',
    'HI'=>'hawaii',
    'ID'=>'idaho',
    'IL'=>'illinois',
    'IN'=>'indiana',
    'IA'=>'iowa',
    'KS'=>'kansas',
    'KY'=>'kentucky',
    'LA'=>'louisiana',
    'ME'=>'maine',
    'MD'=>'maryland',
    'MA'=>'massachusetts',
    'MI'=>'michigan',
    'MN'=>'minnesota',
    'MS'=>'mississippi',
    'MO'=>'missouri',
    'MT'=>'montana',
    'NE'=>'nebraska',
    'NV'=>'nevada',
    'NH'=>'new hampshire',
    'NJ'=>'new jersey',
    'NM'=>'new mexico',
    'NY'=>'new york',
    'NC'=>'north carolina',
    'ND'=>'north dakota',
    'OH'=>'ohio',
    'OK'=>'oklahoma',
    'OR'=>'oregon',
    'PA'=>'pennsylvania',
    'RI'=>'rhode island',
    'SC'=>'south carolina',
    'SD'=>'south dakota',
    'TN'=>'tennessee',
    'TX'=>'texas', 
    'UT'=>'utah',
    'VT'=>'vermont',
    'VA'=>'virginia',
    'WA'=>'washington',
    'WV'=>'west virginia',
    'WI'=>'wisconsin',
    'WY'=>'wyoming');
?>

<html>
    <head>
        <title>Homework6</title>
        <style type="text/css">
            .fieldset-auto-width {
                 display: inline-block;
            }
            table {
                border: 1px solid black;
            }
        </style>
        <script>
            function CheckForm(form){
                var missingFormValues = new Array();
                
                var congressCheck = form.congress;
                if ( congressCheck !== null && congressCheck.value === "" || congressCheck.value === "default"){
                    missingFormValues.push(" Congress database");
                }
                
                if  (form.radioVal !== null && form.radioVal.value === ""){
                    missingFormValues.push(" chamber");
                }
                
                var keywordCheck = form.keyword;
                if ( keywordCheck !== null && keywordCheck.value === ""){
                    missingFormValues.push(" keyword");
                }
                
                if (missingFormValues.length > 0){
                    alert("Please enter the following missingFormValues information: " + missingFormValues);
                } 
                else {
                    //alert("api call about to be called");
                }
            }    
            
            function ChangeText(text){
                document.getElementById("keywordText").value = ""; 
                
                if (text == "legislators"){
                   document.getElementById("keyword").innerHTML = "State/Representative*"; 
                }
                else if (text == "committees"){
                   document.getElementById("keyword").innerHTML = "Committee ID*"; 
                }
                else if (text == "bills"){
                   document.getElementById("keyword").innerHTML = "Bill ID*"; 
                }
                else  if (text == "amendments"){
                   document.getElementById("keyword").innerHTML = "Amendment ID*"; 
                }
                else{
                    document.getElementById("keyword").innerHTML = "Keyword*"; 
                }
            }

               function ChangeKeyText(){
                var text = document.getElementById("dropdown").value;

                if (text == "legislators"){
                   document.getElementById("keyword").innerHTML = "State/Representative*"; 
                }
                else if (text == "committees"){
                   document.getElementById("keyword").innerHTML = "Committee ID*"; 
                }
                else if (text == "bills"){
                   document.getElementById("keyword").innerHTML = "Bill ID*"; 
                }
                else  if (text == "amendments"){
                   document.getElementById("keyword").innerHTML = "Amendment ID*"; 
                }
                else{
                    document.getElementById("keyword").innerHTML = "Keyword*"; 
                }
            }

            function Clear() {
                // window.location.reload();
                document.getElementById("myForm").reset();
                document.getElementById("keyword").innerHTML = "Keyword*"; 
                document.getElementById("keywordText").value = "";
                document.getElementById("content").innerHTML = "";
                document.getElementById("dropdown").value = "default";
            }

            function ViewLegislatorDetails(input){
                var jsonFile = JSON.parse(input);
                var results = "<div style='margin: auto; width: 60%; border: 1px solid; padding: 10px;'>";

                var bioGuide = jsonFile['results'][0]["bioguide_id"];
                var firstname = jsonFile["results"][0]["first_name"];
                var lastname = jsonFile["results"][0]["last_name"];
                var title = jsonFile["results"][0]["title"];
                var term = jsonFile["results"][0]["term_end"];
                var website = jsonFile["results"][0]["website"];
                var office = jsonFile["results"][0]["office"];

                var facebook = jsonFile["results"][0]["facebook_id"];
                var twitter = jsonFile["results"][0]["twitter_id"];

                var tw = "<tr><td>Twitter</td><td><a href=https://twitter.com/"+twitter+">"+firstname+" "+lastname+"</td></tr>"; 
                if (twitter == null){
                    tw = "<tr><td>Twitter</td><td><a href=''>NA</td></tr>";
                }

                var fb = "<tr><td>Facebook</td><td><a href=https://www.facebook.com/"+facebook+">"+firstname+" "+lastname+"</a></td></tr>";
                if (facebook == null){
                    tw = "<tr><td>Facebook</td><td><a href=''>NA</td></tr>";
                }

                results += "<table align='center' style='border:none;'>";
                results += "<img src = 'https://theunitedstates.io/images/congress/225x275/"+bioGuide+".jpg' align='middle'>";
                results += "<tr><td style='width: 200;'>Full Name</td><td>"+title+" "+firstname+" "+lastname+"</td></tr>"
                results += "<tr><td>Term Ends on</td><td>"+term+"</td></tr>";
                results += "<tr><td>Website</td><td><a href='"+website+"'>"+website+"</a></td></tr>";
                results += "<tr><td>Office</td><td>"+office+"</td></tr>";
                results += fb;
                results += tw;
                results += "</table";
                results += "</div>";

                document.getElementById("content").innerHTML = results;
                return false;   
                


            }

            function ViewDetails(input){
                var jsonFile = JSON.parse(input);
                var results = "<div style='margin: auto; width: 60%; border: 1px solid; padding: 10px;'>";

                var billID = jsonFile['results'][0]['bill_id'];
                var billShortTitle = jsonFile['results'][0]["short_title"];
                var billTitle = jsonFile['results'][0]["sponsor"]["title"];
                var billFN = jsonFile['results'][0]["sponsor"]["first_name"];
                var billLN = jsonFile['results'][0]["sponsor"]["last_name"];
                var billIntro = jsonFile['results'][0]["introduced_on"];
                var billV = jsonFile['results'][0]["last_action_at"];
                var billURL = jsonFile['results'][0]["last_version"]["urls"]["pdf"];


                results += "<table align='center' style='border:none;'>";
                results += "<tr><td style='width: 300;'>Bill ID</td><td>"+billID+"</td></tr>";
                results += "<tr><td>Bill Title</td><td>"+billShortTitle+"</td></tr>";
                results += "<tr><td>Sponsor</td><td>"+billTitle+" "+billFN+" "+billLN+"</td></tr>";
                results += "<tr><td>Introduced On</td><td>"+billIntro+"</td></tr>";
                results += "<tr><td>Last action with date</td><td>"+billV+"</td></tr>";
                results += "<tr><td>Bill URL</td><td><a href ="+billURL+">"+billShortTitle+"</a></td></tr>";

                results += "</table";
                results += "</div>";

                document.getElementById("content").innerHTML = results;
                return false;   
            }
        </script>
    </head>
    <body onload="ChangeKeyText()";>
        <div align="center">
            <?php
                // define variables and set to empty values
                $name = $gender = $keyword = $radioVal = $congress = "";
               

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                  if (empty($_POST["radioVal"])) {
                    
                  } else {
                    $radioVal = test_input($_POST["radioVal"]);
                  }

                if (empty($_POST["congress"])) {
                    
                  } else {
                    $congress = test_input($_POST["congress"]);
                  }

                  if (empty($_POST["keyword"])) {
                    
                  } else {
                    $keyword = test_input($_POST["keyword"]);
                  }

                }

                function test_input($data) {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
                }

            ?>



            <h1>Congress Information Search</h1>
            <form id="myForm" action="" method="post">
                <table> 
                    <tr>
                        <td>
                            <div align = "center" style="margin:1px; display: inline-block;">
                            Congress Database 
                            </div>
                        </td>
                        <td>
                            <div align = "right" style="margin:1px; display: inline-block;">

                                <select id = "dropdown" name="congress" onchange="ChangeText(this.value)">
                                    <option selected="selected" value = "default">Select your option</option>
                                    <option value="legislators" <?php if (isset($congress) && $congress=="legislators") echo "selected";?>>Legislators</option>
                                    <option value="committees" <?php if (isset($congress) && $congress=="committees") echo "selected";?>>Committees</option>
                                    <option value="bills" <?php if (isset($congress) && $congress=="bills") echo "selected";?>>Bills</option>
                                    <option value="amendments" <?php if (isset($congress) && $congress=="amendments") echo "selected";?>>Amendments</option>
                                </select>
                            </div>
                        </td>
                    </tr>      
                    <tr>
                        <td>
                            <div align = "center" style="margin:1px; text-align:center;">
                                Chamber
                            </div>
                        </td>
                        <td>
                            <div align = "right" style="margin:1px; text-align:center;">
                                <label><input checked = true type="radio" name="radioVal" value = "senate" <?php if (isset($radioVal) && $radioVal=="senate") echo "checked";?>>Senate</label>
                                <label><input type="radio" name="radioVal" value = "house" <?php if (isset($radioVal) && $radioVal=="house") echo "checked";?>>House</label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div align = "left" style="margin:2px; text-align:center;">
                                <label name ="keyword" id ="keyword">Keyword*</label>
                            </div>
                        </td>
                   
                        <td>
                            <div align = "right" style="margin:1px;">
                                <input type="text" id = "keywordText" name="keyword" value="<?php echo $keyword;?>"> 
                            </div>  
                        
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align="center" style="margin-top:1px; text-align:center">
                            <div>
                                <label><input name = "searchButton" id = "searchButton" type="submit" value="Search" onclick="CheckForm(this.form)"></label>
                                <label><input type="button" onclick="Clear()" value="Clear"></label>  
                            </div>
                        </td>
                    </tr>
                    
                    <tr style="text-align:center">
                        <td colspan="2">
                            <a href="http://sunlightfoundation.com/">Powered by Sunglight Foundation</a>
                        </td>
                    </tr>
                </table>  
            </form>
        </div>
        <div align="center" id="content">

        <?php

        $passedArray = array();

        if ( isset($_POST['searchButton']) && !empty($_POST["keyword"]) && $_POST["congress"] != "default")
        { 
            if (ltrim($_POST["keyword"]) == $_POST["keyword"]){
                    $state = array_search(strtolower($_POST['keyword']),$hello);
                    $name = $_POST['keyword'];
                    $chamber = $_POST['radioVal'];
                    $database = $_POST['congress']; 

                    $requestQuery= "";
                    $nameSplit = explode(" ", $name);

                    if (count($nameSplit) > 1){
                        $requestQueryF = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&query=".$nameSplit[0]."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                        $responseF  = file_get_contents($requestQueryF);
                        $jsonobjF  =  json_decode($responseF, TRUE);


                        $requestQueryN = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&query=".$nameSplit[1]."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                        $responseN  = file_get_contents($requestQueryN);
                        $jsonobjN  =  json_decode($responseN, TRUE);

                        $lengthN = count($jsonobjF["results"]);
                        $lengthF =  count($jsonobjN["results"]);


                        if (count($jsonobjF["results"])>0 || count($jsonobjN["results"])>0)
                        {
                            for ($i = 0; $i<$lengthN; $i++) {
                                for ($j = 0; $j<$lengthF; $j++) {
                                     if ($jsonobjF['results'][$i]["bioguide_id"] == $jsonobjN['results'][$j]["bioguide_id"]){

                                        $matchBio = $jsonobjF['results'][$i]["bioguide_id"];
                                        $matchState = $jsonobjF['results'][$i]["state"];
                                        $requestQuery = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&state=".$matchState."&bioguide_id=".$matchBio."&apikey=e6d195c674c749f1b05f1a7e346962ed";

                                    }
                                }
                            }
                        }else{
                            echo "The API returned zero results for the request.";
                        }
                    }else{
                        $requestQuery = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&query=".$nameSplit[0]."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                    }

                    if ($database == "legislators"){

                        if (isset($hello[$state])) {
           
                            $request = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&state=".$state."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                            $response  = file_get_contents($request);
                            $jsonobj  =  json_decode($response, TRUE);

                            if (count($jsonobj["results"])>0){

                                echo "<table border='1'>"; 
                                echo "<tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                                for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                                        
                                    echo "<tr><td style='text-align: center;'>" .$jsonobj['results'][$x]["first_name"]. " " .$jsonobj['results'][$x]["last_name"],"</td>"; 
                                    echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["state"],"</td>"; 
                                    echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["chamber"],"</td>"; 
                                    $a = $jsonobj['results'][$x]["bioguide_id"];

                                    $requestBio = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&state=".$state."&bioguide_id=".$a."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                                    $response  = file_get_contents($requestBio);
                                    $passedArray = json_encode($response, TRUE);

                                    //ViewLegislatorDetails

                                    //echo "<td><a href='homework6.php?moreInfo=".$a."&state=".$state."&chamber=".$chamber."&database=".$database."'>View Details</a></td></tr>"; 
                                    echo "<td style='text-align: center;'><a href='' onclick='return ViewLegislatorDetails(".$passedArray.")'>View Details</a></td></tr>"; 

                                }
                                echo"</table>";
                            }
                        }else if ($requestQuery != ""){ 
         
                            $response  = file_get_contents($requestQuery);
                            $jsonobj  =  json_decode($response, TRUE);
                            $passedArray = json_encode($response, TRUE);

                            if (count($jsonobj["results"])>0){
                                echo "<table><table border='1'>"; 
                                echo "<tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                                for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                                        
                                    echo "<tr><td style='text-align: center;'>" .$jsonobj['results'][$x]["first_name"]. " " .$jsonobj['results'][$x]["last_name"],"</td>"; 
                                    echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["state"],"</td>"; 
                                    echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["chamber"],"</td>"; 
                                    $a = $jsonobj['results'][$x]["bioguide_id"];

                                    $requestBio = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&state=".$state."&bioguide_id=".$a."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                                    $response  = file_get_contents($requestBio);
                                    $passedArray = json_encode($response, TRUE);

                                    // echo "<td><a href='homework6.php?moreInfo=".$a."&state=".$state."&chamber=".$chamber."&database=".$database."'>View Details</a></td></tr>";
                                    echo "<td style='text-align: center;'><a href='' onclick='return ViewLegislatorDetails(".$passedArray.")'>View Details</a></td></tr>"; 
 
                                }
                            }
                            else{
                                echo "The API returned zero results for the request.";
                            }
                        }else {
                            echo "The API returned zero results for the request.";
                        }
                    }else if ($database == "committees") {
                        $request = "http://congress.api.sunlightfoundation.com/".$database."?committee_id=".strtoupper($name)."&chamber=".$chamber."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                        $response  = file_get_contents($request);
                        $jsonobj  =  json_decode($response, TRUE);
                        $passedArray = json_encode($response, TRUE);

                        if (count($jsonobj["results"])>0){
                            echo "<table border='1'>"; 
                            echo "<tr><th>Committee ID</th><th>Committee Name</th><th>Chamber</th></tr>";
                            for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                                    
                                echo "<tr><td style='text-align: center;'>".$jsonobj['results'][$x]["committee_id"]."</td>"; 
                                echo "<td style='text-align: center;'>".$jsonobj['results'][$x]["name"],"</td>"; 
                                echo "<td style='text-align: center;'>".$jsonobj['results'][$x]["chamber"],"</td>"; 

                            }
                            echo"</table>";
                        }else{
                            echo "The API returned zero results for the request.";
                        }
                    }else if ($database == "bills") {
                        $request = "http://congress.api.sunlightfoundation.com/".$database."?bill_id=".strtolower($name)."&chamber=".$chamber."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                        $response  = file_get_contents($request);
                        $jsonobj  =  json_decode($response, TRUE);
                        //$passedArray = json_encode($response, TRUE);


                        if (count($jsonobj["results"])>0){
                            echo "<table border='1'>"; 
                            echo "<tr><th>Bill ID</th><th>Short Title</th><th>Chamber</th><th>Details</th></tr>";
                            for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                                    
                                echo "<tr><td style='text-align: center;'>" .$jsonobj['results'][$x]["bill_id"]."</td>"; 
                                echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["short_title"],"</td>"; 
                                echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["chamber"],"</td>"; 

                                $passedArray = json_encode($response, TRUE);
                                

                                $billId = $jsonobj['results'][$x]["bill_id"];
                                $billShortTitle = $jsonobj['results'][$x]["short_title"];
                                $billTitle = $jsonobj['results'][$x]["sponsor"]["title"];
                                $billFN = $jsonobj['results'][$x]["sponsor"]["first_name"];
                                $billLN = $jsonobj['results'][$x]["sponsor"]["last_name"];
                                $billIntro = $jsonobj['results'][$x]["introduced_on"];
                                $billV = $jsonobj['results'][$x]["last_action_at"];
                                //$billURL =$jsonobj['results'][$x]["bill_id"];

                               //echo "<td><a href='homework6.php?billsReady=".$billId."&billShortTitle=".$billShortTitle."&billTitle=".$billTitle."&billFN=".$billFN."&billLN=".$billLN."&billIntro=".$billIntro."&billV=".$billV."'>View Details</a></td></tr>"; 
                                echo "<td><a href='' onclick='return ViewDetails(".$passedArray.")'>View Details</a></td></tr>"; 

                                echo"</table>";
                            }
                        }else{
                            echo "The API returned zero results for the request.";
                        }
                    }else if ($database == "amendments") {
                        $request = "http://congress.api.sunlightfoundation.com/".$database."?amendment_id=".strtolower($name)."&chamber=".$chamber."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                        $response  = file_get_contents($request);
                        $jsonobj  =  json_decode($response, TRUE);
                        $passedArray = json_encode($response, TRUE);


                        if (count($jsonobj["results"])>0){
                            echo "<table border='1'>"; 
                            echo "<tr><th>Amendment ID</th><th>Amendment Type</th><th>Chamber</th><th>Introduced On</th></tr>";
                            for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                                    
                                echo "<tr><td style='text-align: center;'>" .$jsonobj['results'][$x]["amendment_id"]."</td>"; 
                                echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["amendment_type"],"</td>"; 
                                echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["chamber"],"</td>"; 
                                echo "<td style='text-align: center;'>" .$jsonobj['results'][$x]["introduced_on"],"</td>"; 

                            }
                            echo"</table>";
                        }else{
                            echo "The API returned zero results for the request.";
                        }
                    }else{
                        echo "The API returned zero results for the request.";
                    }
                }else{
                    echo "The API returned zero results for the request.";
                }
        }

            if (isset($_GET['billsReady'])) {
                            $billId = $_GET['billsReady'];
                            $billShortTitle = $_GET['billShortTitle'];
                            $billTitle = $_GET['billTitle'];
                            $billFN = $_GET['billFN'];
                            $billLN = $_GET['billLN'];
                            $billIntro = $_GET['billIntro'];
                            $billV = $_GET['billV'];

                    echo "<div style='margin: fauto; width: 60%; border: 1px solid; padding: 10px;'>";

                    echo "<table align='center' style='border:none;'>";

                    echo "<tr><td style='width: 300;'>Bill ID</td><td>".$billId."</td></tr>";
                    echo "<tr><td>Bill Title</td><td>".$billShortTitle."</td></tr>";
                    echo "<tr><td>Sponsor</td><td>".$billTitle." ".$billFN." ".$billLN."</a></td></tr>";
                    echo "<tr><td>Introduced On</td><td>".$billIntro."</td></tr>";
                    echo "<tr><td>Last action with date</td><td>".$billV."</td></tr>";

                    echo "</table";
                    echo "</div></br>";        

            }

            if (isset($_GET['moreInfo'])) {
                    $b = $_GET['moreInfo'];
                    $state = $_GET['state'];
                    $chamber = $_GET['chamber'];
                    $database = $_GET['database'];

                    moreInfo($b,$state,$chamber,$database);
            }

            function moreInfo($bio,$st,$cham,$db) {

                    $request = "http://congress.api.sunlightfoundation.com/".$db."?chamber=".$cham."&state=".$st."&bioguide_id=".$bio."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                    $response  = file_get_contents($request);
                    $jsonobj  =  json_decode($response, TRUE);


                    $firstname = $jsonobj["results"][0]["first_name"];
                    $lastname = $jsonobj["results"][0]["last_name"];
                    $title = $jsonobj["results"][0]["title"];
                    $term = $jsonobj["results"][0]["term_end"];
                    $website = $jsonobj["results"][0]["website"];
                    $facebook = $jsonobj["results"][0]["facebook_id"];
                    $twitter = $jsonobj["results"][0]["twitter_id"];
                    $office = $jsonobj["results"][0]["office"];


                    echo "<div style='margin: fauto; width: 80%; border: 1px solid; padding: 10px;'>";
                    echo "<img src = 'https://theunitedstates.io/images/congress/225x275/".$bio.".jpg' align='middle'>";
                    echo "</br>";

                    echo "<table align='center' style='border:none;'>";

                    echo "<tr><td style='width: 200;'>Full Name</td><td>".$title." ".$firstname." ".$lastname."</td></tr>";
                    echo "<tr><td>Term Ends on</td><td>".$term."</td></tr>";
                    echo "<tr><td>Website</td><td><a href='".$website."'>".$website."</a></td></tr>";
                    echo "<tr><td>Office</td><td>".$office."</td></tr>";
                    echo "<tr><td>Facebook</td><td><a href=https://www.facebook.com/".$facebook.">".$firstname." ".$lastname."</a></td></tr>";
                    echo "<tr><td>Twitter</td><td><a href=https://twitter.com/".$twitter.">".$firstname." ".$lastname."</td></tr>";

                    echo "</table";
                    echo "</div></br>";        
            }

            ?>
        </div>
        <div>
        </div>

    </body>
</html>
