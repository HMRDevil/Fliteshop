<?php

namespace App\Service;

use App\Service\AdminSetting;
use Symfony\Component\Filesystem\Filesystem;

class TemplateService
{
    private $setting;
    private $themeDir;
    private $themeName;
    private $filesystem;

    public function __construct(AdminSetting $settings, Filesystem $filesystem)
    {
        $this->setting = $settings;
        $this->themeName = $settings->usedTheme();
        $this->themeDir = $settings->getThemesDirectory() . '/' . $this->themeName;
        $this->filesystem = $filesystem;
    }
    
    public function getAllTemplates(): array
    {
        $templatesInDyrectory = scandir($this->themeDir);
        $templates = [];
        
        foreach ($templatesInDyrectory as $template)
        {
            if(is_file($this->themeDir . "/$template") && $template != '.' && $template != '..')
            {
                $templates[] = $template;
            }
        }
        
        return $templates;
    }
    
    public function getTheme()
    {
        return $this->themeName;
    }
    
    public function saveTemplate(string $tmplName, string $dataToSave)
    {
        $tmplFilePath = $this->themeDir . "/$tmplName";
        unlink($tmplFilePath);
        file_put_contents($tmplFilePath, $dataToSave);
    }
    
    public function getTmplBody($tmplName)
    {
        $this->filesystem->chmod($this->themeDir . '/' . $tmplName, 644);
        $template = file_get_contents($this->themeDir . '/' . $tmplName);
        
        return $template;
    }
}