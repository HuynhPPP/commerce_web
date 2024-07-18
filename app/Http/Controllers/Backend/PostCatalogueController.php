<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Classes\Nestedsetbie;

class PostCatalogueController extends Controller
{
    use AuthorizesRequests;
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $language;
    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository
    ){
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'post.catalogue.index');

        $postCatalogues = $this->postCatalogueService->paginate($request);

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'PostCatalogue',
        ];
        $config['seo'] = __('messages.postCatalogue');
        $template = 'backend.post.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogues',
        ));
    }

    public function create()
    {    
        $this->authorize('modules', 'post.catalogue.create');
        $config = $this->configData();
        $config['seo'] = config('apps.postcatalogue');
        $dropdown = $this->nestedset->Dropdown();
        $config['method'] = 'create';
        
        $template = 'backend.post.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'  
  
        ));
    }

    public function store(StorePostCatalogueRequest $request){
        if($this->postCatalogueService->create($request)){
      
            return redirect()->route('post.catalogue.index');
        }
        
        return redirect()->route('post.catalogue.index');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.catalogue.update');
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, 
        $this->language);

        $config = $this->configData();
        $template = 'backend.post.catalogue.store';
        $dropdown = $this->nestedset->Dropdown();
        $config['seo'] = config('apps.postcatalogue');
        $config['method'] = 'edit';
        $album = json_decode($postCatalogue->album);
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'postCatalogue',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdatePostCatalogueRequest $request)
    {
        if($this->postCatalogueService->update($id, $request)){
      
            return redirect()->route('post.catalogue.index');
        }
        
        return redirect()->route('post.catalogue.index');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'post.catalogue.destroy');
        $config['seo'] = config('apps.postcatalogue');
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id, 
        $this->language);
        $template = 'backend.post.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'postCatalogue',
            'config'
            
        ));
    }

    public function destroy($id, DeletePostCatalogueRequest $request) 
    {
        if($this->postCatalogueService->destroy($id)){
            return redirect()->route('post.catalogue.index');
        }
        
        return redirect()->route('post.catalogue.index');
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
