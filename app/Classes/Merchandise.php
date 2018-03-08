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
    
    public function createMerchandise(array $merchandiseDatas)
    {
        if (isset($merchandiseDatas['degreesOption']) && !empty($merchandiseDatas['degreesOption'])) {
            $merchandiseDatas['extra_info'] = json_encode(array(
                'degrees' => $merchandiseDatas['degreesOption'],
            ));
        }
        
        $merchandiseDatas['introduction'] = json_encode(array(
            'intro_tw' => $merchandiseDatas['intro_tw'],
            'intro_ch' => $merchandiseDatas['intro_ch'],
            'intro_en' => $merchandiseDatas['intro_en'],
        ));
        
        $merchandiseDatas['name'] = json_encode(array(
            'name_tw' => $merchandiseDatas['name_tw'],
            'name_ch' => $merchandiseDatas['name_ch'],
            'name_en' => $merchandiseDatas['name_en'],
        ));
        
        $pathArray = [];
        if (isset($merchandiseDatas['photos'])) {
            $file_name_array = array();

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
        
        foreach($datas as &$data) {
            $data->name = json_decode($data->name, true);
            $data->introduction = json_decode($data->introduction, true);
            $data->extra_info = json_decode($data->extra_info, true);
            $data->photos = json_decode($data->photos, true);
        }

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