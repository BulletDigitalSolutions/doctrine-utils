# Doctrine Utils

Doctrine Utils is a package designed to enhance the functionality of Laravel applications by integrating advanced features for better route model bindings using Doctrine ORM.

## Features

### Route Model Bindings

This feature allows you to replace Laravel's default model binding with Doctrine's powerful ORM capabilities. By using Doctrine for model binding, you can take full advantage of Doctrine's features for retrieving entities.

## Installation

To install the Route Model Bindings feature, follow these steps:

1. **Replace Laravel Middleware:**
    Replace the default Laravel "substitute bindings" middleware with the middleware provided by Doctrine Utils. Update your `Kernel.php` middleware configuration to use the following middleware:

    ```php
    // In app/Http/Kernel.php
    protected $middlewareGroups = [
        'web' => [
            \Bullet\DoctrineUtils\Http\Middleware\SubstituteBindings::class,
            'domain.redirect',
        ],
    ];
    ```

2. **Implement UrlRoutable Interface:**
    Add the `UrlRoutable` interface to your base entity and implement the required methods. This interface is necessary for the middleware to resolve route bindings using Doctrine's entity repository. Here is an example of how to implement it:

    ```php
    namespace App\Entities;

    use Bullet\DoctrineUtils\Interfaces\UrlRoutable;

    class BaseEntity implements UrlRoutable
    {
        // Implement the required methods

        /**
         * Resolve the route binding.
         *
         * @param mixed $value
         * @param string|null $field
         * @return mixed
         */
        public static function resolveRouteBinding($value, $field = null)
        {
            $field = $field ?? self::getRouteKeyName();
            return self::repository()->findOneBy([$field => $value]);
        }

        /**
         * Get the route key name.
         *
         * @return string
         */
        public static function getRouteKeyName(): string
        {
            return 'id';
        }

        /**
         * Get the repository for the entity.
         *
         * @return \Doctrine\ORM\EntityRepository
         */
        public static function repository()
        {
            return app('em')->getRepository(get_called_class());
        }
    }
    ```

## Usage

Once installed, the Doctrine Utils package will automatically handle route model bindings using Doctrine's entity repository. This allows you to define routes and controllers in Laravel as usual, while benefiting from the enhanced ORM capabilities provided by Doctrine.

### Example

Here is an example of how it works:

1. **Define Routes:**

    ```php
    use Illuminate\Support\Facades\Route;

    Route::get('{plant}', [PlantController::class, 'show']);
    Route::get('{plant:slug}', [PlantController::class, 'showBySlug']);
    ```

2. **Controller Methods:**

    ```php
    namespace App\Http\Controllers;

    use App\Entities\Plant;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;

    class PlantController extends Controller
    {
        /**
         * Show the plant details.
         *
         * @param Plant $plant
         * @param Request $request
         * @return Response
         */
        public function show(Plant $plant, Request $request): Response
        {
            // Handle the request with the injected Plant entity
        }

        /**
         * Show the plant details by slug.
         *
         * @param Plant $plant
         * @param Request $request
         * @return Response
         */
        public function showBySlug(Plant $plant, Request $request): Response
        {
            // Handle the request with the injected Plant entity
        }
    }
    ```

## Requirements

- Laravel 8.x or higher
- Doctrine ORM

## License

Doctrine Utils is open-source software licensed under the MIT license. Feel free to contribute or modify the package to suit your needs.

## Contributing

If you would like to contribute to Doctrine Utils, please fork the reposit

