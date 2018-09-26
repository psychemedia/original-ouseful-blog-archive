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
#page {
	text-align: left;
	margin: 0 auto;
	padding: 20px;
	width: 600px;
	background-color: #fff;
	border: 1px solid #ccc;
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
	margin: 10px 0 20px 20px;
	padding: 0;
}
ul li, ol li {
	list-style-type: none;
	color: #777;
	margin: 3px 0 0;
	padding: 0;
}
ul li:before {
	content: "\00BB \0020";
}
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

table.sbApps tr td {
	width: 200px;
}

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
 .example {font-size:60%}
</style>

</head>
<body>

<div id="page">
  <h1>pagefeedr <span id="strapline">feed your own search</span></h1>
<p style="color:red">Find the most recent version of this service <a href="http://blogs.open.ac.uk/Maths/ajh59/searchfeedrplus.php?t=p">here</a>.
  <p>Search across pages or domains listed in a given web page.</p>

 <fieldset><legend>enter
search information</legend>
<form name="dataForm" action="" onsubmit="deliSearch(); return false;">

  <table border='0'>
 <tr><td><label for="usrUser">Page URL: </label></td><td><input style="width: 400px;"
 id="usrFeed" type="text" value="" /><br /><span class="example">(e.g. http://blogs.open.ac.uk/Maths/ajh59/)</span></td></tr>
<tr>
        <td><label for="usrSearchTerms">Search term(s): </label></td><td><input style="width: 400px;"
 id="usrSearchTerms" type="text" value='' /><br /><span class="example">(e.g. css)</span></td></tr>

</table>

<p>Action Type: <label><input type='radio' name='actionType' value='search'  checked=true  /> Perform Search</label>
<label><input type='radio' name='actionType' value='url'/> Generate Yahoo!Search URL</label></p>

<p>Search Over: <label><input type='radio' name='searchType' value='domains'  checked=true   /> Domains</label>
<label><input type='radio' name='searchType' value='pages'   /> Pages</label></p>

<p><input value="Search pageLinks" class="but" type="submit"> <a href="http://delisearch.searchfeedr.com/deliSearchTools.html#pagesearch">Download searchfeedr tools</a></p>
</form>

  <p>Here is your URL: <span id='output'></span></p>
</fieldset>

<br /> 
<iframe id="resultsFrame" name="resultsFrame" src="" scrolling="yes" 
 height="400" frameborder="0" width="600">
</iframe>

</div>

<script type="text/javascript">


function init() {
	}

YAHOO.util.Event.addListener(window, 'load', init);

var lastSearchTag=''; var notFirstSearch=false;

function cleanScript(){
  delete this.Delicious;
  head.removeChild(document.getElementById('uploadScript'));
  //head.removeChild(document.getElementById('runScript'));
}

function loadNewJSONScript(tag) {
  var thisSearchTag=document.getElementById('usrFeed').value;//getUsrTagPath();
  if (notFirstSearch) {
   if (lastSearchTag==thisSearchTag)
	 if (this.Delicious) // Already exists
 		return; //really should destroy this object and load in our new one

   lastSearchTag=thisSearchTag;
   cleanScript();
   notFirstSearch=true;
  }

  var head = document.getElementsByTagName("head")[0];
 attachJSONFeed2(head);

}

function attachJSONFeed2(head){
  var script = document.createElement('script');
  script.id = 'uploadScript';
  script.type = 'text/javascript';
  var feedURL=escape(document.getElementById('usrFeed').value);

//  var browseURL="http://b1.bitty.com/b2browser/?contenttype=rssfeed&contentvalue="+escape(feedURL);
//  document.getElementById('fsBrowse').setAttribute('src',browseURL);

  //feedURL="http://psychemediasxoxotools.ning.com/outlineconvert.php?output=json&classes=items&url="+feedURL+"&callback=performDeliSearchAction";
  feedURL="http://ouseful.open.ac.uk/pagelinks2json.php?url="+feedURL;
  //alert(feedURL);
  script.src=feedURL;
  head.appendChild(script);
}


function deliSearch(){

 var output = document.getElementById('output');
 for (;output.childNodes.length>0;) output.removeChild(output.firstChild);
 var label="need to clean this";
 loadNewJSONScript(label);

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

function performDeliSearchAction(delicious){
 //delicious=feedjson2deljson(delicious);
 var customtype;
 for (var i=0;i<document.dataForm.actionType.length;i++)
  if (document.dataForm.actionType[i].checked==true)
   customType=document.dataForm.actionType[i].value;
 switch(customType){
  case 'search':
   loadURL(delicious);
   break;
  case 'url':
   displayNewURL(delicious);
   break;
  default:
   break;
 }
}

function loadURL(delicious){
 var myURL=generateNewURL(delicious);
// if (myURL!='') window.location=myURL;
 if (myURL!='') frames['resultsFrame'].location.href=myURL;
}

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

function displayNewURL(delicious) {
 var link = document.createElement('a');
// var label= getUsrTagPath(delicious);
 var output = document.getElementById('output');
 var searchTerms=formatSearchTerms();
 var myURL=generateNewURL(delicious);
 var linkTxt='Hmm - there seems to be an error.';
 if (myURL!=''){
  link.setAttribute('href', myURL);
  linkTxt='Search for '+searchTerms;
 }
 link.setAttribute('id','myURL');
 link.appendChild(document.createTextNode(linkTxt));
 output.appendChild(link); 
}

function generateNewURL(delicious){
 var searchTerms = formatSearchTerms();
 var searchString;
 var tmp; var url; var myURL='';
 if (delicious) {
  var customtype; var encURL;
  for (var i=0;i<document.dataForm.searchType.length;i++)
   if (document.dataForm.searchType[i].checked==true)
    customType=document.dataForm.searchType[i].value;

  searchString=escape(searchTerms)+'+(';
  for (var i=0, post; post = delicious[i]; i++) {
    if (customType=='pages') {
     encURL=encodeURIComponent(post.u);
     tmp=searchString+'url:'+encURL;
     if (encURL!='') if (tmp.length<1400) searchString+='url:'+encURL+'%20OR%20'; else break;
    } else {
	url=parseUrlDomain(post.u)
	tmp=searchString+'site:'+url;
	if (url!='') if  (searchString.search(url)==-1)
	 if (tmp.length<1400)
		searchString+='site:'+url+'%20OR%20'; else break;
    }
  }
  searchString+=')';
  myURL='http://search.yahoo.com/search?p='+searchString;
 }

  return myURL;
}
</script>
</body>