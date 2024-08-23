<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    // // today and upcoming SMS
    // function smsSend() {

    //     const message = document.getElementById("smsMessage").value;

    //     var settings = {
    //         "url": "https://8g4r63.api.infobip.com/sms/2/text/advanced",
    //         "method": "POST",
    //         "timeout": 0,
    //         "headers": {
    //             "Authorization": "App 18d4be336e5a3405bcb923d9b274cd3d-78e18f47-e4f2-4d38-ae7a-6db6601c2d33",
    //             "Content-Type": "application/json",
    //             "Accept": "application/json"
    //         },
    //         "data": JSON.stringify({
    //             "messages": [{
    //                 "destinations": [{
    //                     "to": "639694903757"
    //                 }],
    //                 "from": "InfoSMS",
    //                 "text": message
    //             }]
    //         }),
    //     };

    //     $.ajax(settings)
    //         .done(function(response) {
    //             console.log(response);
    //         })
    //         .fail(function(error) {
    //             console.error("Error:", error.responseText);
    //         });
    // }

    // today and upcoming SMS (New Account)
    function smsSend() {

        const message = document.getElementById("smsMessage").value;

        var settings = {
            "url": "https://n8pmd8.api.infobip.com/sms/2/text/advanced",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Authorization": "App b0c05124d8fd2f2abda7233584db174d-27d722c3-8a58-4aa2-addf-cd0b5fa9a9de",
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            "data": JSON.stringify({
                "messages": [{
                    "destinations": [{
                        "to": "639217105499"
                    }],
                    "from": "InfoSMS",
                    "text": message
                }]
            }),
        };

        $.ajax(settings)
            .done(function(response) {
                console.log(response);
            })
            .fail(function(error) {
                console.error("Error:", error.responseText);
            });
    }
</script>