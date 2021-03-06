<?php

namespace Fjord\Crud\Fields\Relations;

use Closure;
use Fjord\Crud\Fields\Traits\HasBaseField;
use Fjord\Exceptions\InvalidArgumentException;

class MorphToRegistrar extends LaravelRelationField
{
    use HasBaseField;

    /**
     * MorphTypes.
     *
     * @var array
     */
    protected $morphTypes = [];

    /**
     * Required field attributes.
     *
     * @var array
     */
    public $required = [
        'morphTypes'
    ];

    /**
     * Should field be registered in form.
     *
     * @return boolean
     */
    public function register()
    {
        return false;
    }

    /**
     * Add morph types.
     *
     * @param Closure $callback
     * @return self
     */
    public function morphTypes(Closure $closure)
    {
        if (!array_key_exists('title', $this->attributes)) {
            throw new InvalidArgumentException('You may set a title before defining morph types.', [
                'function' => 'types'
            ]);
        }

        $this->setAttribute('morphTypes', []);

        $selectId = (new $this->model)->{$this->id}()->getMorphType();

        $select = $this->formInstance->select($selectId)
            ->title(__f('base.item_select', ['item' => $this->title]))
            ->storable(false);

        $morph = new MorphTypeManager($this->id, $this->formInstance, $selectId);

        $closure($morph);

        $options = [];
        foreach ($morph->getTypes() as $class => $morphType) {
            $options[$class] = $morphType->names['singular'];
        }

        $select->options($options);

        $this->setAttribute('morphTypes', $morph->getTypes());

        //dd($this->formInstance->getRegisteredFields());
    }

    /**
     * Build relation index table.
     *
     * @param Closure $closure
     * @return void
     */
    public function preview(Closure $closure)
    {
        throw new InvalidArgumentException('form is not available for MorphTo relations.');
    }
}
