<head>
  <title>searchfeedr - feed powered searches</title>

<script src="http://blogs.open.ac.uk/Maths/ajh59/yahoo.js"></script> 
<script type="text/javascript" src="http://blogs.open.ac.uk/Maths/ajh59/event-min.js"></script>

<style type="text/css">

body {
	margin: 0;
	padding: 0;
	background-color: #eee;
	font-size: 80%;
	line-height: 160%;
	font-family: "Bitstream Vera Sans", Verdana, sans serif;
	color:#000;
	text-align: center;
	}

h1 {
	font-size: 150%;
	margin: 20px 0 40px 0;
	text-align: center;
	color: #666;
	}
h2 {
	font-size: 120%;
	margin: 10px 0 10px 0;
}
form {
	margin: 10px 0 30px 0;
	padding: 0;
}
ul, ol {
	margin: 10px 0 2px 2px;
	padding: 0;
	font-size:80%
}
ul li, ol li {
	list-style-type: none;
	color: #777;
	margin: 3px 0 0;
	padding: 0;
}
/*
ul li:before {
	content: "\00BB \0020";
}
*/
iframe {padding-left:5px;}
input {
	margin: 0;
	padding: 0;
}
textarea {
	font-size: 90%;
	margin: 0;
	padding: 2px;
}
code {
	font-size: 110%;
	color: green;
}
img, a img {
	border: none;
}
fieldset {
	margin: 0;
	padding: 10px;
	border: 1px solid #ccc;
}
legend {
	color: #666;
}

#info{float:right;}

input.but {
	background-color: #eee;
	border: 1px solid #ccc;
	padding: 2px;
	cursor: pointer;
}
input.but:hover {
	background: #eee;
	border: 1px solid #000; 
}
a:link, a:visited {
	color: blue;
	text-decoration: none; 
}
a:hover {
	color: red;
	text-decoration: underline; 
}
 .example {font-size:80%;margin-top:10px}
 #strapline {color:#006600;font-size:60%}
 #dataForm {margin-left:10px;}
 #ip, #sURL, #bURL,#feedTypeArray,#pageOrDomain, #searchEngine {margin-top:10px}
 #feedTypeArray{display:none;}
</style>

<style type="text/css">
body{padding: 20px;background-color: #FFF; text-align: center;
    font: 76% Verdana,Arial,sans-serif}
h1,h2,p{margin: 0 10px}
h1{font-size: 250%;color: #4396D8;letter-spacing: 1px}
h2{font-size: 200%;color: #FFF}
p{padding-bottom:1em}
h2{padding-top: 0.3em}
div#page{width:1020px;text-align:left;margin: 0 auto;}
div#main{background: #9DD4FF;margin-right:320px;width:710px;}
div#rhs{float: right;width:300px;background: #E5FFC4}
div#rhs p{padding: 5px 0}
div#rhs h2{font-size: 110%;color: #333}
</style>
<link rel="stylesheet" type="text/css" href="http://ouseful.open.ac.uk/nifty/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="http://ouseful.open.ac.uk/nifty/niftyPrint.css" media="print">
<script type="text/javascript" src="http://ouseful.open.ac.uk/nifty/nifty.js"></script>
<script type="text/javascript">
window.onload=function(){
if(!NiftyCheck())
    return;
Rounded("div#main","#fff","#9DD4FF");
Rounded("div#rhs","#fff","#E5FFC4");
}
</script>

</head>
<body>

<div id="page">

 <div id="rhs">
 <form name="tuneForm" action="">
 <p>Domains (tick to remove from results): <ul id="searchDomains"></ul>
Pages: <ul id="pageLinks"></ul>
</p></form>
</div>

 <div id='main'>
  <h1>searchfeedr <span id="strapline">feed your own search limits</span></h1>

  <p>Search across pages or domains listed in a web page, web feed (RSS, Atom etc.) or delicious user's bookmark list.</p>

<form name="dataForm" id="dataForm" action="" onsubmit="deliSearch(); return false;">

<div>
 <div id='feednquery'><input id="usrFeed" type="text" size="50" value="" /> : <input id="usrSearchTerms" type="text" size="24" 
value='' /></div>
  <div class="example">Feed URL (feedSearch), page URL (pageSearch (linkSearch & relatedSearch N/A)) or delicious username/tag (deliSearch) : search term(s)</div>
  <div id="feedTypeArray">
  <label><input type="radio" name="feedType" value="feedsearch" checked=true  /> feedSearch</label>
  <label><input type="radio" name="feedType" value="pagesearch"   /> pageSearch</label>
  <label><input type="radio" name="feedType" value="delisearch"  /> deliSearch</label>
  <label><input type="radio" name="feedType" value="linksearch"  /> linkSearch</label>
  <label><input type="radio" name="feedType" value="relatedsearch"  /> relatedSearch</label>
 </div>
</div>

<div id="pageOrDomain">Search Over: <label><input type='radio' name='searchType' value='domains'  checked=true   /> Domains</label>
<label><input type='radio' name='searchType' value='pages'   /> Pages</label></div>

<div id="searchEngine">Select search engine (domain searches only - Yahoo is used for <em>Search Over Pages</em>):<br />
<label><input type='radio' name='searchengineType' value='yahoo'  checked=true   /> Yahoo</label>
<label><input type='radio' name='searchengineType' value='google'   /> Google</label>
<label><input type='radio' name='searchengineType' value='live'     /> Microsoft Live</label>
<label><input type='radio' name='searchengineType' value='altavista'   /> Altavista</label></div>


<div id="ip"><input value="search..." class="but" type="submit"> <span id='info'><a href="http://blogs.open.ac.uk/Maths/ajh59/007576.html">About</a>, <a href="searchfeedrplusTools.html">Tools</a></span></div>

  <div id="sURL">Search URL: <span id='output'></span></div>
  <div id="bURL">URL for this search query (<em>not including suppressed domain info</em>): <span id='bookmark'></span></div>
  <!-- <p>Bookmark this search page: <span id="output2"></span></p> -->

  </form>
<br /> 
<iframe id="resultsFrame" name="resultsFrame" src="" scrolling="yes" 
 height="400" frameborder="0" width="700">
</iframe>
 </div>

</div>

<script type="text/javascript">


function init() {
	}

YAHOO.util.Event.addListener(window, 'load', init);

var lastSearchTag=''; var lastSearchType='';var searchObject;
var freshLinks=true;
function getRadioItem(id){
  var item;
  for (var i=0;i<id.length;i++)
   if (id[i].checked==true)
    item=id[i].value;
  return item;
}

function cleanScript(head){
  if (document.getElementById('uploadScript'))  head.removeChild(document.getElementById('uploadScript'));
}

//function cleanNode(node){for (;node.childNodes.length>0;) node.removeChild(node.firstChild);}
function cleanNode(nodeId){
 var output = document.getElementById(nodeId);
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
}
function loadNewJSONScript(tag) {
  var thisSearchTag=getFeedURL();//document.getElementById('usrFeed').value;//getUsrTagPath();
  var thisSearchType=getSearchType();
  if ((lastSearchTag!=thisSearchTag) || (lastSearchType!=thisSearchType) ) {
   lastSearchTag=thisSearchTag; lastSearchType=thisSearchType;
   var head = document.getElementsByTagName("head")[0];
   //need to bring garbage collection back...
   cleanScript(head);
   cleanNode('pageLinks');
   cleanNode("searchDomains");
   freshLinks=true;
   domainList='';
   attachJSONFeed2(head);
  } else
     freshLinks=false;
	 loadURL(searchObject);
}

var mysticFeed='pagesearch'; var feedHack=false;
function getFeedURL(){ return document.getElementById('usrFeed').value;}//f
function getSearchType(){return mysticFeed;}//{ return getRadioItem(document.dataForm.feedType) };//t
function getResultsType(){ return getRadioItem(document.dataForm.searchType) };//s
function getSearchengineType() { return getRadioItem(document.dataForm.searchengineType) };//se

function attachJSONFeed2(head){
  var script = document.createElement('script');
  script.id = 'uploadScript';
  script.type = 'text/javascript';
  var feedURL=document.getElementById('usrFeed').value;

//  var browseURL="http://b1.bitty.com/b2browser/?contenttype=rssfeed&contentvalue="+escape(feedURL);
//  document.getElementById('fsBrowse').setAttribute('src',browseURL);

  var feedType=getSearchType();
  feedHack=false;
  switch(feedType){
   case 'feedsearch':
    feedURL="http://psychemediasxoxotools.ning.com/outlineconvert.php?output=json&classes=items&url="+escape(feedURL)+"&callback=performDeliSearchAction";
    break;
   case 'pagesearch':
    feedURL="http://ouseful.open.ac.uk/pagelinks2json.php?url="+escape(feedURL);
    break;
   case 'delisearch':
    var pop=feedURL.split('/');
    if (pop[0]=='popular') {feedHack=true;feedURL="http://psychemediasxoxotools.ning.com/outlineconvert.php?output=json&classes=items&url="+escape('http://del.icio.us/rss/'+feedURL)+"&callback=performDeliSearchAction";}
    else feedURL="http://del.icio.us/feeds/json/"+feedURL+"?count=25&callback=performDeliSearchAction";
    break;
   case 'linksearch':
    feedURL="http://api.search.yahoo.com/SiteExplorerService/V1/inlinkData?appid=linkfeedr&output=json&query="+escape(feedURL)+"&callback=performDeliSearchAction";
    break;
   case 'relatedsearch':
    feedURL="http://www.dappit.com/transform.php?dappName=deliciousrelateditemsviasimilicious&transformer=RSS&variableArg_0="+escape(feedURL)+"&extraArg_title=related&extraArg_link=related%40href";
    feedURL="http://xoxotools.ning.com/outlineconvert.php?output=json&classes=items&url="+escape(feedURL)+"&callback=performDeliSearchAction";
    break;
   default:
    break;
  }


  //alert(feedURL);
  script.src=feedURL;
  head.appendChild(script);
}

function doESP(){
 var guessMe=getFeedURL();
 var guess=guessMe.split('/');
 if (guess.length==2) {mysticFeed='delisearch'; return;}

 guess=guessMe;
 var trial=/[\/]{1}rss[\/]{1}/;
 var attempt=guess.search(trial);
 if (attempt!=-1) {mysticFeed='feedsearch'; return}
 trial=/xml$/i;
 attempt=guess.search(trial);
 if (attempt!=-1) {mysticFeed='feedsearch'; return}
 trial=/rss$/i;
 attempt=guess.search(trial);
 if (attempt!=-1) {mysticFeed='feedsearch'; return}
 mysticFeed='pagesearch'; 
}

function vanillaSearch(){
 var q=document.getElementById('usrSearchTerms').value;
 if (q!='') {
   var seType=getSearchengineType();var myURL;
   switch (seType) {
    case 'google':
     myURL='http://www.google.co.uk/search?q=';//+searchString;
     break;
    case 'live':
     myURL='http://search.live.com/results.aspx?first=51&q=';//+searchString;
     break;
    case 'altavista':
     myURL='http://www.altavista.com/web/results?q=';//+searchString;
     break;
    default:
     myURL='http://search.yahoo.com/search?p=';//+searchString;
     break;
   } 
   myURL+=formatSearchTerms();
   loadiframe(myURL); 
 }
}

function deliSearch(){

 //var output = document.getElementById('output');
 //for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
 //cleanNode(output);
 cleanNode('output');
 var label="need to clean this";
 var shouldIbovver=getFeedURL();
 if (shouldIbovver=='') vanillaSearch();
 else {
  doESP(); //alert('I guess '+mysticFeed);
  loadNewJSONScript(label);
 }
}

function feedjson2deljson(json_data) {
   var rtrn = [];
   for(var i=0; i<json_data.items.length; i++) {
      obj = {};
      obj.d = json_data.items[i].title;
      obj.u = json_data.items[i].link;
      obj.n = '';
      if(json_data.items[i].description)
         obj.n = json_data.items[i].description;
      if(json_data.items[i].content)
         obj.n = json_data.items[i].content;
      rtrn.push(obj);
   }//end for
   return rtrn;
}//end feedjson2deljson

function inlinksfeedjson2deljson(json_data) {
   var rtrn = [];
   for(var i=0; i<json_data.ResultSet.Result.length; i++) {
      obj = {};
      obj.d = json_data.ResultSet.Result[i].Title;
      obj.u = json_data.ResultSet.Result[i].Url;
      obj.n = '';
      //if(json_data.items[i].description)
       //  obj.n = json_data.items[i].description;
      //if(json_data.items[i].content)
       //  obj.n = json_data.items[i].content;
      rtrn.push(obj);
   }//end for
   return rtrn;
}//end inlinksfeedjson2deljson

function performDeliSearchAction(delicious){
 var feedType=getSearchType(); 
 if ( (feedType=='feedsearch') || (feedType=='relatedSearch') || (feedHack) ) delicious=feedjson2deljson(delicious);
 if (feedType=='linksearch') delicious=inlinksfeedjson2deljson(delicious);
 searchObject=delicious;
 loadURL(delicious);
}

function loadURL(delicious){
 var myURL=generateNewURL(delicious);
// if (myURL!='') window.location=myURL;
 if (myURL!='') {
  frames['resultsFrame'].location.href=myURL;
  displayNewURL(myURL); deliLinkURL();
 }
}

function loadiframe(url){frames['resultsFrame'].location.href=url;}

function formatSearchTerms(){
 var searchTerms= document.getElementById('usrSearchTerms').value;
 searchTerms= searchTerms.replace ( / /g, '+' );
 return searchTerms;
}

function parseUrlDomain(data) {
    var e=/^(http:\/\/)?([^\/]+)/i;

    if (data.match(e)) {
        return RegExp.$2;
    }
    else {
        return '';
    }
}

var suppressList;

function suppressItems(){
 suppressList=''; var url;
 var items=new Array();
 if (document.tuneForm.suppress){
  var suppressItems=document.tuneForm.suppress;
  //if (suppressItems.checked==true) items='-site:flickr.com+%20' ; else items='';
  for (var i=0; i<suppressItems.length; i++)
   if (suppressItems[i].checked) {
    url=parseUrlDomain(suppressItems[i].value);
   // items+='-site:'+url+'%20';
    suppressList+=url+' ';
   }
  } 
// return items;
}

function displayNewURL(myURL) {
 cleanNode('output');
 var link = document.createElement('a');
// var label= getUsrTagPath(delicious);
 var output = document.getElementById('output');
 var searchTerms=formatSearchTerms();
// var myURL=generateNewURL(delicious);
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  link.setAttribute('href', myURL);
  linkTxt= 'Search for '+searchTerms;
 }
 link.setAttribute('id','myURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link); 
}
/*
var searchDomainsChanged=false;
function checkSearchCheckbox(){
 searchDomainsChanged=true;
}
*/
function addSearchLink(url, nodeId){
 var ul=document.getElementById(nodeId);
 var li=document.createElement('li');
 var a=document.createElement('a');
 a.setAttribute('href','javascript:loadiframe("http://'+url+'");');
 var lt=document.createTextNode(url);
 //var t=document.createTextNode("Suppress ");
 a.appendChild(lt);
 var l=document.createElement('label');
 var i=document.createElement('input');
 i.setAttribute('type','checkbox');
 i.setAttribute('name','suppress');
 i.setAttribute('value',url);
 addEvent(i,'change',deliSearch,false);
 //addEvent(i,'click', checkSearchCheckBox,false);
 //l.appendChild(t);
 l.appendChild(i);
 l.appendChild(a);
 li.appendChild(l);
 ul.appendChild(li);
}

function addClickLink(url, nodeId){
 var ul=document.getElementById(nodeId);
 var li=document.createElement('li');
 var a=document.createElement('a');
 a.setAttribute('href','javascript:loadiframe("'+url+'");');
 var turl;
 var urll=url.length;
 if (urll>60) {turl=url.substring(0,33)+'...'+url.substring(urll-18)} else turl=url;
 var lt=document.createTextNode(turl);
 a.appendChild(lt);
 li.appendChild(a);
 ul.appendChild(li);
}

//http://www.scottandrew.com/weblog/articles/cbs-events
function addEvent(obj, evType, fn, useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.attachEvent){
    var r = obj.attachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be attached");
  }
}
/*function removeEvent(obj, evType, fn, useCapture){
  if (obj.removeEventListener){
    obj.removeEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.detachEvent){
    var r = obj.detachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be removed");
  }
}
*/
var domainList='';
function generateNewURL(delicious){
 var searchTerms = formatSearchTerms();
 var searchString='';
 var tmp; var url; var myURL='http://search.yahoo.com/search?p=';
 if (delicious) {
  var encURL;   var linkCount=0; var maxLinks=16;
  var customType=getResultsType();
  var st=getSearchType();
  //if (st!='delisearch') {var f=getFeedURL(); if (freshLinks) addSearchLink(f, searchDomains);}
  suppressItems();
  searchString+=escape(searchTerms)+'+(';
  cleanNode('pageLinks');
  if (freshLinks) cleanNode('searchDomains');
  for (var i=0, post; post = delicious[i]; i++) {
    url=parseUrlDomain(post.u);
    if (customType=='pages') {
     encURL=encodeURIComponent(post.u);
     tmp=searchString+'url:'+encURL;
     if (encURL!='') if (searchString.search(encURL)==-1) if (suppressList.search(url)==-1) if (linkCount<maxLinks) {
       //if (freshLinks) 
       if (domainList.search(url)==-1) {domainList+=url+' '; addSearchLink(url, 'searchDomains');}  
       addClickLink(post.u, 'pageLinks'); linkCount++
       searchString+='url:'+encURL+'%20OR%20';
     } else break;
    } else {
	//url=parseUrlDomain(post.u)
	tmp=searchString+'site:'+url;
	if  (url!='') if (searchString.search(url)==-1) if (suppressList.search(url)==-1)
	 if (linkCount<maxLinks) {
		//if (domainList.search(url)==-1) {domainList+=url+' ';searchString+='site:'+url+'%20OR%20';if (freshLinks) addSearchLink(url, 'searchDomains');}
		searchString+='site:'+url+'%20OR%20';linkCount++;
		if (freshLinks) if (domainList.search(url)==-1) {domainList+=url+' '; addSearchLink(url, 'searchDomains');}
	 } else break;
    }
  }
  searchString+=')';
  if (customType=='domains') {
   var seType=getSearchengineType();
   switch (seType) {
    case 'google':
     myURL='http://www.google.co.uk/search?q=';//+searchString;
     break;
    case 'live':
     myURL='http://search.live.com/results.aspx?first=51&q=';//+searchString;
     break;
    case 'altavista':
     myURL='http://www.altavista.com/web/results?q=';//+searchString;
     break;
    default:
     myURL='http://search.yahoo.com/search?p=';//+searchString;
     break;
   } 
  }
  myURL=myURL+searchString;
 }

  return myURL;
}

function deliLinkURL() {
 var output = document.getElementById('bookmark');
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
 var link = document.createElement('a');
 var f=getFeedURL();
 var s=getResultsType();
 var se=getSearchengineType();
 var query=formatSearchTerms();
 var searchtype=getSearchType();
 //var myURL='http://blogs.open.ac.uk/Maths/ajh59/searchfeedrlabs.php?f='+f+'&q='+query+'&t='+searchtype+'&se='+se+"&s="+s;
 var myURL='searchfeedrlabs.php?f='+f+'&q='+query+'&t='+searchtype.substring(0,1)+'&se='+se.substring(0,1)+"&s="+s;
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  link.setAttribute('href', myURL);
  //linkTxt='deliSearch del.icio.us/'+usr+'/'+tag+' over '+searchtype+' for '+query;
  linkTxt='Link to this query';
 }
 link.setAttribute('id','bookmarkURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link);
}
</script>
<!--
<script type="text/javascript">
//<![CDATA[
  document.write('<scr'+'ipt src="http://crazyegg.com/pages/scripts/29217.js?'+(new Date()).getTime()+'" type="text/javascript"></'+'script>');
//]]>
</script>
-->
</body>