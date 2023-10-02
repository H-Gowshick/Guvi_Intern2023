$(document).ready(function() {
    // Retrieve and display the user's name
    $.ajax({
        type: "POST",
        url: "php/get_username.php", // PHP script to get the user's name from session
        success: function(response) {
            $("#user-name").text(response);
        }
    });

    // Load user-specific data (age, dob, contact) and populate the form
    $.ajax({
        type: "POST",
        url: "php/get_user_data.php", // PHP script to retrieve user data from the database
        success: function(response) {
            var userData = JSON.parse(response);
            $("#age").val(userData.age);
            $("#dob").val(userData.dob);
            $("#contact").val(userData.contact);
        }
    });

    // Update user-specific data
    $("#update-button").click(function() {
        var age = $("#age").val();
        var dob = $("#dob").val();
        var contact = $("#contact").val();

        $.ajax({
            type: "POST",
            url: "php/update_user_data.php", // PHP script to update user data in the database
            data: {
                age: age,
                dob: dob,
                contact: contact
            },
            success: function(response) {
                if (response === "success") {
                    alert("Profile updated successfully!");
                } else {
                    alert("Error: " + response);
                }
            }
        });
    });
});
