<html>
<title>openLearn Feed Annotation Streams</title>
<head>

<style>
dl {margin:12px;}
dt {font-weight:bold;}
dd {margin-bottom:8px;}
</style>

<script>
/* these calls are just the plumbing */

pipesrpc = {};
pipesrpc._timeoutlength = 30000;  /* 30 seconds by default */
pipesrpc._running = [];

pipesrpc._timeout = function(id,url) {
    var cbo = pipesrpc._running[id];
    pipesrpc._running[id]=null;
    if (!cbo.callbackErr) return;
    cbo.callbackErr("Timeout",-1,cbo.self);
}

pipesrpc._buildurl = function(pipeid,params) {
	var url = "http://pipes.yahoo.com/pipes/pipe.run?_id="+pipeid+"&_render=json";
	if (params) {
    	for (var key in params) {
            if (params[key]===null) continue;
    		url+="&"+encodeURIComponent(key)+"="+encodeURIComponent(params[key])
    	}
	}
    return url;
}

pipesrpc._callbackhandler = function(o) {
	var cbo = pipesrpc._running[callbackIndex];
    if (!cbo) return;
    pipesrpc._running[callbackIndex]=null;
   	window.clearTimeout(cbo.timeout);
   	if (!o || !o.count) {
   	    if (!cbo.callbackErr) return;
        cbo.callbackErr("Bad response",-2,cbo.self);
        return;
   	}
    if (!cbo.callbackOk) return;
    cbo.callbackOk(o,cbo.self);
}

pipesrpc._execute = function(url,callbackOk,callbackErr,timeoutlength) {
    if (!timeoutlength) timeoutlength = pipesrpc._timeoutlength;
    var id = pipesrpc._running.length;
  	url+="&_callback=pipesrpc._callbackhandler_"+id;
    var s=document.createElement("script");
    s.setAttribute("src",url);
    var fn = ""+pipesrpc._callbackhandler;
    fn = fn.replace(/callbackIndex/g,id);
    eval("pipesrpc._callbackhandler_"+id+"="+fn);
    pipesrpc._running.push({self:this,callbackOk:callbackOk,callbackErr:callbackErr,timeout:window.setTimeout(function() { pipesrpc._timeout(id,url); },timeoutlength)});    
    document.getElementsByTagName("head")[0].appendChild(s);
    return id;
}

/* use these three calls to run and cancel Pipes calls */
pipesrpc.cancelrequest = function(id) {
	var cbo = pipesrpc._running[i];
    window.clearTimeout(cbo.timeout);
    pipesrpc._running[i]=null;
}

pipesrpc.cancelallrequests = function() {
    for (var i=0; i< pipesrpc._running.length; i++) {
        pipesrpc._cancelrequest(i);
    }	
}

pipesrpc.run = function(pipeid,params,callbackOk,callbackErr,timeoutLength) {
    return pipesrpc._execute(pipesrpc._buildurl(pipeid,params),callbackOk,callbackErr,timeoutLength);
}

/* This is the example */
function init() {
	var feedURL=document.getElementById('feedURL').value; //alert(feedURL)
	var params={"url":feedURL};//"http://newsrss.bbc.co.uk/rss/newsplayer_uk_edition/sci-tech/rss.xml"};
	
	var requestId = pipesrpc.run("GBA3STQx3BGnYWcHqGIyXQ",params,
	    function(data) {
	    	//loop and create a dl dt/dd list.
	    	//Note: its much quicker to create using an HTML string but this looks nicer in an example
	        var output = document.getElementById('output');
	        for (;output.childNodes.length>0;) output.removeChild(output.firstChild);

			
	       	 var dl = document.createElement("dl");
	        	for (var i=0; i< data.count; i++) {
	        		var item = data.value.items[i];
	        		var dt = document.createElement("dt");
	       		 	dt.innerHTML = item.title;
	        		dl.appendChild(dt);
	        		var dd = document.createElement("dd");
	        	
	        		if (data.value.items[i].openlearn[0].title=="Error Making RSS Feed") 
					{
						dd.innerHTML =item.description +" [<a href='"+item.link+"'>open</a>]" +"<br /><em>No OpenLearn annotations - timed out? (try again: <a href='http://pipes.yahoo.com/pipes/pipe.info?olSearchQuery="+escape(item.tags)+"&=Run+Pipe&_id=uHUU3Gq32xGtaUcNphr_og&_run=1'>"+item.tags+"</a>)</em><br />";
					} else {
						var annotations="<br />OpenLearn Links (<em><a href='http://pipes.yahoo.com/pipes/pipe.info?olSearchQuery="+escape(item.tags)+"&=Run+Pipe&_id=uHUU3Gq32xGtaUcNphr_og&_run=1'>"+item.tags+"</a></em>): <br />";
	        			for (var j=0; j< data.value.items[i].openlearn.length; j++) {
	        		 		annotations+="<a href='"+item.openlearn[j].link+"'>"+data.value.items[i].openlearn[j].title.replace(" - LearningSpace - OpenLearn - The Open University","")+"</a><br />";
	        			}
	        			dd.innerHTML = item.description +" [<a href='"+item.link+"'>open</a>]" +annotations;
	        		}
	   
	        		dl.appendChild(dd);

	      		}
		    	output.appendChild(dl);
		}
	);
}

//window.onload = init;
</script>

</head>

<body>
<h1>OpenLearn Feed Annotation Streams</h1>
<p>Annotate an RSS feed with links to related OpenLearn content.</p>
<p>This thirty minute mashup passes an RSS feed through the Yahoo Pipes
Content Analysis service, which annotates each feed item with appropriate subject tags. These tags are then used as search terms
for an OpenLearn search (itself powered by a Dapper screenscraper); Openlearn serarch results are then appended to the corresponding feed item.</p>
<p>The pipe needs optimising with respect to duplicate search terms/content analysis tags - at the moment, searches are quite likely to time out.</p>
<form name="getFeed" onsubmit="init();return false" />
<input type="text" value='http://environment.independent.co.uk/climate_change/index.jsp?service=rss' size="80" id="feedURL" />
<input type="submit" value="annotate feed" />
</form>
<hr />
<div id="output"></div>
</body>
</html>
