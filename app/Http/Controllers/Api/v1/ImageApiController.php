<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImageResource::collection(Image::all())->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        try {
            //Nombre random para almacenar en el server
            $data = $request->validated();
            $imageRequest = $request->file('image');
            $randomName = Str::random(40) . "." . $imageRequest->getClientOriginalExtension();
            $path = env('APP_URL') . "/uploads/" . $randomName;
            $image = Image::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'path' => $path,
                'original_name' => $imageRequest->getClientOriginalName(),
                'name' => $randomName
            ]);
            //Almacenar Imagen en el public
            Storage::disk('public')->put($randomName, File::get($imageRequest));
            return (new ImageResource($image))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ImageResource
     */
    public function show($id)
    {
        $image = Image::find($id);
        if (is_null($image)) {
            return response(null, Response::HTTP_NOT_FOUND);
        }
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateImageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, $id)
    {
        try {
            $image = Image::find($id);
            if (is_null($image)) {
                return response(null, Response::HTTP_NOT_FOUND);
            }
            //Nombre random para almacenar en el server
            $imageRequest = $request->file('image');
            $randomName = Str::random(40) . "." . $imageRequest->getClientOriginalExtension();
            $path = public_path('uploads') . "/" . $randomName;
            $data = $request->validated();
            //Eliminar imagen anterior
            unlink($image->path);
            //Atualizar datos de la imagen
            $image->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'path' => $path,
                'original_name' => $imageRequest->getClientOriginalName(),
                'name' => $randomName
            ]);
            //Almacenar Imagen en el public
            Storage::disk('public')->put($randomName, File::get($imageRequest));
            return (new ImageResource($image))
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        if (is_null($image)) {
            return response(null, Response::HTTP_NOT_FOUND);
        }
        //Eliminar imagen
        unlink(public_path() . "/uploads/$image->name");
        $image->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
