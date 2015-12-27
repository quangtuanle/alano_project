
  // console.log("Status: " + status);
//	if (status == 'success')  { // Make sure to return the content of the page once the page is finish loaded
 //     var content = page.content;
 //     console.log(content);
 //     phantom.exit();
//  };
//})

var webPage = require('webpage');
var system = require('system');
var page = webPage.create();
//var url = system.args[1]; // This will get the second argument from $cmd, in this example, it will be the value of $target on index.php which is "http://www.kincir.com" 
page.open("http://vnexpress.net/", function (status) {
  page.onLoadFinished = function () { // Make sure to return the content of the page once the page is finish loaded
      var content = page.content;
      console.log(content);
      phantom.exit();
  };
});