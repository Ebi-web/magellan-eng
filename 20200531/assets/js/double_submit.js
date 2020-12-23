$("form").submit(function () {
    $("button[type='submit']").prop("disabled", true);
    setTimeout(function () {
        $("button[type='submit']").prop("disabled", false);
    }, 10000);
});