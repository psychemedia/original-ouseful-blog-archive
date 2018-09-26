<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Circular Schools Catchment Areas</title>
    <style type="text/css">
    v\:* {
      behavior:url(#default#VML);
    }
    body {
      font-family:Arial,Helvetica,Sans Serif;
      font-size:10pt;
    }
    </style>
    
    <!--orig key ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxT-QBCZH8ekfSd8XbXtGwKxpyI_sBTdf0BPmkMfxYcnIUa4xxydvEilhA-->
    
    
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAuqeEz6AY088gjvcgGenAFRQzyekZGHtY3m43wfB_EUazveN-XBRwcyPhyTcB5sThg0vMFDZJpqCvXQ"
            type="text/javascript"></script>

                   
       <script type="text/javascript">
    //<![CDATA[

    var map;

    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(50.7, -1.297), 10);
	map.addControl(new GLargeMapControl());
	GEvent.addListener(map, 'click', mapClick);
	
	// ajh    
	var schools_Xml = new
GGeoXml("http://maps.google.co.uk/maps/ms?ie=UTF8&hl=en&msa=0&output=nl&msid=109196350919255002936.0004442a4df25160d80a7");
        
	 // map.addOverlay(schools_Xml);
	
	//use a proxy to route the kml, or get a json feed from pipes
	//for each item in feed, plot marker and circle;
	//what are units of circle?
	
      }
    }

    function load2() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(50.7, -1.297), 10);
	map.addControl(new GLargeMapControl());
	GEvent.addListener(map, 'click', mapClick);
	
	// ajh    
/*	var schools_Xml = new
GGeoXml("http://maps.google.co.uk/maps/ms?ie=UTF8&hl=en&msa=0&output=nl&msid=109196350919255002936.0004442a4df25160d80a7");
*/
	//don't need to load the overlay if we pull it in from a pipe?
	//var schools_xml=new GGeoXml(kmlURL);
  
	 // map.addOverlay(schools_Xml);
	
	//use a proxy to route the kml, or get a json feed from pipes
	//for each item in feed, plot marker and circle;
	//what are units of circle?
	
      }
    }
    /** Utility Functions **/
   // rand - Generates random number from 1 to n, inclusive
    function rand ( n )
    {
      return ( Math.floor ( Math.random ( ) * n + 1 ) );
    }

   // byte2hex - Takes number n from 0-255 and converts to hexadecimal string e.g. 'AA'
   // Courtesy Jim Bumgardner of krazydad.com
   function byte2Hex(n)
   {
    var nybHexString = "0123456789ABCDEF";
    return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
   }

   // RGB2Color - Takes 3 hexadecimal string color components and concatenates into standard HTML format
   // Courtesy Jim Bumgardner of krazydad.com
   function RGB2Color(r,g,b)
   {
    return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
   }


   // mapClick - Handles the event of a user clicking anywhere on the map
   // Draws either stars or polygons with random variation in arguments
   // with clicked point as center.

    function mapClick(overlay, clickedPoint) {
    
    //AJH DISABLED;
    return;
    
	var polyPoints = Array();

	var mapNormalProj = G_NORMAL_MAP.getProjection();
	var mapZoom = map.getZoom();
        var clickedPixel = mapNormalProj.fromLatLngToPixel(clickedPoint, mapZoom);

	var polySmallRadius = rand(60) + 20;
	var polyLargeRadius = polySmallRadius*2 + rand(40);
	var polyNumSides = rand(8) + 2;
	var polySideLength = 360/polyNumSides;
	var polyColor = RGB2Color(rand(255),rand(255),rand(255));
	
	var starMode = document.getElementById("drawMode_stars").checked;
        var polyMode = document.getElementById("drawMode_polys").checked;
	if(starMode){
          document.getElementById("status").innerHTML = "Drew <strong>star</strong> with <strong>" + polyNumSides + "</strong> sides, <strong>" + polyColor + "</strong> fill, <strong>" + polySmallRadius + "</strong> small radius, and <strong>" + polyLargeRadius + "</strong> large radius.";

     	  for (var a = 0; a<(polyNumSides*2+1); a++) {
	    var aRad = polySideLength/2*a*(Math.PI/180);
	    var polyRadius = polySmallRadius; 
	    if(a%2==1){ // if a is odd, use the large radius
	      polyRadius = polyLargeRadius;
	    }	
       	    var pixelX = clickedPixel.x + polyRadius * Math.cos(aRad);
	    var pixelY = clickedPixel.y + polyRadius * Math.sin(aRad);
	    var polyPixel = new GPoint(pixelX,pixelY);
	    var polyPoint = mapNormalProj.fromPixelToLatLng(polyPixel,mapZoom);
	    polyPoints.push(polyPoint);
	  }
	} else if(polyMode){ // polygon mode
          document.getElementById("status").innerHTML = "Drew <strong>polygon</strong> with <strong>" + polyNumSides + "</strong> sides, <strong>" + polyColor + "</strong> fill, and <strong>" + polySmallRadius + "</strong> radius.";

     	  for (var a = 0; a<(polyNumSides+1); a++) {
	    var aRad = polySideLength*a*(Math.PI/180);
	    var polyRadius = polySmallRadius; 
       	var pixelX = clickedPixel.x + polyRadius * Math.cos(aRad);
	    var pixelY = clickedPixel.y + polyRadius * Math.sin(aRad);
	    var polyPixel = new GPoint(pixelX,pixelY);
	    var polyPoint = mapNormalProj.fromPixelToLatLng(polyPixel,mapZoom);
	    polyPoints.push(polyPoint);
	  }
	} else { // circle mode
          polyNumSides = 20;
          polySideLength = 18;
          document.getElementById("status").innerHTML = "Drew <strong>circle</strong> with <strong>" + polyNumSides + "</strong> sides, and <strong>" + polyColor + "</strong> fill.";

     	  for (var a = 0; a<(polyNumSides+1); a++) {
	    var aRad = polySideLength*a*(Math.PI/180);
	    var polyRadius = polySmallRadius; 
       	    var pixelX = clickedPixel.x + polyRadius * Math.cos(aRad);
	    var pixelY = clickedPixel.y + polyRadius * Math.sin(aRad);
	    var polyPixel = new GPoint(pixelX,pixelY);
	    var polyPoint = mapNormalProj.fromPixelToLatLng(polyPixel,mapZoom);
	    polyPoints.push(polyPoint);
	  }
        }	
	var polygon = new GPolygon(polyPoints,"#000000",2,.5,polyColor,.5);
	map.addOverlay(polygon);
     }

    function clearShapes(){
	map.clearOverlays();
    }

    //]]>
    </script>

  </head>
<!-- remove 'load()' from onload -->
  <body onload="load2()" onunload="GUnload()">
  
  <h1>Circular Catchment Areas Around Schools - Interactive Map</h1>

  <div>This interactive map allows you to set different circular catchment areas around marked schools loaded in 
from a <a href="http://maps.google.com/support/bin/answer.py?answer=68480">Google MyMap</a>. (Google MyMaps allow 
you to create your own map, annotated with markers at locations you have chosen; such as all the schools in
your area, for example.)</div>
  <div>Views of just the schools in a particular sector are possible by hiding the sectors you do not wish to view.
  Individual schools can be hidden from a view to model effect of closing that school. You can find a list of all the schools 
displayed on the map directly below the map - just tick the box next to each school you want to <em>exclude</em>
from the map.</div>
<div>At the current time, the map will identify schools classified as Primary, Middle, Secondary or High School.
To display the catchment areas, the title part of the marker for
each school must include the sector (for example 'This HIgh School' or 'That Primary School').</div>
<div>To import markers from a Google MyMap, you must first enter the URL for the map and click 'Load Map'. The URL
you should use for the map is the one linked to from a Google MyMap as the 'View in Google Earth' URL. Once you have
loaded the map, it will refocus to a point in the centre of the schools you have loaded.</div>
<div>WHen the map is loaded, a list of schools should be displayed beneath the map, from which you can choose to
exclude schools from the map (to simulate their closure, for example). Choose appropriate catchment area 
settings, and then click on 'Plot Points'.</div>
  <div>Each time you change the view/hide settings, you will need to clear the map (click on 'Clear') and then
 replot the catchment circles ('plot points') - you should not need to reload the map.</div>
<div>The default MyMap URL displays 
<a href="http://maps.google.com/maps/ms?ie=UTF8&hl=en&msa=0&msid=109196350919255002936.0004442a4df25160d80a7&z=10">schools 
on the Isle of Wight</a> (including planned new schools, but not excluding schools identified for closure).
TO learn more about how to create a MyMap, see <a href="http://blogs.open.ac.uk/Maths/ajh59/012526.html">Mapping Proposed School Closure Plans on the Isle of Wight</a>.
  <br />
  <hr /><br />
<!--    Draw mode: 
  <input type="radio" name="drawMode" id="drawMode_stars" value="stars" checked /> Stars
   <input type="radio" name="drawMode" id="drawMode_polys" value="polys"/> Polygons 
   <input type="radio" name="drawMode" id="drawMode_circles" value="circles"  /> Circles -->
    <input type="button" onclick="ousefulLoadMap()" value="Load Map" />  <input type="button" onclick="ousefulPlotPoints()" value="plot points" /> <input type="button" onclick="clearShapes();" value="Clear"/>

   <br/>
<br/>
   Google MyMap "View in Google Earth" URL: <input id="kmlURL" size="50" value="http://maps.google.com/maps/ms?ie=UTF8&hl=en&msa=0&output=nl&msid=109196350919255002936.0004442a4df25160d80a7" /><br />
   Default catchment: <input id="circleDist" type='text' size='4' value='2' /> km  (Hide unknown sector schools <input type="checkbox" id='hideUnknown' />)<br/>
   Primary school catchment: <input id="primaryDist" type='text' size='4' value='2' /> km (Hide? <input type="checkbox" id='hidePrimary' />)<br/>
   Middle school catchment: <input id="middleDist" type='text' size='4' value='5' /> km (Hide? <input type="checkbox" id='hideMiddle' />)<br/>
   High school catchment: <input id="highDist" type='text' size='4' value='10' /> km (Hide? <input type="checkbox" id='hideHigh' />)<br/>
   Secondary school catchment: <input id="secondaryDist" type='text' size='4' value='10' /> km (Hide? <input type="checkbox" id='hideSecondary' />)<br/>
    <br/><br/>

    <div id="map" style="width: 500px; height: 300px"></div>
    <br/>
    
    <table id='schoolList'>
    <tr><td>School</td><td>Lat</td><td>Lon</td><td>Hide?</td></tr>

    </table>
    
           <script type="text/javascript">
              //<![CDATA[
	var pipePoints;
	    
    function pointBits(lat, lon, desc,marker,sname,id){
     this.schoolname=sname;
     this.id=id;
     this.lat=lat;
     this.lon=lon;
     this.description=desc;
     if (sname.indexOf('rimary')!=-1) {this.circleColor='#0000FF';this.sector='primary'}
     else if (sname.indexOf('iddle')!=-1) {this.circleColor='#00FF00';this.sector='middle'}
     else if (sname.indexOf('igh')!=-1) {this.circleColor='#FF0000';this.sector='high'}
     else if (sname.indexOf('econdary')!=-1) {this.circleColor='#333333';this.sector='secondary'}
     else {this.circleColor='#777777';this.sector='unknown'};
    }

//http://www.thecave.com/archive/2006/09/05/removing_child_nodes_dynamically_using_javascript.aspx
function removeChildNodes(n)
{
  while (n.childNodes[0])
  {
    n.removeChild(n.childNodes[0]);
  }
}

    function fillTable(sname,lat,lon,id){
    	var cb;
    	var t=document.getElementById('schoolList');
    	var row = document.createElement('tr');
    	var cell=document.createElement('td');
    	var txt=document.createTextNode(sname);
    	cell.appendChild(txt);
    	row.appendChild(cell);
    	cell=document.createElement('td');
    	txt=document.createTextNode(lat);
    	cell.appendChild(txt);
    	row.appendChild(cell);
    	cell=document.createElement('td');
    	txt=document.createTextNode(lon);
    	cell.appendChild(txt);
    	row.appendChild(cell);
    	cell=document.createElement('td');
    	cb=document.createElement('input');
    	cb.setAttribute('type','checkbox')
    	cb.setAttribute('id',id);
    	cell.appendChild(cb);
    	row.appendChild(cell);
    	t.appendChild(row);
    }
    
    function parseJSON(json_data){ 
    	var id;
	var maxlat=-999.0; var minlat=999.0; var avlat=0; var lat;
	var maxlon=-999.0; var minlon=999.0; var avlon=0; var lon;
    	pipePoints= new Array();
 	removeChildNodes(document.getElementById('schoolList'));
    	for (var i=0; i<json_data.value.items.length; i++) {
    		id="schoolID"+i;
		lat=json_data.value.items[i]['y:location'].lat;
		lon=json_data.value.items[i]['y:location'].lon;
		minlon= minlon>lon?lon:minlon;
		maxlon= maxlon>lon?maxlon:lon;
		minlat= minlat>lat?lat:minlat;
		maxlat= maxlat>lat?maxlat:lat;
		pipePoints[i]= new pointBits(json_data.value.items[i]['y:location'].lat,json_data.value.items[i]['y:location'].lon,json_data.value.items[i]['description'],json_data.value.items[i]['dc:type'],json_data.value.items[i]['name'],id);
		fillTable(json_data.value.items[i]['name'],lat,lon,id);
		}
		//alert(pipePoints[0].lat)

	avlat=1.0*minlat+(maxlat-minlat)/2;
	avlon=1.0*minlon+(maxlon-minlon)/2;

	map.setCenter(new GLatLng(avlat, avlon), 10);
    }
    
    function ousefulDist(radiusKm){
    	// based on http://www.bdcc.co.uk/Gmaps/BDCCCircle.js
      	var sz = map.getSize();
  		var bnds = map.getBounds();
  		var pxDiag = Math.sqrt((sz.width*sz.width) + (sz.height*sz.height));
  		var mDiagKm = bnds.getNorthEast().distanceFrom(bnds.getSouthWest()) / 1000.0;
  		var pxPerKm = pxDiag/mDiagKm;
  		//get the bounding square to the middle of the line
  		var rPx = Math.round(radiusKm * pxPerKm);
  		return rPx;
    }
    
    function ousefulCirclePlot(point,lat,lon,circleColor){
    	var mapNormalProj = G_NORMAL_MAP.getProjection();
		var mapZoom = map.getZoom();
   		var polyPoints = Array();
    	var polySmallRadius = rand(60) + 20;
		var polyLargeRadius = polySmallRadius*2 + rand(40);
		var polyNumSides = rand(8) + 2;
		var polySideLength = 360/polyNumSides;
		var polyColor = circleColor;//RGB2Color(rand(255),rand(255),rand(255));
		var clickedPixel = mapNormalProj.fromLatLngToPixel(point, mapZoom);
    	polyNumSides = 40;
        polySideLength = 9;

		var radius= document.getElementById('circleDist').value;
		
     	for (var a = 0; a<(polyNumSides+1); a++) {
	    	var aRad = polySideLength*a*(Math.PI/180);
	    	var polyRadius = polySmallRadius;
	    	polyRadius=ousefulDist(radius);
       	    var pixelX =  clickedPixel.x + polyRadius * Math.cos(aRad);
	    	var pixelY =  clickedPixel.y + polyRadius * Math.sin(aRad);
	    	var polyPixel = new GPoint(pixelX,pixelY);
	    	var polyPoint = mapNormalProj.fromPixelToLatLng(polyPixel,mapZoom);
	    	polyPoints.push(polyPoint);
	  	}
	  	
	  	var polygon = new GPolygon(polyPoints,"#000000",2,.5,polyColor,.5);
		map.addOverlay(polygon);
    }
    
       function ousefulCirclePlot2(point,record){
       	
       	var id=record.id;
       	if (document.getElementById(id).checked) return;
       	
		//var radius= document.getElementById('circleDist').value;
		var radius;
		
		var sector=record.sector;
		switch (sector) {
			case 'primary':
				if (document.getElementById('hidePrimary').checked) return;
				radius=document.getElementById('primaryDist').value;
				break;
			case 'middle':
				if (document.getElementById('hideMiddle').checked) return;
				radius=document.getElementById('middleDist').value;
				break;
			case 'high':
				if (document.getElementById('hideHigh').checked) return;
				radius=document.getElementById('highDist').value;
				break;
			case 'secondary':
				if (document.getElementById('hideSecondary').checked) return;
				radius=document.getElementById('secondaryDist').value;
				break;
			case 'unknown':
				if (document.getElementById('hideUnknown').checked) return;
				radius=document.getElementById('circleDist').value;
				break;
			default: radius=document.getElementById('circleDist').value;
		}

		var showPoint;
		
        var lat=record.lat;
        var lon=record.lon;
        var circleColor=record.circleColor;
        
    	var mapNormalProj = G_NORMAL_MAP.getProjection();
		var mapZoom = map.getZoom();
   		var polyPoints = Array();
    	var polySmallRadius = rand(60) + 20;
		var polyLargeRadius = polySmallRadius*2 + rand(40);
		var polyNumSides = rand(8) + 2;
		var polySideLength = 360/polyNumSides;
		var polyColor = circleColor;//RGB2Color(rand(255),rand(255),rand(255));
		var clickedPixel = mapNormalProj.fromLatLngToPixel(point, mapZoom);
    	polyNumSides = 40;
        polySideLength = 9;
	
     	for (var a = 0; a<(polyNumSides+1); a++) {
	    	var aRad = polySideLength*a*(Math.PI/180);
	    	var polyRadius = polySmallRadius;
	    	polyRadius=ousefulDist(radius);
       	    var pixelX =  clickedPixel.x + polyRadius * Math.cos(aRad);
	    	var pixelY =  clickedPixel.y + polyRadius * Math.sin(aRad);
	    	var polyPixel = new GPoint(pixelX,pixelY);
	    	var polyPoint = mapNormalProj.fromPixelToLatLng(polyPixel,mapZoom);
	    	polyPoints.push(polyPoint);
	  	}
	  	
	  	var polygon = new GPolygon(polyPoints,"#000000",2,.5,polyColor,.5);
		map.addOverlay(polygon);
    }
    
    function ousefulPlotPoints(){
      for (var i=0;i<pipePoints.length;i++){
      	var point = new GLatLng(pipePoints[i].lat, pipePoints[i].lon);
        //map.addOverlay(new GMarker(point));
        //ousefulCirclePlot(point,pipePoints[i].lat, pipePoints[i].lon, pipePoints[i].circleColor);
        ousefulCirclePlot2(point,pipePoints[i]);
      }
    
    }

    function ousefulLoadMap(){
	var kmlURL=document.getElementById('kmlURL').value;
	//load2(kmlURL);
	var d=document;
	var s=d.createElement('script');
	s.type='text/javascript';
        kmlURL=encodeURIComponent(kmlURL);
//kmlURL='http%3A%2F%2Fmaps.google.co.uk%2Fmaps%2Fms%3Fie%3DUTF8%26hl%3Den%26om%3D0%26msa%3D0%26output%3Dnl%26msid%3D109196350919255002936.0004442a4df25160d80a7';
	var pipesURL="http://pipes.yahoo.com/pipes/pipe.run?_id=upZvhxPV3BGkyflyX0sBXw&_render=json&kmzURL="+kmlURL+"&_callback=parseJSON";
	s.src=pipesURL;
//alert(pipesURL);
	d.body.appendChild(s);
    }
             //]]> 
          </script>
     <!--      <script src="http://pipes.yahoo.com/pipes/pipe.run?_id=d696db6de1dda5c86fc8fa59bbef6aec&_render=json&gCalXml=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2Fu0aq4g3cjf6g6nnesa8mv0l77g%2540group.calendar.google.com%2Fpublic%2Fbasic&_callback=parseJSON"></script>
-->
<!--
<script type="text/javascript" src="http://pipes.yahoo.com/pipes/pipe.run?_id=upZvhxPV3BGkyflyX0sBXw&_render=json&kmzURL=http%3A%2F%2Fmaps.google.co.uk%2Fmaps%2Fms%3Fie%3DUTF8%26hl%3Den%26om%3D0%26msa%3D0%26output%3Dnl%26msid%3D109196350919255002936.0004442a4df25160d80a7&_callback=parseJSON"></script>
-->
  </body>
</html>

