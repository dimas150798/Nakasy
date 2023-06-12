$(document).ready(function() {

    $('#ctn-preloader').addClass('loaded');

    if ($('#jumlahpelanggan').text() !== '') {
        $('#preloader').delay(500).queue(function() {
                $(this).remove();
            });
    }
});