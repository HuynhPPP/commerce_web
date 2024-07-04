<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Classes\Nestedsetbie;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $language;
    public function __construct(
        PostService $postService,
        PostRepository $postRepository
    ){
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1,
        ]);
        $this->language = $this->currentLanguage();
    }

    public function index(Request $request)
    {
        $posts = $this->postService->paginate($request);


        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]
        ];
        $config['seo'] = config('apps.post');
        $template = 'backend.post.post.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'posts',
        ));
    }

    public function create() {    
        
        $config = $this->configData();
        $config['seo'] = config('apps.post');
        $dropdown = $this->nestedset->Dropdown();
        $config['method'] = 'create';
        
        $template = 'backend.post.post.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'  
  
        ));
    }

    public function store(StorePostRequest $request){
        if($this->postService->create($request)){
      
            return redirect()->route('post.index');
        }
        
        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        $post = $this->postCatalogueRepository->getPostCatalogueById($id, 
        $this->language);

        $config = $this->configData();
        $template = 'backend.post.post.store';
        $dropdown = $this->nestedset->Dropdown();
        $config['seo'] = config('apps.post');
        $config['method'] = 'edit';
        $album = json_decode($post->album);
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'post',
            'dropdown',
            'album'
        ));
    }

    public function update($id, UpdatePostRequest $request)
    {
        if($this->postService->update($id, $request)){
      
            return redirect()->route('post.index');
        }
        
        return redirect()->route('post.index');
    }

    public function delete($id)
    {
        $config['seo'] = config('apps.post');
        $post = $this->postCatalogueRepository->getPostCatalogueById($id, 
        $this->language);
        $template = 'backend.post.post.post.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'post',
            'config'
            
        ));
    }

    public function destroy($id, DeletePostRequest $request) 
    {
        if($this->postService->destroy($id)){
            return redirect()->route('post.index');
        }
        
        return redirect()->route('post.index');
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
