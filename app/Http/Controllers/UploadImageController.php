<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//tambahan use
use App\Image_uploaded;
use Carbon\Carbon;
use Image;
use File;

//tambah post
use App\Post;


class UploadImageController extends Controller
{
    public $path;
    public $dimensions;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->path = storage_path('app/public/images');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500']; //buat tiga dimensi folder
        // $this->dimensions = ['245'];
    }

    public function createPhoto(){
        $photos = Image_uploaded::all();
        $posts = Post::all();
        // dd($posts);

        return view('photo.create', compact('photos', 'posts'));
    }

    public function storePhoto(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);
		
        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }
		
        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');
        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        // Image::make($file)->save($this->path . '/' . $fileName);
		
        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY 
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY 
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });
			
            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }
        	
            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }
        
        //SIMPAN DATA IMAGE YANG TELAH DI-UPLOAD
        $images = Image_uploaded::create([
            'name' => $fileName,
            'dimensions' => implode('|', $this->dimensions),
            'path' => $this->path
        ]);

        //TAMBAH! simpan di table post
        Post::create([
            'title' => request('title'),
            'body' => request('body'),
            'photo_id' => $images->id
        ]);
        return redirect()->back()->with(['success' => 'Gambar Telah Di-upload']);
    }
}
