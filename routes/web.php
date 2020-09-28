<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
 * Routes for both Welcome Page View and all Authentication Control
 */
Route::get('/', 'AdminController@welcomeToApp');
Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@authenticate')->name('login.authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('login.logout');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');



/*------------------------------------------------------------------------------------*/
/*
 * Routes for all ADMIN Control
 */
Route::get('/home', 'AdminController@index')->name('admin.home');



/*-------------------------------------------------------------------------------------*/
/*
 * Routes for all TEACHER Control
 */
// Route::get('/teacher', 'TeacherController@index')->name('teachers.index'); // List all teachers
// Route::get('/teacher/create', 'TeacherController@create')->name('teachers.create');
// Route::post('/teacher', 'TeacherController@store')->name('teachers.store');


/*-------------------------------------------------------------------------------------*/
/*
 * Routes for all FORMATION Control
 */
Route::get('/formation', 'FormationController@index')->name('formation.showAll');
Route::post('/formation/add', 'FormationController@add')->name('formation.add');
Route::delete('/formation/delete/{id}', 'FormationController@delete')->name('formation.delete');

/*-------------------------------------------------------------------------------------*/
/*
 * Routes for all FORMATION Control
 */
Route::get('/formation/session/create', "FormationSessionController@create")->name('formation.session.create');
Route::post('/formation/store', 'FormationSessionController@store')->name('formation.session.store');
Route::get('/formation/{id}/sessions', 'FormationSessionController@showSessionWithFormationId')->name('formation.session.showWithFormationId');
Route::get('/formation/sessions', 'FormationSessionController@showAllSessions')->name('formation.session.showAll');
Route::get('/formation/sessions/expired', 'FormationSessionController@showExpiredSessions')->name('formation.session.expired');
Route::get('/formation/session/{id}', 'FormationSessionController@showASession')->name('formation.session.showOne');
Route::put('/formation/session/{id}/update', 'FormationSessionController@update')->name('formation.session.update');
Route::delete('/formation/session/{id}/delete', 'FormationSessionController@delete')->name('formation.session.delete');
// Route::get('/badge', 'FormationSessionController@generateBadgeView')->name('formation.session.badge-view');
Route::get('/formation/session/{id}/generate-badge', 'FormationSessionController@generateBadgePdf')->name('formation.session.badge-pdf');



/*------------------------------------------------------------------------------------*/
/*
 * Routes for all STUDENTS Control
 */
Route::get('/student', 'StudentController@index')->name('student.home');
Route::get('/student/old', 'StudentController@oldStudents')->name('student.old');
Route::post('/student/fsession{id}/add', 'StudentController@add')->name('student.add');
Route::get('/student/certified', 'StudentController@certifiedStudents')->name('student.certifiedStudent');
Route::get('/student/{id}', 'StudentController@showOne')->name('student.showOne');
Route::put('/student/{id}/pay', 'StudentController@pay')->name('student.pay');
Route::put('/student/update/{id}', 'StudentController@update')->name('student.update');
Route::delete('/student/{id}/delete', 'StudentController@delete')->name('student.delete');
Route::get('actualStudentsExport', 'StudentController@exportActualStudents')->name('student.export.actualStudents');
Route::get('oldStudentsExport', 'StudentController@exportOldStudents')->name('students.export.oldStudents');
Route::get('certifiedStudentsExport', 'StudentController@exportCertifiedStudents')->name('students.export.certifiedStudents');

/*------------------------------------------------------------------------------------*/

/*------------------------------------------------------------------------------------*/
/*
 * Routes for all TEACHERS Control
 */
Route::get('/teacher', 'TeacherController@index')->name('teacher.home');
Route::get('/teacher/{id}', 'TeacherController@showOne')->name('teacher.showOne');
Route::put('teacher/update/{id}', 'TeacherController@update')->name('teacher.update');

/*------------------------------------------------------------------------------------*/

/*------------------------------------------------------------------------------------*/
/*
 * Routes for all FEES Control
 */
Route::get('fee-problems', 'FeeController@index')->name('fees.home') ;
Route::get('fee-problems/downloadToExcel', 'StudentController@exportStudentsWithProblems')->name('fees.studentsWithProblems.export');

/*------------------------------------------------------------------------------------*/