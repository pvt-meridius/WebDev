<?php
$hello = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas', 
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming');
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
                if ( congressCheck !== null && congressCheck.value === "" || congressCheck.value === "Select your option"){
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
                document.getElementById("myForm").reset();
                document.getElementById("keyword").innerHTML = "Keyword*"; 
            }
        </script>
    </head>
    <body>
        <div align="center">
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
                                <option value="legislators">Legislators</option>
                                <option value="committees">Committees</option>
                                <option value="bills">Bills</option>
                                <option value="amendments">Amendments</option>
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
                                <label><input checked = true type="radio" name="radioVal" value = "senate">Senate</label>
                                <label><input type="radio" name="radioVal" value = "house">House</label>
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
                                <input type="text" name="keyword"> 
                            </div>  
                        
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td align="right" style="margin-top:1px; text-align:right">
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
        <div align="center">

        <?php
            if (isset($_POST['searchButton'])  &&  !empty($_POST["keyword"]) && $_POST["congress"] != "default")
            {
                
                $state = array_search( $_POST['keyword'],$hello);
                $chamber = $_POST['radioVal'];
                $database = $_POST['congress'];    

                $request = "http://congress.api.sunlightfoundation.com/".$database."?chamber=".$chamber."&state=".$state."&apikey=e6d195c674c749f1b05f1a7e346962ed";
                $response  = file_get_contents($request);
                $jsonobj  =  json_decode($response, TRUE);

                //echo isset($jsonobj);
                //document.getElementById("keyword").innerHTML = "test";

                if (isset($jsonobj)) {

                    echo "<table><table border='1'>"; 
                    echo "<tr><th>Name</th><th>State</th><th>Chamber</th><th>Details</th></tr>";
                    for ($x = 0; $x < count($jsonobj["results"]); $x++) {
                            
                        echo "<tr><td>" .$jsonobj['results'][$x]["first_name"]. " " .$jsonobj['results'][$x]["last_name"],"</td>"; 
                        echo "<td>" .$jsonobj['results'][$x]["state"],"</td>"; 
                        echo "<td>" .$jsonobj['results'][$x]["chamber"],"</td>"; 
                        $a = $jsonobj['results'][$x]["bioguide_id"];
                        echo "<td><a href='homework6.php?moreInfo=$a'>View Details</a></td></tr>"; 

                    }
                }
                else{
                    echo "Bad Input";
                }
             }
            ?>
        </div>
        <div>
            <?php
                if (isset($_GET['moreInfo'])) {
                    $b = $_GET['moreInfo'];
                    moreInfo($b);
                }

                function moreInfo($b) {
                    $request = "http://congress.api.sunlightfoundation.com/legislators?chamber=house&state=WA&bioguide_id=$b&apikey=e6d195c674c749f1b05f1a7e346962ed";
                    $response  = file_get_contents($request);
                    $jsonobj  =  json_decode($response, TRUE);

                    echo ($jsonobj["results"][0]["title"]);
                    echo ($jsonobj["results"][0]["first_name"]);
                    echo ($jsonobj["results"][0]["last_name"]);
                    echo ($jsonobj["results"][0]["term_end"]);
                    echo ($jsonobj["results"][0]["website"]);
                    echo ($jsonobj["results"][0]["office"]);
                    echo ($jsonobj["results"][0]["facebook_id"]);
                    echo ($jsonobj["results"][0]["twitter_id"]);
                    
                    // https://theunitedstates.io/images/congress/225x275/N000189.jpg
                    // echo "<div style='border-style:solid'>"
                    // echo "<img src='smiley.gif' >"  
                }
            ?>
        </div>
    </body>
</html>
