<?php
//Home
$router->get('/', 'Employee/Home/HomeController@index'); 
$router->get('employee/home', 'Employee/Home/HomeController@index');

// Employee PDS Preview
$router->get('employee/pds/preview', 'Employee/Pds/PdsController@index');

//Employee Register
$router->get('employee/register', 'Employee/Register/RegisterController@index');
$router->post('employee/register', 'Employee/Register/RegisterController@register');
$router->get('employee/departments/json', 'Employee/Register/DepartmentController@getAllJson');


// Employee login
$router->get('employee/login', 'Employee/Login/LoginController@index');
$router->post('employee/login', 'Employee/Login/LoginController@login');
$router->get('employee/logout', 'Employee/Login/LoginController@logout');

//Employee Dashboard
$router->get('employee/dashboard', 'Employee/Dashboard/DashboardController@index');

// Employee Personal Information
$router->get('employee/info', 'Employee/Info/InfoController@index');
$router->get('employee/info/get', 'Employee/Info/InfoController@get');
$router->post('employee/info/save', 'Employee/Info/InfoController@save');

//Employee Family Background
$router->get('employee/famback', 'Employee/Famback/FambackController@index');
$router->get('employee/famback/get', 'Employee/Famback/FambackController@get');
$router->post('employee/famback/save', 'Employee/Famback/FambackController@save');

//Employee Educational Background
$router->get('employee/eduback', 'Employee/Eduback/EdubackController@index');
$router->get('employee/eduback/get', 'Employee/Eduback/EdubackController@get');
$router->post('employee/eduback/save', 'Employee/Eduback/EdubackController@save');

//Employee Graduate Studies
$router->get('employee/eduback/graduate', 'Employee\Eduback\GraduateStudiesController@index');
$router->get('employee/eduback/graduate/get', 'Employee\Eduback\GraduateStudiesController@get');
$router->post('employee/eduback/graduate/save', 'Employee\Eduback\GraduateStudiesController@save');
$router->post('employee/eduback/graduate/delete', 'Employee\Eduback\GraduateStudiesController@delete');

// Employee Graduate - Dropdown Courses
$router->get('employee/eduback/graduate/getAllJson', 'Employee\Eduback\GraduateController@getAllJson');


//Employee civil Service Eligibility
$router->get('employee/civilser', 'Employee/Civilser/CivilserController@index');
$router->get('employee/civilser/get', 'Employee/Civilser/CivilserController@get');
$router->post('employee/civilser/save', 'Employee/Civilser/CivilserController@save');
$router->post('employee/civilser/delete', 'Employee/Civilser/CivilserController@delete');

$router->get('employee/workexp', 'Employee\Workexp\WorkexpController@index');
$router->get('employee/workexp/get', 'Employee\Workexp\WorkexpController@get');
$router->post('employee/workexp/save', 'Employee\Workexp\WorkexpController@save');
$router->post('employee/workexp/delete', 'Employee\Workexp\WorkexpController@delete');


// Employee Voluntary Work
$router->get('employee/volunterwork', 'Employee\Volunterwork\VolunterworkController@index');
$router->get('employee/volunterwork/get', 'Employee\Volunterwork\VolunterworkController@get');
$router->post('employee/volunterwork/save', 'Employee\Volunterwork\VolunterworkController@save');
$router->post('employee/volunterwork/deleteWork', 'Employee\Volunterwork\VolunterworkController@deleteWork');

// Employee Learning & Development
$router->get('employee/learndev', 'Employee/Learndev/LearndevController@index');
$router->get('employee/learndev/get', 'Employee/Learndev/LearndevController@get');
$router->post('employee/learndev/save', 'Employee/Learndev/LearndevController@save');
$router->post('employee/learndev/delete', 'Employee/Learndev/LearndevController@delete');

// Employee Other Information
$router->get('employee/otherinfo', 'Employee/Otherinfo/OtherinfoController@index');
$router->get('employee/otherinfo/get', 'Employee/Otherinfo/OtherinfoController@get');
$router->post('employee/otherinfo/save', 'Employee/Otherinfo/OtherinfoController@save');
$router->post('employee/otherinfo/delete', 'Employee/Otherinfo/OtherinfoController@delete');
$router->get('employee/otherinfo/search-skills', 'Employee/Otherinfo/OtherinfoController@searchSkills');


//Employee C4 Section
$router->get('employee/c4sections', 'Employee/C4sections/C4sectionsController@index');
$router->get('employee/c4sections/get', 'Employee/C4sections/C4sectionsController@get');
$router->post('employee/c4sections/save', 'Employee/C4sections/C4sectionsController@save');

//Employee Tranings
$router->get('employee/trainings/history', 'Employee\Trainings\TrainingsController@index');      
$router->get('employee/trainings/history/fetch', 'Employee\Trainings\TrainingsController@fetchTrainings'); 
$router->post('employee/trainings/history/accept', 'Employee\Trainings\TrainingsController@acceptTraining');
$router->post('employee/trainings/history/cancel', 'Employee\Trainings\TrainingsController@cancelTraining');


// Admin login
$router->get('admin/login', 'Admin\AdminLoginController@index');
$router->post('admin/login', 'Admin\AdminLoginController@login');
$router->get('admin/logout', 'Admin\AdminLoginController@logout');

// Full Admin dashboard
$router->get('admin/fulladmindashboard', 'Admin\FullAdminDashboardController@index');
$router->get('admin/fulladmin/logout', 'Admin\FullAdminDashboardController@logout');
$router->post('admin/fulladmin/addUser', 'Admin\FullAdminDashboardController@addUser');
$router->post('admin/fulladmin/updateUser', 'Admin\FullAdminDashboardController@updateUser');
$router->post('admin/fulladmin/deleteUser', 'Admin\FullAdminDashboardController@deleteUser');
$router->get('admin/fulladmin/getUserById', 'Admin\FullAdminDashboardController@getUserById');

// Admin dashboard 
$router->get('admin/dashboard', 'Admin\AdminDashboardController@index');
$router->get('admin/dashboard/fetch', 'Admin\AdminDashboardController@fetch');

// Admin Employee List Routes
$router->get('admin/employeelist', 'Admin\EmployeeListController@index');
$router->get('admin/employeelist/fetchAllJson', 'Admin\EmployeeListController@fetchAllJson');
$router->post('admin/employeelist/updateEmployee', 'Admin\EmployeeListController@updateEmployee');   
$router->get('admin/employeelist/getEmployee', 'Admin\EmployeeListController@getEmployee');
$router->post('admin/employeelist/delete', 'Admin\EmployeeListController@delete');
$router->post('admin/employeelist/deleteGraduateStudy', 'Admin\EmployeeListController@deleteGraduateStudy');
$router->post('admin/employeelist/deleteCivilService', 'Admin\EmployeeListController@deleteCivilService');
$router->post('admin/employeelist/deleteWorkExperience', 'Admin\EmployeeListController@deleteWorkExperience');
$router->post('admin/employeelist/deleteVoluntaryWork', 'Admin\EmployeeListController@deleteVoluntaryWork');
$router->post('admin/employeelist/deleteLearningDevelopment', 'Admin\EmployeeListController@deleteLearningDevelopment');
$router->post('admin/employeelist/deleteOtherInformation', 'Admin\EmployeeListController@deleteOtherInformation');
$router->get('admin/employeelist/servePDF', 'Admin\EmployeeListController@servePDF');

// Admin Graduate Studies Management
$router->get('admin/gradtable', 'Admin/GradTableController@index');        
$router->get('admin/gradtable/getAll', 'Admin/GradTableController@getAll');  
$router->post('admin/gradtable/add', 'Admin/GradTableController@add');       
$router->post('admin/gradtable/update', 'Admin/GradTableController@update'); 
$router->post('admin/gradtable/delete', 'Admin/GradTableController@delete'); 

// Admin Academic Rank Routes 
$router->get('admin/academicrank', 'Admin\AcademicRankController@index');
$router->get('admin/academicrank/getAll', 'Admin\AcademicRankController@getAll'); 
$router->post('admin/academicrank/add', 'Admin\AcademicRankController@add');     
$router->post('admin/academicrank/update', 'Admin\AcademicRankController@update');
$router->post('admin/academicrank/delete', 'Admin\AcademicRankController@delete'); 

// Department / Offices CRUD
$router->get('admin/depoffices', 'Admin\DepOfficesController@index');
$router->get('admin/depoffices/getAll', 'Admin\DepOfficesController@getAll');
$router->post('admin/depoffices/add', 'Admin\DepOfficesController@add');
$router->post('admin/depoffices/update', 'Admin\DepOfficesController@update');
$router->post('admin/depoffices/delete', 'Admin\DepOfficesController@delete');


//Admin Manage Account
$router->get('admin/manageaccounts', 'Admin\ManageAccountController@index');
$router->get('admin/manageaccount/fetchAllJson', 'Admin\ManageAccountController@fetchAllJson');
$router->post('admin/manageaccount/update', 'Admin\ManageAccountController@update');
$router->post('admin/manageaccount/delete', 'Admin\ManageAccountController@delete');
$router->post('admin/manageaccount/add', 'Admin\ManageAccountController@add');
$router->post('admin/manageaccount/getAllDepartments', 'Admin\ManageAccountController@getAllDepartments');
$router->post('admin/manageaccount/getAllAcademicRanks','Admin\ManageAccountController@getAllAcademicRanks');


// Admin Reports
$router->get('admin/reports', 'Admin\ReportsController@index');
$router->post('admin/reports/chartData', 'Admin\ReportsController@chartData');

//Admin Graduate Studies
$router->get('admin/graduatestudies', 'Admin\GraduateStudiesController@index'); 
$router->get('admin/graduatestudies/fetchAllJson', 'Admin\GraduateStudiesController@fetchAllJson'); 
$router->post('admin/graduatestudies/update', 'Admin\GraduateStudiesController@update'); 
$router->post('admin/graduatestudies/delete', 'Admin\GraduateStudiesController@delete'); 

// PDC Login
$router->get('pdc/login', 'Pdc\PdcLoginController@index');
$router->post('pdc/login', 'Pdc\PdcLoginController@login');
$router->post('pdc/logout', 'Pdc\PdcLoginController@logout');

// PDC dashboard
$router->get('pdc/dashboard', 'Pdc\PdcDashboardController@index');
$router->get('pdc/dashboard/stats', 'Pdc\PdcDashboardController@stats');


//PDC EmployeeList
$router->get('pdc/employeelist', 'Pdc\EmployeeListController@index');
$router->get('pdc/employeelist/fetchAllJson', 'Pdc\EmployeeListController@fetchAllJson');
$router->get('pdc/employeelist/viewPDS', 'Pdc\EmployeeListController@viewPDS');

// PDC Training Routes
$router->get('pdc/training', 'Pdc\TrainingController@index');             
$router->get('pdc/training/getTrainings', 'Pdc\TrainingController@getTrainings'); 
$router->post('pdc/training/addTraining', 'Pdc\TrainingController@addTraining');  
$router->post('pdc/training/deleteTraining', 'Pdc\TrainingController@deleteTraining'); 
$router->post('pdc/training/updateTraining', 'Pdc\TrainingController@updateTraining');
$router->get('pdc/training/getTrainingsJson', 'Pdc\TrainingController@getTrainingsJson');
$router->get('pdc/training/getTypes', 'Pdc\TrainingController@getTypes');
$router->get('pdc/training/getCategories', 'Pdc\TrainingController@getCategories');


// PDC Training Categories Routes
$router->get('pdc/trainingcategories', 'Pdc\TrainingCategoriesController@index');
$router->get('pdc/trainingcategories/fetch', 'Pdc\TrainingCategoriesController@fetch'); 
$router->post('pdc/trainingcategories/store', 'Pdc\TrainingCategoriesController@store');
$router->post('pdc/trainingcategories/update', 'Pdc\TrainingCategoriesController@update');
$router->post('pdc/trainingcategories/delete', 'Pdc\TrainingCategoriesController@delete');

// PDC Training Types Routes
$router->get('pdc/trainingtypes', 'Pdc\TrainingTypesController@index');
$router->get('pdc/trainingtypes/fetch', 'Pdc\TrainingTypesController@fetch'); 
$router->post('pdc/trainingtypes/store', 'Pdc\TrainingTypesController@store');
$router->post('pdc/trainingtypes/update', 'Pdc\TrainingTypesController@update');
$router->post('pdc/trainingtypes/delete', 'Pdc\TrainingTypesController@delete');

//Training Participants Routes
$router->get('pdc/trainingparticipants', 'Pdc\TrainingParticipantsController@index');
$router->get('pdc/trainingparticipants/getParticipants', 'Pdc\TrainingParticipantsController@getParticipants');
$router->post('pdc/trainingparticipants/addParticipant', 'Pdc\TrainingParticipantsController@addParticipant');
$router->post('pdc/trainingparticipants/deleteParticipant', 'Pdc\TrainingParticipantsController@deleteParticipant');
$router->get('pdc/trainingparticipants/getRecommendedEmployeesContentBased', 'Pdc\TrainingParticipantsController@getRecommendedEmployeesContentBased');

//Trainings JSON for dropdown
$router->get('pdc/training/getTrainingsJson', 'Pdc\TrainingController@getTrainingsJson');

// PDC Reports
$router->get('pdc/reports', 'Pdc\ReportsController@index');
$router->get('pdc/reports/getParticipantsReport', 'Pdc\ReportsController@getParticipantsReport');
$router->post('pdc/reports/getParticipantsChart', 'Pdc\ReportsController@getParticipantsChart');
$router->post('pdc/reports/getParticipantsStatusChart', 'Pdc\ReportsController@getParticipantsStatusChart'); 