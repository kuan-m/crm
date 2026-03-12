<?php

namespace App\Enums;

enum RouteName: string
{
    case LOGIN = 'manager.login';
    case LOGOUT = 'manager.logout';
    case DASHBOARD = 'manager.dashboard';
    case WIDGET = 'ticket.widget';
    case MANAGER_TICKETS_LIST = 'manager.tickets.list';
}
