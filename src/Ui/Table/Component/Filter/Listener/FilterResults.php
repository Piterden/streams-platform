<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery;
use Anomaly\Streams\Platform\Ui\Table\Event\TableIsQuerying;

/**
 * Class FilterResults
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FilterResults
{

    /**
     * The filter query utility.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery
     */
    protected $query;

    /**
     * Create a new FilterQueryHandler instance.
     *
     * @param FilterQuery $query
     */
    public function __construct(FilterQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Handle the event.
     *
     * @param  TableIsQuerying $event
     * @throws \Exception
     */
    public function handle(TableIsQuerying $event)
    {
        $criteria = $event->getCriteria();
        $builder = $event->getBuilder();

        foreach ($builder->table->filters->active() as $filter) {
            $this->query->filter($builder, $filter, $criteria);
        }
    }
}
