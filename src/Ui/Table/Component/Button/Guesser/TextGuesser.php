<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class TextGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TextGuesser
{

    /**
     * Guess the text for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        if (!$module = app('module.collection')->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // Skip if set already.
            if (!isset($button['text']) && isset($button['slug'])) {
                $button['text'] = $module->getNamespace('button.' . $button['slug']);
            }
        }

        $builder->buttons = $buttons;
    }
}
