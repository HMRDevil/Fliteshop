<?php

namespace App\Service;

use App\Service\AdminSetting;

class CssService
{
    private $setting;
    private $themeName;
    private $stylesDir;

    public function __construct(AdminSetting $settings)
    {
        $this->setting = $settings;
        $this->themeName = $settings->usedTheme();
        $this->stylesDir = $settings->getStylesDirectory() . '/' . $this->themeName . '/' . 'css/';
    }
    
    public function getAllStyles(): array
    {
        $stylesInDyrectory = scandir($this->stylesDir);
        $styles = [];
        
        foreach ($stylesInDyrectory as $style)
        {
            if(is_file($this->stylesDir . "$style") && $style != '.' && $style != '..')
            {
                $styles[] = $style;
            }
        }
        
        return $styles;
    }
    
    public function saveCss(string $CssName, string $dataToSave): void
    {
        $styleFilePath = $this->stylesDir . "$CssName";
        unlink($styleFilePath);
        file_put_contents($styleFilePath, $dataToSave);
    }
    
    public function getStyleBody($styleName): string
    {
        $style = file_get_contents($this->stylesDir . $styleName);
        
        return $style;
    }
    
    public function usedTheme(): string
    {
        return $this->themeName;
    }
}