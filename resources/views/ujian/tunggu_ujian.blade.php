@extends('layouts_ujian.app')

@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <img src="{{ asset('assets/images/waiting1.png') }}" class="img img-responsive" width="300px">
            <br />
            <br />
            <h3 id="demo"></h3>
        </div>
    </div>
    <?php
    $slug_soal = $soal->slug_soal;
    $tanggal_mulai = $soal->tanggal_mulai;
    $waktu_mulai = $soal->waktu_mulai;
    ?>
    <script>
        // Set the date we're counting down to
        var tanggal_waktu = new Date("<?php
                echo $tanggal_mulai; echo ' '; echo $waktu_mulai;
                ?>
                ").getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {

                    // Get todays date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = tanggal_waktu - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                        minutes + "m " + seconds + "s ";

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(x);
                        window.location.href =
                            "{{ route('jawab_ujian', ['slug_soal' => $slug_soal]) }}";
                        // document.getElementById('btnSignIn').click(); //kondisi tombol ditekan otomatis
                    }
                }, 1000);

    </script>
@endsection
