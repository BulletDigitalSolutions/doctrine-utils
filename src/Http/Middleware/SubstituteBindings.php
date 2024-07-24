<?php

namespace Bullet\DoctrineUtils\Http\Middleware;

use Bullet\DoctrineUtils\Interfaces\UrlRoutable;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Routing\Route;
use LaravelDoctrine\ORM\Middleware\SubstituteBindings as BaseSubstituteBindings;
use ReflectionParameter;

class SubstituteBindings extends BaseSubstituteBindings
{
    protected function substituteImplicitBindings(Route $route)
    {
        $parameters = $route->parameters();

        foreach ($this->signatureParameters($route) as $parameter) {
            $id = $parameters[$parameter->name];
            $class = $this->getClassName($parameter);
            $field = $route->bindingFieldFor($parameter->name);

            $reflectionClass = new \ReflectionClass($class);

            if ($reflectionClass->implementsInterface(UrlRoutable::class)) {
                $name = $field ?? call_user_func([$class, 'getRouteKeyName']);

                $entity = call_user_func([$class, 'resolveRouteBinding'], $id, $name);

                if (is_null($entity) && ! $parameter->isDefaultValueAvailable()) {
                    throw EntityNotFoundException::fromClassNameAndIdentifier($class, ['id' => $id]);
                }

                $route->setParameter($parameter->name, $entity);
            }
        }
    }

    /**
     * @return ReflectionParameter[]
     */
    private function signatureParameters(Route $route)
    {
        return collect($route->signatureParameters())
            ->reject(function (ReflectionParameter $parameter) use ($route) {
                return ! array_key_exists($parameter->name, $route->parameters());
            })
            ->reject(function (ReflectionParameter $parameter) {
                return ! $this->getClassName($parameter);
            })->toArray();
    }

    private function getClassName(ReflectionParameter $parameter): ?string
    {
        $class = null;

        if (($type = $parameter->getType()) && $type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
            $class = $type->getName();
        }

        return $class;
    }
}
