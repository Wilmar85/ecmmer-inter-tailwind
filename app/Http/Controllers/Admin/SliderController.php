<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,webm|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $slider = new Slider();
        $slider->title = $validated['title'];
        $slider->description = $validated['description'] ?? null;
        $slider->type = $validated['type'];
        $slider->button_text = $validated['button_text'] ?? null;
        $slider->button_url = $validated['button_url'] ?? null;
        $slider->sort_order = $validated['sort_order'] ?? 0;
        $slider->is_active = $validated['is_active'] ?? true;

        // Subir archivo multimedia
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $filename = Str::uuid() . '.' . $media->getClientOriginalExtension();
            
            // Crear directorio si no existe
            $directory = storage_path('app/public/sliders');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Guardar el archivo manualmente
            $media->move($directory, $filename);
            
            // Verificar que el archivo se haya guardado
            if (file_exists($directory . '/' . $filename)) {
                $slider->media_path = 'sliders/' . $filename;
                \Log::info('Archivo guardado correctamente en: ' . $directory . '/' . $filename);
            } else {
                \Log::error('Error al guardar el archivo en: ' . $directory . '/' . $filename);
                return back()->with('error', 'Error al guardar el archivo. Por favor, inténtalo de nuevo.');
            }
        }

        // Subir miniatura si se proporciona
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbName = 'sliders/thumbnails/' . Str::uuid() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbPath = $thumbnail->storeAs('public', $thumbName);
            $slider->thumbnail_path = $thumbName;
        } elseif ($slider->type === 'video') {
            // Generar miniatura del video si no se proporciona
            // Aquí podrías agregar lógica para generar una miniatura del video
        }

        $slider->save();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,webm|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'remove_media' => 'boolean',
            'remove_thumbnail' => 'boolean',
        ]);

        $slider->title = $validated['title'];
        $slider->description = $validated['description'] ?? null;
        $slider->type = $validated['type'];
        $slider->button_text = $validated['button_text'] ?? null;
        $slider->button_url = $validated['button_url'] ?? null;
        $slider->sort_order = $validated['sort_order'] ?? 0;
        $slider->is_active = $validated['is_active'] ?? true;

        // Eliminar archivo multimedia existente si se solicita
        if (!empty($validated['remove_media']) && $slider->media_path) {
            Storage::delete('public/' . $slider->media_path);
            // No establecer a null, mantener el valor actual si no se proporciona uno nuevo
            // Solo actualizar si se proporciona un nuevo archivo
            if (!$request->hasFile('media')) {
                return redirect()->back()->with('error', 'Debes subir un nuevo archivo o no marcar la opción de eliminar.');
            }
        }

        // Subir nuevo archivo multimedia
        if ($request->hasFile('media')) {
            // Eliminar archivo anterior si existe
            if ($slider->media_path && file_exists(storage_path('app/public/' . $slider->media_path))) {
                unlink(storage_path('app/public/' . $slider->media_path));
            }
            
            $media = $request->file('media');
            $filename = Str::uuid() . '.' . $media->getClientOriginalExtension();
            
            // Crear directorio si no existe
            $directory = storage_path('app/public/sliders');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Guardar el archivo manualmente
            $media->move($directory, $filename);
            
            // Verificar que el archivo se haya guardado
            if (file_exists($directory . '/' . $filename)) {
                $slider->media_path = 'sliders/' . $filename;
                \Log::info('Archivo actualizado correctamente en: ' . $directory . '/' . $filename);
            } else {
                \Log::error('Error al actualizar el archivo en: ' . $directory . '/' . $filename);
                return back()->with('error', 'Error al actualizar el archivo. Por favor, inténtalo de nuevo.');
            }
        }

        // Eliminar miniatura existente si se solicita
        if (!empty($validated['remove_thumbnail']) && $slider->thumbnail_path) {
            Storage::delete('public/' . $slider->thumbnail_path);
            $slider->thumbnail_path = null;
        }

        // Subir nueva miniatura
        if ($request->hasFile('thumbnail')) {
            // Eliminar miniatura anterior si existe
            if ($slider->thumbnail_path) {
                Storage::delete('public/' . $slider->thumbnail_path);
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbName = 'sliders/thumbnails/' . Str::uuid() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbPath = $thumbnail->storeAs('public', $thumbName);
            $slider->thumbnail_path = $thumbName;
        }

        $slider->save();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        // Eliminar archivos asociados
        if ($slider->media_path) {
            Storage::delete('public/' . $slider->media_path);
        }
        if ($slider->thumbnail_path) {
            Storage::delete('public/' . $slider->thumbnail_path);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider eliminado exitosamente.');
    }

    /**
     * Actualizar el orden de los sliders
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|exists:sliders,id',
            'sliders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->sliders as $sliderData) {
            Slider::where('id', $sliderData['id'])
                ->update(['sort_order' => $sliderData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
