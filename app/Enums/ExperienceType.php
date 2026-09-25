<?php

namespace App\Enums;

enum ExperienceType: string
{
    case Work = 'work';
    case Organization = 'organization';
    case Assistant = 'assistant';
    case Freelance = 'freelance';

    public function label(): string
    {
        return match ($this) {
            self::Work => 'Work',
            self::Organization => 'Organization',
            self::Assistant => 'Assistantship',
            self::Freelance => 'Freelance',
        };
    }
}
