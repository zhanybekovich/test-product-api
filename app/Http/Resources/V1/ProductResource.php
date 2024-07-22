<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $fields;

    public function __construct($resource, $fields = null)
    {
        parent::__construct($resource);
        $this->fields = $fields ? (array)$fields : []; // Use empty array if fields not provided
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $availableFields = [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'sku' => $this->sku,
            'name' => $this->name,
            'prices' => [
                'old' => $this->prices['old'] ?? null,
                'price' => $this->prices['price'] ?? null,
            ],
            'stocks' => $this->stocks->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'count' => $stock->pivot->count,
                    'address' => $stock->address,
                ];
            }),
            'characteristics' => $this->characteristics->map(function ($characteristic) {
                return [
                    'id' => $characteristic->id,
                    'name' => $characteristic->name,
                    'value' => $characteristic->value,
                ];
            }),
            'description' => $this->description,
            'is_published' => (bool)$this->is_published,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];

        // If no fields specified, return all fields
        if (empty($this->fields)) {
            return $availableFields;
        }

        // Filter fields based on the provided fields
        $filteredData = [];
        foreach ($this->fields as $field) {
            if (array_key_exists($field, $availableFields)) {
                $filteredData[$field] = $availableFields[$field];
            }
        }

        return $filteredData;
    }
}
