<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;

class PostController extends Controller
{
    use AuthorizesRequests;
    protected $postService;
    protected $postRepository;
    protected $languageRepository;
    protected $language;
    protected $nestedset;
    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->initialize();
    }

    public function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language,
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'post.index');
        $posts = $this->postService->paginate($request, $this->language);

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Post',
        ];
        $config['seo'] = __('messages.Post');
        $template = 'backend.post.post.index';
        $dropdown = $this->nestedset->Dropdown();
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'posts',
            'dropdown',
       
        ));
    }

    public function create() 
    {    
        $this->authorize('modules', 'post.create');
        $config = $this->configData();
        $config['seo'] = __('messages.Post');
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
        if($this->postService->create($request, $this->language)){
      
            return redirect()->route('post.index');
        }
        
        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        $this->authorize('modules', 'post.update');
        $post = $this->postRepository->getPostById($id, 
        $this->language);

        $config = $this->configData();
        $template = 'backend.post.post.store';
        $dropdown = $this->nestedset->Dropdown();
        $config['seo'] = __('messages.Post');
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
        $this->authorize('modules', 'post.destroy');
        $config['seo'] = __('messages.Post');
        $post = $this->postRepository->getPostById($id, 
        $this->language);
        $template = 'backend.post.post.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'post',
            'config'
            
        ));
    }

    public function destroy($id) 
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
