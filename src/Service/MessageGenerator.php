<?php

namespace App\Service;

class MessageGenerator
{
    /**
     * Service retournant une citation aléatoire
     *
     * @return string
     */
    public function randomMessage(): string
    {
        $quotesArray = [
            '" Les avis c’est comme les trous du cul, tout le monde en a un ! "  L’inspecteur Harry'
, // index 0
            '“ Tu vois, le monde se divise en deux catégories. Ceux qui ont un pistolet chargé et ceux qui creusent. Toi tu creuses ! “ Le bon, la brute et le truand ', // index 1
            '“ Je vais te taper tellement fort que quand tu te réveilleras tes fringues ne seront plus à la mode . “ Les Goonies ', // index 2
            '“ La vie c’est comme une boite de chocolat, on ne sait jamais sur quoi on va tomber ” Forrest Gump ', // index 3
            '“ Oye Sapapaya! Ca te dirait un ice cream avec mon ami et moi? ” Scarface ', // index 4
            '“ De grands pouvoirs impliquent de grandes responsabilités ” Spiderman', // index 5
            '“ Barrez vous cons de mimes ! ” La cité de la peur', // index 6
            '“ Je m’appelle Bernie Noel, 29 ans bientôt 32. ” Bernie', // index 7
            '“ Tu sors ou je te sors mais va falloir prendre une décision ! ” Dikkenek', // index 8
            '“ J’ai dégusté son foie avec des fèves au beurre et un excellent Chianti ” Le silence des agneaux', // index 9
            '“ Joyeux Noël Félix ! ” Le Père Noël est une ordure', // index 10
            '“ Jean-Claude Dusse avec un D comme Dusse ” Les bronzés', // index 11
            '" Je vais lui faire une offre qu\'il ne pourra pas refuser. ” Le Parrain', // index 12
            '“ Houston, nous avons un problème ! ” Apollo XIII', // index 13
            '“ Luke, je suis ton père ! ” L\’Empire Contre Attaque', // index 14
            '“ T’es mauvais Jack ! ” OSS 117, Le Caire nid d’espions', // index 15
            '“ Pas de bras, pas de chocolat ! ” Intouchables', // index 16
            '“ C’est une bonne situation ça scribe ? ” Astérix et Obélix : Mission Cléopâtre', // index 17
            '" Hashtag Cestmoiquiaipété ! " Deadpool', // index 18
            '“ Mais on avait rompu ! ” Friends', // index 19
            '“ Un jour à un stage d\’été … “ American Pie',// index 20
            '“ C’est hallu, attends la suite, cinant, Hallucinant ! ” How i met your mother', // index 21
            '“ Sans blagues ! et vous croyez que j’appelle pour commander une pizza ? ” Piege de cristal', // index 22
            '“ Sssssssssssssssplendide ! ” The Mask', // index 23
            '" T\'es comme le « c cédille » de surf... t\'existes pas ! " Brice de Nice', // index 24
            '" Qui a deux pouces et qui s’en tape ? Bob Kelso, enchanté ! " Scrubs', // index 25
            '“ Je suis trop vieux pour ces conneries ” L’arme fatale', // index 26
            '“ Je ne suis pas fou, ma mère m’a fait tester. ” The big bang Theory', // index 27
            '“ Hé oui, mais je suis chez moi, et chez moi, je me balade à poil si je veux ! ” Gazon Maudit', // index 28
            '“ Ouais, c\'est pas faux. ” Kaamelott', // index 29

        ];

        // Retourne un index aléatoire à partir du tableau $quotesArray
        $randomIndex = array_rand($quotesArray);

        return $quotesArray[$randomIndex];
    }

    /**
     * Service retournant une citation aléatoire
     *
     * @return string
     */
    public function randomErrorMessage(): string
    {
        $quotesArray = [
            
            '“ Tu vois, le monde se divise en deux catégories. Ceux qui ont un pistolet chargé et ceux qui creusent. Toi tu creuses ! “ Le bon, la brute et le truand ', // index 0
            '“ La vie c’est comme une boite de chocolat, on ne sait jamais sur quoi on va tomber ” Forrest Gump ', // index 1
            '“ Barrez vous cons de mimes ! ” La cité de la peur', // index 2
            '“ Tu sors ou je te sors mais va falloir prendre une décision ! ” Dikkenek', // index 3
            '“ Houston, nous avons un problème ! ” Apollo XIII', // index 4
            '“ T’es mauvais Jack ! ” OSS 117, Le Caire nid d’espions', // index 5
            '“ Pas de bras, pas de chocolat ! ” Intouchables', // index 6
            '" Hashtag Cestmoiquiaipété ! " Deadpool', // index 7
            '“ Mais on avait rompu ! ” Friends', // index 8
            '“ Sans blagues ! et vous croyez que j’appelle pour commander une pizza ? ” Piege de cristal', // index 9
            '" T\'es comme le « c cédille » de surf... t\'existes pas ! " Brice de Nice', // index 10
            '" Qui a deux pouces et qui s’en tape ? Bob Kelso, enchanté ! " Scrubs', // index 11
            '“ Je suis trop vieux pour ces conneries ” L’arme fatale', // index 12
            '“ Je ne suis pas fou, ma mère m\’a fait tester. ” The big bang Theory', // index 13
            '“ Ouais, c\'est pas faux. ” Kaamelott', // index 14

        ];

        // Retourne un index aléatoire à partir du tableau $quotesArray
        $randomIndex = array_rand($quotesArray);

        return $quotesArray[$randomIndex];
    }
}
