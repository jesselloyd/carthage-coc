$("#sign-up").on('submit', function(e) {
    e.preventDefault();
    $.post('/wp-json/directory/register', $(this).getFormData(), onRegister);
});

function onRegister(res) {
    console.log("registered!");
}
