<?php
namespace App\Models;
use App\Traits\ActionButtonAttributeTrait;
use Illuminate\Database\Eloquent\Model;
class Templates_answer extends Model
{
    use ActionButtonAttributeTrait;

    protected $table = 'templates_answer';

}
