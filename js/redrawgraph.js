// Get the context of the canvas element we want to select
function redrawGraph(){
     var f = document.getElementById("locations");
            if(f.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
           var id = f.options[f.selectedIndex].value;
            }
     var r = document.getElementById("range");
            if(r.options.length == 0)
            {
            console.log("undef");
            }
            else
            {
           var d = r.options[r.selectedIndex].value;
            }
    //capture current range

    
    
             $('#loading').show();
             $('#graphRefresh').hide();
        var typ = document.getElementById("type").value     
       
     
        var result = [];
        var ctx;
        var myLineChart;
            alert("Range: "+d+" LocationId: "+id+" Type: "+typ );
        $.ajax({
                type: "POST",
                url: "controllers/graph.php",
                data: {"range": d, "locationId": id, "type": typ},
                success: function(data){
            $('#loading').hide();
            //alert(data);
              $('#graphRefresh').show();
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
ctx = document.getElementById('rain').getContext('2d');
myLineChart = new Chart(ctx).Bar(data,options);

  
//$("#graph").trigger(\'change\');
 
 $("#graph").change(function() {
var n = $(this).val();
 switch(n)
 {
 case 'Bar':

        ctx = document.getElementById('rain').getContext('2d');
        myLineChart = new Chart(ctx).Bar(data,options);
 
   break;
   
 case 'Line':
        ctx = document.getElementById('rain').getContext('2d');
        myLineChart = new Chart(ctx).Line(data,options);
      
   break;
 }
});
    }
            } )
}







==========================================================================================================
    
    
    
    
    <script type="text/javascript" src="js/redrawgraph.js"></script>
<script>
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

</script>