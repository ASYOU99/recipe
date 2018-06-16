$(".dynamicform_wrapper").on("afterInsert", function (e, item) {
    jQuery(".dynamicform_wrapper .panel-title-doc").each(function (index) {
        jQuery(this).html("Ингрилиент: " + (index + 1));
        var id = $("#recipemodel-0-recipeid").val();
        $("#recipemodel-" + index + "-recipeid").prop('value', id);
    });
});

$(".dynamicform_wrapper").on("afterDelete", function (e) {
    jQuery(".dynamicform_wrapper .panel-title-doc").each(function (index) {
        jQuery(this).html("Ингридиент: " + (index + 1));
    });
});

$(".dynamicform_wrapper").on("limitReached", function (e, item) {
    alert("You reached the upload limit");
});