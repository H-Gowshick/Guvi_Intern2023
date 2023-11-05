$(document).ready(function () {
    $("#registration-form").submit(function (event) {
        event.preventDefault();

        // Check if password and confirm password match
        var password = $("#password").val();
        var confirmPassword = $("#confirm-password").val();

        if (password !== confirmPassword) {
            alert("Password and confirm password do not match. Please try again.");
            return; 
        }

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "php/register.php",
            data: formData,
            success: function (response) {
                if (response === "success") {
                    alert("Registration successful!");
                    window.location.href = "login.html"; // Redirect to login page
                } else {
                    // Display error message
                    alert(response);
                }
            },
            error: function () {
                alert("An error occurred. Please try again later.");
            }
        });
    });
});
