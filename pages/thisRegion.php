<head><title>Region tester</title><head>

<body>Region tester - please tell a.j.hirst@open.ac.uk where this page thinks you are<br />
<script type='text/javascript'>window.location='http://www.open.ac.uk'</script><br />Please also tell tony this number: 137.108.64.151<!--
<script type="text/javascript">
    function callback(pingback) {
     //alert(pingback.pingBack[0].ipAddress);
     var ip=pingback.pingBack[0].ipAddress;
     //var ip=pingback.pingBack[0].ipAddress.split('.');
     //var msg=ip[0]+'s'+ip[1]+'s'+ip[2]+'s'+ip[3];alert(msg);
	 var campus=/137.108.(\d{1,3}).\d{1,3}/;
	 var regions=/194.66.(\d{1,3}).\d{1,3}/;
	 if (campus.test(ip)) {
	  var library=/137\.108\.8[23]\.\d{1,3}/;
 	  if (library.test(ip)) alert('in the library'); else alert('somewhere at Walton Hall');
 	 } else if (regions.test(ip)){
 	  switch (regions(ip)[1]) {
 	   case '128':alert('Are you in the London regional office?');break;
 	   case '129':alert('Are you in the Oxford regional office?');break;
	   case '130':alert('Are you in the Bristol regional office?');break;
 	   case '131':alert('Are you in the Birmingham regional office?');break;
 	   case '132':alert('Are you in the Nottingham regional office?');break;
 	   case '133':alert('Are you in the Cambridge regional office?');break;
 	   case '134':alert('Are you in the Leeds regional office?');break;
 	   case '135':alert('Are you in the Manchester regional office?');break;
 	   case '136':alert('Are you in the Newcastle regional office?');break;
 	   case '137':alert('Are you in the Cardiff regional office?');break;
 	   case '138':alert('Are you in the Edinburgh regional office?');break;
 	   case '139':alert('Are you in the Belfast regional office?');break;
 	   case '140':alert('Are you in the East Grinstead regional office?');break;
 	   case '142':alert('Are you in the Wellingborough warehouse?');break;
 	   case '143':alert('Are you at Bedford Row?');break;
 	   case '149':alert('Are you in the Dublin regional office?');break;
 	   default: alert('I thought you may be in the regions, but you could be anywhere...');
 	  }
 	 } else alert('you could be anywhere...');

	 //var localtest=/127\.\d{1,3}\.(\d{1,3})\.(\d{1,3})/;
	 //if (localtest.test(ip)) alert('local'+localtest(ip)[2]); else alert('nah');
		alert('Please also tell tony this number: '+ip);
     }
</script>
<script type="text/javascript" 
        src="http://blogs.open.ac.uk/Maths/ajh59/pingBack.php?output=json"></script>

-->
</body>
<!--


library 137.108.82.0 -> 137.108.83.255 : library 137.108.8[23].\d{1,3} 
Ê
194.66.128.* London
194.66.129.* Oxford
194.66.130.* Bristol
194.66.131.* Birmingham
194.66.132.* Nottingham
194.66.133.* Cambridge
194.66.134.* Leeds
194.66.135.* Manchester
194.66.136.* Newcastle
194.66.137.* Cardiff
194.66.138.* Edinburgh
194.66.139.* Belfast
194.66.140.* East Grinstead
194.66.142.* Wellingborough
194.66.143.* Bedford Row
194.66.149.* Dublin

137.108.0.0 -> 137.108.255.255 ( MK Campus) ?? 137.108.(\d{1,3}).\d{1,3}
Ê
194.66.128.0 -> 194.66.149.255 (Regional Offices plus Warehouses)
194.66.(\d{1,3}).\d{1,3}
-->