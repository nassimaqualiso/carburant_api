<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\NatureController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DataCarController;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SubNatureController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CategoryParamterController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\SalePriceController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleEnergyController;
use App\Http\Controllers\VehicleLengthController;
use App\Http\Controllers\VehiclePeriodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [LoginController::class, 'register'])->name('register');




Route::middleware('auth:api')->group(
    function () {
        //log out

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        //Role Permissions
        Route::post('/roles/{id}/update-permissions
        ', [RoleController::class, 'update_role_permissions'])->name('role_permissions.update');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{id}', [RoleController::class, 'show'])->name('roles.show');

        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

        //Companies

        Route::get('companies/datatable', [CompanyController::class, 'datatable'])->name('companies.datatable');
        Route::apiResource('companies', CompanyController::class);


        //Centers
        Route::get('centers/datatable', [CenterController::class, 'datatable'])->name('centers.datatable');
        Route::apiResource('centers', CenterController::class);

        Route::get('branches/datatable', [BranchController::class, 'datatable'])->name('branches.datatable');
        Route::apiResource('branches', BranchController::class);

        //users
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::get(
            '/user',
            function (Request $request) {
                    return $request->user();
                }
        );

        //Employees
        Route::get('employees/datatable', [EmployeeController::class, 'datatable'])->name('employees.datatable');
        Route::apiResource('employees', EmployeeController::class);

        //DataCar
        Route::get('datacar/datatable', [DataCarController::class, 'datatable'])->name('datacar.datatable');
        Route::apiResource('datacar', DataCarController::class);

        //Vehicle
        Route::get('vehicle/datatable', [VehicleController::class, 'datatable'])->name('vehicle.datatable');
        Route::get('vehicle/get_customer_list', [VehicleController::class, 'getCustomerList'])->name('vehicle.get_customer_list');
        Route::apiResource('vehicle', VehicleController::class);

        //vehicle brand
        Route::get('vehicle_brands/datatable', [VehicleBrandController::class, 'datatable'])->name('vehicle_brands.datatable');
        Route::get('vehicle_brands/get_list', [VehicleBrandController::class, 'getList'])->name('vehicle_brands.get_list');
        Route::apiResource('vehicle_brands', VehicleBrandController::class);

        //vehicle models
        Route::get('vehicle_models/datatable', [VehicleModelController::class, 'datatable'])->name('vehicle_models.datatable');
        Route::get('vehicle_models/get_list', [VehicleModelController::class, 'getList'])->name('vehicle_models.get_list');
        Route::apiResource('vehicle_models', VehicleModelController::class);

        //vehicle energy
        Route::get('vehicle_energies/datatable', [VehicleEnergyController::class, 'datatable'])->name('vehicle_energies.datatable');
        Route::get('vehicle_energies/get_list', [VehicleEnergyController::class, 'getList'])->name('vehicle_energies.get_list');
        Route::apiResource('vehicle_energies', VehicleEnergyController::class);

        //vehicle period
        Route::get('vehicle_periods/datatable', [VehiclePeriodController::class, 'datatable'])->name('vehicle_periods.datatable');
        Route::get('vehicle_periods/get_list', [VehiclePeriodController::class, 'getList'])->name('vehicle_periods.get_list');
        Route::apiResource('vehicle_periods', VehiclePeriodController::class);

        //vehicle Length
        Route::get('vehicle_lengths/datatable', [VehicleLengthController::class, 'datatable'])->name('vehicle_lengths.datatable');
        Route::get('vehicle_lengths/get_list', [VehicleLengthController::class, 'getList'])->name('vehicle_lengths.get_list');
        Route::apiResource('vehicle_lengths', VehicleLengthController::class);

        //Customers
        Route::get('customers/datatable', [CustomerController::class, 'datatable'])->name('customers.datatable');
        Route::apiResource('customers', CustomerController::class);

        //Forfait
        Route::post('forfaits/importExcelForfait', [ForfaitController::class, 'importExcelFile'])->name('forfait.import.excel');
        Route::get('forfaits/exportExcelForfait', [ForfaitController::class, 'exportExcelFile'])->name('forfait.export.excel');
        Route::post('forfaits/sendEmailForfait', [ForfaitController::class, 'sendEmail'])->name('forfait.send.email');

        Route::get('forfaits/get_list_nature', [ForfaitController::class, 'getListNature']);
        Route::get('forfaits/get_sub_nature', [ForfaitController::class, 'getListSubNature']);
        Route::get('forfaits/get_datacar_brands', [ForfaitController::class, 'getDataCarBrands']);
        Route::get('forfaits/get_datacar_models', [ForfaitController::class, 'getDataCarModels']);
        Route::get('forfaits/get_datacar_energies', [ForfaitController::class, 'getDataCarEnergies']);
        Route::get('forfaits/get_datacar_periods', [ForfaitController::class, 'getDataCarPeriods']);
        Route::get('forfaits/get_datacar_lengths', [ForfaitController::class, 'getDataCarLengths']);
        Route::get('forfaits/get_datacar', [ForfaitController::class, 'getDataCar']);
        Route::get('forfaits/datatable', [ForfaitController::class, 'datatable'])->name('forfaits.datatable');
        Route::apiResource('forfaits', ForfaitController::class);
        // Natures
        Route::get('natures/datatable', [NatureController::class, 'datatable'])->name('natures.datatable');
        Route::apiResource('natures', NatureController::class);

        // Natures
        Route::apiResource('subnatures', SubNatureController::class);

        // Product Categories
        Route::get('product-categories/datatable', [ProductCategoryController::class, 'datatable'])->name('product-categories.datatable');
        Route::apiResource('product-categories', ProductCategoryController::class);


        // Products
        Route::get('products/datatable', [ProductController::class, 'datatable'])->name('products.datatable');
        Route::apiResource('products', ProductController::class);

        // Packs
        Route::get('packs/datatable', [PackController::class, 'datatable'])->name('packs.datatable');
        Route::apiResource('packs', PackController::class);

        // Parameters
        Route::get('category-paramters', [CategoryParamterController::class, 'index'])->name('category-parameters.index');

        // SalePrices
        Route::get('sale_prices/get_list_customers', [SalePriceController::class, 'getListCustomers'])->name('sale_prices.get_list_customers');
        Route::get('sale_prices/get_list_centers', [SalePriceController::class, 'getListCenters'])->name('sale_prices.get_list_centers');
        Route::get('sale_prices/get_product_categories', [SalePriceController::class, 'getProductCategories'])->name('sale_prices.get_product_categories');
        Route::get('sale_prices/get_articles', [SalePriceController::class, 'getArticles'])->name('sale_prices.get_articles');
        Route::get('sale_prices/datatable', [SalePriceController::class, 'datatable'])->name('sale_prices.datatable');
        Route::apiResource('sale_prices', SalePriceController::class);

        // discount
        Route::get('discounts/get_list_customers', [DiscountController::class, 'getListCustomers'])->name('discounts.get_list_customers');
        Route::get('discounts/get_list_centers', [DiscountController::class, 'getListCenters'])->name('discounts.get_list_centers');
        Route::get('discounts/get_product_categories', [DiscountController::class, 'getProductCategories'])->name('discounts.get_product_categories');
        Route::get('discounts/get_articles', [DiscountController::class, 'getArticles'])->name('discounts.get_articles');
        Route::get('discounts/datatable', [DiscountController::class, 'datatable'])->name('discounts.datatable');
        Route::apiResource('discounts', DiscountController::class);
    }
);
