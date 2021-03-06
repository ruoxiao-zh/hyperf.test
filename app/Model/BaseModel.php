<?php

declare (strict_types = 1);

namespace App\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Model;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;

class BaseModel extends Model implements CacheableInterface
{
    use Cacheable;

    protected $hidden = ['deleted_at'];

    protected $appends = [
        'created_at_diff_for_humans',
        'updated_at_diff_for_humans',
    ];

    public function getCreatedAtDiffForHumansAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : null;
    }

    public function getUpdatedAtDiffForHumansAttribute()
    {
        return $this->updated_at ? $this->updated_at->diffForHumans() : null;
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort', 'desc');
    }

    /**
     * 缓存时间
     * @return int|null
     */
    public function getCacheTTL(): ?int
    {
        return 3600 * 12;
    }

    public function boot(): void
    {
        Carbon::setLocale('zh');
    }

    public static function getModelName(): string
    {
        return strtolower(get_class(new static()));
    }

//    protected function fireModelEvent(string $event): ?object
//    {
//        parent::fireModelEvent($event);
//
////        if (in_array($event, ['created', 'updated', 'saved', 'deleted'], true)) {
////            $this->
////        }
//    }
}
