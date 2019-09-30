<?php

namespace App\Schemas;

class StockUpdateSchema
{
    protected $schema;

    protected function defineSchema()
    {
        return '{
        	"$schema": "http://json-schema.org/draft-07/schema#",
        	"$id": "https://theorder.gg/schema/stock.update.json",
        	"title": "Stock Update",
        	"description": "A Stock Update API Request",
        	"type": "object",
        	"properties": {
        		"stock": {
        			"type": "object",
                    "properties" {
                        "bags": {
                            "type": "array",
                            "items": {
                				"type": "object",
                				"properties": {
                                    "id": {
        								"type": "integer",
        								"minimum": 0,
        								"maximum": 4294967296
        							},
                                    "name": {
        								"type": "string"
        							},
                                    "link": {
        								"type": "string",
        								"pattern": "^\\\\|[\\\\da-f]{6,9}\\\\|Hitem:[\\\\d:]+\\\\|h\\\\[[\\\\w\\\\s]+\\\\]\\\\|h\\\\|r$"
                					},
                					"count": {
                						"type": "integer",
                						"minimum": 1
                					},
                                    "bag": {
                						"type": "integer",
                						"minimum": 0,
                						"maximum": 11
                					},
                					"slot": {
                						"type": "integer",
                						"minimum": 0,
                						"maximum": 28
                					},
                					"banker_name": {
                						"type": "string",
                						"maxLength": 12
                					}
                				}
                			}
                        },
                        "mail": {
                            "type": "array",
                            "items": {
                                "type": "object",
                                "properties": {
                                    "id": {
        								"type": "integer",
        								"minimum": 0,
        								"maximum": 4294967296
        							},
                                    "name": {
        								"type": "string"
        							},
                                    "link": {
        								"type": "string",
        								"pattern": "^\\\\|[\\\\da-f]{6,9}\\\\|Hitem:[\\\\d:]+\\\\|h\\\\[[\\\\w\\\\s]+\\\\]\\\\|h\\\\|r$"
                					},
                					"count": {
                						"type": "integer",
                						"minimum": 1
                					},
                                    "mail": {
                						"type": "integer",
                						"minimum": 0,
                						"maximum": 11
                					},
                					"slot": {
                						"type": "integer",
                						"minimum": 0,
                						"maximum": 28
                					},
                					"banker_name": {
                						"type": "string",
                						"maxLength": 12
                					}
                                }
                            }
                        }
                    },
                    "required": ["bags", "mail"]
        		}
        	},
        	"required": ["stock"]
        }';
    }

    public function get()
    {
        if (empty($this->schema)) {
            $this->schema = $this->defineSchema();
        }

        return $this->schema;
    }

    public function decode()
    {
        $decoded = json_decode($this->get());

        if (json_last_error()) {
            return json_last_error();
        }

        return $decoded;
    }

    public function loadFromStorage($path, Filesystem $filesystem)
    {
        $this->schema = $filesystem->get($path);

        return $this;
    }
}
