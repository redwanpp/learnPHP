<?php

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use Psr\Container\ContainerInterface;

class Container Implements ContainerInterface
{

    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException('Class "' . $id . '" is not instantiable');
        }

        $constructor = $reflectionClass->getConstructor();

        if(! $constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if(! $parameters) {
            return new $id;
        }

        $dependencies = array_map(function(\ReflectionParameter $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (! $type) {
                throw new ContainerException('Parameter "' . $name . '" of type "' . $name . '" is required');
            }
        }, $parameters);
    }
}