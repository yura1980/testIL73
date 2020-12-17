//установка сообщений валидации формы
document.addEventListener("DOMContentLoaded", function () {
    const elements = document.getElementsByTagName("INPUT");
    for (let i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Поле обязательно для заполнения.");
            }
        };
        elements[i].oninput = function (e) {
            e.target.setCustomValidity("");
        };
    }
})

//загрузка макета
function load() {

    location.href = 'http://medosmotr-plus.ru/wwwphpword/index.php/' + $("#content").text().trim();
}

// сохранение формы
$("#bidForm").submit(function (event) {

    // остановка событий формы по умолчанию
    event.preventDefault();

    // получаем значения формы
    const $form = $(this),
        fam = $form.find("input[name='fam']").val(),
        name = $form.find("input[name='name']").val(),
        otch = $form.find("input[name='otch']").val(),
        pol = $form.find("select[name='pol']").val(),
        dr = $form.find("input[name='dr']").val(),
        weight = $form.find("input[name='weight']").val(),
        height = $form.find("input[name='height']").val(),
        url = $form.attr("action");

    // Send the data using post
    let posting = $.post(url, {
        fam: fam,
        name: name,
        otch: otch,
        pol: pol,
        dr: dr,
        weight: weight,
        height: height
    });

    // Put the results in a div
    posting.done(function (data) {
        $("#result").show();
        $("#loadfile").show();
        $("#content").empty().append(data);
    });
});
