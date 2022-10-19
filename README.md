<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<p align="center">Final Destination</p>

- Graduated Project of the Team 1

- node modules: 
  + npm install
  + npm run dev
  + npm install jquery
  + npm install jsdom
  + npm i common-js
  + npm fund

Process coding a livewire component (Example: Categories module)
- Open terminal
- Step 1: php artisan make:livewire categories/AdminCategoryComponent
        php artisan make:livewire categories/AdminAddCategoryComponent
        php artisan make:livewire categories/AdminEditCategoryComponent

- Step 2: go to <-- routes/web.php --> to set route for module
        // Route group for categories
        Route::get('/categories', AdminCategoryComponent::class)->name('categories');
        Route::get('/categories/add', AdminAddCategoryComponent::class)->name('addcategory');
        Route::get('/categories/edit/{category_slug}', AdminEditCategoryComponent::class)->name('editcategory');
    
    this route in middleware route

- Step 3: php artisan:make model

- Step 4: go to <-- resources/views/livewire/categories -->
    Create list, add, edit view for components

- Step 5: go to <-- app/Http/Livewire/Categories -->
    Handle logic for this components

Organize code: Controller / Liveware -> useCase (business logic) -> Repository (logic query)

