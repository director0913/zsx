<?php

namespace GeniusTS\Roles\Models;


use GeniusTS\Roles\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use GeniusTS\Roles\Traits\RoleHasRelations;
use GeniusTS\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;

class Role extends Model implements RoleHasRelationsContract
{

    use Slugable, RoleHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'level'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection'))
        {
            $this->connection = $connection;
        }
    }
}
