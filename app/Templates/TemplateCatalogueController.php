<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\{ModuleTemplate}ServiceInterface as {ModuleTemplate}Service;
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface as {ModuleTemplate}Repository;
use App\Http\Requests\Store{ModuleTemplate}Request;
use App\Http\Requests\Update{ModuleTemplate}Request;
use App\Http\Requests\Delete{ModuleTemplate}Request;
use App\Classes\Nestedsetbie;
use Auth;
use App\Models\Language;
use Illuminate\Support\Facades\App;

class {ModuleTemplate}Controller extends Controller
{
    use AuthorizesRequests;
    protected ${moduleTemplate}Service;
    protected ${moduleTemplate}Repository;
    protected $language;
    protected $nestedset;
    public function __construct(
        {ModuleTemplate}Service ${moduleTemplate}Service,
        {ModuleTemplate}Repository ${moduleTemplate}Repository
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->{moduleTemplate}Service = ${moduleTemplate}Service;
        $this->{moduleTemplate}Repository = ${moduleTemplate}Repository;
        
    }

    public function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => '{tableName}',
            'foreignkey' => '{foreignKey}',
            'language_id' => $this->language,
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', '{moduleView}.index');

        ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate($request, $this->language);

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => '{ModuleTemplate}',
        ];
        $config['seo'] = __('messages.{moduleTemplate}');
        $template = 'backend.{moduleView}.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            '{moduleTemplate}s',
        ));
    }

    public function create()
    {    
        $this->authorize('modules', '{moduleView}.create');
        $config = $this->configData();
        $config['seo'] = __('messages.{moduleTemplate}');
        $dropdown = $this->nestedset->Dropdown();
        $config['method'] = 'create';
        
        $template = 'backend.{moduleView}.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'  
  
        ));
    }

    public function store(Store{ModuleTemplate}Request $request){
        if($this->{moduleTemplate}Service->create($request)){
      
            return redirect()->route('{moduleView}.index');
        }
        
        return redirect()->route('{moduleView}.index');
    }

    public function edit($id)
    {
        $this->authorize('modules', '{moduleView}.update');
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, 
        $this->language);

        $config = $this->configData();
        $template = 'backend.{moduleView}.store';
        $dropdown = $this->nestedset->Dropdown();
        $config['seo'] = __('messages.{moduleTemplate}');
        $config['method'] = 'edit';
        $album = json_decode(${moduleTemplate}->album);
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            '{moduleTemplate}',
            'dropdown',
            'album'
        ));
    }

    public function update($id, Update{ModuleTemplate}Request $request)
    {
        if($this->{moduleTemplate}Service->update($id, $request)){
      
            return redirect()->route('{moduleView}.index');
        }
        
        return redirect()->route('{moduleView}.index');
    }

    public function delete($id)
    {
        $this->authorize('modules', '{moduleView}.destroy');
        $config['seo'] = __('messages.{moduleTemplate}');
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, 
        $this->language);
        $template = 'backend.{moduleView}.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            '{moduleTemplate}',
            'config'
            
        ));
    }

    public function destroy($id, Delete{ModuleTemplate}Request $request) 
    {
        if($this->{moduleTemplate}Service->destroy($id)){
            return redirect()->route('{moduleView}.index');
        }
        
        return redirect()->route('{moduleView}.index');
    }

    private function configData(){
        return [
            'js' => [
                'backend/plugin/ckeditor/ckeditor.js',
                'backend/plugin/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]
        ];
    }
}
