function getElementsByClass(searchClass,tag) {
	var classElements = new Array();
	if ( tag == null )
		tag = '*';
	var els = document.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp('(^|\\s)'+searchClass+'(\\s|$)');
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function remove(s, t) {
  var i = s.indexOf(t);
  var r = "";
  if (i == -1) return s;
  r += s.substring(0,i) + remove(s.substring(i + t.length), t);
  return r;
  }

function generateYouTubePlaylistItems(){
 var ids='';
 var items=getElementsByClass('myvTitle','div');
 for (var i=0; i<items.length;i++) {
  if (items[i].getElementsByTagName('a')[0])
   ids+=items[i].getElementsByTagName('a')[0].getAttribute('href')+',';
 }
 ids=remove(ids,'/watch?v=');
 return ids;
}

function createPlayListGeneratorURL(){
 var url='http://blogs.open.ac.uk/Maths/ajh59/youTubeOPMLPlaylist.php?id='+generateYouTubePlaylistItems();
 //alert(url);
 window.location=url;
}

function generateYouTubePlaylistItemPairs(){
 var ids='';
 var items=getElementsByClass('myvTitle','div');
 for (var i=0; i<items.length;i++) {
  if (items[i].getElementsByTagName('a')[0])
   ids+=items[i].getElementsByTagName('a')[0].getAttribute('href')+';'+encodeURI(items[i].getElementsByTagName('a')[0].firstChild.nodeValue)+',';
 }
 ids=remove(ids,'/watch?v=');
 return ids;
}

function generateYouTubePublicPlaylistItemPairs(){
 var ids='';
 var items=getElementsByClass('title','div');
 for (var i=0; i<items.length;i++) {
  if (items[i].getElementsByTagName('a')[0])
   ids+=items[i].getElementsByTagName('a')[0].getAttribute('href').split('&')[0]+';'+encodeURI(items[i].getElementsByTagName('a')[0].firstChild.nodeValue)+',';
 }
 ids=remove(ids,'/watch?v=');
 return ids;
}

function createPlayListGeneratorURL2(){
 var url='http://blogs.open.ac.uk/Maths/ajh59/youTubeOPMLPlaylist.php?id2='+generateYouTubePlaylistItemPairs();
 //alert(url);
 window.location=url;
}

function createPlayListGeneratorURL2b(){
 var url='http://blogs.open.ac.uk/Maths/ajh59/youTubeOPMLPlaylist.php?id2='+generateYouTubePublicPlaylistItemPairs();
 //alert(url);
 window.location=url;
}

//createPlayListGeneratorURL();
var thisURL=document.URL;
if (thisURL.indexOf('http://www.youtube.com/my_playlists')==0) createPlayListGeneratorURL2();
else if (thisURL.indexOf('http://www.youtube.com/view_play_list')==0) createPlayListGeneratorURL2b();