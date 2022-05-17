<?php

namespace App\Service;

use App\Repository\SettingRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AdminSetting
{
    private $setting;
    private $repository;
    private $themesDir;
    private $themeName;
    private $stylesDir;

    public function __construct(SettingRepository $repository, ParameterBagInterface $params)
    {
        $this->repository = $repository;
        $this->setting = $repository->findAll();
        $this->themesDir = $params->get('app.themes_dir');
        $this->themeName = current(array_filter(
                $this->setting,
                function($setting)
                {
                    return $setting->getName() === 'theme';
                }))->getValue();
        $this->stylesDir = $params->get('kernel.project_dir') . "/public";
    }
    
    public function getSettings(): array
    {
        $settings = [];
        foreach ($this->setting as $setting)
        {
            $settings = array_merge($settings, [$setting->getName() => $setting->getValue()]);
        }
        
        return $settings;
    }
    
    public function setSettings(array $postParamRequest): void
    {
        foreach ($postParamRequest as $key => $value)
            {
                if('_token'===$key)
                {
                    continue;
                }
                $this->repository->save($key, $value);
            }
    }
    
    public function usedTheme(): string
    {
        return $this->themeName;
    }
    
    public function allThemes(): array
    {
        $themesDir = scandir($this->themesDir);
        $themes = [];
        foreach ($themesDir as $dir)
        {
            if(is_dir($this->themesDir . "/$dir") && $dir != '.' && $dir != '..')
            {
                $themes[] = $dir;
            }
        }
        return $themes;
    }
    
    public function setTheme(string $theme): void
    {
        $this->repository->save('theme', $theme);
    }
    
    public function getThemesDirectory(): string
    {
        return $this->themesDir;
    }
    
    public function getStylesDirectory(): string
    {
        return $this->stylesDir;
    }
}