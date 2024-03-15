<?php

namespace App\Http\Controllers\Web;

use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientStoreRequest;
use App\Http\Requests\Web\UserProfileRequest;
use App\Http\Requests\Web\UserStoreRequest;
use App\Http\Requests\Web\UserUpdateRequest;
use App\Services\GovernorateService;
use App\Services\TargetService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(private UserService $userService)
    {

    }

    public function index(Request $request)
    {
        
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['targets'];
        $users = $this->userService->getAll(filters: $filters, withRelations: $withRelations);
        return View('Dashboard.Users.index', compact(['users']));
    }//end of index


    public function create(Request $request)
    {
        return view('Dashboard.Users.create');
    }//end of create

    public function store(UserStoreRequest $request)
    {
        try {
            $status = $this->userService->store($request->validated());
            return redirect()->route('users.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of store

    public function edit(Request $request, $id)
    {

        $user = $this->userService->findById(id: $id);
        if (!$user)
        {
            return redirect()->back()->with("message", __('lang.not_found'));
        }
        return view('Dashboard.Users.edit', compact('user'));
    }//end of edit

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $status = $this->userService->update(id: $id, data: $request->validated());
            return redirect()->route('users.index')->with('message', __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }//end of update

    public function profileView()
    {
        try {
            $user = Auth::user();
            return view('Dashboard.Users.profile', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of destroy

    public function profile(UserProfileRequest $request)
    {
        try {
            $userId = Auth::user()->id;
            $result = $this->userService->update(id: $userId, data: $request->validated());
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of destroy

    public function destroy($id)
    {
        try {
            $result = $this->userService->destroy($id);
            if (!$result)
                return redirect()->back()->with("message", __('lang.not_found'));
            return redirect()->back()->with("message", __('lang.success_operation'));
        } catch (\Exception $e) {
            return redirect()->back()->with("message", $e->getMessage());
        }
    } //end of destroy

    // public function show(Request $request, $id)
    // {
    //     userCan(request: $request, permission: 'view_category');
    //     $category = $this->categoryService->find($id);
    //     if (!$category)
    //     {
    //         $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
    //         return back()->with('toast', $toast);
    //     }
    //    return view('dashboard.categories.show', compact('category'));
    // } //end of show

    // public function changeStatus(Request $request)
    // {
    //     try {
    //         $result =  $this->categoryService->changeStatus($request->id);
    //         if (!$result)
    //             return apiResponse(message: trans('lang.not_found'), code: 404);
    //         return apiResponse(message: trans('lang.success'));
    //     } catch (\Exception $exception) {
    //         return apiResponse(message: $exception->getMessage(), code: 422);
    //     }

    // } //end of changeStatus
}
