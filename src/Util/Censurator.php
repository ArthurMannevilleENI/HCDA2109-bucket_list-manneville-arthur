<?php

namespace App\Util;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Censurator extends AbstractController
{
    private const BAN_WORDS = ["Arno", "pute", "connasse", "sexe", "partouze", "arabe", "mamadou", "rebeu"];

    public function purify(string $textToCheck)
    {
        $textToCheckExplode = explode(" ", $textToCheck);

        for ($i=0; $i < sizeof($textToCheckExplode); $i++)
        {
            if (in_array($textToCheckExplode[$i], self::BAN_WORDS))
            {
                $wordLength = strlen($textToCheckExplode[$i]);

                $replaceWord = "";
                $count = 0;

                while($count < $wordLength)
                {
                    $replaceWord.= "*";
                    $count++;
                }

                $textToCheckExplode[$i] = $replaceWord;
            }
        }

        return implode(" ", $textToCheckExplode);
    }
}
