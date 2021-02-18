<?php
class MenuController {
    const OPTION_ID_VAR = 'optid';                              
    const CONTROLLER_ID_VAR = 'ctrl';                           

    public function __construct($menu) {                        
        $this->menu = $menu;                                    
    }                                                           

    public function wantsToControl($request) {                  
        return $request->get(self::CONTROLLER_ID_VAR) == 'menu'; 
    }                                                           

    public function execute($request,$view) {                   
        $optionId = $request->get(self::OPTION_ID_VAR);         
        $this->menu->markPathToMenuOption($optionId);           
    }                                                           

    public function addToView($view) {                          
        $view->set('menu',$this->menu);                         
    }                                                           
}
