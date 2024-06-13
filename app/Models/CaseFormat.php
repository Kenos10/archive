<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CaseFormat extends Model
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

    public static function getNextCaseNo()
    {
        $caseFormat = self::firstOrFail(); // Retrieve the first CaseFormat entry or fail if not found

        $prefix = $caseFormat->prefix;
        $suffix = $caseFormat->suffix;
        $includeHyphens = $caseFormat->include_hyphens ? '-' : '';

        $caseNo = '';

        // Add prefix
        if ($prefix === 'string') {
            $caseNo .= $caseFormat->prefix_value ?? '';
        } elseif ($prefix === 'date') {
            $caseNo .= self::formatDateComponent($caseFormat, 'prefix', now());
        }

        // Add auto number
        if ($caseFormat->auto_number) {
            $formattedStarterNumber = str_pad($caseFormat->starter_number, strlen($caseFormat->auto_number_format), '0', STR_PAD_LEFT);
            $caseNo .= $includeHyphens . $formattedStarterNumber;
        } else {
            $caseNo .= $includeHyphens . $caseFormat->starter_number;
        }

        // Add suffix
        if ($suffix === 'string') {
            $caseNo .= $includeHyphens . ($caseFormat->suffix_value ?? '');
        } elseif ($suffix === 'date') {
            $caseNo .= $includeHyphens . self::formatDateComponent($caseFormat, 'suffix', now());
        }

        return $caseNo;
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
        $format = self::firstOrFail(); // Retrieve the first CaseFormat entry or fail if not found

        if ($format->auto_number) {
            $format->increment('starter_number');
        }
    }
}
