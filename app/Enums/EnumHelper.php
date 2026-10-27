<?php

namespace App\Enums;

trait EnumHelper
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function label(): string
    {
        return __("{$this->translationKey()}." . strtolower($this->value));
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    // Override this in your enum if needed
    protected function translationKey(): string
    {
        return strtolower(class_basename(static::class)); // return enum class name: enumhelper
    }
}
