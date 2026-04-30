<?php

namespace App\Modules\Notifications\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Notifications\Models\LmsNotification;

class NotificationRepository extends BaseRepository
{
    public function __construct(LmsNotification $model)
    {
        parent::__construct($model);
    }
}
