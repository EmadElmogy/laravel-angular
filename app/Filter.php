<?php

namespace App;

class Filter
{
    private function __construct($query, &$filters)
    {
        $this->value = null;
        $this->query = $query;
        $this->filters = &$filters;
    }

    /**
     * @param $query
     * @param $filters
     *
     * @return static
     */
    public static function create($query, array &$filters)
    {
        return new static($query, $filters);
    }

    /**
     * @param $paramName
     *
     * @return $this
     */
    public function fuzzy($paramName)
    {
        if ($this->ready($paramName)) {
            $this->query = $this->query->where(
                $paramName,
                'LIKE',
                "%{$this->value}%"
            );
        }

        return $this;
    }

    /**
     * @param $paramName
     *
     * @return $this
     */
    public function maybeArray($paramName)
    {
        if ($this->ready($paramName)) {
            if (is_array($this->value)) {
                $this->query = $this->query->whereIn($paramName, $this->value);
            } else {
                $this->query = $this->query->where($paramName, $this->value);
            }
        }

        return $this;
    }

    /**
     * @param $paramName
     *
     * @return $this
     */
    public function phoneNumber($paramName)
    {
        if ($this->ready($paramName)) {
            $this->query = $this->query->where(function ($q) use ($paramName) {
                $searchTerm = str_replace('-', '', $this->value);
                $searchTerm = str_replace(' ', '', $searchTerm);
                $searchTerm = str_replace('+', '', $searchTerm);
                $searchTerm = ltrim($searchTerm, 0);

                $trim1st2 = substr($searchTerm, 2);

                $q->where($paramName, 'LIKE', "%$searchTerm%");

                if (strlen($searchTerm) > 4) {
                    $q->orWhere($paramName, 'LIKE', "%$trim1st2%");
                }
            });
        }

        return $this;
    }

    /**
     * @param $paramName
     *
     * @return $this
     */
    public function manyToMany($paramName, $relationshipName, $keyName)
    {
        if ($this->ready($paramName)) {
            $this->query = $this->query->whereHas($relationshipName, function ($q) use ($keyName) {
                if (is_array($this->value)) {
                    $q->whereIn($keyName, $this->value);
                } else {
                    $q->where($keyName, $this->value);
                }
            });
        }

        return $this;
    }

    /**
     * @param $paramName
     *
     * @return $this
     */
    public function maybeDateRange($paramName)
    {
        if ($this->ready($paramName)) {
            if (str_contains($this->value, '-')) {
                $dates = explode(' - ', $this->value);
                $this->query = $this->query->whereBetween($paramName, $dates);
            } else {
                $this->query = $this->query->where($paramName, $this->value);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function end()
    {
        return $this->query;
    }

    /**
     * @param $paramName
     *
     * @return bool
     */
    private function ready($paramName)
    {
        if (! isset($this->filters[$paramName])) {
            return false;
        }

        $this->value = $this->filters[$paramName];

        unset($this->filters[$paramName]);

        return true;
    }
}
