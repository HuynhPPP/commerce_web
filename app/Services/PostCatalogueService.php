<?php

namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Classes\Nestedsetbie;
use Illuminate\Support\Str;


/**
 * Class PostCatalogueService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $routerRepository;
    protected $nestedset;
    protected $language;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        RouterRepository $routerRepository,
    ){
        $this->controllerName = 'PostCatalogueController';
        $this->language = $this->currentLanguage();
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language,
        ]);
    }

    public function paginate($request) 
    {
        $perpage = $request->integer('perpage');
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish'),
            'where' => [
                ['tb2.language_id', '=', $this->language]
            ],
        ];
        
        $postCatalogues = $this->postCatalogueRepository->pagination(
                $this->paginateSelect(), 
                $condition, 
                $perpage, 
                ['path' => 'post/catalogue/index'],
                ['post_catalogues.lft', 'ASC',],
                [
                    ['post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=' , 'post_catalogues.id']
                ],
        );
        
        
        return $postCatalogues;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createCatalogue($request);
            if($postCatalogue->id > 0) {
                $this->updateLanguageForCatalogue($postCatalogue, $request);
                $this->createRouter($postCatalogue, $request, $this->controllerName);
                $this->nestedset();
            }
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request) {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $flag = $this->updateCatalogue($postCatalogue, $request);
            if($flag == TRUE){
                $this->updateLanguageForCatalogue($postCatalogue, $request);
                $this->updateRouter($postCatalogue, $request, $this->controllerName);
                $this->nestedset();
            }

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->postCatalogueRepository->delete($id);
            $this->nestedset->Get('level ASC, order ASC');
            $this->nestedset->Recursive(0, $this->nestedset->Set());
            $this->nestedset->Action();

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] =  (($post['value'] == 1)?2:1);
            $postCatalogue = $this->postCatalogueRepository->update($post['modelId'], $payload);
            // $this->changeUserStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] =  $post['value'];
            $flag = $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            
            // $this->changeUserStatus($post, $post['value']);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
       
    }

    public function createCatalogue($request)
    {
        // Chỉ lấy các dữ liệu muốn lấy
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $payload['user_id'] = Auth::id();
        $postCatalogue = $this->postCatalogueRepository->create($payload);
        return $postCatalogue;
    }

    private function updateCatalogue($postCatalogue, $request)
    {
        
        $payload = $request->only($this->payload());
        $payload['album'] = $this->formatAlbum($request);
        $flag = $this->postCatalogueRepository->update($postCatalogue->id, $payload);
        return $flag;
    }

    private function updateLanguageForCatalogue($postCatalogue, $request)
    {
        $payload = $this->formatLanguagePayload($postCatalogue, $request);
        $postCatalogue->languages()->detach([$this->language, $postCatalogue->id]);
        $response = $this->postCatalogueRepository->createPivot($postCatalogue, 
        $payload, 'languages');

        return $response;
    }

    private function formatLanguagePayload($postCatalogue, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $this->currentLanguage();
        $payload['post_catalogue_id'] = $postCatalogue->id; 
        return $payload;
    }

    private function paginateSelect()
    {
        return [
            'post_catalogues.id', 
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.level',
            'post_catalogues.order',
            'tb2.name', 
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'parent_id',
            'follow', 
            'publish',
            'image',
            'album',
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name', 
            'description', 
            'content', 
            'meta_title', 
            'meta_keyword', 
            'meta_description',
            'canonical'
        ];
        
    }
}
