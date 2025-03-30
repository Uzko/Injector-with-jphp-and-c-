<?php
namespace app\forms;

use windows;
use std, gui, framework, app;

class MainForm extends AbstractForm
{
    
    
    /**
     * @event label4.click 
     */
    function doLabel4Click(UXMouseEvent $e = null)
    {    
        app()->shutdown();
    }

    /**
     * @event label5.click 
     */
    function doLabel5Click(UXMouseEvent $e = null)
    {    
        app()->minimizeForm($this->getContextFormName());
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {
            
            $this->panel->show();
            
            $ProcessName = $this->label->text;
            $dllfile = $this->labelAlt->text;
               if ($this->label->text == "" || $this->label->text == "Process name"){
               $this->panel->hide();
                    return;   
               }
               
               if ($this->labelAlt->text == "" || $this->labelAlt->text == "Dll file"){
               $this->panel->hide();
                   return;
               }
               
               $this->Injection->start();
               

            
    }

    /**
     * @event button3.click 
     */
    function doButton3Click(UXMouseEvent $e = null)
    {    
        $dll = $this->fileChooser->execute();
        $this->labelAlt->text = $dll;
        $this->ini->set('DllFile', $dll);
    }

    /**
     * @event button4.action 
     */
    function doButton4Action(UXEvent $e = null)
    {    
        $ProcessName = $this->edit->text;
        $this->label->text = $this->edit->text;
        $this->panelAlt->hide();
        $this->ini->set('ProcessName', $ProcessName);
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        $this->panelAlt->show();
    }

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $ProcessNameText = $this->ini->get('ProcessName');
        $DllfileText = $this->ini->get("DllFile");
        
        $this->panel->x = 8;
        $this->panel->y = 8;
        $this->label->text = $ProcessNameText;
        $this->labelAlt->text = $DllfileText;
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $this->panel->show();
        $this->Loading->start();
    }

    /**
     * @event label9.click 
     */
    function doLabel9Click(UXMouseEvent $e = null)
    {
        $this->panelAlt->hide();
    }




}
