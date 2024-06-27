<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;




class LocationController extends Controller
{

    protected $dictrictRepository;
    protected $provinceRepository;
    public function __construct(
        DistrictRepository $dictrictRepository,
        ProvinceRepository $provinceRepository
    ){
        $this->dictrictRepository = $dictrictRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function getLocation(Request $request) {
        $get = $request->input();
        
        $html = '';
        if($get['target'] == 'districts'){
            $province = $this->provinceRepository->findById($get['data']['location_id'], ['code','name'], 
            ['districts']);
            $html = $this->renderHtml($province->districts);
        }else if($get['target'] == 'wards'){
            $district = $this->dictrictRepository->findById($get['data']['location_id'], ['code','name'], 
            ['wards']);
            $html = $this->renderHtml($district->wards, '[Chọn Phường/Xã');
        }
        
        $response = [
            'html' => $html
        ];
        return response()->json($response);
    }

    public function renderHtml($districts, $root = '[Chọn Quận/Huyện]'){
        $html = '<option value="0">'.$root.'</option>';
        foreach ($districts as $ditrict){
            $html .= '<option value="'.$ditrict->code.'">'.$ditrict->name.'</option>';
        }
        return($html);
    }
}