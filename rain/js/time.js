//Create globally scopped object to allow variable to be accessible from all functions when called

var DateKeeper = {};
var LocationIdKeeper = {};
var JoyrideToggle ={};

date = new Date((new Date()).valueOf() - 1000*3600*24);

day1 = moment().add(-1, "days").format("YYYY-MM-DD");
day2 = moment().format("YYYY-MM-DD");

var nowTemp = new Date();
month = "0" + (date.getMonth()+1);
/******************
Get selected location and use that to get the date
*****************/
$(document).ready(function()
{
    var f = document.getElementById("locations");
    
    //alert(x);
      if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
            var u = f.options[f.selectedIndex].value; //location id saved here
            LocationIdKeeper.loc = u;
            var x = "locationTimes.php";
            $.post(
                    x,{id: u}, function(data)
                        {
                            if(data==1)
                            {
                                JoyrideToggle.result = 1;
                                //set from date to yesterday
                                document.getElementById("fdatepicker3").value = day1;
                            }
                            else
                            {
                            DateKeeper.date = data;
                            }
                        }
                     );
}
});
 function getId(){
            var f = document.getElementById("locations");
            if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
           var u = f.options[f.selectedIndex].value; //location id saved here
            LocationIdKeeper.loc = u;
            var x = "locationTimes.php";
            $.post(
                    x,{id: u}, function(data)
                        {
                            if(data==1)
                            {
                                JoyrideToggle.result = 1;
                                //set from date to yesterday
                                document.getElementById("fdatepicker3").value = day1;
                            }
                            else
                            {
                                document.getElementById("fdatepicker3").value = data;
                            DateKeeper.date = data;
                            }
                        }
                     );
                    }
                }


//alert(month.slice(-2));
/************************************************************************************
If more dates is not selected then :-
-default date is set to yesterdays date and becomes FROM date
-to date is set to current date

If more dates has been selected then:-
-default date is set to null
-from date is set to last added date for the specific location + 1 second
-to date is set to the current date or any other date value that comes after the selected from date
-if there is no last added date, the user selects date
****************************************************************************************/
function datechange()
{
//get new date value
var cdate = document.getElementById("fdatepicker3").value;
var ddate = new Date(cdate);
ddate.setDate(ddate.getDate()+1);
var dd = ddate.getDate();
var mm = ddate.getMonth()+1;
var y = ddate.getFullYear();

var formattedNewDate = y+"-"+mm+"-"+dd;
document.getElementById("fdatepicker").value = formattedNewDate;
document.getElementById("fdatepicker3").value = date.getFullYear() +"-"+month.slice(-2)+"-"+(date.getDate()-1); //default date 
}

function viewgraph()
{
    
         //alert(id);
    var x = "state2.php";
    var y = LocationIdKeeper.loc;
    //alert(newLink);
        $.post(
                    x,{link: y}, function(data)
                    {window.location.href = "summary.php";}
            );
 }

document.getElementById("fdatepicker3").value = day1; //default date 
document.getElementById("fdatepicker").value = day2; //to date set to current date
document.getElementById("fdatepicker2").value = null; //from date is set to null

        $("#fdatepicker").fdatepicker(
            {format: "yyyy-mm-dd"}
        );
        $("#fdatepicker2").fdatepicker(
            {format: "yyyy-mm-dd"}
        );
         $("#fdatepicker3").fdatepicker(
            {
            format: "yyyy-mm-dd",
            }
         );
        
        $("#shows").click(function(){
        $("#hidden").toggle("slow");
       $("#shown").hide("slow");
       document.getElementById("fdatepicker3").value=null;
       document.getElementById("fdatepicker2").value= DateKeeper.date; // this has to be set to last added date + 1second
       //alert(DateKeeper.date);
       document.getElementById("fdatepicker").value = date.getFullYear()+"-"+month.slice(-2)+"-"+(date.getDate()); //to date set to current date
        });
        
        $("#hides").click(function(){
        $("#shown").toggle("slow");
       $("#hidden").hide("slow");
       document.getElementById("fdatepicker3").value= date.getFullYear() +"-"+month.slice(-2)+"-"+(date.getDate()-1); //default date 
document.getElementById("fdatepicker").value = date.getFullYear()+"-"+month.slice(-2)+"-"+(date.getDate()); //to date set to current date
document.getElementById("fdatepicker2").value = null; //from date is set to null
        });
    $(document).ready(function(){

    var value = document.getElementById("locations");
    var time = document.getElementById("timeTest");
    //alert(time.value);
   if(value.options.length >= 1 && JoyrideToggle.result==1)
    {
   // $(document).foundation(\'joyride\', \'start\',);

   $(document).foundation({
    joyride: {
		expose: false,
        "nubPosition": "auto", 
	   // pause_after : [5]
	}
}).foundation("joyride", "start");
    }
    else
    {
    //alert("Locations exist");
    }
    
  
    
});	
     $("#loading").hide(); 
$("#target").submit(function(event) {
    event.preventDefault();
    //please wait record being saved
    $.ajax(
    {
        type: "POST",
        url: "controllers/post_measurement.php",
        data: $("form").serialize(),
        beforeSend: function() { 
            $("#loading").show();
            $("#signup").hide();
            },
        complete: function() {
                 $("#loading").hide(); 
                 $("#signup").show();
        },
        success: function(message) {
              $("#loading").hide();
                    if(message==418)
                    {
                    toastr.error("Rain record not saved. The date range entered clashes with an existing date range for this location.");
                    }
                    else if(message==400)
                    {
                    toastr.error("Rain record not saved. End date was not specified.");
                    }
                    else if(message==420)
                    {
                    toastr.error("Rain record not saved. Please ensure that the measurement start date is not greater than the measurement end date.");
                    }
                   else
                    {
                    toastr.success(message);
        }
    }
    });

});
