<?php

namespace App\Services;

use App\Services\Interfaces\GenerateServiceInterface;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Class GenerateService
 * @package App\Services
 */
class GenerateService extends BaseService implements GenerateServiceInterface
{
    protected $generateRepository;
    public function __construct(
        GenerateRepository $generateRepository,
       
    ){
        $this->generateRepository = $generateRepository;
    }

    public function paginate($request) 
    {
       
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');
        $generates = $this->generateRepository->pagination(
                $this->paginateSelect(), 
                $condition, 
                $perpage, 
                ['path' => 'generate/index'],
        );
        
        return $generates;
    }

    private function paginateSelect()
    {
        return [
            'id', 
            'name', 
            'schema',
        ];
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $this->makeDatabase($request);
            // $this->makeController();
            // $this->makeModel();
            // $this->makeRepository();
            // $this->makeService();
            // $this->makeProvider();
            // $this->makeRequest();
            // $this->makeView();
            // $this->makeRoute();
            // $this->makeRule();
            // $this->makeLang();

            $payload = $request->except(['_token','send']);
            $payload['user_id'] = Auth::id();
            $generate = $this->generateRepository->create($payload);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function makeDatabase($request)
    { // Tạo cơ sở dữ liệu, tạo file migration
        $payload = $request->only('schema', 'name');
        $migrationFileName = date('Y_m_d_His').'_create_'.
        $this->converModelNameToTableName($payload['name']).'_table.php';
        $migrationPath = database_path('migrations/'.$migrationFileName);

        $migrationTemplate = <<<MIGRATION
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {$payload['schema']}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$this->converModelNameToTableName($payload['name'])}');
    }
};

MIGRATION;
        FILE::put($migrationPath, $migrationTemplate);
        ARTISAN::call('migrate');
        die();

    }

    private function converModelNameToTableName($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        return $temp.'s';
    }

    public function update($id, $request) {
        DB::beginTransaction();
        try {
           
            $payload = $request->except(['_token','send']);
            $generate = $this->generateRepository->update($id, $payload);
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
            $generate = $this->generateRepository->forceDelete($id);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }
    
}
