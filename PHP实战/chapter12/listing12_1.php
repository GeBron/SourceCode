<?php
class TestOfAddingContacts extends WebTestCase {

    function addContact($name, $email) {                               
        $this->get($this->configuration->getHome());                   
        $this->click('Add contact');                                   
        $this->setField('Name:', $name);                               
        $this->setField('E-mail:', $email);                            
        $this->click('Add');                                           
    }

    function testNewContactShouldBeVisible() {                          
        $this->addContact('Me', 'me@me.com');                           
        $this->assertText('Me');                                        
        $this->assertText('me@me.com');                                 
    }

    function testCanClickOnNameToEditContact() {                        
        $this->addContact('Me', 'me@me.com');                           
        $this->click('Me');                                             
        $this->setField('E-mail:', 'me@elsewhere.com');                 
        $this->click('Add');                                            
        $this->assertText('me@elsewhere.com');                          
        $this->assertNoText('me@me.com');                               
    }

    function testInvalidEmailAddressShowsInvalidMessage() {             
        $this->addContact('Me', 'invalid_email');                       
        $this->assertText('Invalid address');                           
        $this->assertTitle('Add Contact');                              
    }
}
