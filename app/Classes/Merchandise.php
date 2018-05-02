<?php
namespace App\Classes;
use App\Interfaces\MerchandiseInterface;
use App\Model\Merchandise as MerchandiseModel;
use App\Model\Catalogues as CataloguesModel;
use Image;
class Merchandise implements MerchandiseInterface 
{
    private static $MerchandiseClass;
    
    public static function instance()
    {
        if (self::$MerchandiseClass) {
            return self::$MerchandiseClass;
        }
        
        self::$MerchandiseClass = new self();
        
        return self::$MerchandiseClass;
    }
    
    public function getId() 
    {
        return "getId";
    }
    
    public function getAllContent()
    {
        return "getAllContent";
    }
    
    public function getCataloguesListGroup()
    {
        $data = [];
        $lists = $this->getCataloguesList();
        
        if (count($lists) <= 0) {
            
            return $lists;
        }
        
        foreach ($lists as $list) {
            if ($list->parents == 0) {
                $data[] = array(
                    'id' => $list->id,
                    'type' => $list->type,
                ); 
                
                foreach ($lists as $subList) {
                    if ($subList->parents == $list->id) {
                        $data[] = array(
                            'id' => $subList->id,
                            'type' => $list->type . ":" . $subList->type,
                        );                        
                    }
                }
            }
        }
        
        return $data;
    }
    
    public function getCataloguesList()
    {
        $lists = CataloguesModel::all();
        
        return $lists;
    }
    public function getCataloguesKey($id)
    {
        $key = CataloguesModel::where('id', '=', $id)->take(1)->get();
        return $key[0]['type'];
    }
    public function getCataloguesTree($id)
    {
        $tree[] = CataloguesModel::where('id', '=', $id)->take(1)->get()[0]['parents'];
        $tree[] = $id;
        foreach ($tree as $id) {
            $type[] = array(
                'id' => $id,
                'key' => $this->getCataloguesKey($id),
            );
        }
        return $type;
    }
    
    public function updateMerchandise(array $merchandiseDatas, $id)
    {
        if (isset($merchandiseDatas['degreesOption']) && !empty($merchandiseDatas['degreesOption'])) {
            $merchandiseDatas['extra_info'] = json_encode(array(
                'degrees' => $merchandiseDatas['degreesOption'],
            ));
        }
        
        $merchandiseDatas['introduction'] = json_encode(array(
            'intro_tw' => $merchandiseDatas['intro_tw'],
            'intro_cn' => $merchandiseDatas['intro_cn'],
            'intro_en' => $merchandiseDatas['intro_en'],
        ), JSON_UNESCAPED_UNICODE);


        //檢查使用者更新了那一張照片
        $oldPhotos = json_decode(MerchandiseModel::find($id)['photos']);
        if (isset($merchandiseDatas['photos'])) {
            foreach ($merchandiseDatas['photos'] as $key => $photo) {
                $file_name = $photo->getClientOriginalName();
                $file_relative_path = 'images/merchandise/' . $file_name;
                $file_path = public_path($file_relative_path);
                $image = Image::make($photo)->save($file_path);
                $oldPhotos[($key - 1)] = $file_relative_path;
            }
        }

        //處理優先放第一張的照片
        $temp = $oldPhotos[0];
        $oldPhotos[0] = $oldPhotos[$merchandiseDatas['firstPhoto'] - 1];
        $oldPhotos[$merchandiseDatas['firstPhoto'] - 1] = $temp;

        $merchandiseDatas['photos'] = json_encode($oldPhotos);

        MerchandiseModel::find($id)->update($merchandiseDatas);
        
        return true;        
    }
    
    public function createMerchandise(array $merchandiseDatas)
    {
        if (isset($merchandiseDatas['degreesOption']) && !empty($merchandiseDatas['degreesOption'])) {
            $merchandiseDatas['extra_info'] = json_encode(array(
                'degrees' => $merchandiseDatas['degreesOption'],
            ));
        }
        
        $merchandiseDatas['introduction'] = json_encode(array(
            'intro_tw' => $merchandiseDatas['intro_tw'],
            'intro_cn' => $merchandiseDatas['intro_cn'],
            'intro_en' => $merchandiseDatas['intro_en'],
        ), JSON_UNESCAPED_UNICODE);
        
        $pathArray = [];
        if (isset($merchandiseDatas['photos'])) {
            foreach ($merchandiseDatas['photos'] as $photo) {
                $file_name = $photo->getClientOriginalName();
                $file_relative_path = 'images/merchandise/' . $file_name;
                $file_path = public_path($file_relative_path);
                $image = Image::make($photo)->save($file_path);
                $pathArray[] = $file_relative_path;                
            }
        }
        
        $merchandiseDatas['photos'] = json_encode($pathArray);
        
        MerchandiseModel::create($merchandiseDatas);
        
        return true;
    }
    
    public function addMainType(array $type)
    {
        CataloguesModel::create($type);
        
        return true;
    }
    
    public function addSubType(array $type)
    {
        CataloguesModel::create($type);
        
        return true;
    }    
    
    public function deleteType(int $id)
    {
        $type = CataloguesModel::find($id);
        
        $type->delete();
        
        return true;
    }
    
    public function changeTypeName(array $data)
    {
        $type = CataloguesModel::find($data['id']);
        $type->type = $data['type'];
        $type->save();
        
        return true;
    }
    
    public function getMerchandisesByTypeId($typeId, $rowPerPage)
    {
        $datas = MerchandiseModel::where('type', $typeId)->where('status', 'S')->paginate($rowPerPage);
        $this->merchandiseDecode($datas);
        
        return $datas;
    }
    public function getCataloguesListDatasSubGroup()
    {
        $data = [];
        $lists = $this->getCataloguesList();
        if (count($lists) <= 0) {
            return $lists;
        }
        foreach ($lists as $list) {
            if ($list->parents == 0) {
                foreach ($lists as $subList) {
                    if ($subList->parents == $list->id) {
                        $data[] = array(
                            'id' => $subList->id,
                            'type' => $list->type . ":" . $subList->type,
                        );
                    }
                }
            }
        }
        return $data;
    }
    
    public function getMerchandise($id)
    {
        $datas = MerchandiseModel::where('id', $id)->take(1)->get();
        $this->merchandiseDecode($datas);
        return $datas;
    }
    
    /**
     * json_decode商品資料
     * @param $datas
     * @return mixed
     */
    public function merchandiseDecode(&$datas)
    {
        foreach($datas as &$data) {
            if (isset($data->introduction))
                $data->introduction = json_decode($data->introduction, true);
            if (isset($data->extra_info))
                $data->extra_info = json_decode($data->extra_info, true);
            if (isset($data->photos))
                $data->photos = json_decode($data->photos, true);
        }
        return $datas;
    }
    
    public function checkMerchandiseRemain($id)
    {
        $data = MerchandiseModel::find($id);
        return $data->remain_count;
    }
    
    public function search($name, $orderBy, $listGroup, $rowPerPage) 
    {
        // TODO 這邊先寫這邊, 有時間再換一個比較彈性好擴充的寫法, 多做一個Class也是可以
        if (!empty($name)) {
            // 全英文 or 數字
            if (preg_match("/^[A-Za-z0-9]+$/", $name)) {
                $datas = MerchandiseModel::where('name_en', 'like', '%' . $name . '%')->orderBy($orderBy, 'desc')->paginate($rowPerPage);
            } else {
                $datas = MerchandiseModel::where('name_tw', 'like', '%' . $name . '%')->orderBy($orderBy, 'desc')->paginate($rowPerPage);
            }
        } else if($listGroup == 1) {
            $datas = MerchandiseModel::paginate($rowPerPage);
        } else if ($listGroup !== 1) {
            $datas = MerchandiseModel::where('type', '=', $listGroup)->orderBy($orderBy, 'desc')->paginate($rowPerPage);
        }
        
        $this->merchandiseDecode($datas);
                
        return $datas;
    }
    
    public function editMerchandise(array $merchandiseDatas)
    {
        return "editMerchandise";
    }
    public function deleteMerchandise()
    {
        return "deleteMerchandise";
    }
}