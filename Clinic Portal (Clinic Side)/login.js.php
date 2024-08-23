<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js">
</script>
<script>
    //session_start();

    function login(action) {
        $(document).ready(function() {
            var data = {
                action: action,
                id: $("#id").val(),
                username: $("#username").val(),
                password: $("#password").val()
            }

            $.ajax({
                url: 'login-function.php',
                type: 'post',
                data: data,

                success: function(response) {
                    //alert(response);
                    //let username = $_SESSION['username'];
                    if (response == "admin") {
                        successAlert("Welcome Admin");
                        location.replace("zHTML_dashboard.php");
                    } else if (response == "secretary") {
                        successAlert("Welcome Secretary");
                        location.replace("zStaff_dashboard.php");
                    } else if (response == "veterinarian") {
                        successAlert("Welcome Veterinarian");
                        location.replace("zStaff_dashboard.php");
                    } else if (response == "User not found!") {
                        successAlert("User not found!");
                    }
                    
                    else if (response == "Invalid email!") {
                        successAlert("Invalid email!");
                    }
                    else if (response == "Invalid password!") {
                        successAlert("Invalid password!");
                    }
                    else if (response == "Invalid email or password!") {
                        successAlert("Invalid email or password!");
                    }
                    else if (response == "Invalid email or contact!") {
                        successAlert("Invalid email or contact!");
                    }
                    else if (response == "Contact must be an 11-digit number!") {
                        successAlert("Contact must be an 11-digit number!");
                    }

                    
                    
                    
                    else {
                        forgotPass();
                        successAlert(response);
                        //User not found!
                        //Your request has been submitted. An SMS with your new password will be sent to your contact number. Please wait a few minutes.
                    }
                }
            });
        });
    }
</script>