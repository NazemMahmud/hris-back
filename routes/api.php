<?php

use Illuminate\Support\Facades\Route;
use App\User;

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
Route::get('/users', 'AuthController@getusers');
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getMe', function () {
        $user = User::find(2);
        $user->assignRole(['writer']);
    });
});

Route::resource('/languages', 'Setup\LanguageController');

//medical claim request
Route::resource('/medical-claim-requests', 'MedicalClaim\MedicalClaimRequestController');
Route::post('/medical-claim-requests/upload-files/{medicalClaimRequestId}', 'MedicalClaim\MedicalClaimRequestController@fileUpload');


Route::resource('/medical-claim-requests', 'MedicalClaim\MedicalClaimRequestController');
Route::resource('/medical-claim-items', 'MedicalClaim\MedicalClaimItemController');

Route::resource('/medical-claim-requests', 'MedicalClaim\MedicalClaimRequestController');


//EmployeeDesignationController Api
Route::resource('/employee-designations', 'EmployeeDesignation\EmployeeDesignationController');
Route::resource('/treatment-modes', 'MedicalSetup\TreatmentModeController');

Route::resource('/positions', 'Setup\PositionController');
Route::resource('/roles', 'Setup\RoleController');
Route::resource('/organization-bands', 'Setup\OrganizationBandController');
Route::resource('/groups', 'Setup\GroupController');

Route::resource('/nationalities', 'Setup\NationalityController');
Route::get('/get-group-permission/{groupId}', 'Setup\PageController@getPagesWithPermission');

Route::resource('/relation-types', 'Setup\RelationTypeController');

Route::post('/create-user', 'UserController@store');
Route::resource('/employee-contact-infos', 'Employee\EmployeeContactInfoController');

Route::resource('/approvalFlow-type', 'ApprovalFlow\ApprovalFlowTypeController');
Route::resource('/leave_types', 'Setup\LeaveTypeController');
Route::resource('/leave_requests', 'Leave\LeaveRequestController');

//Employee route
Route::resource('/employee-basic-info', 'Employee\BasicInfoController');
Route::post('/employee-basic-info/{staffId}', 'Employee\BasicInfoController@store');
Route::get('/employee-names', 'Employee\BasicInfoController@getAllNames');
Route::get('/getMyProfile', 'Employee\BasicInfoController@employeeInfo');
Route::get('/child-info/{staffId}', 'Employee\EmployeeInfoController@employeeChildInfo');
Route::get('/family-info/{staffId}', 'Employee\EmployeeInfoController@employeeFamilyInfo');
Route::post('/basicInfo/uploadImage/{staffId}', 'Employee\BasicInfoController@uploadImage');
Route::resource('/employee-contact-info', 'Employee\EmployeeContactInfoController');
Route::get('/not-user-employee', 'Employee\EmployeeContactInfoController@getNotUserEmployee');
Route::resource('/employee-education', 'EmployeeEducation\EmployeeEducationController');


Route::get('/employee/managers', 'Employee\EmployeeInfoController@getGroupWiseEmployeeInfo');

Route::get('/employee-basic-info/{id}', 'Employee\EmployeeController@getEmployeeBasicInfo');
Route::get('/employee-education-info/{id}', 'Employee\EmployeeController@getEmployeeEducationInfo');

Route::get('/employee-contact-info/{id}', 'Employee\EmployeeController@getEmployeeContactInfo');
Route::resource('/employee-family-info', 'Employee\EmployeeFamilyMemberInfoController');


Route::resource('/employee-previus-company-histories', 'Employee\EmployeePreviusCompanyHistoryController');
Route::get('/employee/organogram/{employeeId}', 'Employee\EmployeeInfoController@getEmployeeOrganogram');
Route::any('/employee/import', 'Employee\EmployeeController@import');
Route::resource('/employees', 'Employee\EmployeeController');

//Holiday route
Route::resource('/fixed-holidays', 'Holiday\FixedHolidayController');
Route::resource('/holidays', 'Holiday\HolidayController');
Route::get('/between-holidays', 'Holiday\HolidayController@getHolidaysWithIn');

//leave route
Route::resource('/leave-approval-request', 'Leave\LeaveApprovalRequestsController');
Route::resource('/leave-balance', 'Leave\LeaveBalanceController');
Route::get('/remaining-leave-balance', 'Leave\LeaveBalanceController@getRemainingLeave');
Route::get('/leave-balances', 'Leave\LeaveBalanceController@getLeaveBalance');
Route::resource('/leave-requests', 'Leave\LeaveRequestController');
Route::resource('/second-time-bridge-leave', 'Leave\LeaveRequestController@secondTimeBridgeLeave');
Route::get('/check-bridge-leave', 'Leave\LeaveRequestController@checkBridgeLeave');
//Route::get('/check-bridge-count', 'Leave\LeaveRequestController@checkbridgeLeaveCount');
Route::get('/leave-requests-list/{employeeId}', 'Leave\LeaveRequestController@getLeaveRequestList');
Route::get('/mss-leave-requests-list/{mssId}', 'Leave\LeaveRequestController@getLeaveRequests');
Route::get('/leave-acceptance', 'Leave\LeaveRequestController@leaveAcceptance');

Route::get('/employee-leave-types', 'Setup\LeaveTypeController@getEmployeeLeaveTypes');

Route::get('/get-employee-job-level/{employeeId}', 'Setup\EmployeeJobLevelController@getEmployeejoblevel');
Route::get('/get-employee-position/{employeeId}', 'Setup\EmployeeUnitController@getEmployeeunit');

Route::resource('/employee-requisition', 'Employee\RequisitionController');
Route::get('/get-employee-requisition/{employeeId}', 'Employee\RequisitionController@employeeRequisition');
Route::get('/get-employee-requisition-request-data/{employeeId}', 'Employee\RequisitionController@getEmployeeRequisitionRequestData');
Route::put('/employee-requisition-request/{requisition_Id}', 'Employee\RequisitionController@employeeRequisitionRequest');
Route::get('/get-employee-designation/{employeeId}', 'Employee\EmployeeInfoController@getemployeedesignation');
Route::get('/get-line-manager-under-hrbp/{employeeId}', 'Employee\EmployeeInfoController@getlinemanagerunderhrbp');


//shift route
Route::resource('/shift-type', 'ShiftType\ShiftTypeController');
Route::get('/employee-shift/{employeeId}', 'ShiftType\ShiftTypeController@getShiftdetailsWithEmployeeId');

// Setup Related Route API
Route::resource('/hospitals', 'Setup\HospitalController');
Route::resource('/relationships', 'Setup\RelationshipController');
Route::resource('/bands', 'Setup\BandController');
Route::resource('banks', 'Setup\BankController');
Route::resource('/blood-groups', 'Setup\BloodGroupController');
Route::resource('/branches', 'Setup\BranchController');
Route::resource('/cities', 'Setup\CityController');
Route::resource('/contract-types', 'Setup\ContractTypeController');
Route::resource('/countries', 'Setup\CountryController');
Route::resource('/districts', 'Setup\DistrictController');
Route::resource('/divisions', 'Setup\DivisionController');
Route::resource('/education-levels', 'Setup\EducationLevelController');
Route::resource('/employee-contracts', 'Setup\EmployeeContractController');
Route::resource('/employee-departments', 'Setup\EmployeeDepartmentController');
Route::resource('/employee-divisions', 'Setup\EmployeeDivisionController');
Route::resource('/employee-levels', 'Setup\EmployeeLevelController');
Route::resource('/employee-locations', 'Setup\EmployeeLocationController');
Route::resource('/employee-sublocations', 'Setup\EmployeeSublocationController');
Route::resource('/employee-types', 'Setup\EmployeeTypeController');
Route::resource('/employee-units', 'Setup\EmployeeUnitController');

Route::resource('/employee-tax-responsible', 'Setup\TaxResponsibleController');
Route::resource('/employee-contract-duration', 'Setup\ContractDurationController');

Route::resource('/genders', 'Setup\GenderController');

Route::resource('/marital-statuses', 'Setup\MaritalStatusController');
Route::resource('/organization_departments', 'Setup\OrganizationDepartmentController');
Route::resource('/organization_divisions', 'Setup\OrganizationDivisionController');

Route::get('/get-all-pages-for-parent', 'Setup\PageController@getAllPagesForParent');
Route::resource('/relationships', 'Setup\RelationshipController');

Route::post('/employee-to-user', 'AuthController@employee_register');

Route::get('/get-division-requitment/{staffId}', 'Employee\EmployeeInfoController@getDivisionRequitment');
Route::get('/get-unit-requitment/{staffId}', 'Employee\EmployeeInfoController@getUnitRequitment');

Route::get('/get-department-requitment/{staffId}', 'Employee\EmployeeInfoController@getDepartmentRequitment');


Route::resource('/basicInfo', 'Employee\BasicInfoController');



Route::resource('/employeeInfo', 'Employee\EmployeeInfoController');
Route::resource('/employee-education-infos', 'Employee\EmployeeEducationInfoController');


Route::resource('/leave-types', 'Setup\LeaveTypeController');
Route::resource('/bloodgroup', 'Setup\BloodGroupController');
Route::resource('/pages', 'Setup\PageController');

Route::resource('/approval-flow-type', 'ApprovalFlow\ApprovalFlowTypeController');
Route::resource('/approval-flow-levels', 'ApprovalFlow\ApprovalFlowLevelController');
Route::get('/approval-flow-level', 'ApprovalFlow\ApprovalFlowLevelController@getAllFlowLevels');



Route::resource('/employee_education_infos', 'Employee\EmployeeEducationInfoController');
Route::resource('/employee_contact_infos', 'Employee\EmployeeContactInfoController');
Route::resource('/employee_previus_company_histories', 'Employee\EmployeePreviusCompanyHistoryController');

Route::get('/user-check', 'UserController@index');
Route::get('/refresh-Token', 'AuthController@refresh');
Route::resource('/organization_units', 'Setup\OrganizationUnitController');



Route::post('/fileupload', 'FileupdateHelperController@store')->name('fileupload');

Route::get('/pages-with-permission', 'Setup\PageController@getPages');
Route::get('/get-employee-info/{staffId}', 'Employee\EmployeeInfoController@getEmployeeInfo');

Route::resource('/group-permission', 'Permission\GroupPermissionController');
Route::put('/group-permission', 'Permission\GroupPermissionController@updateAll');
Route::resource('/payment-type', 'Setup\PaymenTypeController');

Route::resource('/employee-status', 'Setup\EmployeeStatusController');
Route::resource('/employee-exit-reason', 'Setup\EmployeeExitReasonController');
Route::resource('/employee-job-level', 'Setup\EmployeeJobLevelController');
Route::get('/employees/managers', 'Employee\EmployeeInfoController@getGroupWiseEmployeeInfo');
Route::resource('/working-day', 'Setup\WorkingDayController');
Route::resource('/occupations', 'Setup\OccupationController');
Route::resource('/employee-children', 'Setup\EmployeeChildrenController');


// Roster
Route::resource('/roster', 'Roster\RosterController');
Route::resource('/employee-roster', 'Roster\EmployeeRosterController');
Route::resource('/roster-attendance', 'Roster\RosterAttendanceController');
Route::get('/rsattendace', 'Roster\RosterAttendanceController@getRosterAttendance');
Route::get('/get-rosters', 'Roster\EmployeeRosterController@getEmployeeRoster');
Route::get('/roster-conflict/{staffId}', 'Roster\RosterAttendanceController@checkConflict');

/* Overtime and Attendance */
Route::get('/overtime-store', 'Overtime\OvertimeController@store');
Route::get('/overtimes', 'Overtime\OvertimeController@show');
Route::get('/overtimes-basic-info', 'Overtime\OvertimeController@overtimeBasicInfo');
Route::get('/overtime-request-claim', 'Overtime\OvertimeApprovalRequestsController@claim');
Route::get('/overtime-approval-requests', 'Leave\OvertimeController@show');
Route::get('/mss-overtime-requests-list', 'Overtime\OvertimeApprovalRequestsController@getOvertimeApprovalLists');
Route::get('/overtime-acceptance', 'Overtime\OvertimeApprovalRequestsController@overtimeAcceptance');

/* Attendance */
Route::get('/attendance', 'Attendance\AttendanceController@index');
Route::get('/attendance/{staff_id}', 'Attendance\AttendanceController@show');
Route::get('/attendance/current-date/{staff_id}', 'Attendance\AttendanceController@currentDateAttendance');
Route::get('/manual-attendance/check-employee-attendance', 'Attendance\AttendanceController@checkEmployeeAttendance');
Route::post('/attendance/manual-attendance/{staff_id}', 'Attendance\AttendanceController@manualAttendance');

Route::get('/attendance/get-team-attendance/{first_line_manager_id}', 'Attendance\AttendanceController@getTeamAttendance');
Route::post('/attendance/store-attendance', 'Attendance\AttendanceController@store');

Route::resource('/daycare', 'Employee\DayCareController');
Route::post('/daycare-request/', 'Employee\DayCareController@DayCareRequestStore');

Route::resource('/attendance-status', 'Setup\AttendanceStatusController');
Route::resource('/employee-children-infos', 'Employee\EmployeeChildrenInfoController');
Route::get('/employee-wise-children-infos/{staff_id}', 'Employee\EmployeeChildrenInfoController@EmployeeWiseChildren');

Route::get('/employee-attendance-status', 'Attendance\AttendanceController@changeEmployeeAttendanceStatus');

/* Manual Attendance */
Route::resource('/manual-attendance', 'Attendance\ManualAttendanceController');
Route::post('/manual-attendance-approval/{manual_attendance_id}', 'Attendance\ManualAttendanceApprovalController@manualAttendanceAcceptance');

/* Travel */
Route::resource('/travels', 'Travel\TravelController');
Route::resource('/trip-types', 'Travel\TripTypeController');
Route::resource('/trip-purposes', 'Travel\TripPurposeController');
Route::resource('/trip-reasons', 'Travel\TripReasonController');
Route::resource('/trip-modes', 'Travel\ModeOfTravelController');
Route::resource('/tallowance-setup', 'Travel\TravelAllowanceSetupController');
Route::get('/travel-allowance/{travel_id}', 'Travel\TravelAllowanceController@show');
Route::get('/travel-approval-request', 'Travel\TravelController@travelApprovalRequest');
Route::post('/travel-approval-proccess/{travel_id}', 'Travel\TravelApprovalController@approvalProccess');
//travel invoice
Route::resource('/travel-invoices', 'Travel\TravelInvoiceController');
Route::resource('/travel-invoice-request', 'Travel\TravelInvoiceApprovalController');
Route::post('/travel-invoice-approval/{travel_invoice_id}', 'Travel\TravelInvoiceApprovalController@approvalProccess');
Route::get('/tinvoice-approval-request', 'Travel\TravelController@travelInvoiceApprovalRequest');



Route::get('/employee-info-pending-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@employeeInfoPendingUpdateRequest');
Route::get('/basic-info-pending-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@basicInfoPendingUpdateRequest');
Route::get('/contact-info-pending-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@contactInfoPendingUpdateRequest');
Route::get('/family-info-pending-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@familyInfoPendingUpdateRequest');
Route::get('/education-info-pending-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@educationInfoPendingUpdateRequest');

Route::get('/employee-info-history-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@employeeInfoHistoryUpdateRequest');
Route::get('/basic-info-history-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@basicInfoHistoryUpdateRequest');
Route::get('/contact-info-history-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@contactInfoHistoryUpdateRequest');
Route::get('/family-info-history-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@familyInfoHistoryUpdateRequest');
Route::get('/education-info-history-update-request/{first_line_manager_id}', 'Employee\RequestedDataController@educationInfoHistoryUpdateRequest');

Route::post('/employee-info-update-request/{staff_id}', 'Employee\RequestedDataController@employeeInfoUpdateRequest');
Route::post('/basic-info-update-request/{staff_id}', 'Employee\RequestedDataController@basicInfoUpdateRequest');
Route::post('/contact-info-update-request/{staff_id}', 'Employee\RequestedDataController@contactInfoUpdateRequest');
Route::post('/family-info-update-request/{staff_id}', 'Employee\RequestedDataController@familyInfoUpdateRequest');


Route::get('/employees-children-in-daycare/{staff_id}', 'Employee\DayCareController@employeesChildrenInDaycare');

Route::get('/employees-daycare-eligibility/{staff_id}', 'Employee\DayCareController@daycareClaimEligibility');
Route::get('/department-by-division/{division_id}', 'Setup\EmployeeDepartmentController@getDepartmentByDivision');

// deceased claim
Route::get('/age-check', 'Employee\EmployeeInfoController@getAge');
Route::get('/deceased-claim-store', 'Employee\EmployeeInfoController@deceasedClaimStore');
Route::resource('/employee-deceased-infos', 'Employee\EmployeeDeceasedInfoController');

//E & C Setup
Route::get('/employees-by-department', 'Employee\EmployeeInfoController@getByDepartment');
Route::get('/employee-departments-by-division', 'Setup\EmployeeDepartmentController@getByDivision');
Route::resource('/engagement-and-culture-list', 'EngagementAndCulture\EmployeeEngagementAndCultureListController');
Route::resource('/engagement-and-culture-approval', 'EngagementAndCulture\EngagementAndCultureApprovalController');

// Special Children Benefit
Route::get('/employee-info-for-special-children-benefit', 'Employee\EmployeeInfoController@getEmployeeForSpecialChild');
Route::get('/special-children-for-employee', 'SpecialChildren\SpecialChildrenController@getSpecialChildForEmployee');
Route::get('/special-children', 'SpecialChildren\SpecialChildrenController@getSpecialChild');
