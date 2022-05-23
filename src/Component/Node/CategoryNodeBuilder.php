<?php

namespace App\Component\Node;

use App\Component\Interfaces\NodeInterface;
use App\Component\Interfaces\ArrayableInterface;
use App\Component\Node\CategoryNode;

class CategoryNodeBuilder implements NodeInterface, ArrayableInterface
{
    private $nodes;
    private $nodesList;
    private $categories;
    
    public function build(array $categories)
    {
        $this->categories = $categories;
        $this->nodesList = $this->categoryParents($categories);
        
        foreach ($this->categories as $category) {
            if($category->getParentId() == 0)
            {
                $node = new CategoryNode($category);
                $this->nodes[$category->getPosition()] = $node->build($this->categories, $this->nodesList);
            }
        }
        
        return $this;
    }
    
    public function toArray()
    {
        if(count($this->nodes) > 0)
        {
            foreach ($this->nodes as $node) {
                $this->nodes[$node->getPosition()] = $node->toArray();
            }
        }
        
        return $this;
    }
    
    private function categoryParents(array $categories)
    {
        foreach ($categories as $category) {
            $this->nodesList[$category->getId()] = $category->getParentId();
        }
        
        return $this->nodesList;
    }
    
    public function list(): array
    {
        $start = true;
        $node = current($this->nodes);
        if ($node instanceof CategoryNode) {
            $this->toArray();
        } else {
            $start = false;
        }
        $array = $this->nodes;
        while ($start) {
            foreach ($this->nodes as $key => $value) {
                if(!empty($value['nodes'])) {
                    foreach ($value['nodes'] as $childNode) {
                        $this->nodes[$childNode['position']] = $childNode;
                    }
                }
                $this->nodes[$key]['nodes'] = [];
            }
            if (count($this->nodes) === count($this->nodesList)) {
                $start = false;
            }
        }
        ksort($this->nodes);
        
        return $this->nodes;
    }
    
    public function getSubCategories(int $id): ?array
    {
        $result = null;
        
        foreach ($this->nodes as $node) {
            $result = $node->searchById($id);
            if (is_object($result))
            {
                break;
            }
            $result = null;
        }
        
        if (is_object($result)) {
            $array = $result->getIdsList();
        }
        
        return $array;
    }
}