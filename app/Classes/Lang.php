<?php
namespace App\Classes;


class Lang
{
    protected $langSupport = array(
        'en',
        'tw',
        'cn',
    );

    public function getLang($datas, $forceLang = null)
    {
        $res = null;
        if (is_null($forceLang)) {
            $default_lang = app()->getLocale();
        } else {
            $default_lang = $forceLang;
        }
        

        foreach ($this->langSupport as $lang) {
            if ($lang === $default_lang) {
                $res = $this->translate($datas, $lang);
            }
        }

        if (is_null($res)) {
            $res = $this->translate($datas, 'en');
        }

        return $res;
    }

    private function translate($datas, $lang)
    {
        $nameKey = 'name_' . $lang;
        $introKey = 'intro_' . $lang;

        foreach ($datas as &$data) {
            // TODO重構這邊, 先寫成這樣子
            if ($lang === "tw") {
                if (isset($data->name_tw))
                    $data->name = $data->name_tw;
            } else if($lang === "cn"){
                if (isset($data->name_cn))
                    $data->name = $data->name_cn;                
            } else {
                if (isset($data->name_en))
                    $data->name = $data->name_en;                 
            }

            if (isset($data->introduction))
                $data->introduction = $data->introduction[$introKey];
        }

        return $datas;
    }

}