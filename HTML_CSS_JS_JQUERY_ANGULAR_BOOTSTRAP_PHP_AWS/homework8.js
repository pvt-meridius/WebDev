
// Gets  the data and store it into $resource 
var app = angular.module('data', ['angularUtils.directives.dirPagination']);

app.run(function($rootScope){
    $rootScope.LegislatorFavoriteGloabldata = JSON.parse(localStorage.getItem('LegiKey'));
    $rootScope.CommitteeFavoriteGloabldata = JSON.parse(localStorage.getItem('CommiKey'));
    $rootScope.BillsFavoriteGloabldata = JSON.parse(localStorage.getItem('BillsKey'));
});


//var JSONtest = {"employees":[
//    {"firstName":"John", "lastName":"Doe"},
//    {"firstName":"Anna", "lastName":"Smith"},
//    {"firstName":"Peter", "lastName":"Jones"}
//]}
//
//
//sessionStorage.setItem("key",JSON.stringify(JSONtest));


app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});




app.filter('ifEmpty', function() {
    return function(input) {
    return (!!input) ? "District " + input : 'N.A';
    }
});


$(document).ready( function() {
 $('#imageCarousel').carousel();

});



 $(document).ready( function() {
    $('#l').click(function(){
        $('#title').html("Legislators")
        $('#page-container').show()
        $('#page-container2').hide()
        $('#page-container3').hide()
        $('#page-container4').hide()
         
    });
    $('#b').click(function(){
        $('#title').html("Bills")
        $('#page-container2').show()
        $('#page-container').hide()
        $('#page-container3').hide()
        $('#page-container4').hide()

        

    });
    $('#c').click(function(){
        $('#title').html("Committees")
        $('#page-container3').show()
        $('#page-container').hide()
        $('#page-container2').hide()
        $('#page-container4').hide()

         
    });
    $('#f').click(function(){
        $('#title').html("Favorites")
        $('#page-container4').show()
        $('#page-container').hide()
        $('#page-container2').hide()
        $('#page-container3').hide()
        
    });
    // OR //
 });


app.controller('legislatorCtrl', function($scope, $http, $rootScope) {
        
    var storageArray = [];

    $scope.isFav = function (){

        var tempStorage = JSON.parse(localStorage.getItem("LegiKey"));
        var localStroageInput = $rootScope.data;
        var selectedInputStorage = "";

        // check if there's data 
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                // finds our data 
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            //check if it's a repeat 
            tempStorage.forEach(function(input2){
                if(input2.bioguide_id == selectedInputStorage.bioguide_id){
                    repeatFlag = false;
                }                        
            });
            
            //its not a repeat 
            if (repeatFlag){
                return false; 
            }else{
                return true; 

            }
        }
    };
    

    var storageArray = [];
        
    $scope.favoriteLegislator = function(){
    
        var tempStorage = JSON.parse(localStorage.getItem("LegiKey"));
        var localStroageInput = $rootScope.data;
        var selectedInputStorage = "";

        
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            tempStorage.forEach(function(input2){
                if(input2.bioguide_id == selectedInputStorage.bioguide_id){
                    repeatFlag = false;
                }                        
            });
            
            if (repeatFlag){
                tempStorage.push(selectedInputStorage);
                $rootScope.LegislatorFavoriteGloabldata = tempStorage;
                localStorage.setItem("LegiKey",JSON.stringify(tempStorage));
            }else{
                var deletedData = JSON.parse(localStorage.getItem("LegiKey"));
                var count = 0;
                deletedData.forEach(function(input3){
                    if(input3.bioguide_id == selectedInputStorage.bioguide_id){
                        
                        deletedData.splice(count, 1);
                        $rootScope.LegislatorFavoriteGloabldata = deletedData;

                        localStorage.setItem("LegiKey",JSON.stringify(deletedData));
                    }
                    count++;
                });
            }
        }
        else{
            
            localStroageInput.forEach(function(input){
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }

            });
            
            if (selectedInputStorage != ""){
                storageArray.push(selectedInputStorage);
                $rootScope.LegislatorFavoriteGloabldata = storageArray;
                localStorage.setItem("LegiKey",JSON.stringify(storageArray));
            }
        }
        
    };
    
    $scope.dynamic = function(start,end){
        $scope.a = new Date();
        $scope.b = new Date(end);
        $scope.c = new Date(start);
        
        return Math.ceil((($scope.a-$scope.c)/($scope.b-$scope.c))*100);
    };
    
    
    $rootScope.updateBioguide = function(bGuide){
        $rootScope.bioGuide = bGuide;
        
        $http({
            method: 'GET',
            url: 'homework8.php',
            params: {action : 'commitLeg', searchVal :bGuide}}).then(function successCallback(response) {

            $rootScope.commitDataView = response.data.results;

            }, function errorCallback(response) {
        });
        
        
        $http({
            method: 'GET',
            url: 'homework8.php',
            params: {action : "billLeg", searchValBill: bGuide}}).then(function successCallback(response) {

            $rootScope.billDataView = response.data.results;

            }, function errorCallback(response) {
        });
        
        $http({
            method: 'GET',
            url: 'homework8.php',
            params: {action : "detailLeg", searchValBill: bGuide}}).then(function successCallback(response) {

            $rootScope.legiDetailView = response.data.results;

            }, function errorCallback(response) {
        });
        
        
    
    };
        
    
    $scope.changeLookUp = function(){
        $scope.lookUpValue = null;
    };
    
    $scope.whatParty = function(stateLetter){
        if (stateLetter == "R"){
            return "Republican";
        }
        else{
            return "Democrat";
        }
    };
    
    
    
    $scope.states = [{"AL": "Alabama","AK": "Alaska","AS": "American Samoa","AZ": "Arizona","AR": "Arkansas","CA": "California","CO": "Colorado","CT": "Connecticut","DE": "Delaware","DC": "District Of Columbia","FM": "Federated States Of Micronesia","FL": "Florida","GA": "Georgia","GU": "Guam","HI": "Hawaii","ID": "Idaho","IL": "Illinois","IN": "Indiana","IA": "Iowa","KS": "Kansas","KY": "Kentucky","LA": "Louisiana","ME": "Maine","MH": "Marshall Islands","MD": "Maryland","MA": "Massachusetts","MI": "Michigan","MN": "Minnesota","MS": "Mississippi","MO": "Missouri","MT": "Montana","NE": "Nebraska","NV": "Nevada","NH": "New Hampshire","NJ": "New Jersey","NM": "New Mexico","NY": "New York","NC": "North Carolina","ND": "North Dakota","MP": "Northern Mariana Islands","OH": "Ohio","OK": "Oklahoma","OR": "Oregon","PW": "Palau","PA": "Pennsylvania","PR": "Puerto Rico","RI": "Rhode Island","SC": "South Carolina","SD": "South Dakota","TN": "Tennessee","TX": "Texas","UT": "Utah","VT": "Vermont","VI": "Virgin Islands","VA": "Virginia","WA": "Washington","WV": "West Virginia","WI": "Wisconsin","WY": "Wyoming"}];
    

    
    $scope.whatState = function(StateAbev){
        var a = $scope.states[0][StateAbev];
        return a;
//        angular.forEach($scope.states, function(value, key) {
//            var stateVal = value[StateAbev];
//            return stateVal;
//        });
    };
                        
    
    $scope.isHouse = function(legislator) {
        if (legislator.chamber === "house"){
            return legislator;
        }
        
        
        
    };
        //'http://cs-server.usc.edu:12994/index.php',

    $http({
    method: 'GET',
    url:'homework8.php',
    params: {action : "leg"}}).then(function successCallback(response) {
        
    $rootScope.data = response.data.results;
    //$scope.test = response.data.results[0].title;
    
    }, function errorCallback(response) {
     });
    
    

    
//    $http({
//    method: 'GET',
//    url: 'http://cs-server.usc.edu:12994/index.php',
//    params: {action : 'commitLeg', searchVal :"K000388"}}).then(function successCallback(response) {
//
//    $scope.commitData = response.data.results;
//
//    }, function errorCallback(response) {
//     });
    
    
    
    
});




//dfdfsdfadfadfadf//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
    
app.controller('BillsCtrl', function($scope, $http, $rootScope) {
    
    var storageArray = [];

    $scope.isFav = function (){

        var tempStorage = JSON.parse(localStorage.getItem("BillsKey"));
        var localStroageInput = $scope.billData;
        var selectedInputStorage = "";

        // check if there's data 
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                // finds our data 
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            //check if it's a repeat 
            tempStorage.forEach(function(input2){
                if(input2.bill_id == selectedInputStorage.bill_id){
                    repeatFlag = false;
                }                        
            });
            
            //its not a repeat 
            if (repeatFlag){
                return false; 
            }else{
                return true; 

            }
        }
    };
    
    var storageArray = [];
    
   
    $scope.favoriteBill = function(){

                
        var tempStorage = JSON.parse(localStorage.getItem("BillsKey"));
        var localStroageInput = $scope.billData;
        var selectedInputStorage = "";

        
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            tempStorage.forEach(function(input2){
                if(input2.bill_id == selectedInputStorage.bill_id){
                    repeatFlag = false;
                }                        
            });
            
            if (repeatFlag){
                tempStorage.push(selectedInputStorage);
                $rootScope.BillsFavoriteGloabldata = tempStorage;
                localStorage.setItem("BillsKey",JSON.stringify(tempStorage));
            }else{
                var deletedData = JSON.parse(localStorage.getItem("BillsKey"));
                var count = 0;
                deletedData.forEach(function(input3){
                    if(input3.bill_id == selectedInputStorage.bill_id){
                        deletedData.splice(count, 1);
                        localStorage.setItem("BillsKey",JSON.stringify(deletedData));
                    }
                    count++;
                });
            }

        }
        else{
            
            localStroageInput.forEach(function(input){
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }

            });
            
            if (selectedInputStorage != ""){
                storageArray.push(selectedInputStorage);
                $rootScope.BillsFavoriteGloabldata = storageArray;
                localStorage.setItem("BillsKey",JSON.stringify(storageArray));
            }
        }
    };
    
    $rootScope.updateBillID = function(bGuide){
        $rootScope.billID = bGuide;
    };
    
    
    $scope.isActive = function(bills) {
        if (bills.history.active == true){
            return bills;
        }
    };
    
    
    $scope.activeVal = function(bool){
        if (bool){
            return "Active";
        }else{
            return "New";
        }
    }
    
    $scope.isNew = function(bills) {
        if (bills.history.active == false){
            return bills;
        }
    };
    
    $http({
        method: 'GET',
        url: 'homework8.php',
        params: {action : "bill"}}).then(function successCallback(response) {

        $scope.billData = response.data.results;

        }, function errorCallback(response) {
     });
});



//dfdfsdfadfadfadf//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf
//dfdfsdfadfadfadf


app.controller('CommitCtrl', function($scope, $http, $rootScope) {
    
    $scope.isFav = function (input){

        var idCommitInput = input;
        
        var tempStorage = JSON.parse(localStorage.getItem("CommiKey"));
        var localStroageInput = $scope.commitData;
        var selectedInputStorage = "";

        // check if there's data 
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                // finds our data 
                if(input.committee_id == idCommitInput){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            //check if it's a repeat 
            tempStorage.forEach(function(input2){
                if(input2.committee_id == selectedInputStorage.committee_id){
                    repeatFlag = false;
                }                        
            });
            
            //its not a repeat 
            if (repeatFlag){
                return false; 
            }else{
                return true; 

            }
        }
    };    
  var storageArray = [];
    
    $scope.favoriteCommit = function(inputCommitId){
                
        $scope.committeeIDInput = inputCommitId;
        
        var tempStorage = JSON.parse(localStorage.getItem("CommiKey"));
        var localStroageInput = $scope.commitData;
        var selectedInputStorage = "";

        
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                if(input.committee_id == $scope.committeeIDInput){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            tempStorage.forEach(function(input2){
                if(input2.committee_id == selectedInputStorage.committee_id){
                    repeatFlag = false;
                }                        
            });
            
            if (repeatFlag){
                tempStorage.push(selectedInputStorage);
                $rootScope.CommitteeFavoriteGloabldata = tempStorage;
                localStorage.setItem("CommiKey",JSON.stringify(tempStorage));
            }else{
                var deletedData = JSON.parse(localStorage.getItem("CommiKey"));
                var count = 0;
                deletedData.forEach(function(input3){
                    if(input3.committee_id == selectedInputStorage.committee_id){
                        deletedData.splice(count, 1);
                        $rootScope.CommitteeFavoriteGloabldata = deletedData;
                        localStorage.setItem("CommiKey",JSON.stringify(deletedData));
                    }
                    count++;
                });
            }

        }else{
            
            localStroageInput.forEach(function(input){
                if(input.committee_id == $scope.committeeIDInput){
                    selectedInputStorage = input; 
                }

            });
            
            if (selectedInputStorage != ""){
                storageArray.push(selectedInputStorage);
                $rootScope.CommitteeFavoriteGloabldata = storageArray;
                localStorage.setItem("CommiKey",JSON.stringify(storageArray));
            }
           
        }
        
        
        $scope.isFav(inputCommitId);
        
    };    
    
    
    
    $http({
        method: 'GET',
        url: 'homework8.php',
        params: {action : "commit"}}).then(function successCallback(response) {

        $scope.commitData = response.data.results;

        }, function errorCallback(response) {
     });
    
    
    $scope.updateCommitteeID = function(bGuide){
        $scope.committeeID = bGuide;
    };
    
    
    $scope.office = function(input){
        if (input != null){
            return input;
        }
        else{
            return "N.A";
        }
    }
    
    
});












app.controller('FavoriteCtrl', function($scope, $http, $rootScope) {
    
    
    // filter for active bill
    $scope.activeVal = function(bool){
        if (bool){
            return "Active";
        }else{
            return "New";
        }
    }
    
    //end filter for active bills
    
    
    //isFavBill for Legislator 
    
    var storageArray = [];

    $scope.isFavBill = function (){

        var tempStorage = JSON.parse(localStorage.getItem("BillsKey"));
        var localStroageInput = $scope.billData;
        var selectedInputStorage = "";

        // check if there's data 
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                // finds our data 
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            //check if it's a repeat 
            tempStorage.forEach(function(input2){
                if(input2.bill_id == selectedInputStorage.bill_id){
                    repeatFlag = false;
                }                        
            });
            
            //its not a repeat 
            if (repeatFlag){
                return false; 
            }else{
                return true; 

            }
        }
    };
    
    var storageArray = [];
    
   
    $scope.favoriteBill = function(){

                
        var tempStorage = JSON.parse(localStorage.getItem("BillsKey"));
        var localStroageInput = $scope.billData;
        var selectedInputStorage = "";

        
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            tempStorage.forEach(function(input2){
                if(input2.bill_id == selectedInputStorage.bill_id){
                    repeatFlag = false;
                }                        
            });
            
            if (repeatFlag){
                tempStorage.push(selectedInputStorage);
                $rootScope.BillsFavoriteGloabldata = tempStorage;
                localStorage.setItem("BillsKey",JSON.stringify(tempStorage));
            }else{
                var deletedData = JSON.parse(localStorage.getItem("BillsKey"));
                var count = 0;
                deletedData.forEach(function(input3){
                    if(input3.bill_id == selectedInputStorage.bill_id){
                        deletedData.splice(count, 1);
                        localStorage.setItem("BillsKey",JSON.stringify(deletedData));
                    }
                    count++;
                });
            }

        }
        else{
            
            localStroageInput.forEach(function(input){
                if(input.bill_id == $rootScope.billID){
                    selectedInputStorage = input; 
                }

            });
            
            if (selectedInputStorage != ""){
                storageArray.push(selectedInputStorage);
                $rootScope.BillsFavoriteGloabldata = storageArray;
                localStorage.setItem("BillsKey",JSON.stringify(storageArray));
            }
        }
    };
    
    //end isFavBill for Legislator
    
    
    
    
    
    
    
    
    
    // isFav for Legislator Detail in Favorites 
    var storageArray = [];

    $scope.isFav = function (){

        var tempStorage = JSON.parse(localStorage.getItem("LegiKey"));
        var localStroageInput = $rootScope.data;
        var selectedInputStorage = "";

        // check if there's data 
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                // finds our data 
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            //check if it's a repeat 
            tempStorage.forEach(function(input2){
                if(input2.bioguide_id == selectedInputStorage.bioguide_id){
                    repeatFlag = false;
                }                        
            });
            
            //its not a repeat 
            if (repeatFlag){
                return false; 
            }else{
                return true; 

            }
        }
    };
    

    var storageArray = [];
        
    $scope.favoriteLegislator = function(){
        
        
        
    
        var tempStorage = JSON.parse(localStorage.getItem("LegiKey"));
        var localStroageInput = $rootScope.data;
        var selectedInputStorage = "";

        
        if (tempStorage != null){
            localStroageInput.forEach(function(input){
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }
                
            });
            
            var repeatFlag = true;
            tempStorage.forEach(function(input2){
                if(input2.bioguide_id == selectedInputStorage.bioguide_id){
                    repeatFlag = false;
                }                        
            });
            
            if (repeatFlag){
                tempStorage.push(selectedInputStorage);
                $rootScope.LegislatorFavoriteGloabldata = tempStorage;
                localStorage.setItem("LegiKey",JSON.stringify(tempStorage));
            }else{
                var deletedData = JSON.parse(localStorage.getItem("LegiKey"));
                var count = 0;
                deletedData.forEach(function(input3){
                    if(input3.bioguide_id == selectedInputStorage.bioguide_id){
                        
                        deletedData.splice(count, 1);
                        $rootScope.LegislatorFavoriteGloabldata = deletedData;

                        localStorage.setItem("LegiKey",JSON.stringify(deletedData));
                    }
                    count++;
                });
            }
        }
        else{
            
            localStroageInput.forEach(function(input){
                if(input.bioguide_id == $rootScope.bioGuide){
                    selectedInputStorage = input; 
                }

            });
            
            if (selectedInputStorage != ""){
                storageArray.push(selectedInputStorage);
                $rootScope.LegislatorFavoriteGloabldata = storageArray;
                localStorage.setItem("LegiKey",JSON.stringify(storageArray));
            }
        }
        
    };
    
    // End of isFav for Legislator Detail in Favorites 
    
    
    $scope.dynamic = function(start,end){
        $scope.a = new Date();
        $scope.b = new Date(end);
        $scope.c = new Date(start);
        
        return Math.ceil((($scope.a-$scope.c)/($scope.b-$scope.c))*100);
    };
    
    $rootScope.myvalue = false;
    
    $rootScope.showDiv = function(input){
      $rootScope.myvalue = !$rootScope.myvalue;  
        $('#title').html("Legislators")

        $rootScope.updateBioguide(input);
    };

    
    
    
    
    $scope.$watch("LegislatorFavoriteGloabldata", function() { 
//        $scope.StringBackToJSON = JSON.parse(localStorage.getItem("LegiKey"));
        
        if ($rootScope.LegislatorFavoriteGloabldata != null){
                $scope.LegiValue = $rootScope.LegislatorFavoriteGloabldata;
            
        }else{
                $scope.LegiValue = [];
        }

    });
    
    $scope.StringBackToJSON = JSON.parse(localStorage.getItem("LegiKey"));
    $scope.LegiValue = $scope.StringBackToJSON;
    
    
    $scope.deleteUser = function(id){
        
        var checkId = id;

        var deletedData = JSON.parse(localStorage.getItem("LegiKey"));
        var count = 0;
        deletedData.forEach(function(input3){
            if(input3.bioguide_id == checkId){
                deletedData.splice(count, 1);
                $rootScope.LegislatorFavoriteGloabldata = deletedData;
                localStorage.setItem("LegiKey",JSON.stringify(deletedData));
            }
            count++;
        });
    };
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $scope.$watch("BillsFavoriteGloabldata", function() { 
//        $scope.StringBackToJSON = JSON.parse(localStorage.getItem("LegiKey"));
        
        if ($rootScope.BillsFavoriteGloabldata != null){
                $scope.billDataFave = $rootScope.BillsFavoriteGloabldata;
            
        }else{
                $scope.billDataFave = [];
        }

    });
    
    
    $scope.StringBackToJSONBill = JSON.parse(localStorage.getItem("BillsKey"));
    $scope.billDataFave = $scope.StringBackToJSONBill;
    
    
    $scope.deleteBill = function(id){
        
        var checkId = id;

        var deletedData = JSON.parse(localStorage.getItem("BillsKey"));
        var count = 0;
        deletedData.forEach(function(input3){
            if(input3.bill_id == checkId){
                deletedData.splice(count, 1);
                $rootScope.BillsFavoriteGloabldata = deletedData;
                localStorage.setItem("BillsKey",JSON.stringify(deletedData));
            }
            count++;
        });
    };
    
        
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $scope.$watch("CommitteeFavoriteGloabldata", function() { 
//        $scope.StringBackToJSON = JSON.parse(localStorage.getItem("LegiKey"));
        
        if ($rootScope.CommitteeFavoriteGloabldata != null){
                $scope.commitData = $rootScope.CommitteeFavoriteGloabldata;
            
        }else{
                $scope.commitData = [];
        }

    });
    

    
    $scope.StringBackToJSONBill = JSON.parse(localStorage.getItem("CommiKey"));
    $scope.commitData = $scope.StringBackToJSONBill;
    
    
    $scope.deleteCommit = function(id){
        
        var checkId = id;

        var deletedData = JSON.parse(localStorage.getItem("CommiKey"));
        var count = 0;
        deletedData.forEach(function(input3){
            if(input3.committee_id == checkId){
                deletedData.splice(count, 1);
                $rootScope.CommitteeFavoriteGloabldata = deletedData;
                localStorage.setItem("CommiKey",JSON.stringify(deletedData));
            }
            count++;
        });
    };
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $http({
        method: 'GET',
        url: 'homework8.php',
        params: {action : "bill"}}).then(function successCallback(response) {

        $scope.billData = response.data.results;

        }, function errorCallback(response) {
     });
    
               
        
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $scope.states = [{"AL": "Alabama","AK": "Alaska","AS": "American Samoa","AZ": "Arizona","AR": "Arkansas","CA": "California","CO": "Colorado","CT": "Connecticut","DE": "Delaware","DC": "District Of Columbia","FM": "Federated States Of Micronesia","FL": "Florida","GA": "Georgia","GU": "Guam","HI": "Hawaii","ID": "Idaho","IL": "Illinois","IN": "Indiana","IA": "Iowa","KS": "Kansas","KY": "Kentucky","LA": "Louisiana","ME": "Maine","MH": "Marshall Islands","MD": "Maryland","MA": "Massachusetts","MI": "Michigan","MN": "Minnesota","MS": "Mississippi","MO": "Missouri","MT": "Montana","NE": "Nebraska","NV": "Nevada","NH": "New Hampshire","NJ": "New Jersey","NM": "New Mexico","NY": "New York","NC": "North Carolina","ND": "North Dakota","MP": "Northern Mariana Islands","OH": "Ohio","OK": "Oklahoma","OR": "Oregon","PW": "Palau","PA": "Pennsylvania","PR": "Puerto Rico","RI": "Rhode Island","SC": "South Carolina","SD": "South Dakota","TN": "Tennessee","TX": "Texas","UT": "Utah","VT": "Vermont","VI": "Virgin Islands","VA": "Virginia","WA": "Washington","WV": "West Virginia","WI": "Wisconsin","WY": "Wyoming"}];
    
    $scope.whatState = function(StateAbev){
        var a = $scope.states[0][StateAbev];
        return a;

    };
    
    
    
    

    
});



////Toggle Function 

$(function() {
	$("#menu-toggle").click(function(e) {
	    e.preventDefault();
	    $("#wrapper").toggleClass("toggled");
	});
});

