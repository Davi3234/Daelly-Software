<?php
require_once 'render.php';

class RenderClient
{
    /**
     * @var array
     */
    private $STATE;

    function __construct($directory)
    {
        $this->STATE = [
            'directory' => str_replace('\\', '/', $directory)
        ];

        $this->loadState();
    }

    private function loadState()
    {
        $this->STATE['rootFolderServer'] = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
        $this->STATE['baseRouterURL'] = URL::getInstance()->getBaseRouter();
        $this->STATE['publicFolder'] = Render::getInstance()->getBasePath();
        $this->STATE['router'] = substr(Render::getInstance()->getPath(), 1);

        $this->STATE['rootFolderProject'] = remove_string($this->STATE['rootFolderServer'], $this->STATE['directory']);
        $this->STATE['pathCurrentFolder'] = remove_string("/" . $this->STATE['baseRouterURL'], $this->STATE['rootFolderProject']);
        $this->STATE['currentFolder'] = remove_string("/" . $this->STATE['publicFolder'], $this->STATE['pathCurrentFolder']);

        $this->STATE['nextFolderPath'] = $this->STATE['router'];

        if ($this->STATE['currentFolder']) {
            $pathCurrentFolderWithoutRootAndStarBar = substr($this->STATE['currentFolder'], 1);

            $this->STATE['nextFolderPath'] = remove_string($pathCurrentFolderWithoutRootAndStarBar, $this->STATE['router']);

            if (substr($this->STATE['nextFolderPath'], 0, 1) == "/") {
                $this->STATE['nextFolderPath'] = substr($this->STATE['nextFolderPath'], 1);
            }
        }

        $this->STATE['nextFolderName'] = explode("/", $this->STATE['nextFolderPath'])[0];

        $this->STATE['nextRouterFolder'] = substr($this->STATE['pathCurrentFolder'], 1) . ($this->STATE['nextFolderName'] ? "/" . $this->STATE['nextFolderName'] : "");
        $this->STATE['ok'] = true;
        $this->STATE['queries'] = [];

        if (Render::getInstance()->isQueryParam(substr($this->STATE['pathCurrentFolder'], 1))) {
            $this->STATE['queries'][Render::getInstance()->getNextNameRouter(substr($this->STATE['pathCurrentFolder'], 1))] = $this->STATE['nextFolderName'];
        }
    }

    function include($target = '')
    {
        if (!$target) {
            return false;
        }

        if (!str_starts_with($target, '/')) {
            $target = '/' . $target;
        }

        return Render::getInstance()->include($this->STATE['pathCurrentFolder'] . $target);
    }

    function getState()
    {
        return $this->STATE;
    }
}
