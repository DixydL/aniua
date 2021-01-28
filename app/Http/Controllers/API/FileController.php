<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Gumlet\ImageResize;

class FileController extends Controller
{

    public function index()
    {
        return new JsonResource(Anime::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->file('file')->isValid()) {
            $path = $request->file('file')->store('public/poster/full');
            // dd($path);
            $image = new ImageResize(storage_path('app/' . $path));
            $image->resize(300, 250);

            Storage::disk('public')->put('poster/300x250/' . basename($path), $image->getImageAsString());

            $file = File::create([
                'name' => basename($path),
                'path' => $path,
                'url' => Storage::url($path),
                'url_resize' => '/storage/poster/300x250/' . basename($path),
            ]);

            // $user = Auth::user();
            // $user->avatar_id = $file->id;
            // $user->save();

            return new JsonResource($file);
        }

        return response()->json([], 402);
    }
}
