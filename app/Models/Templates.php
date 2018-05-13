<?php
namespace App\Models;
use App\Traits\ActionButtonAttributeTrait;
use Illuminate\Database\Eloquent\Model;
class Templates extends Model
{
    use ActionButtonAttributeTrait;

    protected $table = 'templates';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function setLevelAttribute($value)
    {
        if ($value && is_numeric($value)) {
            $this->attributes['level'] = intval($value);
        }else{
            $this->attributes['level'] = 1;
        }
    }

}
