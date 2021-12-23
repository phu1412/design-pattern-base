<?php

namespace App\Repositories\Caches;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Cache\Cache;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Psr\SimpleCache\InvalidArgumentException;

abstract class CacheAbstractDecorator implements RepositoryInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * PageCacheDecorator constructor.
     */
    public function __construct(RepositoryInterface $repository, string $cacheGroup = null)
    {
        $this->repository = $repository;
        $this->cache = new Cache(app('cache'), $cacheGroup ?? \get_class($repository));
    }

    /**
     * @return Cache
     */
    public function getCacheInstance()
    {
        return $this->cache;
    }

    /**
     * @param $function
     *
     * @return mixed
     */
    public function getDataIfExistCache($function, array $args)
    {
        if (!env('enable_cache', false)) {
            return \call_user_func_array([$this->repository, $function], $args);
        }

        try {
            $cacheKey = md5(
                static::class .
                $function .
                serialize(request()->input()) . serialize(url()->current()) .
                serialize(\func_get_args())
            );

            if ($this->cache->has($cacheKey)) {
                return $this->cache->get($cacheKey);
            }

            $cacheData = \call_user_func_array([$this->repository, $function], $args);

            // Store in cache for next request
            $this->cache->put($cacheKey, $cacheData);

            return $cacheData;
        } catch (Exception $ex) {
            info($ex->getMessage());

            return \call_user_func_array([$this->repository, $function], $args);
        } catch (InvalidArgumentException $ex) {
            info($ex->getMessage());

            return \call_user_func_array([$this->repository, $function], $args);
        }
    }

    /**
     * @param $function
     *
     * @return mixed
     */
    public function getDataWithoutCache($function, array $args)
    {
        return \call_user_func_array([$this->repository, $function], $args);
    }

    /**
     * @param $function
     * @param $args
     * @param bool $flushCache
     *
     * @return mixed
     */
    public function flushCacheAndUpdateData($function, $args, $flushCache = true)
    {
        if ($flushCache) {
            try {
                $this->cache->flush();
            } catch (FileNotFoundException $exception) {
                info($exception->getMessage());
            }
        }

        return \call_user_func_array([$this->repository, $function], $args);
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->repository->getModel();
    }

    /**
     * {@inheritdoc}
     */
    public function setModel($model)
    {
        return $this->repository->setModel($model);
    }

    /**
     * {@inheritdoc}
     */
    public function getTable()
    {
        return $this->repository->getTable();
    }

    /**
     * {@inheritdoc}
     */
    public function make(array $with = [])
    {
        return $this->repository->make($with);
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function findOrFail($id, array $with = [], array $select = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstBy(array $condition = [], array $select = [], array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function pluck($column, $key = null)
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function all(array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function allBy(array $condition, array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createOrUpdate($data, $condition = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Model $model)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrCreate(array $data, array $with = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $condition, array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function select(array $select = ['*'], array $condition = [])
    {
        return $this->getDataWithoutCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteBy(array $condition = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $condition = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getByWhereIn($column, array $value = [], array $args = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function advancedGet(array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function forceDelete(array $condition = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function restoreBy(array $condition = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstByWithTrash(array $condition = [], array $select = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function insert(array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrNew(array $condition)
    {
        return $this->getDataIfExistCache(__FUNCTION__, \func_get_args());
    }
}
