<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Ublaboo\DataGrid\DataGrid;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private $from;
    private $to;

    public function __construct()
    {
        $this->from = date('d.m.Y', strtotime('first day of this month'));
        $this->to = date('d.m.Y', strtotime('last day of this month'));
    }


    public function handleSetRange($from, $to): void
    {
        $this->from = $from;
        $this->to = $to;
        $this['grid']->reload();
    }

    public function createComponentGrid(): DataGrid
    {
        $grid = new DataGrid();
        $grid->setDataSource([['id' => 1, 'name' => 'John', 'date' => '2022-10-01'], ['id' => 2, 'name' => 'Joe', 'date' => '2022-09-01']]);
        $grid->addColumnText('name', 'Název');
        $grid->addColumnDateTime('date', 'Datum')->setformat('d.m.Y');
        $grid->addFilterDateRange('date', 'Datum:', 'date')->setFormat('Y-m-d', 'd. m. yyyy');
        $grid->setOuterFilterRendering();
        $grid->setDefaultFilter(['date' => ['from' => $this->from, 'to' => $this->to]]);
        return $grid;
    }

}
