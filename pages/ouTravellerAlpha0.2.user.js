// ==UserScript==
// @name          OU Traveller (alpha 0.2)
// @namespace     http:/ouseful.open.ac.uk/blog/
// @description	  Search the Open University Library Catalogue from generic book listings, based on script from http://www.mundell.org and http://www.daveyp.com/blog
// @include       *
// @exclude       http://blogs.open.ac.uk/*
// ==/UserScript==

//These scripts being developed by Tony Hirst, http://ouseful.open.ac.uk/blog

// Add a 'close box' option
// Offer a 'request this book' option for books not in the Library Catalogue
// Get results from mutliple lookups// First step, create the Traveller panel away from the lookup function.
// For example, looking up the ISBN on the Voyager Library catalogue and O'Reilly Safari
// First step, create the Traveller panel away from the lookup function.
// fixed for Firefox 1.5 and GM 0.6.4

(function()
{


//--------------------------------
    var amazonHandler =
    {
	//get Book Info for an ISBN for Amazon
	getISBNBookInfo: function(callback)
	{
		var isbn = window.content.location.href.match(/([\/-]|is[bs]n=|searchData=)(\d{7,9}[\dX])/i)[2];//getISBN();
		//Use any book lookup service that accepts an ISBN and returns book data as XML 
		var URL = "http://webservices.amazon.co.uk/onca/xml?Service=AWSECommerceService&Version=2005-03-23&Operation=ItemLookup&ContentType=text%2Fxml&SubscriptionId=0DK8EWAWVKXSH8SEMVR2&ItemId="+isbn+"&ResponseGroup=Images,ItemAttributes";
		GM_xmlhttpRequest({
		  method:"GET",
		  url:URL,
		  headers:{ "User-Agent":"monkeyagent","Accept":"text/monkey,application/xml,text/xml",},
		  onload:function(details){ callback(details)}
		});
	}
    }

    var handleOUBookRequest =
    {

	handleRequestForm: function(author, title, pubdate, publisher,price, isbn)
	{
		//var uri='http://library.open.ac.uk/waltonhall/book/bookrequest.php';
		var uri='http://blogs.open.ac.uk/Maths/ajh59/demoBookDetailsForm.php';
		var f=document.createElement('form');
		f.method='post';
		f.setAttribute('name','test');
		f.action=uri;
		OUTraveller.createFormInputElement(f,'isbn',isbn);
		OUTraveller.createFormInputElement(f,'dateofpub',pubdate);
		OUTraveller.createFormInputElement(f,'author',author);
		OUTraveller.createFormInputElement(f,'itemtitle',title);
		OUTraveller.createFormInputElement(f,'price',price);
		OUTraveller.createFormInputElement(f,'publisher',publisher);
		document.body.appendChild(f);
		f.submit();
	},

	generateRequestDetails: function(details)
	{
	   var parser = new DOMParser();
	   var dom = parser.parseFromString(details.responseText,
        	    "application/xml");

	   if (!dom.getElementsByTagName('Errors').length){
		//this is too clunky - need to go by name until IDs are sorted on form...
		var author=dom.getElementsByTagName('Author')[0].textContent;
		var title=dom.getElementsByTagName('Title')[0].textContent;
		var publisher=dom.getElementsByTagName('Publisher')[0].textContent;
		var pubdate=dom.getElementsByTagName('PublicationDate')[0].textContent;
		var price=dom.getElementsByTagName('FormattedPrice')[0].textContent;
		var isbn=dom.getElementsByTagName('ISBN')[0].textContent;
		handleOUBookRequest.handleRequestForm(author,title,pubdate,publisher,price,isbn);
	    } else alert('Error looking up '+isbn+' as an ISBN');
	},
	addRequestLink: function(){
		OUTraveller.insertFormHandlerLink (
                	"Request book",
                	"Request this book from " + libraryName,
                	"blue",handleOUBookRequest.lookupRequestDetails
			);
	},
	lookupRequestDetails: function(){
		amazonHandler.getISBNBookInfo(handleOUBookRequest.generateRequestDetails);
	}
    }


//----------------- Citation generation service ---------------

// This function demonstrates how to populate a form that is used to call a third party service

    var handleBookCitation =
    {

	handleRequestForm: function(author, title, pubdate, publisher,price, isbn)
	{
		var uri='http://www.studentabc.com/app/action/Compose';
		var f=document.createElement('form');
		f.method='post';
		var dateInfo=pubdate.split('-');
		pubdate=pubdate.split('-')[0];
		f.setAttribute('name','test');
		f.action=uri;
		var authorDet=author.split(' ');
		OUTraveller.createFormInputElement(f,'style','apa');
		OUTraveller.createFormInputElement(f,'type','book');
		OUTraveller.createFormInputElement(f,'author.last.input.1',authorDet[authorDet.length-1]);
		OUTraveller.createFormInputElement(f,'author.first.input.1',authorDet[0]);
		OUTraveller.createFormInputElement(f,'publisher.input',publisher);
		OUTraveller.createFormInputElement(f,'date.year.input',pubdate);
		if (dateInfo.length>1) OUTraveller.createFormInputElement(f,'date.month.input',dateInfo[1]);
		if (dateInfo.length>2) OUTraveller.createFormInputElement(f,'date.day.input',dateInfo[2]);
		OUTraveller.createFormInputElement(f,'title.input',title);
		OUTraveller.createFormInputElement(f,'dateInputField','July+6%2C+2006');
		document.body.appendChild(f);
		f.submit();
	},

	generateRequestDetails: function(details)
	{
	   var parser = new DOMParser();
	   var dom = parser.parseFromString(details.responseText,
        	    "application/xml");

	   if (!dom.getElementsByTagName('Errors').length){
		var author=dom.getElementsByTagName('Author')[0].textContent;
		var title=dom.getElementsByTagName('Title')[0].textContent;
		var publisher=dom.getElementsByTagName('Publisher')[0].textContent;
		var pubdate=dom.getElementsByTagName('PublicationDate')[0].textContent;
		var price=dom.getElementsByTagName('FormattedPrice')[0].textContent;
		var isbn=dom.getElementsByTagName('ISBN')[0].textContent;
		handleBookCitation.handleRequestForm(author,title,pubdate,publisher,price,isbn);

	    } else alert('Error looking up '+isbn+' as an ISBN');
	},

	addBookCitationLink: function()
	{
	    // Add the 'cite this book' link
	    OUTraveller.insertFormHandlerLink (
                            "Cite book",
                            "Cite this book",
                            "blue",handleBookCitation.lookupCitationDetails
			);
	},
	lookupCitationDetails:function(){
		amazonHandler.getISBNBookInfo(handleBookCitation.generateRequestDetails);
	}
    }

//----------------GENERIC LOOKUP PATTERN--------------------
// This pattern looks to see if a book, keyed by ISBN, is available or not available via a specified service

// urlStub is the URL to which an ISBN is added for an ISBN lookup
// name is the name of the service being looked up
// scrapePattern is the pattern that is to scrape a looked up page
// availability (true|false) says whether the books is available|unavailable if scrapePattern is found
// isbn is the ISBN of the book to be looked up

    var genericLookup = 
    {
        doLookup: function (urlStub, name, scrapePattern, availability,isbn )
        {
	   var verbose=0; var unavailability=false;
           GM_xmlhttpRequest
            ({
                method:'GET',
                url: urlStub + isbn,
                onload:function(results)
                {
                    page = results.responseText;
                    if (availability) 
		    {
		     if (scrapePattern.test(page))
                     {
                        OUTraveller.insertLink(
                            urlStub +isbn,
                            "available now",
                            "Available at " + name,
                            "green"
                        );
                     }
		    } else if (!(scrapePattern.test(page)))
		     {
                        OUTraveller.insertLink(
                            urlStub +isbn,
                            "available now",
                            "Available at " + name,
                            "green"
                        );
                     } else if (verbose)
                    {
                        OUTraveller.insertLink (
                            urlStub +isbn,
                            "Unavailable",
                            "No results are being returned from " + name,
                            "orange"
                        );
                    }
                }
            });
        }


    }

//----------------GOOGLE BOOKS LOOKUP--------------------

    var gBooksUrlPattern = 'http://books.google.com/books?vid=ISBN'
    var gBooksName = "Google Books";
    var gBooksUnavailability = /Not Found/;
    //genericLookup.doLookup(gBooksUrlPattern, gBooksName, gBooksUnavailability, false,isbn );


//----------------SAFARI LOOKUP--------------------

    var safariUrlPattern = 'http://safari.oreilly.com/?XmlId='
    var safariName = "O'Reilly Safari";
    var safariAvailability = /Start Reading/;
    //genericLookup.doLookup(safariUrlPattern, safariName, safariAvailability, true,isbn );


//------------------LIBRARY LOOKUP

    var libraryUrlPattern = 'http://ouseful.open.ac.uk/voyager/isbn/'
    var libraryName = 'the Open University Library';
    var libraryOffline=/The Online Public Access Catalog is not available/;
    var libraryAvailability = /[In the library|Displaying 1 of 1]/;
    var libraryElectronic = /Electronic Book/;
    var libraryOtherEditions = /other editions available/;
    var libraryOnOrder = /On Order/;
    var libraryInProcess = /In Cataloguing/;
  //  var libraryEZProxy=/http://libezproxy.open.ac.uk/login?url=(*)/;
    var librarySeveralVersions = /Displaying 1 through/
    var libraryDueBack = /(\d{2}\/\d{2}\/\d{4})/;
    var notFound = /Your search resulted in no hits/;

    var libraryLookup = 
    {
	bookDetails:function(details) {
	   var parser = new DOMParser();
	   var dom = parser.parseFromString(details.responseText,
        	    "application/xml");

	   if (!dom.getElementsByTagName('Errors').length){

		// pull the author details out of the returned XML file
		var author=dom.getElementsByTagName('Author')[0].textContent;

		// pull the title details out of the returned XML file
		var title=dom.getElementsByTagName('Title')[0].textContent;

	    	//------ title lookup link -------

		// By inspection of a sample query using the VOyager interface,
		//   the OU Voyager catalogue seems to like +'s rather than spaces...
	    	title=title.replace(/\s+/g,'+');

		// Some Amazon results have additional info in brackets added to the title
		//   e.g. (Penguin Classic Edition). So dump everything in brackets...
		title=title.replace(/\(.*\)/g, '');
		title=title.replace(/\[.*\]/g, '');
		// Add the link that will make a title query to the OU Library catalogue
            	OUTraveller.insertLink (
               		'http://voyager.open.ac.uk/cgi-bin/Pwebrecon.cgi?Search_Arg='+title+'&Search_Code=TKEY&CNT=25&HIST=1&SEARCH_FROM_TITLES_PAGE=Y',
               		"Title Search",
               		"Try a title search at "+libraryName,
               		"orange"
            	);		

	    	//------ author lookup link -------

		// The Amazon data seems to give the author result as a variant of 'firstname lastname' 
		// So just use the last word in the Author data (hopefully it's the Author's surname...)
		// and a dodgy heuristic for the first name
		author=author.replace(/\.*/,'');
		author=author.split(' ');
		author=author[author.length-1]+'+'+author[0].charAt(0);

		// Add the link that will make an author query to the OU Library catalogue
             	OUTraveller.insertLink (
               		'http://voyager.open.ac.uk/cgi-bin/Pwebrecon.cgi?Search_Arg='+author+'&Search_Code=NAME_&CNT=25&HIST=1',
               		"Author Search",
               		"Try an author search at "+libraryName,
               		"orange"
            	);	

	    } else alert('Error looking up '+isbn+' as an ISBN');

	},
        doLookup: function ( isbn )
        {
            GM_xmlhttpRequest
            ({
                method:'GET',
                url: 'http://ouseful.open.ac.uk/voyager/isbn/' + isbn,
                onload:function(results)
                {
                    page = results.responseText;
                    if  (libraryOffline.test(page))
		    {
                        OUTraveller.insertLink (
                            '',
                            "Error",
                            "The " + libraryName+" is currently offline.",
                            "orange"
                        );
		    }
		    else if ( notFound.test(page) )
                    {
                        var due = page.match(notFound)[1]
			//if the call to amazon has already been made, we need to reuse that data...
	    		amazonHandler.getISBNBookInfo(libraryLookup.bookDetails);
			handleOUBookRequest.addRequestLink();
                   }
                    else if ( libraryDueBack.test(page) )
                    {
                        var due = page.match(libraryDueBack)[1]
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "due back " + due,
                            "Due back at " + libraryName + " on " + due,
                            "#AA7700"  // dark yellow
                        );
                    }
                    else if ( libraryAvailability.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "available now",
                            "Available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( librarySeveralVersions.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "severl versions available",
                            "Several versions of this title are available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryElectronic.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "available electronically",
                            "Available in electronic format from " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryOtherEditions.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "other editions available",
                            "Other editions of this title are available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryOnOrder.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "on order",
                            "On order at " + libraryName,
                            "#AA7700"  // dark yellow
                        );
                    }                    
                    else if ( libraryInProcess.test(page) )
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "In process!",
                            "In process (available soon) at " + libraryName,
                            "#AA7700"  // dark yellow
                        );
                    }                    
                else
                    {
                        OUTraveller.insertLink (
                            libraryUrlPattern +isbn,
                            "Error",
                            "Error checking " + libraryName,
                            "orange"
                        );
                    }
                }
            });
        }


    }

//--------------------------------

    var OUTraveller =
    {

	createPanel:function(isbn){

            var body = document.getElementsByTagName('body')[0];
 	    var div=document.createElement('div');
	    div.setAttribute('style','left:0px;top:0px;z-index:999;background-color:#ffff00;border:1px solid #000000;color:#000000;padding: 0px;position: absolute;');

	    var logo=document.createElement('img');
	    logo.setAttribute('src','http://www.open.ac.uk/wwwcommon/oulogo_hor.gif');
	    logo.setAttribute('alt','OU logo');

	    var title=document.createElement('div');
	    var label = document.createTextNode( 'OU Library Traveller' );
	    title.appendChild(label);

		var close = window.document.createElement("div");
/* ************************************************************ 
 *   Set the pointer on the close button to cursor so that it 
 *	looks like you can do something with it.
 * ************************************************************ */
		OUTraveller.dom_setStyle(close,
"margin:0px;position:absolute;top:3px;right:3px;width:10px;height:10px;border:1px solid #ffc;line-height:8px;text-align:center;cursor:pointer;");
		close.setAttribute("title","Click to close panel");
		close.addEventListener('click', function() { this.parentNode.parentNode.style.display = "none"; }, true);
		close.appendChild(window.document.createTextNode("x"));
		title.appendChild(close);
 /* ************************************************************ */

	    title.setAttribute('style','background:#0000FF;cursor:move;color:white;');

	    div.appendChild(title);

	    var divStyled=document.createElement('div');
	    divStyled.setAttribute('style','border:1px solid #e4e4e4;padding:1em; background:#efefff');
	    divStyled.setAttribute('id','travellerPanel');       
            var br = document.createElement('br');

	    divStyled.appendChild(logo);
	    divStyled.appendChild(br);

	    div.appendChild(divStyled);
	    body.appendChild(div);

	    title.drag = new Drag(title, div); // make draggable

	    libraryLookup.doLookup(isbn);

	    handleBookCitation.addBookCitationLink();

	    genericLookup.doLookup(safariUrlPattern, safariName, safariAvailability, true,isbn );
	    genericLookup.doLookup(gBooksUrlPattern, gBooksName, gBooksUnavailability, false,isbn );
	},

	// create a single form element
	createFormInputElement: function(f,n,v){
		var el=document.createElement('input');
		el.type='text';
		el.name=n;
		el.value=v;
		f.appendChild(el);
	},

        insertLink: function(href, hrefTitle, aLabel, color )
        {
		var divStyled=document.getElementById('travellerPanel');
		var link = document.createElement('a');
		link.setAttribute ( 'title', hrefTitle );
		link.setAttribute('href', href);
		link.setAttribute('style','font-size:small; font-weight:bold; color:' + color);

	        var label = document.createTextNode( aLabel );
        	link.appendChild(label);
		divStyled.appendChild(link);

        	var br = document.createElement('br');
		divStyled.appendChild(br);
        },

	insertFormHandlerLink: function(hrefTitle, aLabel, color, callback){
		var divStyled=document.getElementById('travellerPanel');
		var link = document.createElement('a');
		link.setAttribute ( 'title', hrefTitle );
		link.setAttribute('style','font-size:small; font-weight:bold; color:' + color);

	        var label = document.createTextNode( aLabel );
        	link.appendChild(label);
		link.addEventListener('click', callback, true );

		divStyled.appendChild(link);
        	var br = document.createElement('br');
		divStyled.appendChild(br);

	},

	dom_setStyle: function(elt, str) {
		elt.setAttribute("style", str);
		// for MSIE:
		if (elt.style.setAttribute) {
			elt.style.setAttribute("cssText", str, 0);
			// positioning for MSIE:
			if (elt.style.position == "fixed") {
				elt.style.position = "absolute";
			}
		}
	}
    }


//--------------------------------
// Modified DOM-Drag taken from  http://www.xs4all.nl/~jlpoutre/BoT/Javascript/RSSpanel/ 
// (originally based on Book Burro 0.16)
var Drag = function(){ this.init.apply( this, arguments ); };

Drag.fixE = function( e )
{
  if( typeof e == 'undefined' ) e = window.event;
  if( typeof e.layerX == 'undefined' ) e.layerX = e.offsetX;
  if( typeof e.layerY == 'undefined' ) e.layerY = e.offsetY;
  return e;
};

Drag.prototype.init = function( handle, dragdiv )
{
  this.div = dragdiv || handle;
  this.handle = handle;
  if( isNaN(parseInt(this.div.style.left)) ) this.div.style.left  = '0px';
  if( isNaN(parseInt(this.div.style.top)) ) this.div.style.top = '0px';
  this.onDragStart = function(){};
  this.onDragEnd = function(){};
  this.onDrag = function(){};
  this.onClick = function(){};
  this.mouseDown = addEventHandler(this.handle, 'mousedown', this.start, this);
};

Drag.prototype.start = function( e )
{
  // this.mouseUp = addEventHandler(this.handle, 'mouseup', this.end, this);
  e = Drag.fixE(e);

  this.started = new Date();
  var y = this.startY = parseInt(this.div.style.top);
  var x = this.startX = parseInt(this.div.style.left);
  this.onDragStart(x, y);
  this.lastMouseX = e.clientX;
  this.lastMouseY = e.clientY;
  this.documentMove = addEventHandler(document, 'mousemove', this.drag, this);
  this.documentStop = addEventHandler(document, 'mouseup', this.end, this);
  if (e.preventDefault) e.preventDefault();
  return false;
};

Drag.prototype.drag = function( e )
{
  e = Drag.fixE(e);
  var ey = e.clientY;
  var ex = e.clientX;
  var y = parseInt(this.div.style.top);
  var x = parseInt(this.div.style.left);
  var nx = ex + x - this.lastMouseX;
  var ny = ey + y - this.lastMouseY;
  this.div.style.left	= nx + 'px';
  this.div.style.top	= ny + 'px';
  this.lastMouseX	= ex;
  this.lastMouseY	= ey;
  this.onDrag(nx, ny);
  if (e.preventDefault) e.preventDefault();
  return false;
};

Drag.prototype.end = function()
{
  removeEventHandler( document, 'mousemove', this.documentMove );
  removeEventHandler( document, 'mouseup', this.documentStop );
  var time = (new Date()) - this.started;
  var x = parseInt(this.div.style.left),  dx = x - this.startX;
  var y = parseInt(this.div.style.top), dy = y - this.startY;
  this.onDragEnd( x, y, dx, dy, time );
  if( (dx*dx + dy*dy) < (4*4) && time < 1e3 )
    this.onClick( x, y, dx, dy, time );
};

function removeEventHandler( target, eventName, eventHandler )
{
  if( target.addEventListener )
    target.removeEventListener( eventName, eventHandler, true );
  else if( target.attachEvent )
    target.detachEvent( 'on' + eventName, eventHandler );
}

function addEventHandler( target, eventName, eventHandler, scope )
{
  var f = scope ? function(){ eventHandler.apply( scope, arguments ); } : eventHandler;
  if( target.addEventListener )
    target.addEventListener( eventName, f, true );
  else if( target.attachEvent )
    target.attachEvent( 'on' + eventName, f );
  return f;
}


    try 
    { 
	//isbn regexp taken from Udell's library lookup - http://weblog.infoworld.com/udell/stories/2002/12/11/librarylookup.html
	var isbn = window.content.location.href.match(/([\/-]|is[bs]n=|searchData=)(\d{7,9}[\dX])/i)[2];  }

    catch (e)
    { return; }

	OUTraveller.createPanel(isbn);

    }
)();