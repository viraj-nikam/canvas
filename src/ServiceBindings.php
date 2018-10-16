<?php

namespace Canvas;

trait ServiceBindings
{
    /**
     * Here we define all of the service bindings for Canvas.
     *
     * @var array
     */
    public $serviceBindings = [
        // Repository services...
        Interfaces\PostInterface::class => Repositories\Eloquent\PostRepository::class,
        Interfaces\TagInterface::class => Repositories\Eloquent\TagRepository::class,
    ];
}
