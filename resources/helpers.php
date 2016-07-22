<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Validate with teh given data
 *
 * @param  array $data
 * @param  array $rules
 * @param bool $softValidation using "sometimes"
 *
 * @return \Illuminate\Validation\Validator|void
 * @throws \App\Exceptions\ValidationException
 */
function validate(array $data, array $rules, $softValidation = false, $customAttributes = [])
{
    if ($softValidation) {
        array_walk($rules, function (&$value, $key) {
            $value = 'sometimes|'.$value;
        });
    }

    $validator = Validator::make($data, $rules, [], $customAttributes);

    if ($validator->fails()) {
        throw new App\Exceptions\ValidationException(implode(', ', $validator->messages()->all()));
    }

    return $validator;
}

/**
 * @param $options
 * @param $selected
 * @return string
 */
function selectBoxOptionsBuilder($options, $selected)
{
    $isMultiLevel = count(array_filter($options, 'is_array')) > 0;

    $output = '';
    foreach ($options as $key => $value) {
        if ($isMultiLevel) {
            if (! is_array($value)) {
                $output .= "<option value=\"$key\">$value</option>";
                continue;
            }

            $output .= "<optgroup label=\"$key\">";

            foreach ($value as $subKey => $subValue) {
                if (is_array($selected)) {
                    $selectionMarkup = in_array($subKey, $selected) ? 'selected="selected"' : '';
                } else {
                    $selectionMarkup = $selected != '' && $selected == $subKey ? 'selected="selected"' : '';
                }

                $output .= "<option $selectionMarkup value=\"$subKey\">$subValue</option>";
            }

            $output .= "</optgroup>";

        } else {
            if (is_array($selected)) {
                $selectionMarkup = in_array($key, $selected) ? 'selected="selected"' : '';
            } else {
                $selectionMarkup = $selected != '' && $selected == $key ? 'selected="selected"' : '';
            }

            $output .= "<option $selectionMarkup value=\"$key\">$value</option>";
        }

    }

    return $output;
}

function startQueryLog()
{
    DB::enableQueryLog();
}

function getQueryLog()
{
    return DB::getQueryLog();
}

/**
 * @param $parentsCollection
 * @param $relationshipName
 * @param string $parentNameField
 * @param string $childIdField
 * @param string $childNameField
 * @return array
 */
function groupedSelectBoxArrayBuilder($parentsCollection, $relationshipName, $parentNameField = 'name', $childIdField = 'id', $childNameField = 'name')
{
    $output = [];

    foreach ($parentsCollection as $parent) {
        foreach ($parent->{$relationshipName} as $child) {
            $output[$parent->{$parentNameField}][$child->{$childIdField}] = $child->{$childNameField};
        }
    }

    return $output;
}