function dynamicSelectOption() {
    let select = $(this),
        url = select.data("url"),
        val = select.val(),
        child = select.data("child"),
        selectChild = $(child),
        placeholder = selectChild.data("placeholder") ?? '',
        canChoosePLH = selectChild.data("can_choose_plh") == 1 ? '' : 'disabled',
        prefix = selectChild.data("prefix") ?? null;

    selectChild.trigger("change");
    $.ajax({
        url: url,
        data: {
            id: val,
        },
        method: "GET",
        success: function (data) {
            if (data.status === 200) {
                selectChild.html(`<option value='' ${canChoosePLH} selected>${placeholder}</option>`);
                data.data.forEach((option, index) => {
                    selectChild.append(
                        `<option value="${option.id}">${prefix}${option.name}</option>`
                    );
                });
            } else {
            }
        },
        error: function (err) {
            console.log(err);
        },
    });
}

$(function () {
    $(document).on("change", ".dynamic-select-option", dynamicSelectOption);
});
