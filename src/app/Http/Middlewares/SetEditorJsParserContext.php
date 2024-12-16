<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Http\Middlewares;

use Closure;

class SetEditorJsParserContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['laravel-backpack-editorjs.context' => 'backpack']);

        return $next($request);
    }
}
