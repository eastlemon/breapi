$("a#clear-format").on("click", function () {
    $(this).closest("div").find("input").val("");
    $(this).closest('div').find("input[type='hidden']").val("");
});

$("a#insert-dummy").on("click", function () {
    let visible = $(this).closest("div").find("input");
    let hidden = $(this).closest('div').find("input[type='hidden']");

    _upd_(visible, hidden, "@", "@");
});

$("a.select-format").on("click", function () {
    let visible = $(this).closest("div").find("input");
    let hidden = $(this).closest('div').find("input[type='hidden']");

    let visible_fragment = $(this).text();
    let hidden_fragment = $(this).attr('hidden-name');

    if (visible.val().indexOf(visible_fragment) == -1) {
        _upd_(visible, hidden, visible_fragment, hidden_fragment);
    }
});

function _upd_(visible_input, hidden_input, visible_fragment, hidden_fragment) {
    let _visible_input = visible_input.val();
    let _hidden_input = hidden_input.val();

    if (_visible_input == '') {
        _visible_input += visible_fragment;
        _hidden_input += hidden_fragment;
    } else {
        _visible_input += ', ' + visible_fragment;
        _hidden_input += ',' + hidden_fragment;
    }

    visible_input.val(_visible_input);
    hidden_input.val(_hidden_input);
}