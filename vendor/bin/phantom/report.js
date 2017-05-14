var page = require('webpage').create();
page.open('http:medisom.com.br/teste-report', function (status) {
    console.log("Status: " + status);
    if (status === "success") {
        page.render('example.pdf');
    }
    phantom.exit();
});
