<?php

namespace App\Repositories;

use App\Models\CaseServiceItem;

class CaseServiceItemRepository extends BaseRepository
{
    /**
     * Configure the Model
     */
    public function model()
    {
        return CaseServiceItem::class;
    }

    /**
     * Configure the Unique Id Column
     */
    public function uniqueIdCol()
    {
        return 'service_items_id';
    }
}
