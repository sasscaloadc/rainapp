//Create globally scopped object to allow variable to be accessible from all functions when called
var DateKeeper = {};
DateKeeper.date = 'undefined';
var LocationIdKeeper = {};
var JoyrideToggle ={};
var MoreDates = {};
 $("#loading").hide(); 


date = new Date((new Date()).valueOf() - 1000*3600*24);
yesterday = moment().add(-1, "days").format("YYYY-MM-DD");//yesterday
today = moment().format("YYYY-MM-DD");//today

dayBeforeYesterday = moment().add(-2, "days").format("YYYY-MM-DD");
var nowTemp = new Date();
month = "0" + (date.getMonth()+1);

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

$("#fdatepicker2").fdatepicker(
            {format: "yyyy-mm-dd",
            endDate:yesterday
            }
        );
$("#fdatepicker3").fdatepicker(
        {format: "yyyy-mm-dd",
        endDate:yesterday
        }
);

$("#fdatepicker").fdatepicker(
        {format: "yyyy-mm-dd",
        endDate:yesterday}
);

//default date values
document.getElementById("fdatepicker3").value = yesterday; //default date 
document.getElementById("fdatepicker").value = today; //to date set to current date
document.getElementById("fdatepicker2").value = null; //from date is set to null

//toggle more dates text box
$("#shows").click(function(){
    $("#hidden").toggle("slow");
    $("#shown").hide("slow");
    document.getElementById("fdatepicker3").value=null;
    MoreDates.flag = 1;
    if(DateKeeper.date === 'undefined')
    {
    document.getElementById("fdatepicker2").value= dayBeforeYesterday;//DateKeeper.date; // this has to be set to last added date + 1second
    document.getElementById("fdatepicker").value = yesterday;//date.getFullYear()+"-"+month.slice(-2)+"-"+(date.getDate()); //to date set to current date
    }
    else
    {
        //if(moment(yesterday) > moment(DateKeeper.date))
        if(moment(yesterday).isBefore(DateKeeper.date))
        {
           
    document.getElementById("fdatepicker2").value= yesterday;//DateKeeper.date;//DateKeeper.date; // this has to be set to last added date + 1second
    document.getElementById("fdatepicker").value = DateKeeper.date;//yesterday;//date.getFullYear()+"-"+month.slice(-2)+"-"+(date.getDate()); //to date set to current date
    DateKeeper.date = 'undefined';
        }
        else
        {
        document.getElementById("fdatepicker2").value= DateKeeper.date;//DateKeeper.date; // this has to be set to last added date + 1second
         document.getElementById("fdatepicker").value = yesterday;
            DateKeeper.date = 'undefined';
        }
        DateKeeper.date = 'undefined';
    }
});
        
$("#hides").click(function(){
    $("#shown").toggle("slow");
    $("#hidden").hide("slow");
     MoreDates.flag = 0;
    DateKeeper.date = 'undefined';
    document.getElementById("fdatepicker3").value= yesterday; //default date 
    document.getElementById("fdatepicker").value = today; //to date set to current date
    document.getElementById("fdatepicker2").value = null; //from date is set to null
});

/******************
Get selected location and use that to get the date
*****************/
$(document).ready(function()
{
    var f = document.getElementById("locations");

    
      if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
            var u = f.options[f.selectedIndex].value; //location id saved here
            LocationIdKeeper.loc = u;
                
    $.ajax({
            type: "POST",
            url: "locationTimes.php",
            data: {id:u},
            success: function(data){
                        if(data==1)
                            {
                            document.getElementById("fdatepicker3").value = yesterday;
                            document.getElementById("fdatepicker").value = today;
                            //check if there are any locations saved
                            if(f.options.length == 1)
                                 {
                                     
                                    $(document).foundation({
                                        joyride: {
		                                expose: false,
                                        "nubPosition": "auto", 
	                                    // pause_after : [5]
	                                 }
                                   }).foundation("joyride", "start");
                                 }
                             }
                                else
                             {
                                //document.getElementById("fdatepicker3").value = data;
                                DateKeeper.date = data;
                             }
                        }
                    });
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
           var u = f.options[f.selectedIndex].value;
           LocationIdKeeper.loc = u;
                $.ajax({
                        type: "POST",
                        url: "locationTimes.php",
                        data: {id:u},
                        success: function(data){
                             if(data==1)
                             {
                             
                                document.getElementById("fdatepicker3").value = yesterday;
                                document.getElementById("fdatepicker").value = today;
                                 //check if there are any locations saved
                                 if(f.options.length == 1)
                                 {
                                    $(document).foundation({
                                                joyride: {
		                                        expose: false,
                                                "nubPosition": "auto", 
	                                           // pause_after : [5]
	                                               }
                                        }).foundation("joyride", "start");
                                }    
                             }
                            else
                            {
                                DateKeeper.date = data;
                                if(MoreDates.flag == 0){
                            document.getElementById("fdatepicker3").value = data;
                            
                                }
                                else if(MoreDates.flag == 1)
                                {
                                    
                             document.getElementById("fdatepicker3").value=null;

        //if(moment(yesterday) > moment(DateKeeper.date))
        if(moment(yesterday).isBefore(data))
        {
           
    document.getElementById("fdatepicker2").value= yesterday;//DateKeeper.date;//DateKeeper.date; // this has to be set to last added date + 1second
    document.getElementById("fdatepicker").value = data;//DateKeeper.date;//yesterday;//date.getFullYear()+"-"+month.slice(-2)+"-"+(date.getDate()); //to date set to current date
        }
        else
        {
        document.getElementById("fdatepicker2").value= data;//DateKeeper.date;//DateKeeper.date; // this has to be set to last added date + 1second
         document.getElementById("fdatepicker").value = yesterday;
        }
  
                            }}
                }
                });
                }
            }

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
                    x,{link: y, type: "rain"}, function(data)
                    {window.location.href = "summary.php";}
            );
 }
    
    
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
                    toastr.error("Rain record not saved. Rain measurement is missing.");
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
