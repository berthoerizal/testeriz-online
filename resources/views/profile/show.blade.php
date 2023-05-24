@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        @include('partial.message')

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Profile</h1>
        <hr>

        <div class="row">
            <div class="col-md-3 mb-3">
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
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow col-md-12 mb-4">
                    <div class="card-header">
                        <div class="float-right">
                            @include('profile.update_password')
                        </div>
                    </div>

                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>Nama</td>
                                            <td><input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><input type="email" class="form-control" name="email"
                                                    value="{{ $user->email }}" required></td>
                                        </tr>
                                        <tr>
                                            <td>Upload Gambar</td>
                                            <td>
                                                <input type="file" name="gambar" id="gambar" onchange="previewImg()">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="float-right">
                                <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                    Simpan</button>
                            </span>
                            <br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');
            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

    </script>
@endsection
