
<?php
    global $data;    
    
    echo getHeader($data["title"]);
    menu($data["title"]); 
?>
    <div class="wrapper">
       
      <?php
   
      echo "<div class='topbar'><form method=post id=form-filtr>";      
      echo "Rok ";    
      echo "<select name=rok class='date-picker' style='width:120px' onchange=\"jQuery('#form-filtr').submit();\">";       
            foreach($data["option_roky"] as $option){
               echo $option;
            }
      echo "</select>";
      ?>
      <script type="text/javascript">
                var popisky=[];
                 var body=[];
                 var barvy=[];
      </script>
      <?php         
      echo "</form></div>";     
     
            
            echo "<table class=zaplaceno cellpadding=4 cellspacing=4>";
            
           
            echo "<tr class=table-header><td align=center>Pořadí</td><td>Jméno</td><td align=right>Počet účastí</td><td align=right>Úspěšnost</td></tr>";
                          
            foreach($data["body"] as $rada_body){              
              echo "<tr class='poradi ".$rada_body["class_bold"]."'>";
              echo "<td align=center>".$rada_body["poradi"]."</td>";
              echo "<td align=left>".$rada_body["jmeno"]."</td>";
              echo "<td align=right>".$rada_body["pocet_ucasti"]."</td>";
              echo "<td align=right>".$rada_body["body"]."</td>";               
              echo "</tr>";

                ?>
                  <script type="text/javascript">
                    popisky.push(<?php echo "'".$rada_body["jmeno"]."'"; ?>);
                    body.push(<?php echo round($rada_body["body"], 2); ?>);
                    <?php 
                    if($rada_body["pod"]==0){
                       ?>
                       barvy.push("#B0BEC5"); 
                       <?php 
                    }
                    else
                    {
                        ?>
                       barvy.push("#009688"); 
                       <?php 
                    }
                    ?>
                  </script>
                <?php
                                 
            }
      echo "</table>"; 
      echo '<br><div id=velikost><canvas style="width: 100%;" id="myChart"></canvas><div>';  
     ?>
    </div>
<script type="text/javascript">
var chart;
jQuery(document).ready(function(){  
    var canvas = document.getElementById('myChart'); 
    var cwidth = document.getElementById('velikost').offsetWidth;
    var options;
    if(cwidth>800){
        options={legend: {
                      display: false
                  },
                  tooltips: {
                      callbacks: {
                         label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                         }
                      }
                  },
                  scales: {
            xAxes: [{
                ticks: {                   
                    autoSkip: false
                }
            }]
        }};
    }
    else
    {
        options={
                  legend: {
                      display: false
                  },
                  tooltips: {
                      callbacks: {
                         label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                         }
                      }
                  },
                  scales: {
            xAxes: [{
                ticks: {
                    display: false
                }
            }]
        }
              };
    }
    
    
    var ctx = canvas.getContext('2d');
    chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: popisky,
      datasets: [
        {

          backgroundColor: barvy,
          data: body
        }
      ]
    },
    options: options
});    
});  
</script>
<?php
    echo getFooter(); 
?> 