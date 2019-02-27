<?php
/**
 * Created by PhpStorm.
 * User: Sollyu
 * Date: 2019/2/27
 * Time: 10:52
 */

namespace Sollyu\IsEnabled;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsEnabledScope implements Scope
{

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithDisabled', 'WithoutDisabled', 'OnlyDisabled'];


    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedIsEnabledColumn(), true);
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithDisabled(Builder $builder)
    {
        $builder->macro('withDisabled', function (Builder $builder, $withDisabled = true) {
            if (!$withDisabled) {
                return $builder->withoutDisabled();
            }
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addWithoutDisabled(Builder $builder)
    {
        $builder->macro('withoutDisabled', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withGlobalScope($this)->where($model->getQualifiedIsEnabledColumn(), true);
            return $builder;
        });
    }

    protected function addOnlyDisabled(Builder $builder)
    {
        $builder->macro('onlyDisabled', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this)->where($model->getQualifiedIsEnabledColumn(), false);
            return $builder;
        });
    }

}