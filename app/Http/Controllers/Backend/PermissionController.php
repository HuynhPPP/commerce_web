<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PermissionServiceInterface as PermissionService;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionRepository;
    public function __construct(
        PermissionService $permissionService,
        PermissionRepository $permissionRepository
    ){
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $permissions = $this->permissionService->paginate($request);


        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'permission',
        ];
        $config['seo'] = __('messages.permission');
        $template = 'backend.permission.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'permissions',
        ));
    }

    public function create() {    
        
        $config = $this->configData();
        $config['seo'] = __('messages.permission');
        $config['method'] = 'create';
        $template = 'backend.permission.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',  
        ));
    }

    public function store(StorePermissionRequest $request){
        if($this->permissionService->create($request)){
      
            return redirect()->route('permission.index');
        }
        
        return redirect()->route('permission.index');
    }

    public function edit($id)
    {
       
        $permission = $this->permissionRepository->findById($id);
        $config = $this->configData();
        $template = 'backend.permission.store';
        
        $config['seo'] = __('messages.permission');
        $config['method'] = 'edit';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'permission'
            
        ));
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        if($this->permissionService->update($id, $request)){
      
            return redirect()->route('permission.index');
        }
        
        return redirect()->route('permission.index');
    }

    public function delete($id)
    {
        $config['seo'] = __('messages.permission');
        $permission = $this->permissionRepository->findById($id);
        $template = 'backend.permission.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'permission',
            'config'
            
        ));
    }

    public function destroy($id) 
    {
        if($this->permissionService->destroy($id)){
      
            return redirect()->route('permission.index');
        }
        
        return redirect()->route('permission.index');
    }

    private function configData(){
        return [
           
        ];
    }

}
