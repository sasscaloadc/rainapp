//global data variable
var GlobDat = {};
            var options = {
                    tooltipEvents: ["touchstart", "touchmove"],
                    responsive: true
                };
//get id sent from create record
var default_Chosen_Location = document.getElementById("locationId").value;
//set the selectlist to the value obtained above
//document.getElementById("locations").selectedIndex = default_Chosen_Location;
//set graph type
var type = document.getElementById("type").value;
//set range
var range = document.getElementById("range").value;
//set graph title
if(type=="rain")
{
    
document.getElementById("title").innerHTML = $("#locations :selected").text()+" - Rain";
}
else
{

    document.getElementById("title").innerHTML = $("#locations :selected").text()+" - Temperature";
}

//if location changes,change the id as well
    $('#range').on('change', function() {
              range = this.value;
                  $.ajax({
                    type: "POST",
                    url: "controllers/graph.php",
                    data: {"id": default_Chosen_Location, "type": type, "range": range},
                    beforeSend: function() { 
                                $("#loading").show();
                                $("#graphRefresh").hide();
                            },
                    complete: function() {
                                $("#loading").hide(); 
                                $("#graphRefresh").show();
                            },
                    success: function(data){
                                $('#loading').hide();
                                $('#graphRefresh').show();
            //draw graph with returned values
                    DrawGraph(data);
                    }
                });
            })
    
function getId()
{
      var f = document.getElementById("locations");
            if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
                default_Chosen_Location = f.options[f.selectedIndex].value;
            }
            if(type=="rain")
            {
    
                document.getElementById("title").innerHTML = $("#locations :selected").text()+" - Rain";
            }
            else
            {

            document.getElementById("title").innerHTML = $("#locations :selected").text()+" - Temperature";
            }
            $.ajax({
                    type: "POST",
                    url: "controllers/graph.php",
                    data: {"id": default_Chosen_Location, "type": type, "range": range},
                    beforeSend: function() { 
                                $("#loading").show();
                                $("#graphRefresh").hide();
                            },
                    complete: function() {
                                $("#loading").hide(); 
                                $("#graphRefresh").show();
                        },
                    success: function(data){
                                $('#loading').hide();
                                $('#graphRefresh').show();
            //draw graph with returned values
                    DrawGraph(data);
                    }
            });
            }
//make ajax request sending locationId, range and graphtype to obtain the json results for drawing the graph
        $.ajax({
                type: "POST",
                url: "controllers/graph.php",
                data: {"id": default_Chosen_Location, "type": type, "range": range},
                beforeSend: function() { 
                        $("#loading").show();
                        $("#graphRefresh").hide();
                    },
                complete: function() {
                    $("#loading").hide(); 
                    $("#graphRefresh").show();
                },
                success: function(data){
                        $('#loading').hide();
                        $('#graphRefresh').show();
                DrawGraph(data);
            }
});

function DrawGraph(data)
{
            result = $.parseJSON(data);
            var x;
            var dates = [];
            var values= [];
            for(x=0;x<Object.keys(result).length;x++)
            {
                dates[x] = result[x][0];
            }
             for(x=0;x<Object.keys(result).length;x++)
            {
                values[x] = result[x][1];     
            }
            //draw graph
            var options = {
                        tooltipEvents: ["touchstart", "touchmove"],
responsive: true 
};

             var    data = {
                    labels: JSON.parse(JSON.stringify(dates)),
                    datasets: [
                                {
                                label: "Rain measurements",
                                fillColor: "rgba(187,205,240,0.2)",
                                strokeColor: "rgba(60,36,216,1)",
                                pointColor: "rgba(32,31,33,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: JSON.parse(JSON.stringify(values)),
                                }
                                ]
                            };
    GlobDat.data = data;
    ctx = document.getElementById('rain').getContext('2d');
    myLineChart = new Chart(ctx).Bar(data,options);

}

 $("#graph").change(function() {
        var n = $(this).val();
        switch(n)
        {
            case 'Bar':
                    ctx = document.getElementById('rain').getContext('2d');
                    myLineChart = new Chart(ctx).Bar(GlobDat.data,options);
            break;
   
            case 'Line':
                    ctx = document.getElementById('rain').getContext('2d');
                    myLineChart = new Chart(ctx).Line(GlobDat.data,options);
            break;
                
            default:
                ctx = document.getElementById('rain').getContext('2d');
                myLineChart = new Chart(ctx).Bar(GlobDat.data,options);
            break;     
        }
    })
 