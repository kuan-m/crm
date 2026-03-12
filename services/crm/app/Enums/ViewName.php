<?php

namespace App\Enums;

enum ViewName: string
{
    case WELCOME = 'welcome';
    case SWAGGER_UI = 'swagger-ui';
    case WIDGET = 'ticket.widget';
    case LOGIN = 'manager.login';
    case DASHBOARD = 'manager.dashboard';
    case MANAGER_TICKETS_LIST = 'manager.tickets.list';
}
