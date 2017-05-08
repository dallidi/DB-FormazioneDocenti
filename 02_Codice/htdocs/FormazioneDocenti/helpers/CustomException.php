<?php
  // require_once "$__ROOT__/helpers/CustomException.php";
  require_once "$__ROOT__/helpers/Debug.php";
  
  class CustomException extends Exception{
    private $usrMsg;
    
    public function __construct($usrMessage, $message=null, 
                                $code = 0, Exception $previous = null) {
      // make sure everything is assigned properly
      parent::__construct($message, $code, $previous);
      
      $this->usrMsg = $usrMessage;
      if (!isset($message)){
        $this->message = $this->usrMsg;
      }
      dbgTrace("$this, usrMsg=$usrMessage", cDbgExcept);
    }
    
    public function getUserMessage(){
      return $this->usrMsg;
    }
  }
  
?>