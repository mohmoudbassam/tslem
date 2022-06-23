<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    public function download_file(string $model, int $id, string $attribute = null)
    {
        $model = studly_case(trim($model));
        /** @var \App\Models\FinalReport $_model */
        $_model = class_exists($model) ? $model::findOrFail($id) : null;
        $_model ??= class_exists($app_model = "\\App\\Models\\{$model}") ? $app_model::findOrFail($id) : null;
        throw_unless($_model, "{$model} Not Exists!");
        throw_unless($_model->isFillable($attribute), "Attribute [{$attribute}] not in " . get_class($_model) . "::\$fillables !");

        $label = title_case(class_basename($app_model ?? $model)) . "-" . $_model->getKey();
        if( $_model->isFillable("{$attribute}_label") ) {
            $label = $_model->{"{$attribute}_label"} ?: $label;
        }
        if( $_model->isFillable("real_name") ) {
            $label = $_model->real_name ?: $label;
        }

        $disk = method_exists($_model, 'disk') ? fn($d = null) => $_model::disk($d) : fn($d = null) => Storage::disk($d);
        $path = $_model->getRawOriginal($attribute);
        $file = ($_disk = $disk(config('filesystems.default', 'public')))->exists($path) ? $_disk->path($path) : null;
        $file ??= ($_disk = $disk('local'))->exists($path) ? $_disk->path($path) : null;
        $file ??= ($_disk = $disk('public'))->exists($path) ? $_disk->path($path) : null;
        $file ??= ($_disk = $disk())->exists($path) ? $_disk->path($path) : null;
        $file ??= ($_disk = $disk())->exists($_path = storage_path($path)) ? $_disk->path($_path) : null;
        $file ??= ($_disk = $disk())->exists($_path = storage_path("app/public/{$path}")) ? $_disk->path($_path) : null;
        $file ??= ($_disk = $disk())->exists($_path = storage_path("app/{$path}")) ? $_disk->path($_path) : null;

        return response()->download($file, $label ?? $_model->getAttribute($attribute));
    }
}
