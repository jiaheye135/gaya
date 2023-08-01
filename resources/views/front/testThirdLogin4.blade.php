<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://hilife-hishopping.azureedge.net/address/city.js"></script>
    <script src="https://life-explore.com.tw/city.json"></script>

    <script type="text/javascript" src="http://lifediscovery.local/city.js"></script>
    <script>console.log(city)</script>
    
    <script>
        var cityJs = 'https://hilife-hishopping.azureedge.net/address/city.js';
        // var users = require('https://hilife-hishopping.azureedge.net/address/city.js');

        // var option = {
        //     url: 'https://hilife-hishopping.azureedge.net/address/city.js',
        //     type: 'get',
        //     // dataType: 'json',
        //     // data: data,
        //     success: function (resData) {
                // console.log(mydata);
        //         // if(typeof callback === 'function') callback(data, resData, param);
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr, ajaxOptions, thrownError);
        //         // if(typeof errorCallback === 'function') errorCallback(data, param);
        //     },
        // }

        // $.ajax(option);

        function readTextFile(file, callback) {
            var rawFile = new XMLHttpRequest();
            rawFile.overrideMimeType("application/json");
            rawFile.open("GET", file, true);
            rawFile.onreadystatechange = function() {
                if (rawFile.readyState === 4 && rawFile.status == "200") {
                    callback(rawFile.responseText);
                }
            }
            rawFile.send(null);
        }

        //usage:
        readTextFile('https://life-explore.com.tw/city.json', function(text){
            var data = JSON.parse(text);
            console.log(data);
        });

        var fileReader = new FileReader(); 
        var a = fileReader.readAsText(cityJs, "utf-8");
        console.log(a);
    </script>
</head>
<body>

</body>
</html>