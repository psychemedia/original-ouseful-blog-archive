<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Beyond Google: Multisearch Demo</title>
<link type="text/css" rel="stylesheet"  href="http://blogs.open.ac.uk/Maths/ajh59/tabber.css" />
<script type="text/javascript" src="http://blogs.open.ac.uk/Maths/ajh59/tabber.js"></script>

<script type="text/javascript">

//addLoadEvent from http://simon.incutio.com/archive/2004/05/26/addLoadEvent
 function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
 }

 function setFrameSrc(id, url){
  var el=document.getElementById(id);
  el.setAttribute('src',url);
 }
 
 function loadSearchPageFrame(){
  document.getElementById('searchPages').setAttribute("style", "display:block;width:710px");
  setFrameSrc('searchPageGoogle','http://www.google.co.uk');
  setFrameSrc('searchPageYahoo','http://uk.search.yahoo.com');
  setFrameSrc('searchPageMSN','http://www.msn.co.uk');
  //setFrameSrc('searchPageLive','http://www.live.com'); 
 }

 function loadCannedSearch(q){
  //document.getElementById('searchItemPages').setAttribute("style", "display:block;width:710px");
  setFrameSrc('searchUsrPageGoogle','http://www.google.co.uk/search?q='+q);
  setFrameSrc('searchUsrPageYahoo','http://uk.search.yahoo.com/search?p='+q);
  setFrameSrc('searchUsrPageMSN','http://search.msn.co.uk/results.aspx?q='+q);
  //setFrameSrc('searchItemPageLive','http://www.live.com/?q='+q); 
 }
 
 function loadUsrSearch(){

  var q=document.getElementById('usrSearchQuery').value;
  document.getElementById('searchUsrPages').setAttribute("style", "display:block;width:710px");
  setFrameSrc('searchUsrPageGoogle','http://www.google.co.uk/search?q='+q);
  setFrameSrc('searchUsrPageYahoo','http://uk.search.yahoo.com/search?p='+q);
  setFrameSrc('searchUsrPageMSN','http://search.msn.co.uk/results.aspx?q='+q);
  //setFrameSrc('searchUsrPageLive','http://www.live.com/?q='+q); 
 }
  
  

</script>

<style type="text/css">
	body {font-family:arial,sans-serif;}
	#tabberPanel {margin-top:20px;}
</style>

</head>

<body>
 <a href="http://ouseful.open.ac.uk/tu120" style="decoration:none"><img style="border:0px;" alt="TU120 banner" src="http://ouseful.open.ac.uk/beyondGoogle/TU120_course_title.gif" /></a>
 <div id="tabberPanel">
  <form action="" onsubmit="loadUsrSearch();return false;" >
   <label for="usrSearchQuery">Enter query:</label>
   <input id='usrSearchQuery' style="width: 200px;" type='text' >
   <input value="Search" type="submit">
  </form>
  <div class="tabber" id="searchUsrPages" style="width:710px;height:410px">
   <div class="tabbertab" title="Google">
    <iframe src="" id="searchUsrPageGoogle" style="width:700px;height:400px" ></iframe>
   </div>
   <div class="tabbertab" title="Yahoo">
    <iframe src="" id="searchUsrPageYahoo" style="width:700px;height:400px" ></iframe>
   </div>
   <div class="tabbertab" title="MSN">
    <iframe src="" id="searchUsrPageMSN" style="width:700px;height:400px" ></iframe>
   </div>
  </div>
 </div>
</body>
</html>
