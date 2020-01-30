<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>

<!--darkmode-toggle-->
<script>

    $(document).ready(function () {
        $('#loader').fadeOut(1000);
        $('body').css('overflow', 'auto');
    });

    function darkMode() {
        var darkMode = localStorage.getItem('darkmode');

        if(darkMode == 'on') {
            $('body').addClass('darkmode');
            $('.navbar').addClass('navbar-light').removeClass('bg-light');
            $('.navbar').addClass('navbar-dark').addClass('bg-dark');
            $('.darkmode-toggle').prop('checked', true);
            // Chart.defaults.global.defaultFontColor = "#fff";
        } else {
            $('body').removeClass('darkmode');
            $('.navbar').removeClass('navbar-dark').removeClass('bg-dark');
            $('.navbar').addClass('navbar-light').addClass('bg-light');
            $('.darkmode-toggle').prop('checked', false);
            // Chart.defaults.global.defaultFontColor = "#666";
        }
    }
    darkMode();

    $('.darkmode-toggle').change(function (event) {
        event.preventDefault();

        if($(this).is(':checked')) {
            // Turn on
            // document.cookie = "darkmode=on";
            localStorage.setItem('darkmode', 'on');
        } else {
            // Turn off
            // document.cookie = "darkmode=off";
            localStorage.removeItem('darkmode');
        }

        darkMode();
    });
</script>