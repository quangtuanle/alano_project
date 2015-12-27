
  var webPage = require('webpage');
var system = require('system');
var page = webPage.create();
var url = system.args[1]; // This will get the second argument from $cmd, in this example, it will be the value of $target on index.php which is "http://www.kincir.com" 
page.open(url, function (status) {
  //console.log("Status: " + status);
  if(status === "success") { // Make sure to return the content of the page once the page is finish loaded
		window.setTimeout(function () {
        var content = page.content;
      console.log(content);
	  console.log(url);
	  page.render('example.png');
      phantom.exit();    
        }, 1000);
      
  }
  else
  {
  phantom.exit();
  };
});

  // console.log("Status: " + status);
//	if (status == 'success')  { // Make sure to return the content of the page once the page is finish loaded
 //     var content = page.content;
 //     console.log(content);
 //     phantom.exit();
//  };
//})

// var webPage = require('webpage');
// //var system = require('system');
// var page = webPage.create();
// //var url = system.args[1]; // This will get the second argument from $cmd, in this example, it will be the value of $target on index.php which is "http://www.kincir.com" 
// page.open("http://www.kincir.com", function (status) {
  // if (status == 'success') { // Make sure to return the content of the page once the page is finish loaded
     // var content = page.content;
      // console.log(content);
      // phantom.exit();
  // }
  // };
  
  // page.onLoadFinished = function() {
            // window.setTimeout(function () {
				// console.log("dfds");
            // var content = page.content;
			// console.log(content);
			
          // }, 200000);
    // }
	// phantom.exit();
// });
 