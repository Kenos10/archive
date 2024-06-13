<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FileFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'prefix_value',
        'prefix_date',
        'prefix_year_format',
        'prefix_year_only',
        'prefix_month_only',
        'prefix_day_only',
        'suffix',
        'suffix_value',
        'suffix_date',
        'suffix_year_format',
        'suffix_year_only',
        'suffix_month_only',
        'suffix_day_only',
        'auto_number',
        'starter_number',
        'auto_number_format',
        'include_hyphens'
    ];

    public static function getNextFileNo()
    {
        $fileFormat = self::firstOrFail(); // Retrieve the first FileFormat entry or fail if not found

        $prefix = $fileFormat->prefix;
        $suffix = $fileFormat->suffix;
        $includeHyphens = $fileFormat->include_hyphens ? '-' : '';

        $fileNo = '';

        // Add prefix
        if ($prefix === 'string') {
            $fileNo .= $fileFormat->prefix_value ?? '';
        } elseif ($prefix === 'date') {
            $fileNo .= self::formatDateComponent($fileFormat, 'prefix', now());
        }

        // Add auto number
        if ($fileFormat->auto_number) {
            $formattedStarterNumber = str_pad($fileFormat->starter_number, strlen($fileFormat->auto_number_format), '0', STR_PAD_LEFT);
            $fileNo .= $includeHyphens . $formattedStarterNumber;
        } else {
            $fileNo .= $includeHyphens . $fileFormat->starter_number;
        }

        // Add suffix
        if ($suffix === 'string') {
            $fileNo .= $includeHyphens . ($fileFormat->suffix_value ?? '');
        } elseif ($suffix === 'date') {
            $fileNo .= $includeHyphens . self::formatDateComponent($fileFormat, 'suffix', now());
        }

        return $fileNo;
    }

    private static function formatDateComponent($format, $type, $date)
    {
        $parts = [];

        if ($format->{$type . '_year_only'}) {
            $parts[] = $date->format($format->{$type . '_year_format'} === 'short' ? 'y' : 'Y');
        }

        if ($format->{$type . '_month_only'}) {
            $parts[] = $date->format('m');
        }

        if ($format->{$type . '_day_only'}) {
            $parts[] = $date->format('d');
        }

        if (empty($parts)) {
            $parts[] = $date->format('Ymd');
        }

        return implode('', $parts);
    }

    public static function incrementAutoNumber()
    {
        $format = self::firstOrFail(); // Retrieve the first FileFormat entry or fail if not found

        if ($format->auto_number) {
            $format->increment('starter_number');
        }
    }
}
