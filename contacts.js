
function toggleDetails(button) {
    const detailsDiv = $(button).siblings('.contact-details');
    const isHidden = detailsDiv.is(':hidden');
    
    detailsDiv.slideToggle();
    $(button).text(isHidden ? 'Hide Details' : 'View Details');
}

$(function () {

    loadContacts();


    $("#getusers").on('click', loadContacts);


    $("#searchInput").on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $(".contact-card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    $("#saveusers").on('click', function () {
        var formData = new FormData();
        formData.append('first_name', $("#first_name").val());
        formData.append('last_name', $("#last_name").val());
        formData.append('phone', $("#phone").val());
        formData.append('email', $("#email").val());
        formData.append('photo', $('#photo')[0].files[0]);

        $.ajax({
            method: "POST",
            url: "saverecords_ajax.php",
            data: formData,
            processData: false,
            contentType: false,
        }).done(function (data) {
            var result = $.parseJSON(data);
            var str = '';
            var cls = '';
            if (result == 1) {
                str = 'Contact saved successfully.';
                cls = 'success';
                // Clear form
                $('form')[0].reset();
            } else if (result == 2) {
                str = 'All fields are required.';
                cls = 'error';
            } else if (result == 3) {
                str = 'Enter a valid email address.';
                cls = 'error';
            } else if (result == 4) {
                str = 'Please upload a valid image file (JPG, PNG, or GIF).';
                cls = 'error';
            } else {
                str = 'Contact could not be saved. Please try again';
                cls = 'error';
            }
            $("#message").show(3000).html(str).addClass(cls).hide(5000);
        });
    });
});

function loadContacts() {
    $("#loading").show();
    $("#records").hide();

    $.ajax({
        method: "GET",
        url: "getrecords_ajax.php",
    }).done(function (data) {
        var result = $.parseJSON(data);
        var string = '';

        $.each(result, function (key, value) {
            string += `
                <div class="contact-card">
                    <img src="${value.photo}" alt="Contact photo" class="contact-photo">
                    <div class="contact-info">
                        <div class="contact-name">${value.first_name} ${value.last_name}</div>
                        <div class="contact-details" style="display: none;">
                            <p> ${value.phone}</p>
                            <p> ${value.email}</p>
                        </div>
                        <button class="toggle-details btn" onclick="toggleDetails(this)">View Details</button>
                    </div>
                </div>`;
        });

        $("#loading").hide();
        $("#records").html(string).show();
    });
}
