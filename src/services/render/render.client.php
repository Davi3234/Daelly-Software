<?php
require_once 'render.php';

class RenderClient
{
    /**
     * @var array
     */
    private $STATE;

    private function __construct($directory)
    {
        $this->STATE = [
            'directory' => str_replace('\\', '/', $directory)
        ];

        $this->loadState();
    }

    static function createInstance($directory)
    {
        return new RenderClient($directory);
    }

    private function loadState()
    {
        $this->STATE['rootFolderServer'] = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $this->STATE['baseRouterURL'] = URL::getInstance()->getBaseRouter();
        $this->STATE['publicFolder'] = Render::getInstance()->getPublicBasePath();
        $this->STATE['router'] = remove_start_str('/', Render::getInstance()->getRouters());

        $this->STATE['rootFolderProject'] = remove_start_str($this->STATE['rootFolderServer'], $this->STATE['directory']);
        $this->STATE['pathCurrentFolder'] = remove_start_str($this->STATE['baseRouterURL'] ? '/' . $this->STATE['baseRouterURL'] : '', remove_start_str('/' . $this->STATE['publicFolder'], $this->STATE['rootFolderProject']));
        $this->STATE['currentFolder'] = remove_start_str('/' . $this->STATE['publicFolder'], $this->STATE['pathCurrentFolder']);
        $this->STATE['currentFolder'] = remove_start_str('/', $this->STATE['currentFolder']);
        $this->STATE['nextFolderPath'] = $this->STATE['router'];

        if ($this->STATE['currentFolder']) {
            $pathCurrentFolderWithoutRootAndStarBar = remove_start_str('/', $this->STATE['currentFolder']);

            $this->STATE['nextFolderPath'] = remove_start_str($pathCurrentFolderWithoutRootAndStarBar, $this->STATE['router']);
            $this->STATE['nextFolderPath'] = remove_start_str('/', $this->STATE['nextFolderPath']);
        }

        $this->STATE['nextFolderName'] = explode('/', $this->STATE['nextFolderPath'])[0];
        $this->STATE['nextRouterFolder'] = remove_start_str($this->STATE['baseRouterURL'], remove_start_str('/', $this->STATE['rootFolderProject']) . ($this->STATE['nextFolderName'] ? '/' . $this->STATE['nextFolderName'] : ''));
        $this->getQueries();

        if (!is_dir($this->STATE['nextRouterFolder'])) {
            if ($this->hasQueryParamNextRouter(remove_start_str('/', $this->STATE['rootFolderProject']))) {
                $nameQueryParamFolder = Render::getInstance()->getNextNameRouter(remove_start_str('/', $this->STATE['rootFolderProject']));
                $this->STATE['nextFolderName'] = '[' . $nameQueryParamFolder . ']';

                $this->STATE['nextRouterFolder'] = remove_start_str('/', $this->STATE['rootFolderProject']) . ($this->STATE['nextFolderName'] ? '/' . $this->STATE['nextFolderName'] : '');
            }
        }
    }

    function getQueries()
    {
        $this->STATE['queries'] = [];

        if ($this->hasQueryParamNextRouter(remove_start_str('/', $this->STATE['pathCurrentFolder']))) {
            $this->STATE['queries'][Render::getInstance()->getNextNameRouter(remove_start_str('/', $this->STATE['pathCurrentFolder']))] = $this->STATE['nextFolderName'];
        } else {
            $this->STATE['queries'] = Render::getInstance()->getQueryParam();
        }

        return $this->STATE['queries'];
    }

    function hasQueryParamNextRouter($dir)
    {
        return Render::getInstance()->hasQueryParamNextRouter($dir);
    }

    function getQueryParam()
    {
        return $this->STATE['queries'];
    }

    function includeComponent($target) {
        return Render::getInstance()->includeComponent($target);
    }

    function include($target = '')
    {
        $target = remove_start_str('/', $target);

        if (!$target) {
            $target = $this->STATE['nextRouterFolder'];

            if (remove_start_str('/', $this->STATE['rootFolderProject']) == $this->STATE['nextRouterFolder']) {
                return false;
            }
        } else {
            $target = $this->STATE['publicFolder'] . '/' . $target;
        }

        return Render::getInstance()->include($target);
    }

    function isPageNotFound()
    {
        return Render::getInstance()->isPageNotFound();
    }

    function validInclude($target = '')
    {
        $target = remove_start_str('/', $target);

        if (!$target) {
            $target = $this->STATE['nextRouterFolder'];
        } else {
            $target = $this->STATE['publicFolder'] . '/' . $target;
        }

        $target = remove_start_str('/', $target);

        echo $target;

        return Render::getInstance()->validInclude($target);
    }

    function getState()
    {
        return $this->STATE;
    }
}
