<?php

enum USER_ACTION_ROUTERS: string {
    case Create = '/create';
    case List = '/';
}

enum USER_METHODS_ROUTERS: string {
    case Create = 'POST';
    case List = 'GET';
}