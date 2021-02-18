<?php
class CalendarView {
    public function addToColumn(Event $event) {                       
        if ($this->addToExistingColumn($event)) return;               
        $this->addToNewColumn($event);                                
    }

    private function addToExistingColumn($event) {                    
        foreach (array_keys($this->columns) as $key) {                
            if ($this->columns[$key]->hasRoomFor($event)) {           
                $this->columns[$key]->add($event);                    
                return TRUE;                                          
            }
        }
        return FALSE;                                                  
    }

    private function addToNewColumn($event) {                         
        $column = new CalendarViewColumn($this->hours);               
        $column->add($event);                                         
        $this->columns[] = $column;                                   
    }
}
