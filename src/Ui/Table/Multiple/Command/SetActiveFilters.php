<?php

namespace Anomaly\Streams\Platform\Ui\Table\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetActiveFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveFilters
{

    /**
     * The multiple form builder.
     *
     * @var MultipleTableBuilder
     */
    protected $builder;

    /**
     * Create a new MergeRows instance.
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
        if (!$filters = $this->builder->table->filters->active()) {
            return;
        }

        /* @var Filter $filter */
        foreach ($this->builder->tables as $builder) {
            foreach ($filters as $filter) {
                $this->setActiveFilter($filter->getSlug(), $builder);
            }
        }
    }

    /**
     * Set the active filter.
     *
     * @param              $slug
     * @param TableBuilder $builder
     */
    protected function setActiveFilter($slug, TableBuilder $builder)
    {
        /* @var Filter $filter */
        foreach ($builder->table->filters as $filter) {
            if ($filter->getSlug() === $slug) {
                $filter->setPrefix($builder->table->options->get('prefix'));
                $filter->setActive(true);

                break;
            }
        }
    }
}
