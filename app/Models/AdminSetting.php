<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    // Type constants
    const TYPE_STRING = 'string';
    const TYPE_JSON = 'json';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_INTEGER = 'integer';

    // Cast value berdasarkan type
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case self::TYPE_JSON:
                return json_decode($value, true);
            case self::TYPE_BOOLEAN:
                return (bool) $value;
            case self::TYPE_INTEGER:
                return (int) $value;
            default:
                return $value;
        }
    }

    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case self::TYPE_JSON:
                $this->attributes['value'] = json_encode($value);
                break;
            case self::TYPE_BOOLEAN:
                $this->attributes['value'] = (bool) $value;
                break;
            case self::TYPE_INTEGER:
                $this->attributes['value'] = (int) $value;
                break;
            default:
                $this->attributes['value'] = $value;
        }
    }

    // Static method untuk get setting
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Static method untuk set setting
    public static function setValue($key, $value, $type = self::TYPE_STRING, $group = 'general', $description = null)
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->type = $type;
        $setting->group = $group;
        $setting->description = $description;
        $setting->save();
        
        return $setting;
    }
}