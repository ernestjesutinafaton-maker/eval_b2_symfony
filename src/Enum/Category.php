<?php

// Le namespace doit correspondre au dossier src/Enum (règle d'autoload PSR-4 définie dans composer.json).
// Réf. : https://www.php-fig.org/psr/psr-4/
namespace App\Enum;

// "enum" déclare une énumération, ": string" la rend "backed" (chaque cas a une valeur texte).
// Réf. PHP : https://www.php.net/manual/fr/language.enumerations.backed.php
enum Category: string
{
    // Nom du cas = valeur stockée en base, utilisée dans l'URL (?categorie=concert)
    // et dans la classe CSS (cat-concert). Minuscules, sans accent.
    case Concert = 'concert';
    case Conference = 'conference';
    case Atelier = 'atelier';
    case Sport = 'sport';

    // Une enum peut avoir des méthodes : on l'utilise pour le texte affiché (avec accent).
    // Réf. PHP : https://www.php.net/manual/fr/language.enumerations.methods.php
    public function label(): string
    {
        // "match" renvoie la valeur associée au cas courant ($this).
        // Réf. PHP : https://www.php.net/manual/fr/control-structures.match.php
        return match ($this) {
            self::Concert => 'Concert',
            self::Conference => 'Conférence',
            self::Atelier => 'Atelier',
            self::Sport => 'Sport',
        };
    }
}