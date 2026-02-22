<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ProductPromotionController as AdminProductPromotionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\OnlineStoreController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ConsultationController;
// use App\Http\Controllers\Admin\CustomerExportController;
use App\Http\Controllers\Admin\BannerController; // <-- TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ============ SETTINGS ============
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        
        // ADMIN USERS
        Route::prefix('admin-users')->name('admin-users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        // ONLINE STORES
        Route::prefix('online-stores')->name('online-stores.')->group(function () {
            Route::get('/', [OnlineStoreController::class, 'index'])->name('index');
            Route::get('/create', [OnlineStoreController::class, 'create'])->name('create');
            Route::post('/', [OnlineStoreController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [OnlineStoreController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OnlineStoreController::class, 'update'])->name('update');
            Route::delete('/{id}', [OnlineStoreController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [OnlineStoreController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/reorder', [OnlineStoreController::class, 'reorder'])->name('reorder');
            Route::post('/update-order', [OnlineStoreController::class, 'updateOrder'])->name('update-order');
        });
        
        // ABOUT US
        Route::prefix('about-us')->name('about-us.')->group(function () {
            Route::get('/', [AboutUsController::class, 'index'])->name('index');
            
            Route::post('/sections', [AboutUsController::class, 'storeSection'])->name('sections.store');
            Route::put('/sections/{id}', [AboutUsController::class, 'updateSection'])->name('sections.update');
            Route::delete('/sections/{id}', [AboutUsController::class, 'destroySection'])->name('sections.destroy');
            Route::post('/sections/{id}/toggle-status', [AboutUsController::class, 'toggleSectionStatus'])->name('sections.toggle-status');
            Route::post('/sections/reorder', [AboutUsController::class, 'reorderSections'])->name('sections.reorder');
            
            Route::post('/team-members', [AboutUsController::class, 'storeTeamMember'])->name('team-members.store');
            Route::put('/team-members/{id}', [AboutUsController::class, 'updateTeamMember'])->name('team-members.update');
            Route::delete('/team-members/{id}', [AboutUsController::class, 'destroyTeamMember'])->name('team-members.destroy');
            Route::post('/team-members/reorder', [AboutUsController::class, 'reorderTeam'])->name('team-members.reorder');
            
            Route::post('/achievements', [AboutUsController::class, 'storeAchievement'])->name('achievements.store');
            Route::put('/achievements/{id}', [AboutUsController::class, 'updateAchievement'])->name('achievements.update');
            Route::delete('/achievements/{id}', [AboutUsController::class, 'destroyAchievement'])->name('achievements.destroy');
            Route::post('/achievements/reorder', [AboutUsController::class, 'reorderAchievements'])->name('achievements.reorder');
            
            Route::post('/core-values', [AboutUsController::class, 'storeCoreValue'])->name('core-values.store');
            Route::put('/core-values/{id}', [AboutUsController::class, 'updateCoreValue'])->name('core-values.update');
            Route::delete('/core-values/{id}', [AboutUsController::class, 'destroyCoreValue'])->name('core-values.destroy');
            Route::post('/core-values/reorder', [AboutUsController::class, 'reorderValues'])->name('core-values.reorder');
        });
        
        // ============ BANNERS - DI SINI (DI DALAM SETTINGS) ============
        Route::prefix('banners')->name('banners.')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('/create', [BannerController::class, 'create'])->name('create');
            Route::post('/', [BannerController::class, 'store'])->name('store');
            Route::get('/{banner}/edit', [BannerController::class, 'edit'])->name('edit');
            Route::put('/{banner}', [BannerController::class, 'update'])->name('update');
            Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('destroy');
            Route::post('/update-order', [BannerController::class, 'updateOrder'])->name('update-order');
            Route::post('/{banner}/toggle-active', [BannerController::class, 'toggleActive'])->name('toggle-active');
            Route::get('/{banner}/statistics', [BannerController::class, 'statistics'])->name('statistics');
        });
        
        // CONSULTATIONS
        Route::prefix('consultations')->name('consultations.')->group(function () {
            Route::get('/', [ConsultationController::class, 'index'])->name('index');
            Route::put('/general/{id}', [ConsultationController::class, 'updateGeneral'])->name('general.update');
            Route::put('/product/{id}', [ConsultationController::class, 'updateProduct'])->name('product.update');
            Route::put('/custom/{id}', [ConsultationController::class, 'updateCustom'])->name('custom.update');
        });  
        
        // GENERAL SETTINGS
        Route::prefix('general')->name('general.')->group(function () {
            Route::get('/', [SettingController::class, 'generalSettings'])->name('index');
            Route::post('/update', [SettingController::class, 'updateGeneralSettings'])->name('update');
        });
        
        // PAYMENT SETTINGS
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [SettingController::class, 'paymentSettings'])->name('index');
        });
        
        // SHIPPING SETTINGS
        Route::prefix('shippings')->name('shippings.')->group(function () {
            Route::get('/', [SettingController::class, 'shippingSettings'])->name('index');
        });
    });

    // ============ CUSTOMERS ============
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomerController::class, 'create'])->name('create');
        Route::post('/', [AdminCustomerController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminCustomerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminCustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminCustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminCustomerController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [AdminCustomerController::class, 'updateStatus'])->name('status.update');
        
        Route::get('/export/csv', [AdminCustomerController::class, 'exportCsv'])->name('export.csv');
        Route::get('/export/excel', [AdminCustomerController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [AdminCustomerController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/export/selected', [AdminCustomerController::class, 'exportSelected'])->name('export.selected');
    });

    // ============ ORDERS ============
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
        Route::post('/', [AdminOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminOrderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminOrderController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminOrderController::class, 'destroy'])->name('destroy');

        Route::post('/{id}/update-status', [AdminOrderController::class, 'updateOrderStatus'])->name('update-status');
        Route::post('/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('confirm-payment');
        Route::post('/{id}/mark-processing', [AdminOrderController::class, 'markAsProcessing'])->name('mark-processing');
        Route::post('/{id}/mark-completed', [AdminOrderController::class, 'markAsCompleted'])->name('mark-completed');
    });

    // ============ PRODUCTS ============
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminProductController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminProductController::class, 'destroy'])->name('destroy');

        Route::post('/quick-add-category', [AdminProductController::class, 'quickAddCategory'])->name('quick-add-category');
        Route::post('/{id}/upload-image', [AdminProductController::class, 'uploadImage'])->name('upload-image');
        Route::delete('/{id}/delete-image', [AdminProductController::class, 'deleteImage'])->name('delete-image');
    });

    // ============ PROMO CODES ============
    Route::prefix('promos')->name('promos.')->group(function () {
        Route::get('/', [AdminPromoCodeController::class, 'index'])->name('index');
        Route::get('/create', [AdminPromoCodeController::class, 'create'])->name('create');
        Route::post('/', [AdminPromoCodeController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminPromoCodeController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminPromoCodeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminPromoCodeController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminPromoCodeController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [AdminPromoCodeController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ============ PRODUCT PROMOTIONS ============
    Route::prefix('product-promotions')->name('product-promotions.')->group(function () {
        Route::get('/select-product', [AdminProductPromotionController::class, 'selectProduct'])->name('select-product');
        Route::get('/create/{productId}', [AdminProductPromotionController::class, 'create'])->name('create');
        Route::post('/store/{productId}', [AdminProductPromotionController::class, 'store'])->name('store');
        Route::get('/', [AdminProductPromotionController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminProductPromotionController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminProductPromotionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminProductPromotionController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminProductPromotionController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [AdminProductPromotionController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/product/{productId}', [AdminProductPromotionController::class, 'productPromotions'])->name('product-promotions');
    });
});