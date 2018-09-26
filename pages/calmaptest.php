<html><head><title></title>
<style type='text/css'>
#calmap {
	width: 1000px;
}

#calendar {
	width: 420px;
	float: right;
	margin-right:50px;
}

#map { 
	margin: 0;
	float: right;
	width: 530px;
}
</style>

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAuqeEz6AY088gjvcgGenAFRSfEz5P6ejuNohth3Pfp7X_JG8fZhRjTXaEZv-9PKK9vwDVzje3usxecA"
            type="text/javascript"></script>


<script type="text/javascript">
var map;
var geoXml;

function load() {
  if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
    geoXml = new GGeoXml('http://pipes.yahoo.com/pipes/pipe.run?_id=d696db6de1dda5c86fc8fa59bbef6aec&_render=kml&gCalXml=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Fu0aq4g3cjf6g6nnesa8mv0l77g%2540group.calendar.google.com%2Fpublic%2Fbasic');
    map.setCenter(new GLatLng(0,0), 1);
    map.addControl(new GLargeMapControl());
    map.addOverlay(geoXml);
  }
}
</script>
</head><body onload="load()">
<!--

-->
<div id='calmap'>

<div id="map" style="width: 500px; height: 400px"></div>
<iframe id='calendar' src="http://www.google.com/calendar/embed?showNav=0&amp;showDate=0&amp;showTabs=0&amp;mode=AGENDA&amp;height=400&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=u0aq4g3cjf6g6nnesa8mv0l77g%40group.calendar.google.com&amp;color=%235229A3" style=" border-width:0 " width="400" height="400" frameborder="0" scrolling="no"></iframe>


</div>
</body>
</html>