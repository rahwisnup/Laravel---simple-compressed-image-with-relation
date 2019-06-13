</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wisnu Paramartha - Upload image</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('upload.image') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" value="" name="title">
                            </div>
                            <div class="form-group">
                                    <label for="">Body</label>
                                    <textarea rows="4" cols="50" name="body" >Enter text here...</textarea>
                                </div>

                            <div class="form-group">
                                <label for="">Pilih gambar</label>
                                <input type="file" name="image">
                                <p class="text-danger">{{ $errors->first('image') }}</p>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger btn-sm">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h2>Photo List</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Photo</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($photos as $item)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>/images/{{$item->name}}</td>
                                        <td> <img height="50" src="storage/images/300/{{$item->name}}" alt="" class="img-responsive"> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h2>Post List</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Post Title</th>
                                    <th scope="col">Post Name</th>
                                    <th scope="col">Photo</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $item)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->body}}</td>
                                        {{-- <td>{{$item->image['name']}}</td> --}}
                                        <td> <img height="50" src="storage/images/300/{{$item->image['name']}}" alt="" class="img-responsive"> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>