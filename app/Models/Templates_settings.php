<?php
namespace App\Models;
use App\Traits\ActionButtonAttributeTrait;
use Illuminate\Database\Eloquent\Model;
class Templates_settings extends Model
{
    use ActionButtonAttributeTrait;

    protected $table = 'templates_settings';

}
