<?php

namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ExtensionCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ExtensionCollection extends AddonCollection
{

    /**
     * Undocumented variable
     *
     * @var null|string
     */
    protected $active = null;

    /**
     * Set the active extension.
     *
     * @param string $active
     * @return $this
     */
    public function setActive(string $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active extension.
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Return the active extension.
     *
     * @return Extension|null
     */
    public function active()
    {
        if (!$active = $this->getActive()) {
            return null;
        }

        return app($active);
    }

    /**
     * Search for and return matching extensions.
     *
     * @param  mixed               $pattern
     * @param  bool                $intance
     * @return ExtensionCollection
     */
    public function search($pattern, $instance = true)
    {
        return $this->instances()->map(function (Extension $addon, $namespace) use ($pattern) {
            return str_is($pattern, $addon->getProvides()) ? $addon : null;
        })->filter();
    }

    /**
     * Get an extension by it's reference.
     *
     * Example: extension.users::authenticator.default
     *
     * @param  mixed          $key
     * @return null|Extension
     */
    public function find($key)
    {
        foreach ($this->items as $item) {

            /* @var Extension $item */
            if ($item->getProvides() == $key) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return installed extensions.
     *
     * @return static
     */
    public function installed()
    {
        $installed = [];

        foreach ($this->items as $item) {

            /* @var Extension $item */
            if ($item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return uninstalled extensions.
     *
     * @return static
     */
    public function uninstalled()
    {
        $installed = [];

        foreach ($this->items as $item) {

            /* @var Extension $item */
            if (!$item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return enabled extensions.
     *
     * @return static
     */
    public function enabled()
    {
        $enabled = [];

        foreach ($this->items as $item) {

            /* @var Extension $item */
            if ($item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Determine if a extension is installed or not.
     *
     * @param  $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        if (!isset($this->items[$slug])) {
            return false;
        }

        /* @var Extension $item */
        $item = $this->items[$slug];

        if ($item) {
            return $item->isInstalled();
        }

        return false;
    }

    /**
     * Set the installed and enabled states.
     *
     * @param array $installed
     */
    public function setStates(array $states)
    {
        foreach ($states as $state) {
            if ($extension = $this->get($state->namespace)) {
                $this->setFlags($extension, $state);
            }
        }
    }

    /**
     * Set the extension flags from a state object.
     *
     * @param Extension $extension
     * @param           $state
     */
    protected function setFlags(Extension $extension, $state)
    {
        $extension->setEnabled($state->enabled);
        $extension->setInstalled($state->installed);
    }
}
