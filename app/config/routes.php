<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan 
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

// AUTH ROUTES
$router->get('/', 'AuthController::index');          // login page
$router->get('/login', 'AuthController::index');     // login page
$router->post('/login', 'AuthController::login');    // login form submit
$router->get('/register', 'AuthController::registerPage');
$router->post('/register', 'AuthController::register');
$router->get('/verify-email/{token}', 'AuthController::verifyEmail');
$router->get('/logout', 'AuthController::logout');

// DASHBOARD
$router->get('/admin/dashboard', 'AuthController::adminDashboard');
$router->get('/applicant/dashboard', 'ApplicantController::dashboard');
$router->get('/applicant/my-applications', 'ApplicantController::myApplications');
$router->get('/applicant/view-application/{id}', 'ApplicantController::viewApplication');
$router->get('/applicant/profile', 'ApplicantController::profile');
$router->post('/applicant/profile/update', 'ApplicantController::updateProfile');
$router->get('/applicant/settings', 'ApplicantController::settings');
$router->post('/applicant/settings/update-account', 'ApplicantController::updateAccount');
$router->post('/applicant/settings/change-password', 'ApplicantController::changePassword');


// USER CRUD (admin only)
$router->get('/admin/users', 'UserController::index');
$router->get('/admin/users/search', 'UserController::search');
$router->get('/admin/users/create', 'UserController::create');
$router->post('/admin/users/store', 'UserController::store');
$router->get('/admin/users/edit/{id}', 'UserController::edit');
$router->post('/admin/users/update/{id}', 'UserController::update');
$router->get('/admin/users/delete/{id}', 'UserController::destroy');

// APPLCATION FORM
$router->get('apply/form', 'ApplyController');
$router->post('apply/submit', 'ApplyController::submit');
$router->get('apply/success', 'ApplyController::success');
$route['dashboard_applicant'] = 'ApplyController::index';
$route['apply/submit'] = 'ApplyController::submit';

$router->get('/admin/dashboard', 'AdminController::dashboard');
$router->get('/admin/applications', 'AdminController::applications');
$router->get('/admin/view/{id}', 'AdminController::view');
$router->get('/admin/approve/{id}', 'AdminController::approve');
$router->get('/admin/reject/{id}', 'AdminController::reject');
$router->get('/admin/settings', 'AdminController::settings');
$router->post('/admin/settings/update-account', 'AdminController::updateAccount');
$router->post('/admin/settings/change-password', 'AdminController::changePassword');


