<?php
   namespace App\Providers;

   use Illuminate\Support\ServiceProvider;

   class RepositoryServiceProvider extends ServiceProvider
     {
        protected static $repositories = [
            'order' => [
                \App\Repositories\Order\OrderRepositoryInterface::class,
                \App\Repositories\Order\OrderRepository::class,
            ],
            'product' => [
                \App\Repositories\Product\ProductRepositoryInterface::class,
                \App\Repositories\Product\ProductRepository::class,
            ],
            'category' => [
                \App\Repositories\Category\CategoryRepositoryInterface::class,
                \App\Repositories\Category\CategoryRepository::class
            ],
            'paymenttype' => [
                \App\Repositories\PaymentType\PaymentTypeRepositoryInterface::class,
                \App\Repositories\PaymentType\PaymentTypeRepository::class,
            ],
            'customer' => [
                \App\Repositories\Customer\CustomerRepositoryInterface::class,
                \App\Repositories\Customer\CustomerRepository::class,
            ],
            'orderdetail' => [
                \App\Repositories\OrderDetail\OrderDetailRepositoryInterface::class,
                \App\Repositories\OrderDetail\OrderDetailRepository::class,
            ],
            "blog" => [
                \App\Repositories\Blog\BlogRepositoryInterface::class,
                \App\Repositories\Blog\BlogRepository::class,
            ],
            "blogCategory" => [
                \App\Repositories\BlogCategory\BlogCategoryRepositoryInterface::class,
                \App\Repositories\BlogCategory\BlogCategoryRepository::class,
            ],

            'productprice' => [
                \App\Repositories\ProductPrice\ProductPriceRepositoryInterface::class,
                \App\Repositories\ProductPrice\ProductPriceRepository::class,
            ],
            'productoption' => [
                \App\Repositories\ProductOption\ProductOptionRepositoryInterface::class,
                \App\Repositories\ProductOption\ProductOptionRepository::class,
            ],
            'productdiscount' => [
                \App\Repositories\ProductDiscount\ProductDiscountRepositoryInterface::class,
                \App\Repositories\ProductDiscount\ProductDiscountRepository::class,
            ],

            "blogComment" => [
                \App\Repositories\BlogComment\BlogCommentRepositoryInterface::class,
                \App\Repositories\BlogComment\BlogCommentRepository::class,
            ],
            "address" => [
                \App\Repositories\Address\AddressRepositoryInterface::class,
                \App\Repositories\Address\AddressRepository::class,
            ],
            "import" => [
                \App\Repositories\Import\ImportRepositoryInterface::class,
                \App\Repositories\Import\ImportRepository::class,
            ],
            "importDetail" => [
                \App\Repositories\ImportDetail\ImportDetailRepositoryInterface::class,
                \App\Repositories\ImportDetail\ImportDetailRepository::class,
            ],"role" => [
                \App\Repositories\Role\RoleRepositoryInterface::class,
                \App\Repositories\Role\RoleRepository::class,
            ],
            "permission" => [
                \App\Repositories\Permission\PermissionRepositoryInterface::class,
                \App\Repositories\Permission\PermissionRepository::class,
            ],
            "command" => [
                \App\Repositories\Command\CommandRepositoryInterface::class,
                \App\Repositories\Command\CommandRepository::class,
            ],
            "roleHasPermission" => [
                \App\Repositories\RoleHasPermission\RoleHasPermissionRepositoryInterface::class,
                \App\Repositories\RoleHasPermission\RoleHasPermissionRepository::class,
            ],
            "administrators" => [
                \App\Repositories\Administrator\AdministratorRepositoryInterface::class,
                \App\Repositories\Administrator\AdministratorRepository::class,
            ],
            "userHasRole" => [
                \App\Repositories\UserHasRole\UserHasRoleRepositoryInterface::class,
                \App\Repositories\UserHasRole\UserHasRoleRepository::class,
            ],
            "grantPermission" => [
                \App\Repositories\GrantPermission\GrantPermissionRepositoryInterface::class,
                \App\Repositories\GrantPermission\GrantPermissionRepository::class,
            ],
            "voucher" => [
                \App\Repositories\Voucher\VoucherRepositoryInterface::class,
                \App\Repositories\Voucher\VoucherRepository::class,
            ],
            "customerVoucher" => [
                \App\Repositories\CustomerVoucher\CustomerVoucherRepositoryInterface::class,
                \App\Repositories\CustomerVoucher\CustomerVoucherRepository::class,
            ],
            "productReview" => [
                \App\Repositories\ProductReview\ProductReviewRepositoryInterface::class,
                \App\Repositories\ProductReview\ProductReviewRepository::class,
            ],
        ];

        /**
         * Bootstrap the application services.
         *
         * @return void
         */
        public function boot()
        {
            //
        }

        /**
         * Register the application services.
         *
         * @return void
         */
        public function register()
        {
            foreach (static::$repositories as $repository) {
                $this->app->singleton(
                    $repository[0],
                    $repository[1]
                );
            }
        }
}
