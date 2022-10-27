<?php

namespace App\Util;

use Symfony\Component\String\Slugger\SluggerInterface;

class Censurator
{

    public function purify(string $text):string
    {
        $motsInterdis = ['réseaux', 'null', 'false'];
        $remplacement = ('*');
        $textCensure =  str_ireplace($motsInterdis, $remplacement, $text);
        return $textCensure;

//        //Correction : pour avoir autant d'asterisques qu'il y a de lettres dans le mot censuré.
//        $motsInterdis = ['réseaux', 'null', 'false'];
//
//        foreach ($motsInterdis as $mot){
//            $remplacement = '';
//            for ($i = 0; $i< strlen(($mot; $i++){
//                $remplacement = '*';
//            }
//            $textCensure =  str_ireplace($motsInterdis, $remplacement, $text);
//        }
//        return $textCensure;


    }

}