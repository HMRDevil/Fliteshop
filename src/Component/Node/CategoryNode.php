<?php

namespace App\Component\Node;

use App\Interfaces\NodeInterface;
use App\Interfaces\ArrayableInterface;
use App\Entity\Category;

class CategoryNode implements NodeInterface, ArrayableInterface
{
    private $id;
    private $parentId;
    private $url;
    private $name;
    private $nodes;
    private $categories;
    private $position;
    
    public function __construct(Category $category)
    {
        $this->id = $category->getId();
        $this->parentId = $category->getParentId();
        $this->url = $category->getUrl();
        $this->name = $category->getName();
        $this->position = $category->getPosition();
        $this->nodes = [];
    }

    public function build(array $categories, array $nodes = [])
    {
        $this->categories = $categories;
        
        foreach ($this->categories as $key => $category) {
            if($category->getParentId() == $this->id)
            {
                $newNode = new CategoryNode($category);
                $this->nodes[$category->getPosition()] = $newNode->build($categories, $nodes);
            }
            unset($this->categories[$key]);
        }
            
        return $this;
    }
    
    public function toArray()
    {
        $array = [
            'id' => $this->id,
            'parentId' => $this->parentId,
            'url' => $this->url,
            'name' => $this->name,
            'position' => $this->position,
            'nodes' => []
                ];
        if(count($this->nodes) > 0)
        {
            foreach ($this->nodes as $node) {
                $array['nodes'][$node->getPosition()] = $node->toArray();
            }
        }
        
        return $array;
    }
    
    public function searchById(int $id): ?NodeInterface
    {
        $result = null;
        if ($this->id === $id)
        {
            return $this;
        } else {
            foreach ($this->nodes as $node) {
                $result = $node->searchById($id);
                if (is_object($result))
                {
                    break;
                }
            }
            return $result;
        }
    }
    
    public function getIdsList(): array
    {
        $array[] = $this->id;
        
        foreach ($this->nodes as $node) {
            $result = $node->getIdsList();
            $array = array_merge($array, $result);
        }
        
        return $array;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getParentId(): ?int
    {
        return $this->parentId;
    }
    
    public function getPosition(): ?int
    {
        return $this->position;
    }
    
    public function getNodes(): ?array
    {
        return $this->nodes;
    }
    
    public function getUrl(): ?string
    {
        return $this->url;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
}