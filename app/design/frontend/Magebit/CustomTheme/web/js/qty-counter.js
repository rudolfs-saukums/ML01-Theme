require(['jquery'], function ($) {
    $(document).ready(function () {
        let count = parseInt($('#qty').val()) || 0;

        $('.qty-increase').on('click', function () {
            count++;
            $('#qty').val(count);
            console.log("Increased: " + count);
        });

        $('.qty-decrease').on('click', function () {
            if (count > 0) {
                count--;
                $('#qty').val(count);
                console.log("Decreased: " + count);
            }
        });
    });
});
