<?php
namespace App\Classes;


class Lang
{
    protected $langSupport = array(
        'en',
        'tw',
        'cn',
    );

    public function getLang($datas)
    {
        $res = null;
        $default_lang = app()->getLocale();

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
            if (isset($data->name))
                $data->name = $data->name[$nameKey];

            if (isset($data->introduction))
                $data->introduction = $data->introduction[$introKey];
        }

        return $datas;
    }

}