// ==UserScript==
// @name          Amazon UK OU Library Linky
// @namespace     http:/ouseful.open.ac.uk/blog/
// @description	  Search the Open University Library Catalogue from Amazon UK book listings, based on script from http://www.mundell.org and http://www.daveyp.com/blog
// @include       http://*.amazon.co.uk*
// ==/UserScript==

// fixed for Firefox 1.5 and GM 0.6.4

(

function()
{

    var libraryUrlPattern = 'http://ouseful.open.ac.uk/voyager/isbn/'
    var libraryName = 'the Open University';
    var libraryAvailability = /In the library/;
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
        insertLink: function(isbn, hrefTitle, aLabel, color )
        {
            var div = origTitle.parentNode;
//            var title = origTitle.firstChild.nodeValue;
    	    var title = '';

            var newTitle = document.createElement('b');
            newTitle.setAttribute('class','sans');

            var titleText = document.createTextNode(title);
            newTitle.appendChild(titleText);
        
            var br = document.createElement('br');

            var link = document.createElement('a');
            link.setAttribute ( 'title', hrefTitle );
            link.setAttribute('href', libraryUrlPattern + isbn);
            link.setAttribute('style','font-size:small; font-weight:bold; color:' + color);

            var label = document.createTextNode( aLabel );

            link.appendChild(label);

            div.insertBefore(newTitle, origTitle);
            div.insertBefore(link, origTitle);
            div.insertBefore(br, origTitle);
//            div.removeChild(origTitle);
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
                    if ( notFound.test(page) )
                    {
                        var due = page.match(notFound)[1]
                        libraryLookup.insertLink (
                            origTitle.firstChild.nodeValue,
                            "ISBN not found",
                            "ISBN not found at " + libraryName + " - click here to start title search",
                            "red"
                        );
                    }
                    else if ( libraryAvailability.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "available now",
                            "Available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( librarySeveralVersions.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "severl versions available",
                            "Several versions of this title are available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryElectronic.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "available electronically",
                            "Available in electronic format from " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryOtherEditions.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "other editions available",
                            "Other editions of this title are available at " + libraryName,
                            "green"
                        );
                    }
                    else if ( libraryOnOrder.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "on order",
                            "On order at " + libraryName,
                            "#AA7700"  // dark yellow
                        );
                    }                    
                    else if ( libraryInProcess.test(page) )
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "In process!",
                            "In process (available soon) at " + libraryName,
                            "#AA7700"  // dark yellow
                        );
                    }                    
                    else if ( libraryDueBack.test(page) )
                    {
                        var due = page.match(libraryDueBack)[1]
                        libraryLookup.insertLink (
                            isbn,
                            "due back " + due,
                            "Due back at " + libraryName + " on " + due,
                            "#AA7700"  // dark yellow
                        );
                    }
                    else
                    {
                        libraryLookup.insertLink (
                            isbn,
                            "Error",
                            "Error checking " + libraryName,
                            "orange"
                        );
                    }
                }
            });
        }


    }

    try 
    { var isbn = window.content.location.href.match(/\/(\d{7,9}[\d|X|x])\//)[1];  }

    catch (e)
    { return; }

    var origTitle = document.evaluate("//font[@face='verdana, helvetica, arial']/b", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null ).singleNodeValue;

    if ( ! origTitle )
    { return; }

//     alert( isbn );
//     alert( origTitle.firstChild.nodeValue );

    libraryLookup.doLookup(isbn);

    }
)();