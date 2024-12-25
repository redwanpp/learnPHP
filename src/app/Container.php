<?php

namespace App;

use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\NotFoundException;
use PhpParser\ConstExprEvaluationException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container Implements ContainerInterface
{

    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
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
        // 1. Inspect the class that we are trying to get from the container

        $reflectorClass = new \ReflectionClass($id);

        if(! $reflectorClass->isInstantiable()) {
            throw new ContainerException('Class "' . $id . '" is not instantiable');
        }

        // 2. Inspect the constructor of the class
        $constructor = $reflectorClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        // 3. Inspect the constructor parameters (dependencies)

        $parameters = $constructor->getParameters();

        if(! $parameters) {
            return new $id;
        }

        // 4. If the constructor parameter is a class then try to resolve the class using the container

        $dependencies = array_map(
            function(\ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if(! $type) {
                    throw new ContainerException('Failed to resolve class "' . $name . '" because param "' . $name . '" is missing type hint');
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new ContainerException('Failed to resolve "' . $id . '" because of union type for param "' . $name . '"');
                }

                if($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException(
                    'Failed to resolve class "' . $id . '"because invalid param "' . $name . '"'
                );
        },
            $parameters
        );

        return $reflectorClass->newInstanceArgs($dependencies);

    }
}