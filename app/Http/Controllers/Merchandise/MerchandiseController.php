<?php

namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Classes\Merchandise;

class MerchandiseController extends Controller
{
    private $res;
    
    public function __construct()
    {
        $this->res = [
            'result' => null,
            'data' => null,
            'errorCode' => null,
        ];
    }
    
    public function merchandiseCreatePage() 
    {
        $datas = array(
            'title' => 'MerchandiseCreate',
        );
        
        return view('Page/Admin/MerchandiseSingle')->with($datas);
    }    
    
    public function merchandiseCreateProcess(Request $request) 
    {
        $inputs = $request->all();

        $rules = [
            'name_tw' => 'required|max:80',
            'name_ch' => 'required|max:80',
            'name_en' => 'required|max:80',
            'status' => 'required|in:C,S',
            'brand' => 'required|max:30',
            'price' => 'required|integer|min:0',
            'type' => 'required',
            'remain_count' => 'required|integer|min:0',
            'intro_tw' => 'required|max:1200',
            'intro_ch' => 'required|max:1200',
            'intro_en' => 'required|max:1200',
        ];

        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        //valid for photos
        $rules = ['photos' => 'file|image|max:10240'];
        foreach ($inputs['photos'] as $photo) {
            $validator = Validator::make(array("photos" => $photo), $rules);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }
        
        
        if (isset($inputs['degreesOption']) && !empty($inputs['degreesOption'])) {
            $degreesOption = explode(',', $inputs['degreesOption']);
            
            foreach ($degreesOption as $value) {
                if (!is_int(intval($value))) {
                    $error_message = array(
                        'degreesOption' => 'The degrees must be an integer.',
                    );
                    
                    return redirect()->back()->withErrors($error_message)->withInput();
                }
            }
            
            $inputs['degreesOption'] = $degreesOption;
        }
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->createMerchandise($inputs);
        
        if ($result === true) {
            $success_message = array(
                'success' => '新增成功',
            );
            return redirect()->back()->with($success_message);
        }
    }
    
    public function merchandiseCataloguesListPage()
    {
        $datas = array(
            'title' => '商品目錄新增',
        );

        return view('Page/Admin/CataloguesList')->with($datas);
    }
    
    public function getCataloguesListDatas()
    {
        $listData =  Merchandise::instance()->getCataloguesList();

        if (count($listData) <= 0) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1001';
            
            return $this->res;
        }
        
        $this->res['result'] = true;
        $this->res['data'] = $listData;
            
        return $this->res;
    }
    
    public function addMainType(Request $request)
    {
        $inputs = $request->all();
        
        $rules = [
            'type' => 'required|min:0'
        ];
        
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1002';
            
            return $this->res;
        }        
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->addMainType($inputs);
        
        if ($result === true) {
            $this->res['result'] = true;
            $this->res['data'] = [
                "groupList" => $merchandiseClass->getCataloguesListGroup(),
                "list" => $merchandiseClass->getCataloguesList(),
            ];
            
            return $this->res;
        }
    }
    
    public function addSubType(Request $request)
    {
        $inputs = $request->all();
        
        $rules = [
            'type' => 'required|min:0',
            'parents' => 'required|min:0',
        ];
        
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1002';
            
            return $this->res;
        }        
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->addSubType($inputs);
        
        if ($result === true) {
            $this->res['result'] = true;
            $this->res['data'] = [
                "groupList" => $merchandiseClass->getCataloguesListGroup(),
                "list" => $merchandiseClass->getCataloguesList(),
            ];
            
            return $this->res;
        }
    }    
    
    public function deleteType(Request $request, $id)
    {
        if (empty($id)) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1002';
            
            return $this->res;
        }    
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->deleteType($id);
        
        if ($result === true) {
            $this->res['result'] = true;
            $this->res['data'] = [
                "groupList" => $merchandiseClass->getCataloguesListGroup(),
                "list" => $merchandiseClass->getCataloguesList(),
            ];
            
            return $this->res;
        }        
    }
    
    public function getCataloguesListDatasGroup() 
    {
        $listData =  Merchandise::instance()->getCataloguesListGroup();

        if (count($listData) <= 0) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1001';
            
            return $this->res;
        }
        
        $this->res['result'] = true;
        $this->res['data'] = $listData;
            
        return $this->res;        
    }
    
    public function changeTypeName(Request $request)
    {
        $inputs = $request->all();
        
        $rules = [
            'id' => 'required',
            'type' => 'required|min:0',
        ];
        
        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            $this->res['result'] = false;
            $this->res['errorCode'] = '1002';
            
            return $this->res;
        }        
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->changeTypeName($inputs);
        
        if ($result === true) {
            $this->res['result'] = true;
            $this->res['data'] = [
                "groupList" => $merchandiseClass->getCataloguesListGroup(),
                "list" => $merchandiseClass->getCataloguesList(),
            ];
            
            return $this->res;
        }        
    }
    
    public function merchandiseTypeListPage(Request $request, $id)
    {
        $rowPerPage = 40;
        $merchandiseClass = Merchandise::instance();
        
        $datas = array(
            'title' => 'MerchandiseList',
            'products' => $merchandiseClass->getMerchandisesByTypeId($id, $rowPerPage),
        );
        
        return view('Page/Customer/MerchandiseType')->with($datas);        
    }
}
