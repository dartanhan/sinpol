<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        // O usuário logado já está disponível via auth()->user()
        $user_data = auth()->user(); 
        return view('admin.banner', compact('banners', 'user_data'));
    }

    public function store(Request $request)
    {
        try {
            $path = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/banners'), $filename);
                $path = $filename;
            } else {
                $folder = $request->input('temp_image_folder') ?? $request->input('image');
                $temp_file = TemporaryFile::where('folder', $folder)->first();

                if ($temp_file) {
                    $tempPath = storage_path('app/public/posts/tmp/' . $temp_file->folder . '/' . $temp_file->file);
                    $destPath = public_path('storage/banners/' . $temp_file->file);

                    if (file_exists($tempPath)) {
                        copy($tempPath, $destPath);
                        $path = $temp_file->file;
                    }
                }
            }

            if ($path) {
                Banner::create([
                    'path' => $path,
                    'titulo' => $request->input('titulo', ''),
                    'link' => $request->input('link', ''),
                    'status' => 1,
                ]);
                return redirect()->route('banner.index')->with('success', 'Banner criado com sucesso.');
            }

            return redirect()->route('banner.index')->with('danger', 'Erro: Nenhuma imagem válida encontrada.');
        } catch (\Exception $e) {
            Log::error("Erro Banner Store: " . $e->getMessage());
            return redirect()->route('banner.index')->with('danger', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->titulo = $request->input('titulo', '');
            $banner->link = $request->input('link', '');
            $newPath = null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/banners'), $filename);
                $newPath = $filename;
            } else {
                $folder = $request->input('temp_image_folder') ?? $request->input('image');
                if ($folder && !is_object($folder)) {
                    $temp_file = TemporaryFile::where('folder', $folder)->first();
                    if ($temp_file) {
                        $tempPath = storage_path('app/public/posts/tmp/' . $temp_file->folder . '/' . $temp_file->file);
                        $destPath = public_path('storage/banners/' . $temp_file->file);

                        if (file_exists($tempPath)) {
                            copy($tempPath, $destPath);
                            $newPath = $temp_file->file;
                        }
                    }
                }
            }

            if ($newPath) {
                $oldPath = public_path('storage/banners/' . $banner->path);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
                $banner->path = $newPath;
            }

            $banner->save();
            return redirect()->route('banner.index')->with('success', 'Banner atualizado com sucesso.');
        } catch (\Exception $e) {
            Log::error("Erro Banner Update: " . $e->getMessage());
            return redirect()->route('banner.index')->with('danger', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        if (!$banner) return response()->json(['success' => false], 404);
        return response()->json(['success' => true, 'data' => $banner]);
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::find($id);
            if ($banner) {
                $filePath = public_path('storage/banners/' . $banner->path);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
                $banner->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function atualizarStatus(Request $request)
    {
        $banner = Banner::find($request->id);
        if ($banner) {
            $banner->status = $request->status;
            $banner->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
