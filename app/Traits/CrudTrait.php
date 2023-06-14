<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\{Arr, Str, Collection};
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

trait CrudTrait
{
    public $Model;

    // default value
    public $sortColumn = 'created_at';
    public $sortDirection = 'DESC';
    public $perPage = 10;

    public function datatable()
    {
        $model = new $this->Model;

        $this->authorize($model->getTable() . '.index', auth()->user());
        $fieldsColumns = (new $this->Model)->fieldsColumns;
        $data = [];
        foreach ($fieldsColumns as $name => $params) {
            try {
                if (!isset($params['table']))
                    continue;
                $arr = [
                    'name' => $name,
                    'label' => $params['table']['label'] ?? null,
                    'filter_type' => $params['filter']['type'] ?? null,
                ];

                if ($params['filter']['type'] == 'select')
                    $arr['options'] = isset($params['filter']['options']) ? $model->{$params['filter']['options']}() : [];

                $data[] = $arr;
            } catch (\Throwable $th) {
                continue;
            }
        }

        return sendResponse($data, 'test message');
    }

    public function getData($request = null, $paginate = false, $id = null, $applyFielsdColumns = true)
    {
        $filters = $request->except(['with', 'sort']) ?? [];
        if ($request->has('page')) $paginate = true;

        $data = $this->Model::when(!empty($id), function($query) use($id) {
                return $query->where((new $this->Model)->getTable().'.id', $id);
            })
            ->when(count($filters), function ($query) use ($filters) {
                $this->applyFilters($query, $filters);
            })
            ->when($applyFielsdColumns, function ($query) use ($request) {
                $this->returnFieldCol($query, $request);
            })
            ->when(!$applyFielsdColumns, function ($query) {
                return $query->select( (new $this->Model)->getTable() .'.*');
            })
            ->when($request->filled('with'), function ($query) use ($request) {
                $this->applyWithData($query, $request);
            })
            ->when(true, function ($query) use ($request) {
                $this->applySort($query, $request);
            })
        ;
        if ($request->filled('select'))
            $data->select(...explode(',', $request->get('select')));

        if ($paginate)
            return $data->paginate($this->perPage);
        elseif(!empty($id))
            return $data->first();
        elseif ($request->filled('pluck'))
            return $data->pluck(...explode(',', $request->get('pluck')));
        else
            return $data->get();
    }

    public function index(Request $request)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.index', auth()->user());
        $data = $this->getData($request);
        return sendResponse($data, 'test message');
    }

    public function applyWithData($query, $request)
    {
        $model = new $this->Model;
        foreach ($request->get('with') ?? [] as $data) {
            try {
                $separator = "/[:.,]/";
                $query->with($data);
                if ($foreignKey = $model->getTable() . '.' . $model->first()->getRelationValue(preg_split($separator, $data)[0])->getForeignKey())
                    $query->addSelect($foreignKey);
            } catch (\Throwable $th) {
                continue;
            }

        }
        return $query;
    }

    public function applyFilters($query, $filters)
    {
        $model = new $this->Model;
        foreach ($model->fieldsColumns as $fieldColumn => $fieldColumnParams) {
            if (!in_array($fieldColumn, array_keys($filters)))
                continue;
            $filterType = $fieldColumnParams['filter']['type'] ?? null;
            switch ($filterType) {
                case 'like':
                case 'exact':
                case 'bool':
                case 'select':
                    if (isset($filters[$fieldColumn]) && !empty($filters[$fieldColumn])) {
                        $filterColumns = $fieldColumnParams['filter']['columns'];
                        $value = $filters[$fieldColumn];
                        $query->where(function ($sub_query) use ($filterColumns, $filterType, $value, $model) {
                            foreach ($filterColumns as $index => $filterColumn) {
                                if (strpos($filterColumn, '.')) {
                                    $parts = explode('.', $filterColumn);
                                    $filterColumnName = last($parts);
                                    array_pop($parts);
                                    $relations = implode(".", $parts);
                                    $sub_query->orWhereHas(
                                        $relations,
                                        function ($q) use ($filterColumnName, $filterType, $value) {
                                            if ($filterType == 'like')
                                                $q->where($filterColumnName, 'Like', '%' . $value . '%');
                                            if ($filterType == 'exact' || $filterType == 'select')
                                                $q->where($filterColumnName, $value);
                                            if ($filterType == 'bool') {
                                                if ($value == 'true' || $value == 1)
                                                    $q->where($filterColumnName, true);
                                                else
                                                    $q->where($filterColumnName, false);
                                            }
                                        }
                                    );
                                } else {
                                    $filterColumn = $model->getTable() . '.' . $filterColumn;
                                    if ($filterType == 'like')
                                        $sub_query->orWhere($filterColumn, 'Like', '%' . $value . '%');
                                    if ($filterType == 'exact' || $filterType == 'select')
                                        $sub_query->orWhere($filterColumn, $value);
                                    if ($filterType == 'bool') {
                                        if ($value == 'true' || $value == 1)
                                            $sub_query->orWhere($filterColumn, true);
                                        else
                                            $sub_query->orWhere($filterColumn, false);
                                    }
                                }
                            }
                        });
                    }
                    break;
                case 'daterange':
                case 'timerange':
                case 'datetimerange':
                    if (isset($filters[$fieldColumn]['start']) && !empty($filters[$fieldColumn]['start'])) {
                        $filterColumnStart = $fieldColumnParams['filter']['columns']['start'];
                        $valueStart = $filters[$fieldColumn]['start'];
                        if (strpos($filterColumnStart, '.')) {
                            $parts = explode('.', $filterColumnStart);
                            $filterColumnName = last($parts);
                            array_pop($parts);
                            $parts = implode(".", $parts);
                            $query->whereHas($parts, function ($q) use ($filterColumnName, $valueStart, $filterType) {
                                if ($filterType == 'daterange')
                                    $q->whereDate($filterColumnName, '>=', Carbon::parse($valueStart)->toDateString());
                                if ($filterType == 'timerange')
                                    $q->whereTime($filterColumnName, '>=', Carbon::parse($valueStart)->format('H:i:s'));
                                if ($filterType == 'datetimerange')
                                    $q->where(
                                        function ($q) use ($filterColumnName, $valueStart) {
                                            $q->whereDate($filterColumnName, '>=', Carbon::parse($valueStart)->toDateString());
                                            $q->whereTime($filterColumnName, '>=', Carbon::parse($valueStart)->format('H:i:s'));
                                        }
                                    );
                            });
                        } else {
                            $filterColumnStart = $model->getTable() . '.' . $filterColumnStart;
                            if ($filterType == 'daterange')
                                $query->whereDate($filterColumnStart, '>=', Carbon::parse($valueStart)->toDateString());
                            if ($filterType == 'timerange')
                                $query->whereTime($filterColumnStart, '>=', Carbon::parse($valueStart)->format('H:i:s'));
                            if ($filterType == 'datetimerange')
                                $query->where(function ($q) use ($filterColumnStart, $valueStart) {
                                    $q->whereDate($filterColumnStart, '>=', Carbon::parse($valueStart)->toDateString());
                                    $q->whereTime($filterColumnStart, '>=', Carbon::parse($valueStart)->format('H:i:s'));
                                });
                        }
                    }
                    if (isset($filters[$fieldColumn]['end']) && !empty($filters[$fieldColumn]['end'])) {
                        $filterColumnEnd = $fieldColumnParams['filter']['columns']['end'];
                        $valueEnd = $filters[$fieldColumn]['end'];
                        if (strpos($filterColumnEnd, '.')) {
                            $parts = explode('.', $filterColumnEnd);
                            $filterColumnName = last($parts);
                            array_pop($parts);
                            $relations = implode(".", $parts);

                            $query->whereHas($relations, function ($q) use ($filterColumnName, $valueEnd, $filterType) {
                                if ($filterType == 'daterange')
                                    $q->whereDate($filterColumnName, '<=', Carbon::parse($valueEnd)->toDateString());
                                if ($filterType == 'timerange')
                                    $q->whereTime($filterColumnName, '<=', Carbon::parse($valueEnd)->format('H:i:s'));
                                if ($filterType == 'datetimerange')
                                    $q->where(
                                        function ($q) use ($filterColumnName, $valueEnd) {
                                            $q->whereDate($filterColumnName, '<=', Carbon::parse($valueEnd)->toDateString());
                                            $q->whereTime($filterColumnName, '<=', Carbon::parse($valueEnd)->format('H:i:s'));
                                        }
                                    );
                            });
                        } else {
                            $filterColumnEnd = $model->getTable() . '.' . $filterColumnEnd;
                            if ($filterType == 'daterange')
                                $query->whereDate($filterColumnEnd, '<=', Carbon::parse($valueEnd)->toDateString());
                            if ($filterType == 'timerange')
                                $query->whereTime($filterColumnEnd, '<=', Carbon::parse($valueEnd)->format('H:i:s'));
                            if ($filterType == 'datetimerange')
                                $query->where(function ($q) use ($filterColumnEnd, $valueEnd) {
                                    $$q->whereDate($filterColumnEnd, '<=', Carbon::parse($valueEnd)->toDateString());
                                    $$q->whereTime($filterColumnEnd, '<=', Carbon::parse($valueEnd)->format('H:i:s'));
                                });
                        }
                    }
                    break;
                default:
                    $query->where($model->getTable() . '.' . $fieldColumn, $filters[$fieldColumn]);
            }
        }
        return $query;
    }

    public function join($query, $attribute, $fieldsColumn)
    {
        $objectOld = new $this->Model;
        foreach ($loop = explode('.', $attribute) as $value) {
            if (end($loop) != $value) {
                try {
                    $className = class_basename($objectOld->first()->{$value}()->getRelated()->getModel());
                    $foreignKey = $objectOld->first()->{$value}()->getQualifiedForeignKeyName();

                    if (class_exists($ModelNew = 'App\\' . 'Models\\' . $className)) // Not a Last line && Model Exists
                    {
                        $objectNew = new $ModelNew;
                        if (!Collection::make($query->getQuery()->joins)->pluck('table')->contains($objectNew->getTable())) {
                            $query->leftJoin($objectNew->getTable(), $objectNew->getTable() . '.id', '=', $foreignKey);
                            // ->(  ,function($query))

                        }
                        $objectOld = $objectNew;
                    }
                } catch (\Throwable $th) {
                    continue;
                }
            } else
                $attribute = $objectOld->getTable() . '.' . $value; // Last line
        }
        return [$query, $attribute];
    }

    public function returnFieldCol($query)
    {
        $model = new $this->Model;
        $query->when(true, function ($q) use ($model) {
            foreach ($model->fieldsColumns as $fieldsColumn => $colParam) {
                $fieldsCols = [];
                $splitWith = $colParam['table']['split_with'] ?? '-';
                foreach ($colParam['table']['columns'] ?? [$fieldsColumn] as $col) {
                    if (!strpos($col, '.')) {
                        if (Schema::hasColumn($model->getTable(), $col)) {
                            $fieldsCols[] = $model->getTable() . '.' . $col;
                        }
                    } else
                        [$q, $fieldsCols[]] = $this->join($q, $col, $fieldsColumn);
                }
                if (count($fieldsCols) > 1) {
                    $formatFieldsCols = [];
                    foreach ($fieldsCols as $nameCol) {
                        $formatFieldsCols[] = "COALESCE(" . $nameCol . ",'')";
                    }
                    $q->selectRaw("TRIM(CONCAT( " . implode(",'" . $splitWith . "',", $formatFieldsCols) . " )) as " . $fieldsColumn);
                } elseif (count($fieldsCols) == 1) {
                    $q->addSelect($fieldsCols[0] . " as " . $fieldsColumn);
                }
            }
        });
        return $query;
    }

    public function applySort($query, $request)
    {
        $model = new $this->Model;
        if (!$request->has('sort'))
            return $query->orderBy($model->getTable() . '.' . $this->sortColumn, $this->sortDirection);
        $sort = $request->get('sort');
        return $query->orderBy(
            isset($model->fieldsColumns[$sort['column'] ?? null]) ? $sort['column'] : $model->getTable() . '.' . $this->sortColumn,
            $sort['direction'] ?? 'ASC'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.store', auth()->user());
        $item = $this->Model::create($request->all());
        return sendResponse($item, 'A new ' . class_basename($model) . ' has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show( Request $request, $id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.show', auth()->user());
        $item = $this->getData($request, false, $id, false);
        return sendResponse($item, 'show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.update', auth()->user());
        $item = $this->Model::findOrFail($id);
        $item->update($request->all());
        return sendResponse($item, 'update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.destroy', auth()->user());
        $item = $this->Model::findOrFail($id);
        $item->delete();
        return sendResponse([], 'delete');
    }
}
