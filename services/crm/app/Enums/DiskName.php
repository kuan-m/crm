<?php

namespace App\Enums;

enum DiskName: string
{
    case PUBLIC = 'public';
    case LOCAL = 'local';
    case TICKETS_ATTACHMENTS = 'tickets_attachments';
}
