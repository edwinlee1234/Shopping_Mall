<?php

namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Classes\Merchandise;
use App\Classes\Lang;
use Purifier;
use App\Interfaces\Error as IError;

class MerchandiseController extends Controller
{
    private $res;
    private $rowPerPage = 8;
    
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
    
    public function merchandiseManageListPage($merchandisesData = null, $linkOption = null)
    {
        $listData =  Merchandise::instance()->getCataloguesListDatasSubGroup();
        
        $datas = array(
            'title' => 'MerchandiseMange',
            'listGroups' => $listData,
            'products' => $merchandisesData,
            'linkOption' => $linkOption,
        );
        
        return view('Page/Admin/MerchandiseMange')->with($datas);
    }
    
    public function merchandiseItemEditPage(Request $request, $id) 
    {
        $merchandisesData =  Merchandise::instance()->getMerchandise($id);
        
        $datas = array(
            'title' => 'Edit',
            'products' => $merchandisesData[0],
        );
        
        return view('Page/Admin/MerchandiseEdit')->with($datas);        
    }
    
    public function merchandiseItemUpdate(Request $request, $id)
    {
        $inputs = $request->all();

        $rules = [
            'name_tw' => 'required|max:80',
            'name_cn' => 'required|max:80',
            'name_en' => 'required|max:80',
            'status' => 'required|in:C,S',
            'brand' => 'required|max:30',
            'price' => 'required|integer|min:0',
            'type' => 'required',
            'remain_count' => 'required|integer|min:0',
            'intro_tw' => 'required|max:1200',
            'intro_cn' => 'required|max:1200',
            'intro_en' => 'required|max:1200',
            'firstPhoto' => 'required|integer|in:1,2,3,4,5',
        ];

        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        //valid for degrees
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

         $photos = array(
             "photos1",
             "photos2",
             "photos3",
             "photos4",
             "photos5",
         );

         $rules = ['photos' => 'file|image|max:10240'];
         foreach ($photos as $photo) {
             if (isset($inputs[$photo])) {
                 $validator = Validator::make(array("photos" => $inputs[$photo]), $rules);
            
                 if ($validator->fails()) {
                     return redirect()->back()->withErrors($validator->errors())->withInput();
                 }
                 $num = substr($photo, -1);
                 $inputs['photos'][$num] = &$inputs[$photo];
             }
         }

        Purifier::clean(Input::get('intro_tw'));
        Purifier::clean(Input::get('intro_cn'));
        Purifier::clean(Input::get('intro_en'));
        
        $merchandiseClass = Merchandise::instance();
        $result = $merchandiseClass->updateMerchandise($inputs, $id);
        
        if ($result === true) {
            $success_message = array(
                'success' => '更新成功',
            );
            return redirect()->back()->with($success_message);
        }        
    }
    
    public function merchandiseCreateProcess(Request $request) 
    {
        $inputs = $request->all();

        $rules = [
            'name_tw' => 'required|max:80',
            'name_cn' => 'required|max:80',
            'name_en' => 'required|max:80',
            'status' => 'required|in:C,S',
            'brand' => 'required|max:30',
            'price' => 'required|integer|min:0',
            'type' => 'required',
            'remain_count' => 'required|integer|min:0',
            'intro_tw' => 'required|max:1200',
            'intro_cn' => 'required|max:1200',
            'intro_en' => 'required|max:1200',
        ];

        $validator = Validator::make($inputs, $rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        //valid for degrees
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
        
        $photos = array(
            "photos1",
            "photos2",
            "photos3",
            "photos4",
            "photos5",
        );

        $rules = ['photos' => 'file|image|max:10240'];
        foreach ($photos as $photo) {
            if (isset($inputs[$photo])) {
                $validator = Validator::make(array("photos" => $inputs[$photo]), $rules);
            
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                } 
                
                $inputs['photos'][] = &$inputs[$photo];
            }
        }

        if (!isset($inputs['photos']) || count($inputs['photos']) <= 0) {
            $error_message = array(
                'photos' => '最少一張照片',
            );

            return redirect()->back()->withErrors($error_message)->withInput();
        }

        Purifier::clean(Input::get('intro_tw'));
        Purifier::clean(Input::get('intro_cn'));
        Purifier::clean(Input::get('intro_en'));
        
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
            $this->res['errorCode'] = IError::DATA_FETCH_ERROR;
            
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
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            
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
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            
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
            $this->res['errorCode'] = IError::DATA_FORMAT_ERROR;
            
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
            $this->res['errorCode'] = IError::DATA_FETCH_ERROR;
            
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
            $this->res['errorCode'] = IError::DATA_FETCH_ERROR;
            
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

    public function getCataloguesListDatasSubGroup()
    {
        $listData =  Merchandise::instance()->getCataloguesListDatasSubGroup();

        if (count($listData) <= 0) {
            $this->res['result'] = false;
            $this->res['errorCode'] = IError::DATA_FETCH_ERROR;

            return $this->res;
        }

        $this->res['result'] = true;
        $this->res['data'] = $listData;

        return $this->res;
    }

    public function merchandiseTypeListPage(Request $request, $id)
    {
        $rowPerPage = $this->rowPerPage;
        $merchandiseClass = Merchandise::instance();
        $lang = new Lang();
        $merchandise = $lang->getLang($merchandiseClass->getMerchandisesByTypeId($id, $rowPerPage));
        $types = $merchandiseClass->getCataloguesTree($id);

        $datas = array(
            'title' => 'MerchandiseList',
            'types' => $types,
            'products' => $merchandise,
        );

        return view('Page/Customer/MerchandiseType')->with($datas);
    }

    public function merchandiseItemPage(Request $request, $id)
    {
        $merchandiseClass = Merchandise::instance();
        $lang = new Lang();
        $merchandise = $lang->getLang($merchandiseClass->getMerchandise($id));
        $types = $merchandiseClass->getCataloguesTree($merchandise[0]->type);

        $datas = array(
            'title' => 'Merchandise',
            'types' => $types,
            'products' => $merchandise,
        );

        return view('Page/Customer/MerchandiseSingle')->with($datas);
    }

    /**
     * 搜尋商品
     * @param Request $request
     * @return $this
     */
    public function search(Request $request) {
        $inputs = $request->all();
        $name = "";
        $orderBy= "remain_count";
        $group = 1;

        if (isset($inputs['name'])) {
            $name = $inputs['name'];
        }

        if (isset($inputs['group'])) {
            $group = $inputs['group'];
        }

        if (isset($inputs['orderBy'])) {
            $orderBy = $inputs['orderBy'];
        }

        // 這個是做分頁用的參數
        $linkOption = array(
            'name' => $name,
            'group' => $group,
            'orderBy' => $orderBy,
        );

        $merchandiseClass = Merchandise::instance();
        $datas = $merchandiseClass->search($name, $orderBy, $group, $this->rowPerPage);
        $lang = new Lang();
        $datas = $lang->getLang($datas, 'tw');

        return $this->merchandiseManageListPage($datas, $linkOption);
    }
}
