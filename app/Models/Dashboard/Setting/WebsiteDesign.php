<?php

namespace App\Models\Dashboard\Setting;

use Illuminate\Database\Eloquent\Model;

class WebsiteDesign extends Model
{
    protected $fillable = ['name', 'folder', 'is_active'];

    public static function setActiveDesign($designId)
    {
        // Deactivate all designs
        self::query()->update(['is_active' => false]);
        // Activate the selected design
        self::where('id', $designId)->update(['is_active' => true]);
    }

    public static function getActiveDesign()
    {
        return self::where('is_active', true)->first();
    }
}
