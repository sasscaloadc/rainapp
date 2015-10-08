<?php

/*
$body.='<h4><center>NO RECORDS SAVED FOR THE LOCATION</center></h4>';
*/
$body = '<br>
<div class="row">
    <select id="graph">
        <option selected="selected" value="Bar">Bar graph</option>
        <option value="Line">Line graph</option>
    </select> 
    <select id="range">
        <option value="7">Past week</option>
        <option value="30">Past month</option>
        <option value="90">Past 3 months</option>
    </select>
</div>
<div class="row" id="loading">
    <center>
    <img src="images/294.GIF"/><br>
    <strong>Please wait..</strong>
    </center>
</div>
<div id="graphRefresh">
<canvas  id="rain"  style="margin-left:-20px;width="100%";height="200";"></canvas></div>';

include('index.php');
echo '<script>
//recieve id
$(document).ready(function() {
// Get the context of the canvas element we want to select
    $(function(){
        $("#range").trigger(\'change\');
        });
    
        $("#range").change(function() {
             $(\'#loading\').show();
             $(\'#graphRefresh\').hide();
             
        var d = $(this).val();
     
        var result = [];
        var ctx;
        var myLineChart;
        $.post(
        "controllers/graph.php",{range: d},
        function(data){
            $(\'#loading\').hide();
            
              $(\'#graphRefresh\').show();
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
ctx = document.getElementById(\'rain\').getContext(\'2d\');
myLineChart = new Chart(ctx).Bar(data,options);

  
//$("#graph").trigger(\'change\');
 
 $("#graph").change(function() {
var n = $(this).val();
 switch(n)
 {
 case \'Bar\':

        ctx = document.getElementById(\'rain\').getContext(\'2d\');
        myLineChart = new Chart(ctx).Bar(data,options);
 
   break;
   
 case \'Line\':
        ctx = document.getElementById(\'rain\').getContext(\'2d\');
        myLineChart = new Chart(ctx).Line(data,options);
      
   break;
 }
});
    }
    )
    }
    )}
);

</script>';
?>