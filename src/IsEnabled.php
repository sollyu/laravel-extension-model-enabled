<?php
/**
 * Created by PhpStorm.
 * User: Sollyu
 * Date: 2019/2/27
 * Time: 10:51
 */

namespace Sollyu\IsEnabled;

use Illuminate\Database\Eloquent\Concerns\HasGlobalScopes;

trait IsEnabled
{
    use HasGlobalScopes;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootIsEnabled()
    {
        static::addGlobalScope(new IsEnabledScope);
    }

    public function disable()
    {
        $this[$this->getIsEnableColumn()] = false;
    }

    public function enable()
    {
        $this[$this->getIsEnableColumn()] = true;
    }

    public function getIsEnableColumn()
    {
        return defined('static::IS_ENABLED') ? static::IS_ENABLED : 'is_enabled';
    }

    public function getQualifiedIsEnabledColumn()
    {
        return $this->qualifyColumn($this->getIsEnableColumn());
    }
}