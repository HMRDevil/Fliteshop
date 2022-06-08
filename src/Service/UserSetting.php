<?php

namespace App\Service;

use App\Repository\SettingRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Component\Node\CategoryNodeBuilder;

class UserSetting
{
    private $themeName;
    private $units;
    private $allBrands;
    private $categories;
    private $categoryRepo;
    private $brandRepo;

    public function __construct(
            SettingRepository $repository,
            BrandRepository $brandRepo,
            CategoryRepository $categoryRepo,
            CategoryNodeBuilder $categoryNodeBuilder
    ) {
        $this->themeName = $repository->findOneBy(['name' => 'theme'])->getValue();
        $this->units = $repository->findOneBy(['name' => 'units'])->getValue();
        $this->allBrands = $brandRepo->findAll();
        $this->categories = $categoryNodeBuilder->build($categoryRepo->findBy(['visible' => true]));
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }
    
    public function usedTheme(): string
    {
        return $this->themeName;
    }
    
    public function units()
    {
        return $this->units;
    }
    
    public function brands()
    {
        return $this->allBrands;
    }
    
    public function categories()
    {
        return $this->categories;
    }
    
    public function categoryRepo()
    {
        return $this->categoryRepo;
    }
    
    public function brandRepo()
    {
        return $this->brandRepo;
    }
}