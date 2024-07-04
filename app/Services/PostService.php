<?php

namespace App\Services;

use App\Services\Interfaces\PostServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


/**
 * Class PostService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $language;
    public function __construct(
        PostRepository $postRepository,
    ){
        $this->language =$this->currentLanguage();
        $this->postRepository = $postRepository;
    }

    public function paginate($request) 
    {
       
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $condition['where'] = [
            ['tb2.language_id', '=', $this->language]
        ];
        $perpage = $request->integer('perpage');
        $posts = $this->postRepository->pagination(
                $this->paginateSelect(), 
                $condition, 
                $perpage, 
                ['path' => 'post/catalogue/index'],
                ['posts.id', 'DESC',],
                [
                    ['post_language as tb2', 'tb2.post_id', '=' , 'posts.id']
                ],
        );
        
        
        return $posts;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            // Chỉ lấy các dữ liệu muốn lấy
            $payload = $request->only($this->payload());
            
            $payload['user_id'] = Auth::id();
            $payload['album'] = json_encode($payload['album']);
            $post = $this->postRepository->create($payload);
            if($post->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_id'] = $post->id; 
                $language = $this->postRepository->createPivot($post, 
                $payloadLanguage, 'languages');
                $catalogue = $this->catalogue($request);
                $post->post_catalogues()->sync($catalogue);
            }
           


            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request) {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findById($id);
            $payload = $request->only($this->payload());
            $payload['album'] = json_encode($payload['album']);
            $flag = $this->postRepository->update($id, $payload);
            if($flag == TRUE){
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $id; 
                $post->languages()->detach([$payloadLanguage['language_id'], $id]);
                $response = $this->postRepository->createLanguagePivot($post, $payloadLanguage);
                $this->nestedset->Get('level ASC, order ASC');
                $this->nestedset->Recursive(0, $this->nestedset->Set());
                $this->nestedset->Action();
            }

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->delete($id);
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

    private function catalogue($request) 
    {
       return array_unique(array_merge(
            $request->input('catalogue'),
            [$request->post_catalogue_id]
        ));
       
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] =  (($post['value'] == 1)?2:1);
            $post = $this->postRepository->update($post['modelId'], $payload);
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
            $flag = $this->postRepository->updateByWhereIn('id', $post['id'], $payload);
            
            // $this->changeUserStatus($post, $post['value']);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
       
    }

       
        private function paginateSelect()
        {
            return [
                'posts.id', 
                'posts.publish',
                'posts.image',
                'posts.level',
                'posts.order',
                'tb2.name', 
                'tb2.canonical',
            ];
        }

        private function payload()
        {
            return [
                'follow', 
                'publish',
                'image',
                'album',
                'post_catalogue_id'
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
