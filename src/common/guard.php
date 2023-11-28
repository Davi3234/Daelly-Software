<?php

interface Guard {
    function perform(Request $request, Response $response);
}