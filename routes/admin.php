<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\BookHomeCollectionController;
use App\Http\Controllers\Admin\PatientsConsumersController;
use App\Http\Controllers\Admin\FeedBackController;
use App\Http\Controllers\Admin\FrequentlyAskedQuestionsController;
use App\Http\Controllers\Admin\FranchisingOpportunitiesController;
use App\Http\Controllers\Admin\BookAppointmentController;
use App\Http\Controllers\Admin\HeadOfficeController;
use App\Http\Controllers\Admin\ReachUsController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\HospitalLabManagementController;
use App\Http\Controllers\Admin\ClinicalLabManagementController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HealthCheckupController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApiConfigController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\JobPostController;
use App\Http\Controllers\Admin\ResearchController;
use App\Http\Controllers\Admin\PaymentConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsAndEventsController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrganController;
use App\Http\Controllers\SitemapXmlController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth_users'])->group(function () {

    // ================================================= //
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            Route::post('/export', [DashboardController::class, 'exportData'])->name('dashboard.export');
        });
        Route::get('/dashboardData', [DashboardController::class, 'dashboardData'])->name('dashboard.data');
        Route::post('/dashboard-status', [DashboardController::class, 'status'])->name('dashboard.status');
        Route::post('/dashboard-remark', [DashboardController::class, 'remark'])->name('dashboard.remark');
        // Route::group(['prefix' => 'settings'], function () {
            Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
            Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
            Route::post('/profile_image', [ProfileController::class, 'imageDelete'])->name('profile.image');
        
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [UserController::class, 'index'])->name('user.index');
                Route::get('create', [UserController::class, 'create'])->name('user.create');
                Route::post('create', [UserController::class, 'store'])->name('user.store');
                Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::put('edit/{id}', [UserController::class, 'update'])->name('user.update');
                Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
            });
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', [RoleController::class, 'index'])->name('role.index');
                Route::get('create', [RoleController::class, 'create'])->name('role.create');
                Route::post('create', [RoleController::class, 'store'])->name('role.store');
                Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
                Route::put('edit/{id}', [RoleController::class, 'update'])->name('role.update');
                Route::delete('delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');
            });
            Route::group(['prefix' => 'api-config'], function () {
                Route::get('/', [ApiConfigController::class, 'index'])->name('api_config.index');
                Route::get('create', [ApiConfigController::class, 'create'])->name('api_config.create');
                Route::post('create', [ApiConfigController::class, 'store'])->name('api_config.store');
                Route::get('edit/{id}', [ApiConfigController::class, 'edit'])->name('api_config.edit');
                Route::post('edit/{id?}', [ApiConfigController::class, 'update'])->name('api_config.update');
                Route::delete('delete/{id}', [ApiConfigController::class, 'destroy'])->name('api_config.delete');
            });
            Route::group(['prefix' => 'payment-config'], function () {
                Route::get('/', [PaymentConfigController::class, 'index'])->name('payment_config.index');
                Route::get('create', [PaymentConfigController::class, 'create'])->name('payment_config.create');
                Route::post('create', [PaymentConfigController::class, 'store'])->name('payment_config.store');
                Route::get('edit/{id}', [PaymentConfigController::class, 'edit'])->name('payment_config.edit');
                Route::post('/edit/{id?}', [PaymentConfigController::class, 'update'])->name('payment_config.update');
                Route::delete('/payment-config-delete/{id}', [PaymentConfigController::class, 'destroy'])->name('payment_config.delete');
            });
        // });
        Route::group(['prefix' => 'master'], function () {
            Route::group(['prefix' => 'branch'], function () {
                Route::get('/', [BranchController::class, 'index'])->name('branch.index');
                Route::post('/', [BranchController::class, 'syncRequest'])->name('branch.sync');
                Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show');
            });
            Route::group(['prefix' => 'city'], function () {
                Route::get('/', [CityController::class, 'index'])->name('city.index');
                Route::post('/', [CityController::class, 'syncRequest'])->name('city.sync');
            });
            Route::group(['prefix' => 'test'], function () {
                Route::get('/', [TestController::class, 'index'])->name('test.index');
                Route::post('/', [TestController::class, 'syncRequest'])->name('test.sync');
                Route::get('show/{id}', [TestController::class, 'show'])->name('test.show');
                Route::get('edit/{id}', [TestController::class, 'edit'])->name('test.edit');
                Route::post('edit/{id}', [TestController::class, 'update'])->name('test.edit');
                Route::get('is_home', [TestController::class, 'status'])->name('test.is_home');
            });
            Route::group(['prefix' => 'banner'], function () {
                Route::get('/', [BannerController::class, 'index'])->name('banner.index');
                Route::get('create', [BannerController::class, 'create'])->name('banner.create');
                Route::post('create/{id?}', [BannerController::class, 'store'])->name('banner.store');
                Route::get('edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
                Route::delete('delete/{id?}', [BannerController::class, 'delete'])->name('banner.delete');
            });          
        });
        Route::group(['prefix' => 'news-and-events'], function () {
            Route::get('/', [NewsAndEventsController::class, 'index'])->name('news-and-events.index');
            Route::get('create', [NewsAndEventsController::class, 'create'])->name('news-and-events.create');
            Route::post('create/{id?}', [NewsAndEventsController::class, 'store'])->name('news-and-events.store');
            Route::post('update/{id?}', [NewsAndEventsController::class, 'update'])->name('news-and-events.update');
            Route::get('edit/{id}', [NewsAndEventsController::class, 'edit'])->name('news-and-events.edit');
            Route::delete('delete/{id?}', [NewsAndEventsController::class, 'destroy'])->name('news-and-events.destroy');
        });
        Route::group(['prefix' => 'news-letter'],function(){
            Route::get('/', [NewsLetterController::class, 'index'])->name('news-letter.index');
            Route::get('/{id}', [NewsLetterController::class, 'show'])->name('news-letter.show');
            Route::delete('/{id?}', [NewsLetterController::class, 'delete'])->name('news-letter.delete');
            Route::post('/export', [NewsLetterController::class, 'exportData'])->name('news-letter.export');

        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrdersController::class, 'index'])->name('orders.index');
            Route::get('/show/{id}', [OrdersController::class, 'show'])->name('orders.show');
            Route::post('/change-order-status/{id}', [OrdersController::class, 'change_order_status'])->name('orders.change-order-status');
            Route::post('/export', [OrdersController::class, 'exportData'])->name('orders.export');
        });

        Route::group(['prefix' => 'customers'], function () {
            Route::get('/', [CustomersController::class, 'index'])->name('customers.index');
            Route::get('/show/{id}', [CustomersController::class, 'show'])->name('customers.show');
            Route::post('/export', [CustomersController::class, 'exportData'])->name('customers.export');
        });

        Route::group(['prefix' => 'organs'], function () {
            Route::get('/', [OrganController::class, 'index'])->name('organ.index');
            Route::get('/create', [OrganController::class, 'create'])->name('organ.create'); 
            Route::post('/create', [OrganController::class, 'store'])->name('organ.store'); 
            Route::get('/edit/{id}', [OrganController::class, 'edit'])->name('organ.edit'); 
            Route::post('/edit/{id}', [OrganController::class, 'update'])->name('organ.update'); 
            Route::delete('/destroy/{id}', [OrganController::class, 'destroy'])->name('organ.destroy');  
        });
        Route::group(['prefix' => 'conditions'], function () {
            Route::get('/', [ConditionController::class, 'index'])->name('condition.index');
            Route::get('/create', [ConditionController::class, 'create'])->name('condition.create'); 
            Route::post('/create', [ConditionController::class, 'store'])->name('condition.store'); 
            Route::get('/edit/{id}', [ConditionController::class, 'edit'])->name('condition.edit'); 
            Route::post('/edit/{id}', [ConditionController::class, 'update'])->name('condition.update'); 
            Route::delete('/destroy/{id}', [ConditionController::class, 'destroy'])->name('condition.destroy');  
        }); 
    // ================================================= //


    // Route::get('patients', [EnquiryController::class, 'index'])->name('patients.index');
    // Route::get('doctors', [DoctorsController::class, 'index'])->name('doctors.index');
    // Route::get('health-checkup', [HealthCheckupController::class, 'index'])->name('health-checkup.index');
    // Route::get('reach-us', [ReachUsController::class, 'index'])->name('reach-us.index');

    Route::get('/home-collection', [BookHomeCollectionController::class, 'index'])->name('home-collection.index');
    Route::delete('/home-collection/{id}', [BookHomeCollectionController::class, 'destroy'])->name('home-collection.delete');
    Route::get('/home-collection/{id}', [BookHomeCollectionController::class, 'show'])->name('home-collection.show');
    Route::post('/home-collection/export', [BookHomeCollectionController::class, 'exportData'])->name('home-collection.export');


    Route::get('/feedback/{type?}', [FeedBackController::class, 'index'])->name('feedback.index');
    Route::delete('/feedback/destroy/{id}', [FeedBackController::class, 'destroy'])->name('feedback.delete');
    Route::get('/feedback/{type}/{id}', [FeedBackController::class, 'show'])->name('feedback.show');
    Route::post('/feedback/{type}/export', [FeedBackController::class, 'exportData'])->name('feedback.export');

    Route::get('/faq', [FrequentlyAskedQuestionsController::class, 'index'])->name('faq.index');
    Route::delete('/faq/{id}', [FrequentlyAskedQuestionsController::class, 'destroy'])->name('faq.delete');
    Route::get('/faq/{id}', [FrequentlyAskedQuestionsController::class, 'show'])->name('faq.show');
    Route::post('/faq/export', [FrequentlyAskedQuestionsController::class, 'exportData'])->name('faq.export');

    Route::get('/hospital-lab-management', [HospitalLabManagementController::class, 'index'])->name('hospital-lab-management.index');
    Route::delete('/hospital-lab-management/{id}', [HospitalLabManagementController::class, 'destroy'])->name('hospital-lab-management.delete');
    Route::get('/hospital-lab-management/{id}', [HospitalLabManagementController::class, 'show'])->name('hospital-lab-management.show');
    Route::post('/hospital-lab-management/export', [HospitalLabManagementController::class, 'exportData'])->name('hospital-lab-management.export');

    Route::get('/clinical-lab-management', [ClinicalLabManagementController::class, 'index'])->name('clinical-lab-management.index');
    Route::delete('/clinical-lab-management/{id}', [ClinicalLabManagementController::class, 'destroy'])->name('clinical-lab-management.delete');
    Route::get('/clinical-lab-management/{id}', [ClinicalLabManagementController::class, 'show'])->name('clinical-lab-management.show');
    Route::post('/clinical-lab-management/export', [ClinicalLabManagementController::class, 'exportData'])->name('clinical-lab-management.export');

    Route::get('/franchising-opportunities', [FranchisingOpportunitiesController::class, 'index'])->name('franchising-opportunities.index');
    Route::delete('/franchising-opportunities/{id}', [FranchisingOpportunitiesController::class, 'destroy'])->name('franchising-opportunities.delete');
    Route::get('/franchising-opportunities/{id}', [FranchisingOpportunitiesController::class, 'show'])->name('franchising-opportunities.show');
    Route::post('/franchising-opportunities/export', [FranchisingOpportunitiesController::class, 'exportData'])->name('franchising-opportunities.export');


    Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
    Route::delete('/research/{id}', [ResearchController::class, 'destroy'])->name('research.delete');
    Route::get('/research/{id}', [ResearchController::class, 'show'])->name('research.show');
    Route::post('/research/export', [ResearchController::class, 'exportData'])->name('research.export');


    Route::get('/patients-consumers', [PatientsConsumersController::class, 'index'])->name('patients-consumers.index');
    Route::delete('/patients-consumers/{id}', [PatientsConsumersController::class, 'destroy'])->name('patients-consumers.delete');
    Route::get('/patients-consumers/{id}', [PatientsConsumersController::class, 'show'])->name('patients-consumers.show');
    Route::post('/patients-consumers/export', [PatientsConsumersController::class, 'exportData'])->name('patients-consumers.export');


    Route::get('/book-an-appointment', [BookAppointmentController::class, 'index'])->name('book-an-appointment.index');
    Route::delete('/book-an-appointment/{id}', [BookAppointmentController::class, 'destroy'])->name('book-an-appointment.delete');
    Route::get('/book-an-appointment/{id}', [BookAppointmentController::class, 'show'])->name('book-an-appointment.show');
    Route::post('/book-an-appointment/export', [BookAppointmentController::class, 'exportData'])->name('book-an-appointment.export');

    Route::get('/healthcheckup-for-employee', [HeadOfficeController::class, 'index'])->name('healthcheckup-for-employee.index');
    Route::delete('/healthcheckup-for-employee/{id}', [HeadOfficeController::class, 'destroy'])->name('healthcheckup-for-employee.delete');
    Route::get('/healthcheckup-for-employee/{id}', [HeadOfficeController::class, 'show'])->name('healthcheckup-for-employee.show');
    Route::post('/healthcheckup-for-employee/export', [HeadOfficeController::class, 'exportData'])->name('healthcheckup-for-employee.export');


    Route::group(['prefix' => 'job-post'], function () {
        Route::get('/', [JobPostController::class, 'index'])->name('job-post.index');
        Route::get('/create', [JobPostController::class, 'create'])->name('job-post.create'); 
        Route::post('/create', [JobPostController::class, 'store'])->name('job-post.store'); 
        Route::get('/edit/{id}', [JobPostController::class, 'edit'])->name('job-post.edit'); 
        Route::post('/edit/{id}', [JobPostController::class, 'update'])->name('job-post.update'); 
        Route::delete('/destroy/{id}', [JobPostController::class, 'delete'])->name('job-post.destroy');  
    }); 
        Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('department.create'); 
        Route::post('/create', [DepartmentController::class, 'store'])->name('department.store'); 
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit'); 
        Route::post('/edit/{id}', [DepartmentController::class, 'update'])->name('department.update'); 
        Route::delete('/destroy/{id}', [DepartmentController::class, 'delete'])->name('department.destroy');  
    }); 
    Route::get('careers', [CareerController::class, 'index'])->name('careers.index');
    Route::delete('careers/delete/{id?}', [CareerController::class, 'delete'])->name('careers.delete'); 
    Route::get('careers/status/{id}', [CareerController::class, 'status'])->name('careers.status');
    Route::get('careers/resume/{id}', [CareerController::class, 'download'])->name('resume.download');
    Route::get('careers/view/{id}', [CareerController::class, 'view'])->name('careers.view');
    Route::post('/careers/export', [CareerController::class, 'exportData'])->name('careers.export');


    Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us.index');
    Route::delete('contact-us/delete/{id?}', [ContactUsController::class, 'delete'])->name('contact-us.delete'); 
    Route::get('contact-us/view/{id}', [ContactUsController::class, 'view'])->name('contact-us.view');
    Route::post('/contact-us/export', [ContactUsController::class, 'exportData'])->name('contact-us.export');

    
});

Route::get('test-mail',function() {
    $action = new ApiController();
    $action->sendMailNotification(6,'DENIED');
    return "action";
});
Route::get('/sitemap.xml', [SitemapXmlController::class, 'index']);
