<?php
namespace App\Models;
use App\Traits\ActionButtonAttributeTrait;
use Illuminate\Database\Eloquent\Model;
class Form extends Model
{
    use ActionButtonAttributeTrait;

    protected $table = 'form';

}
