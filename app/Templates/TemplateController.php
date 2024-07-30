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
use App\Models\Language;

class {ModuleTemplate}Controller extends Controller
{
    use AuthorizesRequests;
    protected ${moduleTemplate}Service;
    protected ${moduleTemplate}Repository;
    protected $languageRepository;
    protected $language;
    protected $nestedset;
    public function __construct(
        {moduleTemplate}Service ${moduleTemplate}Service,
        {moduleTemplate}Repository ${moduleTemplate}Repository,
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
        $this->initialize();
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
        $template = 'backend.{moduleTemplate}.{moduleTemplate}.index';
        $dropdown = $this->nestedset->Dropdown();
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            '{moduleTemplate}s',
            'dropdown',
       
        ));
    }

    public function create() 
    {    
        $this->authorize('modules', '{moduleTemplate}.create');
        $config = $this->configData();
        $config['seo'] = __('messages.{moduleTemplate}');
        $dropdown = $this->nestedset->Dropdown();
        $config['method'] = 'create';
        
        $template = 'backend.{moduleTemplate}.{moduleTemplate}.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'  
  
        ));
    }

    public function store(Store{ModuleTemplate}Request $request){
        if($this->{moduleTemplate}Service->create($request, $this->language)){
      
            return redirect()->route('{moduleTemplate}.index');
        }
        
        return redirect()->route('{moduleTemplate}.index');
    }

    public function edit($id)
    {
        $this->authorize('modules', '{moduleTemplate}.update');
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, 
        $this->language);

        $config = $this->configData();
        $template = 'backend.{moduleTemplate}.{moduleTemplate}.store';
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
      
            return redirect()->route('{moduleTemplate}.index');
        }
        
        return redirect()->route('{moduleTemplate}.index');
    }

    public function delete($id)
    {
        $this->authorize('modules', '{moduleTemplate}.destroy');
        $config['seo'] = __('messages.{moduleTemplate}');
        ${moduleTemplate} = $this->{moduleTemplate}Repository->get{moduleTemplate}ById($id, 
        $this->language);
        $template = 'backend.{moduleTemplate}.{moduleTemplate}.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            '{moduleTemplate}',
            'config'
            
        ));
    }

    public function destroy($id) 
    {
        if($this->{moduleTemplate}Service->destroy($id)){
            return redirect()->route('{moduleTemplate}.index');
        }
        
        return redirect()->route('{moduleTemplate}.index');
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
