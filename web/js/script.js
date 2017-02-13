$(document).ready(function(){
    $(".action-button").click(function(){
        $(this).parents(".tab-pane").find(".form input").val("");
        $(this).parents(".tab-pane").find(".form select option").attr("selected", false);
        $(this).parents(".tab-pane").find(".form select option:first-child").attr("selected", true);

        $(this).parents(".tab-pane").find(".form").show();
        return false;
    });

    $(".action-cancel").click(function(){
        $(this).parents(".tab-pane").find(".form").hide();
        return false;
    });

    $('body').on('beforeSubmit', '#companies_form form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (response) {
                $.pjax.reload({container: "#p0", async:true});
            }
        });
        return false;
    });

    $('body').on('beforeSubmit', '#users_form form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (response) {
                $.pjax.reload({container: "#p1", async:true});
            }
        });
        return false;
    });

    $("body").on('click', '.update-company', function(){
        var form = $(this).parents('#companies').find('#companies_form');
        var element = $(this).parents('tr');

        form.find("form").attr("method", "PUT");
        form.find("form").attr("action", "/companies/update/" + $(this).attr('id'));

        form.find("#companies-name").val(element.find("td:nth-child(1)").text());

        var quota = element.find("td:nth-child(2)").text().split(" ");
        form.find("#companies-quota").val(quota[0]);
        form.find('#companies-quota_type option').filter(function() {
            return $(this).html() == quota[1];
        }).attr("selected", true);

        form.show();

        return false;
    });

    $("body").on('click', '.update-user', function(){
        var form = $(this).parents('#users').find('#users_form');
        var element = $(this).parents('tr');

        form.find("form").attr("method", "PUT");
        form.find("form").attr("action", "/users/update/" + $(this).attr('id'));

        form.find("#users-name").val(element.find("td:nth-child(2)").text());
        form.find("#users-email").val(element.find("td:nth-child(3)").text());

        $("#users-company_id option[value='" + $(this).attr('company_id') + "']").attr("selected", true);

        form.show();

        return false;
    });

    $('.generate').click(function(){
        $(this).hide();

        interavl = setInterval(function(){
            $.pjax.reload({container: "#p2", async:true});
        }, 1000);

        $.ajax({
            url: '/site/generate',
            type: 'POST',
            data: '',
            async: true,
            success: function (response) {
                $('.generate').show();
                clearInterval(interavl);
            }
        });

        return false;
    });
});