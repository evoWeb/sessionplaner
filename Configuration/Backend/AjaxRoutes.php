<?php

return [
    // Dispatch the permissions actions
    'evoweb_sessionplaner_edit' => [
        'path' => '/evoweb/sessionplaner/edit',
        'target' => \Evoweb\Sessionplaner\Controller\AjaxController::class . '::dispatch'
    ]
];
