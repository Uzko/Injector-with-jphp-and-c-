<?php
namespace app\modules;

use windows;
use std, gui, framework, app;


class MainModule extends AbstractModule
{

    /**
     * @event Injection.action 
     */
    function doInjectionAction(ScriptEvent $e = null)
    {    
                       $ProcessName = app()->form('MainForm')->label->text;
            $dllfile = app()->form('MainForm')->labelAlt->text;
                $ProcessNameID = app()->form('MainForm')->label->text;
                
        if (fs::isFile("". $path ."Injector.exe")){
            
        }else{
                $injector_start = 'res://.data/Injector/Injector.exe';
        $injector_end = 'C:/GalaxyInjector/Injector.exe';
        
        copy($injector_start, $injector_end);
        }
        
        if ("". $path ."test.dll"){
        $dll_end = 'C:/GalaxyInjector/test.dll';
        copy($dllfile, $dll_end);
        }else{
           return;
        }
        
        $commandorr = ' "C:\GalaxyInjector\Injector.exe" '. $ProcessName .'';

         execute("cmd.exe /c ".$commandorr."");
        
        app()->form('MainForm')->panel->hide();
    }

    /**
     * @event Loading.action 
     */
    function doLoadingAction(ScriptEvent $e = null)
    {    
        $path = "C:/GalaxyInjector/";
        fs::makeDir($path);
        $af = app()->form("MainForm");
        $af->panel->x = 8;
        $af->panel->y = 8;
        $af->panelAlt->hide();
        $af->panelAlt->x = 8;
        $af->panelAlt->y = 8;
        app()->form("MainForm")->panel->hide();
        $af->label7->text = 'In Progress';
    }

    




}
