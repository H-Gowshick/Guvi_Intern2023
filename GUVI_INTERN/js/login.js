$(document).ready(function() {
    $("#login-button").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "php/login.php", // Specify the PHP script for server-side validation
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                if (response === "success") {
                    // Redirect to the profile page upon successful login
                    window.location.href = "profile.html";
                } else {
                    alert(response); //error messages
                }
            }
        });
    });
});
