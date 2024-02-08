
# 🦅 Harvest for Silverstripe

[![Silverstripe Version](https://img.shields.io/badge/Silverstripe-5.1-005ae1.svg?labelColor=white&logoColor=ffffff&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDEuMDkxIDU4LjU1NSIgZmlsbD0iIzAwNWFlMSIgeG1sbnM6dj0iaHR0cHM6Ly92ZWN0YS5pby9uYW5vIj48cGF0aCBkPSJNNTAuMDE1IDUuODU4bC0yMS4yODMgMTQuOWE2LjUgNi41IDAgMCAwIDcuNDQ4IDEwLjY1NGwyMS4yODMtMTQuOWM4LjgxMy02LjE3IDIwLjk2LTQuMDI4IDI3LjEzIDQuNzg2czQuMDI4IDIwLjk2LTQuNzg1IDI3LjEzbC02LjY5MSA0LjY3NmM1LjU0MiA5LjQxOCAxOC4wNzggNS40NTUgMjMuNzczLTQuNjU0QTMyLjQ3IDMyLjQ3IDAgMCAwIDUwLjAxNSA1Ljg2MnptMS4wNTggNDYuODI3bDIxLjI4NC0xNC45YTYuNSA2LjUgMCAxIDAtNy40NDktMTAuNjUzTDQzLjYyMyA0Mi4wMjhjLTguODEzIDYuMTctMjAuOTU5IDQuMDI5LTI3LjEyOS00Ljc4NHMtNC4wMjktMjAuOTU5IDQuNzg0LTI3LjEyOWw2LjY5MS00LjY3NkMyMi40My0zLjk3NiA5Ljg5NC0uMDEzIDQuMTk4IDEwLjA5NmEzMi40NyAzMi40NyAwIDAgMCA0Ni44NzUgNDIuNTkyeiIvPjwvc3ZnPg==)](https://packagist.org/packages/goldfinch/harvest)
[![Package Version](https://img.shields.io/packagist/v/goldfinch/harvest.svg?labelColor=333&color=F8C630&label=Version)](https://packagist.org/packages/goldfinch/harvest)
[![Total Downloads](https://img.shields.io/packagist/dt/goldfinch/harvest.svg?labelColor=333&color=F8C630&label=Downloads)](https://packagist.org/packages/goldfinch/harvest)
[![License](https://img.shields.io/packagist/l/goldfinch/harvest.svg?labelColor=333&color=F8C630&label=License)](https://packagist.org/packages/goldfinch/harvest) 

**Harvest** is a seeder component 🚟 that helps you to bundle automation run by [**Taz**](https://github.com/goldfinch/taz)🌪️.

## Install

```bash
composer require goldfinch/harvest
```

## Available Taz commands

> Create new harvest
```bash
php taz make:harvest
```
> List all available harvesters
```bash
php taz harvest
```
> Run specific harvest
```bash
php taz harvest myharvest
```
> Run all available harvesters
```bash
php taz harvest:all
```

>> If you haven't used [**Taz**](https://github.com/goldfinch/taz)🌪️ before, *taz* file must be presented in your root project folder `cp vendor/goldfinch/taz/taz taz`

## Use Case example

Let's create a new harvest calling *Pages* that will handle Page [Mill](https://github.com/goldfinch/mill) which will generate fake records for us by firing a single command.

#### 1. Create new harvest

```bash
php taz make:harvest Pages
# What [short name] does this harvest need to be called by? : pages
```

After creating new harvest, we need to run dev/build to update harvest list

```bash
php taz dev/build
```

Now our harvest `pages` should be available in the harvest list, let's check that:

```bash
php taz harvest
```

#### 2. Create new mill

As we decide that our harvest will manage mill factory, we need to create one. For more info about mills please refer to [goldfinch/mill](https://github.com/goldfinch/mill)

```bash
php taz make:mill Page
# What [class name] does this mill is going to work with? : Page
```

Let's modify our Mill by adding some placeholder data:

```php
namespace App\Mills;

use Goldfinch\Mill\Mill;

class PageMill extends Mill
{
    public function factory(): array
    {
        return [
            'Title' => $this->faker->catchPhrase(),
            'Content' => $this->faker->paragraph(20),
        ];
    }
}
```

We also need to make sure that `Millable` trait is added to **Page** class as it states in [goldfinch/mill](https://github.com/goldfinch/mill).

```php
namespace {

    use Goldfinch\Mill\Traits\Millable;
    use SilverStripe\CMS\Model\SiteTree;

    class Page extends SiteTree
    {
        use Millable;

        private static $db = [];
    }
}
```

#### 3. Prepare your harvest

Now we can go back to our **PageHarvest** that was created by **Taz** in the first step and add our mill to it.

```php
namespace App\Harvest;

use Goldfinch\Harvest\Harvest;

class PagesHarvest extends Harvest
{
    public static function run(): void
    {
        \Page::mill(10)->make();
    }
}
```

#### 4. Use harvest

Now our harvest is ready to rock along with **Taz**. By firing our harvest, we should get 10 newly generated pages in admin site tree.

```bash
php taz harvest pages
```

## Recommendation
This module plays nicely with mill factory [goldfinch/mill](https://github.com/goldfinch/mill)

## License

The MIT License (MIT)
