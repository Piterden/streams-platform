<?php

namespace Anomaly\Streams\Platform\Ui\Table\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildTables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTables
{

    /**
     * The multiple form builder.
     *
     * @var MultipleTableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTables instance.
     *
     * @param MultipleTableBuilder $builder
     */
    public function __construct(MultipleTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /* @var TableBuilder $builder */
        foreach ($this->builder->tables as $builder) {
            $builder
                ->setFilters($this->builder->filters)
                ->setButtons($this->builder->buttons)
                ->setColumns($this->builder->columns)
                ->setActions($this->builder->actions)
                ->build();
        }
    }
}
