<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;


use App\Http\Requests\StoreUserCatalogueRequest;
use App\Http\Requests\UpdateUserCatalogRequest;

class UserCatalogueController extends Controller
{
    use AuthorizesRequests;
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;
    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
        PermissionRepository $permissionRepository
    ){
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }
    

    public function index(Request $request)
    {
        $this->authorize('modules', 'user.catalogue.index');
        $userCatalogues = $this->userCatalogueService->paginate($request);

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'UserCatalogue',
        ];
        $config['seo'] = config('apps.usercatalogue');
        $template = 'backend.user.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues'
        ));
    }

    public function create() 
    {      
        $this->authorize('modules', 'user.catalogue.create');
        $template = 'backend.user.catalogue.store';
        
        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'create';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
           
            
        ));
    }

    public function store(StoreUserCatalogueRequest $request){
        if($this->userCatalogueService->create($request)){
      
            return redirect()->route('user.catalogue.index');
        }
        
        return redirect()->route('user.catalogue.index');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'user.catalogue.update');
        $userCatalogue = $this->userCatalogueRepository->findById($id);
        $template = 'backend.user.catalogue.store';
        
        $config['seo'] = config('apps.usercatalogue');
        $config['method'] = 'edit';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue'
            
        ));
    }

    public function update($id, UpdateUserCatalogRequest $request)
    {
        if($this->userCatalogueService->update($id, $request)){
      
            return redirect()->route('user.catalogue.index');
        }
        
        return redirect()->route('user.catalogue.index');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'user.catalogue.delete');
        $config['seo'] = config('apps.usercatalogue');
        $userCatalogue = $this->userCatalogueRepository->findById($id);
        $template = 'backend.user.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'userCatalogue',
            'config'
            
        ));
    }

    public function destroy($id) 
    {
        if($this->userCatalogueService->destroy($id)){
      
            return redirect()->route('user.catalogue.index');
        }
        
        return redirect()->route('user.catalogue.index');
    }

    public function permission()
    {
        // $this->authorize('modules', 'user.catalogue.permission');
        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $permissions = $this->permissionRepository->all();
        $config['seo'] = __('messages.userCatalogue');
        $template = 'backend.user.catalogue.permission';
        return view('backend.dashboard.layout', compact(
            'template',
            'userCatalogues',
            'permissions',
            'config'
            
        ));
    }

    public function updatePermission(Request $request)
    {
        if($this->userCatalogueService->setPermission($request)){
            return redirect()->route('user.catalogue.index');
        }
        return redirect()->route('user.catalogue.index');
    }
}
