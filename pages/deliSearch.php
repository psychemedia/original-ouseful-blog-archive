<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>deliSearch</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="monitorThis.css" />

<style type="text/css">@import 'delijsonsearch.css';</style>

<script src="http://blogs.open.ac.uk/Maths/ajh59/yahoo.js"></script> 
<script src="http://blogs.open.ac.uk/Maths/ajh59/connection.js"></script>
<!-- <script type="text/javascript" src="yahoo-min.js"></script> -->
<script type="text/javascript" src="dom-min.js"></script>
<script type="text/javascript" src="event-min.js"></script>
<script type="text/javascript">
// Code in this block based on http://icant.co.uk/sandbox/jsonsearch

YJSONsearch = {
	indicatorClass : 'YJSONsearch',
	searchAPIURL : 'http://api.search.yahoo.com/WebSearchService/V1/webSearch?output=json&callback=YJSONsearch.eureka',
	yourAppID : 'deliSearch',
	start : 0,
	amount : 10,
	resultElementID : 'YJSONresults',
	loadingMessage : 'loading...',

	deliSearch:function(term){
		//var term;
		//term = this.href ? this.href.replace( /.*p=/, '' ) : document.getElementById( 'p' ).value;	
		var s = document.getElementById( 'YJSONsubmit' );
		if(s) {
			s.oldvalue = s.value;
			s.value = YJSONsearch.loadingMessage;
			s.disabled = true;
		}
		document.getElementById( YJSONsearch.resultElementID ).innerHTML = YJSONsearch.loadingMessage;
		var url = YJSONsearch.searchAPIURL;
		url += '&query=' + term;
		url += '&appid=' + YJSONsearch.yourAppID;
		url += '&start=' + YJSONsearch.start;
		url += '&results=' + YJSONsearch.amount;
		var newsearch = document.createElement( 'script' );
		newsearch.src = url;
		document.getElementsByTagName( 'head' )[0].appendChild( newsearch );
		//YAHOO.util.Event.preventDefault(e);
	},

	applyHandlers:function(){
		var elms = YAHOO.util.Dom.getElementsByClassName( YJSONsearch.indicatorClass );
		for( var i = 0; i < elms.length; i++ ) {
			if( elms[i].nodeName.toLowerCase() == 'form' ) {
				YAHOO.util.Event.addListener(elms[i], 'submit', YJSONsearch.search); 
			} else {
				YAHOO.util.Event.addListener(elms[i], 'click', YJSONsearch.search); 
			}
		}
	},

	eureka:function( data ) {
		if( document.getElementById('YJSONsubmit' ) ) {
			var s = document.getElementById( 'YJSONsubmit' );
			s.value = s.oldvalue;
			s.disabled = false;
		}
		var item, itemlink, itemsummary, itemtitle;
		var outputElement = document.getElementById( YJSONsearch.resultElementID );
		if( ! outputElement ) { return; }
		outputElement.innerHTML = '';
		var list = document.createElement( 'ul' );
		item = document.createElement( 'li' );
		itemtitle = document.createElement( 'h2' );
		itemtitle.appendChild( document.createTextNode( 'Found '+ data.ResultSet.totalResultsAvailable + ' results' ) );
		item.appendChild( itemtitle );
		list.appendChild( item );
		for( var i in data.ResultSet.Result ) {
			item = document.createElement( 'li' );
			itemtitle = document.createElement( 'h3' );
			itemlink = document.createElement( 'a' );
			itemlink.setAttribute( 'href', data.ResultSet.Result[i].ClickUrl );
			itemlink.appendChild( document.createTextNode( data.ResultSet.Result[i].Title ) );
			itemtitle.appendChild( itemlink );
			itemsummary = document.createElement( 'p' );
			itemsummary.appendChild( document.createTextNode( data.ResultSet.Result[i].Summary ) );
			item.appendChild( itemtitle );
			item.appendChild( itemsummary );
			list.appendChild( item )    
		}
		outputElement.appendChild( list );
	}
}
//YAHOO.util.Event.addListener(window, 'load', YJSONsearch.applyHandlers);

</script>

</head>
<body>
<div id="page">
  <h1>deliSearch  - del.icio.us Search Lists</h1>
  
  <p style="color:red">Find the most recent version of this service <a href="http://blogs.open.ac.uk/Maths/ajh59/searchfeedrplus.php?t=d">here</a>.

  <fieldset><legend>enter
search information</legend>
<form name="dataForm" action="" onsubmit="deliSearch(); return false;">

  <table border='0'>
 <tr><td><label for="usrUser">Delicious User<br />(required; default <em>psychemedia</em>): </label></td>
 <td><input style="width: 200px;"
 id="usrUser" type="text" value="" > (e.g. psychemedia)</td></tr>
 <tr><td><label for="usrTag">Delicious Tag: </label></td><td><input style="width: 200px;"
 id="usrTag"  type="text" value=""> (e.g. web2.0)</td></tr>
<tr>
        <td><label for="usrSearchTerms">Search term(s): </label></td><td><input style="width: 200px;"
 id="usrSearchTerms" type="text" value='' > (e.g. rich internet)</td></tr>

</table>

<p>Search Over: <label><input type='radio' name='searchType' value='domains'  checked=true  /> Domains</label>
<label><input type='radio' name='searchType' value='pages'  /> Pages</label>&nbsp;&nbsp;<input value="deliSearch" class="but" type="submit">
&nbsp;&nbsp;<a href="deliSearchTools.html">Download deliSearch tools...</a></p>
</form>


  <p>Yahoo! results page (visit here if no results show): <span id='output'></span></p>
  <p><span id='deliLink'></span> <span id='add2deli'></span></p></fieldset>
<br />
<div id="YJSONresults"></div>
</div>

<script type="text/javascript">

function init() {
	 }

YAHOO.util.Event.addListener(window, 'load', init);

 var lastSearchTag=''; var notFirstSearch=false;
function getUsrTagPath(){
 var usrTagPath;
 var user= document.getElementById('usrUser').value; 
 var tag=document.getElementById('usrTag').value; 
 if (user!='') {
  user=user.split(' ');
  if (user[0]!='') {
   usrTagPath=user[0];
   if (tag!='') {
    tag=tag.replace ( / /g, '+' );
    usrTagPath+='/'+tag;
   }
  }
 } else {
   usrTagPath='psychemedia';
   if (tag!='') {
    tag=tag.replace ( / /g, '+' );
    usrTagPath+='/'+tag;
   }
 }
 return usrTagPath;
}

function cleanScript(){
  delete this.Delicious;
  head.removeChild(document.getElementById('uploadScript'));
  //head.removeChild(document.getElementById('runScript'));
}

function loadNewJSONScript(tag) {
  var thisSearchTag=getUsrTagPath();
  if (notFirstSearch) {
   if (lastSearchTag==thisSearchTag)
	 if (this.Delicious) // Already exists
 		return; //really should destroy this object and load in our new one

   lastSearchTag=thisSearchTag;
   cleanScript();
   notFirstSearch=true;
  }

  var head = document.getElementsByTagName("head")[0];
  attachJSONFeed(head,tag);
//  attachSearchAction(head);
}

function attachJSONFeed(head,tag){
  var script = document.createElement('script');
  script.id = 'uploadScript';
  script.type = 'text/javascript';
  script.src = "http://del.icio.us/feeds/json/"+tag+"?count=25&callback=performDeliSearchAction";
  head.appendChild(script);
}

function deliSearch(){
 var label= getUsrTagPath();
 var output = document.getElementById('output');
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);

 loadNewJSONScript(label);

}

function performDeliSearchAction(delicious){
   displayNewURL(delicious);
   var myURL=generateNewURL('',delicious);
   YJSONsearch.deliSearch(myURL);
}

function formatTagSearchTerms(el){
 var terms= document.getElementById(el).value;
 terms= terms.replace ( / /g, '+' );
 return terms;
}

function formatUserTerms(){
 var user= document.getElementById('usrUser').value; 
 if (user!='') {
  user=user.split(' ');
  if (user[0]!='') {
    return user[0];
  }
 } else {
   return 'psychemedia';
 }
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

function displayNewURL(delicious) {
 var link = document.createElement('a');
 var label= getUsrTagPath(delicious);
 var output = document.getElementById('output');
 var searchTerms=formatTagSearchTerms('usrSearchTerms');
 var myURL=generateNewURL('http://search.yahoo.com/search?p=',delicious);
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  link.setAttribute('href', myURL);
  //linkTxt='deliSearch del.icio.us/'+label+' over '+searchType()+' for '+searchTerms;
  linkTxt='Yahoo! results page';
 }
 link.setAttribute('id','myURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link); 

 deliLinkURL();add2delicious();
}

function deliLinkURL() {
 var output = document.getElementById('deliLink');
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
 var link = document.createElement('a');
 var usr=formatUserTerms();
 var tag=formatTagSearchTerms('usrTag');
 var query=formatTagSearchTerms('usrSearchTerms');
 var searchtype=searchType();
 var myURL='http://blogs.open.ac.uk/Maths/ajh59/deliSearch.php?u='+usr+'&t='+tag+'&q='+query+'&s='+searchtype;
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  link.setAttribute('href', myURL);
  //linkTxt='deliSearch del.icio.us/'+usr+'/'+tag+' over '+searchtype+' for '+query;
  linkTxt='Link to this results page';
 }
 link.setAttribute('id','deliURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link); 
}

function add2delicious() {
 var output = document.getElementById('add2deli');
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
 var link = document.createElement('a');
 var usr=formatUserTerms();
 var tag=formatTagSearchTerms('usrTag');
 var query=formatTagSearchTerms('usrSearchTerms');
 var searchtype=searchType();
 var myURL='http://blogs.open.ac.uk/Maths/ajh59/deliSearch.php?u='+usr+'&t='+tag+'&q='+query+'&s='+searchtype;
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  myURL='http://del.icio.us//post?title=deliSearch:%20'+usr+'/'+tag+' over '+searchtype+' for '+query+'&url='+escape(myURL);
  link.setAttribute('href', myURL);
  linkTxt='+2 del.icio.us';
 }
 link.setAttribute('id','deliURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link); 
}

function searchType(){
 var customType='pages';
 for (var i=0;i<document.dataForm.searchType.length;i++)
   if (document.dataForm.searchType[i].checked==true)
    customType=document.dataForm.searchType[i].value;
 return customType;
}

function generateNewURL(root, delicious){
 var searchTerms = formatTagSearchTerms('usrSearchTerms');
 var searchString;
 var tmp; var url; var myURL='';
 if (delicious) {
  var customType=searchType(); var encURL;
  searchString=escape(searchTerms)+'+(';
  for (var i=0, post; post = delicious[i]; i++) {
    if (customType=='pages') {
     //hack
     encURL=escape(encodeURIComponent(post.u));
     tmp=searchString+'url:'+encURL;
     if (tmp.length<1400) searchString+='url:'+encURL+'%20OR%20'; else break;
    } else {
	url=parseUrlDomain(post.u)
	tmp=searchString+'site:'+url;
	if  (searchString.search(url)==-1)
	 if (tmp.length<1400)
		searchString+='site:'+url+'%20OR%20'; else break;
    }
  }
  searchString+=')';
  //myURL='http://search.yahoo.com/search?p='+searchString;
  myURL=root+searchString;
 }

  return myURL;
}
</script>
</body>
</html>