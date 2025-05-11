<?php
namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class TrendChart extends Chart
{
    protected $title = 'Динамика записей';
    protected $type = 'line';
    protected $target = 'trendChart';
    protected $height = 300;
    protected $colors = ['#3F51B5'];
}
