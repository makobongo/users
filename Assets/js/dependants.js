/* global SCHEMES_URL, IMAGE_SRC, URL */

$(document).ready(function () {
    //new fields
    var max_fields = 5; //maximum input boxes allowed
    var wrapper = $(".dependants"); //Fields wrapper
    var add_button = $(".add_button"); //Add button ID

    var x = 1; //initlal text box count
    var html_template = $('#wrapper1').html();
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++;
            var ids = 'wrapper' + x;
            var title = 'Dependant ' + x;
            $(wrapper).append("<h3>" + title + "</h3><div id='" + ids + "'>" + html_template + "</div>");
            $(".date").datepicker({
                dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y', yearRange: "1900:+0"}
            );
            $(".company").change(function () {
                apply_dependants(this);
            });
            $('#wrapper' + x + ' select').select2();
            $("#wrapper" + x + ".date").datepicker({dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y'});
        }

    });
});
