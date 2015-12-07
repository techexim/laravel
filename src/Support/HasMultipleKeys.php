<?php namespace TechExim\Support;

use Illuminate\Database\Eloquent\Builder;

trait HasMultipleKeys
{
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        if (count($this->primaryKey)) {
            foreach ($this->primaryKey as $key) {
                if (isset($this->original[$key])) {
                    $value = $this->original[$key];
                } else {
                    $value = $this->getAttribute($key);
                }
                $query->where($key, $value);
            }
        } else {
            $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        }

        return $query;
    }
}