@extends('layouts_ujian.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #title {
            display: block;
            font-weight: bold;
            color: #6780FC;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h4 id="title" style="letter-spacing: 1px;">{{ $title }}</h4>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_jenis_soal"><b>Kategori</b></label>
                                    <select class="form-control" id="id_jenis_soal" name="id_jenis_soal">
                                        <option value="0">Semua</option>
                                        @foreach ($jenis_soal as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ $id_jenis_soal == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis_soal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_soal"><b>Periode</b></label>
                                <div class="input-group mb-3">

                                    <input type="number" class="form-control" aria-label="year"
                                        aria-describedby="basic-addon2" name="year" value="{{ $year }}" required
                                        readonly>
                                    <div class="input-group-append">
                                        <a id="searchButton" class="btn btn-secondary" href="#" id="button-addon2"><i
                                                class="fas fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-md-2 mb-3">
                            <div class="card">
                                @if ($user->gambar != null)
                                    <img class="card-img-top" src="{{ asset('assets/images/' . $user->gambar) }}"
                                        alt="Card image cap">
                                @else
                                    <img class="card-img-top" src="{{ asset('assets/images/profiledefault.PNG') }}"
                                        alt="Card image cap">
                                @endif
                                <div class="card-body text-center">
                                    <p class="card-text"><b>{{ $user->name }}</b></p>
                                    <span
                                        @if ($loop->iteration <= 3) class="text-warning" @else class="text-info" @endif>
                                        <b><i class="fas fa-trophy"></i> #{{ $loop->iteration }}</b>
                                    </span>

                                    <!-- Make all font awesome social media -->


                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ $user->facebook }}">
                                        <i class="fab fa-facebook-f" style="color: #1877F2;"></i>
                                    </a>
                                    <a href="{{ $user->twitter }}">
                                        <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                                    </a>
                                    <a href="{{ $user->instagram }}">
                                        <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the select element
            var selectElement = document.getElementById('id_jenis_soal');

            // Add an event listener to detect changes in the select element
            selectElement.addEventListener('change', function() {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var selectedValue = selectedOption.value;

            });

            // Add an event listener to the search button
            document.getElementById('searchButton').addEventListener('click', function() {
                // Get the updated values
                var selectedValue = selectElement.value;

                // Generate the search URL using the updated values
                var searchURL =
                    "{{ route('ranking', ['id_jenis_soal' => ':id_jenis_soal', 'year' => '2023']) }}";
                searchURL = searchURL.replace(':id_jenis_soal', selectedValue);

                // Navigate to the search URL
                window.location.href = searchURL;
            });
        });
    </script>
@endsection
