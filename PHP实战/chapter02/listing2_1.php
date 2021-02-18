<?php
class LoggingClass {
    function __call($method,$args) {
        $method = "_$method";
        if (!method_exists($this,$method))
            throw new Exception("Call to undefined method "
                    .get_class($this)."::$method");
        $log  = Log::singleton('file', '/tmp/user.log',
                'Methods', NULL, LOG_INFO);
        $log->log("Just starting method $method");
        $return = call_user_func_array(array($this,$method),$args);
        $log->log("Just finished method $method");
        return $return;
    }
}
