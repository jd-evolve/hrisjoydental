$("input[data-type='currency']").on({keyup: function(){ formatCurrency($(this)); } });
function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}
function formatCurrency(input) {
    var input_val = input.val();
    if (input_val === "") { return; }
    input.val(formatNumber(input_val));
}