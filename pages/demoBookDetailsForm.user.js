// ==UserScript==
// @name           Get Book Details from ISBN demo
// @namespace      http://ouseful.open.ac.uk/blog
// @description    Adds a button to demo book details form and autocompletes book data based on ISBN.
// @include        http://blogs.open.ac.uk/Maths/ajh59/demoBookDetailsForm.html
// ==/UserScript==

(function() {

	//this function based on the example at http://diveintogreasemonkey.org/patterns/parse-xml.html
	function completeForm(details){
	    var parser = new DOMParser();
	    var dom = parser.parseFromString(details.responseText,
        	    "application/xml");

	   if (!dom.getElementsByTagName('Errors').length){
		//this is too clunky - need to go by name until IDs are sorted on form...
		document.getElementById('author').value=dom.getElementsByTagName('Author')[0].textContent;
		document.getElementById('title').value=dom.getElementsByTagName('Title')[0].textContent;
		document.getElementById('publisher').value=dom.getElementsByTagName('Publisher')[0].textContent;
		//here's another way of doing the indexing - count the form elements...
		document.getElementsByTagName('input')[5].value=dom.getElementsByTagName('PublicationDate')[0].textContent;
		document.getElementById('price').value=dom.getElementsByTagName('FormattedPrice')[0].textContent;
	    } else alert('Error looking up '+document.getElementById('isbn').value+' as an ISBN');
	}

	function getISBN(){
		//The ISBN is pulled from the ISBN text box
		// Check it is an ISBN: isbn regexp taken from Udell's library lookup - http://weblog.infoworld.com/udell/stories/2002/12/11/librarylookup.html
		//var isbn = window.content.location.href.match(/([\/-]|is[bs]n=|searchData=)(\d{7,9}[\dX])/i)[2];
		//Here's an alternative:
		//var regISBN = /([^\S]?\d{7,9}[\dX][^\S]?)/gi
		var isbn=document.getElementsByTagName('input')[4].value;				
		return isbn;
	}

	function getResponseText () {
		var isbn=getISBN();
		//Use any book lookup service that accepts an ISBN and returns book data as XML 
		var URL = "http://webservices.amazon.co.uk/onca/xml?Service=AWSECommerceService&Version=2005-03-23&Operation=ItemLookup&ContentType=text%2Fxml&SubscriptionId=0DK8EWAWVKXSH8SEMVR2&ItemId="+isbn+"&ResponseGroup=Images,ItemAttributes";
		GM_xmlhttpRequest({
		  method:"GET",
		  url:URL,
		  headers:{ "User-Agent":"monkeyagent","Accept":"text/monkey,application/xml,text/xml",},
		  onload:function(details){ completeForm(details);}
		});
	}


	function attachDetailsButton(){
		//this function adds the button that will get details based on an ISBN
		var b=document.getElementById('isbn');
		//get the parent of the ISBN text box;
		var link=document.createElement('a');
		link.addEventListener('click', getResponseText, true );
		link.setAttribute('style','text-decoration:underline');
		//or can we do this with an href and javascript: command?
		var linkTxt=document.createTextNode('Get book Details');
		link.appendChild(linkTxt);
		b.parentNode.appendChild(link);//I suspect this is wrong just for now...
	}
		
	attachDetailsButton();

})();	
