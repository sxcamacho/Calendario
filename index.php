<?php

  @session_start();
  
  if(!isset($_SESSION['authenticated']) || ($_SESSION['authenticated'] == "no")){
    header("Location: login.php");
    exit;
  } 
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
<link rel="apple-touch-icon" sizes="72x72" href="touch-icon-ipad.png" /> 
<link rel="apple-touch-icon" sizes="114x114" href="touch-icon-iphone4.png" />
<link rel="icon" type="image/png" href="favicon.png" />
<style type='text/css'>

  body {
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    margin: 0;
  }
  
  h1 {
    margin: 0;
    padding: 0.5em;
  }
  
  p.description {
    font-size: 0.8em;
    padding: 1em;
    position: absolute;
    top: 3.2em;
    margin-right: 400px;
  }
  
  #message {
    font-size: 0.7em;
    position: absolute;
    top: 1em; 
    right: 1em;
    width: 350px;
    display: none;
    padding: 1em;
    background: #ffc;
    border: 1px solid #dda;
  }
  
</style>


<script type='text/javascript' src='jquery.min.js'></script>
<script type='text/javascript' src='jquery.cookie.js'></script>
<script type='text/javascript' src='jquery-ui.min.js'></script>
<script type='text/javascript' src='jquery.weekcalendar.js'></script>
<script type='text/javascript' src='bootstrap/js/bootstrap.min.js'></script>

<link rel='stylesheet' type='text/css' href='jquery-ui.css' />
<link rel='stylesheet' type='text/css' href='jquery.weekcalendar.css' />
<link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.css' />

<script type='text/javascript'>
   
  $(document).ready(function() {
  
    function pad (str, max) {
      str = str + "";
      return str.length < max ? pad("0" + str, max) : str;
    }
  
    function cargar_sesiones(_fecha_desde, _fecha_hasta){
      
      var _r;
      
      var fd = [_fecha_desde.getFullYear(), pad(_fecha_desde.getMonth()+1, 2), pad(_fecha_desde.getDate(), 2)].join('/');
      var fh = [_fecha_hasta.getFullYear(), pad(_fecha_hasta.getMonth()+1, 2), pad(_fecha_hasta.getDate(), 2)].join('/');
      
      var midata  = {
        accion : 'cargar-sesiones',
        fecha_desde : fd,
        fecha_hasta : fh
      };
            
      $.ajax({
        type: "POST",
        url: "servicios.php",
        async: false, // La petición es síncrona
        cache: false, // No queremos usar la caché del navegador
        data: midata,
        success: function( respuesta ){
          _r = respuesta;
       }});

      return _r;
    }
    
  
  
    var verModo = $.cookie('verModo');
    var verModoDia, diasToShow, diaSemana;
    
    if(verModo == null){
      verModoDia = false;
      diasToShow = 5;
      diaSemana = 1;
    }
    else if(verModo == "dia"){
      verModoDia = true;
      diasToShow = 1;
      diaSemana = new Date().getDay();
    }
    else if(verModo == "semana"){
      verModoDia = false;
      diasToShow = 5;
      diaSemana = 1;
    }
    
    var datos = eval(cargar_sesiones(new Date("2010/01/01"), new Date("2020/01/01")));

    $('#calendar').weekCalendar({
      date: new Date(),
      buttonText: {today : "Hoy", lastWeek : "<", nextWeek : ">", modeday : "Diario", modeweek : "Semanal"}, 
      timeslotsPerHour: 4,
      displayOddEven:true,
      daysToShow: diasToShow,
      timeSeparator: ' - ',
      readonly: true,
      businessHours :{start: 8, end: 20, limitDisplay: false},
      firstDayOfWeek : diaSemana,  
      modeDay : verModoDia,
      timeslotHeight: 20,
      use24Hour : false,
      allowCalEventOverlap: true, // Enable conflicting events
      overlapEventsSeparate: true, // Separate conflicting events
      switchDisplay: { '1 day': 1,  '3 next days': 3, 'work week': 5, 'full week': 6}, // Selector for number of days to be shown
      height: function($calendar){
        return $(window).height() - $("h1").outerHeight();
      },
      eventRender : function(calEvent, $event) {
        /*
        if(calEvent.end.getTime() < new Date().getTime()) {
          $event.css("backgroundColor", "#aaa");
          $event.find(".time").css({"backgroundColor": "#999", "border":"1px solid #888"});
        }
        */
      },
      eventNew : function(calEvent, $event) {
        return false;
        //displayMessage("<strong>Added event</strong><br/>Start: " + calEvent.start + "<br/>End: " + calEvent.end);
        //alert("You've added a new event. You would capture this event, add the logic for creating a new event with your own fields, data and whatever backend persistence you require.");
      },
      eventDrop : function(calEvent, $event) {
        //displayMessage("<strong>Moved Event</strong><br/>Start: " + calEvent.start + "<br/>End: " + calEvent.end);
      },
      eventResize : function(calEvent, $event) {
        //displayMessage("<strong>Resized Event</strong><br/>Start: " + calEvent.start + "<br/>End: " + calEvent.end);
      },
      eventClick : function(calEvent, $event) {
     
      //var fecha1 = [pad(calEvent.start.getDate(), 2), pad(calEvent.start.getMonth()+1, 2), calEvent.start.getFullYear()].join('/');
          //var fecha2 = [pad(calEvent.end.getDate(), 2), pad(calEvent.end.getMonth()+1, 2), calEvent.end.getFullYear()].join('/');
      
      
          //displayMessage("<strong>Horario " + fecha1 + " a " + fecha2 + "</strong><br>" + calEvent.title);
      },
      eventMouseover : function(calEvent, $event) {
        //displayMessage("<strong>Mouseover Event</strong><br/>Start: " + calEvent.start + "<br/>End: " + calEvent.end);
      },
      eventMouseout : function(calEvent, $event) {
        //displayMessage("<strong>Mouseout Event</strong><br/>Start: " + calEvent.start + "<br/>End: " + calEvent.end);
      },
      noEvents : function() {
        //displayMessage("There are no events for this week");
      },
      data: datos
    });
    
    function displayMessage(message) {
      $("#message").html(message).fadeIn();
    }

    $("<div id=\"message\" class=\"ui-corner-all\"></div>").prependTo($("body"));
    
  });

</script>
</head>
<body>
  <center>
    <img src="header.png" />
  </center>

  
    
  

  <div id='calendar'></div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43616406-2', 'esteticapp.com.uy');
  ga('send', 'pageview');

</script>
</body>
</html>
