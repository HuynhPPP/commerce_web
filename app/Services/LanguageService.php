<?php

namespace App\Services;

use App\Services\Interfaces\LanguageServiceInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


/**
 * Class LanguageService
 * @package App\Services
 */
class LanguageService implements LanguageServiceInterface
{
    protected $languageRepository;
    public function __construct(
        LanguageRepository $languageRepository,
       
    ){
        $this->languageRepository = $languageRepository;
    }

    public function paginate($request) 
    {
       
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');
        $languages = $this->languageRepository->pagination(
                $this->paginateSelect(), 
                $condition, 
                $perpage, 
                ['path' => 'language/index'],
        );
        
        return $languages;
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token','send']);
            $payload['user_id'] = Auth::id();
            $language = $this->languageRepository->create($payload);
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
           
            $payload = $request->except(['_token','send']);
            $language = $this->languageRepository->update($id, $payload);
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
            $language = $this->languageRepository->forceDelete($id);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] =  (($post['value'] == 1)?2:1);
            $language = $this->languageRepository->update($post['modelId'], $payload);
            // $this->changeUserStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] =  $post['value'];
            $flag = $this->languageRepository->updateByWhereIn('id', $post['id'], $payload);
            
            // $this->changeUserStatus($post, $post['value']);

            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
       
    }

    public function switch($id)
    {
        try{
            $language = $this->languageRepository->update($id, ['current' => 1]);
            $payload = ['current' => 0];
            $where = [
                ['id', '!=', $id],
            ];
            $this->languageRepository->updateByWhere($where, $payload);

        DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    
       

    private function paginateSelect()
    {
        return [
            'id', 
            'name', 
            'canonical',
            'publish',
            'image'
           
        ];
    }
}
