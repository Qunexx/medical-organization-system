<?php
namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class StatusChart extends Chart
{
    protected $title = 'Статусы записей';
    protected $type = 'pie';
    protected $target = 'statusChart';
    protected $height = 300;
    protected $colors = ['#4CAF50', '#F44336', '#2196F3', '#FF9800'];
    protected $export = true;
}
