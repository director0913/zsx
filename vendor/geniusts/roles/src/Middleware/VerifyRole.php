<?php

namespace GeniusTS\Roles\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use GeniusTS\Roles\Exceptions\RoleDeniedException;

class VerifyRole
{

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param int|string               $role
     *
     * @return mixed
     * @throws \GeniusTS\Roles\Exceptions\RoleDeniedException
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->auth->check() && $this->auth->user()->isRole($role))
        {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
